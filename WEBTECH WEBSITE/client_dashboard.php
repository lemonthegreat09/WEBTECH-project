<?php
session_start();
if (!isset($_SESSION['client_id'])) {
    header("Location: client_login.html");
    exit;
}
$client_name = $_SESSION['client_name'];
$show_welcome = isset($_GET['welcome']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Client Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <?php if ($show_welcome): ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php endif; ?>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            padding: 0;
            background: #f4f4f4;
        }
        .services{
            font-size: 2rem;
            color: #007bff;
            text-align: center;
            margin: 20px 0;
        }
        .main-header {
            width: 100%;
            background: #007bff;
            color: #fff;
            padding: 0;
            margin: 0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
        }
        .main-header .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 70px;
        }
        .main-header .logo {
            font-size: 1.7rem;
            font-weight: bold;
            letter-spacing: 2px;
        }
        .main-header nav a {
            color: #fff;
            text-decoration: none;
            margin-left: 30px;
            font-size: 1.1rem;
            transition: color 0.2s;
        }
        .main-header nav a:hover {
            color: #ffc107;
        }
        .fullscreen-dashboard {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .welcome-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            padding-top: 60px;
        }
        .welcome-box {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.10);
            padding: 48px 40px 32px 40px;
            max-width: 600px;
            width: 100%;
            margin-bottom: 32px;
            text-align: center;
        }
        .welcome-box h2 {
            font-size: 2.2rem;
            margin-bottom: 10px;
        }
        .welcome-box p {
            font-size: 1.1rem;
            color: #444;
        }
        .company-tagline {
            margin: 0 auto 32px auto;
            text-align: center;
            font-size: 1.3rem;
            color: #007bff;
            font-weight: 500;
            letter-spacing: 1px;
        }
        .logout-btn {
            display: inline-block;
            margin-top: 30px;
            padding: 10px 24px;
            background: #f44336;
            color: #fff;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            font-size: 16px;
            transition: background 0.2s;
        }
        .logout-btn:hover {
            background: #c62828;
        }
        @media (max-width: 700px) {
            .main-header .container {
                flex-direction: column;
                height: auto;
                padding: 12px;
            }
            .welcome-box {
                padding: 24px 10px 18px 10px;
            }
        }
        .nav-btn {
            display: inline-block;
            margin: 8px 10px;
            padding: 10px 18px;
            background: #007bff;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1rem;
            transition: background 0.2s;
        }
        .nav-btn:hover {
            background: #0056b3;
        }
        .scrollable-sections section {
            border-bottom: 1px solid #eee;
        }
        .scrollable-sections section:last-child {
            border-bottom: none;
        }
        .animated-gallery {
            display: flex;
            gap: 24px;
            justify-content: center;
            margin: 40px 0 0 0;
            align-items: center;
            width: 100%;
            overflow: hidden;
            position: relative;
            height: 140px;
        }
        .gallery-img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 18px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.13);
            cursor: pointer;
            transition: transform 0.4s cubic-bezier(.4,0,.2,1), box-shadow 0.3s;
            margin: 0 8px;
            animation: slideLeft 12s linear infinite;
        }
        .gallery-img:hover {
            transform: scale(1.15) rotate(-2deg);
            box-shadow: 0 8px 32px rgba(0,0,0,0.18);
            z-index: 2;
        }
        @keyframes slideLeft {
            0% { transform: translateX(0);}
            20% { transform: translateX(0);}
            25% { transform: translateX(-130px);}
            45% { transform: translateX(-130px);}
            50% { transform: translateX(-260px);}
            70% { transform: translateX(-260px);}
            75% { transform: translateX(-390px);}
            95% { transform: translateX(-390px);}
            100% { transform: translateX(0);}
        }
        @media (max-width: 700px) {
            .animated-gallery {
                gap: 6px;
                height: 90px;
            }
            .gallery-img {
                width: 70px;
                height: 70px;
                margin: 0 3px;
            }
        }
        .img-modal {
            display: none;
            position: fixed;
            z-index: 99999;
            left: 0; top: 0;
            width: 100vw; height: 100vh;
            background: rgba(0,0,0,0.85);
            justify-content: center;
            align-items: center;
        }
        .img-modal-content {
            max-width: 80vw;
            max-height: 80vh;
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.18);
            animation: modalZoom 0.3s;
        }
        @keyframes modalZoom {
            0% { transform: scale(0.7);}
            100% { transform: scale(1);}
        }
        .img-modal-close {
            position: absolute;
            top: 40px;
            right: 60px;
            color: #fff;
            font-size: 3rem;
            font-weight: bold;
            cursor: pointer;
            z-index: 100000;
            transition: color 0.2s;
        }
        .img-modal-close:hover {
            color: #ffc107;
        }
        @media (max-width: 700px) {
            .animated-gallery {
                gap: 6px;
            }
            .gallery-img {
                width: 70px;
                height: 70px;
            }
            .img-modal-content {
                max-width: 96vw;
                max-height: 60vh;
            }
        }
        .cart-icon-container {
            position: fixed;
            top: 22px;
            right: 38px;
            z-index: 10001;
        }
        .cart-icon-btn {
            background: #fff;
            border: none;
            border-radius: 50%;
            box-shadow: 0 2px 8px rgba(0,0,0,0.13);
            width: 52px;
            height: 52px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            position: relative;
            transition: box-shadow 0.2s;
        }
        .cart-icon-btn:hover {
            box-shadow: 0 4px 16px rgba(0,123,255,0.18);
        }
        .cart-badge {
            position: absolute;
            top: 7px;
            right: 7px;
            background: #f44336;
            color: #fff;
            border-radius: 50%;
            font-size: 0.95rem;
            font-weight: bold;
            width: 22px;
            height: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2;
        }
        .cart-modal {
            display: none;
            position: fixed;
            top: 0; right: 0;
            width: 370px;
            max-width: 98vw;
            height: 100vh;
            background: #fff;
            box-shadow: -4px 0 24px rgba(0,0,0,0.13);
            z-index: 10010;
            flex-direction: column;
            padding: 0;
            animation: cartSlideIn 0.25s;
        }
        @keyframes cartSlideIn {
            0% { right: -400px; }
            100% { right: 0; }
        }
        .cart-modal-header {
            padding: 18px 24px;
            background: #007bff;
            color: #fff;
            font-size: 1.25rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .cart-modal-close {
            font-size: 2rem;
            font-weight: bold;
            color: #fff;
            cursor: pointer;
            background: none;
            border: none;
        }
        .cart-modal-body {
            padding: 18px 24px;
            flex: 1;
            overflow-y: auto;
        }
        .cart-item {
            display: flex;
            align-items: center;
            margin-bottom: 18px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .cart-item:last-child {
            border-bottom: none;
        }
        .cart-item-img {
            width: 48px;
            height: 48px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 14px;
        }
        .cart-item-info {
            flex: 1;
        }
        .cart-item-title {
            font-weight: bold;
            font-size: 1.05rem;
            margin-bottom: 2px;
        }
        .cart-item-price {
            color: #007bff;
            font-size: 1rem;
        }
        .cart-item-remove {
            background: #f44336;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 4px 10px;
            cursor: pointer;
            font-size: 0.95rem;
            margin-left: 8px;
        }
        .cart-modal-footer {
            padding: 18px 24px;
            border-top: 1px solid #eee;
            background: #fafbfc;
            text-align: right;
        }
        .cart-checkout-btn {
            background: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 10px 22px;
            font-size: 1.1rem;
            cursor: pointer;
            font-weight: bold;
        }
        .cart-empty {
            color: #888;
            text-align: center;
            margin: 40px 0;
            font-size: 1.1rem;
        }
        @media (max-width: 700px) {
            .cart-modal {
                width: 98vw;
                min-width: 0;
            }
        }
        .cart-option-modal {
            display: none;
            position: fixed;
            z-index: 10020;
            left: 0; top: 0;
            width: 100vw; height: 100vh;
            background: rgba(0,0,0,0.45);
            justify-content: center;
            align-items: center;
        }
        .cart-option-content {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.18);
            padding: 32px 28px 24px 28px;
            min-width: 320px;
            max-width: 95vw;
            text-align: left;
            position: relative;
        }
        .cart-option-close {
            position: absolute;
            top: 12px;
            right: 18px;
            font-size: 2rem;
            color: #888;
            background: none;
            border: none;
            cursor: pointer;
        }
        .cart-option-content label {
            font-weight: bold;
            margin-top: 12px;
            display: block;
        }
        .cart-option-content input[type="number"], .cart-option-content select {
            width: 100%;
            padding: 7px 10px;
            margin: 7px 0 14px 0;
            border-radius: 5px;
            border: 1px solid #bbb;
            font-size: 1rem;
        }
        .cart-option-actions {
            text-align: right;
        }
        .cart-option-add-btn {
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 9px 22px;
            font-size: 1.05rem;
            cursor: pointer;
            font-weight: bold;
        }
        .cart-option-cancel-btn {
            background: #eee;
            color: #333;
            border: none;
            border-radius: 4px;
            padding: 9px 18px;
            font-size: 1.05rem;
            cursor: pointer;
            margin-right: 10px;
        }
        .cart-item-options {
            font-size: 0.97rem;
            color: #555;
            margin-top: 2px;
        }
    </style>
</head>
<body>
    <div id="login-toast" style="display:none;position:fixed;top:30px;left:50%;transform:translateX(-50%);background:#007bff;color:#fff;padding:18px 36px;border-radius:8px;box-shadow:0 2px 12px rgba(0,0,0,0.12);font-size:1.1rem;z-index:9999;">
        Login Successful! Welcome back, <?php echo htmlspecialchars($client_name); ?>!
    </div>
    <!-- Cart Icon -->
    <div class="cart-icon-container">
        <button class="cart-icon-btn" id="cart-icon-btn" title="View Cart">
            <span style="font-size:2rem; color:#007bff;">
                <!-- SVG Cart Icon -->
                <svg width="28" height="28" fill="none" viewBox="0 0 24 24">
                    <path d="M7 20a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm10 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zM7.2 16h9.6c.9 0 1.7-.6 1.9-1.5l2.3-8.7A1 1 0 0 0 20 4H6.2l-.3-1.3A2 2 0 0 0 4 2H1a1 1 0 1 0 0 2h2.2l3.6 14.3A2 2 0 0 0 8.7 20h8.6a1 1 0 1 0 0-2H8.7a.5.5 0 0 1-.5-.4L7.2 16z" fill="#007bff"/>
                </svg>
            </span>
            <span class="cart-badge" id="cart-badge">0</span>
        </button>
    </div>
    <!-- Cart Modal -->
    <div class="cart-modal" id="cart-modal">
        <div class="cart-modal-header">
            <span>My Cart</span>
            <button class="cart-modal-close" id="cart-modal-close" title="Close">&times;</button>
        </div>
        <div class="cart-modal-body" id="cart-modal-body">
            <!-- Cart items will be rendered here -->
        </div>
        <div class="cart-modal-footer">
            <div id="cart-modal-footer-total"></div>
            <button class="cart-checkout-btn" id="cart-checkout-btn">Checkout</button>
        </div>
    </div>
    <!-- Add to Cart Options Modal -->
    <div class="cart-option-modal" id="cart-option-modal">
        <div class="cart-option-content">
            <button class="cart-option-close" id="cart-option-close" title="Close">&times;</button>
            <div id="cart-option-product" style="font-weight:bold; font-size:1.1rem; margin-bottom:10px;"></div>
            <form id="cart-option-form">
                <label for="cart-option-qty">Quantity</label>
                <input type="number" id="cart-option-qty" name="qty" min="1" value="1" required>
                <label for="cart-option-color">Color</label>
                <select id="cart-option-color" name="color" required>
                    <option value="Natural">Natural</option>
                    <option value="Black">Black</option>
                    <option value="White">White</option>
                    <option value="Red">Red</option>
                    <option value="Blue">Blue</option>
                    <option value="Sunburst">Sunburst</option>
                    <option value="Custom">Custom</option>
                </select>
                <div class="cart-option-actions" style="margin-top:18px;">
                    <button type="button" class="cart-option-cancel-btn" id="cart-option-cancel">Cancel</button>
                    <button type="submit" class="cart-option-add-btn">Add to Cart</button>
                </div>
            </form>
        </div>
    </div>
    <div class="fullscreen-dashboard">
        <header class="main-header">
            <div class="container">
                <div class="logo">Harmony Haven</div>
                <nav id="main-nav">
                    <a href="#home" class="nav-link" id="home-link">Homepages</a>
                    <a href="#about" class="nav-link" id="about-link">About Us Pages</a>
                    <a href="#services" class="nav-link" id="services-link">Services/Product Page</a>
                    <a href="#contact" class="nav-link" id="contact-link">Contact Us</a>
                    <a href="#portal" class="nav-link" id="portal-link">User Portal</a>
                    <a href="client_logout.php" style="margin-left:30px;">Logout</a>
                </nav>
            </div>
        </header>
        <div id="homepage-image-section" style="display:none; width:100%; height:calc(100vh - 70px); background:#222; align-items:center; justify-content:center; flex-direction:column; position:relative;">
            <button id="back-to-home-content" title="Back" style="position:absolute;top:30px;left:30px;background:rgba(0,0,0,0.6);border:none;border-radius:50%;width:48px;height:48px;display:flex;align-items:center;justify-content:center;cursor:pointer;z-index:10;">
                <span style="font-size:2rem;color:#fff;">&#8592;</span>
            </button>
            <div style="display:flex; flex-direction:column; align-items:center; justify-content:center; width:100%; height:100%; overflow-y:auto;">
                <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=900&q=80" alt="Homepage Banner" style="max-width:100%; max-height:70vh; border-radius:18px; margin:40px auto 20px auto; display:block;">
                <h2 style="color:#fff; text-align:center; margin-top:20px;">Welcome to Harmony Haven</h2>
            </div>
        </div>
        <div id="homepage-content">
            <!-- WELCOME SECTION -->
            <section class="welcome-section" style="min-height:100vh; display:flex; flex-direction:column; align-items:center; justify-content:center;">
                <div id="welcome" class="welcome-box" style="max-width:900px; width:100%; padding:60px 50px 40px 50px;">
                    <h2 style="font-size:2.7rem;">Welcome, <?php echo htmlspecialchars($client_name); ?>!</h2>
                    <p style="font-size:1.35rem; color:#007bff; margin-bottom:28px;">
                        We're glad to have you back at <strong>Harmony Haven</strong>.<br>
                        Explore your dashboard and discover new features designed just for you!
                    </p>
                    <div style="margin: 30px 0;">
                        <img src="https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=900&q=80" alt="Welcome" style="width:180px; border-radius:50%; box-shadow:0 4px 16px rgba(0,0,0,0.13);">
                    </div>
                    <!-- Animated Image Gallery -->
                    <div class="animated-gallery">
                        <img class="gallery-img" src="https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=400&q=80" alt="Piano">
                        <img class="gallery-img" src="https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=400&q=80" alt="Drum Set">
                        <img class="gallery-img" src="https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?auto=format&fit=crop&w=400&q=80" alt="Electric Guitar">
                        <img class="gallery-img" src="https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=400&q=80" alt="Violin">
                        <img class="gallery-img" src="https://images.unsplash.com/photo-1509228468518-180dd4864904?auto=format&fit=crop&w=400&q=80" alt="Saxophone">
                    </div>
                </div>
            </section>
            <!-- Modal for enlarged image -->
            <div id="img-modal" class="img-modal">
                <span class="img-modal-close" id="img-modal-close">&times;</span>
                <img class="img-modal-content" id="img-modal-img">
            </div>
            <!-- COMPANY INTRO/TAGLINE SECTION -->
            <section class="company-tagline" style="min-height:60vh; display:flex; flex-direction:column; align-items:center; justify-content:center;">
                <h2 style="color:#007bff; margin-bottom:18px; font-size:2.2rem;">Experience the World of Instruments</h2>
                <p style="max-width:900px; text-align:center; font-size:1.35rem; color:#222;">
                    <strong>Harmony Haven</strong> is your gateway to the beauty and diversity of musical instruments.<br>
                    <span style="color:#444;">From classic pianos to modern electric guitars, we celebrate the art of sound and craftsmanship.</span>
                </p>
                <div style="margin:30px 0;">
                    <img src="https://images.unsplash.com/photo-1513883049090-d0b7439799bf?auto=format&fit=crop&w=900&q=80" alt="Instrument Collection" style="width:220px; border-radius:18px; box-shadow:0 4px 16px rgba(0,0,0,0.10);">
                </div>
            </section>
            <!-- FEATURE HIGHLIGHTS OR ETC SECTION -->
            <section style="min-height:60vh; display:flex; flex-direction:column; align-items:center; justify-content:center;">
                <h3 style="color:#333; margin-bottom:18px; font-size:2rem;">Why Choose Instruments?</h3>
                <ul style="list-style:none; padding:0; max-width:900px; text-align:left; font-size:1.25rem;">
                    <li style="margin-bottom:18px;">
                        <span style="color:#007bff; font-weight:bold;">🎹 Piano:</span>
                        <span>Timeless elegance and versatility for classical and modern music.</span>
                    </li>
                    <li style="margin-bottom:18px;">
                        <span style="color:#007bff; font-weight:bold;">🥁 Drums:</span>
                        <span>The heartbeat of every band, bringing rhythm and energy to every performance.</span>
                    </li>
                    <li style="margin-bottom:18px;">
                        <span style="color:#007bff; font-weight:bold;">🎸 Guitar:</span>
                        <span>From acoustic warmth to electric power, guitars shape the sound of generations.</span>
                    </li>
                    <li style="margin-bottom:18px;">
                        <span style="color:#007bff; font-weight:bold;">🎻 Violin:</span>
                        <span>Expressive and soulful, the violin connects emotion and melody.</span>
                    </li>
                    <li style="margin-bottom:18px;">
                        <span style="color:#007bff; font-weight:bold;">🎷 Saxophone:</span>
                        <span>Iconic in jazz and pop, the saxophone adds color and flair to any ensemble.</span>
                    </li>
                </ul>
                <div style="margin:30px 0;">
                    <img src="https://images.unsplash.com/photo-1465101178521-c3a6088bfa9d?auto=format&fit=crop&w=900&q=80" alt="Instrument Details" style="width:220px; border-radius:18px; box-shadow:0 4px 16px rgba(0,0,0,0.10);">
                </div>
            </section>
            <!-- CONTACT QUICK INFO -->
            <section style="min-height:40vh; display:flex; flex-direction:column; align-items:center; justify-content:center;">
                <h3 style="color:#333; margin-bottom:14px; font-size:2rem;">Let's Make Music Together!</h3>
                <p style="font-size:1.25rem; max-width:900px; text-align:center;">
                    Have questions about instruments or want to start your musical journey?<br>
                    Contact our team at <a href="mailto:instruments@harmonyhaven.com" style="color:#007bff;">instruments@harmonyhaven.com</a>
                    or call <span style="color:#007bff;">(123) 456-7890</span>.<br>
                    Visit our <a href="#contact" style="color:#007bff;">Contact Us</a> page for more ways to connect.
                </p>
                <div style="margin:30px 0;">
                    <img src="https://images.unsplash.com/photo-1503676382389-4809596d5290?auto=format&fit=crop&w=900&q=80" alt="Contact Instruments" style="width:220px; border-radius:18px; box-shadow:0 4px 16px rgba(0,0,0,0.10);">
                </div>
            </section>
        </div>
        <div id="about-content" style="display:none;">
            <section id="about" style="min-height:100vh; display:flex; flex-direction:column; align-items:center; justify-content:center;">
                <h2 style="font-size:2.5rem; color:#007bff; margin-bottom:18px;">About Harmony Haven Instruments</h2>
                <div style="max-width:900px; text-align:center; font-size:1.25rem; color:#222; margin-bottom:30px;">
                    <p>
                        <strong>Harmony Haven</strong> is dedicated to inspiring musicians and music lovers by providing the finest selection of musical instruments. 
                        Our passion for music drives us to curate a diverse collection, from timeless classics to modern marvels, ensuring every artist finds their perfect sound.
                    </p>
                    <p>
                        Our team is composed of experienced musicians, instrument experts, and music educators who believe in the power of music to connect, heal, and inspire.
                        Whether you are a beginner or a professional, we are here to support your musical journey.
                    </p>
                </div>
                <div style="display:flex; flex-wrap:wrap; justify-content:center; gap:30px; margin-bottom:30px;">
                    <img class="about-img" src="https://images.unsplash.com/photo-1465101178521-c3a6088bfa9d?auto=format&fit=crop&w=400&q=80" alt="Instrument Shop" style="width:220px; border-radius:18px; box-shadow:0 4px 16px rgba(0,0,0,0.10); cursor:pointer;">
                    <img class="about-img" src="https://images.unsplash.com/photo-1513883049090-d0b7439799bf?auto=format&fit=crop&w=400&q=80" alt="Instrument Display" style="width:220px; border-radius:18px; box-shadow:0 4px 16px rgba(0,0,0,0.10); cursor:pointer;">
                    <img class="about-img" src="https://images.unsplash.com/photo-1503676382389-4809596d5290?auto=format&fit=crop&w=400&q=80" alt="Music Class" style="width:220px; border-radius:18px; box-shadow:0 4px 16px rgba(0,0,0,0.10); cursor:pointer;">
                </div>
                <div style="max-width:900px; text-align:center; font-size:1.15rem; color:#444;">
                    <h3 style="color:#007bff; margin-bottom:10px;">Our Mission</h3>
                    <p>
                        To make music accessible to everyone by offering quality instruments, expert advice, and a welcoming community for all musicians.
                    </p>
                    <h3 style="color:#007bff; margin-bottom:10px;">Our Vision</h3>
                    <p>
                        To be the leading hub for musical inspiration, learning, and creativity—where every note finds its voice.
                    </p>
                </div>
                <div style="margin-top:30px;">
                    <h3 style="color:#007bff;">Meet Our Team</h3>
                    <ul style="list-style:none; padding:0; margin:0; font-size:1.1rem;">
                        <li style="margin:10px 0;"><strong>ishsha Lopez</strong> – Founder & Guitarist,kyut</li>
                        <li style="margin:10px 0;"><strong>Enrique Rene</strong> – Guitar Specialist</li>
                        <li style="margin:10px 0;"><strong>Anna Santos</strong> – Violin Instructor</li>
                        <li style="margin:10px 0;"><strong>Leo Garcia</strong> – Drum & Percussion Expert</li>
                        <li style="margin:10px 0;"><strong>Mike Tan</strong> – Saxophone & Wind Instruments</li>
                    </ul>
                </div>
            </section>
        </div>
        <div id="services-content" style="display:none;">
            <section id="services" style="min-height:100vh; width:100vw; max-width:100vw; display:flex; flex-direction:column; align-items:center; justify-content:center; background:#fff;">
                <h2 style="margin-bottom:18px; font-size:2.2rem; color:#007bff; letter-spacing:1px;">Our Services / Products</h2>
                <!-- Product Grid Start -->
                <div style="margin-top:40px; width:100vw; max-width:100vw; overflow-x:auto;">
                    <table style="border-collapse:collapse; width:100vw; min-width:1300px; background:#fff; box-shadow:0 2px 12px rgba(0,0,0,0.07);">
                        <thead>
                            <tr style="background:#f7f7f7;">
                                <th style="padding:14px 8px; font-size:1.1rem; border:1px solid #eee;">Image</th>
                                <th style="padding:14px 8px; font-size:1.1rem; border:1px solid #eee;">Product Name</th>
                                <th style="padding:14px 8px; font-size:1.1rem; border:1px solid #eee;">Description</th>
                                <th style="padding:14px 8px; font-size:1.1rem; border:1px solid #eee;">Price</th>
                                <th style="padding:14px 8px; font-size:1.1rem; border:1px solid #eee;">Availability</th>
                                <th style="padding:14px 8px; font-size:1.1rem; border:1px solid #eee;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        // Expanded product list (20 items)
                        $products = [
                            ['Acoustic Guitar','Classic 6-string acoustic guitar with spruce top and mahogany back & sides.','$199','In Stock','https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?auto=format&fit=crop&w=200&q=80'],
                            ['Electric Guitar','Modern electric guitar, maple neck, dual humbuckers, perfect for rock.','$299','In Stock','https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=200&q=80'],
                            ['Digital Piano','88-key weighted digital piano with built-in speakers and MIDI support.','$499','In Stock','https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=200&q=80'],
                            ['Drum Set','5-piece drum set with cymbals, hardware, and drum throne included.','$399','Limited','https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=200&q=80'],
                            ['Violin','Full-size violin with bow, rosin, and hard case. Ideal for students.','$149','In Stock','https://images.unsplash.com/photo-1509228468518-180dd4864904?auto=format&fit=crop&w=200&q=80'],
                            ['Saxophone','Alto saxophone, gold lacquer finish, includes mouthpiece and case.','$349','In Stock','https://images.unsplash.com/photo-1503676382389-4809596d5290?auto=format&fit=crop&w=200&q=80'],
                            ['Flute','Silver concert flute, closed hole, C footjoint, with cleaning kit.','$99','In Stock','https://images.unsplash.com/photo-1513883049090-d0b7439799bf?auto=format&fit=crop&w=200&q=80'],
                            ['Ukulele','Soprano ukulele, mahogany body, geared tuners, gig bag included.','$59','In Stock','https://images.unsplash.com/photo-1465101178521-c3a6088bfa9d?auto=format&fit=crop&w=200&q=80'],
                            ['Bass Guitar','4-string bass, alder body, active electronics, great for all genres.','$259','In Stock','https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=200&q=80'],
                            ['Trumpet','Brass trumpet, medium-large bore, includes case and mouthpiece.','$129','In Stock','https://images.unsplash.com/photo-1509228468518-180dd4864904?auto=format&fit=crop&w=200&q=80'],
                            ['Cello','Full-size cello, maple back, spruce top, bow and padded bag included.','$399','Limited','https://images.unsplash.com/photo-1513883049090-d0b7439799bf?auto=format&fit=crop&w=200&q=80'],
                            ['Clarinet','Bb clarinet, ABS body, nickel keys, mouthpiece and case included.','$119','In Stock','https://images.unsplash.com/photo-1465101178521-c3a6088bfa9d?auto=format&fit=crop&w=200&q=80'],
                            ['Keyboard','61-key portable keyboard, hundreds of sounds, battery or AC powered.','$89','In Stock','https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=200&q=80'],
                            ['Cajon','Percussion cajon box, adjustable snare, birch wood, for acoustic sets.','$79','In Stock','https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=200&q=80'],
                            ['Mandolin','8-string mandolin, sunburst finish, adjustable bridge, padded gig bag.','$139','In Stock','https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?auto=format&fit=crop&w=200&q=80'],
                            ['Harmonica','Blues harmonica, 10 holes, key of C, stainless steel reeds.','$29','In Stock','https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=200&q=80'],
                            ['Accordion','Piano accordion, 41 keys, 120 bass, pearl finish, padded straps.','$249','Limited','https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=200&q=80'],
                            ['Banjo','5-string banjo, maple rim, Remo head, geared tuners.','$179','In Stock','https://images.unsplash.com/photo-1513883049090-d0b7439799bf?auto=format&fit=crop&w=200&q=80'],
                            ['Oboe','Professional oboe, grenadilla wood, silver-plated keys, hard case.','$499','In Stock','https://images.unsplash.com/photo-1465101178521-c3a6088bfa9d?auto=format&fit=crop&w=200&q=80'],
                            ['Trombone','Tenor trombone, brass body, F-attachment, mouthpiece and case.','$219','In Stock','https://images.unsplash.com/photo-1509228468518-180dd4864904?auto=format&fit=crop&w=200&q=80'],
                        ];
                        foreach ($products as $p) {
                            echo '<tr>';
                            echo '<td style="padding:14px 8px; border:1px solid #eee; text-align:center;"><img src="'.htmlspecialchars($p[4]).'" alt="'.htmlspecialchars($p[0]).'" style="width:80px; height:80px; object-fit:cover; border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,0.10);"></td>';
                            echo '<td style="padding:14px 8px; border:1px solid #eee; font-weight:bold; font-size:1.1rem;">'.htmlspecialchars($p[0]).'</td>';
                            echo '<td style="padding:14px 8px; border:1px solid #eee;">'.htmlspecialchars($p[1]).'</td>';
                            echo '<td style="padding:14px 8px; border:1px solid #eee; color:#007bff; font-weight:bold;">'.htmlspecialchars($p[2]).'</td>';
                            echo '<td style="padding:14px 8px; border:1px solid #eee; color:'.($p[3]=='In Stock'?'#28a745':'#ff9800').'; font-weight:500;">'.htmlspecialchars($p[3]).'</td>';
                            echo '<td style="padding:14px 8px; border:1px solid #eee; text-align:center;">';
                            echo '<button style="margin:0 6px 0 0; padding:7px 18px; background:#007bff; color:#fff; border:none; border-radius:4px; cursor:pointer; font-size:1rem;">Add to Cart</button>';
                            echo '<button style="padding:7px 18px; background:#28a745; color:#fff; border:none; border-radius:4px; cursor:pointer; font-size:1rem;">Buy</button>';
                            echo '</td>';
                            echo '</tr>';
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <!-- Product Grid End -->
                <!-- Enhanced Services List -->
                
                 <p class="services" >OUR SERVICES</p>
                <div style="display:flex; flex-wrap:wrap; gap:28px; justify-content:center; margin:60px auto 0 auto; max-width:1100px;">
                    <div style="flex:1 1 220px; background:#f8faff; border-radius:12px; box-shadow:0 2px 8px rgba(0,123,255,0.07); padding:28px 22px; min-width:220px; display:flex; align-items:flex-start; gap:16px;">
                        <span style="font-size:2.2rem; color:#007bff; margin-right:10px;">🛠️</span>
                        <div>
                            <div style="font-weight:bold; font-size:1.15rem; color:#222;">Instrument Repair & Maintenance</div>
                            <div style="font-size:0.98rem; color:#555;">Professional repair, cleaning, and regular maintenance for all instruments.</div>
                        </div>
                    </div>
                    <div style="flex:1 1 220px; background:#f8faff; border-radius:12px; box-shadow:0 2px 8px rgba(0,123,255,0.07); padding:28px 22px; min-width:220px; display:flex; align-items:flex-start; gap:16px;">
                        <span style="font-size:2.2rem; color:#007bff; margin-right:10px;">🎨</span>
                        <div>
                            <div style="font-weight:bold; font-size:1.15rem; color:#222;">Instrument Customization</div>
                            <div style="font-size:0.98rem; color:#555;">Personalize your instrument’s look and sound to fit your unique style.</div>
                        </div>
                    </div>
                    <div style="flex:1 1 220px; background:#f8faff; border-radius:12px; box-shadow:0 2px 8px rgba(0,123,255,0.07); padding:28px 22px; min-width:220px; display:flex; align-items:flex-start; gap:16px;">
                        <span style="font-size:2.2rem; color:#007bff; margin-right:10px;">🎼</span>
                        <div>
                            <div style="font-weight:bold; font-size:1.15rem; color:#222;">Music Lessons</div>
                            <div style="font-size:0.98rem; color:#555;">Private and group lessons for all ages and skill levels, in-store or online.</div>
                        </div>
                    </div>
                    <div style="flex:1 1 220px; background:#f8faff; border-radius:12px; box-shadow:0 2px 8px rgba(0,123,255,0.07); padding:28px 22px; min-width:220px; display:flex; align-items:flex-start; gap:16px;">
                        <span style="font-size:2.2rem; color:#007bff; margin-right:10px;">🎻</span>
                        <div>
                            <div style="font-weight:bold; font-size:1.15rem; color:#222;">Instrument Rentals</div>
                            <div style="font-size:0.98rem; color:#555;">Affordable short- and long-term rentals for students, events, and professionals.</div>
                        </div>
                    </div>
                    <div style="flex:1 1 220px; background:#f8faff; border-radius:12px; box-shadow:0 2px 8px rgba(0,123,255,0.07); padding:28px 22px; min-width:220px; display:flex; align-items:flex-start; gap:16px;">
                        <span style="font-size:2.2rem; color:#007bff; margin-right:10px;">🤝</span>
                        <div>
                            <div style="font-weight:bold; font-size:1.15rem; color:#222;">After-Sales Support</div>
                            <div style="font-size:0.98rem; color:#555;">Friendly support for setup, troubleshooting, and warranty assistance.</div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div id="contact-content" style="display:none;">
            <section id="contact" style="min-height:100vh; display:flex; flex-direction:column; align-items:center; justify-content:center;">
                <h2>Contact Us</h2>
                <!-- Google Map and Location Info -->
                <div style="max-width:600px; width:100%; margin:0 auto 24px auto; background:#fff; border-radius:14px; box-shadow:0 2px 8px rgba(0,123,255,0.09); padding:0 0 18px 0; overflow:hidden;">
                    <div style="width:100%; border-radius:14px 14px 0 0; overflow:hidden;">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15456.765187058872!2d121.03233229200892!3d14.41613332677592!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397d033da1fd649%3A0x8f60d963b066eff8!2sAlabang%2C%20Muntinlupa%2C%20Metro%20Manila!5e0!3m2!1sen!2sph!4v1747665137249!5m2!1sen!2sph" width="100%" height="260" style="border:0;display:block;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <div style="padding:18px 22px 0 22px;">
                        <div style="font-size:1.13rem; color:#222; margin-bottom:8px;">
                            <b>Our Main Location:</b> <span style="color:#007bff;">Alabang, Muntinlupa, Metro Manila</span>
                        </div>
                        <div style="font-size:1rem; color:#444;">
                            <span style="display:inline-block;margin-bottom:3px;">📍 <b>Address:</b> 123 Music Lane, Melody City, PH 1000</span><br>
                            <span style="display:inline-block;margin-bottom:3px;">☎️ <b>Phone:</b> (123) 456-7890</span><br>
                            <span style="display:inline-block;margin-bottom:3px;">✉️ <b>Email:</b> <a href="mailto:info@harmonyhaven.com" style="color:#007bff;">info@harmonyhaven.com</a></span>
                        </div>
                        <div style="margin-top:10px; color:#888; font-size:0.98rem;">
                            <b>Open Hours:</b> Mon-Sat 9:00am - 7:00pm<br>
                            <b>Landmark:</b> Near Festival Mall, Alabang
                        </div>
                    </div>
                </div>
                <!-- Comment Form -->
                <div style="max-width:600px; width:100%; margin:0 auto 30px auto; background:#fff; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,0.07); padding:28px 22px;">
                    <h3 style="margin-top:0; color:#007bff;">Send us a Message</h3>
                    <form id="contact-comment-form" autocomplete="off">
                        <input type="text" id="comment-name" placeholder="Your Name" required style="width:100%;margin-bottom:10px;padding:8px 10px;border-radius:5px;border:1px solid #bbb;font-size:1rem;">
                        <textarea id="comment-message" placeholder="Your Comment or Feedback" required style="width:100%;min-height:70px;margin-bottom:10px;padding:8px 10px;border-radius:5px;border:1px solid #bbb;font-size:1rem;"></textarea>
                        <button type="submit" style="background:#007bff;color:#fff;border:none;border-radius:4px;padding:10px 22px;font-size:1.05rem;cursor:pointer;font-weight:bold;">Submit</button>
                    </form>
                </div>
                <!-- User Feedback List -->
                <div style="max-width:600px; width:100%; margin:0 auto 30px auto;">
                    <h3 style="color:#007bff;">User Feedback</h3>
                    <div id="feedback-list" style="background:#fafbfc; border-radius:10px; min-height:60px; padding:18px 14px; box-shadow:0 2px 8px rgba(0,0,0,0.04);"></div>
                </div>
            </section>
        </div>
        <div id="portal-content" style="display:none;">
            <section id="portal" style="min-height:100vh; display:flex; flex-direction:column; align-items:center; justify-content:center;">
                <h2>User Portal</h2>
                <p style="max-width:600px; text-align:center;">Access your personalized dashboard, manage your account, and explore exclusive features here.</p>
            </section>
        </div>
    </div>
    <script>
        // Show toast notification on login (if ?welcome=1)
        <?php if ($show_welcome): ?>
        document.addEventListener('DOMContentLoaded', function() {
            var toast = document.getElementById('login-toast');
            toast.style.display = 'block';
            setTimeout(function() {
                toast.style.display = 'none';
            }, 3500);
        });
        <?php endif; ?>

        // Helper to show only one content section at a time
        function showSection(section) {
            document.getElementById('homepage-content').style.display = (section === 'home') ? '' : 'none';
            document.getElementById('about-content').style.display = (section === 'about') ? '' : 'none';
            document.getElementById('services-content').style.display = (section === 'services') ? '' : 'none';
            document.getElementById('contact-content').style.display = (section === 'contact') ? '' : 'none';
            document.getElementById('portal-content').style.display = (section === 'portal') ? '' : 'none';
            document.getElementById('homepage-image-section').style.display = 'none';
        }

        // Navigation click handlers
        document.getElementById('home-link').addEventListener('click', function(e) {
            e.preventDefault();
            showSection('home');
        });
        document.getElementById('about-link').addEventListener('click', function(e) {
            e.preventDefault();
            showSection('about');
        });
        document.getElementById('services-link').addEventListener('click', function(e) {
            e.preventDefault();
            showSection('services');
        });
        document.getElementById('contact-link').addEventListener('click', function(e) {
            e.preventDefault();
            showSection('contact');
        });
        document.getElementById('portal-link').addEventListener('click', function(e) {
            e.preventDefault();
            showSection('portal');
        });

        // If you want to keep the homepage image section feature, you can add a button to show it and a back button to return.
        document.getElementById('back-to-home-content').addEventListener('click', function() {
            showSection('home');
        });

        // Animated gallery click to enlarge
        document.querySelectorAll('.gallery-img').forEach(function(img) {
            img.addEventListener('click', function() {
                var modal = document.getElementById('img-modal');
                var modalImg = document.getElementById('img-modal-img');
                modal.style.display = 'flex';
                modalImg.src = this.src;
                modalImg.alt = this.alt;
            });
        });

        // Make About Us images clickable to enlarge
        document.querySelectorAll('.about-img').forEach(function(img) {
            img.addEventListener('click', function() {
                var modal = document.getElementById('img-modal');
                var modalImg = document.getElementById('img-modal-img');
                modal.style.display = 'flex';
                modalImg.src = this.src;
                modalImg.alt = this.alt;
            });
        });

        document.getElementById('img-modal-close').onclick = function() {
            document.getElementById('img-modal').style.display = 'none';
        };
        document.getElementById('img-modal').onclick = function(e) {
            if (e.target === this) this.style.display = 'none';
        };

        // --- CART FUNCTIONALITY WITH OPTIONS START ---
        const products = [
            <?php foreach ($products as $p) { echo json_encode($p) . ","; } ?>
        ];

        // Cart state
        function getCart() {
            return JSON.parse(localStorage.getItem('cart') || '[]');
        }
        function setCart(cart) {
            localStorage.setItem('cart', JSON.stringify(cart));
        }
        function updateCartBadge() {
            const cart = getCart();
            document.getElementById('cart-badge').textContent = cart.length;
        }
        function renderCartModal() {
            const cart = getCart();
            const body = document.getElementById('cart-modal-body');
            if (cart.length === 0) {
                body.innerHTML = '<div class="cart-empty">Your cart is empty.</div>';
                document.getElementById('cart-modal-footer-total').innerHTML = '';
                return;
            }
            let html = '';
            let total = 0;
            cart.forEach((item, idx) => {
                // Parse price (remove $ and commas)
                let price = parseFloat((item[2] || '').replace(/[^0-9.]/g, '')) || 0;
                let qty = parseInt(item[5] || 1);
                total += price * qty;
                html += `
                    <div class="cart-item">
                        <img class="cart-item-img" src="${item[4]}" alt="${item[0]}">
                        <div class="cart-item-info">
                            <div class="cart-item-title">${item[0]}</div>
                            <div class="cart-item-price">${item[2]}</div>
                            <div class="cart-item-options">
                                Qty: ${qty} &nbsp; | &nbsp; Color: ${item[6] || 'Natural'}
                            </div>
                        </div>
                        <button class="cart-item-remove" data-idx="${idx}">Remove</button>
                    </div>
                `;
            });
            body.innerHTML = html;
            document.getElementById('cart-modal-footer-total').innerHTML =
                `<div style="font-size:1.13rem; color:#222; margin-bottom:10px; text-align:right;">
                    <b>Total: </b> <span style="color:#007bff;">$${total.toFixed(2)}</span>
                </div>`;
            // Remove handlers
            body.querySelectorAll('.cart-item-remove').forEach(btn => {
                btn.onclick = function() {
                    const idx = parseInt(this.getAttribute('data-idx'));
                    const cart = getCart();
                    cart.splice(idx, 1);
                    setCart(cart);
                    updateCartBadge();
                    renderCartModal();
                };
            });
        }
        // Show/hide cart modal
        document.getElementById('cart-icon-btn').onclick = function() {
            renderCartModal();
            document.getElementById('cart-modal').style.display = 'flex';
        };
        document.getElementById('cart-modal-close').onclick = function() {
            document.getElementById('cart-modal').style.display = 'none';
        };
        document.getElementById('cart-modal').onclick = function(e) {
            if (e.target === this) this.style.display = 'none';
        };

        // --- Add to Cart Option Modal Logic ---
        let selectedProduct = null;
        function showCartOptionModal(product) {
            selectedProduct = product;
            // Use SweetAlert2 for options
            if (window.Swal) {
                Swal.fire({
                    title: 'Add to Cart',
                    html: `
                        <div style="text-align:left;">
                            <b>${product[0]}</b><br>
                            <label for="swal-qty" style="font-weight:bold;">Quantity</label>
                            <input id="swal-qty" type="number" min="1" value="1" class="swal2-input" style="width:80px;">
                            <label for="swal-color" style="font-weight:bold;">Color</label>
                            <select id="swal-color" class="swal2-input" style="width:180px;">
                                <option value="Natural">Natural</option>
                                <option value="Black">Black</option>
                                <option value="White">White</option>
                                <option value="Red">Red</option>
                                <option value="Blue">Blue</option>
                                <option value="Sunburst">Sunburst</option>
                                <option value="Custom">Custom</option>
                            </select>
                        </div>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Add to Cart',
                    preConfirm: () => {
                        const qty = parseInt(document.getElementById('swal-qty').value) || 1;
                        const color = document.getElementById('swal-color').value || "Natural";
                        if (qty < 1) {
                            Swal.showValidationMessage('Quantity must be at least 1');
                            return false;
                        }
                        return { qty, color };
                    }
                }).then((result) => {
                    if (result.isConfirmed && selectedProduct) {
                        let prodWithOptions = selectedProduct.slice();
                        prodWithOptions[5] = result.value.qty;
                        prodWithOptions[6] = result.value.color;
                        let cart = getCart();
                        cart.push(prodWithOptions);
                        setCart(cart);
                        updateCartBadge();
                        Swal.fire({
                            icon: 'success',
                            title: 'Added to Cart!',
                            showConfirmButton: false,
                            timer: 900
                        });
                    }
                });
            } else {
                // fallback to old modal if SweetAlert2 not loaded
                document.getElementById('cart-option-product').textContent = product[0];
                document.getElementById('cart-option-qty').value = 1;
                document.getElementById('cart-option-color').value = "Natural";
                document.getElementById('cart-option-modal').style.display = 'flex';
            }
        }
        function hideCartOptionModal() {
            document.getElementById('cart-option-modal').style.display = 'none';
            selectedProduct = null;
        }
        document.getElementById('cart-option-close').onclick = hideCartOptionModal;
        document.getElementById('cart-option-cancel').onclick = hideCartOptionModal;
        document.getElementById('cart-option-modal').onclick = function(e) {
            if (e.target === this) hideCartOptionModal();
        };
        document.getElementById('cart-option-form').onsubmit = function(e) {
            e.preventDefault();
            if (!selectedProduct) return;
            let qty = parseInt(document.getElementById('cart-option-qty').value) || 1;
            let color = document.getElementById('cart-option-color').value || "Natural";
            let prodWithOptions = selectedProduct.slice();
            prodWithOptions[5] = qty;
            prodWithOptions[6] = color;
            let cart = getCart();
            cart.push(prodWithOptions);
            setCart(cart);
            updateCartBadge();
            hideCartOptionModal();
        };

        // Add to Cart/Buy buttons
        document.querySelectorAll('button').forEach(btn => {
            if (btn.textContent.trim() === 'Add to Cart') {
                btn.onclick = function() {
                    let tr = btn.closest('tr');
                    let name = tr.children[1].textContent.trim();
                    let prod = products.find(p => p[0] === name);
                    if (prod) {
                        showCartOptionModal(prod);
                    }
                };
            }
            if (btn.textContent.trim() === 'Buy') {
                btn.onclick = function() {
                    let tr = btn.closest('tr');
                    let name = tr.children[1].textContent.trim();
                    let prod = products.find(p => p[0] === name);
                    if (prod) {
                        alert('Thank you for buying: ' + prod[0] + '!\n(Checkout simulation only)');
                    }
                };
            }
        });

        // Cart checkout
        document.getElementById('cart-checkout-btn').onclick = function() {
            const cart = getCart();
            if (cart.length === 0) {
                alert('Your cart is empty!');
                return;
            }
            let total = 0;
            let items = cart.map(item => {
                let price = parseFloat((item[2] || '').replace(/[^0-9.]/g, '')) || 0;
                let qty = parseInt(item[5] || 1);
                total += price * qty;
                return `${item[0]} (Qty: ${qty}, Color: ${item[6] || 'Natural'})`;
            }).join('\n');
            // SweetAlert2 for checkout confirmation
            if (window.Swal) {
                Swal.fire({
                    title: 'Checkout',
                    html: `<div style="font-size:1.1rem;text-align:left;">
                        <b>Total:</b> <span style="color:#007bff;">$${total.toFixed(2)}</span><br>
                        <b>Items:</b><br>
                        <pre style="font-size:1rem;white-space:pre-wrap;">${items}</pre>
                    </div>`,
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonText: 'Proceed',
                    cancelButtonText: 'Cancel',
                    focusConfirm: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Checkout Successful!',
                            text: `Thank you for your purchase! Total: $${total.toFixed(2)}`,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                        setCart([]);
                        updateCartBadge();
                        renderCartModal();
                        document.getElementById('cart-modal').style.display = 'none';
                    }
                });
            } else {
                // fallback
                alert('Thank you for your purchase!\nTotal: $' + total.toFixed(2) + '\nItems:\n' + items);
                setCart([]);
                updateCartBadge();
                renderCartModal();
                document.getElementById('cart-modal').style.display = 'none';
            }
        };
        updateCartBadge();
        // --- CART FUNCTIONALITY END ---

        // --- CONTACT US COMMENT & FEEDBACK FUNCTIONALITY ---
        // Store feedback in localStorage for demo (in real app, use backend)
        function getFeedbacks() {
            return JSON.parse(localStorage.getItem('hh_feedbacks') || '[]');
        }
        function setFeedbacks(arr) {
            localStorage.setItem('hh_feedbacks', JSON.stringify(arr));
        }
        function renderFeedbacks() {
            const list = document.getElementById('feedback-list');
            const feedbacks = getFeedbacks();
            if (!feedbacks.length) {
                list.innerHTML = '<div style="color:#888;">No feedback yet. Be the first to comment!</div>';
                return;
            }
            list.innerHTML = feedbacks.map(f =>
                `<div style="margin-bottom:18px;padding-bottom:10px;border-bottom:1px solid #eee;">
                    <b style="color:#007bff;">${f.name}</b>
                    <span style="color:#888;font-size:0.95rem;margin-left:8px;">${f.date}</span>
                    <div style="margin-top:4px;white-space:pre-line;">${f.message}</div>
                </div>`
            ).join('');
        }
        document.getElementById('contact-comment-form').onsubmit = function(e) {
            e.preventDefault();
            const name = document.getElementById('comment-name').value.trim() || 'Anonymous';
            const message = document.getElementById('comment-message').value.trim();
            if (!message) return;
            const date = new Date().toLocaleString();
            const feedbacks = getFeedbacks();
            feedbacks.unshift({ name, message, date });
            setFeedbacks(feedbacks);
            renderFeedbacks();
            document.getElementById('contact-comment-form').reset();
            if (window.Swal) {
                Swal.fire({icon:'success',title:'Thank you!',text:'Your feedback has been submitted.',timer:1200,showConfirmButton:false});
            }
        };
        // Render feedbacks on load
        renderFeedbacks();
    </script>
</body>
</html>
