<?php
session_start();
require("../../backend/config/database.php");

if (isset($_POST["submit"])) {
    $first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_SPECIAL_CHARS);
    $middle_name = filter_input(INPUT_POST, 'middle_name', FILTER_SANITIZE_SPECIAL_CHARS);
    $last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_SPECIAL_CHARS);
    $gender = $_POST['gender'];
    $date_of_birth = $_POST['date_of_birth'];
    $patient_number = filter_input(INPUT_POST, 'patient_number', FILTER_SANITIZE_NUMBER_INT);
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

    header("Location: ../../vitals_form.php");
    exit;
}

?>