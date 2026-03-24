<?php
session_start();
require("./backend/config/database.php");

$first_name = $_SESSION["first_name"];
$middle_name = $_SESSION["middle_name"];
$last_name = $_SESSION["last_name"];
$patient_number = $_SESSION["patient_number"];

function calculate_BMI($height, $weight){
    $heightM = $height / 100;
    $BMI = $weight / ($heightM * $heightM);
    return $BMI;
}

if(isset($_POST["submit"])){
    $visit_date = $_POST["visit_date"];
    $height = filter_input(INPUT_POST, "height", FILTER_SANITIZE_NUMBER_INT);
    $weight = filter_input(INPUT_POST, "weight", FILTER_SANITIZE_NUMBER_INT);
    $BMI = calculate_BMI($height, $weight);

    // check the date, if its same as the last one on the system, the record is not stored
    $check_last_date = mysqli_query($conn, "select visit_date from vitals_records where patient_number = '$patient_number'  AND VISIT_DATE = '$visit_date'");
    if(mysqli_num_rows($check_last_date)>0){
            echo "<script> alert('User already registered on that day!')</script>";
    }
    else{
        // send the data to the database...
        $query_update_vitals_records = "INSERT INTO VITALS_RECORDS VALUES('$patient_number', '$visit_date', '$height', '$weight', '$BMI')";
        if(mysqli_query($conn, $query_update_vitals_records)){
            echo "<script> alert('Vitals successfully recorded!')</script>";
            if ($BMI <= 25) {
                header("Location: ./general_assessment_form.php");
                exit;
            } else {
                header("Location: ./overweight_assessment_form.php");
                exit;
            }
        } else{
            echo "<script> alert('There was an error tryng to save the records!')</script>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Vitals form</title>
</head>

<body>
    <div class="container">
        <h2>Vitals Form</h2>
        <form action="" method="POST">
            <div class="patient_name">
                <label for="patient_name">Patient's Name:</label>
                <input type="text" name="patient_name" id="patient_name" value="<?php echo $first_name." ".$middle_name." ".$last_name?>" readonly>
            </div>

            <div class="visit_date">
                <label for="visit_date">Visit Date:</label>
                <input type="date" name="visit_date" id="visit_date" required>
            </div>

            <div class="height">
                <label for="height">Height (cm):</label>
                <input type="number" name="height" id="height" required>
            </div>

            <div class="weight">
                <label for="weight">Weight (KG):</label>
                <input type="number" name="weight" id="weight" required>
            </div>

            <div class="bmi">
                <label for="bmi">BMI: </label>
                <input type="number" name="bmi" id="bmi" value="<?php if(isset($BMI))echo $BMI?>" readonly>
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