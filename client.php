<?php
require 'connection.php';
session_start();
$_SESSION=[];
session_destroy();
if (isset($_POST['confirmsignup'])){
    $email = $_POST['Email'];
    $username = $_POST['userid'];
    $password = hash('SHA512',$_POST['password']);
    $repassword = hash('SHA512',$_POST['reenterpassword']);
    $dob = $_POST['dob'];
    if (userCreated($conn,$email,$username,$password,$repassword,$dob)){
        echo "<script>alert('thank you for signing up.');</script>";
    }else{
        echo "<script>alert('thank you for signing up.');</script>";
    }
}
if (isset($_POST['signin'])){
    $email = $_POST['userid'];
    $pass = hash('SHA512',$_POST['passwordinput']);

    if (signIn($conn,$email,$pass)){
        session_start();
        $_SESSION['code']=true;
        header("Location: index.php");

    }else{
        echo "<script>alert('Sorry, No user found.');</script>";
    }
}

?>

<html>
<head>
    <style>
        body{
            background: linear-gradient(to right, #00FFFF 49%, #FF00FF 51%);
        }
        .container{
            background: linear-gradient(to right,#00FFFF,#FF00FF);
            width: 100vw;
            padding-left: 0px;
            height: 100vh;
            text-align: center;
        }

        .modal-content{
            background: linear-gradient(#00FFFF,#FF00FF);
        }
        #start{
            background: linear-gradient(to left,#00FFFF,#FF00FF);
            border: none;
            color: black;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 28px;
        }
        #confirmsignup{
            background: linear-gradient(to left,#00FFFF,#FF00FF);
            border: none;
            color: black;
        }
        #signinb{
            background: linear-gradient(to left,#00FFFF,#FF00FF);
            border: none;
            color: black;
        }

        */ Color line credit to ninjamonk: [[http://bootsnipp.com/snippets/featured/mix-amp-match-login]]
    </style>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<body>
<div class="container">
        <h1>Welcome to</h1>
    <br/>
    <img src="logo.png">
    <br />
    <h2>To use our service, please sign in first</h2>
    <br />
        <button id= "start" class="btn btn-primary btn-lg" href="#signup" data-toggle="modal" data-target=".bs-modal-sm">Sign In / Register</button>

    <br>

</div>


<!-- Modal -->
<div class="modal fade bs-modal-sm" id="myModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <br>
            <div class="bs-example bs-example-tabs">
                <ul id="myTab" class="nav nav-tabs">
                    <li class="active"><a href="#signin" data-toggle="tab">Sign In</a></li>
                    <li class=""><a href="#signup" data-toggle="tab">Register</a></li>
                </ul>
            </div>
            <div class="modal-body">
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="signin">
                        <form class="form-horizontal" action="client.php" method="post">
                            <fieldset>
                                <!-- Sign In Form -->
                                <!-- Text input-->
                                <div class="control-group">
                                    <label class="control-label" for="userid">Username:</label>
                                    <div class="controls">
                                        <input required="" id="userid" name="userid" type="text" class="form-control" placeholder="username" class="input-medium" required="">
                                    </div>
                                </div>

                                <!-- Password input-->
                                <div class="control-group">
                                    <label class="control-label" for="passwordinput">Password:</label>
                                    <div class="controls">
                                        <input required="" id="passwordinput" name="passwordinput" class="form-control" type="password" placeholder="password" class="input-medium">
                                    </div>
                                </div>


                                <!-- Button -->
                                <div class="control-group">
                                    <label class="control-label" for="signin"></label>
                                    <div class="controls">
                                        <button id="signinb" name="signin" class="btn btn-success">Sign In</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="signup">
                        <form class="form-horizontal" action="client.php" method="post">
                            <fieldset>
                                <!-- Sign Up Form -->
                                <!-- Text input-->
                                <div class="control-group">
                                    <label class="control-label" for="Email">Email:</label>
                                    <div class="controls">
                                        <input id="Email" name="Email" class="form-control" type="text" placeholder="email" class="input-large" required>
                                    </div>
                                </div>

                                <!-- Text input-->
                                <div class="control-group">
                                    <label class="control-label" for="userid">Username:</label>
                                    <div class="controls">
                                        <input id="userid" name="userid" class="form-control" type="text" placeholder="username" class="input-large" required>
                                    </div>
                                </div>

                                <!-- Password input-->
                                <div class="control-group">
                                    <label class="control-label" for="password">Password:</label>
                                    <div class="controls">
                                        <input id="password" name="password" class="form-control" type="password" placeholder="password" class="input-large" required>
                                        <em>1-8 Characters</em>
                                    </div>
                                </div>

                                <!-- Text input-->
                                <div class="control-group">
                                    <label class="control-label" for="reenterpassword">Re-Enter Password:</label>
                                    <div class="controls">
                                        <input id="reenterpassword" class="form-control" name="reenterpassword" type="password" placeholder="password" class="input-large" required>
                                    </div>
                                </div>

                                <!-- Text input-->
                                <div class="control-group">
                                    <label class="control-label" for="dob">Date Of Birth:</label>
                                    <div class="controls">
                                        <input id="dob" class="form-control" name="dob" type="date" placeholder="DD/MM/YYYY" class="input-large" required>
                                    </div>
                                </div>

                                <!-- Multiple Radios (inline) -->
                                <br>

                                <!-- Button -->
                                <div class="control-group">
                                    <label class="control-label" for="confirmsignup"></label>
                                    <div class="controls">
                                        <button id="confirmsignup" name="confirmsignup" class="btn btn-success">Sign Up</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <center>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </center>
            </div>
        </div>
    </div>
</div>
</body>
</html>