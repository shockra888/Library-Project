<?php
require_once("session.php");
$result = mysqli_query($connect_db, "SELECT *,title, subject, author, yearPublished, totalNumber FROM book LEFT JOIN bookcount ON book.id = bookcount.bookId");
$result1 = mysqli_query($connect_db, "SELECT COUNT(id) FROM book");
$res1 = mysqli_fetch_array($result1);

$Uresult = mysqli_query($connect_db, "SELECT * FROM account where id='$_SESSION[id]'");
$Ures = mysqli_fetch_array($Uresult);
$_SESSION['id'] =  $Ures['id'];

if ($_SESSION['id'] != $_SESSION['id']) {
    header("Location:../index.php");
    exit();
}


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
    <title>Books</title>
    <style>
        .navbar-right {
            margin-top: 3px;
        }

        .table-hover {
            color: #000000;
        }
    </style>
</head>

<body>
    <nav class="nav navbar-inverse navbar-fixed-top">
        <div class="container">
            <label class="navbar-brand">Library -> Books</label>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                    <li>
                        <form role="form" class="form-inline" action="search.php" method="GET">
                            <div class="input-group">
                                <input type="search" class="form-control" name="content" placeholder="Search...">
                                <div class="input-group-btn">
                                    <button type="submit" id="Search" name="search" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                        </form>
                    </li>
                    </li>
                    <li><a href="index.php?=<?php echo $_SESSION['id']; ?>">Back</a></li>
                </ul>
            </div>
        </div>
        </div>
    </nav>
    <br><br><br>

    <div class="container-fluid">
        <div class="jumbotron text-center">
            <div class="row">
                <div class="col-lg-12">
                    <table width="100%" class="table table-bordered table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="theader" colspan="7">Available Books: <?php echo $res1['COUNT(id)']; ?></th>
                            </tr>
                        </thead>
                        <thead>
                            <tr>
                                <th class="theader">Title</th>
                                <th class="theader">Subject</th>
                                <th class="theader">Author</th>
                                <th class="theader">Year Published</th>
                                <th class="theader">Available Copies</th>
                                <th class="theader">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($res = mysqli_fetch_array($result)) {

                                echo "<tr class='tr2'>";
                                echo "<td class='td1'>" . $res['title'] . "</td>";
                                echo "<td class='td1'>" . $res['subject'] . "</td>";
                                echo "<td class='td1'>" . $res['author'] . "</td>";
                                echo "<td class='td1'>" . $res['yearPublished'] . "</td>";
                                echo "<td class='td1'>" . $res['totalNumber'] . "</td>";
                                echo "<td class='td1'><a class='btn btn-warning btn-md' data-name='$res[title]' data-id='$res[id]' onCLick='confirmBorrow(this);'><i class='fa fa-hand-lizard-o'>Borrow</i></a></td>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="MyModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                </div>
                <div class=" modal-body">
                    <h4 class="modal-title">Do you want to Borrow this book?</h4>
                </div>
                <form method="GET" action="borrow_info.php?" id="borrow-book">
                    <input type="hidden" name="id">
                    <div class="input-group">
                        <span class="input-group-addon"><i>Title</i></span>
                        <input type="text" class="form-control" name="title" disabled>
                    </div><br>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" form="borrow-book" class="btn btn-warning">Borrow</button>
                </div>
            </div>
        </div>
    </div>
    </div>



    <nav class="navbar navbar-inverse navbar-fixed-bottom">
        <div class="container">
        </div>
    </nav>
    <script>
        function confirmBorrow(self) {
            var id = self.getAttribute("data-id");
            var title = self.getAttribute("data-name");

            document.getElementById("borrow-book").id.value = id;
            document.getElementById("borrow-book").title.value = title;
            $("#MyModal").modal("show");

        }
    </script>
    <script src="assets/jquery-1.12.1/external/jquery/jquery.js"></script>
    <script src="assets/bootstrap-4.5.3/dist/js/bootstrap.min.js"></script>
</body>

</html>