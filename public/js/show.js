document.addEventListener('DOMContentLoaded', function() {
    // Xử lý tăng giảm số lượng
    const quantityInput = document.querySelector('.quantity-input');
    const minusBtn = document.querySelector('.quantity-btn.minus');
    const plusBtn = document.querySelector('.quantity-btn.plus');
    
    if (quantityInput && minusBtn && plusBtn) {
        const maxQuantity = parseInt(quantityInput.getAttribute('max'));

        minusBtn.addEventListener('click', () => {
            let value = parseInt(quantityInput.value);
            if (value > 1) {
                quantityInput.value = value - 1;
            }
        });

        plusBtn.addEventListener('click', () => {
            let value = parseInt(quantityInput.value);
            if (value < maxQuantity) {
                quantityInput.value = value + 1;
            }
        });

        // Xử lý khi người dùng nhập trực tiếp vào input
        quantityInput.addEventListener('change', function() {
            let value = parseInt(this.value);
            if (isNaN(value) || value < 1) {
                this.value = 1;
            } else if (value > maxQuantity) {
                this.value = maxQuantity;
            }
            // Đảm bảo giá trị là số nguyên
            this.value = parseInt(this.value);
        });

        // Ngăn chặn hành vi mặc định cho input số lượng khi nhấn phím up/down
        quantityInput.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowUp' || e.key === 'ArrowDown') {
                e.preventDefault();
                const step = e.key === 'ArrowUp' ? 1 : -1;
                const newValue = parseInt(this.value) + step;
                if (newValue >= 1 && newValue <= maxQuantity) {
                    this.value = newValue;
                    this.dispatchEvent(new Event('change', { bubbles: true }));
                }
            }
        });
    }

    // Xử lý chuyển đổi tab
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabPanes = document.querySelectorAll('.tab-pane');

    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Xóa active class từ tất cả buttons và panes
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabPanes.forEach(pane => pane.classList.remove('active'));

            // Thêm active class vào button được click và pane tương ứng
            button.classList.add('active');
            const tabId = button.getAttribute('data-tab');
            document.getElementById(tabId).classList.add('active');
        });
    });

    // Xử lý form thêm vào giỏ hàng
    const addToCartForm = document.querySelector('.add-to-cart-form');
    if (addToCartForm) {
        addToCartForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const productId = this.getAttribute('action').split('/').pop();
            
            fetch(this.getAttribute('action'), {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Hiển thị thông báo thành công
                    alert('Đã thêm sản phẩm vào giỏ hàng!');
                } else {
                    // Hiển thị thông báo lỗi
                    alert(data.message || 'Có lỗi xảy ra khi thêm vào giỏ hàng!');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi thêm vào giỏ hàng!');
            });
        });
    }

    // Xử lý nút mua ngay
    const buyNowBtn = document.querySelector('.btn-buy-now');
    if (buyNowBtn) {
        buyNowBtn.addEventListener('click', function() {
            const quantityInput = document.querySelector('.quantity-input');
            const quantity = quantityInput ? parseInt(quantityInput.value) : 1;
            const productId = window.location.pathname.split('/').pop();
            
            // Chuyển hướng đến trang thanh toán với số lượng đã chọn
            window.location.href = `/Product/buyNow/${productId}?quantity=${quantity}`;
        });
    }

    // Xử lý thay đổi ảnh sản phẩm
    const thumbnails = document.querySelectorAll('.thumbnail');
    const mainImage = document.getElementById('main-product-image');

    if (thumbnails.length > 0 && mainImage) {
        thumbnails.forEach(thumb => {
            thumb.addEventListener('click', () => {
                // Xóa active class từ tất cả thumbnails
                thumbnails.forEach(t => t.classList.remove('active'));
                
                // Thêm active class vào thumbnail được click
                thumb.classList.add('active');
                
                // Cập nhật ảnh chính
                const newSrc = thumb.getAttribute('data-src');
                mainImage.src = newSrc;
            });
        });
    }
}); 