<?php
session_start();

$first_name = $_SESSION["first_name"];
$middle_name = $_SESSION["middle_name"];
$last_name = $_SESSION["last_name"];
$patient_number = $_SESSION["patient_number"];

function calculate_BMI($height, $weight)
{
    $heightM = $height / 100;
    $BMI = $weight / ($heightM * $heightM);
    return $BMI;
}

?>