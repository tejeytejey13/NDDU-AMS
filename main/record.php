<?php
  include '../server/config.php';
  
  
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>NDDU AMS</title>
    <link rel="stylesheet" href="../vendors/feather/feather.css">
    <link rel="stylesheet" href="../vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="../vendors/datatables.net-bs4/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="../vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" type="text/css" href="../js/select.dataTables.min.css">
    <link rel="stylesheet" href="../css/vertical-layout-light/style.css">
    <link rel="shortcut icon" href="../images/nddu/nddulogo.png" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</head>


<body>
    <div class="container-scroller">
        <?php require_once 'nav.php' ?>
        <div class="container-fluid page-body-wrapper">
            <?php require_once 'sidebar.php'; ?>
            <div class="main-panel">
                <div class="content-wrapper">

                    <div class="row">
                        <?php             
                            $select = "SELECT * FROM users WHERE rfidUID = '$uid'";
                            $query = $conn->query($select);
                            while($data = $query->fetch_assoc()){
                                $name = $data['firstname'].' '.$data['middlename'].' '.$data['lastname'];
                                $subjectcode = $data['subjectCode'];
                                $subjectdes = $data['subjectDescription'];
                                $timeFrom = $data['scheduleFrom'];
                                $timeTo = $data['scheduleTo'];

                                $formattedTime = date('g:i A', strtotime($timeFrom)) . ' - ' . date('g:i A', strtotime($timeTo));
                            }
                                      
                        ?>
                        <div class="col-md-12 grid-margin transparent">
                            <div class="row">
                                <div class="col mb-4 stretch-card transparent">
                                    <div class="card card-tale">
                                        <div class="card-body">
                                            <p class="mb-4">Professor</p>
                                            <p class="fs-25 mb-2">Welcome, <?=$name?> - ( <?=$formattedTime?> )</p>
                                            <p class="fs-30 mb-2"><?=$subjectcode.' '.$subjectdes?></p>

                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="col-md-6 mb-4 stretch-card transparent">
                                    <div class="card card-dark-blue">
                                        <div class="card-body">
                                            <p class="mb-4">Date Today</p>
                                            <p class="fs-25 mb-2" id="currentDate"></p>
                                            <p class="fs-30 mb-2" id="currentTime"></p>

                                        </div>
                                    </div>
                                </div> -->
                            </div>

                        </div>

                    </div>


                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="header"
                                        style="display: flex; justify-content: space-between; align-items: center;">
                                        <p class="card-title mb-0">Students</p>
                                        <div class="d-flex">
                                            <select name="" id="studentType" class="ml-auto">
                                                <option value="Enrolled Students">Enrolled Students</option>
                                                <option value="Drop Out Students">Drop Out Students</option>
                                            </select>
                                        </div>
                                        <form id="exportForm" action="../client/export-data.php" method="post">
                                            <div class="row">
                                                <div class="col">
                                                    <label for="">Filter by Date</label>

                                                    <div class="form-group">
                                                        <select name="selectedDate" id="filterDate"
                                                            onchange="updateText()">
                                                            <option value="all">All</option>
                                                            <?php 
                                                            $selectAttendance = "SELECT DISTINCT attendanceDate FROM attendance";
                                                            $queryAttendance = $conn->query($selectAttendance);

                                                            if ($queryAttendance) {
                                                                while($dataAtt = $queryAttendance->fetch_assoc()) {
                                                                    $date = $dataAtt['attendanceDate'];
                                                                    $formattedDate = date("F j, Y", strtotime($date));
                                                                    echo '<option value="' . $date . '">' . $formattedDate. '</option>';
                                                                }
                                                            } else {
                                                                echo '<option value="">No dates available</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                        <input type="hidden" name="date" id="text" value="">
                                                    </div>
                                                </div>
                                                <div class="col" style="margin-top: 1.8rem;">
                                                    <button type="submit" class="btn btn-info" style="display: none;"
                                                        id="exportButton">Export
                                                        Data</button>
                                                </div>
                                            </div>
                                        </form>



                                        <script>
                                        function updateText() {
                                            var select = document.getElementById("filterDate");
                                            var selectedDate = select.value;
                                            document.getElementById("text").value = selectedDate;

                                            var exportButton = document.getElementById("exportButton");
                                            if (selectedDate === 'all') {
                                                exportButton.style.display = 'none';
                                            } else {
                                                exportButton.style.display =
                                                    'inline-block';
                                            }
                                        }
                                        </script>





                                    </div>
                                    <div class="table-responsive">
                                        <table id="studentsTable" class="table table-striped table-borderless">
                                            <thead>
                                                <tr>
                                                    <th style="font-size: 25px;">Name</th>
                                                    <th style="font-size: 25px;">Subject</th>
                                                    <th style="font-size: 25px;">Course</th>
                                                    <th style="font-size: 25px;">Year</th>
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
            <p class="fs-30" style="display: none;">ID <span id="modal-studentID"></span></p><br>
            <div id="firstname"></div>
            <?php 
                $select = "SELECT * FROM users WHERE rfidUID = '$uid'";
                $query = $conn->query($select);
                while($data = $query->fetch_assoc()){
                    $first = $data['firstname'];
                    $mid = $data['middlename'];
                    $last = $data['lastname'];
                    $suff = $data['suffix'];
                    $subjectcode = $data['subjectCode'];
                    $subjectdes = $data['subjectDescription'];
                    $timeFrom = $data['scheduleFrom'];
                    $timeTo = $data['scheduleTo'];

                }
        ?>
            <form class="pt-3">
    
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-lg" id="firstname"
                                placeholder="First Name" name="firstname">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-lg" id="middlename"
                                placeholder="Middle Name" name="middlename">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-lg" id="lastname"
                                placeholder="Last Name" name="lastname">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <select class="form-control form-control-lg" id="exampleInputSuffix" name="suffix">
                                <option value="" selected disabled>Choose a suffix</option>
                                <option value="Jr.">Jr.</option>
                                <option value="Sr.">Sr.</option>
                                <option value="II">II</option>
                                <option value="III">III</option>
                                <option value="IV">IV</option>
                                <option value="V">V</option>
                                <option value="VI">VI</option>
                                <option value="VII">VII</option>
                                <option value="VIII">VIII</option>
                                <option value="IX">IX</option>
                                <option value="X">X</option>
                            </select>
                        </div>
                    </div>


                    <div class="col">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-lg" id="exampleInputName"
                                placeholder="Course" name="course">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-lg" id="exampleInputName"
                                placeholder="Year Level" name="year">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <?php
                        $select = "SELECT * FROM users WHERE rfidUID = '$uid'";
                        $query = $conn->query($select);
                        while($data = $query->fetch_assoc()){
                            
                            $subjectcode = $data['subjectCode'];
                            $subjectdes = $data['subjectDescription'];
                        }
                            
                    ?>
                    <div class="col">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-lg" value="<?=$subjectcode?>"
                                id="exampleInputName" placeholder="Subject Code" name="subjectcode" readonly>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-lg" id="exampleInputName"
                                placeholder="Subject Description" value="<?=$subjectdes?>" name="subjectdescription"
                                readonly>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-lg"
                                value="<?= date('g:i A', strtotime($scheduleFrom))?>" id="exampleInputName"
                                placeholder="Subject Code" name="subjectfrom" readonly>
                        </div>
                    </div>
                    <h3 style="margin-top: 10px;">-</h3>
                    <div class="col">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-lg" id="exampleInputName"
                                placeholder="Subject Description" value="<?= date('g:i A', strtotime($scheduleTo))?>"
                                name="subjectto" readonly>
                        </div>
                    </div>

                </div>



            </form>

        </div>


        <button class="btn btn-success" onclick="updateStatus()" style="width: 15vw">Update</button>
    </div>



    <style>
    select {
        border-radius: 10px;
        padding: 10px;
    }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="../client/js/all-student-summary.js?ver=1.3"></script>
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
    max-width: 50vw;
    max-height: 50vh;
    min-width: 30vw;
    min-height: 20vh;
    overflow-y: auto;
    border-radius: 10px;
    text-align: center;
    margin: 10% 30% 0 30%;

}

.close {
    position: absolute;
    top: 10px;
    right: 10px;
    cursor: pointer;
}
</style>