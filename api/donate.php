<?php

$data = json_decode(file_get_contents("php://input"), true);

$file = "../data/donations.json";

$donations = json_decode(file_get_contents($file), true);

if(!$donations) $donations = [];

$donations[] = [
"name"=>$data["name"],
"amount"=>$data["amount"],
"message"=>$data["message"],
"date"=>date("Y-m-d H:i")
];

file_put_contents($file, json_encode($donations, JSON_PRETTY_PRINT));

echo json_encode(["status"=>"ok"]);
