<?php
include("session.php");
    $result = mysqli_query($connect_db, "SELECT * FROM account ORDER BY id Asc");
    $res = mysqli_fetch_array($result);
    $_SESSION['id'] =  $res['id'];
if (isset($_POST['Update'])) {

    $id = mysqli_real_escape_string($connect_db, $_POST['id']);
    $Username = mysqli_real_escape_string($connect_db, $_POST['Uname']);
    $Name = mysqli_real_escape_string($connect_db, $_POST['FullName']);
    $Course = mysqli_real_escape_string($connect_db, $_POST['course']);
    $YearSection = mysqli_real_escape_string($connect_db, $_POST['Y&S']);

    $Date = date("Y-m-d");

    if (empty($Username) || empty($Name) || empty($Course) || empty($YearSection)) {
        $error = "Field must not be empty";
    } else {
        $result = mysqli_query($connect_db, "UPDATE student SET name = '$Name', course = '$Course', yearSection = '$YearSection' WHERE id = '{$id}'");
        $result1 = mysqli_query($connect_db, "UPDATE account SET username = '$Username', dateModified = '$Date' WHERE id = '{$id}'");

        header("Location:users.php?Modified Succesfully");
    }
}
?>
<?php
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $Id = $_GET['id'];


    $result = mysqli_query($connect_db, "SELECT * FROM student WHERE id=$Id");
    $result1 = mysqli_query($connect_db, "SELECT * FROM account WHERE id=$Id");

    if (mysqli_num_rows($result) == 1) {
        $res = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $res1 = mysqli_fetch_array($result1, MYSQLI_ASSOC);

        $username = $res1['username'];
        $name = $res['name'];
        $course = $res['course'];
        $YS = $res['yearSection'];
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
    <link rel="stylesheet" type="text/css" href="assets/bootstrap-4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/bootstrap-4.5.3/dist/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/addStudent.css">
    <link rel="icon" href="assets/FAVICON.png" type="text/x-icon">
    <title>Edit Student Record</title>
    <style>
        .panel {
            margin-top: 10%;
            width: 40%;
        }
    </style>
</head>

<body>

    <nav class="nav navbar-inverse navbar-fixed-top">
        <div class="container">
            <label class="navbar-brand">Library -> Users -> Update</label>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div class="navbar-collapse collapse">
                <div class="nav navbar-nav navbar-right">
                    <li><a href="users.php?=<?php echo $_SESSION['id']; ?>">Back</a></li>
                </div>
            </div>
        </div>
    </nav>
    <br><br><br>

    <center>
        <div class="container">
            <div class="panel">
                <div class="panel-heading"> </div>
                <div class="panel-body">
                    <form role="form" class="form-horizontal" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" class="form-control" name="Uname" value="<?php echo $username; ?>" placeholder="Username">
                        </div><br>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" class="form-control" name="FullName" value="<?php echo $name; ?>" placeholder=" Name">
                        </div><br>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-certificate"></i></span>
                            <input type="text" class="form-control" name="course" value="<?php echo $course; ?>" placeholder=" Course">
                        </div><br>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-mortar-board"></i></span>
                            <input type="text" class="form-control" name="Y&S" value="<?php echo $YS; ?>" placeholder=" Year & Section">
                            <input type="hidden" name="id" value=<?php echo $_GET['id']; ?>>
                        </div><br>
                        <div class="panel-footer">
                            <input type="submit" name="Update" class="btn btn-default" value="Update">
                        </div>

                </div>
            </div>
        </div>
        </div>
    </center>

    <nav class="navbar navbar-inverse navbar-fixed-bottom">
        <div class="container">
            <p>
                <?php
                echo $error;
                ?>
            </p>
        </div>
    </nav>
    <script src="assets/jquery-1.12.1/external/jquery/jquery.js"></script>
    <script src="assets/bootstrap-4.5.3/dist/js/bootstrap.min.js"></script>
</body>

</html>