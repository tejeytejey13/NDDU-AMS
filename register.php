<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>NDDU AMS</title>
    <link rel="stylesheet" href="vendors/feather/feather.css">
    <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="css/vertical-layout-light/style.css">
    <link rel="shortcut icon" href="images/nddu/nddulogo.png" />
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5"
                            style="justify-content: center; margin: 0 auto; width: 50vw; filter: drop-shadow(5px 5px 15px #000000);">
                            <div class="brand-logo">
                                <img src="images/nddu/nddulogo.png" alt="logo">
                            </div>
                            <h4>New here?</h4>
                            <h6 class="font-weight-light">Signing up is easy. It only takes a few steps</h6>
                            <form class="pt-3">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-lg" id="exampleInputUsername1"
                                        name="uid" placeholder="Username" readonly>
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
                                                id="exampleInputName" placeholder="Middle Name" name="middlename">
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
                                            <input type="text" class="form-control form-control-lg"
                                                id="exampleInputName" placeholder="Subject Code" name="subjectcode">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-lg"
                                                id="exampleInputName" placeholder="Subject Description"
                                                name="subjectdescription">
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <input type="time" class="form-control form-control-lg"
                                                id="exampleInputName" placeholder="Schedule From" name="schedulefrom">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <input type="time" class="form-control form-control-lg"
                                                id="exampleInputName" placeholder="Schedule To" name="scheduleto">
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-lg"
                                        id="exampleInputPassword1" placeholder="Password" name="password">
                                </div>
                                <div class="mt-3">
                                    <a class="btn btn-update btn-block btn-primary btn-lg font-weight-medium auth-form-btn"
                                        href="" id="submit">SIGN UP</a>
                                </div>
                                <div class="text-center mt-4 font-weight-light">
                                    Already have an account? <a href="index.php" class="text-primary">Login</a>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <!--Queries -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="client/js/realtime-retrieve-uid.js"></script>
    <script src="client/js/update-register-uid.js"></script>


    <!-- Random -->
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <script src="js/off-canvas.js"></script>
    <script src="js/hoverable-collapse.js"></script>
    <script src="js/template.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/todolist.js"></script>


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