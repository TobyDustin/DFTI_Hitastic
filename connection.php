<?php
$servername = "localhost";
$username = "hittastic";
$password = "password";
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
        //$search = "SELECT * FROM wadsongs WHERE $type LIKE '%$term%' ORDER BY $order DESC";
    $stmt = $conn->prepare("SELECT * FROM wadsongs WHERE ? LIKE '%?%' ORDER BY ? DESC");

    $stmt->bindParam(1,$type);
    $stmt->bindParam(2,$term);
    $stmt->bindParam(3,$order);
    $stmt->execute(); // DELETE THIS AFTERWARDS
    while($rowReturn=$stmt->fetch()){
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
    $sql = "INSERT INTO clients (username, password, full_name,date_of_birth) VALUES (:user, :pass, :fullname,:date)";

    $stmt = $conn->prepare($sql);

//Bind the provided username to our prepared statement.
    $stmt->bindValue(':user', $user);
    $stmt->bindValue(':pass', $pass);
    $stmt->bindValue(':fullname',$fullName);
    $stmt->bindValue(':date',$date);

//Execute.
    $stmt->execute();

//    $sql = "INSERT INTO clients (username, password, full_name,date_of_birth)
//VALUES ('$user', '$pass', '$fullName','$date')";
//    if ($conn->query($sql) === TRUE) {
//        return true;
//    } else {
//        return false;
//    }
//
//    $conn->close();
}

function signIn($conn,$user,$pass)
{
   // echo "<script>alert('$pass');</script>";
    $stmt = $conn->prepare("SELECT count(id) as cli FROM clients WHERE username=:user AND password=:pass");
    $stmt->bindParam(":user",$user);
    $stmt->bindParam(":pass",$pass);
    $stmt->execute();
    //echo "<script>alert('$hashed');</script>";
    while($loginCheck=$stmt->fetch()){
        $l =$loginCheck['cli'];
      //  echo "<script>alert('$l');</script>";
        if ($loginCheck['cli'] ==1) {
            //echo "<script>alert('working');</script>";
            return true;
        }else{
            return false;
        }
    }

    return false;
}