
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

?>

<a href='index.php'>back</a>
<h1>Add movie/serie</h1>
<form action="create.php" method="post">
<table>
    <tr>
        <td> </td>
        <td> </td>
    </tr>

    <tr>
        <td><b>Title</b></td>
        <td><input type='text' name='title'></td>
    </tr>

    <tr>
        <td><b>Type</b></td>
        <td>

            <select name="type">
                <option value="movie">movie</option>
                <option value="serie">serie</option>
            </select>

        </td>
    </tr>


    <tr>
        <td><b>Release date </b></td>
        <td><input type='date' name='releasedate'></td>
    </tr>



    <tr>
        <td><b>Country </b></td></td>
        <td><input type='text' name='country'></td>
    </tr>

    <tr>
        <td><b>Language </b></td></td>
        <td><input type='text' name='language'></td>
    </tr>

    <tr>
        <td><b>Length </b></td></td>
        <td><input type='number' name='length'></td>
    </tr>

    <tr>
        <td><b>Seasons </b></td></td>
        <td><input type='number' name='seasons'></td>
    </tr>

    <tr>
        <td><b>Awards </b></td></td>
        <td><input type='number' name='awards'></td>
    </tr>

    <tr>
        <td><b>Rating </b></td></td>
        <td><input placeholder="/10" type='number' name='rating'></td>
    </tr>


    <tr>
        <td><b>Description </b></td></td>
        <td><input type="text" name="description"</input></td>
    </tr>

    <tr>
        <td><b>Youtube URL </b></td></td>
        <td><input type='text' name='youtube_url'></td>
    </tr>

    <br><br><br>

    <tr>
        <td></td>
        <td><input type='submit' name='submit'></td>
    </tr>

</table>
</form>

<?php

if (isset($_POST['submit'])) {

            $query = <<<EOT
                        INSERT INTO netland.media (title, type, releasedate,
                         releasecountry, seasons, length, rating, language, 
                         awards, youtube_url, description)
                        VALUES (
                            '${_POST['title']}',
                            '${_POST['type']}',
                            '${_POST['releasedate']}',
                            '${_POST['country']}',
                            '${_POST['seasons']}',
                            '${_POST['length']}',
                            '${_POST['rating']}',
                            '${_POST['language']}',
                            '${_POST['awards']}',
                            '${_POST['youtube_url']}',
                            '${_POST['description']}'
                        );
EOT;


        $result = $pdo->query($query)->fetch();
        var_dump($result);
        ;
    }

?>