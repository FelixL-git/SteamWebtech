<!DOCTYPE html>
<html lang="de">
<head>
    <title>Steam - Login</title>
    <link rel="stylesheet" href="./style.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="background-color:#252525;">
<!-- SERIE HINZUFÜGEN START -->

<form action="add_series.php" method="post">
    <h2>Serie hinzufügen</h2>
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

<!-- SERIE HINZUFÜGEN END -->

<!-- SERIEN AUFLISTEN START -->
<?php
include './db_config.php';

// Erstelle die Verbindung
$conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

$username = "Sebastian"; //TODO durch login user setzen

$sql = "SELECT * from series WHERE username = 'Sebastian' ";

$result = $conn->query($sql);
?>
<?php if ($result->num_rows > 0): ?>
    <h1>Serien Vorhanden</h1>
    <div class="series-container">
        <?php while($row = $result->fetch_assoc()): ?>
            <div class="series">
                <div class="title"><span>title: </span><?php echo $row["Titel"]; ?></div>
                <div class="genre"><span>genre: </span><?php echo $row["Genre"]; ?></div>
                <div class="platform"><span>platform: </span><?php echo $row["Plattform"]; ?></div>
                <div class="seasons"><span>seasons: </span><?php echo $row["Staffeln"]; ?></div>
                <br><br>
            </div>
        <?php endwhile; ?>
    </div>
<?php else: ?>
    <p>Keine Serien vorhanden</p>
<?php endif; ?>
<?php
$conn->close();

?>
<!-- SERIEN AUFLISTEN END -->

</body>
</html>