<?php
session_start();
require("db.php");
$plan = $_GET['plan'];
$amt = $_GET['amt'];
$user_email = $_SESSION['user'];

$res = $db->query("SELECT * FROM users WHERE email = '$user_email'");
$data = $res->fetch_assoc();
$name = $data['full_name'];

require("../src/Instamojo.php");

$api = new Instamojo\Instamojo('a07716f2d3f8556645a7865f95f37454', 'e6d4298bc4375e43bb941d147381d64a','https://www.instamojo.com/api/1.1/');

try {
    $response = $api->paymentRequestCreate(array(
        "purpose" => "STP Drive ".$plan." Plan",
        "amount" => $amt,
        "send_email" => true,
        "email" => $user_email,
        "buyer_name" => $name,
        "redirect_url" => "http://localhost/stpdrive/php/update_plan.php?plan=" . $plan
        ));
    $main_url = $response['longurl'];

    Header("Location:$main_url");
}
catch (Exception $e) {
    print('Error: ' . $e->getMessage());
}

?>
