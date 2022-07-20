<?php
require_once("session.php");
$Uresult = mysqli_query($connect_db, "SELECT * FROM account where id='$_SESSION[id]'");
$Ures = mysqli_fetch_array($Uresult);
//this is where we get the session and compare it to identify the user is
//logged in if not it will be redirected to the homepage
$_SESSION['id'] = $Ures['id'];
if ($_SESSION['id'] != $_SESSION['id']) {
    header("Location:../index.php");
    exit();
}

//this is the PHP and MYSQLi query to fetch the data from 2 tables using Left Join query
$result = mysqli_query($connect_db, "SELECT *,title, subject, author, yearPublished, totalNumber FROM book LEFT JOIN bookcount ON book.id = bookcount.bookId");
//this is where we determine on how many rows are there in a table, the table selected is 'book'
//using COUNT() query
$result1 = mysqli_query($connect_db, "SELECT COUNT(id) FROM book");
$res1 = mysqli_fetch_array($result1);

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
                        <form role="form" class="form-inline" action="search.php" method="GET">
                            <div class="input-group">
                                <input type="search" class="form-control" name="content" placeholder="Search...">
                                <div class="input-group-btn">
                                    <button type="submit" id="Search" name="search" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                        </form>
                    </li>
                    <li><a href="index.php?=<?php echo $_SESSION['id']; ?>">Back</a></li>
                </ul>
            </div>
        </div>
        </div>
    </nav>
    <br><br><br>

    <div class="container-fluid" id="ser">
        <div class="jumbotron text-center">
            <div class="row">
                <div class="col-lg-12">
                    <table id="tbl" width="100%" class="table table-bordered">
                        <thead>
                            <tr>
                                <!--this is to display the row count of the table book!-->
                                <th colspan="8">Book Count: <?php echo $res1['COUNT(id)'] ?></th>
                            </tr>
                        </thead>
                        <thead>
                            <tr>
                                <th class="theader">Title</th>
                                <th class="theader">Subject</th>
                                <th class="theader">Author</th>
                                <th class="theader">Year Published</th>
                                <th class="theader">Available Copies</th>
                                <th class="theader" colspan="3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            //this is to fetch data in a 2 table and display it here using mysqli_fetch_array and a loop
                            while ($res = mysqli_fetch_array($result)) {

                                echo "<tr class='tr2'>";
                                echo "<td class='td1'>" . $res['title'] . "</td>";
                                echo "<td class='td1'>" . $res['subject'] . "</td>";
                                echo "<td class='td1'>" . $res['author'] . "</td>";
                                echo "<td class='td1'>" . $res['yearPublished'] . "</td>";
                                echo "<td class='td1'>" . $res['totalNumber'] . "</td>";
                                //the buttons we use as action to the data in a specific data in a table
                                echo "<td class='td1'><a class='btn btn-primary btn-md' href=\"update_book.php?id=$res[id]\"><i class='fa fa-edit'>Update</i></a></td>  <td class='td1'> <a class='btn btn-danger btn-md' data-name='$res[title]' data-id='$res[id]' onCLick='confirmDelete(this);'><i class='fa fa-trash-o'>Delete</i></a></td>  <td class='td1'><a class='btn btn-warning btn-md' data-title='$res[title]' data-bid='$res[id]' onCLick='confirmBorrow(this);'><i class='fa fa-hand-lizard-o'>Borrow</i></a></td>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!--This is the confirmation before deleting a book to avoid accidental delete of a book!-->
    <div id="MyModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                </div>
                <div class=" modal-body">
                    <h4 class="modal-title">Do you want to delete this book?</h4>
                </div>
                <form method="GET" action="delete_book.php?" id="delete-book">
                    <input type="hidden" name="id">
                    <div class="input-group">
                        <span class="input-group-addon"><i>Title</i></span>
                        <input type="text" class="form-control" name="title" disabled>
                    </div><br>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" form="delete-book" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!--This is the confirmation before borrowing a book to avoid accidental borrow of a book!-->
    <div id="MyModalB" class="modal fade" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                </div>
                <div class=" modal-body">
                    <h4 class="modal-title">Do you want to Borrow this book?</h4>
                </div>
                <form method="GET" action="borrow_info.php?" id="borrow-book">
                    <input type="hidden" name="bid">
                    <div class="input-group">
                        <span class="input-group-addon"><i>Title</i></span>
                        <input type="text" class="form-control" name="titles" disabled>
                    </div><br>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" form="borrow-book" class="btn btn-warning">Borrow</button>
                </div>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-inverse navbar-fixed-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="navbar-brand"><?php echo $info; ?></div>
                </div>
            </div>
        </div>
    </nav>
    <script>
        function confirmDelete(self) {
            //this a function that confirms a delete to a book
            //it gather the specific id and name of a book and this function opens the confirmation
            //modal
            var id = self.getAttribute("data-id");
            var title = self.getAttribute("data-name");

            document.getElementById("delete-book").id.value = id;
            document.getElementById("delete-book").title.value = title;
            $("#MyModal").modal("show");

        }

        function confirmBorrow(self) {
            //this a function that confirms a borrow to a book
            //it gather the specific id and name of a book and this function opens the confirmation
            //modal
            var bid = self.getAttribute("data-bid");
            var titles = self.getAttribute("data-title");

            document.getElementById("borrow-book").bid.value = bid;
            document.getElementById("borrow-book").titles.value = titles;
            $("#MyModalB").modal("show");

        }
    </script>
    <script src="assets/jquery-1.12.1/external/jquery/jquery.js"></script>
    <script src="assets/bootstrap-4.5.3/dist/js/bootstrap.min.js"></script>
</body>

</html>