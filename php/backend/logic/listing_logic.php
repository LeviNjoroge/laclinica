<?php
require(__DIR__ . "/../config/database.php");

// required details: Patients_name, Age, BMI Status [Underweight, Normal, Overweight], Last Assessment Date
if (isset($_POST['patients_listing_date']) && $_POST['patients_listing_date'] != '') {
    $date = $_POST['patients_listing_date'];
    $patients_listing_query = "SELECT DISTINCT FIRST_NAME, MIDDLE_NAME, LAST_NAME, DATE_OF_BIRTH, BMI, VISIT_DATE
                                FROM PATIENTS_REGISTRATION P
                                JOIN VITALS_RECORDS V
                                ON P.PATIENT_NUMBER = V.PATIENT_NUMBER
                                AND V.VISIT_DATE = (SELECT MAX(V2.VISIT_DATE)
			                                    FROM VITALS_RECORDS V2
			                                    WHERE V2.PATIENT_NUMBER = P.PATIENT_NUMBER)
                                AND V.VISIT_DATE = '$date'";
} else {
    $patients_listing_query = "SELECT DISTINCT FIRST_NAME, MIDDLE_NAME, LAST_NAME, DATE_OF_BIRTH, BMI, VISIT_DATE
                            FROM PATIENTS_REGISTRATION P
                            JOIN VITALS_RECORDS V
                            ON P.PATIENT_NUMBER = V.PATIENT_NUMBER
                            AND V.VISIT_DATE = (SELECT MAX(V2.VISIT_DATE)
			                                    FROM VITALS_RECORDS V2
			                                    WHERE V2.PATIENT_NUMBER = P.PATIENT_NUMBER)";

}
$patients_listing = mysqli_query($conn, $patients_listing_query);

function BMI_Comment($BMI)
{
    if ($BMI < 18.5) {
        return 'Underweight';
    } elseif ($BMI < 25) {
        return 'Normal';
    } else {
        return 'Overweight';
    }
}

function calculate_AGE($date_of_birth)
{
    $dob = new DateTime($date_of_birth);
    $today = new DateTime();
    $age = $today->diff($dob)->y;
    return $age;
}
?>