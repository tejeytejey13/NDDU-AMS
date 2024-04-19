function fetchData() {
    $.ajax({
        url: 'client/get-rfid-login.php',
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

$(document).on('click', '.btn-update', function(e) {
    e.preventDefault();

    var formData = {
        uid: $('input[name=uid]').val(),
        password: $('input[name=password]').val(),
    };

    // Send Ajax request to update the server data
    $.ajax({
        url: 'client/login-user.php',
        type: 'POST',
        data: formData,
        dataType: 'json',
        xhrFields: {
            withCredentials: true
        },
        success: function(response) {
            if (response.success) {
                // Show success alert
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message,
                }).then((result) => {
                  
                    window.location.href = 'main/index1.php';
                });
            } else {
                // Show error alert
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: response.message,
                });
            }
        },
        error: function(error) {
            console.error('Error updating data:', error.responseText);
        }
    });
});
