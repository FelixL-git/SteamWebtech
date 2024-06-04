<!DOCTYPE html>
<html lang="de">
<head>
    <title>Steam - Dashboard</title>
    <link rel="stylesheet" type="text/css" href="./style.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body class="page-dashboard" style="background-color:#252525;">
<!-- BUTTON ZURÜCK ZUM LOGIN -->
<a href="index.html" class="align-right button">
	Logout
</a>



<h1 class="h1 h1--noMargin" style="text-align: center">Vorhandene Serien</h1>
<div class="divider"></div>

<!-- SERIE HINZUFÜGEN START -->
<div class="center">
<button class="center open-add-series-form">Serie hinzufügen</button>
</div>
<div class="gradient center add-series-form">
    <div class="add-series-form_close">×</div>
    <form class="addSeriesFormStyling outline" action="add_series.php" method="post">
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
<div class="center">
    <input type="text" id="search" placeholder="Suche: Titel, Genre, Plattform ...">
    <div id="searchfor" >
        <label for="title-checkbox">Title:</label>
        <input type="checkbox" id="title-checkbox" name="title" value="title" checked>
        <label for="genre-checkbox">Genre:</label>
        <input type="checkbox" id="genre-checkbox" name="genre" value="genre" checked>
        <label for="platform-checkbox">Plattform:</label>
        <input type="checkbox" id="platform-checkbox" name="platform" value="platform" checked>
    </div>
</div>
<!-- SUCHE END --> 

<!-- Rating Form -->
<form id="rating_form" action="change_rating.php" method="POST">
    <input type="text" id="rating_user" name="username">
    <input type="number" id="rating_stars" name="rating">
    <input type="number" id="rating_seriesid" name="series_id">
</form>
<!-- Rating Form End -->

<!-- SERIEN AUFLISTEN START -->
<?php
include './db_config.php';

$conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}


session_start();
$username = $_SESSION["username"];

$sql = "SELECT * from series WHERE username = " . "'" . $username . "' ";

$result = $conn->query($sql);
?>
<?php if ($result->num_rows > 0): ?>
    
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
                    "seasons": "<?php echo $row["Staffeln"]; ?>",
                    "rating": "<?php echo $row["Bewertung"]; ?>",
                }'
            >
                <div class="title">
                    
                    <?php echo $row["Titel"]; ?>
                </div>
                <div class="genre">
                    <?php echo $row["Genre"]; ?>
                </div>
                <div class="platform">
                    <span>Plattform: </span>
                    <?php echo $row["Plattform"]; ?>
                </div>
                <div class="seasons">
                    <?php echo $row["Staffeln"]; ?>
                    <span>Staffeln</span>
                </div>
                <div class="rating">
                    <span class="star <?php if($row["Bewertung"] >= 1) {echo "activeStar";} ?>" onclick="changeRating('<?php echo $_SESSION['username']?>', <?php echo $row['id']?>, 1);">★</span>
                    <span class="star <?php if($row["Bewertung"] >= 2) {echo "activeStar";} ?>" onclick="changeRating('<?php echo $_SESSION['username']?>', <?php echo $row['id']?>, 2);">★</span>
                    <span class="star <?php if($row["Bewertung"] >= 3) {echo "activeStar";} ?>" onclick="changeRating('<?php echo $_SESSION['username']?>', <?php echo $row['id']?>, 3);">★</span>
                    <span class="star <?php if($row["Bewertung"] >= 4) {echo "activeStar";} ?>" onclick="changeRating('<?php echo $_SESSION['username']?>', <?php echo $row['id']?>, 4);">★</span>
                    <span class="star <?php if($row["Bewertung"] >= 5) {echo "activeStar";} ?>" onclick="changeRating('<?php echo $_SESSION['username']?>', <?php echo $row['id']?>, 5);">★</span>
                </div>
                <br><br>
                <form action="delete_series.php" method="post">
                    <input type="hidden" name="series_id" value="<?php echo $row['id']; ?>">
                    <input type="submit" value="Serie löschen">
                </form>
            </div>
        <?php 
        $index++;
        endwhile; 
        ?>
    </div>
<?php else: ?>

<?php endif; ?>
<?php
$conn->close();

?>
<!-- SERIEN AUFLISTEN END -->
<script src="./script.js"></script>
</body>
</html>