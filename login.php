<?php
include "assets/php/config.php";
SESSION_START();

function test_Input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$Username = $Password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Username = test_input($_POST['Uname']);

    if (!preg_match("/^[a-zA-Z0-9_]*$/", $Username)) {
        $_SESSION['msg'] = "Username should not contain space and special characters!";
        $error2 = "Username should not contain space and special characters!";
        header('location: login.php');
    } else {

        $Password = test_input($_POST["Pass"]);
        $encrypt = md5($Password);

        $query = mysqli_query($connect_db, "select * from `account` where username='$Username' and password='$encrypt'");

        if (mysqli_num_rows($query) == 0) {
            $_SESSION['msg'] = "Login Failed, Invalid Input!";
            header('location: login.php');
        } else {

            $row = mysqli_fetch_array($query);
            if ($row['accountType'] == 'Admin') {
                $_SESSION['id'] = $row['id'];
                header("Location:admin_panel/index.php?=$_SESSION[id]");
            ?>
            <?php
            } else if ($row['accountType'] == 'Student') {
                $_SESSION['id'] = $row['id'];
                header("Location:Student_panel/index.php?=$_SESSION[id]");
            ?>
            <?php
            } else {
                $_SESSION['msg'] = "Failed! No record found";
            ?>
                <script>
                    window.alert('Error! No record');
                    window.location.href = 'login.php';
                </script>
<?php
            }
        }
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
    <link rel="stylesheet" type="text/css" href="assets/css/index.css">
    <link rel="icon" href="assets/FAVICON.png" type="text/x-icon">
    <title>Log in</title>
</head>

<body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <label class="navbar-brand">Library System</label>
        </div>
    </nav><br><br><br>

    <center>
        <div class="container-fluid">
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner" role="listbox">
                    <div class="item active">
                        <img src="assets/back.png">
                        <div class="carousel-caption">
                            <h1 class="text-2">Library</h1>
                            <button type="button" class="btn btn-violet btn-default btn-md" data-toggle="modal" data-target="#MyModalinfo">About</button>
                            <button type="button" class="btn btn-purple btn-default btn-lg" data-toggle="modal" data-target="#MyModal">Log in</button>
                        </div>
                    </div>
                    <div class="item">
                        <img src="assets/librarybanner.jpg">
                        <div class="carousel-caption">
                            <h1>Never judge the book by its<br>cover</h1>
                        </div>
                    </div>
                    <div class="item">
                        <img src="assets/call-to.jpg">
                        <div class="carousel-caption">
                            <h1>Books Are the chronicles of<br>knowledge</h1>
                        </div>
                    </div>
                </div>

                <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                    <span class="fa fa-arrow-circle-o-left"></span>
                </a>
                <a class="right carousel-control" href="#myCarousel" role="button" data-slide="prev">
                    <span class="fa fa-arrow-circle-o-right"></span>
                </a>
            </div>
        </div>
    </center>

    <div id="MyModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Log In</h4>
                </div>
                <form role="form" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                    <div class="modal-body">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" name="Uname" class="form-control" placeholder="Username">
                        </div><br><br>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                            <input type="password" name="Pass" class="form-control" placeholder="Password">
                            <input type="hidden" name="type" value="Admin">
                            <input type="hidden" name="type1" value="Student">
                        </div>
                        <br><br>
                        <div class="modal-footer">
                            <input type="button" class="btn btn-default" value="Cancel" data-dismiss="modal">
                            <input type="submit" class="btn btn-butt btn-default" value="Log in">
                        </div>
                </form>
            </div>
        </div>
    </div>
    </div>

    <div id="MyModalinfo" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">Group Members</div>
                <div class="modal-body">
                    <p>Leader: Reyneil Puda<br>Members:<br>Ranny Ortillo<br>Maria Angelica Santos<br>Mae Laderas<br>Sheila Cabuburac</p>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" value="Close" data-dismiss="modal">
                </div>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-inverse navbar-fixed-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <span class="navbar-brand" id="lab"><?php echo $_SESSION['msg']; ?></span>
                </div>
            </div>
        </div>
    </nav>
    <script language="javascript" type="text/javascript">
        window.history.forward();
    </script>
    <script src="assets/jquery-1.12.1/external/jquery/jquery.js"></script>
    <script src="assets/bootstrap-4.5.3/dist/js/carousel.js"></script>
    <script src="assets/bootstrap-4.5.3/dist/js/bootstrap.min.js"></script>
</body>

</html>