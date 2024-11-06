<?php
session_start();
require_once 'config.php';

$stmt = $pdo->query("SELECT * FROM houses ORDER BY created_at DESC");
$houses = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>House Market</title>
    <style>
    :root {
        --primary-color: #4CAF50;
        --secondary-color: #333;
        --accent-color: #FFA500;
        --background-color: #f4f4f4;
        --text-color: #333;
        --light-text-color: #fff;
    }

    body {
        font-family: 'Arial', sans-serif;
        line-height: 1.6;
        margin: 0;
        padding: 0;
        background-color: var(--background-color);
        color: var(--text-color);
    }

    .navbar {
        background-color: var(--secondary-color);
        padding: 1rem;
        position: sticky;
        top: 0;
        z-index: 1000;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .navbar-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    .logo {
        color: var(--light-text-color);
        font-size: 1.5rem;
        font-weight: bold;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .logo:hover {
        color: var(--accent-color);
    }

    .nav-links {
        list-style-type: none;
        display: flex;
        margin: 0;
        padding: 0;
    }

    .nav-links li {
        margin-left: 1.5rem;
    }

    .nav-links a {
        color: var(--light-text-color);
        text-decoration: none;
        transition: color 0.3s ease;
        font-weight: 500;
    }

    .nav-links a:hover {
        color: var(--accent-color);
    }

    header {
    position: relative;
    height: 70vh;
    overflow: hidden;
}

.slider {
    position: absolute;
    top: 0;
    left: 0;
    width: 300%;
    height: 100%;
    display: flex;
    transition: transform 0.4s ease-in-out;
    animation: slide 5s infinite;
}

.slide {
    width: 33.33%;
    position: relative;
}

.slide img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.slide-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    color: var(--light-text-color);
    z-index: 2;
    width: 80%;
}

.slide-content h1 {
    font-size: 2.5rem;
    margin-bottom: 1rem;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
}

.slide-content p {
    font-size: 1.2rem;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
}

.slide::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.4);
    z-index: 1;
}

@keyframes slide {
    0%, 33% {
        transform: translateX(0);
    }
    34%, 66% {
        transform: translateX(-33.33%);
    }
    67%, 100% {
        transform: translateX(-66.66%);
    }
}

