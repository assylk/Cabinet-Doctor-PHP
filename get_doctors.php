<?php
include('includes/dbconnection.php');
if(!empty($_POST["sp_id"])) 
{
$spid=$_POST["sp_id"];
$sql=$dbh->prepare("SELECT * FROM tbldoctor WHERE Specialization=:spid");
$sql->execute(array(':spid' => $spid));	
?>
<li value="">Doctor</li>

<?php
while($row =$sql->fetch())
{
?>
<li value="<?php echo $row["ID"]; ?> "><?php echo $row["FullName"]; ?></li>
<?php
}
}
?>