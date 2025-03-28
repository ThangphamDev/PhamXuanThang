<!-- Footer mới cho website bán hàng điện tử -->
<footer class="ecommerce-footer">
    <div class="footer-container">
        <!-- Cột 1: Thông tin cửa hàng -->
        <div class="footer-column">
            <h3 class="footer-title">Thông tin cửa hàng</h3>
            <p class="footer-text">
                <i class="fas fa-store-alt"></i> Cửa hàng Quản lý sản phẩm<br>
                <i class="fas fa-map-marker-alt"></i> 123 Đường Số 1, Quận 1, TP. HCM<br>
                <i class="fas fa-phone-alt"></i> 0326314436<br>
                <i class="fas fa-envelope"></i> Thangphamxuan097@gamil.com
            </p>
        </div>

        <!-- Cột 2: Liên kết nhanh -->
        <div class="footer-column">
            <h3 class="footer-title">Liên kết nhanh</h3>
            <ul class="footer-links">
                <li><a href="/Product/">Danh sách sản phẩm</a></li>
                <li><a href="/Product/add">Thêm sản phẩm</a></li>
                <li><a href="/Category">Danh mục</a></li>
                <li><a href="/Product/cart">Giỏ hàng</a></li>
            </ul>
        </div>

        <!-- Cột 3: Chính sách -->
        <div class="footer-column">
            <h3 class="footer-title">Chính sách</h3>
            <ul class="footer-links">
                <li><a href="#">Chính sách bảo hành</a></li>
                <li><a href="#">Chính sách đổi trả</a></li>
                <li><a href="#">Chính sách vận chuyển</a></li>
                <li><a href="#">Chính sách bảo mật</a></li>
            </ul>
        </div>

        <!-- Cột 4: Theo dõi chúng tôi -->
        <div class="footer-column">
            <h3 class="footer-title">Theo dõi chúng tôi</h3>
            <div class="footer-social">
                <a href="https://www.facebook.com/thangthang097" target="_blank" class="social-icon social-facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://www.instagram.com/thangthang097/" target="_blank" class="social-icon social-instagram">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#" class="social-icon social-youtube">
                    <i class="fab fa-youtube"></i>
                </a>
                <a href="#" class="social-icon social-tiktok">
                    <i class="fab fa-tiktok"></i>
                </a>
            </div>
            <p class="footer-text payment-methods">
                <strong>Phương thức thanh toán:</strong><br>
                <i class="fab fa-cc-visa" style="color: #1a1a1a;"></i> Visa
                <i class="fab fa-cc-mastercard" style="color: #1a1a1a;"></i> MasterCard
                <i class="fab fa-paypal" style="color: #1a1a1a;"></i> MoMo
                <i class="fas fa-truck" style="color: #1a1a1a;"></i> COD
</p>
        </div>
    </div>

    <!-- Bản quyền -->
    <div class="footer-bottom">
        <p>&copy; <?php echo date('Y'); ?> Thangpham. All Rights Reserved.</p>
    </div>
</footer>

<style>
    :root {
        --primary-color: #43a047;
        --primary-dark: #2e7d32;
        --primary-light: #a5d6a7;
        --white: #ffffff;
        --light-bg: #f8f9fa;
        --text-dark: #333333;
        --text-muted: #6c757d;
        --border-color: #e9ecef;
        --shadow-color: rgba(0, 0, 0, 0.05);
    }

    /* Footer chính */
    .ecommerce-footer {
        background: linear-gradient(135deg, #1a2526, #2c3e50);
        color: var(--white);
        padding: 40px 0 20px;
        font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        position: relative;
        overflow: hidden;
    }

    .ecommerce-footer::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background: linear-gradient(90deg, var(--primary-color), var(--primary-dark));
    }

    .footer-container {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 30px;
        padding: 0 20px;
    }

    /* Cột trong footer */
    .footer-column {
        margin-bottom: 20px;
    }

    .footer-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--white);
        margin-bottom: 15px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        position: relative;
        padding-bottom: 8px;
    }

    .footer-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 40px;
        height: 2px;
        background: var(--primary-color);
    }

    .footer-text {
        font-size: 0.85rem;
        color: var(--text-muted);
        line-height: 1.6;
        margin: 0;
    }

    .footer-text i {
        margin-right: 8px;
        color: var(--primary-light);
    }

    /* Liên kết nhanh và chính sách */
    .footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-links li {
        margin-bottom: 10px;
    }

    .footer-links a {
        font-size: 0.85rem;
        color: var(--text-muted);
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .footer-links a:hover {
        color: var(--primary-color);
        text-decoration: underline;
    }

    /* Mạng xã hội */
    .footer-social {
        display: flex;
        gap: 12px;
        margin-bottom: 15px;
    }

    .social-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: var(--primary-color);
        color: var(--white);
        font-size: 1rem;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 2px 6px var(--shadow-color);
    }

    .social-icon:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(67, 160, 71, 0.3);
    }

    .social-facebook:hover {
        background: #3b5998;
    }

    .social-instagram:hover {
        background: #E1306C;
    }

    .social-youtube:hover {
        background: #ff0000;
    }

    .social-tiktok:hover {
        background: #000000;
    }

    /* Phương thức thanh toán */
    .payment-methods i {
    margin-right: 8px;
    font-size: 1.2rem;
    vertical-align: middle;
        }
    .payment-methods i:hover {
    color: var(--primary-color);
    transform: scale(1.1);
    }

    .payment-icon {
        width: 40px;
        height: 26px;
        object-fit: contain;
        padding: 4px;
        background: var(--white);
        border-radius: 4px;
        box-shadow: 0 2px 4px rgba(109, 42, 42, 0.2);
        transition: all 0.3s ease;
        border: 1px solid rgba(104, 55, 55, 0.1);
    }

    .payment-icon:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        border-color: var(--primary-color);
    }

    /* Bản quyền */
    .footer-bottom {
        text-align: center;
        padding: 15px 0;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        margin-top: 30px;
        font-size: 0.82rem;
        color: var(--text-muted);
    }

    .footer-bottom p {
        margin: 0;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .footer-container {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .footer-title {
            font-size: 1rem;
        }

        .footer-text,
        .footer-links a {
            font-size: 0.8rem;
        }

        .social-icon {
            width: 32px;
            height: 32px;
            font-size: 0.9rem;
        }

        .payment-methods strong {
            font-size: 0.8rem;
        }

        .payment-icon {
            width: 36px;
            height: 22px;
            padding: 3px;
        }
    }
</style>

<!-- Đóng thẻ main-container -->
</div>
</body>
</html>