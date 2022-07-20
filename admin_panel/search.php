<?php
include("session.php");
if (isset($_REQUEST['search'])) {
    $SearchContent = mysqli_real_escape_string($connect_db, $_GET['content']);

    if (empty($SearchContent)) {
        $error = "Please Search something";
    } else {
        $SearchQuery = mysqli_query($connect_db, "SELECT * FROM book LEFT JOIN bookcount ON bookcount.totalNumber WHERE bookcount.bookId = book.id AND title LIKE '%$SearchContent%' OR author LIKE '%$SearchContent$' OR subject LIKE '%$SearchContent%'");
        $SearchCount = mysqli_num_rows($SearchQuery);

        if ($SearchCount == 0) {
            $info = "There are no record";
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
    <link rel="stylesheet" type="text/css" href="assets/css/books.css">
    <link rel="icon" href="assets/FAVICON.png" type="text/x-icon">
    <title>Search</title>
</head>

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
                <li><a href="index.php">Back</a></li>
            </ul>
        </div>
    </div>
    </div>
</nav>
<br><br><br>

<body>
    <div class="container-fluid" id="result">
        <div class="jumbotron text-center">
            <div class="row">
                <div class="col-lg-12">
                    <table width="100%" class="table table-bordered table-bordered">
                        <thead>
                            <tr>
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
                        <?php
                        if ($SearchCount >= 1) {
                            while ($SearchRow = mysqli_fetch_array($SearchQuery)) {

                                echo "<tr class='tr2'>";
                                echo "<td class='td1'>" . $SearchRow['title'] . "</td>";
                                echo "<td class='td1'>" . $SearchRow['subject'] . "</td>";
                                echo "<td class='td1'>" . $SearchRow['author'] . "</td>";
                                echo "<td class='td1'>" . $SearchRow['yearPublished'] . "</td>";
                                echo "<td class='td1'>" . $SearchRow['totalNumber'] . "</td>";
                                echo "<td class='td1'><a class='btn btn-primary btn-md' href=\"update_book.php?id=$$SearchRow[id]\"><i class='fa fa-edit'>Update</i></a></td>  <td class='td1'> <a class='btn btn-danger btn-md' data-name='$SearchRow[title]' data-id='$SearchRow[id]' onCLick='confirmDelete(this);'><i class='fa fa-trash-o'>Delete</i></a></td>  <td class='td1'><a class='btn btn-warning btn-md' data-title='$SearchRow[title]' data-bid='$SearchRow[id]' onCLick='confirmBorrow(this);'><i class='fa fa-hand-lizard-o'>Borrow</i></a></td>";
                            }
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
            var id = self.getAttribute("data-id");
            var title = self.getAttribute("data-name");

            document.getElementById("delete-book").id.value = id;
            document.getElementById("delete-book").title.value = title;
            $("#MyModal").modal("show");

        }

        function confirmBorrow(self) {
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