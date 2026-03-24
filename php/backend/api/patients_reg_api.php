<?php
session_start();
require("../");

if(isset($_POST["submit"])){
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];
    $date_of_birth = $_POST['date_of_birth'];
    $patient_number = $_POST['patient_number'];
    $reg_date = $_POST['reg_date'];

    $query_insert_data_into_patients_reg_table = "INSERT INTO PATIENTS_REGISTRATION VALUES('$patient_number', '$first_name','$middle_name','$last_name', '$gender', '$date_of_birth', '$reg_date')";

    $insert_data_into_patients_reg_table = mysqli_query($conn, $query_insert_data_into_patients_reg_table);
}
?>