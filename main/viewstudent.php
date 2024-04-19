<?php
include '../server/config.php';


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>NDDU ITS</title>
    <link rel="stylesheet" href="../vendors/feather/feather.css">
    <link rel="stylesheet" href="../vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="../vendors/datatables.net-bs4/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="../vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" type="text/css" href="../js/select.dataTables.min.css">
    <link rel="stylesheet" href="../css/vertical-layout-light/style.css">
    <link rel="shortcut icon" href="../images/nddu/nddulogo.png" />
    <link rel="stylesheet" href="../css/modal.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</head>

<style>
.overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.3);
    align-items: center;
    justify-content: center;
    margin: 0 auto;

}

.modal {
    background-color: #fff;
    padding: 50px 20px 20px 20px;
    border-radius: 5px;
    max-width: 35vw;
    max-height: 25vh;
    min-width: 30vw;
    min-height: 20vh;
    overflow-y: auto;
    border-radius: 10px;
    text-align: center;
    margin: 10% 40% 0 40%;

}

.close {
    position: absolute;
    top: 10px;
    right: 10px;
    cursor: pointer;
}

.value {
    display: flex;
    justify-content: center;
    gap: 30px;
    margin-top: 16px;

}



option {
    padding: 12px;
    display: block;
    text-decoration: none;
    color: #333;
    transition: background-color 0.3s;
    font-size: 30px;
    font-family: --font-family-monospace;
}

option:hover {
    background-color: #3498db;
    color: #fff;
}


select {
    border-radius: 10px;
    padding: 10px;
    width: 20vw;
}

.btn {
    max-width: 30vw;
}
</style>

<body>
    <div class="container-scroller">
        <?php require_once 'nav.php' ?>
        <div class="container-fluid page-body-wrapper">
            <?php require_once 'sidebar.php'; ?>
            <div class="main-panel">
                <div class="content-wrapper">

                    <div class="row">
                        <?php
                        if (isset($_GET['id'])) {
                            $rfidUID = $_GET['id'];

                            $select = "SELECT * FROM users WHERE rfidUID = '$uid'";
                            $query = $conn->query($select);
                            while ($data = $query->fetch_assoc()) {
                                $name = $data['firstname'] . ' ' . $data['middlename'] . ' ' . $data['lastname'];
                                $subjectcode = $data['subjectCode'];
                                $subjectdes = $data['subjectDescription'];
                            }
                        }


                        ?>

                        <input type="hidden" value="<?= $rfidUID ?>" name="rfid" id="hiddenRfid">

                        <div class="col-md-12 grid-margin transparent">
                            <div class="row">
                                <div class="col mb-4 stretch-card transparent">
                                    <div class="card card-tale">
                                        <div class="card-body">
                                            <p class="mb-4">Professor</p>
                                            <p class="fs-25 mb-2">Welcome, <?= $name ?></p>
                                            <p class="fs-30 mb-2"><?= $subjectcode . ' ' . $subjectdes ?></p>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4 stretch-card transparent">
                                    <div class="card card-dark-blue">
                                        <div class="card-body">
                                            <p class="mb-4">Student</p>
                                            <p class="fs-30 mb-2" id="name"></p>
                                            <p class="fs-30 mb-2">
                                                <span class="badge badge-success" id="present"
                                                    style="padding: 5px 30px 5px 30px; font-weight: 900"></span>
                                                <span class="badge badge-warning" id="late"
                                                    style="padding: 5px 30px 5px 30px; font-weight: 900"></span>
                                                <span class="badge badge-danger" id="absent"
                                                    style="padding: 5px 30px 5px 30px; font-weight: 900"></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                               
                            </div>

                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <p class="card-title mb-0">Students</p>
                                    
                                    <div class="table-responsive">
                                        <table id="studentsTable" class="table table-striped table-borderless">
                                            <thead>
                                                <tr>

                                                    <th style="font-size: 25px;">Subject</th>
                                                    <th style="font-size: 25px;">Date</th>
                                                    <th style="font-size: 25px;">Time In</th>
                                                    <th style="font-size: 25px;">Status</th>
                                                    <th style="font-size: 25px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Data will be dynamically added here -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>

            </div>
        </div>
    </div>

    <div class="overlay" id="overlay"></div>
    <div id="modal" class="modal">
        <h2 class="fs-30 fs-bold">Update Status</h2>
        <span class="close" onclick="closeModal()">&times;</span>

        <div class="value">
            <p class="fs-30">Date: <span id="modal-date"></span></p>
            <p class="fs-30">Status: <span id="modal-status"></span></p>
            <p class="fs-30" style="display: none;">ID <span id="modal-studentID"></span></p><br>
            <p class="fs-30" style="display: none;">ID <span id="modal-id"></span></p>

        </div>

        <div class="dropdown-container mt-5">
            <select>
                <option value="">Select Status</option>
                <option value="Present">Present</option>
                <option value="Late">Late</option>
                <option value="Absent">Absent</option>
            </select>
        </div> <br>
        <button class="btn btn-success" onclick="updateStatus()" style="width: 15vw">Update</button>
    </div>





    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
    var selectedStatus;

    function updateStatus() {
        Swal.fire({
            title: 'Confirm Update',
            text: 'Are you sure you want to update the status to ' + selectedStatus + '?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, update it!'
        }).then((result) => {
            if (result.isConfirmed) {
                performUpdate(selectedStatus);
            }
        });
    }

    function performUpdate(status) {
        // Add your logic to perform the actual status update here
        console.log('Updating status to:', status);
    }

    // Function to set the selectedStatus variable when the dropdown value changes
    $(document).ready(function() {
        $('select').change(function() {
            selectedStatus = $(this).val();
        });
    });

    function performUpdate(selectedStatus) {
        var studentIDElement = document.getElementById('modal-studentID');
        var studentID = studentIDElement ? studentIDElement.innerText : null;

        var attendanceDate = document.getElementById('modal-date').innerText;
        var attendanceID = document.getElementById('modal-id').innerText;

        if (studentID !== null) {
            $.ajax({
                url: '../client/update-student.php',
                type: 'POST',
                data: {
                    idd: attendanceID,
                    id: studentID,
                    date: attendanceDate,
                    status: selectedStatus
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Show success alert only if the update was successful
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message,
                        }).then((result) => {
                            document.getElementById('modal').style.display = 'none';
                            document.getElementById('overlay').style.display = 'none';
                        });
                    } else {
                        // Show error alert if the update was not successful
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
        } else {
            console.error('Student ID not found or is undefined.');
        }
    }
    </script>


    <script src="../client/js/student-spec.js?ver=1"></script>
    <!-- <script src="../client/js/get-attendance.js"></script> -->
    <!-- <script src="../vendors/js/vendor.bundle.base.js"></script>

    <script src="../../vendors/datatables.net/jquery.dataTables.js"></script>
    <script src="../../vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
    <script src="../js/dataTables.select.min.js"></script>
    -->

    <script src="../js/off-canvas.js"></script>
    <script src="../js/hoverable-collapse.js"></script>
    <script src="../js/template.js"></script>
    <script src="../js/settings.js"></script>
    <script src="../js/todolist.js"></script>

    <script src="../js/dashboard.js"></script>

</body>

</html>