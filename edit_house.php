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

$message = '';

// Fetch current data for the selected house
$stmt = $pdo->prepare("SELECT * FROM houses WHERE id = ? AND seller_id = ?");
$stmt->execute([$_GET['id'], $_SESSION['user_id']]);
$house = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$house) {
    $message = "House not found or you're not authorized to edit it.";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $house) {
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

    // Image upload handling
    $imagePath = $house['image_url'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploadDir = 'uploads/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $imageName = time() . '_' . basename($_FILES['image']['name']);
        $fullImagePath = $uploadDir . $imageName;
        
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $fileExtension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        
        if (in_array($fileExtension, $allowedExtensions)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $fullImagePath)) {
                $imagePath = '/' . $fullImagePath; // Store path with leading slash
                
                // Delete old image if it exists
                if ($house['image_url'] && file_exists(ltrim($house['image_url'], '/'))) {
                    unlink(ltrim($house['image_url'], '/'));
                }
            } else {
                $message = "Failed to upload new image. Keeping existing image.";
            }
        } else {
            $message = "Invalid file type. Please upload a JPG, JPEG, PNG, or GIF file.";
        }
    }

    if (!$message) {
        try {
            $stmt = $pdo->prepare("UPDATE houses SET title=?, description=?, price=?, bedrooms=?, bathrooms=?, area=?, address=?, city=?, state=?, zip_code=?, contact_number=?, image_url=? WHERE id=? AND seller_id=?");
            $stmt->execute([$title, $description, $price, $bedrooms, $bathrooms, $area, $address, $city, $state, $zip_code, $contact_number, $imagePath, $_GET['id'], $_SESSION['user_id']]);

            $message = "House updated successfully!";
            // Refresh house data
            $stmt = $pdo->prepare("SELECT * FROM houses WHERE id = ? AND seller_id = ?");
            $stmt->execute([$_GET['id'], $_SESSION['user_id']]);
            $house = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            $message = "Error updating record: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit House</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; margin: 0; padding: 20px; background-color: #f4f4f4; }
        h2 { color: #333; text-align: center; }
        form { background-color: #fff; max-width: 500px; margin: 20px auto; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        input[type="text"], input[type="number"], input[type="tel"], textarea { width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        textarea { height: 100px; }
        input[type="submit"] { background-color: #4CAF50; color: white; padding: 12px 20px; border: none; border-radius: 4px; cursor: pointer; width: 100%; }
        input[type="submit"]:hover { background-color: #45a049; }
        a { display: block; text-align: center; margin-top: 20px; color: #333; text-decoration: none; }
        a:hover { color: #4CAF50; }
        .message { text-align: center; margin-bottom: 20px; padding: 10px; border-radius: 4px; }
        .success { background-color: #d4edda; color: #155724; }
        .error { background-color: #f8d7da; color: #721c24; }
        .current-image { max-width: 100%; height: auto; margin-bottom: 10px; }
    </style>
</head>
<body>
    <h2>Edit House Listing</h2>
    <?php
    if ($message) {
        $class = (strpos($message, "successfully") !== false) ? "success" : "error";
        echo "<div class='message $class'>$message</div>";
    }

    if ($house):
    ?>
    <form method="post" enctype="multipart/form-data">
        <input type="text" name="title" value="<?php echo htmlspecialchars($house['title']); ?>" required>
        <textarea name="description" required><?php echo htmlspecialchars($house['description']); ?></textarea>
        <input type="number" name="price" value="<?php echo number_format($house['price'], 2, '.', ''); ?>" step="0.01" min="0" required>
        <input type="number" name="bedrooms" value="<?php echo $house['bedrooms']; ?>" min="0" required>
        <input type="number" name="bathrooms" value="<?php echo $house['bathrooms']; ?>" min="0" required>
        <input type="number" name="area" value="<?php echo number_format($house['area'], 2, '.', ''); ?>" step="0.01" min="0" required>
        <input type="text" name="address" value="<?php echo htmlspecialchars($house['address']); ?>" required>
        <input type="text" name="city" value="<?php echo htmlspecialchars($house['city']); ?>" required>
        <input type="text" name="state" value="<?php echo htmlspecialchars($house['state']); ?>" required>
        <input type="text" name="zip_code" value="<?php echo htmlspecialchars($house['zip_code']); ?>" required>
        <input type="tel" name="contact_number" value="<?php echo htmlspecialchars($house['contact_number']); ?>" required>
        
      
        <input type="submit" value="Update House">
    </form>
    <?php else: ?>
    <p>House not found or you're not authorized to edit it.</p>
    <?php endif; ?>
    <a href="index.php">Back to Listings</a>
</body>
</html>