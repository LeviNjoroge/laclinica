<?php
require("../../backend/config/database.php");

// general assessment
if (isset($_POST["general_submit"])) {
    $visit_date = $_POST["visit_date"];
    $gen_health = $_POST["gen_health"] ?? '';
    $on_drugs = $_POST["on_drugs"] ?? '';
    $comments = $_POST["comments"];

    // check the date, if its same as the last one on the system, the record is not stored
    $check_last_date = mysqli_query($conn, "SELECT VISIT_DATE from ASSESSMENT_RECORDS WHERE PATIENT_NUMBER = '$patient_number' AND VISIT_DATE = '$visit_date'");
    if (mysqli_num_rows($check_last_date) > 0) {
        echo "</script>alert('User already registered on that day!')</script>";
    } else {
        // send the data to the database...
        $query = "INSERT INTO ASSESSMENT_RECORDS VALUES('$patient_number', '$visit_date', '$gen_health', '$on_drugs', '$comments')";
        if (mysqli_query($conn, $query)) {
            echo "</script>alert('General assessment successfully recorded!')</script>";
            header("Location: patients_listing.php");
            exit;
        } else {
            echo "</script>alert('Error saving details!')</script>";
        }
    }
}

// overweight assessment logic
if (isset($_POST["overweight_assessment_submit"])) {
    $visit_date = $_POST["visit_date"];
    $gen_health = $_POST["gen_health"] ?? '';
    $been_on_diet = $_POST["been_on_diet"] ?? '';
    $comments = $_POST["comments"];

    // check the date, if its same as the last one on the system, the record is not stored
    $check_last_date = mysqli_query($conn, "SELECT VISIT_DATE from OVERWEIGHT_ASSESSMENT_RECORDS WHERE PATIENT_NUMBER = '$patient_number' AND VISIT_DATE = '$visit_date'");
    if (mysqli_num_rows($check_last_date) > 0) {
        echo '<script> alert("User already registered on that day!" ); </script>';
    } else {
        // send the data to the database...
        $query = "INSERT INTO OVERWEIGHT_ASSESSMENT_RECORDS VALUES('$patient_number', '$visit_date', '$gen_health', '$been_on_diet', '$comments')";
        if (mysqli_query($conn, $query)) {
            echo '<script> alert("General assessment successfully recorded!") </script>';
            header("Location: patients_listing.php");
            exit;
        } else {
            echo '<script> alert("Error saving details!") </script>';
            exit;
        }
    }
}

?>