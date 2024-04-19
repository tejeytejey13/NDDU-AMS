function updateStudentsTable() {
    $.ajax({
        url: '../client/get-students.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            var tableBody = $('#studentsTable tbody');
            tableBody.empty();

            if (response.length > 0) {
                $.each(response, function(index, student) {
                    var badgeColor = getBadgeColor(student.status);

                    var row = `<tr>
                            <td style="display: none;">${student.rfidUID}</td>
                            <td style="font-size: 20px;" class="font-weight-bold">${student.name}</td>
                            <td style="font-size: 20px;">${student.subject}</td>
                            <td class="font-weight-medium">
                                <div class="badge ${badgeColor}" style="font-size: 20px;">${student.status}</div>
                            </td>
                            <td style="font-size: 20px;">${student.timeIn}</td>
                        </tr>`;
                    tableBody.append(row);
                });
            } else {
                var emptyRow = '<tr><td colspan="5">No students found.</td></tr>';
                tableBody.append(emptyRow);
            }
        },
        error: function(error) {
            console.error('Error retrieving student data:', error.responseText);
        }
    });
}

function getBadgeColor(status) {
    switch (status.toLowerCase()) {
        case 'present':
            return 'badge-success';
        case 'late':
            return 'badge-warning';
        case 'absent':
            return 'badge-danger';
        default:
            return 'badge-secondary';
    }
}

updateStudentsTable();
setInterval(updateStudentsTable, 2000);
