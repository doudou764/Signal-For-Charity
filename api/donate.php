<?php

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

// --------------------
// 🛡️ VALIDATION BASE
// --------------------

if(!isset($data["name"], $data["amount"])) {
echo json_encode(["error" => "Invalid request"]);
exit;
}

$name = trim(strip_tags($data["name"]));
$amount = floatval($data["amount"]);
$message = trim(strip_tags($data["message"] ?? ""));

// --------------------
// 🚫 ANTI FAKE RULES
// --------------------

// Nom trop court
if(strlen($name) < 2){
echo json_encode(["error" => "Name too short"]);
exit;
}

// Nom trop long
if(strlen($name) > 30){
echo json_encode(["error" => "Name too long"]);
exit;
}

// Montant invalide
if($amount <= 0 || $amount > 500){
echo json_encode(["error" => "Invalid amount"]);
exit;
}

// Pas de virgules absurdes
if(!is_numeric($data["amount"])){
echo json_encode(["error" => "Invalid number"]);
exit;
}

// Anti spam message
if(strlen($message) > 200){
echo json_encode(["error" => "Message too long"]);
exit;
}

// --------------------
// ⛔ ANTI BOT SIMPLE
// --------------------

// Limite IP (anti spam basique)
$ip = $_SERVER["REMOTE_ADDR"];
$ipFile = "../data/ip_log.json";

if(!file_exists($ipFile)){
file_put_contents($ipFile, json_encode([]));
}

$ips = json_decode(file_get_contents($ipFile), true);

// dernière donation IP
if(isset($ips[$ip]) && time() - $ips[$ip] < 10){
echo json_encode(["error" => "Too many requests"]);
exit;
}

// update IP log
$ips[$ip] = time();
file_put_contents($ipFile, json_encode($ips));

// --------------------
// 💾 SAVE DON
// --------------------

$file = "../data/donations.json";

$donations = json_decode(file_get_contents($file), true);
if(!$donations) $donations = [];

$donations[] = [
"name" => $name,
"amount" => $amount,
"message" => $message,
"date" => date("Y-m-d H:i:s"),
"ip" => $ip
];

file_put_contents($file, json_encode($donations, JSON_PRETTY_PRINT));

echo json_encode(["success" => true]);

?>
