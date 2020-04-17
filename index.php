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
$db   = 'netland';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo("Connected to: " . $db . " on " . $host . " version: " . phpversion());
    echo("<br>");
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

$movies = "SELECT *
        FROM media WHERE type='movie'";

$q = $pdo->query($movies);
$moviedata = $q->fetchAll(PDO::FETCH_ASSOC);



$series = "SELECT *
        FROM media WHERE type='serie'";

$w = $pdo->query($series);
$seriedata = $w->fetchAll(PDO::FETCH_ASSOC);


echo("<h1>movies</h1>");
echo("<table>");
echo("<tr>");
echo("<td><b>Title" . "</b></td>");
echo("<td><b> Release date" . "</b></td>");

echo("</tr>");

foreach ($moviedata as $row){
    echo("<tr>");
    echo("<td>" . $row["title"] . "</td>");
    echo("<td>" . $row["releasedate"] . "</td>");
    echo("<td><a href='details.php?id=" . $row['id'] . "'" . ">details</a></td>");
    echo("</tr>");
}
echo("<tr><td><a href='create.php'>add movie</a></td></tr>");
echo("</table>");


echo("<h1>Series</h1>");
echo("<table>");
echo("<tr>");
echo("<td><b>Title" . "</b></td>");
echo("<td><b> Seasons" . "</b></td>");
echo("<td><b> Rating" . "</b></td>");


echo("</tr>");

foreach ($seriedata as $row){
    echo("<tr>");
    echo("<td>" . $row["title"] . "</td>");
    echo("<td>" . $row["seasons"] . "</td>");
    echo("<td>" . $row["rating"] . "/10" . "</td>");

    echo("<td><a href='details.php?id=" . $row['id'] . "'" . ">details</a></td>");
    echo("</tr>");
}
echo("<tr><td><a href='create.php'>add serie</a></td></tr>");
echo("</table>");

?>
</html>

</body>

