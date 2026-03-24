<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Patient Registration Form</title>
</head>

<body>
    <div class="container">
        <h2>Patient Registration Form</h2>
        <form method="POST" action="./backend/actions/save_patients.php">
            <div class="first_name">
                <label for="first_name">First Name:</label>
                <input name="first_name" type="text" id="first_name" placeholder="Joe" required>
            </div>

            <div class="middle_name">
                <label for="middle_name">Middle Name:</label>
                <input name="middle_name" type="text" id="middle_name" placeholder="Bloggs">
            </div>

            <div class="last_name">
                <label for="last_name">Last Name:</label>
                <input name="last_name" type="text" id="last_name" placeholder="Doe" required>
            </div>

            <div class="gender">
                <label for="gender">Gender:</label>
                <input type="radio" name="gender" id="Male" value="Male" required> Male
                <input type="radio" name="gender" id="Female" value="Female"> Female
            </div>

            <div class="date_of_birth">
                <label for="date_of_birth">Date of birth: </label>
                <input type="date" name="date_of_birth" id="date_of_birth" required>
            </div>

            <div class="patient_number">
                <label for="patient_number">Patient Number:</label>
                <input type="number" name="patient_number" id="patient_number" required>
            </div>

            <div class="reg_date">
                <label for="registration_date">Registration Date:</label>
                <input type="date" name="registration_date" id="registration_date" required>
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