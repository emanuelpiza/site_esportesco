<?php
session_start();
ob_start();

include('dbcon/dbcon.php');




if (!isset($_SESSION["signin"])) {
    $_SESSION["error1"] = "<strong>Please Sign in </strong>";
    header("Location: index.php");
}

if (isset($_POST["sign_out"])) {
    unset($_SESSION["signin"]);

    $_SESSION["sout"] = "<strong>Successfully Sign out </strong>";
    header("Location: index.php");
}



if (isset($_SESSION["nps"])) {
    echo '
			<div class="alert alert-info alert-dismissible" role="alert" style="margin:0">
			  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			  <strong>' . $_SESSION["nps"] . '</strong> 
			</div>';
    unset($_SESSION["nps"]);
} if (isset($_SESSION["nper"])) {
    echo '
			<div class="alert alert-warning alert-dismissible" role="alert" style="margin:0">
			  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			  <strong>' . $_SESSION["nper"] . '</strong> 
			</div>';
    unset($_SESSION["nper"]);
}
if (isset($_SESSION["npcer"])) {
    echo '
			<div class="alert alert-warning alert-dismissible" role="alert" style="margin:0">
			  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			  <strong>' . $_SESSION["npcer"] . '</strong> 
			</div>';
    unset($_SESSION["npcer"]);
}



//videos upload 


if (isset($_SESSION["vs"])) {
    echo '
			<div class="alert alert-info alert-dismissible" role="alert" style="margin:0">
			  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			  <strong>' . $_SESSION["vs"] . '</strong> 
			</div>';
    unset($_SESSION["vs"]);
}

if (isset($_SESSION["ver"])) {
    echo '
			<div class="alert alert-warning alert-dismissible" role="alert" style="margin:0">
			  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			  <strong>' . $_SESSION["ver"] . '</strong> 
			</div>';
    unset($_SESSION["ver"]);
}


//upload massage

if (isset($_SESSION["upload"])) {
    echo '
			<div class="alert alert-warning alert-dismissible" role="alert" style="margin:0">
			  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			  <strong>' . $_SESSION["upload"] . '</strong> 
			</div>';
    unset($_SESSION["upload"]);
}
if (isset($_SESSION["uploadok"])) {
    echo '
			<div class="alert alert-info alert-dismissible" role="alert" style="margin:0">
			  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			  <strong>' . $_SESSION["uploadok"] . '</strong> 
			</div>';
    unset($_SESSION["uploadok"]);
}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SportsTech</title>

        <!-- Bootstrap -->
        <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet"> 
        <script src="../js/jquery.min.js" type="text/javascript"></script>

        <!--upload-->
        <script type="text/javascript" src="uploadfiles/js/jquery.js"></script>
        <script type="text/javascript" src="uploadfiles/js/ajaxupload-min.js"></script>

        <!-- ********************************** textarea length ************************ -->
        <script language="javascript" type="text/javascript">
            function limitText(limitField, limitCount, limitNum) {
                if (limitField.value.length > limitNum) {
                    limitField.value = limitField.value.substring(0, limitNum);
                } else {
                    limitCount.value = limitNum - limitField.value.length;
                }
            }
        </script>
        <!-- ********************************** end textarea length ************************ -->

        <link rel="stylesheet" type="text/css" media="all" href="date/jsDatePick_ltr.min.css" />

        <script type="text/javascript" src="date/jsDatePick.min.1.3.js"></script>

        <script type="text/javascript">
            window.onload = function() {
                new JsDatePick({
                    useMode: 2,
                    target: "inputField",
                    dateFormat: "%M-%d-%Y"

                });
                new JsDatePick({
                    useMode: 2,
                    target: "inputField2",
                    dateFormat: "%M-%d-%Y"

                });
            };



        </script>


    </head>
    <body>

        <div class="container-fluid"> 

            <div class="row">
                <nav class="navbar navbar-inverse navbar-static-top" role="navigation">
                    <div class="container">
                        <div class="navbar-header">

                            <a class="navbar-brand" href="#">SportsTech Admin Panel</a>
                        </div> <!-- end navbar-header -->

                        <div class="collapse navbar-collapse" id="navigation1">
                            <ul class="nav navbar-nav">



                            </ul>
                            <form action="" method="post">
                                <button type="submit" name="sign_out" class="btn navbar-btn pull-right btn-default"><span class="glyphicon glyphicon-off"></span> Sign Out</button>
                            </form>

                        </div>  
                    </div> 
                </nav> 
            </div> 

            <div class="row">
                <div class="col-lg-4">
                    <h3> Add New Sports &  News  </h3>
                    <hr>
                    <form action="upload_file.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>News Header </label>
                            <input type="text" name="head" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>description</label>
                            <textarea style="resize: none" name="dis" class="form-control" required onKeyDown="limitText(this.form.dis, this.form.countdown, 324);" 
                                      onKeyUp="limitText(this.form.dis, this.form.countdown, 324);"></textarea>
                            <font size="1">(Maximum characters: 324)<br>
                            You have <input readonly type="text" name="countdown" size="3" value="324"> characters left.</font>
                        </div>
                        <div class="form-group">
                            <label>Date</label>
                            <input value="<?php echo date("Y-m-d"); ?>" name="date" type="date" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Upload Picture</label>
                            <input type="file" name="fileToUpload" id="fileToUpload" required>
                            <p class="help-block">png , jpg , jpeg , gif  ( Image Resolution must 370x320)</p>
                        </div>
                        <button type="submit" name="upload" class="btn btn-default">Submit</button>
                    </form>


                </div>



                <div class="col-lg-4">
                    <h3> Add Videos For Slider </h3>
                    <hr>
                    <form action="upload_file.php" method="post"> 
                        <div class="form-group">
                            <label>Video Path Past here </label>
                            <textarea name="path" style="resize: none"class="form-control" required></textarea>
                        </div> 
                        <button type="submit" name="video" class="btn btn-default">Submit</button>
                    </form>


                </div>


                <div class="col-lg-4">
                    <h3> Change Your admin password  </h3>
                    <hr>
                    <form action="upload_file.php" method="post">
                        <div class="form-group">
                            <label>Old Password</label>
                            <input  type="password" name="olpw"class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>New Password</label>
                            <input  type="password" name="newpw"class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>New Password Confirmation</label>
                            <input  type="password" name="cnpw"class="form-control" required>
                        </div>

                        <button type="submit" name="change" class="btn btn-default">Submit</button>
                    </form>


                </div>
            </div>


            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> 
            <script src="js/bootstrap.min.js"></script>
    </body>
</html>