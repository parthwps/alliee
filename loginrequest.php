<?php
require("connect.php");
$mobile = $_POST["mobile"];

try {
    // Check if mobile number already exists
    $checkStmt = $pdo->prepare("SELECT * FROM user WHERE mobile = :mobile");
    $checkStmt->bindParam(':mobile', $mobile);
    $checkStmt->execute();

    if ($checkStmt->rowCount() > 0) {
        $otp = generateOTP();
        $updateStmt = $pdo->prepare("UPDATE user SET otp = :otp WHERE mobile = :mobile");
        $updateStmt->bindParam(':otp', $otp);
        $updateStmt->bindParam(':mobile', $mobile);
        $updateStmt->execute();
        echo "0, ".$otp.", Mobile number exists. OTP updated successfully";
    } else {
        $otp = generateOTP();
        $insertStmt = $pdo->prepare("INSERT INTO user (mobile, otp) VALUES (:mobile, :otp)");
        $insertStmt->bindParam(':mobile', $mobile);
        $insertStmt->bindParam(':otp', $otp);
        $insertStmt->execute();

        echo "0, Mobile number does not exist. New record inserted with OTP";
    }
}
catch(PDOException $e) {
    echo "1, Error: " . $e->getMessage();
}

function generateOTP() {
    return str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
}
?>