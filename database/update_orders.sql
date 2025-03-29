-- Cập nhật bảng orders để thêm các trường cần thiết (mỗi cột được thêm riêng biệt)
-- Kiểm tra và thêm cột user_id
SET @exist_user_id = (SELECT COUNT(*) FROM information_schema.columns 
    WHERE table_schema = DATABASE()
    AND table_name = 'orders'
    AND column_name = 'user_id');
SET @sql_add_user_id = IF(@exist_user_id = 0, 
    'ALTER TABLE `orders` ADD COLUMN `user_id` int NULL', 
    'SELECT "Column user_id already exists"');
PREPARE stmt FROM @sql_add_user_id;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Kiểm tra và thêm cột status
SET @exist_status = (SELECT COUNT(*) FROM information_schema.columns 
    WHERE table_schema = DATABASE()
    AND table_name = 'orders'
    AND column_name = 'status');
SET @sql_add_status = IF(@exist_status = 0, 
    'ALTER TABLE `orders` ADD COLUMN `status` enum("pending","processing","shipping","completed","cancelled") NOT NULL DEFAULT "pending"', 
    'SELECT "Column status already exists"');
PREPARE stmt FROM @sql_add_status;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Kiểm tra và thêm cột payment_id
SET @exist_payment_id = (SELECT COUNT(*) FROM information_schema.columns 
    WHERE table_schema = DATABASE()
    AND table_name = 'orders'
    AND column_name = 'payment_id');
SET @sql_add_payment_id = IF(@exist_payment_id = 0, 
    'ALTER TABLE `orders` ADD COLUMN `payment_id` varchar(255) DEFAULT NULL', 
    'SELECT "Column payment_id already exists"');
PREPARE stmt FROM @sql_add_payment_id;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Kiểm tra và thêm cột shipping_fee
SET @exist_shipping_fee = (SELECT COUNT(*) FROM information_schema.columns 
    WHERE table_schema = DATABASE()
    AND table_name = 'orders'
    AND column_name = 'shipping_fee');
SET @sql_add_shipping_fee = IF(@exist_shipping_fee = 0, 
    'ALTER TABLE `orders` ADD COLUMN `shipping_fee` decimal(10,2) DEFAULT 0.00', 
    'SELECT "Column shipping_fee already exists"');
PREPARE stmt FROM @sql_add_shipping_fee;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Kiểm tra và thêm cột discount
SET @exist_discount = (SELECT COUNT(*) FROM information_schema.columns 
    WHERE table_schema = DATABASE()
    AND table_name = 'orders'
    AND column_name = 'discount');
SET @sql_add_discount = IF(@exist_discount = 0, 
    'ALTER TABLE `orders` ADD COLUMN `discount` decimal(10,2) DEFAULT 0.00', 
    'SELECT "Column discount already exists"');
PREPARE stmt FROM @sql_add_discount;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Kiểm tra và thêm các cột thời gian
SET @exist_processing_time = (SELECT COUNT(*) FROM information_schema.columns 
    WHERE table_schema = DATABASE()
    AND table_name = 'orders'
    AND column_name = 'processing_time');
SET @sql_add_processing_time = IF(@exist_processing_time = 0, 
    'ALTER TABLE `orders` ADD COLUMN `processing_time` datetime DEFAULT NULL', 
    'SELECT "Column processing_time already exists"');
PREPARE stmt FROM @sql_add_processing_time;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @exist_shipping_time = (SELECT COUNT(*) FROM information_schema.columns 
    WHERE table_schema = DATABASE()
    AND table_name = 'orders'
    AND column_name = 'shipping_time');
SET @sql_add_shipping_time = IF(@exist_shipping_time = 0, 
    'ALTER TABLE `orders` ADD COLUMN `shipping_time` datetime DEFAULT NULL', 
    'SELECT "Column shipping_time already exists"');
PREPARE stmt FROM @sql_add_shipping_time;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @exist_completed_time = (SELECT COUNT(*) FROM information_schema.columns 
    WHERE table_schema = DATABASE()
    AND table_name = 'orders'
    AND column_name = 'completed_time');
SET @sql_add_completed_time = IF(@exist_completed_time = 0, 
    'ALTER TABLE `orders` ADD COLUMN `completed_time` datetime DEFAULT NULL', 
    'SELECT "Column completed_time already exists"');
PREPARE stmt FROM @sql_add_completed_time;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @exist_cancelled_time = (SELECT COUNT(*) FROM information_schema.columns 
    WHERE table_schema = DATABASE()
    AND table_name = 'orders'
    AND column_name = 'cancelled_time');
SET @sql_add_cancelled_time = IF(@exist_cancelled_time = 0, 
    'ALTER TABLE `orders` ADD COLUMN `cancelled_time` datetime DEFAULT NULL', 
    'SELECT "Column cancelled_time already exists"');
PREPARE stmt FROM @sql_add_cancelled_time;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @exist_updated_at = (SELECT COUNT(*) FROM information_schema.columns 
    WHERE table_schema = DATABASE()
    AND table_name = 'orders'
    AND column_name = 'updated_at');
SET @sql_add_updated_at = IF(@exist_updated_at = 0, 
    'ALTER TABLE `orders` ADD COLUMN `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP', 
    'SELECT "Column updated_at already exists"');
PREPARE stmt FROM @sql_add_updated_at;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Kiểm tra và thêm foreign key cho user_id nếu cần
SELECT COUNT(*) INTO @exist_fk_orders_users 
FROM information_schema.TABLE_CONSTRAINTS
WHERE table_schema = DATABASE()
AND table_name = 'orders'
AND constraint_name = 'fk_orders_users';

SET @sql_add_fk = IF(@exist_fk_orders_users = 0,
    'ALTER TABLE `orders` ADD CONSTRAINT `fk_orders_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL',
    'SELECT "Foreign key fk_orders_users already exists"');
PREPARE stmt FROM @sql_add_fk;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Tạo trigger để cập nhật số lượng sản phẩm khi thêm chi tiết đơn hàng
DROP TRIGGER IF EXISTS `after_order_detail_insert`;
DELIMITER $$
CREATE TRIGGER `after_order_detail_insert` 
AFTER INSERT ON `order_details` 
FOR EACH ROW
BEGIN
    -- Sử dụng bảng inventory để cập nhật quantity
    UPDATE `inventory` 
    SET `quantity` = `quantity` - NEW.quantity
    WHERE `product_id` = NEW.product_id;
END$$
DELIMITER ;

-- Tạo trigger để cập nhật lại số lượng sản phẩm khi hủy đơn hàng
DROP TRIGGER IF EXISTS `after_order_cancelled`;
DELIMITER $$
CREATE TRIGGER `after_order_cancelled` 
AFTER UPDATE ON `orders` 
FOR EACH ROW
BEGIN
    IF NEW.`status` = 'cancelled' AND (OLD.`status` != 'cancelled' OR OLD.`status` IS NULL) THEN
        -- Cập nhật inventory dựa trên order_details
        UPDATE inventory i
        INNER JOIN order_details od ON i.product_id = od.product_id AND od.order_id = NEW.id
        SET i.quantity = i.quantity + od.quantity;
    END IF;
END$$
DELIMITER ; 