<?php
// Include the connection code
session_start();
require("connect.php");

// Get the data from the AJAX request
$firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
$lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';

try {
    // Update the user's first name and last name in the database (replace 'users' with your actual table name)
    $updateStmt = $pdo->prepare("UPDATE user SET firstname = :firstName, lastname = :lastName WHERE id = :userId");
    $updateStmt->bindParam(':firstName', $firstName);
    $updateStmt->bindParam(':lastName', $lastName);
    // Assuming you have a user_id for the user you want to update
    $updateStmt->bindParam(':userId', $_SESSION['udetails']); // Replace $userId with the actual user ID

    // Execute the update query
    $updateStmt->execute();

    // Send a success response
    echo "Name updated successfully";
} catch (PDOException $e) {
    // Send an error response
    echo "Error: " . $e->getMessage();
}
?>
