<?php
session_start();

if(isset($_POST["login"])){

$data = json_decode(file_get_contents("../data/admin.json"), true);

$user = $_POST["username"];
$pass = $_POST["password"];

if($user === $data["username"] && $pass === $data["password"]){
$_SESSION["admin"] = true;
header("Location: dashboard.php");
exit;
}else{
$error = "Identifiants incorrects";
}

}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>
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

<h1>🔐 Admin Panel</h1>

<?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>

<form method="POST">
<input name="username" placeholder="Username">
<input name="password" type="password" placeholder="Password">
<button name="login">Login</button>
</form>

</body>
</html>
