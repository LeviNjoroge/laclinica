<?php 
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Patient Registration Form</title>
</head>
<body>
    <h2>Patient Registration Form</h2>
    <form>
        <div class="first_name">
            <label for="first_name">First Name:</label>
            <input name="first_name" id="first_name" placeholder="Joe" required>
        </div>

        <div class="middle_name">
            <label for="middle_name">Middle Name:</label>
            <input name="middle_name" type="text" id="middle_name" placeholder="Bloggs">
        </div>

        <div class="last_name">
            <label for="last_name">Last Name:</label>
            <input name="last_name" type="text" id="last_name" placeholder="Doe" required>
        </div>

        <div class="gender">
            <label for="gender">Gender:</label>
            <input type="radio" name="gender" id="Male" value="male"> Male
            <input type="radio" name="gender" id="Female" value="female"> Female
        </div>

        <div class="date_of_birth">
            <label for="date_of_birth">Date of birth: </label>
            <input type="date" name="date" id="date" required>
        </div>

        <div class="patient_number">
            <label for="patient_number">Patient Number:</label>
            <input type="number" name="patient_number" id="patient_number" required>
        </div>

        <div class="reg_date">
            <label for="registration_date">Registration Date:</label>
            <input type="date" name="registration_date" id="registration_date" required>
        </div>

        <input type="button" value="Cancel" id="cancel_button">
        
        <input type="button" value="Submit" id="submit_button">
    </form>
    
</body>
</html>