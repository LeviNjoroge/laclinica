<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Vitals form</title>
</head>
<body>
    <h2>Vitals Form</h2>
    <form action="">
        <div class="patient_name">
            <label for="patient_name">Patient's Name:</label>
            <!-- <p class="patients_records_in_form">Patient's records go here</p> -->
            <input type="text" name="patient_name" id="patient_name" readonly>
        </div>

        <div class="visit_date">
            <label for="visit_date">Visit Date:</label>
            <input type="date" name="visit_date" id="visit_date">
        </div>

        <div class="height">
            <label for="height">Height (cm):</label>
            <input type="number" name="height" id="height">
        </div>

        <div class="weight">
            <label for="weight">Weight (KG):</label>
            <input type="number" name="weight" id="weight">
        </div>

        <div class="bmi">
            <label for="bmi">BMI: </label>
            <input type="number" name="bmi" id="bmi" readonly>
        </div>

        <input type="button" value="Cancel" id="cancel_button">
        
        <input type="button" value="Submit" id="submit_button">
    </form>
</body>
</html>