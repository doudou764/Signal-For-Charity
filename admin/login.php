<?php
session_start();

if(isset($_SESSION["admin"]) && $_SESSION["admin"] === true){
header("Location: dashboard.php");
exit;
}

$data = json_decode(file_get_contents("../data/admin.json"), true);

$error = "";

// Anti brute force simple
if(!isset($_SESSION["tries"])){
$_SESSION["tries"] = 0;
}

if($_SESSION["tries"] >= 5){
die("⛔ Trop de tentatives. Réessaie plus tard.");
}

if(isset($_POST["login"])){

$user = $_POST["username"];
$pass = $_POST["password"];

if($user === $data["username"] && password_verify($pass, $data["password_hash"])){

$_SESSION["admin"] = true;
$_SESSION["last_activity"] = time();
$_SESSION["tries"] = 0;

header("Location: dashboard.php");
exit;

}else{

$_SESSION["tries"]++;
$error = "❌ Identifiants incorrects";
}

}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Secure Login</title>
<style>
body{
background:#0a0a0a;
color:white;
font-family:Arial;
text-align:center;
padding-top:100px;
}

input{
display:block;
margin:10px auto;
padding:10px;
width:250px;
}

button{
padding:10px 25px;
background:#00ff88;
border:none;
cursor:pointer;
font-weight:bold;
}
</style>
</head>
<body>

<h1>🔐 Secure Admin</h1>

<p style="opacity:0.6">Tentatives : <?= $_SESSION["tries"] ?>/5</p>

<?php if($error) echo "<p style='color:red'>$error</p>"; ?>

<form method="POST">
<input name="username" placeholder="Username">
<input name="password" type="password" placeholder="Password">
<button name="login">Connexion</button>
</form>

</body>
</html>
