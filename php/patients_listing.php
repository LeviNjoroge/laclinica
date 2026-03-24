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
                        } 
                        else {
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