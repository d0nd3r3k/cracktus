<?php

session_start();
$username = $_POST['inputUsername'];

$_SESSION['username'] = $username;
/* $mon = new monDB();


  $retrieved = $mon->getUser('keys',array('username' => $username));
  $results = array();

  foreach ($retrieved as $key => $obj) {
  $results[$key]['name'] = $obj['name'];
  $results[$key]['essid'] = $obj['essid'];
  $results[$key]['password'] = $obj['password'];
  $results[$key]['error'] = $obj['error'];
  }
  $response = json_encode($results);
  echo $response; */

$mongoDB = new Mongo();
$database = $mongoDB->selectDB("cracktus");
$collection = $database->createCollection('keys');

$retrieved = $collection->find(array('username' => $username));
$results = array();

foreach ($retrieved as $key => $obj) {
    $results[$key]['name'] = $obj['name'];
    $results[$key]['essid'] = $obj['essid'];
    $results[$key]['password'] = $obj['password'];
    $results[$key]['error'] = $obj['error'];
}
$response = json_encode($results);
echo $response;
?>