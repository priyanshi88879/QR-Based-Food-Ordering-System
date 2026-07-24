<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart QR Restaurant Ordering</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #ffffff;
        }
        #img{
            border-radius: 100px;
            width: 200px;
            height: 50px;
        }

        .navbar {
            background: #1e40af;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
            animation: slideDown 0.5s ease-out;
        }

        @keyframes slideDown {
            from { transform: translateY(-100%); }
            to { transform: translateY(0); }
        }

        .hero-section {
            position: relative;
            overflow: hidden;
            height: 600px;
        }

        .carousel-container {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .carousel-slide {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 1s ease-in-out;
            background-size: cover;
            background-position: center;
        }

        .carousel-slide.active {
            opacity: 1;
        }

        .carousel-slide::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.6));
        }

        .carousel-dots {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
            z-index: 10;
        }

        .carousel-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .carousel-dot.active {
            background: white;
            width: 30px;
            border-radius: 6px;
        }

        .glass {
            background: white;
            backdrop-filter: blur(10px);
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .fade-in {
            animation: fadeIn 0.6s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .slide-up {
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                transform: translateY(100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .menu-item {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .menu-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }

        .menu-item img {
            transition: transform 0.3s ease;
        }

        .menu-item:hover img {
            transform: scale(1.1);
        }

        .btn-primary {
            background: #2563eb;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: #1d4ed8;
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        .cart-badge {
            animation: pop 0.3s ease;
        }

        @keyframes pop {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.2); }
        }

        .category-btn {
            transition: all 0.3s ease;
        }

        .category-btn.active {
            background: #2563eb;
            color: white;
        }

        .floating {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .feature-card {
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-10px);
        }

        .search-bar {
            transition: all 0.3s ease;
        }

        .search-bar:focus-within {
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
            border: 1px solid #3b82f6;
        }

        .menu-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 12px;
        }

        .detail-image {
            width: 100%;
            height: 350px;
            object-fit: cover;
            border-radius: 16px;
        }

        .shimmer {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        .nav-link {
            position: relative;
            transition: color 0.3s ease;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: white;
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .page-container {
            display: none;
        }

        .page-container.active {
            display: block;
        }

        footer {
            background: #1e40af;
            color: white;
        }

        .toast {
            position: fixed;
            top: 100px;
            right: 20px;
            background: white;
            padding: 16px 24px;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            gap: 12px;
            z-index: 1000;
            animation: slideInRight 0.4s ease-out;
            border-left: 4px solid #2563eb;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .toast.hide {
            animation: slideOutRight 0.4s ease-out forwards;
        }

        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(400px);
                opacity: 0;
            }
        }

        .loader {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #2563eb;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 40px auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="max-w-7xl mx-auto px-4 py-2">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
                        <span class="text-2xl"><img src="WhatsApp Image 2025-11-10 at 7.04.06 PM.jpeg" id="img"></span>
                    </div>
                    <div>
                        <h1 class="text-white text-xl font-bold">Quick Bite</h1>
                        <p class="text-gray-300 text-xs">QR</p>
                    </div>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center gap-6">
                    <a href="#" class="nav-link text-white font-medium" data-page="home">Home</a>
                    <a href="#" class="nav-link text-white font-medium" data-page="about">About</a>
                    <a href="#" class="nav-link text-white font-medium" data-page="contact">Contact</a>
                    <a href="logout.php" class="text-white" >Logout</a>
                </div>

                <div class="flex items-center gap-3">
                    <button id="searchBtn" class="p-2 bg-white bg-opacity-20 rounded-lg hover:bg-opacity-30 transition">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                    <button id="cartBtn" class="relative p-2 bg-white bg-opacity-20 rounded-lg hover:bg-opacity-30 transition">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span id="cartCount" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center cart-badge">0</span>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Home Page -->
    <div id="homePage" class="page-container active">
        <!-- Hero Section with Carousel -->
        <section class="hero-section">
            <div class="carousel-container">
                <div class="carousel-slide active" style="background-image: url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=1920&h=1080&fit=crop')"></div>
                <div class="carousel-slide" style="background-image: url('https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=1920&h=1080&fit=crop')"></div>
                <div class="carousel-slide" style="background-image: url('https://images.unsplash.com/photo-1552566626-52f8b828add9?w=1920&h=1080&fit=crop')"></div>
                <div class="carousel-slide" style="background-image: url('https://images.unsplash.com/photo-1424847651672-bf20a4b0982b?w=1920&h=1080&fit=crop')"></div>
                
                <div class="absolute inset-0 flex items-center justify-center z-10">
                    <div class="text-center text-white fade-in px-4">
                        <h2 class="text-4xl md:text-6xl font-bold mb-4">Welcome to Bistro Delights</h2>
                        <p class="text-lg md:text-xl text-gray-100 mb-8 max-w-2xl mx-auto">Scan, Browse, Order - Experience seamless dining with our smart QR-based ordering system</p>
                        <div class="flex justify-center gap-4 flex-wrap">
                            <div class="bg-white bg-opacity-20 backdrop-blur-lg rounded-xl p-6 feature-card">
                                <div class="text-4xl mb-2">⚡</div>
                                <h3 class="font-semibold mb-1">Quick Orders</h3>
                                <p class="text-sm text-gray-100">Order in seconds</p>
                            </div>
                            <div class="bg-white bg-opacity-20 backdrop-blur-lg rounded-xl p-6 feature-card">
                                <div class="text-4xl mb-2">🔒</div>
                                <h3 class="font-semibold mb-1">Safe & Secure</h3>
                                <p class="text-sm text-gray-100">Contactless dining</p>
                            </div>
                            <div class="bg-white bg-opacity-20 backdrop-blur-lg rounded-xl p-6 feature-card">
                                <div class="text-4xl mb-2">💳</div>
                                <h3 class="font-semibold mb-1">Easy Payment</h3>
                                <p class="text-sm text-gray-100">Multiple options</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="carousel-dots">
                    <span class="carousel-dot active" data-slide="0"></span>
                    <span class="carousel-dot" data-slide="1"></span>
                    <span class="carousel-dot" data-slide="2"></span>
                    <span class="carousel-dot" data-slide="3"></span>
                </div>
            </div>
        </section>

        <div class="max-w-7xl mx-auto px-4 py-8">
            <!-- Search Bar -->
            <div id="searchContainer" class="hidden mb-6 fade-in">
                <div class="glass p-4 search-bar">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" id="searchInput" placeholder="Search for dishes..." class="flex-1 bg-transparent outline-none text-gray-700">
                        <button id="closeSearch" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Categories -->
            <div class="mb-8 fade-in">
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Browse Menu</h3>
                <div id="categoriesContainer" class="flex gap-3 overflow-x-auto pb-2">
                    <div class="loader"></div>
                </div>
            </div>

            <!-- Menu Items Grid -->
            <div id="menuContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-24">
                <div class="col-span-full"><div class="loader"></div></div>
            </div>
        </div>
    </div>

    <!-- Menu Page (Detail View) -->
    <div id="menuPage" class="page-container">
        <div class="max-w-4xl mx-auto px-4 py-8">
            <button id="backBtn" class="flex items-center gap-2 text-gray-600 hover:text-gray-800 mb-6 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Menu
            </button>
            
            <div id="itemDetail" class="glass p-6 fade-in"></div>
        </div>
    </div>

    <!-- About Page -->
    <div id="aboutPage" class="page-container">
        <div class="max-w-5xl mx-auto px-4 py-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-8 text-center">About Bistro Delights</h2>
            <div class="grid md:grid-cols-2 gap-8 mb-12">
                <div class="glass p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Our Story</h3>
                    <p class="text-gray-600 mb-4">Founded in 2020, Bistro Delights has been serving exquisite cuisine with a passion for culinary excellence. Our mission is to provide an unforgettable dining experience combining traditional recipes with modern innovation.</p>
                    <p class="text-gray-600">With our smart QR-based ordering system, we're revolutionizing the dining experience, making it seamless, contactless, and convenient.</p>
                </div>
                <div class="glass p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Why Choose Us?</h3>
                    <ul class="space-y-3 text-gray-600">
                        <li class="flex items-start gap-2">
                            <span class="text-blue-400 font-bold">✓</span>
                            <span>Fresh, locally-sourced ingredients</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-blue-400 font-bold">✓</span>
                            <span>Expert chefs with decades of experience</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-blue-400 font-bold">✓</span>
                            <span>Contactless ordering & payment</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-blue-400 font-bold">✓</span>
                            <span>Ambiance that feels like home</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Page -->
    <div id="contactPage" class="page-container">
        <div class="max-w-4xl mx-auto px-4 py-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-8 text-center">Get in Touch</h2>
            <div class="grid md:grid-cols-2 gap-8">
                <div class="glass p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Contact Information</h3>
                    <div class="space-y-4 text-gray-600">
                        <div class="flex items-start gap-3">
                            <span class="text-2xl">📍</span>
                            <div>
                                <p class="font-semibold">Address</p>
                                <p>123 Culinary Street, Food District<br>Lucknow, UP 226001</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="text-2xl">📞</span>
                            <div>
                                <p class="font-semibold">Phone</p>
                                <p>+91 98765 43210</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="text-2xl">✉️</span>
                            <div>
                                <p class="font-semibold">Email</p>
                                <p>contact@bistrodelights.com</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="text-2xl">🕐</span>
                            <div>
                                <p class="font-semibold">Hours</p>
                                <p>Mon-Sun: 11:00 AM - 11:00 PM</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="glass p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Send a Message</h3>
                    <div class="space-y-4">
                        <input type="text" placeholder="Your Name" class="w-full p-3 border rounded-lg outline-none focus:border-blue-500 transition">
                        <input type="email" placeholder="Your Email" class="w-full p-3 border rounded-lg outline-none focus:border-blue-500 transition">
                        <textarea placeholder="Your Message" rows="4" class="w-full p-3 border rounded-lg outline-none focus:border-blue-500 transition"></textarea>
                        <button class="w-full btn-primary text-white py-3 rounded-lg font-semibold">Send Message</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="mt-16">
        <div class="max-w-7xl mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <span class="text-3xl">🍽️</span>
                        <h3 class="text-xl font-bold">Bistro Delights</h3>
                    </div>
                    <p class="text-gray-300 text-sm">Experience culinary excellence with our smart ordering system.</p>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-gray-300 text-sm">
                        <li><a href="#" class="hover:text-white transition opacity-70 hover:opacity-100">Home</a></li>
                        <li><a href="#" class="hover:text-white transition opacity-70 hover:opacity-100">About</a></li>
                        <li><a href="#" class="hover:text-white transition opacity-70 hover:opacity-100">Contact</a></li>
                        <li><a href="review.php" class="hover:text-white transition opacity-70 hover:opacity-100">Rate Us</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Categories</h4>
                    <ul class="space-y-2 text-gray-300 text-sm">
                        <li><a href="#" class="hover:text-white transition opacity-70 hover:opacity-100">Starters</a></li>
                        <li><a href="#" class="hover:text-white transition opacity-70 hover:opacity-100">Main Course</a></li>
                        <li><a href="#" class="hover:text-white transition opacity-70 hover:opacity-100">Desserts</a></li>
                        <li><a href="#" class="hover:text-white transition opacity-70 hover:opacity-100">Beverages</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Follow Us</h4>
                    <div class="flex gap-3">
                        <a href="#" class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center hover:bg-opacity-30 transition">
                            <span>📘</span>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center hover:bg-opacity-30 transition">
                            <span>📸</span>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center hover:bg-opacity-30 transition">
                            <span>🐦</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-600 mt-8 pt-8 text-center text-gray-300 text-sm">
                <p>&copy; 2025 Bistro Delights. All rights reserved. | Designed with ❤️</p>
            </div>
        </div>
    </footer>

    <!-- Cart Modal -->
    <div id="cartModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50">
    <div class="absolute bottom-0 left-0 right-0 glass rounded-t-3xl p-6 slide-up max-h-[90vh] overflow-y-auto">

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Your Order</h2>
            <button id="closeCart" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- USER DETAILS FORM -->
        <div class="space-y-4 mb-6 bg-gray-50 p-4 rounded-xl">
            <input id="customerName" type="text" 
                   placeholder="Your Name" 
                   class="w-full p-3 rounded-lg border focus:ring-2 focus:ring-blue-500">

            <input id="customerPhone" type="text" 
                   placeholder="Phone Number" 
                   class="w-full p-3 rounded-lg border focus:ring-2 focus:ring-blue-500">

            <input id="tableNumber" type="text" 
                   placeholder="Table Number" 
                   class="w-full p-3 rounded-lg border focus:ring-2 focus:ring-blue-500">
        </div>

        <div id="cartItems" class="space-y-3 mb-6"></div>

        <div class="border-t pt-4">
            <div class="space-y-2 mb-4">
                <div class="flex justify-between text-gray-600">
                    <span>Subtotal</span>
                    <span id="subtotal">₹0</span>
                </div>
                <div class="flex justify-between text-gray-600">
                    <span>GST (5%)</span>
                    <span id="gst">₹0</span>
                </div>
                <div class="flex justify-between items-center text-lg font-bold text-gray-800 pt-2 border-t">
                    <span>Total</span>
                    <span id="totalPrice" class="text-2xl text-blue-600">₹0</span>
                </div>
            </div>

            <button id="placeOrder" 
                    class="w-full btn-primary text-white py-4 rounded-xl font-semibold text-lg disabled:opacity-50 disabled:cursor-not-allowed">
                Place Order
            </button>
        </div>
    </div>
</div>


    <!-- Success Modal -->
    <div id="successModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="glass p-8 max-w-sm w-full text-center fade-in">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 floating">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Order Placed Successfully!</h3>
            <p class="text-gray-600 mb-2">Your order has been sent to the kitchen.</p>
            <p class="text-sm text-gray-500 mb-6" id="estimatedTime">Estimated time: 20-25 minutes</p>
            <button id="closeSuccess" class="btn-primary text-white px-8 py-3 rounded-xl font-semibold">
                Continue Ordering
            </button>
        </div>
    </div>

    <script>
        // API Configuration
        const API_BASE = 'api/';
        
        let menuItems = [];
        let cart = {};
        let currentCategory = 'all';
        let searchQuery = '';
        let currentSlide = 0;
        let carouselInterval;

        // Fetch menu items from database
        async function fetchMenuItems(category = 'all', search = '') {
            try {
                const url = `${API_BASE}get_menu_items.php?category=${category}&search=${encodeURIComponent(search)}`;
                const response = await fetch(url);
                const data = await response.json();
                
                if (data.success) {
                    menuItems = data.data;
                    renderMenu();
                } else {
                    console.error('Error fetching menu:', data.message);
                    showError('Failed to load menu items');
                }
            } catch (error) {
                console.error('Error:', error);
                showError('Failed to connect to server');
            }
        }

        // Fetch categories from database
        async function fetchCategories() {
            try {
                const response = await fetch(`${API_BASE}get_categories.php`);
                const data = await response.json();
                
                if (data.success) {
                    renderCategories(data.data);
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }

        // Render categories
        function renderCategories(categories) {
            const container = document.getElementById('categoriesContainer');
            container.innerHTML = categories.map(cat => `
                <button class="category-btn ${cat.slug === 'all' ? 'active' : ''} px-6 py-3 rounded-full bg-gray-100 text-gray-700 whitespace-nowrap font-medium shadow-sm" data-category="${cat.slug}">
                    ${cat.icon} ${cat.name}
                </button>
            `).join('');

            // Add event listeners
            document.querySelectorAll('.category-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    document.querySelectorAll('.category-btn').forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                    currentCategory = btn.dataset.category;
                    fetchMenuItems(currentCategory, searchQuery);
                });
            });
        }

        // Carousel functionality
        function initCarousel() {
            const slides = document.querySelectorAll('.carousel-slide');
            const dots = document.querySelectorAll('.carousel-dot');
            
            function showSlide(index) {
                slides.forEach(s => s.classList.remove('active'));
                dots.forEach(d => d.classList.remove('active'));
                
                slides[index].classList.add('active');
                dots[index].classList.add('active');
                currentSlide = index;
            }
            
            function nextSlide() {
                currentSlide = (currentSlide + 1) % slides.length;
                showSlide(currentSlide);
            }
            
            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    showSlide(index);
                    clearInterval(carouselInterval);
                    carouselInterval = setInterval(nextSlide, 5000);
                });
            });
            
            carouselInterval = setInterval(nextSlide, 5000);
        }

        // Navigation
        function showPage(pageName) {
            document.querySelectorAll('.page-container').forEach(page => {
                page.classList.remove('active');
            });
            document.getElementById(pageName + 'Page').classList.add('active');
            window.scrollTo(0, 0);
        }

        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const page = link.dataset.page;
                showPage(page);
            });
        });

        // Menu rendering
        function renderMenu() {
            const container = document.getElementById('menuContainer');
            
            if (menuItems.length === 0) {
                container.innerHTML = '<div class="col-span-full text-center py-12 text-gray-500"><p class="text-xl">No items found</p></div>';
                return;
            }
            
            container.innerHTML = menuItems.map(item => `
                <div class="glass p-4 menu-item fade-in" onclick="showItemDetail(${item.id})">
                    <div class="relative mb-3 overflow-hidden rounded-xl">
                        <img src="${item.img}" alt="${item.name}" class="menu-image shimmer" loading="lazy">
                        <div class="absolute top-2 right-2 bg-white px-3 py-1 rounded-full text-sm font-bold text-blue-600 shadow-lg">
                            ₹${item.price}
                        </div>
                    </div>
                    <h3 class="font-bold text-gray-800 text-lg mb-1">${item.name}</h3>
                    <p class="text-sm text-gray-600 mb-3 line-clamp-2">${item.desc}</p>
                    <button onclick="event.stopPropagation(); addToCart(${item.id})" class="w-full btn-primary text-white py-2.5 rounded-lg font-medium flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add to Cart
                    </button>
                </div>
            `).join('');
        }

        // Show item detail
        function showItemDetail(id) {
            const item = menuItems.find(i => i.id === id);
            if (!item) return;
            
            const detailContainer = document.getElementById('itemDetail');
            
            detailContainer.innerHTML = `
                <div>
                    <img src="${item.img}" alt="${item.name}" class="detail-image mb-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h2 class="text-3xl font-bold text-gray-800 mb-2">${item.name}</h2>
                            <p class="text-gray-600 mb-4">${item.fullDesc}</p>
                        </div>
                        <div class="text-3xl font-bold text-blue-600 whitespace-nowrap ml-4">₹${item.price}</div>
                    </div>
                    
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <h3 class="font-bold text-gray-800 mb-2">Ingredients</h3>
                        <p class="text-gray-600">${item.ingredients}</p>
                    </div>

                    <div class="flex gap-4">
                        <button onclick="addToCart(${item.id})" class="flex-1 btn-primary text-white py-4 rounded-xl font-semibold text-lg flex items-center justify-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add to Cart
                        </button>
                    </div>
                </div>
            `;
            
            showPage('menu');
        }

        document.getElementById('backBtn').addEventListener('click', () => {
            showPage('home');
        });

        function addToCart(id) {
            cart[id] = (cart[id] || 0) + 1;
            updateCartBadge();
            
            const badge = document.getElementById('cartCount');
            badge.classList.remove('cart-badge');
            void badge.offsetWidth;
            badge.classList.add('cart-badge');
            
            // Show toast notification
            showToast(id);
        }

        function showToast(id) {
            const item = menuItems.find(i => i.id === id);
            if (!item) return;
            
            // Remove existing toast if any
            const existingToast = document.querySelector('.toast');
            if (existingToast) {
                existingToast.remove();
            }
            
            // Create toast
            const toast = document.createElement('div');
            toast.className = 'toast';
            toast.innerHTML = `
                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-800">Added to cart!</p>
                    <p class="text-sm text-gray-600">${item.name}</p>
                </div>
            `;
            
            document.body.appendChild(toast);
            
            // Auto remove after 3 seconds
            setTimeout(() => {
                toast.classList.add('hide');
                setTimeout(() => {
                    toast.remove();
                }, 400);
            }, 3000);
        }

        function updateCartBadge() {
            const total = Object.values(cart).reduce((sum, qty) => sum + qty, 0);
            document.getElementById('cartCount').textContent = total;
        }

        function renderCart() {
            const container = document.getElementById('cartItems');
            const items = Object.entries(cart).map(([id, qty]) => {
                const item = menuItems.find(m => m.id == id);
                return item ? { ...item, qty } : null;
            }).filter(item => item !== null);

            if (items.length === 0) {
                container.innerHTML = '<div class="text-center py-12"><div class="text-6xl mb-4">🛒</div><p class="text-gray-500">Your cart is empty</p></div>';
                document.getElementById('subtotal').textContent = '₹0';
                document.getElementById('gst').textContent = '₹0';
                document.getElementById('totalPrice').textContent = '₹0';
                document.getElementById('placeOrder').disabled = true;
                return;
            }

            container.innerHTML = items.map(item => `
                <div class="flex gap-3 bg-gray-50 p-3 rounded-lg">
                    <img src="${item.img}" alt="${item.name}" class="w-20 h-20 object-cover rounded-lg">
                    <div class="flex-1">
                        <p class="font-semibold text-gray-800">${item.name}</p>
                        <p class="text-sm text-gray-600">₹${item.price} each</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button onclick="updateQty(${item.id}, -1)" class="w-8 h-8 bg-gray-200 rounded-lg font-bold hover:bg-gray-300 transition">-</button>
                        <span class="font-semibold w-8 text-center">${item.qty}</span>
                        <button onclick="updateQty(${item.id}, 1)" class="w-8 h-8 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700 transition">+</button>
                    </div>
                </div>
            `).join('');

            const subtotal = items.reduce((sum, item) => sum + (item.price * item.qty), 0);
            const gst = Math.round(subtotal * 0.05);
            const total = subtotal + gst;
            
            document.getElementById('subtotal').textContent = `₹${subtotal}`;
            document.getElementById('gst').textContent = `₹${gst}`;
            document.getElementById('totalPrice').textContent = `₹${total}`;
            document.getElementById('placeOrder').disabled = false;
        }

        function updateQty(id, change) {
            cart[id] = (cart[id] || 0) + change;
            if (cart[id] <= 0) delete cart[id];
            updateCartBadge();
            renderCart();
        }

        // Place order function
        async function placeOrder() {
            if (Object.keys(cart).length === 0) return;

            const orderData = {
                tableNumber: 'Table #12',
                items: Object.entries(cart).map(([id, quantity]) => ({
                    id: parseInt(id),
                    quantity: quantity
                }))
            };

            try {
                const response = await fetch(`${API_BASE}place_order.php`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(orderData)
                });

                const data = await response.json();

                if (data.success) {
                    document.getElementById('cartModal').classList.add('hidden');
                    document.getElementById('estimatedTime').textContent = `Estimated time: ${data.data.estimatedTime}`;
                    document.getElementById('successModal').classList.remove('hidden');
                    cart = {};
                    updateCartBadge();
                } else {
                    alert('Failed to place order: ' + data.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Failed to place order. Please try again.');
            }
        }

        function showError(message) {
            const container = document.getElementById('menuContainer');
            container.innerHTML = `
                <div class="col-span-full text-center py-12">
                    <div class="text-6xl mb-4">⚠️</div>
                    <p class="text-xl text-gray-600">${message}</p>
                    <button onclick="location.reload()" class="mt-4 btn-primary text-white px-6 py-2 rounded-lg">
                        Retry
                    </button>
                </div>
            `;
        }

        // Event Listeners
        document.getElementById('cartBtn').addEventListener('click', () => {
            document.getElementById('cartModal').classList.remove('hidden');
            renderCart();
        });

        document.getElementById('closeCart').addEventListener('click', () => {
            document.getElementById('cartModal').classList.add('hidden');
        });

        document.getElementById('searchBtn').addEventListener('click', () => {
            document.getElementById('searchContainer').classList.remove('hidden');
            document.getElementById('searchInput').focus();
        });

        document.getElementById('closeSearch').addEventListener('click', () => {
            document.getElementById('searchContainer').classList.add('hidden');
            document.getElementById('searchInput').value = '';
            searchQuery = '';
            fetchMenuItems(currentCategory, searchQuery);
        });

        document.getElementById('searchInput').addEventListener('input', (e) => {
            searchQuery = e.target.value;
            // Debounce search
            clearTimeout(window.searchTimeout);
            window.searchTimeout = setTimeout(() => {
                fetchMenuItems(currentCategory, searchQuery);
            }, 500);
        });

        document.getElementById('placeOrder').addEventListener('click', placeOrder);

        document.getElementById('closeSuccess').addEventListener('click', () => {
            document.getElementById('successModal').classList.add('hidden');
        });

        document.getElementById('cartModal').addEventListener('click', (e) => {
            if (e.target === e.currentTarget) {
                document.getElementById('cartModal').classList.add('hidden');
            }
        });

        // Initialize on page load
        window.addEventListener('DOMContentLoaded', () => {
            initCarousel();
            fetchCategories();
            fetchMenuItems();
        });
    </script>
</body>
</html>