-- Create database
CREATE DATABASE IF NOT EXISTS db_hanghoa;
USE db_hanghoa;

-- Create table tbl_danhmuc (categories)
CREATE TABLE IF NOT EXISTS tbl_danhmuc (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ten VARCHAR(255) NOT NULL
);

-- Create table tbl_sanpham (products)
CREATE TABLE IF NOT EXISTS tbl_sanpham (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ten VARCHAR(255) NOT NULL,
    mota TEXT,
    gia DECIMAL(10,2),
    id_dm INT,
    FOREIGN KEY (id_dm) REFERENCES tbl_danhmuc(id)
);

-- Insert some sample categories
INSERT INTO tbl_danhmuc (ten) VALUES 
('Điện tử'),
('Thời trang'),
('Gia dụng'),
('Sách');

-- Insert some sample products
INSERT INTO tbl_sanpham (ten, mota, gia, id_dm) VALUES 
('iPhone 14', 'Điện thoại thông minh cao cấp', 25000000, 1),
('Áo sơ mi', 'Áo sơ mi nam cao cấp', 350000, 2),
('Nồi cơm điện', 'Nồi cơm điện 1.8L', 1200000, 3),
('Lập trình PHP', 'Sách học lập trình PHP cơ bản', 250000, 4);