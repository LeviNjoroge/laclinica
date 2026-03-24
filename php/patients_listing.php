<?php
require("./backend/config/database.php");

// required details: Patients_name, Age, BMI Status [Underweight, Normal, Overweight], Last Assessment Date
$patients_listing_query = "SELECT FIRST_NAME, MIDDLE_NAME, LAST_NAME, DATE_OF_BIRTH, BMI, VISIT_DATE
                            FROM PATIENTS_REGISTRATION P
                            JOIN VITALS_RECORDS V
                            ON P.PATIENT_NUMBER = V.PATIENT_NUMBER
                            AND V.VISIT_DATE = (SELECT MAX(V2.VISIT_DATE)
			                                    FROM VITALS_RECORDS V2
			                                    WHERE V2.PATIENT_NUMBER = P.PATIENT_NUMBER)";

$patients_listing = mysqli_query($conn, $patients_listing_query);

$current_date = date("Y-m-d");

function BMI_Comment($BMI){
    if  ($BMI<18.5){
        return 'Underweight';
    }elseif ($BMI<25) {
        return 'Normal';
    }else{
        return 'Overweight';
    }
}

function calculate_AGE($date_of_birth){
    $dob = new DateTime($date_of_birth);
    $today = new DateTime();
    $age = $today->diff($dob)->y;
    return $age;
}

if (isset($_POST['patients_listing_date']) && $_POST['patients_listing_date'] != '') {
    $date = $_POST['patients_listing_date'];
    $patients_listing_query = "SELECT FIRST_NAME, MIDDLE_NAME, LAST_NAME, DATE_OF_BIRTH, BMI, VISIT_DATE
                                FROM PATIENTS_REGISTRATION P
                                JOIN VITALS_RECORDS V
                                ON P.PATIENT_NUMBER = V.PATIENT_NUMBER
                                AND V.VISIT_DATE = (SELECT MAX(V2.VISIT_DATE)
			                                    FROM VITALS_RECORDS V2
			                                    WHERE V2.PATIENT_NUMBER = P.PATIENT_NUMBER)
                                AND V.VISIT_DATE = '$date'";
    $patients_listing = mysqli_query($conn, $patients_listing_query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Patients Listing</title>
</head>
<body>
    <div class="container">
        <h2>Patients Listing</h2>
        <div class="patients_listing_date">
            <form action="" method="post">
                <!-- Filter records by this date -->
                <label for="patients_listing_date">Date:</label>
                <input type="date" name="patients_listing_date" value="<?php echo $_POST['patients_listing_date'] ?? '' ?>">
                <input type="submit" value="Filter">
            </form>
        </div>
        <?php
            if (isset($date)) {
                echo "<p>Showing records for: ".$date."</p>";
            } else {
                echo "<p>Showing latest records</p>";
            }
        ?>

        <table>
            <thead>
                <tr class="table_head">
                    <th>Patient Name</th>
                    <th>Age</th>
                    <th>BMI Status</th>
                    <th>Last Assessment Date</th>
                </tr>
            </thead>
            <tbody>
                <!-- add table data here-->
                    <?php
                        if(mysqli_num_rows($patients_listing) > 0){
                            while($patient = mysqli_fetch_assoc($patients_listing)){
                                echo "<tr>";
                                echo "<td>".$patient['FIRST_NAME']." ".$patient['MIDDLE_NAME']." ".$patient['LAST_NAME']."</td>";
                                echo "<td>".calculate_AGE($patient["DATE_OF_BIRTH"])."</td>";
                                echo "<td>".(isset($patient['BMI']) ? BMI_Comment($patient['BMI']) : 'N/A')."</td>";
                                echo "<td>".$patient['VISIT_DATE']."</td>";
                                echo "</tr>";
                            }
                        } else {
                        echo "<tr>";
                            for($i = 0; $i< 4; $i++){
                                echo "<td> N/A </td>";
                            }
                        echo "</tr>";
                        }
                    ?>
            </tbody>
        </table>
    </div>
</body>
</html>