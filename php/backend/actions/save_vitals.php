<?php
require("../../backend/config/database.php");
require("../../backend/logic/vitals_logic.php");

if (isset($_POST["submit"])) {
    $visit_date = $_POST["visit_date"];
    $height = filter_input(INPUT_POST, "height", FILTER_SANITIZE_NUMBER_INT);
    $weight = filter_input(INPUT_POST, "weight", FILTER_SANITIZE_NUMBER_INT);
    $BMI = calculate_BMI($height, $weight);

    // check the date, if its same as the last one on the system, the record is not stored
    $check_last_date = mysqli_query($conn, "select visit_date from vitals_records where patient_number = '$patient_number'  AND VISIT_DATE = '$visit_date'");
    if (mysqli_num_rows($check_last_date) > 0) {
        echo "<script> alert('User already registered on that day!')</script>";
    } else {
        // send the data to the database...
        $query_update_vitals_records = "INSERT INTO VITALS_RECORDS VALUES('$patient_number', '$visit_date', '$height', '$weight', '$BMI')";
        if (mysqli_query($conn, $query_update_vitals_records)) {
            echo "<script> alert('Vitals successfully recorded!')</script>";
            if ($BMI <= 25) {
                header("Location: ../../general_assessment_form.php");
                exit;
            } else {
                header("Location: ../../overweight_assessment_form.php");
                exit;
            }
        } else {
            echo "<script> alert('There was an error tryng to save the records!')</script>";
        }
    }
}
?>