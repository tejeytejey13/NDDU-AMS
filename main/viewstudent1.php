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


<body>
    <div class="container-scroller">
        <?php require_once 'nav.php' ?>
        <div class="container-fluid page-body-wrapper">
            <?php require_once 'sidebar.php'; ?>
            <div class="main-panel">
                <div class="content-wrapper">

                    <div class="row">
                        <?php       
                        if(isset($_GET['id'])){
                            $rfidUID = $_GET['id'];

                            $select = "SELECT * FROM users WHERE rfidUID = '$uid'";
                            $query = $conn->query($select);
                            while($data = $query->fetch_assoc()){
                                $name = $data['firstname'].' '.$data['middlename'].' '.$data['lastname'];
                                $subjectcode = $data['subjectCode'];
                                $subjectdes = $data['subjectDescription'];
                            }
                        }      
                          
                                      
                        ?>

                        <input type="hidden" value="<?=$rfidUID?>" name="rfid" id="hiddenRfid">

                        <div class="col-md-12 grid-margin transparent">
                            <div class="row">
                                <div class="col mb-4 stretch-card transparent">
                                    <div class="card card-tale">
                                        <div class="card-body">
                                            <p class="mb-4">Professor</p>
                                            <p class="fs-25 mb-2">Welcome, <?=$name?></p>
                                            <p class="fs-30 mb-2"><?=$subjectcode.' '.$subjectdes?></p>

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
                                    <p class="card-title mb-0">Update Status</p>
                                    <div class="table-responsive">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>

            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="myModal" class="modal">
        <!-- Modal content -->
        <span class="close" onclick="closeModal()">&times;</span>
        <p>This is a small modal content.</p>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="../client/js/spec-student-summary.js"></script>
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