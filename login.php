<html>
<head>
<title>Netland - Login</title>
</head>

<style>

    .loginbox {
        margin: 0 auto;
        margin-top: 2%;
        width: 40%;
        text-align: center;
        font-family: "Consolas";
    }

    input {
        margin-bottom: 2%;
        height: 3%;
        width: 60%;
    }

    .status{
        color: green;
        text-align: center;
    }

    .redstatus{
        color: white;
        background-color: red;
        padding: 5px;
        margin: 0 auto;
        width: 20%;
        text-align: center;
        border-radius: 10px;
    }

</style>

<?php
session_start();




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
    echo("<div class='status'>");
    echo("Connected to: " . $db . " on " . $host . " version: " . phpversion());
    echo("</div>");
    echo("<br>");
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

?>


	<body>


        <div class='loginbox'>
        <h1>Netland Admin Panel</h1>

	    <form action='login.php' method='POST'>
	    <input type='text' name='username' placeholder='username'>
            <br>
	    <input type='password' name='password' placeholder='password'>
            <br>
	    <input type='submit' name='submit' value='login'>
	    </form>

        </div>

	</body>

</html>

<?php



if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");

    if ($stmt->execute(array($_POST['username']))) {
        while ($row = $stmt->fetch()) {
		print_r($row);

		if($row['password'] == $password) {
			echo("Password Correct");
			setcookie('loggedInUser', $row['id']);
            header("Location: index.php", true, 301);
            exit();
		
			}else { 
				echo("Password Incorrect");
			}

        }
    }
}




?>
