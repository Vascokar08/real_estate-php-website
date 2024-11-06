<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id']) || !$_SESSION['is_agent']) {
    header("Location: login.php");
    exit();
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $seller_id = $_SESSION['user_id'];
    $title = htmlspecialchars(trim($_POST['title']));
    $description = htmlspecialchars(trim($_POST['description']));
    $price = filter_var($_POST['price'], FILTER_VALIDATE_FLOAT);
    $bedrooms = filter_var($_POST['bedrooms'], FILTER_VALIDATE_INT);
    $bathrooms = filter_var($_POST['bathrooms'], FILTER_VALIDATE_INT);
    $area = filter_var($_POST['area'], FILTER_VALIDATE_FLOAT);
    $address = htmlspecialchars(trim($_POST['address']));
    $city = htmlspecialchars(trim($_POST['city']));
    $state = htmlspecialchars(trim($_POST['state']));
    $zip_code = htmlspecialchars(trim($_POST['zip_code']));
    $contact_number = htmlspecialchars(trim($_POST['contact_number']));

    

    if (!$message) { // If no error message, proceed with database insertion
        try {
            $stmt = $pdo->prepare("INSERT INTO houses (seller_id, title, description, price, bedrooms, bathrooms, area, address, city, state, zip_code, contact_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$seller_id, $title, $description, $price, $bedrooms, $bathrooms, $area, $address, $city, $state, $zip_code, $contact_number]);

            $message = "House listed successfully!";
            // Optionally, redirect to index or the new listing
            // header("Location: index.php");
            // exit();
        } catch (PDOException $e) {
            $message = "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List a House</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; margin: 0; padding: 20px; background-color: #f4f4f4; }
        h2 { color: #333; text-align: center; margin-bottom: 20px; }
        form { max-width: 500px; margin: 0 auto; background: #fff; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        input[type="text"], input[type="number"], input[type="tel"], textarea { width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        textarea { height: 100px; resize: vertical; }
        input[type="submit"] { background-color: #4CAF50; color: white; padding: 12px 20px; border: none; border-radius: 4px; cursor: pointer; width: 100%; font-size: 16px; }
        input[type="submit"]:hover { background-color: #45a049; }
        .message { text-align: center; margin-bottom: 20px; padding: 10px; border-radius: 4px; }
        .success { background-color: #d4edda; color: #155724; }
        .error { background-color: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <h2>List a House</h2>
    <?php
    if ($message) {
        $class = (strpos($message, "successfully") !== false) ? "success" : "error";
        echo "<div class='message $class'>$message</div>";
    }
    ?>
    <form method="post" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Title" required>
        <textarea name="description" placeholder="Description" required></textarea>
        <input type="number" name="price" placeholder="Price" step="0.01" min="0" required>
        <input type="number" name="bedrooms" placeholder="Bedrooms" min="0" required>
        <input type="number" name="bathrooms" placeholder="Bathrooms" min="0" required>
        <input type="number" name="area" placeholder="Area (sq ft)" step="0.01" min="0" required>
        <input type="text" name="address" placeholder="Address" required>
        <input type="text" name="city" placeholder="City" required>
        <input type="text" name="state" placeholder="State" required>
        <input type="text" name="zip_code" placeholder="ZIP Code" required>
        <input type="tel" name="contact_number" placeholder="Contact Number" required>

        <input type="submit" value="List House">
    </form>
</body>
</html>