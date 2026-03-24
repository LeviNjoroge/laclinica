<?php
session_start();
require("./backend/config/database.php");

if (isset($_POST["submit"])) {
    $first_name = filter_input(INPUT_POST,'first_name',FILTER_SANITIZE_SPECIAL_CHARS);
    $middle_name = filter_input(INPUT_POST,'middle_name',FILTER_SANITIZE_SPECIAL_CHARS);
    $last_name = filter_input(INPUT_POST,'last_name',FILTER_SANITIZE_SPECIAL_CHARS);
    $gender = $_POST['gender'];
    $date_of_birth = $_POST['date_of_birth'];
    $patient_number = filter_input(INPUT_POST,'patient_number',FILTER_SANITIZE_NUMBER_INT);
    $reg_date = $_POST['registration_date'];

    // check if patient already exists
    $check_patient = mysqli_query($conn, "SELECT * FROM PATIENTS_REGISTRATION WHERE patient_number = '$patient_number'");
    if (mysqli_num_rows($check_patient) > 0) {
        echo '<script> alert("Patient already registered!") </script>';
    } else {
        $query_insert_data_into_patients_reg_table = "INSERT INTO PATIENTS_REGISTRATION VALUES('$patient_number', '$first_name','$middle_name','$last_name', '$gender', '$date_of_birth', '$reg_date')";
        $insert_data_into_patients_reg_table = mysqli_query($conn, $query_insert_data_into_patients_reg_table);
        echo '<script> alert("Patient registered successfully!") </script>';
    }
    $_SESSION["first_name"] = $first_name;
    $_SESSION["middle_name"] = $middle_name;
    $_SESSION["last_name"] = $last_name;
    $_SESSION["patient_number"] = $patient_number;

    header("Location: ./vitals_form.php");
    exit;
}

if (isset($_POST["cancel"])) {
    header("Location: ./");
}
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
    <div class="container">
        <h2>Patient Registration Form</h2>
        <form method="POST">
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
                <input type="radio" name="gender" id="Male" value="Male"> Male
                <input type="radio" name="gender" id="Female" value="Female"> Female
            </div>

            <div class="date_of_birth">
                <label for="date_of_birth">Date of birth: </label>
                <input type="date" name="date_of_birth" id="date_of_birth" required>
            </div>

            <div class="patient_number">
                <label for="patient_number">Patient Number:</label>
                <input type="number" name="patient_number" id="patient_number" required>
            </div>

            <div class="reg_date">
                <label for="registration_date">Registration Date:</label>
                <input type="date" name="registration_date" id="registration_date" required>
            </div>

            <input type="button" value="Cancel" id="cancel_button" onclick="clearForm()">

            <input type="submit" value="Submit" id="submit_button" name="submit">
        </form>
    </div>
    <script>
        function clearForm() {
            document.querySelector("form").reset();
        }
    </script>
</body>

</html>