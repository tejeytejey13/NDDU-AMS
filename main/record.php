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
                                        <form action="../client/export-data.php" method="post">
                                            <button type="submit" class="btn btn-info">Export Data</button>
                                        </form>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="studentsTable" class="table table-striped table-borderless">
                                            <thead>
                                                <tr>
                                                    <th style="font-size: 25px;">Student ID</th>
                                                    <th style="font-size: 25px;">Name</th>
                                                    <th style="font-size: 25px;">Subject</th>
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

    <style>
    select {
        border-radius: 10px;
        padding: 10px;
    }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="../client/js/all-student-summary.js?ver=1.1"></script>
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