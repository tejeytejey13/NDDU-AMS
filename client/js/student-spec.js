function openModal(date, status, rfidUIDid, id) {
    document.getElementById('modal-date').innerText = date;
    document.getElementById('modal-status').innerText = status;
    document.getElementById('modal-studentID').innerText = rfidUIDid;
    document.getElementById('modal-id').innerText = id;

    document.getElementById('modal').style.display = 'block';
    document.getElementById('overlay').style.display = 'flex';

}

// Function to close the modal
function closeModal() {
    document.getElementById('modal').style.display = 'none';
    document.getElementById('overlay').style.display = 'none';

}

function updateStudentsTable() {
    var rfidUID = $('#hiddenRfid').val();

    $.ajax({
        url: `../client/get-students2.php?id=${rfidUID}`,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            var tableBody = $('#studentsTable tbody');
            tableBody.empty();

            if (response.length > 0) {
                $.each(response, function (index, student) {
                    var badgeColor = getBadgeColor(student.status);

                    var row = `<tr>
                        <td style="font-size: 20px;">${student.subject}</td>
                        <td style="font-size: 20px;">${student.date}</td>
                        <td style="font-size: 20px;">${student.timeIn}</td>
                        <td class="font-weight-medium">
                            <div  class="badge ${badgeColor}" style="font-size: 20px;" >${student.status}</div>
                        </td>
                      
                        <td> 
                            <button type="button" class="btn btn-success" onclick="openModal('${student.date}', '${student.status}', '${student.rfidUID}', '${student.id}')">
                            <i class="ti-pencil-alt"></i>
                            </button>
                        </td>
                    
             
                        </tr>`;

                    tableBody.append(row);


                });
            } else {
                var emptyRow = '<tr><td colspan="6">No students found.</td></tr>';
                tableBody.append(emptyRow);
            }
        },
        error: function (error) {
            console.error('Error retrieving student data:', error.responseText);
        }
    });
}


function getBadgeColor(status) {
    switch (status.toLowerCase()) {
        case 'present':
            return 'badge-success'; // Green badge for "Present"
        case 'late':
            return 'badge-warning'; // Yellow badge for "Late"
        case 'absent':
            return 'badge-danger'; // Red badge for "Absent"
        default:
            return 'badge-secondary'; // Default gray badge for unknown status
    }
}
function getStudentName() {
    var rfidUID = $('#hiddenRfid').val();

    $.ajax({
        url: `../client/get-students3.php?id=${rfidUID}`,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.length > 0) {
                var student = response[0];

                $('#name').text(student.name);
                $('#present').text(student.presentCount);
                $('#late').text(student.lateCount);
                $('#absent').text(student.absentCount);

                var badgeColor = getBadgeColor(student.status);

                $('#present').removeClass().addClass(`badge badge-success ${badgeColor}`);
                $('#late').removeClass().addClass(`badge badge-warning ${badgeColor}`);
                $('#absent').removeClass().addClass(`badge badge-danger ${badgeColor}`);
            } else {
                // Handle the case where no students are found
                $('#name').text('No students found.');
                // You may want to clear/reset other elements as well
            }
        },
        error: function (error) {
            console.error('Error retrieving student data:', error.responseText);
        }
    });
}

updateStudentsTable();
setInterval(updateStudentsTable, 2000);
getStudentName();
setInterval(getStudentName, 2000);


function viewStudent(rfidUID) {
    window.location.href = 'viewstudent.php?id=' + rfidUID;
}