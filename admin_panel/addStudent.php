<?php
include("session.php");
$result = mysqli_query($connect_db, "SELECT * FROM account where id");
$res = mysqli_fetch_array($result);
$_SESSION['id'] =  $res['id'];
//this is where we get the session and compare it to identify the user is
//logged in if not it will be redirected to the homepage
if ($_SESSION['id'] != $_SESSION['id']) {
    header("Location:../index.php");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //this is where the data validates
    function test_Input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $Name = $Course = $YearSection = $Username = $Password = "";
    //this is getting the account type with the value of student because the user
    //to be added is a student
    $ACtype = mysqli_real_escape_string($connect_db, $_POST['acctype']);

    //this is the validation from the 'Fullname' input
    if (empty($_POST['FullName'])) {
        $error = "Name is required";
    } else {
        if (preg_match("/^[0-9 \.\-]+$/", $_POST['FullName'])) {
            $error = "Invalid Name";
        } else {
            $Name = test_Input($_POST['FullName']);
        }
    }

    //this is the validation from the 'course' input
    if (empty($_POST['course'])) {
        $error1 = "Course is required";
    } else {
        if (preg_match("/^[0-9 \.\-]+$/", $_POST['course'])) {
            $error1 = "Invalid Course";
        } else {
            $Course = test_Input($_POST['course']);
        }
    }

    //this is the validation from the 'year and section (Y&S)' input
    if (empty($_POST['Y&S'])) {
        $error2 = "Year And Section is required";
    } else {
        if (preg_match("/^[0-9 \.\-]+$/", $_POST['Y&S'])) {
            $error2 = "Invalid Year And Section";
        } else {
            $YearSection = test_Input($_POST['Y&S']);
        }
    }

    //this is the validation form the 'username' input
    if (empty($_POST['Uname'])) {
        $error = "Username is required";
    } else {
        $Username = test_Input($_POST['Uname']);
    }

    //this is the validation from 'password input'
    if (empty($_POST['Pass'])) {
        $error1 = "Password is required";
    } else {
        $Password = test_Input($_POST['Pass']);
        $encrypt = md5($Password);
    }

    //this is where we get the 'Date' from method 'date()' in PHP
    $Date = date("Y-m-d");

    //this is the condition where the input data are empty otherwise it will
    //be processed by the server side language and ready to insert in the database using SQL query
    if (!empty($Name) && (!empty($Course)) && (!empty($YearSection)) && (!empty($Username)) && (!empty($Password))) {
        $result = "INSERT into account(username,password,dateCreated,accountType) VALUES ('{$Username}', '{$encrypt}','{$Date}','{$ACtype}')";
        $result1 = "INSERT into student(name,course,yearSection) VALUES ('{$Name}', '{$Course}','{$YearSection}')";

        if ($connect_db->query($result) === TRUE && $connect_db->query($result1) === TRUE) {
            header("Location:index.php?=$_SESSION[id]");
        } else {
            $error4 = "error";
        }
    }
    //this is when we want to cancel the student registration if you press
    //back button you are redirected in the admin landing page with the user id seen in the url tab
    if (isset($_POST['back'])) {
        $result = mysqli_query($connect_db, "SELECT * FROM account where id");
        $res = mysqli_fetch_array($result);
        $_SESSION['id'] =  $res['id'];
        header("Location:index.php?=$_SESSION[id]");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="assets/bootstrap-4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/bootstrap-4.5.3/dist/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/addStudent.css">
    <link rel="icon" href="assets/FAVICON.png" type="text/x-icon">
    <title>Student Register</title>
    <style>
        .panel {
            margin-top: 10%;
            width: 40%;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <label class="navbar-brand">Library -> Student Registration</label>
        </div>
    </nav><br><br><br>

    <center>
        <div class="container">
            <div class="panel">
                <div class="panel-heading"> </div>
                <div class="panel-body">
                    <form role="form" class="form-horizontal" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" class="form-control" name="FullName" placeholder="Name">
                        </div><br>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-certificate"></i></span>
                            <input type="text" class="form-control" name="course" placeholder="Course">
                        </div><br>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-mortar-board"></i></span>
                            <input type="text" class="form-control" name="Y&S" placeholder="Year & Section">
                        </div><br>
                        <div class="panel-footer">
                            <input type="submit" name="back" class="btn btn-default" value="Back">
                            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#MyModal">Next</button>
                        </div>

                </div>
            </div>
        </div>
        </div>
    </center>

    <div id="MyModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header"></div>
                <form role="form">
                    <div class=" modal-body">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" class="form-control" name="Uname" placeholder="Username">
                        </div><br><br>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                            <input type="password" class="form-control" name="Pass" placeholder="Password">
                            <input type="hidden" name="acctype" value="Student">
                        </div><br>
                        <div class="modal-footer">
                            <input type="button" class="btn btn-default" value="Cancel" data-dismiss="modal">
                            <input type="submit" class="btn btn-default" value="Register">
                        </div>
                </form>
            </div>
        </div>
    </div>
    </div>

    <nav class="navbar navbar-inverse navbar-fixed-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    <span class="navbar-brand" id="lab"><?php echo $error; ?></span>
                </div>
                <div class="col-md-2">
                    <span class="navbar-brand" id="lab"><?php echo $error1; ?></span>
                </div>
                <div class="col-md-2">
                    <span class="navbar-brand" id="lab"><?php echo $error2; ?></span>
                </div>
                <div class="col-md-2">
                    <span class="navbar-brand" id="lab"><?php echo $error3; ?></span>
                </div>
                <div class="col-md-2">
                    <span class="navbar-brand" id="lab"><?php echo $error4; ?></span>
                </div>
            </div>
        </div>
    </nav>
    <script src="assets/jquery-1.12.1/external/jquery/jquery.js"></script>
    <script src="assets/bootstrap-4.5.3/dist/js/bootstrap.min.js"></script>
</body>

</html>