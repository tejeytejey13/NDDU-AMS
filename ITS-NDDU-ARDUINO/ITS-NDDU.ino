#include <SPI.h>
#include <MFRC522.h>
#include <ESP8266WiFi.h>
#include <ArduinoJson.h>

#define SS_PIN D4   // Define the SS_PIN for RFID-RC522
#define RST_PIN D3  // Define the RST_PIN for RFID-RC522

MFRC522 mfrc522(SS_PIN, RST_PIN);

const char *ssid = "Walay Internet";
const char *password = "newP@ssw0rd2024";
const char *server = "192.168.0.34";
const char *path = "/client-files/nddu-its/server/register-uid.php";

int buzzer = D8;


void setup() {
  pinMode(buzzer, OUTPUT);
  Serial.begin(115200);
  SPI.begin();
  mfrc522.PCD_Init();
  connectToWiFi();
}


void loop() {
  if (mfrc522.PICC_IsNewCardPresent() && mfrc522.PICC_ReadCardSerial()) {
    String uid = getUID();
    playRFIDSound();
    sendUIDviaAjax(uid);
    delay(5000);
  }
}

void connectToWiFi() {
  Serial.println("Connecting to WiFi");
  WiFi.begin(ssid, password);

  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting to WiFi...");
  }

  Serial.println("Connected to WiFi");
}

String getUID() {
  String uid = "";
  for (byte i = 0; i < mfrc522.uid.size; i++) {
    uid += (mfrc522.uid.uidByte[i] < 0x10 ? "0" : "");
    uid += String(mfrc522.uid.uidByte[i], HEX);
  }
  uid.toUpperCase();
  return uid;
}

void sendUIDviaAjax(String uid) {
  Serial.print("Sending UID via AJAX: ");
  Serial.println(uid);

  // Create a JSON object
  DynamicJsonDocument jsonDoc(256);
  jsonDoc["uid"] = uid;

  // Serialize the JSON object to a string
  String jsonData;
  serializeJson(jsonDoc, jsonData);

  // Make the POST request
  WiFiClient client;
  if (client.connect(server, 80)) {
    client.print("POST " + String(path) + " HTTP/1.1\r\n");
    client.print("Host: " + String(server) + "\r\n");
    client.print("Content-Type: application/json\r\n");
    client.print("Content-Length: " + String(jsonData.length()) + "\r\n");
    client.print("Connection: close\r\n\r\n");
    client.print(jsonData);

    Serial.println("POST request sent");
  } else {
    Serial.println("Connection failed");
  }

  delay(1000);  // Adjust delay as needed
  while (client.available()) {
    Serial.write(client.read());
  }
  client.stop();
}


void playRFIDSound() {
  static int currentTap = 1;  // Declare as static to persist between function calls

  int rfidSoundFrequencies1[] = { 1500, 1800, 2000, 1500 };
  int rfidSoundDurations1[] = { 200, 200, 200, 200 };
  int rfidSoundFrequencies2[] = {3000};
  int rfidSoundDurations2[] = { 200, 200, 200, 200 };

  int numTones = 4;

  int *frequencies;
  int *durations;

  if (currentTap == 1) {
    frequencies = rfidSoundFrequencies1;
    durations = rfidSoundDurations1;
  } else {
    frequencies = rfidSoundFrequencies2;
    durations = rfidSoundDurations2;
  }

  for (int i = 0; i < numTones; i++) {
    tone(buzzer, frequencies[i], durations[i]);
    delay(durations[i]);  // Pause between tones
  }

  noTone(buzzer);
  currentTap = 3 - currentTap;
}
