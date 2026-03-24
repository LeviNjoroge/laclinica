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