<?php
session_start();
require("./backend/config/database.php");

$first_name = $_SESSION["first_name"];
$middle_name = $_SESSION["middle_name"];
$last_name = $_SESSION["last_name"];
$patient_number = $_SESSION["patient_number"];

if (isset($_POST["submit"])) {
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
        if(mysqli_query($conn, $query)){
            echo "</script>alert('General assessment successfully recorded!')</script>";
            header("Location: patients_listing.php");
            exit;
        }
        else{
            echo "</script>alert('Error saving details!')</script>";
        }
    }   
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>General Assessment Form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>General Assessment Form</h2>
        <form action="" method="POST">
            <div class="patient_name">
                <label for="patient_name">Patient's Name:</label>
                <input type="text" name="patient_name" id="patient_name" value="<?php echo $first_name . " " . $middle_name . " " . $last_name ?>" readonly>
            </div>

            <div class="visit_date">
                <label for="visit_date">Visit Date:</label> <br>
                <input type="date" name="visit_date" id="visit_date" required>
            </div>

            <div class="gen_health">
                <label for="gen_health">General Health:</label> <br>
                <input type="radio" name="gen_health" id="Good" value="Good"> Good
                <input type="radio" name="gen_health" id="Poor" value="Poor"> Poor
            </div>

            <div class="on_drugs">
                <label for="on_drugs">Are you currently using any drugs?</label> <br>
                <input type="radio" name="on_drugs" id="Yes" value="Yes"> Yes
                <input type="radio" name="on_drugs" id="No" value="No"> No
            </div>

            <div class="comments">
                <label for="comments">Comments:</label> <br>
                <textarea name="comments" id="comments" required></textarea>
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