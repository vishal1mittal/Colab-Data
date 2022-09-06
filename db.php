<?php
$ServerName = "remotemysql.com";
$dbUserName = "P8HY5kV7Pt";
$dbPassword = "1E0v2SslWY";
$dbName = "P8HY5kV7Pt";

$con = mysqli_connect($ServerName, $dbUserName, $dbPassword, $dbName);

if (!$con){
    die("connection Failed: " . mysqli_connect_error());
}

function getData($con){
    $sql = "SELECT * FROM `clients`;";
        $stmt = mysqli_stmt_init($con);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: #?Error=stmtfailed");
            exit();
        }

        mysqli_stmt_execute($stmt);

        $resutData = mysqli_stmt_get_result($stmt);
        $solution = array();
        while ($row = mysqli_fetch_assoc($resutData))
            {
                #print_r($row);
                array_push($solution,$row);
            }
        if($solution){
            return $solution;
        }
        else{
            $result = false;
            return $result;
        }
        mysqli_stmt_close($stmt);
}

function changeData($con,$i,$type){
    $results = getData($con);
    $sql = "UPDATE `clients` SET `IsActive`='".$type."' WHERE `Owner`='".$results[$i]['Owner']."';";
        $stmt = mysqli_stmt_init($con);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: #?Error=stmtfailed");
            exit();
        }

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
}

function inserData($con,$owner,$website,$status){
    $sql = "INSERT INTO `clients` (`Owner`, `Website`, `IsActive`, `Date_Renewed`) VALUES (?, ?, ?, CURRENT_TIMESTAMP);";
    $stmt = mysqli_stmt_init($con);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: #?Error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sss", $owner, $website, $status);
    if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_close($stmt);
        return true;
        exit();
    }
    return false;
    exit();
}

if(isset($_POST['index'])) {
    changeData($con,$_POST['index'],$_POST['type']);
    echo($_POST['type']);
    echo($_POST['index']);
    
  }
