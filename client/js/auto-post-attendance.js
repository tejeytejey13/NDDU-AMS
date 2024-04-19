function fetchData() {
    $.ajax({
        url: '../client/get.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.length > 0) {
                $('#exampleInputUsername1').val(response[0]);

                // If uid is not empty, automatically trigger the update
                if (response[0] !== "Please Scan the RFID Card First.") {
                    autoPostAttendance();
                }
            } else {
                $('#exampleInputUsername1').val("Please Scan the RFID Card First.");
            }
        },
        error: function(error) {
            console.error('Error retrieving UID:', error.responseText);
        }
    });
}


(function () {

    function autoPostAttendance() {
        var formData = {
            uid: $('input[name=uid]').val(),
            subjectcode: $('input[name=subjectcode]').val(),
            from: $('input[name=from]').val(),
            to: $('input[name=to]').val(),
        };

        $.ajax({
            url: '../client/post-attendance.php',
            type: 'POST',
            data: formData,
            dataType: 'json',

            success: function (response) {
                if (response.success) {
                    var iconType = 'success';

                 
                    Swal.fire({
                        icon: iconType,
                        title: 'Success!',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 4000,
                    });
                } else if(response.message === 'User status is dropped.'){
                    Swal.fire({
                        icon: 'warning',
                        title: 'DROPPED!',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 4000,
                    });
                } else {
                    // Show error alert
                    Swal.fire({
                        icon: 'info',
                        title: 'RECORDED!',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 4000,
                    });
                }

                
            },

            error: function (error) {
                console.error('Error updating data:', error.responseText);
            }
        });
    }

    // Expose the function globally
    window.autoPostAttendance = autoPostAttendance;
})();

// Fetch data on page load
fetchData();

// Set interval to fetch data every 2000 milliseconds
setInterval(fetchData, 2000);
