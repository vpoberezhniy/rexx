<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Booking System</title>
    <link rel="stylesheet" href="style/main.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<div class="container">
    <h2>Event Booking System</h2>

    <!-- Formular zum Hochladen einer JSON-Datei. -->
    <form class="form-group" action="process_json.php" method="post" enctype="multipart/form-data">
        <label for="jsonFile">Upload JSON File:</label>
        <input type="file" id="jsonFile" name="jsonFile">
        <input type="submit" value="Upload">
    </form>

    <!-- Formular zur Filterung -->
    <form class="form-group filter-form" id="filterForm" method="get">
        <div class="form-group">
            <label for="employeeName">Employee Name:</label>
            <input type="text" id="employeeName" name="employeeName">
        </div>

        <div class="form-group">
            <label for="eventName">Event Name:</label>
            <input type="text" id="eventName" name="eventName">
        </div>

        <div class="form-group">
            <label for="eventDate">Event Date:</label>
            <input type="date" id="eventDate" name="eventDate">
        </div>

        <input id="filterButton" type="submit" value="Filter">
    </form>

    <!-- Tabelle mit den Ergebnissen -->
    <table id="resultsTable">
        <thead>
        <tr>
            <th>Employee Name</th>
            <th>Event Name</th>
            <th>Event Date</th>
            <th>Price</th>
        </tr>
        </thead>
        <tbody>
        <!-- Das Ergebnis der Filterung. -->
        </tbody>
        <tfoot>
        <tr class="total-row">
            <td colspan="3">Total Price:</td>
            <td id="totalPrice"><!-- Hier wird der Gesamtpreis angezeigt. --></td>
        </tr>
        </tfoot>
    </table>
</div>
<script src="ajax_form_script.js"></script>
</body>
</html>
