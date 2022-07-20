<?php
include("session.php");

if (isset($_POST['update'])) {

    $id = mysqli_real_escape_string($connect_db, $_POST['id']);
    $Title = mysqli_real_escape_string($connect_db, $_POST['title']);
    $Subject = mysqli_real_escape_string($connect_db, $_POST['subject']);
    $Author = mysqli_real_escape_string($connect_db, $_POST['author']);
    $YearPublished = mysqli_real_escape_string($connect_db, $_POST['Ypublished']);

    if (empty($Title) || empty($Subject) || empty($Author) || empty($YearPublished)) {
        $error = "Field must not be empty";
    } else {
        $result = mysqli_query($connect_db, "UPDATE book SET title = '$Title', subject = '$Subject', author = '$Author', publisherId = 1, yearPublished = '$YearPublished' WHERE id = '{$id}'");
        header("Location:books.php?Modified Succesfully");
    }
}
?>
<?php
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];


    $result = mysqli_query($connect_db, "SELECT * FROM book WHERE id=$id");

    if (mysqli_num_rows($result) == 1) {
        $res = mysqli_fetch_array($result, MYSQLI_ASSOC);

        $ID = $res['id'];
        $title = $res['title'];
        $subject = $res['subject'];
        $author = $res['author'];
        $yearP = $res['yearPublished'];
    } else {
        $error = "error fetch";
    }
    $result1 = mysqli_query($connect_db, "SELECT * FROM bookcount WHERE bookId=$id");
    if (mysqli_num_rows($result1) == 1) {
        $res1 = mysqli_fetch_array($result1, MYSQLI_ASSOC);
        $QTY = $res1['totalNumber'];
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
    <link rel="stylesheet" type="text/css" href="assets/css/addBook.css">
    <link rel="icon" href="assets/FAVICON.png" type="text/x-icon">
    <title>Edit Book</title>
</head>

<body>

    <nav class="nav navbar-inverse navbar-fixed-top">
        <div class="container">
            <label class="navbar-brand">Library -> Books -> Update</label>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div class="navbar-collapse collapse">
                <div class="nav navbar-nav navbar-right">
                    <li><a href="books.php">Back</a></li>


                </div>
            </div>
        </div>
    </nav>
    <br><br><br>

    <center>
        <div class="container">
            <div class="jumbotron text-center">
                <div class="panel">
                    <div class="panel-body">
                        <form role="form" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-font"></i></span>
                                <input type="text" class="form-control" value="<?php echo $title; ?>" name=" title" placeholder="Title">
                            </div><br>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-book"></i></span>
                                <input type="text" class="form-control" value="<?php echo $subject; ?>" name=" subject" placeholder="Subject">
                            </div><br>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control" value="<?php echo $author; ?>" name="author" placeholder="Author">
                            </div><br>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="text" class="form-control" name="Ypublished" value="<?php echo $yearP; ?>" placeholder=" Year Published">
                                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                            </div><br>
                    </div>
                    <div class="panel-footer">
                        <input type="submit" name="update" class="btn btn-info" value="Update">
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </center>

    <nav class="navbar navbar-inverse navbar-fixed-bottom">
        <div class="container">
            <p><?php echo $error; ?></p>
        </div>
    </nav>
    <script src="assets/jquery-1.12.1/external/jquery/jquery.js"></script>
    <script src="assets/bootstrap-4.5.3/dist/js/bootstrap.min.js"></script>
</body>

</html>