<!DOCTYPE html>
<html>
<head>
    <style>
    #songTable{
        width: 75%;
    }
    </style>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<?php
require 'connection.php';
$term = ($_GET['term']);
//$type = ($_GET['type']);
$order = ($_GET['order']);
//if (strpos($term,"--")){
//    $search="";
//}elseif (strpos($term,";")){
//    $search="";
//}else{
//}
//
//}
$songSearch="";
$search = "SELECT count(*) as c FROM wadsongs WHERE artist LIKE '%$term%' OR song LIKE '%$term%' OR year LIKE '%$term%'";
foreach ($conn->query($search) as $rowReturn) {
   $c= $rowReturn['c'];
   $t = time();
$songSearch .="<p>$c results returned.</p>";
}
$search = "SELECT * FROM wadsongs WHERE artist LIKE '%$term%' OR song LIKE '%$term%' OR year LIKE '%$term%'ORDER BY $order DESC";

echo "<table id='songTable' class='table'>
        <tr>
            <th scope='col'>Artist</th>
            <th scope='col'>Song</th>
            <th scope='col'>Likes</th>
            <th scope='col'>Downloads</th>
            <th scope='col'>Chart</th>
            <th scope='col'>Release Date</th>
            <th scope='col'>Listen</th>
            <th scope='col'>Download</th>

        </tr>";
foreach ($conn->query($search) as $rowReturn) {
    $title =$rowReturn['song'];
    $titleQuery = str_replace(" ",'+',$title);
    $artist=$rowReturn['artist'];
    $artistQuery = str_replace(" ",'+',$artist);
    $day = $rowReturn['day'];
    $month = $rowReturn['month'];
    $year = $rowReturn['year'];
    $likes = $rowReturn['likes'];
    $downloads = $rowReturn['downloads'];
    $chart = $rowReturn['chart'];
    $downloadHREF= "'https://www.amazon.co.uk/s/ref=nb_sb_noss_1?url=search-alias%3Ddigital-music&field-keywords=$artistQuery+$titleQuery'";
    $titleHREF= "'https://www.youtube.com/results?search_query=$artistQuery+$titleQuery'";
    $date = gmdate("d-M-y",strtotime($day."-".$month."-".$year));
    $songSearch .= "
            <tr >
            <td>$artist</td>
            <td>$title</td>
            <td>$likes</td>
            <td>$downloads</td>
            <td>$chart</td>
            <td>$date</td>
            <td><a target='_blank' href=$titleHREF>$title</a></td>
            <td><a target='_blank' href=$downloadHREF>$title</a> </td>

        </tr>
            ";
}
echo $songSearch;
echo "</table>";
mysqli_close($conn);
?>
</body>
</html>