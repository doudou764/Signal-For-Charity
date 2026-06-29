<?php
session_start();

if(!isset($_SESSION["admin"])){
header("Location: login.php");
exit;
}

// ⛔ Timeout 15 min
$timeout = 900;

if(isset($_SESSION["last_activity"]) && (time() - $_SESSION["last_activity"] > $timeout)){
session_destroy();
header("Location: login.php?timeout=1");
exit;
}

$_SESSION["last_activity"] = time();
?>

$donations = json_decode(file_get_contents("../data/donations.json"), true);
$total = 0;

foreach($donations as $d){
$total += $d["amount"];
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>
<style>
body{
background:#111;
color:white;
font-family:Arial;
padding:30px;
}

.card{
background:#1c1c1c;
padding:20px;
margin:10px;
border-radius:10px;
}

a{
color:#00ff88;
}
</style>
</head>
<body>

<h1>📊 Admin Dashboard</h1>

<div class="card">
<h2>💰 Total collecté</h2>
<p><?= $total ?> €</p>
</div>

<div class="card">
<h2>📦 Nombre de dons</h2>
<p><?= count($donations) ?></p>
</div>

<div class="card">
<h2>🏆 Classement rapide</h2>

<?php
usort($donations, function($a,$b){
return $b["amount"] - $a["amount"];
});

$rank = 1;
foreach($donations as $d){
echo "<p>#{$rank} {$d['name']} - {$d['amount']}€</p>";
$rank++;
}
?>

</div>

<a href="logout.php">🚪 Logout</a>

</body>
</html>
