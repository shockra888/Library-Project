<?php
require_once("session.php");
$Uresult = mysqli_query($connect_db, "SELECT * FROM account where id='$_SESSION[id]'");
$Ures = mysqli_fetch_array($Uresult);
$_SESSION['id'] = $Ures['id'];
if ($_SESSION['id'] != $_SESSION['id']) {
    header("Location:../index.php");
    exit();
}

$Borrow_detail = mysqli_query($connect_db, "SELECT book.title, book.subject, book.author, book.yearPublished, student.name, borrow.dateborrowed,borrow.dateReturned, borrow.remarks FROM
  book, student, borrow WHERE book.id = borrow.bookId AND student.id = borrow.StudentId ORDER BY borrow.id");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="assets/bootstrap-4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/bootstrap-4.5.3/dist/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/books.css">
    <link rel="icon" href="assets/FAVICON.png" type="text/x-icon">
    <title>Borrow History</title>
    <style>
        .navbar-right {
            margin-top: 3px;
        }
    </style>
</head>

<body>
    <nav class="nav navbar-inverse navbar-fixed-top">
        <div class="container">
            <label class="navbar-brand">Library -> Borrowed Books -> Borrow History</label>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="borrowedBooks.php?=<?php echo $_SESSION['id']; ?>">Back</a></li>
                </ul>
            </div>
        </div>
    </nav> <br><br><br>

    <div class="container-fluid">
        <div class="jumbotron text-center">
            <div class="row">
                <div class="col-lg-12">
                    <table width="100%" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="theader">Title</th>
                                <th class="theader">Author</th>
                                <th class="theader">Borrowed By</th>
                                <th class="theader">Date Borrowed</th>
                                <th class="theader">Date Returned</th>
                                <th class="theader">Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($BorrowRes = mysqli_fetch_array($Borrow_detail)) {
                                if ($BorrowRes['dateReturned'] == 0000 - 00 - 00) {
                                    //nothing to show here
                                } else if ($BorrowRes['remarks'] == '') {
                                    //nothing to show here
                                } else {
                                    echo "<tr class='tr2'>";
                                    echo "<td class='td1'>" . $BorrowRes['title'] . "</td>";
                                    echo "<td class='td1'>" . $BorrowRes['author'] . "</td>";
                                    echo "<td class='td1'>" . $BorrowRes['name'] . "</td>";
                                    echo "<td class='td1'>" . $BorrowRes['dateborrowed'] . "</td>";
                                    echo "<td class='td1'>" . $BorrowRes['dateReturned'] . "</td>";
                                    echo "<td class='td1'>" . $BorrowRes['remarks'] . "</td>";
                                }
                            }
                            ?>
                    </table>
                </div>
            </div>
        </div>
    </div>



    <nav class="navbar navbar-inverse navbar-fixed-bottom">
        <div class="container">
        </div>
    </nav>
    <script src="assets/jquery-1.12.1/external/jquery/jquery.js"></script>
    <script src="assets/bootstrap-4.5.3/dist/js/bootstrap.min.js"></script>
</body>

</html>