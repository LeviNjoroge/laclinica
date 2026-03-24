<?php
// session_start();
require("./backend/config/database.php");

// $first_name = $_SESSION["first_name"];
// $middle_name = $_SESSION["middle_name"];
// $last_name = $_SESSION["last_name"];
// $patient_number = $_SESSION["patient_number"];

$first_name = "Joe";
$middle_name = "Underson";
$last_name = "Doe";
$patient_number = 101;

if (isset($_POST["submit"])) {
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
            header("Location: patients_listing.php");
            exit;
        } else {
            $message = "Error saving details!";
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
    <title>Overweight Assessment Form</title>
</head>
<body>
    <div class="container">
        <h2>Overweight Assessment Form</h2>
        <form action="">
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
                <input type="radio" name="gen_health" id="Good"> Good
                <input type="radio" name="gen_health" id="Poor"> Poor
            </div>

            <div class="been_on_diet">
                <label for="been_on_diet">Have you ever been on a diet to lose weight?</label>
                <input type="radio" name="been_on_diet" id="Yes"> Yes
                <input type="radio" name="been_on_diet" id="No"> No
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
        <?php if(isset($message))  ?>
        function clearForm() {
            document.querySelector("form").reset();
        }
    </script>
</body>
</html>