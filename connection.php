<?php
$servername = "localhost";
$username = "test2";
$password = "";
$dbname = "music";


try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}

$analysis="";

function buildAnalysis($conn,$term,$type){
    $search = "SELECT * FROM wadsongs WHERE $type LIKE '$term'ORDER BY downloads DESC";
    $analysis="";

    foreach ($conn->query($search) as $rowReturn) {
        $title =$rowReturn['song'];
        $artist=$rowReturn['artist'];
        $day = $rowReturn['day'];
        $month = $rowReturn['month'];
        $year = $rowReturn['year'];
        $likes = $rowReturn['likes'];
        $downloads = $rowReturn['downloads'];
        $chart = $rowReturn['chart'];

        $analysis .="['$title', $downloads],";
    }
    return $analysis;
            
}


function searchDatabase($conn,$term,$type){
    $songSearch = '';
    if (isset($_GET['order'])){
        $order = $_GET['order'];
    }else{
        $order = "ID";
    }
        $search = "SELECT * FROM wadsongs WHERE $type LIKE '%$term%' ORDER BY $order DESC";

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

        return $songSearch;
}


function userCreated($conn,$email,$username,$password,$repassword,$dob){
    if ($repassword == $password){
        if (addUser($conn,$username,$password,$email,$dob)){
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}
function addUser($conn,$user,$pass,$fullName,$date){

    $sql = "INSERT INTO clients (username, password, full_name,date_of_birth)
VALUES ('$user', '$pass', '$fullName','$date')";
    print_r($sql);
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }

    $conn->close();
}

function signIn($conn,$user,$pass)
{

    $login = "SELECT count(id) AS 'cli' FROM clients WHERE username='$user' AND password='$pass'";
    foreach ($conn->query($login) as $loginCheck) {
        if ($loginCheck['cli'] == 1) {
            return true;
        } else {
            return false;
        }
    }
}