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
            <!-- Filter records by this date -->
            <label for="patients_listing_date">Date:</label>
            <input type="date" name="patients_listing_date" id="patients_listing_date">
            <input type="button" value="reset">
        </div>

        <table border="1">
            <thead>
                <tr>
                    <th>Patient Name</th>
                    <th>Age</th>
                    <th>BMI Status</th>
                    <th>Last Assessment Date</th>
                </tr>
            </thead>
            <tbody>
                <!-- add table data here-->
                <tr>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>N/A</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>