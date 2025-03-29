<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ thống Quản lý Sản phẩm</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #43a047;
            --primary-dark: #2e7d32;
            --primary-light: #a5d6a7;
            --primary-gradient: linear-gradient(135deg, #43a047, #2e7d32);
            --secondary-color: #388e3c;
            --accent-color: #66bb6a;
            --white: #ffffff;
            --light-bg: #f8f9fa;
            --text-dark: #333333;
            --text-muted: #6c757d;
            --border-color: #e9ecef;
            --hover-bg: rgba(255, 255, 255, 0.1);
            --transition-speed: 0.2s;
        }

        /* General Styles */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9f9f9;
            color: var(--text-dark);
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        a {
            transition: all var(--transition-speed) ease;
        }

        /* Header Styles */
        .custom-navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: var(--primary-gradient);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 8px 0;
            z-index: 1000;
            transition: all 0.2s ease;
        }

        .custom-navbar.scrolled {
            padding: 6px 0;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
            background: linear-gradient(135deg, var(--primary-dark), var(--primary-color));
        }

        .navbar-container {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 15px;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.3rem;
            color: var(--white) !important;
            display: flex;
            align-items: center;
            white-space: nowrap;
            transition: transform var(--transition-speed) ease;
        }

        .navbar-brand:hover {
            transform: scale(1.02);
        }

        .navbar-brand i {
            margin-right: 6px;
            font-size: 1.4rem;
            color: var(--white);
        }

        .navbar-toggler {
            border: none;
            padding: 10px 12px;
            color: var(--white);
            font-size: 1.2rem;
            background-color: rgba(255, 255, 255, 0.15);
            border-radius: 4px;
            margin-left: auto;
            cursor: pointer;
            z-index: 1001;
        }

        .navbar-toggler i {
            color: white;
        }

        .navbar-nav {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .nav-item {
            margin: 0;
        }

        .nav-link {
            color: var(--white) !important;
            font-weight: 500;
            padding: 6px 10px !important;
            border-radius: 15px;
            font-size: 0.9rem;
            white-space: nowrap;
            transition: all var(--transition-speed) ease;
            position: relative;
        }

        .nav-link:hover {
            background-color: var(--hover-bg);
            color: var(--white) !important;
            transform: translateY(-1px);
        }

        .nav-link.active {
            background-color: var(--white);
            color: var(--primary-dark) !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .nav-link i {
            margin-right: 5px;
            font-size: 0.9rem;
        }

        /* Search Box */
        .navbar-search-box {
            position: relative;
            margin: 0 20px;
            min-width: 180px;
            max-width: 220px;
            display: flex;
            align-items: center;
        }

        .navbar-search-box form {
            width: 100%;
            position: relative;
            margin: 0;
        }

        .navbar-search-input {
            border-radius: 24px !important;
            padding: 8px 15px 8px 38px !important;
            border: none !important;
            transition: all 0.3s !important;
            font-size: 0.9rem !important;
            background-color: rgba(255, 255, 255, 0.9) !important;
            width: 100% !important;
            height: 38px !important;
            outline: none !important;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1) !important;
        }

        .navbar-search-input:focus {
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.15) !important;
            background-color: var(--white) !important;
            border-color: transparent !important;
            width: 105% !important;
            max-width: 260px !important;
        }

        .navbar-search-icon {
            position: absolute !important;
            top: 50% !important;
            left: 15px !important;
            transform: translateY(-50%) !important;
            color: var(--primary-dark) !important;
            font-size: 0.9rem !important;
            z-index: 5 !important;
            pointer-events: none !important; /* Để icon không chặn click vào input */
        }

        /* Cart Link */
        .nav-link.cart-link {
            position: relative;
        }

        .cart-link .badge {
            position: absolute;
            top: -3px;
            right: -3px;
            background-color: #ff5722;
            color: var(--white);
            font-size: 0.65rem;
            padding: 2px 5px;
            border-radius: 50%;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        }

        /* User Menu */
        .username-link {
            color: var(--primary-dark) !important;
            background-color: var(--white);
            padding: 5px 10px !important;
            border-radius: 15px;
            font-weight: 600;
            display: flex;
            align-items: center;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            font-size: 0.9rem;
        }

        .username-link:hover, 
        .username-link:focus {
            background-color: rgba(255, 255, 255, 0.9);
            color: var(--primary-dark) !important;
            transform: translateY(-1px);
        }

        .username-link i {
            font-size: 1rem;
            margin-right: 6px;
        }

        /* Admin Dropdown Link - nền trắng, chữ xanh */
        .admin-dropdown-link {
            color: var(--primary-dark) !important;
            background-color: var(--white);
            padding: 5px 10px !important;
            border-radius: 15px;
            font-weight: 600;
            display: flex;
            align-items: center;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            font-size: 0.9rem;
            margin-right: 8px;
            text-decoration: none;
        }

        .admin-dropdown-link:hover, 
        .admin-dropdown-link:focus {
            background-color: rgba(255, 255, 255, 0.9);
            color: var(--primary-dark) !important;
            transform: translateY(-1px);
            text-decoration: none;
        }

        .admin-dropdown-link i {
            font-size: 1rem;
            margin-right: 6px;
            color: var(--primary-dark);
        }

        .login-button {
            background-color: var(--white);
            color: var(--primary-dark) !important;
            padding: 5px 12px !important;
            border-radius: 15px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            font-size: 0.9rem;
        }

        .login-button:hover {
            background-color: rgba(255, 255, 255, 0.9);
            color: var(--primary-dark) !important;
            transform: translateY(-1px);
        }

        /* Header Dropdown Menu */
        .navbar .dropdown-menu {
            border-radius: 8px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
            border: none;
            padding: 6px 0;
            margin-top: 8px;
            background-color: var(--white);
            animation: slideDown 0.2s ease;
            display: none;
            position: absolute;
            right: 0;
            min-width: 200px;
            z-index: 1000;
        }

        .navbar .dropdown-menu.show {
            display: block;
        }

        .navbar .dropdown-item {
            padding: 6px 12px;
            color: var(--text-dark);
            font-size: 0.85rem;
            transition: all var(--transition-speed) ease;
            display: block;
            text-decoration: none;
        }

        .navbar .dropdown-item i {
            margin-right: 6px;
            color: var(--primary-color);
            width: 16px;
            text-align: center;
        }

        .navbar .dropdown-item:hover, 
        .navbar .dropdown-item:focus {
            background-color: var(--hover-bg);
            color: var(--primary-dark);
        }

        .navbar .dropdown-item.text-danger i {
            color: #dc3545;
        }

        .navbar .dropdown-divider {
            margin: 4px 0;
            border-top-color: var(--border-color);
        }

        .navbar .dropdown-item.active {
            background-color: #e8f5e9; /* Màu xanh nhạt */
            color: var(--primary-dark);
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-5px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Main Content Padding */
        .main-container {
        padding: 70px 15px 0;
        min-height: calc(100vh - <navbar-height> - <footer-height>);
        }
        @media (max-width: 992px) {
        .main-container {
        padding: 60px 15px 0;
        min-height: calc(100vh - <navbar-height> - <footer-height-mobile>);
            }
        }

        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .navbar-container {
                flex-wrap: wrap;
                padding: 8px 15px;
            }
            
            .navbar-toggler {
                display: block !important;
                order: 2;
            }
            
            .navbar-brand {
                flex: 1;
                order: 1;
            }
            
            .navbar-search-box {
                order: 3;
                margin: 10px 0;
                min-width: 100%;
                max-width: 100%;
                width: 100%;
            }
            
            .navbar-search-input {
                width: 100% !important;
            }
            
            .navbar-search-input:focus {
                width: 100% !important;
                max-width: 100% !important;
            }
            
            .navbar-collapse {
                order: 4;
                flex-basis: 100%;
                margin-top: 10px;
                padding-top: 10px;
                border-top: 1px solid rgba(255, 255, 255, 0.2);
            }
            
            .navbar-nav {
                margin-top: 8px;
                flex-direction: column;
                width: 100%;
            }
            
            .nav-item {
                width: 100%;
                margin: 3px 0;
            }
            
            .nav-link {
                display: block;
                text-align: left;
                padding: 10px !important;
                border-radius: 8px;
                width: 100%;
            }
            
            .nav-link i {
                width: 20px;
                text-align: center;
                margin-right: 10px;
            }
            
            .navbar-nav.ml-auto {
                margin-top: 15px;
            }
            
            .dropdown-menu-11 {
                position: static;
                width: 100%;
                box-shadow: none;
                margin-top: 5px;
                border: none;
                background-color: white !important;
                padding: 0;
            }
            
            .dropdown-item {
                padding: 10px 15px 10px 35px;
                color: var(--primary-dark) !important;
                background-color: white !important;
            }
            
            .dropdown-item i {
                color: var(--primary-dark) !important;
            }
            
            .dropdown-item:hover, 
            .dropdown-item:focus,
            .dropdown-item.active {
                background-color: rgba(232, 245, 233, 0.8) !important;
                color: var(--primary-dark) !important;
            }

            .admin-dropdown-link, 
            .username-link {
                background-color: white !important;
                color: var(--primary-dark) !important;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;
                justify-content: flex-start;
                border-radius: 8px;
            }

            .admin-dropdown-link i, 
            .username-link i {
                color: var(--primary-dark) !important;
            }

            .cart-text {
                display: inline-block !important;
                margin-left: 8px;
            }
            
            .nav-link.cart-link {
                display: flex !important;
                align-items: center !important;
            }
        }

        @media (max-width: 576px) {
            .main-container {
                padding-top: 120px !important;
            }
            
            .navbar-brand {
                font-size: 1.1rem;
            }

            .navbar-brand span {
                display: none;
            }

            .navbar-brand i {
                font-size: 1.3rem;
                margin-right: 0;
            }
            
            .nav-link {
                font-size: 0.85rem;
                padding: 8px 12px !important;
            }
            
            .cart-link .badge {
                font-size: 0.6rem;
            }
            
            .navbar-search-input {
                font-size: 0.8rem !important;
                padding: 8px 15px 8px 35px !important;
            }
            
            .navbar-search-icon {
                font-size: 0.8rem !important;
                left: 12px !important;
            }
        }

        /* Dropdown Menu 11 */
        .dropdown-menu-11 {
            border-radius: 8px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
            border: 1px solid var(--border-color);
            padding: 10px 0;
            margin-top: 8px;
            background-color: white;
            animation: slideDown 0.2s ease;
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            min-width: 220px;
            z-index: 1000;
        }

        .dropdown-menu-11.show {
            display: block;
        }

        .dropdown-menu-11 .dropdown-item {
            padding: 8px 16px;
            color: var(--text-dark);
            font-size: 0.85rem;
            transition: all var(--transition-speed) ease;
            display: block;
            text-decoration: none;
        }

        .dropdown-menu-11 .dropdown-item i {
            margin-right: 8px;
            color: var(--primary-color);
            width: 18px;
            text-align: center;
        }

        .dropdown-menu-11 .dropdown-item:hover, 
        .dropdown-menu-11 .dropdown-item:focus {
            background-color: #f8f9fa;
            color: var(--primary-dark);
        }

        .dropdown-menu-11 .dropdown-item.active {
            background-color: #e8f5e9;
            color: var(--primary-dark);
        }

        @media (max-width: 992px) {
            .dropdown-menu-11 {
                position: static;
                width: 100%;
                box-shadow: none;
                margin-top: 5px;
                border: none;
                background-color: white !important;
                padding: 0;
            }
            
            .dropdown-menu-11 .dropdown-item {
                padding: 10px 15px 10px 35px;
                color: var(--primary-dark) !important;
                background-color: white !important;
            }

            .dropdown-menu-11 .dropdown-item i {
                color: var(--primary-dark) !important;
            }
            
            .dropdown-menu-11 .dropdown-item:hover, 
            .dropdown-menu-11 .dropdown-item:focus,
            .dropdown-menu-11 .dropdown-item.active {
                background-color: rgba(232, 245, 233, 0.8) !important;
                color: var(--primary-dark) !important;
            }

            .admin-dropdown-link, 
            .username-link {
                background-color: white !important;
                color: var(--primary-dark) !important;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;
                justify-content: flex-start;
                border-radius: 8px;
            }

            .admin-dropdown-link i, 
            .username-link i {
                color: var(--primary-dark) !important;
            }
        }

        .navbar-collapse {
            display: none;
            width: 100%;
        }
        
        .navbar-collapse.show {
            display: block !important;
            visibility: visible !important;
            height: auto !important;
            opacity: 1 !important;
            overflow: visible !important;
        }
        
        @media (min-width: 993px) {
            .navbar-collapse {
                display: flex !important;
                visibility: visible !important;
                height: auto !important;
                width: auto;
            }
            
            .navbar-toggler {
                display: none !important;
            }
        }

        /* Mobile menu styles */
        .navbar-toggler {
            border: none;
            padding: 10px 12px;
            color: var(--white);
            font-size: 1.2rem;
            background-color: rgba(255, 255, 255, 0.15);
            border-radius: 4px;
            margin-left: auto;
            cursor: pointer;
            z-index: 1001;
        }
        
        .navbar-toggler i {
            color: white;
        }
        
        /* Hiển thị navbar-toggler trên mobile */
        @media (max-width: 992px) {
            .navbar-toggler {
                display: block !important;
                order: 2;
            }
            
            .navbar-collapse.show {
                display: block !important;
                visibility: visible !important;
                height: auto !important;
                opacity: 1 !important;
                overflow: visible !important;
                margin-top: 10px !important;
                width: 100% !important;
                transition: all 0.3s ease !important;
            }
            
            /* Thêm style đặc biệt để đảm bảo menu hiển thị */
            #navbarNav.show {
                display: block !important;
                max-height: 1000px !important;
            }
            
            /* Hiệu ứng cho menu khi mở */
            .navbar-collapse {
                transition: max-height 0.3s ease-in-out !important;
                max-height: 0 !important;
                overflow: hidden !important;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg custom-navbar">
        <div class="navbar-container">
            <!-- Logo -->
            <a class="navbar-brand" href="/">
                <i class="fas fa-box-open"></i>
                <span>Quản lý Sản phẩm</span>
            </a>

            <!-- Toggler for Mobile -->
            <button class="navbar-toggler" type="button" id="navbarTogglerBtn">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Navbar Content -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Menu Links -->
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo (strpos($_SERVER['REQUEST_URI'], '/Product/') === 0 && strpos($_SERVER['REQUEST_URI'], '/Product/add') === false) ? 'active' : ''; ?>" href="/Product/" id="products-list-link">
                            <i class="fas fa-list"></i>
                            Danh sách sản phẩm
                        </a>
                    </li>
                    <?php if (!SessionHelper::isAdmin()): ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (strpos($_SERVER['REQUEST_URI'], '/Review') === 0) ? 'active' : ''; ?>" href="/Review">
                            <i class="fas fa-star"></i>
                            Đánh giá từ khách hàng
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>

                <!-- Search Box -->
                <div class="navbar-search-box">
                    <form action="/Product/search" method="GET" id="searchForm">
                        <i class="fas fa-search navbar-search-icon"></i>
                        <input type="text" name="keyword" class="form-control navbar-search-input" placeholder="Tìm kiếm sản phẩm..." id="searchInput" value="<?php echo isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>">
                    </form>
                </div>

                <!-- Right Side (Cart and User) -->
                <ul class="navbar-nav ml-auto">
                    <?php if (SessionHelper::isAdmin()): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle admin-dropdown-link" href="#" id="adminDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-cog"></i>
                            Quản lý
                        </a>
                        <div class="dropdown-menu-11" aria-labelledby="adminDropdown">
                            <a class="dropdown-item <?php echo (strpos($_SERVER['REQUEST_URI'], '/Product/add') === 0) ? 'active' : ''; ?>" href="/Product/add">
                                <i class="fas fa-plus-circle"></i> Thêm sản phẩm
                            </a>
                            <a class="dropdown-item <?php echo (strpos($_SERVER['REQUEST_URI'], '/Category') === 0) ? 'active' : ''; ?>" href="/Category">
                                <i class="fas fa-tags"></i> Danh mục
                            </a>
                            <a class="dropdown-item <?php echo (strpos($_SERVER['REQUEST_URI'], '/Review') === 0) ? 'active' : ''; ?>" href="/Review">
                                <i class="fas fa-star"></i> Đánh giá từ khách hàng
                            </a>
                        </div>
                    </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link cart-link <?php echo (strpos($_SERVER['REQUEST_URI'], '/Product/cart') === 0) ? 'active' : ''; ?>" href="/Product/cart">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="badge cart-count"><?php echo array_sum(array_column($_SESSION['cart'] ?? [], 'quantity')) ?? 0; ?></span>
                            <span class="cart-text d-none d-lg-none">Giỏ hàng</span>
                        </a>
                    </li>

                    <?php
                    require_once 'app/helpers/SessionHelper.php';
                    if (SessionHelper::isLoggedIn()) {
                        echo '<li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle username-link" href="#" id="userDropdown" role="button" 
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-user-circle"></i>
                                    ' . htmlspecialchars($_SESSION['username']) . '
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                    <a class="dropdown-item" href="/account/profile">
                                        <i class="fas fa-id-card"></i> Hồ sơ cá nhân
                                    </a>
                                    <a class="dropdown-item" href="/account/orders">
                                        <i class="fas fa-clipboard-list"></i> Đơn hàng của tôi
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-danger" href="/account/logout">
                                        <i class="fas fa-sign-out-alt"></i> Đăng xuất
                                    </a>
                                </div>
                            </li>';
                    } else {
                        echo '<li class="nav-item">
                                <a class="nav-link login-button" href="/account/login">
                                    <i class="fas fa-sign-in-alt"></i> Đăng nhập
                                </a>
                            </li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="main-container">
        <!-- Nội dung chính sẽ được đặt ở đây -->
    </div>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Custom JavaScript -->
    <script>
        // Handle navbar scroll effect
        window.addEventListener('scroll', () => {
            const navbar = document.querySelector('.custom-navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Menu hamburger trên mobile
        document.addEventListener('DOMContentLoaded', function() {
            // Xử lý toggle menu hamburger (nút 3 gạch)
            const navbarToggler = document.getElementById('navbarTogglerBtn');
            const navbarCollapse = document.getElementById('navbarNav');
            
            if (navbarToggler) {
                // Đơn giản hóa xử lý click cho button hamburger
                navbarToggler.onclick = function(e) {
                    e.preventDefault();
                    if (navbarCollapse) {
                        navbarCollapse.classList.toggle('show');
                        console.log('Menu hamburger toggled');
                    }
                    return false;
                };
            }

            // Xử lý dropdown admin
            const adminDropdown = document.getElementById('adminDropdown');
            if (adminDropdown) {
                adminDropdown.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const dropdownMenu = this.nextElementSibling;
                    if (dropdownMenu) {
                        // Đóng tất cả dropdown khác
                        document.querySelectorAll('.dropdown-menu-11.show').forEach(menu => {
                            if (menu !== dropdownMenu) menu.classList.remove('show');
                        });
                        // Toggle dropdown hiện tại
                        dropdownMenu.classList.toggle('show');
                    }
                });
            }
            
            // Xử lý dropdown user
            const userDropdown = document.getElementById('userDropdown');
            if (userDropdown) {
                userDropdown.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const dropdownMenu = this.nextElementSibling;
                    if (dropdownMenu) {
                        // Đóng tất cả dropdown khác
                        document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
                            if (menu !== dropdownMenu) menu.classList.remove('show');
                        });
                        // Toggle dropdown hiện tại
                        dropdownMenu.classList.toggle('show');
                    }
                });
            }
            
            // Đóng dropdown khi click ra ngoài
            document.addEventListener('click', function(e) {
                // Đóng dropdown admin nếu click bên ngoài
                const adminDropdown = document.getElementById('adminDropdown');
                if (adminDropdown && !adminDropdown.contains(e.target)) {
                    const dropdownMenu = adminDropdown.nextElementSibling;
                    if (dropdownMenu && dropdownMenu.classList.contains('show')) {
                        dropdownMenu.classList.remove('show');
                    }
                }
                
                // Đóng dropdown user nếu click bên ngoài
                const userDropdown = document.getElementById('userDropdown');
                if (userDropdown && !userDropdown.contains(e.target)) {
                    const dropdownMenu = userDropdown.nextElementSibling;
                    if (dropdownMenu && dropdownMenu.classList.contains('show')) {
                        dropdownMenu.classList.remove('show');
                    }
                }
            });
            
            // Tạo hàm cập nhật số lượng giỏ hàng toàn cục
            window.updateCartCount = function(count) {
                const cartCountElement = document.querySelector('.cart-count');
                if (cartCountElement) {
                    cartCountElement.textContent = count;
                    
                    // Hiển thị badge nếu có sản phẩm trong giỏ hàng
                    if (count > 0) {
                        cartCountElement.style.display = 'inline-block';
                    } else {
                        cartCountElement.style.display = 'none';
                    }
                }
            };
            
            // Xử lý cuộn trang khi click vào nút danh sách sản phẩm
            const productsListLink = document.getElementById('products-list-link');
            if (productsListLink && window.location.pathname === '/Product/') {
                productsListLink.addEventListener('click', function(e) {
                    // Nếu đang ở trang danh sách sản phẩm, ngăn chặn hành vi mặc định và cuộn trang
                    e.preventDefault();
                    
                    // Cuộn đến breadcrumb
                    const breadcrumb = document.querySelector('.breadcrumb');
                    if (breadcrumb) {
                        window.scrollTo({
                            top: breadcrumb.offsetTop - 20,
                            behavior: 'smooth'
                        });
                    }
                });
            }

            // Định nghĩa các hàm cần thiết cho AJAX search nếu đang ở trang danh sách sản phẩm
            if (window.location.pathname === '/' || 
                window.location.pathname === '/Product/' || 
                window.location.pathname === '/Product' || 
                window.location.pathname === '/Product/search') {
                
                // Hàm cuộn đến breadcrumb
                window.scrollToBreadcrumb = function() {
                    const breadcrumb = document.querySelector('.breadcrumb');
                    if (breadcrumb) {
                        window.scrollTo({
                            top: breadcrumb.offsetTop - 20,
                            behavior: 'smooth'
                        });
                    }
                };
                
                // Hàm cập nhật lưới sản phẩm - định nghĩa trống, sẽ được ghi đè bởi file list.php
                if (typeof window.updateProductGrid !== 'function') {
                    window.updateProductGrid = function(products) {
                        console.log('Hàm updateProductGrid chưa được định nghĩa trong trang này');
                        // Nếu đang ở trang chủ, chuyển hướng tới trang danh sách sản phẩm
                        if (window.location.pathname === '/') {
                            window.location.href = '/Product';
                        }
                    };
                }
                
                // Hàm cập nhật phân trang - định nghĩa trống, sẽ được ghi đè bởi file list.php
                if (typeof window.updatePagination !== 'function') {
                    window.updatePagination = function(pagination) {
                        console.log('Hàm updatePagination chưa được định nghĩa trong trang này');
                    };
                }
            }

            // Xử lý submit form tìm kiếm
            const searchForm = document.getElementById('searchForm');
            const searchInput = document.getElementById('searchInput');
            
            if (searchForm && searchInput) {
                // Biến để lưu timeout
                let searchTimeout;
                
                // Ngăn không cho form submit theo cách thông thường
                searchForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                });
                
                // Xử lý khi gõ
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    const keyword = this.value.trim();
                    
                    // Đợi 300ms sau khi người dùng ngừng gõ
                    searchTimeout = setTimeout(() => {
                        if (keyword.length >= 2) {
                            // Gửi AJAX request để tìm kiếm mà không thay đổi URL
                            fetch(`/Product/search?keyword=${encodeURIComponent(keyword)}`, {
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                // Nếu đang ở trang danh sách sản phẩm hoặc trang chủ, cập nhật nội dung
                                if (window.location.pathname === '/' || 
                                    window.location.pathname === '/Product/' || 
                                    window.location.pathname === '/Product' || 
                                    window.location.pathname === '/Product/search') {
                                    
                                    // Kiểm tra xem các hàm cần thiết có tồn tại không
                                    if (typeof updateProductGrid === 'function') {
                                        updateProductGrid(data.products);
                                        
                                        if (typeof updatePagination === 'function') {
                                            updatePagination(data.pagination);
                                        }
                                        
                                        // Nếu đang ở trang chủ, chuyển hướng tới trang sản phẩm
                                        if (window.location.pathname === '/') {
                                            window.location.href = '/Product';
                                            return;
                                        }
                                    } else {
                                        // Nếu không có các hàm này, chuyển hướng tới trang sản phẩm
                                        window.location.href = '/Product';
                                    }
                                } else {
                                    // Nếu không ở trang danh sách sản phẩm, chuyển hướng tới trang sản phẩm
                                    window.location.href = '/Product';
                                }
                            })
                            .catch(error => {
                                console.error('Lỗi khi tìm kiếm sản phẩm:', error);
                                // Trong trường hợp lỗi, chuyển hướng tới trang sản phẩm
                                window.location.href = '/Product';
                            });
                        } else if (keyword.length === 0 && 
                            (window.location.pathname === '/Product/' || 
                            window.location.pathname === '/Product' || 
                            window.location.pathname === '/Product/search')) {
                            // Nếu từ khóa rỗng và đang ở trang sản phẩm, tải lại tất cả sản phẩm
                            fetch('/Product/search', {
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (typeof updateProductGrid === 'function' && 
                                    typeof updatePagination === 'function') {
                                    
                                    updateProductGrid(data.products);
                                    updatePagination(data.pagination);
                                }
                            })
                            .catch(error => console.error('Lỗi khi tải sản phẩm:', error));
                        }
                    }, 300);
                });

                // Xử lý khi ấn Enter
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault(); // Ngăn form submit
                        clearTimeout(searchTimeout);
                        const keyword = this.value.trim();
                        
                        if (keyword.length >= 2) {
                            // Thực hiện AJAX search ngay lập tức
                            fetch(`/Product/search?keyword=${encodeURIComponent(keyword)}`, {
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (window.location.pathname === '/' || 
                                    window.location.pathname === '/Product/' || 
                                    window.location.pathname === '/Product' || 
                                    window.location.pathname === '/Product/search') {
                                    
                                    if (typeof updateProductGrid === 'function') {
                                        updateProductGrid(data.products);
                                        
                                        if (typeof updatePagination === 'function') {
                                            updatePagination(data.pagination);
                                        }
                                        
                                        if (typeof scrollToBreadcrumb === 'function') {
                                            scrollToBreadcrumb();
                                        }
                                        
                                        // Nếu đang ở trang chủ, chuyển hướng tới trang sản phẩm
                                        if (window.location.pathname === '/') {
                                            window.location.href = '/Product';
                                            return;
                                        }
                                    } else {
                                        window.location.href = '/Product';
                                    }
                                } else {
                                    window.location.href = '/Product';
                                }
                            })
                            .catch(error => {
                                console.error('Lỗi khi tìm kiếm sản phẩm:', error);
                                window.location.href = '/Product';
                            });
                        }
                    }
                });

                // Xử lý khi click vào icon tìm kiếm
                const searchIcon = document.querySelector('.navbar-search-icon');
                if (searchIcon) {
                    searchIcon.addEventListener('click', function() {
                        clearTimeout(searchTimeout);
                        const keyword = searchInput.value.trim();
                        
                        if (keyword.length >= 2) {
                            // Thực hiện AJAX search ngay lập tức
                            fetch(`/Product/search?keyword=${encodeURIComponent(keyword)}`, {
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (window.location.pathname === '/' || 
                                    window.location.pathname === '/Product/' || 
                                    window.location.pathname === '/Product' || 
                                    window.location.pathname === '/Product/search') {
                                    
                                    if (typeof updateProductGrid === 'function') {
                                        updateProductGrid(data.products);
                                        
                                        if (typeof updatePagination === 'function') {
                                            updatePagination(data.pagination);
                                        }
                                        
                                        if (typeof scrollToBreadcrumb === 'function') {
                                            scrollToBreadcrumb();
                                        }
                                        
                                        // Nếu đang ở trang chủ, chuyển hướng tới trang sản phẩm
                                        if (window.location.pathname === '/') {
                                            window.location.href = '/Product';
                                            return;
                                        }
                                    } else {
                                        window.location.href = '/Product';
                                    }
                                } else {
                                    window.location.href = '/Product';
                                }
                            })
                            .catch(error => {
                                console.error('Lỗi khi tìm kiếm sản phẩm:', error);
                                window.location.href = '/Product';
                            });
                        }
                    });
                    // Thêm cursor pointer cho icon
                    searchIcon.style.cursor = 'pointer';
                }
            }
        });
    </script>
</body>
</html>