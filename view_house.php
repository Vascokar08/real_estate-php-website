<?php
session_start();
require_once 'config.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$house_id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
if (!$house_id) {
    header("Location: index.php");
    exit();
}

try {
    $stmt = $pdo->prepare("SELECT * FROM houses WHERE id = ?");
    $stmt->execute([$house_id]);
    $house = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$house) {
        throw new Exception("House not found");
    }
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($house['title']); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .house-header {
            background-color: #4CAF50;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        .house-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .house-image {
            width: 100%;
            height: auto;
            max-height: 400px;
            object-fit: cover;
            display: block;
        }
        .house-details {
            padding: 20px;
        }
        .detail-card {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 15px;
            margin-bottom: 15px;
        }
        .detail-card h2 {
            margin-top: 0;
            font-size: 18px;
            color: #4CAF50;
        }
        .price {
            font-size: 24px;
            font-weight: bold;
            color: #4CAF50;
        }
        .description {
            white-space: pre-wrap;
        }
        .back-link {
            display: inline-block;
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
        }
        .back-link:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="house-header">
            <h1><?php echo htmlspecialchars($house['title']); ?></h1>
        </div>
       
        <div class="house-details">
            <div class="detail-card">
                <h2>Price</h2>
                <p class="price">$<?php echo number_format($house['price'], 2); ?></p>
            </div>
            <div class="detail-card">
                <h2>Details</h2>
                <p><?php echo $house['bedrooms']; ?> bed, <?php echo $house['bathrooms']; ?> bath</p>
                <p>Area: <?php echo number_format($house['area'], 2); ?> sq ft</p>
            </div>
            <div class="detail-card">
                <h2>Location</h2>
                <p><?php echo htmlspecialchars($house['address']); ?></p>
                <p><?php echo htmlspecialchars($house['city']); ?>, <?php echo htmlspecialchars($house['state']); ?> <?php echo htmlspecialchars($house['zip_code']); ?></p>
            </div>
            <div class="detail-card">
                <h2>Description</h2>
                <p class="description"><?php echo nl2br(htmlspecialchars($house['description'])); ?></p>
            </div>
            <div class="detail-card">
                <h2>Contact Information</h2>
                <p>Phone: <?php echo htmlspecialchars($house['contact_number']); ?></p>
            </div>
            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $house['seller_id']): ?>
                <a href="edit_house.php?id=<?php echo $house['id']; ?>" class="back-link">Edit Listing</a>
            <?php endif; ?>
            <a href="index.php" class="back-link">Back to Listings</a>
        </div>
    </div>
</body>
</html>