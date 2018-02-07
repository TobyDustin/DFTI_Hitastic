<?php
session_start();
if (isset($_SESSION['code'])){

}else{
    header('Location: client.php');
}
?>
<!doctype html>
<html lang="en">
<?php
require 'connection.php';
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hitastic</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <?php
    $d = getdate();
    $m = $d['mon'];
    if ($m<6){
        $style="winter";
    }else{
        $style="summer";
    }
    ?>
    <link rel="stylesheet" href="<?php echo$style ?>.css?version=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">



    <?php
    if (isset($term)){
        $term = $_GET['term'];
    }else{
        $term = $_GET['term'];
    }
    ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
        function showUser() {
            var str = document.getElementById("searchTerm").value;
            if (str.includes('--')){
                str ="";
                document.getElementById("searchTerm").innerHTML="";
            }
            if (str.includes(';')){
                str ="";
                document.getElementById("searchTerm").innerHTML="";
            }
            var e = document.getElementById("typeSelect");
            var strType = e.options[e.selectedIndex].text;
            var d = document.getElementById("orderSelect");
            var strOrder = d.options[d.selectedIndex].text;
            if (str == "") {
                document.getElementById("txtHint").innerHTML = "";
                return;
            } else {
                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else {
                    // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("txtHint").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET","ajaxTest.php?term="+str+"&type="+strType+"&order="+strOrder,true);
                xmlhttp.send();
            }
        }
    </script>

</head>
<body onresize="changeText()" onload="changeText()">


<header>
    <a href="client.php" id="logout">Logout</a>
    <img src="logo.png">
    <form action='index.php' method='get'>
        <div class='form-group'>
            <span>Search for...</span><br />
            <input type='text' class='form-control' autofocus value="<?php echo $term;?>" name='term' id='searchTerm' placeholder='Search...' oninput="showUser()">
            <select style="display: none" class="select-style" name="type" id="typeSelect" onchange="showUser()">
                <option name="song" value="song">Song</option>
                <option name="artist" value="artist">Artist</option>
                <option name="year" value="year">Year</option>
            </select>
            <br />
            <span>Order By...</span><br />
            <select class="select-style" name="order" id="orderSelect" onchange="showUser()">
                <option name="artist" value="Artist">Artist</option>
                <option name="song" value="Song">Song</option>
                <option name="likes" value="Likes">Likes</option>
                <option name="downloads" value="Downloads">Downloads</option>
                <option name="year" value="Year">Release Year</option>
            </select>
        </div>
<!--        <button type='submit' class='btn btn-primary'>Search!</button>-->
    </form>
</header>

<?php ?>

<div id="txtHint">
    <video autoplay muted loop id="myVideo" style="position: fixed;right: 0;bottom: 0;min-width: 100%;min-height: 100%; z-index: -100;">
        <source src="forDFTI.mp4" type="video/mp4">
    </video>
    <div style="width: 30vw; margin: 0 auto;">

    <h1 style="font-size: 48pt; color: #FFFFFF">Search for...</h1>
    </div>
    <div style="border-color: #fff; border-style: solid; border-width: 1px; width: 40vw; margin: 0 auto;">

    <h1 style="font-size: pt;">
        <?php $songCarosel= randomSongGetter($conn);?>

        <a id="typer" href="#" style="color: #ffffff" class="typewrite" data-period="2000" data-type='<?php echo $songCarosel?>'>
            <span class="wrap"></span>
        </a>
    </h1>


</div>



<script src="script.js"></script>

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</body>
</html>