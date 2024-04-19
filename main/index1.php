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
                            }
                                      
                        ?>
                        <div class="col-md-12 grid-margin transparent">
                            <div class="row">
                                <div class="col-md-6 mb-4 stretch-card transparent">
                                    <div class="card card-tale">
                                        <div class="card-body">
                                            <p class="mb-4">Professor</p>
                                            <p class="fs-25 mb-2">Welcome, <?=$name?></p>
                                            <p class="fs-30 mb-2"><?=$subjectcode.' '.$subjectdes?></p>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4 stretch-card transparent">
                                    <div class="card card-dark-blue">
                                        <div class="card-body">
                                            <p class="mb-4">Date Today</p>
                                            <p class="fs-25 mb-2" id="currentDate"></p>
                                            <p class="fs-30 mb-2" id="currentTime"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>



                    <!-- Display None the Auto Submit Attendance -->
                    <form class="pt-3" style="display: none">
                        <div class="form-group">
                            <input type="text" name="from" value="<?=$scheduleFrom?>">
                            <input type="text" name="to" value="<?=$scheduleTo?>">
                            <input type="text" class="form-control form-control-lg" id="exampleInputUsername1"
                                name="uid" placeholder="Username" readonly>
                        </div>

                        <div class="row">
                            <?php
                                $select = "SELECT * FROM users WHERE rfidUID = '$uid'";
                                $query = $conn->query($select);
                                while($data = $query->fetch_assoc()){
                                    $subjectcode = $data['subjectCode'];
                                }
                                    
                            ?>
                            <div class="col">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-lg" value="<?=$subjectcode?>"
                                        id="exampleInputName" placeholder="Subject Code" name="subjectcode" readonly>
                                </div>
                            </div>

                        </div>


                        <div class="mt-3">
                            <a class="btn btn-update btn-block btn-primary btn-lg font-weight-medium auth-form-btn"
                                href="">Submit</a>
                        </div>
                    </form>



                    <?php
                    date_default_timezone_set('Asia/Manila');
                    $select1 = "SELECT * FROM users WHERE rfidUID != '$uid' LIMIT 1";
                    $query1 = $conn->query($select1);

                    while ($data1 = $query1->fetch_assoc()) {
                        $name = $data1['firstname'] . ' ' . $data1['middlename'] . ' ' . $data1['lastname'];
                        $subjectCode = $data1['subjectCode'];
                        $subjectDescription = $data1['subjectDescription'];

                        // Assuming that $data1['scheduleTo'] contains the schedule information
                        $scheduleTo = $data1['scheduleTo'];
                        $scheduleToTimestamp = strtotime($scheduleTo);

                        $currentTimestamp = time();
                        $fiveMinutesBefore = $currentTimestamp - 5 * 60;

                        if ($fiveMinutesBefore < $scheduleToTimestamp) {
                            echo '<script>
                            Swal.fire({
                                title: "Next Schedule Alert",
                                html: `Your next schedule for ' . $subjectCode . ' - ' . $subjectDescription . ' is approaching!`,
                                icon: "info",
                                timer: 5000,
                                timerProgressBar: true,
                                showConfirmButton: false,
                                allowOutsideClick: false,
                                didOpen: () => {
                                    
                                    var audio = new Audio("../alarm1.mp3");
                                    audio.play();
                                }
                            });
                            </script>';
                        }
                    }
                ?>


                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <p class="card-title mb-0">Students</p>
                                    <div class="table-responsive">
                                        <table id="studentsTable" class="table table-striped table-borderless">
                                            <thead>
                                                <tr>
                                                    <th style="font-size: 25px;">Name</th>
                                                    <th style="font-size: 25px;">Subject</th>
                                                    <th style="font-size: 25px;">Status</th>
                                                    <th style="font-size: 25px;">Time In</th>
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
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>


    <script>
    

    function updateDateTime() {
        var currentDate = new Date();
        var optionsDate = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
        };
        var optionsTime = {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: true,
            timeZone: 'Asia/Manila' // Set the time zone to the Philippines
        };

        var formattedDate = currentDate.toLocaleDateString('en-PH', optionsDate);
        var formattedTime = currentDate.toLocaleTimeString('en-PH', optionsTime);

        document.getElementById('currentDate').textContent = formattedDate;
        document.getElementById('currentTime').textContent = formattedTime;
    }

    setInterval(updateDateTime, 1000);

    updateDateTime();
    </script>


    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="../client/js/auto-post-attendance.js"></script>
    <script src="../client/js/get-attendance-students.js?ver=2.1"></script>
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