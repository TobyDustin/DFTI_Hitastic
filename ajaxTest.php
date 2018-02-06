<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, td, th {
            border: 1px solid black;
            padding: 5px;
        }

        th {text-align: left;}
    </style>
</head>
<body>

<?php
require 'connection.php';
$term = ($_GET['term']);
$type = ($_GET['type']);
$order = ($_GET['order']);
//if (strpos($term,"--")){
//    $search="";
//}elseif (strpos($term,";")){
//    $search="";
//}else{
//}
//
//}
$search = "SELECT * FROM wadsongs WHERE $type LIKE '%$term%' ORDER BY $order DESC";
$songSearch="";
echo "<table id='songTable'>
        <tr>
            <th>Artist</th>
            <th>Song</th>
            <th>Likes</th>
            <th>Downloads</th>
            <th>Chart</th>
            <th>Release Date</th>
            <th>Listen</th>
            <th>Download</th>

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
    $songSearch .= "
            <tr >
            <td>$artist</td>
            <td>$title</td>
            <td>$likes</td>
            <td>$downloads</td>
            <td>$chart</td>
            <td>$day-$month-$year</td>
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