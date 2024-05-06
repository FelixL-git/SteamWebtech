<!DOCTYPE html>
<html lang="de">
<head>
    <title>Steam - Dashboard</title>
    <link rel="stylesheet" type="text/css" href="./style.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="background-color:#252525;">
<!-- BUTTON ZURÜCK ZUM LOGIN -->
<a href="index.html" class="align-right">
	<input type="button" value="Logout">
</a>

<!-- SERIE HINZUFÜGEN START -->
<div class="center">
<form action="add_series.php" method="post">
    <h1>Serie hinzufügen</h1>
    <label for="title">Titel:</label>
    <input type="text" id="title" name="title" required><br>
    <label for="genre">Genre:</label>
    <input type="text" id="genre" name="genre" required><br>
    <label for="platform">Plattform:</label>
    <input type="text" id="platform" name="platform" required><br>
    <label for="seasons">Staffeln:</label>
    <input type="number" id="seasons" name="seasons" required><br>
    <input type="submit" value="Serie hinzufügen">
</form>
</div>

<!-- SERIE HINZUFÜGEN END -->
<!-- SUCHE START -->
<div>
    <input type="text" id="search" placeholder="Titel, Genre, Plattform ..." checked>
    <div id="searchfor" >
        <label for="vehicle1">Title:</label>
        <input type="checkbox" id="title-checkbox" name="title" value="title" checked>
        <label for="vehicle1">Genre:</label>
        <input type="checkbox" id="genre-checkbox" name="genre" value="genre" checked>
        <label for="vehicle1">Plattform:</label>
        <input type="checkbox" id="platform-checkbox" name="platform" value="platform" checked>
    </div>
</div>
<!-- SUCHE END -->

<!-- SERIEN AUFLISTEN START -->
<?php
include './db_config.php';

// Erstelle die Verbindung
$conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

//$username = "Sebastian"; //TODO durch login user setzen
session_start();
$username = $_SESSION["username"];

$sql = "SELECT * from series WHERE username = " . "'" . $username . "' ";

$result = $conn->query($sql);
?>
<?php if ($result->num_rows > 0): ?>
    <h1 class="h1 h1--noMargin" style="text-align: center">Vorhandene Serien</h1>
    <div class="divider"></div>
    <div class="series-container">
        <?php 
        $index = 0;
        while($row = $result->fetch_assoc()): 
        ?>
            <div 
                class="series"
                id="series-<?php echo $index; ?>"
                data-series='{
                    "id": "series-<?php echo $index; ?>",
                    "title": "<?php echo $row["Titel"]; ?>",
                    "genre": "<?php echo $row["Genre"]; ?>",
                    "platform": "<?php echo $row["Plattform"]; ?>",
                    "seasons": "<?php echo $row["Staffeln"]; ?>"
                }'
            >
                <div class="title">
                    <span>title: </span>
                    <?php echo $row["Titel"]; ?>
                </div>
                <div class="genre">
                    <span>genre: </span>
                    <?php echo $row["Genre"]; ?>
                </div>
                <div class="platform">
                    <span>platform: </span>
                    <?php echo $row["Plattform"]; ?>
                </div>
                <div class="seasons">
                    <span>seasons: </span>
                    <?php echo $row["Staffeln"]; ?>
                </div>
                <br><br>
            </div>
        <?php 
        $index++;
        endwhile; 
        ?>
    </div>
<?php else: ?>
    <p>Keine Serien vorhanden</p>
<?php endif; ?>
<?php
$conn->close();

?>
<!-- SERIEN AUFLISTEN END -->
<script src="./script.js"></script>
</body>
</html>