<?php
require_once("session.php");
$Uresult = mysqli_query($connect_db, "SELECT * FROM account ORDER BY id Asc");
$Ures = mysqli_fetch_array($Uresult);
$_SESSION['id'] =  $Ures['id'];
$result = mysqli_query($connect_db, "SELECT student.id, student.name, student.course, student.yearSection, account.accountType, account.dateCreated,account.dateModified FROM student, account WHERE student.id = account.id ORDER BY student.id");
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
    <title>Users</title>
    <style>
        .navbar-right {
            margin-top: 3px;
        }
    </style>
</head>

<body>
    <nav class="nav navbar-inverse navbar-fixed-top">
        <div class="container">
            <label class="navbar-brand">Library -> Users</label>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
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
                    <table width="100%" class="table table-bordered table-bordered">
                        <thead>
                            <tr>
                                <th class="theader">Name</th>
                                <th class="theader">Course</th>
                                <th class="theader">Year and Section</th>
                                <th class="theader">Account Type</th>
                                <th class="theader">Date Created</th>
                                <th class="theader">Date Modified</th>
                                <th class="theader" colspan="3">Settings</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($res = mysqli_fetch_array($result)) {

                                echo "<tr class='tr2'>";
                                echo "<td class='td1'>" . $res['name'] . "</td>";
                                echo "<td class='td1'>" . $res['course'] . "</td>";
                                echo "<td class='td1'>" . $res['yearSection'] . "</td>";
                                echo "<td class='td1'>" . $res['accountType'] . "</td>";
                                echo "<td class='td1'>" . $res['dateCreated'] . "</td>";
                                echo "<td class='td1'>" . $res['dateModified'] . "</td>";
                                echo "<td class='td1'><a class='btn btn-primary btn-md' href=\"update.php?id=$res[id]\"><i class='glyphicon glyphicon-open'>Update</i></a></td>  <td class='td1'> <a class='btn btn-danger btn-md' id='del' data-name='$res[name]' data-id='$res[id]' onCLick='confirmDelete(this);'><i class='glyphicon glyphicon-trash'>Delete</i></a></td><td class='td1'><a class='btn btn-warning btn-md' href=\"upPass.php?id=$res[id]\"><i class='fa fa-lock'>Update Password</i></a></td>";
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
                    <h4 class="modal-title">Do you want to delete this user?</h4>
                </div>
                <form method="GET" action="delete.php?" id="delete-user">
                    <input type="hidden" name="id">
                    <div class="input-group">
                        <span class="input-group-addon"><i>Name</i></span>
                        <input type="text" class="form-control" name="name" disabled>
                    </div><br>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" form="delete-user" class="btn btn-danger">Delete</button>
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
        function confirmDelete(self) {
            var id = self.getAttribute("data-id");
            var name = self.getAttribute("data-name");

            document.getElementById("delete-user").id.value = id;
            document.getElementById("delete-user").name.value = name;
            $("#MyModal").modal("show");

        }
    </script>
    <script src="assets/jquery-1.12.1/external/jquery/jquery.js"></script>
    <script src="assets/bootstrap-4.5.3/dist/js/bootstrap.min.js"></script>
</body>

</html>