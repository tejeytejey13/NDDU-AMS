function fetchData() {
    $.ajax({
        url: 'client/get-rfid.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.length > 0) {
                $('#exampleInputUsername1').val(response[0]);
            } else {
                $('#exampleInputUsername1').val("Please Scan the RFID Card First.");
            }
        },
        error: function(error) {
            console.error('Error retrieving professorID:', error.responseText);
        }
    });
}

fetchData();

setInterval(fetchData, 2000);

