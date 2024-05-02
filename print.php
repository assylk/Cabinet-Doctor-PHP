<?php
require_once 'vendor/autoload.php'; // Include Dompdf autoload file
require('includes/db.php'); // Include database connection file

use Dompdf\Dompdf;

$id = $_GET['id']; 
$query = "SELECT tblfiche.pathologie as pathologie,tblpatient.patientID as patientID,tblfiche.observations as observations,tblfiche.image as image,tblfiche.gender as gender,tblfiche.dob as dob, tblpatient.Name as name, tbldoctor.FullName as FullName FROM tblfiche 
          INNER JOIN tblpatient ON tblfiche.patientID = tblpatient.patientID 
          INNER JOIN tbldoctor ON tblfiche.doctorID = tbldoctor.ID 
          WHERE tblfiche.id='$id' LIMIT 1"; 
$result = mysqli_query($con, $query);

// Check if query execution is successful
if ($result && mysqli_num_rows($result) > 0) {
    $patient = mysqli_fetch_assoc($result);

    // Define doctor's name (this can be retrieved from the database as well)
    $doctorName = $patient['FullName'];
    // Fetch visit records for the patient from tblvisit
        $visitQuery = "select tblordonnance.medic as medic,tblordonnance.creationDate as creationDate,tbldoctor.FullName as docname,tblpatient.Name as pname,tblordonnance.creationDate as creationDate from tblordonnance inner join tbldoctor on tblordonnance.doctorID=tbldoctor.ID inner join tblpatient on tblordonnance.patientID=tblpatient.patientID where tblordonnance.patientID='".$patient['patientID']."' order by tblordonnance.creationDate desc LIMIT 5";

    $visitResult = mysqli_query($con, $visitQuery);

    // Prepare HTML for visit records table rows
    $visitRows = '';
    if ($visitResult && mysqli_num_rows($visitResult) > 0) {
        while ($visit = mysqli_fetch_assoc($visitResult)) {
            $visitRows .= '<tr>';
            $visitRows .= '<td>' . $visit['docname'] . '</td>';
            $visitRows .= '<td>' . $visit['creationDate'] . '</td>';
            $visitRows .= '<td>' . $visit['medic'] . '</td>';
            $visitRows .= '</tr>';
        }
    } else {
        $visitRows = '<tr><td colspan="3">No visit records found</td></tr>';
    }
    // HTML content to be converted to PDF
    $html = '
    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Record</title>
    <style>
    @font-face {
    font-family: "MyCustomSignatureFont";
    src: url("./Cathylise Janetson.otf") format("otf"),
    }
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            padding: 20px;
            line-height: 1.6;
        }
        .patient-record {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            position: relative;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #333;
            text-transform: uppercase;
        }
        .patient-info {
            text-align: left;
            margin-bottom: 20px;
        }
        .patient-info p {
            margin: 5px 0;
            color: #333;
        }
        .patient-image {
            position: absolute;
            top: 20px;
            right: 20px;
            border-radius: 10px;
            border: 5px solid #fff;
            width: 150px;
            height: 150px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .patient-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .content {
            margin-bottom: 20px;
            color: #333;
        }
        .medical-history, .recent-visits {
            margin-bottom: 20px;
        }
        .medical-history h2, .recent-visits h2 {
            font-size: 20px;
            margin-bottom: 10px;
            color: #333;
            text-transform: uppercase;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
            color: #333;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-transform: uppercase;
        }
        .footer {
            text-align: center;
        }
        .footer p {
            margin: 5px 0;
            color: #666;
        }
        .signature {
            margin-top: 20px;
            border-top: 1px solid #ccc;
            padding-top: 10px;
            text-align: center;
        }
        .signature img {
            width: 200px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .signature p {
            margin-top: 10px;
            font-style: italic;
            color: #333;
            text-align: center;
            font-family:MyCustomSignatureFont,cursive;
        }
    </style>
    </head>
    <body>
        <div class="patient-record">
            <div class="header">
                <h1>Patient Record</h1>
            </div>
            <div class="patient-info">
                <p><strong>Patient Name:</strong> ' . $patient['name'] . '</p>
                <p><strong>Date of Birth:</strong> ' . $patient['dob'] . '</p>
                <p><strong>Gender:</strong> ' . $patient['gender'] . '</p>
            </div>
            
            <div class="content">
                <div class="medical-history">
                    <h2>Medical History</h2>
                    <p><strong>Observations:</strong> ' . $patient['observations'] . '</p>
                    <p><strong>Pathologie:</strong> ' . $patient['pathologie'] . '</p>
                </div>
                <div class="recent-visits">
                    <h2>Recent Visits</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Doctor Name</th>
                                <th>Date</th>
                                <th>Medicaments</th>
                            </tr>
                        </thead>
                        <tbody>
                            '. $visitRows . '
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="footer">
                <p><strong>Doctor\'s Signature:</strong></p>
                <div class="signature">
                    <p>' . $doctorName . '</p>
                </div>
            </div>
        </div>
    </body>
    </html>';

    // Create a new Dompdf instance
    $dompdf = new Dompdf();

    // Load HTML content into Dompdf
    $dompdf->loadHtml($html);

    // Set paper size and orientation
    $dompdf->setPaper('A4', 'portrait');

    // Render PDF (generate PDF from HTML)
    $dompdf->render();

    // Output PDF to browser
    $dompdf->stream('patient_record.pdf', array('Attachment' => false));
} else {
    echo "No patient records found";
}
?>