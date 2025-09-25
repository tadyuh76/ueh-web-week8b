-- Migration script to add image column to tbl_sanpham
-- Run this script in your MySQL database

-- Add image column to tbl_sanpham
ALTER TABLE tbl_sanpham 
ADD COLUMN image_url VARCHAR(500) NULL DEFAULT NULL AFTER gia;

-- Update existing products with a default image (optional)
UPDATE tbl_sanpham 
SET image_url = 'https://images.unsplash.com/photo-1621361365424-06f0e1eb5c49?q=80&w=1064&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'
WHERE image_url IS NULL;

-- You can also add different sample images for variety
UPDATE tbl_sanpham SET image_url = 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?q=80&w=1099&auto=format&fit=crop' WHERE id = 1 AND image_url IS NOT NULL;
UPDATE tbl_sanpham SET image_url = 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?q=80&w=1170&auto=format&fit=crop' WHERE id = 2 AND image_url IS NOT NULL;
UPDATE tbl_sanpham SET image_url = 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?q=80&w=1170&auto=format&fit=crop' WHERE id = 3 AND image_url IS NOT NULL;
UPDATE tbl_sanpham SET image_url = 'https://images.unsplash.com/photo-1560343090-f0409e92791a?q=80&w=1064&auto=format&fit=crop' WHERE id = 4 AND image_url IS NOT NULL;
UPDATE tbl_sanpham SET image_url = 'https://images.unsplash.com/photo-1572635196237-14b3f281503f?q=80&w=1160&auto=format&fit=crop' WHERE id = 5 AND image_url IS NOT NULL;