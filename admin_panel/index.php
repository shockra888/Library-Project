<?php
require_once("session.php");
$result = mysqli_query($connect_db, "SELECT * FROM account ORDER BY id Asc");
$res = mysqli_fetch_array($result);
$_SESSION['id'] =  $res['id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/bootstrap-4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/bootstrap-4.5.3/dist/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/admin_index.css">
    <link rel="icon" href="assets/FAVICON.png" type="text/x-icon">
    <title>Admin</title>
</head>

<body>
    <div class="box">
        <nav class="nav navbar-inverse navbar-fixed-top">
            <div class="container">
                <label class="navbar-brand">Library</label>
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Admin<b class="caret"></b>
                                <ul class="dropdown-menu">
                                    <li><a href="addStudent.php?=<?php echo $_SESSION['id']; ?>"><i class="fa fa-user-plus"> Student Register</i></a></li>
                                    <li><a href="users.php?=<?php echo $_SESSION['id']; ?>"><i class="fa fa-users"> Users</i></a></li>
                                    <li><a href="logout.php"><i class="fa fa-sign-out"> Log Out</i></a></li>
                                </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <br><br><br>

        <div class="container" id="cont">
            <div class="row">
                <div class="col-md-4">
                    <div class="jumbotron text-center" id="jumb">
                        <h2>Books</h2>
                        <a href="books.php?=<?php echo $_SESSION['id']; ?>"><img src="assets/books.png"></a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="jumbotron text-center">
                        <h2>Borrowed Books</h2>
                        <a href="borrowedBooks.php?=<?php echo $_SESSION['id']; ?>"><img src="assets/bbook.png"></a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="jumbotron text-center">
                        <h2>Add Book</h2>
                        <a href="addBook.php?=<?php echo $_SESSION['id']; ?>"><img src="assets/addbook.png"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="box1"></div>
    <nav class="navbar navbar-inverse navbar-fixed-bottom">
        <div class="container">
            <p class="navbar-brand">Welcome Admin: <?php echo $res['username']; ?></p>
        </div>
    </nav>
    <script src="assets/jquery-1.12.1/external/jquery/jquery.js"></script>
    <script src="assets/bootstrap-4.5.3/dist/js/bootstrap.min.js"></script>
</body>

</html>