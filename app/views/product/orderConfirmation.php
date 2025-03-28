<style> 
    /* Căn giữa nội dung */
.confirmation-container {
    max-width: 600px;
    margin: 50px auto;
    padding: 30px;
    text-align: center;
    background-color: var(--white);
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

/* Tiêu đề */
.confirmation-container h1 {
    font-size: 2rem;
    font-weight: 700;
    color: var(--primary-color);
    margin-bottom: 20px;
}

/* Đoạn văn bản */
.confirmation-container p {
    font-size: 1.2rem;
    color: var(--text-dark);
    margin-bottom: 20px;
}

/* Nút điều hướng */
.btn-primary {
    background-color: var(--primary-color);
    color: var(--white);
    padding: 12px 20px;
    font-size: 1rem;
    font-weight: 600;
    border-radius: 5px;
    transition: background 0.3s ease;
    text-decoration: none;
    display: inline-block;
}

.btn-primary:hover {
    background-color: var(--primary-dark);
}

/* Responsive */
@media (max-width: 768px) {
    .confirmation-container {
        margin: 30px 20px;
        padding: 20px;
    }

    .confirmation-container h1 {
        font-size: 1.8rem;
    }

    .confirmation-container p {
        font-size: 1rem;
    }

    .btn-primary {
        padding: 10px 15px;
        font-size: 0.9rem;
    }
}
/* Biểu tượng xác nhận */
.confirmation-icon {
    font-size: 4rem;
    color: var(--primary-color);
    margin-bottom: 15px;
    animation: pop 0.5s ease-in-out;
}

/* Hiệu ứng icon */
@keyframes pop {
    0% {
        transform: scale(0);
        opacity: 0;
    }
    80% {
        transform: scale(1.2);
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}


</style>
<?php include 'app/views/shares/header.php'; ?> 
<div class="confirmation-container">
    <div class="confirmation-icon">
        <i class="fas fa-check-circle"></i>
    </div>
    <h1>Xác nhận đơn hàng</h1>
    <p>Cảm ơn bạn đã đặt hàng. Đơn hàng của bạn đã được xử lý thành công.</p>
    <a href="/Product" class="btn btn-primary mt-2">Tiếp tục mua sắm</a>
</div>

<?php include 'app/views/shares/footer.php'; ?>