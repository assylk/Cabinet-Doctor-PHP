<?php include "includes/db.php";
$course_id = $_POST['courseId'];
$sql = "select * from tblappointment where ID = '$course_id'";
$rs = mysqli_query($con,$sql);
if (mysqli_num_rows($rs) > 0) {
	$row = mysqli_fetch_array($rs);
        echo "<input name='idstat' value=".$row['ID']." type='hidden'>";

    if($row["Status"] == 'Approved'){
        echo "<option value=".$row['Status']." selected>".$row['Status']."</option>";
        echo "<option value='Cancelled'>Cancelled</option>";
    }else if($row["Status"] == 'Cancelled'){
        echo "<option value=".$row['Status']." selected>".$row['Status']."</option>";
        echo "<option value='Approved'>Approved</option>";
    }
    

}

if(isset($_POST['changeStat'])){
        $status=$_POST['status'];
        $check=mysqli_query($con,"select * from tblappointment where ID='$course_id'");
    }
?>