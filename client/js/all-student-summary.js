function updateStudentsTable() {
    var selectedOption = $('#studentType').val();
    var selectedOptionDate = $('#filterDate').val();



    var baseUrl = '../client/';

    var url;
    if (selectedOption === 'Enrolled Students') {
        url = baseUrl + 'get-students1.php';

    } else if (selectedOption == 'Drop Out Students') {
        url = baseUrl + 'get-drop-students.php';


    }

    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            var tableBody = $('#studentsTable tbody');
            tableBody.empty();

            if (response.length > 0) {
                $.each(response, function (index, student) {
                    // Check if the student's date matches the selected date
                    if (selectedOptionDate === student.date) {
                        // Construct the row for the student
                        var row = `<tr>
                            <td style="font-size: 20px; display: none;">${student.rfidUID}</td>
                            <td style="font-size: 20px;" class="font-weight-bold">${student.name}</td>
                            <td style="font-size: 20px;">${student.subject}</td>
                            <td style="font-size: 20px;">${student.course}</td>
                            <td style="font-size: 20px;">${student.year}</td>


                            <td>
                                <div class="badge badge-success" style="padding: 5px 30px 5px 30px; font-weight: 900">${student.presentCount || 0}</div>
                                <div class="badge badge-warning" style="padding: 5px 30px 5px 30px; font-weight: 900">${student.lateCount || 0}</div>
                                <div class="badge badge-danger" style="padding: 5px 30px 5px 30px; font-weight: 900">${student.absentCount || 0}</div>
                            </td>
                            <td>
                            <div class="btn btn-info" onclick="viewStudent('${student.rfidUID}')"><i class="ti-eye"></i></div>
                            <div class="btn btn-success" onclick="updateStudent('${student.rfidUID}')"><i class="ti-pencil-alt"></i></div>
    
                            </td>                        </tr>`;
                        tableBody.append(row);
                    } else if (selectedOptionDate === 'all') {
                        var row = `<tr>
                        <td style="font-size: 20px; display: none;">${student.rfidUID}</td>
                        <td style="font-size: 20px;" class="font-weight-bold">${student.name}</td>
                        <td style="font-size: 20px;">${student.subject}</td>
                        <td style="font-size: 20px;">${student.course}</td>
                        <td style="font-size: 20px;">${student.year}</td>
                        <td>
                            <div class="badge badge-success" style="padding: 5px 30px 5px 30px; font-weight: 900">${student.presentCount || 0}</div>
                            <div class="badge badge-warning" style="padding: 5px 30px 5px 30px; font-weight: 900">${student.lateCount || 0}</div>
                            <div class="badge badge-danger" style="padding: 5px 30px 5px 30px; font-weight: 900">${student.absentCount || 0}</div>
                        </td>
                        <td>
                        <div class="btn btn-info" onclick="viewStudent('${student.rfidUID}')"><i class="ti-eye"></i></div>
                        <div class="btn btn-success" onclick="updateStudent('${student.rfidUID}')"><i class="ti-pencil-alt"></i></div>

                        </td>
                    </tr>`;
                        tableBody.append(row);
                    }
                });

            } else {
                var emptyRow = '<tr><td colspan="5">No students found.</td></tr>';
                tableBody.append(emptyRow);
            }
        },
        error: function (error) {
            console.error('Error retrieving student data:', error.responseText);
        }
    });


}


updateStudentsTable();
setInterval(updateStudentsTable, 2000);


function viewStudent(rfidUID) {
    window.location.href = 'viewstudent.php?id=' + rfidUID;
}

function updateStudent(rfidUID){
    window.location.href = 'updatestudent.php?id=' + rfidUID;
}