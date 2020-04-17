<html>
<form action="index.php" method="post">
    <input type="submit" name="logout" value="Logout">
</form>

<body>
<?php
if (isset($_POST['logout'])) {
    setcookie("loggedInUser", "", time()-60);
    header("Location: login.php", true, 301);
}

if (!isset($_COOKIE['loggedInUser'])) {
    header("Location: login.php", true, 301);
}


$host = '127.0.0.1:3306';
$db = 'netland';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo("Connected to: " . $db . " on " . $host . " version: " . phpversion());
    echo("<br>");
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
}else {
    $id = $_POST['id'];
}



if (isset($_POST['submit'])){

    $awards = $_POST['awards'];
    $seasons = $_POST['seasons'];
    $country = $_POST['country'];
    $language = $_POST['language'];
    $description = $_POST['description'];
    $length = $_POST['length'];
    $releasedate = $_POST['releasedate'];
    $youtubeurl = $_POST['youtube_url'];

    $query = <<<EOT
                        UPDATE netland.media 
                        SET
                            releasedate = '${releasedate}',
                            releasecountry = '${country}',
                            language = '${language}',
                            seasons = '${seasons}',
                            awards = '${awards}',
                            youtube_url = '${youtubeurl}',
                            description = '${description}',
                            length = '${length}'
                        WHERE 
                            id = '${id}'
                        ;
EOT;

    $result = $pdo->query($query)->fetch();
    var_dump($result);


    ;
}

echo("<a href='index.php'>back</a>");

$selection = "SELECT *
        FROM media
        WHERE id='$id'";

$q = $pdo->query($selection);
$selectiondata = $q->fetchAll(PDO::FETCH_ASSOC);

echo ("<form action='details.php' method='post'>");
echo ("<input type='hidden' name='id' value='" . $id . "'>");
foreach ($selectiondata as $row) {
    echo("<h1>" . $row['title'] . "</h1>");
    echo("<b>Release date </b>");
    echo("<input type='date' name='releasedate' value=" . "'" . $row['releasedate'] . "'" . ">");
    echo("<br><br>");
    echo("<b>Country </b>");
    echo("<input type='text' name='country' value=" . "'" . $row['releasecountry'] . "'" . ">");
    echo("<br><br>");
    echo("<b>Language </b>");
    echo("<input type='text' name='language' value=" . "'" . $row['language'] . "'" . ">");
    echo("<br><br>");
    echo("<b>Length </b>");
    echo("<input type='number' name='length' value=" . "'" . $row['length'] . "'" . "> minutes");
    echo("<br><br>");
    echo("<b>Seasons </b>");
    echo("<input type='number' name='seasons' value=" . "'" . $row['seasons'] . "'>");
    echo("<br><br>");
    echo("<b>Awards </b>");
    echo("<input type='number' name='awards' value=" . "'" . $row['awards'] . "'" . ">");
    echo("<br><br>");
    echo("<b>Description </b>");
    echo("<br>");
    echo("<textarea name=\"description\" rows=\"4\" cols=\"50\">");
    echo($row['description']);
    echo("</textarea>");
    echo "<br><br>";
    echo("<input type='submit' name='submit' value='wijzig'>");
    echo "<br><br>";
    echo("<b>Youtube URL </b>");
    echo("<input type='text' name='youtube_url' value=" . "'" . $row['youtube_url'] . "'" . ">");
    echo("</form>");
    echo "<br><br>";
    $videoid = $row['youtube_url'];
    echo("
        <iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/$videoid\"
         frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>
        ");

}