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
</head>

<body>
    <div class="container-scroller">
        <?php require_once 'nav.php' ?>
        <div class="container-fluid page-body-wrapper">
            <?php require_once 'sidebar.php'; ?>
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="content-wrapper d-flex align-items-center auth px-0">
                        <div class="row w-100 mx-0">
                            <div class="col">
                                <div class="auth-form-light text-left py-5 px-4 px-sm-5"
                                    style=" justify-content: center; margin: 0 auto; width: 60vw;">

                                    <h6 class="font-weight-light"> Register Student Details
                                    </h6>
                                    <form class="pt-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-lg"
                                                id="exampleInputUsername1" name="uid" placeholder="Username" readonly>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <input type="text" class="form-control form-control-lg"
                                                        id="exampleInputName" placeholder="First Name" name="firstname">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <input type="text" class="form-control form-control-lg"
                                                        id="exampleInputName" placeholder="Middle Name"
                                                        name="middlename">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <input type="text" class="form-control form-control-lg"
                                                        id="exampleInputName" placeholder="Last Name" name="lastname">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <select class="form-control form-control-lg" id="exampleInputSuffix"
                                                        name="suffix">
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
                                                    <input type="text" class="form-control form-control-lg"
                                                        id="exampleInputName" placeholder="Course" name="course">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <input type="text" class="form-control form-control-lg"
                                                        id="exampleInputName" placeholder="Year Level" name="year">
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
                                                    <input type="text" class="form-control form-control-lg"
                                                        value="<?=$subjectcode?>" id="exampleInputName"
                                                        placeholder="Subject Code" name="subjectcode" readonly>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <input type="text" class="form-control form-control-lg"
                                                        id="exampleInputName" placeholder="Subject Description"
                                                        value="<?=$subjectdes?>" name="subjectdescription" readonly>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <input type="text" class="form-control form-control-lg"
                                                        value="<?= date('g:i A', strtotime($scheduleFrom))?>"
                                                        id="exampleInputName" placeholder="Subject Code"
                                                        name="subjectfrom" readonly>
                                                </div>
                                            </div>
                                            <h3 style="margin-top: 10px;">-</h3>
                                            <div class="col">
                                                <div class="form-group">
                                                    <input type="text" class="form-control form-control-lg"
                                                        id="exampleInputName" placeholder="Subject Description"
                                                        value="<?= date('g:i A', strtotime($scheduleTo))?>"
                                                        name="subjectto" readonly>
                                                </div>
                                            </div>

                                        </div>


                                        <div class="mt-3">
                                            <a class="btn btn-update btn-block btn-primary btn-lg font-weight-medium auth-form-btn"
                                                href="" id="submit">Submit</a>
                                        </div>
                                    </form>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="../client/js/register-students.js?ver=1.0"></script>


    <script src="../js/off-canvas.js"></script>
    <script src="../js/hoverable-collapse.js"></script>
    <script src="../js/template.js"></script>

    <script>
    document.getElementById("submit").addEventListener("keypress", function(e) {
        if (e.key === "Enter") {
            e.preventDefault();
            this.submit();
        }
    });
    </script>
</body>

</html>