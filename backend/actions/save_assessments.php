<?php
require("../../backend/config/database.php");
require("../../backend/logic/assessment_logic.php");

if (isset($_POST["submit"])) {
    $form_type = $_POST["form_type"];

    // general assessment
    if ($form_type === "general") {
        $visit_date = $_POST["visit_date"];
        $gen_health = $_POST["gen_health"] ?? '';
        $on_drugs = $_POST["on_drugs"] ?? '';
        $comments = filter_input(INPUT_POST, 'comments', FILTER_SANITIZE_SPECIAL_CHARS);

        // check the date, if its same as the last one on the system, the record is not stored
        $check_last_date = mysqli_query($conn, "SELECT VISIT_DATE FROM ASSESSMENT_RECORDS WHERE PATIENT_NUMBER = '$patient_number' AND VISIT_DATE = '$visit_date'");
        if (mysqli_num_rows($check_last_date) > 0) {
            $message = 'User already registered on that day!';
        } else {
            // send the data to the database...
            $query = "INSERT INTO ASSESSMENT_RECORDS VALUES('$patient_number', '$visit_date', '$gen_health', '$on_drugs', '$comments')";
            if (mysqli_query($conn, $query)) {
                $message = 'General assessment successfully recorded!';
                header("Location: ../../patients_listing.php");
                exit;
            } else {
                $message = 'Error saving details!';
            }
        }
    }

    // overweight assessment logic
    } elseif ($form_type === "overweight") {
        $visit_date = $_POST["visit_date"];
        $gen_health = $_POST["gen_health"] ?? '';
        $been_on_diet = $_POST["been_on_diet"] ?? '';
        $comments = $_POST["comments"];

        // check the date, if its same as the last one on the system, the record is not stored
        $check_last_date = mysqli_query($conn, "SELECT VISIT_DATE from OVERWEIGHT_ASSESSMENT_RECORDS WHERE PATIENT_NUMBER = '$patient_number' AND VISIT_DATE = '$visit_date'");
        if (mysqli_num_rows($check_last_date) > 0) {
            $message = "User already registered on that day!";
        } else {
            // send the data to the database...
            $query = "INSERT INTO OVERWEIGHT_ASSESSMENT_RECORDS VALUES('$patient_number', '$visit_date', '$gen_health', '$been_on_diet', '$comments')";
            if (mysqli_query($conn, $query)) {
                $message = "General assessment successfully recorded!";
                header("Location: ../../patients_listing.php");
                exit;
            } else {
                $message = "Error saving details!";
                exit;
            }
        }
    }

?>