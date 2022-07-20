<?php
include("session.php");
$Uresult = mysqli_query($connect_db, "SELECT * FROM account ORDER BY id Asc");
$Ures = mysqli_fetch_array($Uresult);
//this is where we get the session and compare it to identify the user is
//logged in if not it will be redirected to the homepage
$_SESSION['id'] =  $Ures['id'];
if ($_SESSION['id'] != $_SESSION['id']) {
    header("Location:../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //this is where the data is being processed by server side language
    function test_Input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $Title = $Subject = $Author = "";

    $PublisherID = 1;
    //accepting data from input that is named 'quantity in html'
    $Quantity = mysqli_real_escape_string($connect_db, $_POST['quantity']);

    //this is the conditions where validating the input of the user

    //validation of data from 'title' input
    if (empty($_POST['title'])) {
        $error = "Title is required";
    } else {
        if (preg_match("/^[0-9 \.\-]+$/", $_POST['title'])) {
            $error = "Invalid title";
        } else {
            $Title = test_Input($_POST['title']);
        }
    }

    //validation of data from 'subject' input
    if (empty($_POST['subject'])) {
        $error1 = "Subject is required";
    } else {
        if (preg_match("/^[0-9 \.\-]+$/", $_POST['title'])) {
            $error1 = "Invalid Subject";
        } else {
            $Subject = test_Input($_POST['subject']);
        }
    }

    //validation of data from 'author' input
    if (empty($_POST['author'])) {
        $error2 = "Author is required";
    } else {
        if (preg_match("/^[0-9 \.\-]+$/", $_POST['author'])) {
            $error2 = "Invalid Author";
        } else {
            $Author = test_Input($_POST['author']);
        }
    }

    //validation of data from 'year published (Ypublished)' input
    if (empty($_POST['Ypublished'])) {
        $error3 = "Year of Publish is required";
    } else {
        if (!preg_match("/^[0-9 \.\-]+$/", $_POST['Ypublished'])) {
            $error3 = "Invalid input";
        } else {
            $YearPublished = test_Input($_POST['Ypublished']);
        }
    }



    //this is the condition if the inputs are empty or else the input data will be processed
    //in ready to be inserted in the database with sql query
    if (empty($Title) && empty($Subject) && empty($Author) && empty($YearPublished) && empty($PublisherID)) {
        $error4 = "Form is Empty";
    } else {
        $result = "INSERT INTO book (`title`, `subject`, `author`, `publisherId`, `yearPublished`) VALUES ('{$Title}', '{$Subject}', '{$Author}', '1', '{$YearPublished}');";
        if ($connect_db->query($result) === TRUE) {

            $Insertid = $connect_db->insert_id;
            $result1 = "INSERT INTO bookcount (`bookId`, `totalNumber`) VALUES ('{$Insertid}', '{$Quantity}');";

            $query = $connect_db->query($result1);

            if ($query === TRUE) {
                header("Location:index.php?Added Succesfully");
            } else {
                $error = "Error Adding data";
            }
        } else {
            $error4 = "error";
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
    <title>Add Book</title>
</head>

<body>

    <nav class="nav navbar-inverse navbar-fixed-top">
        <div class="container">
            <label class="navbar-brand">Library -> Add Book</label>
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
                        <form role="form" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-font"></i></span>
                                <input type="text" class="form-control" name="title" placeholder="Title">
                            </div><br>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-book"></i></span>
                                <input type="text" class="form-control" name="subject" placeholder="Subject">
                            </div><br>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control" name="author" placeholder="Author">
                            </div><br>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="text" class="form-control" name="Ypublished" placeholder="Year Published">
                            </div><br>
                    </div>
                    <div class="panel-footer">
                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#MyModal">Next</button>
                    </div>
                </div>
            </div>
        </div>
    </center>

    <div id="MyModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header"></div>
                <div class=" modal-body">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-hashtag"></i></span>
                        <input type="text" class="form-control" name="quantity" placeholder="Enter Quantity">
                    </div><br>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" value="Close" data-dismiss="modal">
                        <input type="submit" name="add" class="btn btn-info" value="Add">
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-inverse navbar-fixed-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    <span class="navbar-brand" id="lab"><?php echo $error; ?></span>
                </div>
                <div class="col-md-2">
                    <span class="navbar-brand" id="lab"><?php echo $error1; ?></span>
                </div>
                <div class="col-md-2">
                    <span class="navbar-brand" id="lab"><?php echo $error2; ?></span>
                </div>
                <div class="col-md-4">
                    <span class="navbar-brand" id="lab"><?php echo $error3; ?></span>
                </div>
                <div class="col-md-2">
                    <span class="navbar-brand" id="lab"><?php echo $error4; ?></span>
                </div>
            </div>
        </div>
    </nav>
    <script src="assets/jquery-1.12.1/external/jquery/jquery.js"></script>
    <script src="assets/bootstrap-4.5.3/dist/js/bootstrap.min.js"></script>
</body>

</html>