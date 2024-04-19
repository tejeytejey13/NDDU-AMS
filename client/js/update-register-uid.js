$(document).on('click', '.btn-update', function(e) {
    e.preventDefault();

    var formData = {
        uid: $('input[name=uid]').val(),
        firstname: $('input[name=firstname]').val(),
        middlename: $('input[name=middlename]').val(),
        lastname: $('input[name=lastname]').val(),
        subjectcode: $('input[name=subjectcode]').val(),
        subjectdescription: $('input[name=subjectdescription]').val(),
        schedulefrom: $('input[name=schedulefrom]').val(),
        scheduleto: $('input[name=scheduleto]').val(),
        password: $('input[name=password]').val(),
    };

    $.ajax({
        url: 'client/register-user.php',
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                // Show success alert
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message,
                }).then((result) => {
                    // Redirect to login page or perform any other action
                    window.location.href = 'index.php';
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
