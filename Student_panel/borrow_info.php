<?php
require_once("session.php");
$Uresult = mysqli_query($connect_db, "SELECT * FROM account where id='$_SESSION[id]'");
$Ures = mysqli_fetch_array($Uresult);
$_SESSION['id'] =  $Ures['id'];
$id = $_GET['id'];
if ($_SESSION['id'] != $_SESSION['id']) {
    header("Location:../index.php");
    exit();
}

$Date = date("Y-m-d");

if (isset($_GET['Borrow'])) {
    $BookCount = mysqli_query($connect_db, "SELECT totalNumber from bookcount where bookId = '$id' ");
    while ($rowCount = mysqli_fetch_array($BookCount)) {
        if ($rowCount['totalNumber'] == 0) {
            mysqli_query($connect_db, "UPDATE bookcount set totalNumber = 0 where bookId = '$id' ");
            $error = "Book not available";
        } else {
            $Borrow = "INSERT INTO borrow (bookId,StudentId) SELECT book.id, student.id FROM book, student WHERE book.id = $id AND student.id = $Ures[id]";

            if ($connect_db->query($Borrow) === TRUE) {
                $BorrowDate = mysqli_query($connect_db, "UPDATE `borrow` SET `dateborrowed` = '$Date' WHERE `borrow`.`bookId` = '$id';");
                $BorrowCount = mysqli_query($connect_db, "UPDATE bookcount set totalNumber = totalNumber - 1 where bookId = '$id' ");
                header("Location:books.php?=$_SESSION[id]");
            } else {
                $error = "Problem in sql";
            }
        }
    }
}
?>
<?php
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];


    $result = mysqli_query($connect_db, "SELECT * FROM book WHERE id=$id");

    if (mysqli_num_rows($result) == 1) {
        $res = mysqli_fetch_array($result, MYSQLI_ASSOC);

        $title = $res['title'];
        $subject = $res['subject'];
        $author = $res['author'];
        $yearPublished = $res['yearPublished'];
    } else {
        echo "error connect";
    }
} else {
    echo "error id";
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
    <title>Borrow Information</title>
</head>

<body>

    <nav class="nav navbar-inverse navbar-fixed-top">
        <div class="container">
            <label class="navbar-brand">Library -> Books -> Borrow Information</label>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div class="navbar-collapse collapse">
                <div class="nav navbar-nav navbar-right">
                    <li><a href="index.php?=<?php echo $_SESSION['id']; ?>">Back</a></li>
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
                        <form role="form" method="GET">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-font"></i></span>
                                <input type="text" class="form-control" name="title" value="<?php echo $title; ?>" disabled>
                            </div><br>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-book"></i></span>
                                <input type="text" class="form-control" name="subject" value="<?php echo $subject; ?>" disabled>
                            </div><br>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control" name="author" value="<?php echo $author; ?>" disabled>
                            </div><br>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="text" class="form-control" name="Ypublished" value="<?php echo $yearPublished; ?>" disabled>
                                <input type="hidden" name="id" value=<?php echo $_GET['id']; ?>>
                            </div><br>
                    </div>
                    <div class="panel-footer">
                        <input type="submit" name="Borrow" class="btn btn-warning" value="Borrow">
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </center>

    <nav class="navbar navbar-inverse navbar-fixed-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    <span class="navbar-brand" id="lab"><?php echo $error; ?></span>
                </div>
            </div>
    </nav>
    <script src="assets/jquery-1.12.1/external/jquery/jquery.js"></script>
    <script src="assets/bootstrap-4.5.3/dist/js/bootstrap.min.js"></script>
</body>

</html>