function fetchData() {
    $.ajax({
        url: '../client/get1.php',
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
            console.error('Error retrieving UID:', error.responseText);
        }
    });
}

fetchData();
setInterval(fetchData, 2000);

$(document).on('click', '.btn-update', function(e) {
    e.preventDefault();

    var formData = {
        uid: $('input[name=uid]').val(),
        firstname: $('input[name=firstname]').val(),
        middlename: $('input[name=middlename]').val(),
        lastname: $('input[name=lastname]').val(),
        subjectcode: $('input[name=subjectcode]').val(),
        subjectdescription: $('input[name=subjectdescription]').val(),
        // schedulefrom: $('input[name=schedulefrom]').val(),
        // scheduleto: $('input[name=scheduleto]').val(),
        // password: $('input[name=password]').val(),
    };

    $.ajax({
        url: '../client/register-student.php',
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                // Show success alert
                Swal.fire({
                    icon: 'success',
                    title: 'Successsss!',
                    text: response.message,
                }).then((result) => {
                    window.location.href = 'registerstudent.php';
                });
            } else {
                // Show error alert
                Swal.fire({
                    icon: 'error',
                    title: 'Erroreeee!',
                    text: response.message,
                });
            }
        },
        error: function(error) {
            console.error('Error updating data:', error.responseText);
        }
    });
});
