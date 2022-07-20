
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="assets/bootstrap-4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/bootstrap-4.5.3/dist/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/loader.css">
    <link rel="icon" href="assets/FAVICON.png" type="text/x-icon">
    <title>Loading...</title>
</head>

<body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
        </div>
    </nav><br><br><br>

    <div class="container" id="loadCont">
        <div class="jumbotron">
            <div class="row">
                <div class="col-sm-2">
                    <div class="loader"></div>
                </div>
                <div class="col-lg-10">
                    <div id="myProgress">
                        <div id="myBar">
                            <div id="label">Loading 10%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-inverse navbar-fixed-bottom">
        <div class="container">
        </div>
        </div>
    </nav>
    <script language="javascript" type="text/javascript">
        var elem = document.getElementById("myBar");
        var width = 1;
        var id = setInterval(frame, 20);

        function frame() {
            if (width >= 100) {
                window.location = "login.php";
            } else {
                width++;
                elem.style.width = width + '%';
                document.getElementById("label").innerHTML = 'Loading ' + width * 1 + '%';
            }
        }
    </script>
    <script src="assets/jquery-1.12.1/external/jquery/jquery.js"></script>
    <script src="assets/bootstrap-4.5.3/dist/js/carousel.js"></script>
    <script src="assets/bootstrap-4.5.3/dist/js/bootstrap.min.js"></script>
</body>

</html>