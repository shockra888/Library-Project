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

if (isset($_POST['confirm'])) {
    $id = mysqli_real_escape_string($connect_db, $_POST['id']);
    $Remark = mysqli_real_escape_string($connect_db, $_POST['remark']);

    if (empty($Remark)) {
        $error = "Remark is Require";
    } else {
        $SetRemark = mysqli_query($connect_db, "UPDATE borrow SET remarks = '$Remark' WHERE id = '{$id}'");
        header("Location:Return_list.php?=$_SESSION[id]");
    }
}

?>
<?php
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $Bid = $_GET['Bid'];

    $result = mysqli_query($connect_db, "SELECT borrow.id, book.id, book.title,book.author, student.name, borrow.dateborrowed FROM
  book, student, borrow WHERE borrow.id = $id AND book.id = $Bid AND student.id = borrow.StudentId;");

    while ($BorrowRes = mysqli_fetch_array($result)) {
        if ($BorrowRes['dateReturned'] == 0000 - 00 - 00) {
            $title = $BorrowRes['title'];
            $author = $BorrowRes['author'];
            $Borrowers_name = $BorrowRes['name'];
            $dateBorrow = $BorrowRes['dateborrowed'];
            $remark = $BorrowRes['remarks'];
        } else {
            echo "error connect";
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
    <link rel="stylesheet" type="text/css" href="assets/css/addBook.css">
    <link rel="icon" href="assets/FAVICON.png" type="text/x-icon">
    <title>Borrow Information</title>
</head>

<body>

    <nav class="nav navbar-inverse navbar-fixed-top">
        <div class="container">
            <label class="navbar-brand">Library -> Borrowed Books -> Return List -> Approval</label>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div class="navbar-collapse collapse">
                <div class="nav navbar-nav navbar-right">
                    <li><a href="Return_list.php?=<?php echo $_SESSION['id']; ?>">Back</a></li>
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
                        <form role="form" method="POST">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-font"> Title</i></span>
                                <input type="text" class="form-control" value="<?php echo $title; ?>" disabled>
                            </div><br>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-male"> Author</i></span>
                                <input type="text" class="form-control" value="<?php echo $author; ?>" disabled>
                            </div><br>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user">Borrower</i></span>
                                <input type="text" class="form-control" value="<?php echo $Borrowers_name; ?>" disabled>
                            </div><br>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar">Borrow Date</i></span>
                                <input type="text" class="form-control" value="<?php echo $dateBorrow; ?>" disabled>
                                <input type="hidden" name="id" value=<?php echo $_GET['id']; ?>>
                            </div><br>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-pencil-square"></i></span>
                                <input type="text" class="form-control" name="remark" placeholder="Enter Remarks">
                            </div>
                    </div>
                    <div class="panel-footer">
                        <input type="submit" name="confirm" class="btn btn-success" value="Approve">
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