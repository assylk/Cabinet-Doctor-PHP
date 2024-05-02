<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['damsid']==0)) {
  header('location:logout.php');
  }

    $eid = $_GET['editid'];
$status = $_GET['sta'];

if ($_GET['sta'] === 'true') {
    $sql = "UPDATE tblsalle SET status='false' WHERE id=:eid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':eid', $eid, PDO::PARAM_STR);
    $query->execute();
    echo "<script>window.location.href ='salle.php'</script>";
} elseif ($_GET['sta'] === 'false') {
    $sql = "UPDATE tblsalle SET status='true' WHERE id=:eid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':eid', $eid, PDO::PARAM_STR);
    $query->execute();
    echo "<script>window.location.href ='salle.php'</script>";
} 









?>