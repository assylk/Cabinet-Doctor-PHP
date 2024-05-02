<?php include "includes/db.php";
$course_id = $_POST['courseId'];
$sql = "select tbldoctor.FullName as doctorName,tblpatient.Name as patientName,tblordonnance.medic as medic,tblordonnance.creationDate as creationDate from tblordonnance inner join tbldoctor on tblordonnance.doctorID=tbldoctor.ID inner join tblpatient on tblordonnance.patientID=tblpatient.patientID where tblordonnance.patientID='$course_id' order by tblordonnance.creationDate desc";
$rs = mysqli_query($con,$sql);
if (mysqli_num_rows($rs) > 0) {
    $count=1;
    while($row=mysqli_fetch_assoc($rs)){
        echo  "<tr>";
        echo  '<td>'.$count.'</td>';
        echo  '<td>'.$row["patientName"].'</td>';
        echo  '<td>'.$row["doctorName"].'</td>';
        echo  '<td>'.$row["medic"].'</td>';
        echo  '<td>'.$row["creationDate"].'</td>';
        echo  "</tr>"; 
        $count++;
    }
}
?>