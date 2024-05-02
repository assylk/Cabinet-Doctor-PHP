<?php 
session_start();
error_reporting(0);
include('includes/dbconnection.php');
include('includes/db.php');


// Initialize variables
$fullName = $email = $specialization = $password = $confirmPassword = $mobileNumber = '';
$fullNameErr = $emailErr = $specializationErr = $passwordErr = $confirmPasswordErr = $mobileNumberErr = '';

// Function to sanitize input data
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $fullName = sanitize_input($_POST["fullName"]);
    $email = sanitize_input($_POST["email"]);
    $specialization = sanitize_input($_POST["specialization"]);
    $password = sanitize_input($_POST["password"]);
    $confirmPassword = sanitize_input($_POST["confirmPassword"]);
    $mobileNumber = sanitize_input($_POST["mobileNumber"]);

    // Validate full name
    if (empty($fullName)) {
        $fullNameErr = "Full name is required";
    }

    // Validate email
    if (empty($email)) {
        $emailErr = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
    }

    // Validate specialization
    if (empty($specialization)) {
        $specializationErr = "Specialization is required";
    }

    // Validate password
    if (empty($password)) {
        $passwordErr = "Password is required";
    }

    // Validate confirm password
    if (empty($confirmPassword)) {
        $confirmPasswordErr = "Please confirm password";
    } elseif ($password != $confirmPassword) {
        $confirmPasswordErr = "Passwords do not match";
    }

    // Validate mobile number (optional)
    if (empty($mobileNumber)) {
        $mobileNumberErr = "Invalid mobile number";
    }

    // If all fields are valid, proceed with registration
    if (empty($fullNameErr) && empty($emailErr) && empty($specializationErr) && empty($passwordErr) && empty($confirmPasswordErr) && empty($mobileNumberErr)) {
        // Check if email already exists in the database
        $checkEmailQuery = "SELECT * FROM tbldoctor WHERE Email = :email";
        $stmt = $dbh->prepare($checkEmailQuery);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            $emailErr = "Email already exists";
        } else {
            // Hash the password

            $hashedPassword = md5($password);

            // Insert user data into the database
            $insertQuery = "INSERT INTO tbldoctor (FullName, Email, Specialization, Password, MobileNumber) VALUES (:fullName, :email, :specialization, :password, :mobileNumber)";
            $stmt = $dbh->prepare($insertQuery);
            $stmt->bindParam(':fullName', $fullName);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':specialization', $specialization);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':mobileNumber', $mobileNumber);
            
            if ($stmt->execute()) {
                $alertMessage = "New record created successfully.Go to login Page";
                //header("Location: login.php");
                // Optionally, redirect user after successful registration
                // header("Location: success.php");
                 //exit();
            } else {
                $alertMessage = "Error: Unable to execute the query.";
            }
        }
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
<style>
/* Style for custom alert */
.custom-alert {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #4CAF50;
    /* Green color by default */
    color: white;
    border-radius: 5px;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    z-index: 9999;
}

.custom-alert p {
    margin: 0;
}

.custom-alert .close-btn {
    position: absolute;
    top: 5px;
    right: 10px;
    cursor: pointer;
}

.custom-alert .close-btn:hover {
    color: black;
}

/* Red background for error */
.custom-alert.error {
    background-color: #f44336;
}
</style>
<body>
    <form class="form" method="post">
        <p class="title">Register </p>
        <p class="message">Signup now and get full access to our app. </p>
        <div class="flex">
            <label>
                <input placeholder="Enter Full Name" value="<?php echo $fullName; ?>" type="text" style="width:300px"
                    name="fullName" class="input">
                <span style="color:red"><?php echo $fullNameErr; ?></span>

            </label>

        </div>

        <label>
            <input placeholder="Enter Email" value="<?php echo $email; ?>" type="email" name="email" style="width:300px"
                class="input">
            <span style="color:red"><?php echo $emailErr; ?></span>
        </label>

        <label>
            <input pattern="[0-9]+" type="text" value="<?php echo $mobileNumber; ?>" placeholder="Enter Mobile Num"
                style="width:300px" name="mobileNumber" class="input">
            <span style="color:red"><?php echo $mobileNumberErr; ?></span>
        </label>
        <label>
            <select class="input" name="specialization">
                <option value="">Select Specialization</option>
                <?php
$sql1="SELECT * from tblspecialization";
$result=mysqli_query($con,$sql1);

$cnt=1;
if(mysqli_num_rows($result) > 0)
{
while($row=mysqli_fetch_assoc($result)){
                  ?>
                <option value="<?php  echo htmlentities($row['ID']);?>">
                    <?php  echo htmlentities($row['Specialization']);?></option>
                <?php $cnt=$cnt+1;}} ?>

            </select>
            <span style="color:red"><?php echo $specializationErr; ?></span>
        </label>
        <label>
            <input placeholder="Enter Password" type="password" name="password" style="width:300px" class="input">
            <span style="color:red"><?php echo $passwordErr; ?></span>
        </label>
        <label>
            <input placeholder="Enter Confirme password" type="password" name="confirmPassword" style="width:300px"
                class="input">
            <span style="color:red"><?php echo $confirmPasswordErr; ?></span>
        </label>

        <button class="submit" name="submit">Submit</button>
        <p class="signin">Already have an acount ? <a href="login.php">Signin</a> </p>
    </form>
    <!-- Custom alert -->
    <div id="customAlert" class="custom-alert">
        <p id="alertMessage"><?php echo $alertMessage; ?>Login <a href="login.php">Now</a></p>
        <span class="close-btn" onclick="hideAlert()">&times;</span>
    </div>
    <script>
    // Show custom alert
    function showAlert(message, isSuccess) {
        var alertBox = document.getElementById('customAlert');
        var alertMessage = document.getElementById('alertMessage');
        alertMessage.textContent = message;
        alertBox.style.display = 'block';
        if (isSuccess) {
            alertBox.classList.remove('error');
        } else {
            alertBox.classList.add('error');
        }
    }

    // Hide custom alert
    function hideAlert() {
        var alertBox = document.getElementById('customAlert');
        alertBox.style.display = 'none';
    }

    // Display alert message if it's not empty
    var alertMessage = '<?php echo $alertMessage; ?>';
    var isSuccess = '<?php echo $alertMessage == "New record created successfully." ? "true" : "false"; ?>';
    if (alertMessage) {
        showAlert(alertMessage, isSuccess);
    }
    </script>
</body>
</html>