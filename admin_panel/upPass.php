<?php
include("session.php");
$result = mysqli_query($connect_db, "SELECT * FROM account ORDER BY id Asc");
$res = mysqli_fetch_array($result);
$_SESSION['id'] =  $res['id'];

if (isset($_POST['update'])) {

    $id = mysqli_real_escape_string($connect_db, $_POST['id']);
    $Password = mysqli_real_escape_string($connect_db, $_POST['password']);
    $ConfirmPass = mysqli_real_escape_string($connect_db, $_POST['Cpass']);

    if ($Password != $ConfirmPass) {
        $error1 = "Passwords doesn't match";
    } else if (empty($Password) || empty($ConfirmPass)) {
        $error1 = "Forms should not be empty";
    } else {
        $Date = date("Y-m-d");
        $encrypt = md5($ConfirmPass);
        $result = mysqli_query($connect_db, "UPDATE account SET password = '$encrypt', dateModified = '$Date' WHERE id = '{$id}'");

        header("Location:users.php?Modified Succesfully");
    }
}
?>
<?php
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];


    $result = mysqli_query($connect_db, "SELECT * FROM account WHERE id=$id");

    if (mysqli_num_rows($result) == 1) {
        $res = mysqli_fetch_array($result, MYSQLI_ASSOC);
    } else {
        $error = "error fetch";
    }
} else {
    $error = "error connect";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/bootstrap-4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/bootstrap-4.5.3/dist/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/upPass.css">
    <link rel="icon" href="assets/FAVICON.png" type="text/x-icon">
    <title>Change Password</title>
</head>

<body>
    <nav class="nav navbar-inverse navbar-fixed-top">
        <div class="container">
            <label class="navbar-brand">Library -> Users -> Update Password</label>

            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="users.php?=<?php echo $_SESSION['id']; ?>">Back</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <br><br><br>

    <center>
        <div class="container" id="cont">
            <div class="panel">
                <div class="panel-heading"> </div>
                <div class="panel-body">
                    <form role="form" class="form-horizontal" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                            <input type="password" class="form-control" name="password" placeholder="Enter new password">
                        </div><br>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                            <input type="password" class="form-control" name="Cpass" placeholder="Confirm Password">
                            <input type="hidden" name="id" value=<?php echo $_GET['id']; ?>>
                        </div><br>
                        <div class="panel-footer">
                            <input type="submit" name="update" class="btn btn-default" value="Update">
                        </div>

                </div>
            </div>
        </div>
        </div>
    </center>
    <div class="box1"></div>
    <nav class="navbar navbar-inverse navbar-fixed-bottom">
        <div class="container">
            <p class="navbar-brand"><?php echo $error1; ?></p>
        </div>
    </nav>
    <script src="assets/jquery-1.12.1/external/jquery/jquery.js"></script>
    <script src="assets/bootstrap-4.5.3/dist/js/bootstrap.min.js"></script>
</body>

</html>