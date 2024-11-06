<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id']) || !$_SESSION['is_agent']) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

try {
    // Prepare a delete statement
    $stmt_delete = $pdo->prepare("DELETE FROM houses WHERE id = ? AND seller_id = ?");
    
    // Bind variables to the prepared statement as parameters
    $stmt_delete->execute([
        intval($_GET["id"]),
        intval($_SESSION["user_id"])
    ]);

    // Check if any rows were affected
    if ($stmt_delete->rowCount() > 0) {
        echo "Record deleted successfully.";
    } else {
        echo "No records were deleted. The house may not exist or you may not have permission to delete it.";
    }
} catch(PDOException $e) {
    die('Error: ' . $e->getMessage());
}

header('Location: index.php');
exit();
?>