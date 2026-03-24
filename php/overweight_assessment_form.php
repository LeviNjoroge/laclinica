<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Overweight Assessment Form</title>
</head>
<body>
    <div class="container">
        <h2>Overweight Assessment Form</h2>
        <form action="" method="POST">
            <div class="patient_name">
                <label for="patient_name">Patient's Name:</label>
                <input type="text" name="patient_name" id="patient_name" value="<?php echo $first_name . " " . $middle_name . " " . $last_name ?>" readonly>
            </div>

            <div class="visit_date">
                <label for="visit_date">Visit Date:</label>
                <input type="date" name="visit_date" id="visit_date">
            </div>

            <div class="gen_health">
                <label for="gen_health">General Health:</label>
                <input type="radio" name="gen_health" id="Good" value="Good"> Good
                <input type="radio" name="gen_health" id="Poor" value="Poor"> Poor
            </div>

            <div class="been_on_diet">
                <label for="been_on_diet">Have you ever been on a diet to lose weight?</label>
                <input type="radio" name="been_on_diet" id="Yes" value="Yes"> Yes
                <input type="radio" name="been_on_diet" id="No" value="No"> No
            </div>

            <div class="comments">
                <label for="comments">Comments:</label>
                <textarea name="comments" id="comments"></textarea>
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