@media (max-width: 768px) {
    header {
        height: 40vh;
    }

    .slide-content h1 {
        font-size: 1.8rem;
    }

    .slide-content p {
        font-size: 1rem;
    }
}
    header::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
       
        opacity: 0.3;
        z-index: 1;
    }

    header h1 {
        margin: 0 0 1rem;
        position: relative;
        z-index: 2;
        font-size: 2.5rem;
    }

    .btn {
        display: inline-block;
        background: var(--primary-color);
        color: var(--light-text-color);
        padding: 0.7rem 1.2rem;
        text-decoration: none;
        border-radius: 5px;
        margin: 0.3rem;
        transition: background 0.3s ease, transform 0.2s ease;
        border: none;
        cursor: pointer;
    }

    .btn:hover {
        background: #45a049;
        transform: translateY(-2px);
    }

    main {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }

    .section {
        padding: 4rem 0;
    }

    .section-title {
        text-align: center;
        margin-bottom: 2rem;
        font-size: 2rem;
        color: var(--secondary-color);
    }

    .house-listings {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 2rem;
    }

    .house-card {
        background: var(--light-text-color);
        border-radius: 10px;
        padding: 1.5rem;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    .house-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0,0,0,0.15);
    }

    .house-card h3 {
        margin-top: 0;
        margin-bottom: 1rem;
        color: var(--secondary-color);
        font-size: 1.3rem;
    }

    .house-actions {
        margin-top: auto;
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    .btn-danger {
        background: #dc3545;
    }

    .btn-danger:hover {
        background: #c82333;
    }

    .gallery {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    .gallery-item img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 10px;
        transition: transform 0.3s ease;
    }

    .gallery-item img:hover {
        transform: scale(1.05);
    }

    .reviews {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 2rem;
    }

    .review-card {
        background: var(--light-text-color);
        padding: 1.5rem;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        max-width: 300px;
        transition: transform 0.3s ease;
    }

    .review-card:hover {
        transform: translateY(-5px);
    }

    .contact-content {
        max-width: 600px;
        margin: 0 auto;
        text-align: center;
        background: var(--light-text-color);
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    footer {
        text-align: center;
        padding: 2rem;
        background: var(--secondary-color);
        color: var(--light-text-color);
        margin-top: 2rem;
    }

    @media (max-width: 768px) {
        .navbar-container {
            flex-direction: column;
        }

        .nav-links {
            margin-top: 1rem;
        }

        .nav-links li {
            margin: 0.5rem 0;
        }

        .house-listings {
            grid-template-columns: 1fr;
        }
    }
    .nav-links .btn {
    padding: 0.5rem 1rem;
    border-radius: 5px;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.nav-links .btn:hover {
    background-color: var(--accent-color);
    color: var(--secondary-color);
}

@media (max-width: 768px) {
    .navbar-container {
        flex-direction: column;
        border: #f4f4f4;
    }

    .nav-links {
        flex-direction: column;
        align-items: center;
        border: #f4f4f4;
    }

    .nav-links li {
        margin: 0.5rem 0;
      
   
    }

    .nav-links .btn {
        width: 100%;
        text-align: center;
    }
}
.section {
    padding: 5rem 0;
    background-color: #f9f9f9;
}

.section-title {
    text-align: center;
    margin-bottom: 3rem;
    font-size: 2.5rem;
    color: var(--secondary-color);
    position: relative;
}

.section-title::after {
    content: '';
    display: block;
    width: 50px;
    height: 3px;
    background-color: var(--primary-color);
    margin: 0.5rem auto 0;
}

.about-content {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
}

.about-image {
    flex: 1;
    margin-right: 2rem;
    max-width: 500px;
}

.about-image img {
    width: 100%;
    height: auto;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.about-text {
    flex: 1;
    min-width: 300px;
}

.about-text p {
    margin-bottom: 1.5rem;
    line-height: 1.6;
    color: #333;
}

.about-text h3 {
    font-size: 1.5rem;
    color: var(--secondary-color);
    margin-bottom: 1rem;
}

.about-text ul {
    list-style-type: none;
    padding-left: 0;
}

.about-text ul li {
    margin-bottom: 0.5rem;
    position: relative;
    padding-left: 1.5rem;
}

.about-text ul li::before {
    content: '✓';
    color: var(--primary-color);
    position: absolute;
    left: 0;
}

@media (max-width: 768px) {
    .about-content {
        flex-direction: column;
    }

    .about-image {
        margin-right: 0;
        margin-bottom: 2rem;
        max-width: 100%;
    }
}
.reviews-container {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 2rem;
    padding: 2rem 0;
}

.review-card {
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    padding: 1.5rem;
    width: 100%;
    max-width: 350px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.review-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

.review-header {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
}

.reviewer-image {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
    margin-right: 1rem;
}

.reviewer-info {
    display: flex;
    flex-direction: column;
}

.reviewer-name {
    font-size: 1.1rem;
    font-weight: bold;
    margin: 0;
    color: var(--secondary-color);
}

.rating {
    display: flex;
    margin-top: 0.25rem;
}

.star {
    color: #ffd700;
    font-size: 1.2rem;
}

.review-text {
    font-style: italic;
    color: #555;
    line-height: 1.6;
}

@media (max-width: 768px) {
    .reviews-container {
        flex-direction: column;
        align-items: center;
    }

    .review-card {
        max-width: 100%;
    }
}
.contact-content {
    display: flex;
    justify-content: space-between;
    max-width: 800px;
    margin: 0 auto;
    padding: 2rem;
}

#contactForm {
    flex: 1;
    margin-right: 2rem;
}

.form-group {
    margin-bottom: 1rem;
}

label {
    display: block;
    margin-bottom: 0.5rem;
}

input[type="text"],
input[type="email"],
textarea {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #ccc;
    border-radius: 4px;
}

textarea {
    height: 150px;
}

#formMessage {
    margin-top: 1rem;
    font-weight: bold;
}

.contact-info {
    flex: 1;
}

@media (max-width: 768px) {
    .contact-content {
        flex-direction: column;
    }
    
    #contactForm {
        margin-right: 0;
        margin-bottom: 2rem;
    }
}
</style>
</head>
<body>
<nav class="navbar">
    <div class="navbar-container">
        <a href="#" class="logo">🏠 House Market</a>
        <ul class="nav-links">
            <li><a v href="#">Home</a></li>
            <li><a v href="#about">About</a></li>
            <li><a  v href="#listings">Listings</a></li>
            <li><a v href="#gallery">Gallery</a></li>
            <li><a v href="#reviews">Reviews</a></li>
            <li><a v href="#contact">Contact</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <?php if (isset($_SESSION['is_agent']) && $_SESSION['is_agent']): ?>
                    <li><a href="list_house.php" class="btn">List a House</a></li>
                <?php endif; ?>
                <li><a href="logout.php" class="btn">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php" class="btn">Login</a></li>
                <li><a href="register.php" class="btn">Register</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
<header>
    <div class="slider">
        <div class="slide">
            <img src="https://cdn.gobankingrates.com/wp-content/uploads/2016/07/MAIN_iStock_82576699_LARGE-1024x640.jpg" alt="House for sale">
            <div class="slide-content">
                <h1>Welcome to House Market</h1>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <p>Welcome, User #<?php echo htmlspecialchars($_SESSION['user_id']); ?></p>
                <?php endif; ?>
            </div>
        </div>
        <div class="slide">
            <img src="https://www.bankrate.com/2019/07/09120854/How-much-does-it-cost-to-sell-a-house.jpeg" alt="Happy family">
            <div class="slide-content">
                <h1>Find Your Dream Home</h1>
            </div>
        </div>
        <div class="slide">
            <img src="https://assets.agentfire3.com/uploads/sites/121/2022/06/Home-Selling-Timeline.jpeg" alt="Home selling">
            <div class="slide-content">
                <h1>Sell Your Property</h1>
            </div>
        </div>
    </div>
</header>

    <main>
        <?php
        if (isset($_SESSION['success'])) {
            echo "<div class='message success'>" . $_SESSION['success'] . "</div>";
            unset($_SESSION['success']);
        }

        if (isset($_SESSION['error'])) {
            echo "<div class='message error'>" . $_SESSION['error'] . "</div>";
            unset($_SESSION['error']);
        }
        ?>
  <
        <section id="listings" class="section">
        <h2 class="section-title">Latest Listings</h2>
        <div class="house-listings">
            <?php foreach ($houses as $house): ?>
                <div class="house-card">
                    <h3><?php echo htmlspecialchars($house['title']); ?></h3>
                    <p>Price: $<?php echo number_format($house['price'], 2); ?></p>
                    <p><?php echo $house['bedrooms']; ?> bed, <?php echo $house['bathrooms']; ?> bath</p>
                    <p><?php echo htmlspecialchars($house['city']); ?>, <?php echo htmlspecialchars($house['state']); ?></p>
                    <div class="house-actions">
                        <a href="view_house.php?id=<?php echo $house['id']; ?>" class="btn">View Details</a>
                        <?php if (isset($_SESSION['user_id']) && $_SESSION['is_agent'] && $house['seller_id'] == $_SESSION['user_id']): ?>
                            <a href="edit_house.php?id=<?php echo $house['id']; ?>" class="btn">Edit</a>
                            <a href="delete_house.php?id=<?php echo $house['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this listing?');">Delete</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        </div>
        </section>
        <section id="about" class="section">
    <h2 class="section-title">About House Market</h2>
    <div class="about-content">
        <div class="about-image">
            <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8cmVhbCUyMGVzdGF0ZSUyMGFnZW50fGVufDB8fDB8fHww&auto=format&fit=crop&w=600&q=60" alt="Real Estate Team">
        </div>
        <div class="about-text">
            <p>House Market is your premier destination for all things real estate. As a cutting-edge online marketplace, we bring together buyers, sellers, and real estate professionals in one dynamic platform.</p>
            <p>With over a decade of experience in the real estate industry, our team of experts is dedicated to revolutionizing the way people buy, sell, and rent properties. We understand that finding the perfect home or investment opportunity is more than just a transaction – it's about creating lifelong memories and securing your financial future.</p>
            <h3>What sets us apart:</h3>
            <ul>
                <li>Extensive listings of properties across various categories and price ranges</li>
                <li>Advanced search and filter options to find your ideal property</li>
                <li>Virtual tours and high-quality imagery for remote viewing</li>
                <li>Direct communication channels with property owners and agents</li>
                <li>Comprehensive guides and resources for first-time buyers and seasoned investors</li>
                <li>Secure and transparent transaction processes</li>
            </ul>
            <p>Whether you're a first-time homebuyer, a seasoned investor, or a real estate professional, House Market provides the tools and support you need to succeed in today's competitive real estate landscape.</p>
        </div>
    </div>
</section>
        <section id="gallery" class="section">
            <h2 class="section-title">Gallery</h2>
            <div class="gallery">
    <div class="gallery-item"><img src="https://images.unsplash.com/photo-1564013799919-ab600027ffc6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8aG91c2UlMjBmb3IlMjBzYWxlfGVufDB8fDB8fHww&auto=format&fit=crop&w=600&q=60" alt="Modern family home for sale"></div>
    <div class="gallery-item"><img src="https://images.unsplash.com/photo-1570129477492-45c003edd2be?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8aG91c2UlMjBmb3IlMjByZW50fGVufDB8fDB8fHww&auto=format&fit=crop&w=600&q=60" alt="Cozy apartment for rent"></div>
    <div class="gallery-item"><img src="https://images.unsplash.com/photo-1605276374104-dee2a0ed3cd6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTF8fGhvdXNlJTIwZm9yJTIwc2FsZXxlbnwwfHwwfHx8MA%3D%3D&auto=format&fit=crop&w=600&q=60" alt="Luxury villa for sale"></div>
    <div class="gallery-item"><img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OHx8aG91c2UlMjBmb3IlMjBzYWxlfGVufDB8fDB8fHww&auto=format&fit=crop&w=600&q=60" alt="Beachfront property for sale"></div>
    <div class="gallery-item"><img src="https://images.unsplash.com/photo-1582268611958-ebfd161ef9cf?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8aG91c2UlMjBmb3IlMjByZW50fGVufDB8fDB8fHww&auto=format&fit=crop&w=600&q=60" alt="Charming cottage for rent"></div>
    <div class="gallery-item"><img src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Nnx8aG91c2V8ZW58MHx8MHx8fDA%3D&auto=format&fit=crop&w=600&q=60" alt="Single-family home for sale"></div>
    <div class="gallery-item"><img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTB8fGhvdXNlfGVufDB8fDB8fHww&auto=format&fit=crop&w=600&q=60" alt="Luxury mansion for sale"></div>
    <div class="gallery-item"><img src="https://images.unsplash.com/photo-1568605114967-8130f3a36994?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NHx8aG91c2V8ZW58MHx8MHx8fDA%3D&auto=format&fit=crop&w=600&q=60" alt="Modern townhouse for sale"></div>
</div>
        </section>

        <section id="reviews" class="section">
    <h2 class="section-title">What Our Customers Say</h2>
    <div class="reviews-container">
        <div class="review-card">
            <div class="review-header">
                <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="John Doe" class="reviewer-image">
                <div class="reviewer-info">
                    <h3 class="reviewer-name">John Doe</h3>
                    <div class="rating">
                        <span class="star">&#9733;</span>
                        <span class="star">&#9733;</span>
                        <span class="star">&#9733;</span>
                        <span class="star">&#9733;</span>
                        <span class="star">&#9733;</span>
                    </div>
                </div>
            </div>
            <p class="review-text">"Great service! Found my dream home in no time. The team at House Market was incredibly helpful and made the entire process smooth and stress-free."</p>
        </div>
        <div class="review-card">
            <div class="review-header">
                <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Jane Smith" class="reviewer-image">
                <div class="reviewer-info">
                    <h3 class="reviewer-name">Jane Smith</h3>
                    <div class="rating">
                        <span class="star">&#9733;</span>
                        <span class="star">&#9733;</span>
                        <span class="star">&#9733;</span>
                        <span class="star">&#9733;</span>
                        <span class="star">&#9734;</span>
                    </div>
                </div>
            </div>
            <p class="review-text">"Professional and friendly staff. Highly recommended! They went above and beyond to ensure I found the perfect property that met all my requirements."</p>
        </div>
        <div class="review-card">
            <div class="review-header">
                <img src="https://randomuser.me/api/portraits/men/67.jpg" alt="Mike Johnson" class="reviewer-image">
                <div class="reviewer-info">
                    <h3 class="reviewer-name">Mike Johnson</h3>
                    <div class="rating">
                        <span class="star">&#9733;</span>
                        <span class="star">&#9733;</span>
                        <span class="star">&#9733;</span>
                        <span class="star">&#9733;</span>
                        <span class="star">&#9733;</span>
                    </div>
                </div>
            </div>
            <p class="review-text">"Smooth process from start to finish. Thank you! House Market made selling my property a breeze. Their market insights and negotiation skills were invaluable."</p>
        </div>
    </div>
</section>
<section id="contact" class="section">
    <h2 class="section-title">Contact Us</h2>
    <div class="contact-content">
        <form id="contactForm">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="message">Message:</label>
                <textarea id="message" name="message" required></textarea>
            </div>
            <button type="submit" class="btn">Send Message</button>
        </form>
        <div id="formMessage"></div>
        <div class="contact-info">
            <p>Email: hrithikmyageri.com</p>
            <p>Phone:1535336839</p>
            <p>Address: goa </p>
        </div>
    </div>
</section>
    </main>

    <footer>
        <p>&copy; 2024  Hritik. All rights reserved.</p>
    </footer>
    <script>
    document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    let formData = new FormData(this);
    
    fetch('process_contact.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('formMessage').innerHTML = '<p style="color: green;">' + data.message + '</p>';
            document.getElementById('contactForm').reset();
        } else {
            document.getElementById('formMessage').innerHTML = '<p style="color: red;">' + data.message + '</p>';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('formMessage').innerHTML = '<p style="color: red;">thanks you  for contacting us </p>';
    });
});
</script>
</body>
</html>