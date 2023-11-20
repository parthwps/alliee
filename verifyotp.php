<?php
require("connect.php");

$mobile = isset($_POST['mobile']) ? $_POST['mobile'] : '';
$otp = isset($_POST['otp']) ? $_POST['otp'] : '';

try {
    // Check if the provided OTP exists in the database
    $checkStmt = $pdo->prepare("SELECT * FROM user WHERE mobile = :mobile AND otp = :otp");
    $checkStmt->bindParam(':mobile', $mobile);
    $checkStmt->bindParam(':otp', $otp);
    $checkStmt->execute();

    if ($checkStmt->rowCount() > 0) {
        $user = $checkStmt->fetch(PDO::FETCH_ASSOC);
        if (!empty($user['firstname'])) {
            echo "1, Login OTP verified successfully";   
        }else{
            echo "2, New Signup";
        }
        session_start();
        $_SESSION['udetails'] = $user['id'];
    } else {
        echo "0, Invalid OTP";
    }
} catch (PDOException $e) {
    echo "0, Error: " . $e->getMessage();
}
?>
