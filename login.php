<?php

session_start();
error_reporting(0);
include('includes/dbconnection.php');

if(isset($_POST['login'])) 
  {
    $email=$_POST['email'];
    $password=md5($_POST['password']);
    $sql ="SELECT * FROM tbldoctor WHERE Email=:email and Password=:password";
    $query=$dbh->prepare($sql);
    $query->bindParam(':email',$email,PDO::PARAM_STR);
    $query-> bindParam(':password', $password, PDO::PARAM_STR);
    $query-> execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
    if($query->rowCount() > 0)
{
foreach ($results as $result) {
$_SESSION['damsid']=$result->ID;
$test=$result->Role;
$_SESSION['image']=$result->image;

$_SESSION['damsemailid']=$result->Email;
$_SESSION['damsfullname']=$result->FullName;


}
if($test=="doctor"){
$_SESSION['login']=$_POST['email'];
$_SESSION['type']="Doctor";
echo "<script type='text/javascript'> document.location ='dashboard.php'; </script>";
exit();
}else if($test=="secretaire"){
    $_SESSION['type']= "Secretaire";
echo "<script type='text/javascript'> document.location ='dashboard.php'; </script>";
exit();

}else if($test=="admin"){
    $_SESSION['type']= "Admin";
    echo "<script type='text/javascript'> document.location ='dashboard.php'; </script>";
    exit();
}
else{
echo "<script>alert('Role NOT YET UPDATED');</script>";

}


} else{
echo "<script>alert('Invalid Details');</script>";
}
}






?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/register.css">
</head>
<body>
    <form class="form" method="post" name="login">
        <p class="title">Login </p>
        <p class="message">Signin now and get full access to our app. </p>


        <label>
            <input required placeholder="" name="email" type="email" style="width:300px" class="input">
            <span>Email</span>
        </label>

        <label>
            <input required placeholder="" type="password" name="password" style="width:300px" class="input">
            <span>Password</span>
        </label>

        <button class="submit" name="login">Submit</button>
        <p class="signin">Already have an acount ? <a href="register.php">Signup</a> </p>
    </form>
</body>
</html>