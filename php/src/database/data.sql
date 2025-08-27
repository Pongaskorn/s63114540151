-- Converted from MySQL to PostgreSQL
-- Source: data.sql
-- Generated: 2025-08-20T09:30:22.886408Z
-- Notes:
-- * AUTO_INCREMENT converted to identity via ALTER statements at end, and sequence value synced to MAX(id)+1.
-- * MySQL indexes (ADD KEY) converted to CREATE INDEX statements.
-- * MySQL procedure `getcat` rewritten as SQL function.
-- * Trigger `after_user_info_insert` rewritten to PL/pgSQL.
-- * Data types: int(N)->INTEGER, datetime->TIMESTAMP, removed ENGINE/CHARSET.

SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;



CREATE TABLE admin_info (
  admin_id INTEGER NOT NULL,
  admin_name VARCHAR(100) NOT NULL,
  admin_email VARCHAR(300) NOT NULL,
  admin_password VARCHAR(300) NOT NULL
);


INSERT INTO "admin_info" ("admin_id", "admin_name", "admin_email", "admin_password") VALUES
(1, 'admin', 'admin@gmail.com', '25f9e794323b453885f5181f1b624d0b');



CREATE TABLE brands (
  brand_id INTEGER NOT NULL,
  brand_title TEXT NOT NULL
);
INSERT INTO brands (brand_id, brand_title) VALUES
(1, 'HP'),
(2, 'Samsung'),
(3, 'Apple');

CREATE TABLE "cart" (
  "id" INTEGER NOT NULL,
  "p_id" INTEGER NOT NULL,
  "ip_add" varchar(250) NOT NULL,
  "user_id" INTEGER DEFAULT NULL,
  "qty" INTEGER NOT NULL
);
INSERT INTO "cart" ("id", "p_id", "ip_add", "user_id", "qty") VALUES
(6, 26, '::1', 4, 1),
(9, 10, '::1', 7, 1),
(10, 11, '::1', 7, 1),
(11, 45, '::1', 7, 1),
(44, 5, '::1', 3, 0),
(46, 2, '::1', 3, 0),
(48, 72, '::1', 3, 0),
(49, 60, '::1', 8, 1),
(50, 61, '::1', 8, 1),
(51, 1, '::1', 8, 1),
(52, 5, '::1', 9, 1),
(53, 2, '::1', 14, 1),
(54, 3, '::1', 14, 1),
(55, 5, '::1', 14, 1),
(56, 1, '::1', 9, 1),
(57, 2, '::1', 9, 1),
(71, 61, '127.0.0.1', -1, 1);


CREATE TABLE "categories" (
  "cat_id" INTEGER NOT NULL,
  "cat_title" text NOT NULL
);
INSERT INTO "categories" ("cat_id", "cat_title") VALUES
(1, 'Electronics'),
(2, 'Ladies Wears'),
(3, 'Mens Wear'),
(4, 'Kids Wear'),
(5, 'Furnitures'),
(6, 'Home Appliances'),
(7, 'Electronics Gadgets');



CREATE TABLE "email_info" (
  "email_id" INTEGER NOT NULL,
  "email" text NOT NULL
);



INSERT INTO "email_info" ("email_id", "email") VALUES
(3, 'admin@gmail.com'),
(4, 'puneethreddy951@gmail.com'),
(5, 'puneethreddy@gmail.com');



CREATE TABLE "logs" (
  "id" INTEGER NOT NULL,
  "user_id" varchar(50) NOT NULL,
  "action" varchar(50) NOT NULL,
  "date" TIMESTAMP NOT NULL
);


CREATE TABLE "orders" (
  "order_id" INTEGER NOT NULL,
  "user_id" INTEGER NOT NULL,
  "product_id" INTEGER NOT NULL,
  "qty" INTEGER NOT NULL,
  "trx_id" varchar(255) NOT NULL,
  "p_status" varchar(20) NOT NULL
);
INSERT INTO "orders" ("order_id", "user_id", "product_id", "qty", "trx_id", "p_status") VALUES
(1, 12, 7, 1, '07M47684BS5725041', 'Completed'),
(2, 14, 2, 1, '07M47684BS5725041', 'Completed');



CREATE TABLE "orders_info" (
  "order_id" INTEGER NOT NULL,
  "user_id" INTEGER NOT NULL,
  "f_name" varchar(255) NOT NULL,
  "email" varchar(255) NOT NULL,
  "address" varchar(255) NOT NULL,
  "city" varchar(255) NOT NULL,
  "state" varchar(255) NOT NULL,
  "zip" INTEGER NOT NULL,
  "cardname" varchar(255) NOT NULL,
  "cardnumber" varchar(20) NOT NULL,
  "expdate" varchar(255) NOT NULL,
  "prod_count" INTEGER DEFAULT NULL,
  "total_amt" INTEGER DEFAULT NULL,
  "cvv" INTEGER NOT NULL
);
INSERT INTO "orders_info" ("order_id", "user_id", "f_name", "email", "address", "city", "state", "zip", "cardname", "cardnumber", "expdate", "prod_count", "total_amt", "cvv") VALUES
(1, 12, 'Puneeth', 'puneethreddy951@gmail.com', 'Bangalore, Kumbalagodu, Karnataka', 'Bangalore', 'Karnataka', 560074, 'pokjhgfcxc', '4321 2345 6788 7654', '12/90', 3, 77000, 1234);


CREATE TABLE "order_products" (
  "order_pro_id" INTEGER NOT NULL,
  "order_id" INTEGER NOT NULL,
  "product_id" INTEGER NOT NULL,
  "qty" INTEGER DEFAULT NULL,
  "amt" INTEGER DEFAULT NULL
);
INSERT INTO "order_products" ("order_pro_id", "order_id", "product_id", "qty", "amt") VALUES
(73, 1, 1, 1, 5000),
(74, 1, 4, 2, 64000),
(75, 1, 8, 1, 40000);



CREATE TABLE products (
  "product_id" INTEGER NOT NULL,
  "product_cat" INTEGER NOT NULL,
  "product_brand" INTEGER NOT NULL,
  "product_title" varchar(255) NOT NULL,
  "product_price" INTEGER NOT NULL,
  "product_desc" text NOT NULL,
  "product_image" text NOT NULL,
  "product_keywords" text NOT NULL
);
INSERT INTO "products" ("product_id", "product_cat", "product_brand", "product_title", "product_price", "product_desc", "product_image", "product_keywords") VALUES
(1, 1, 2, 'Samsung galaxy s7 edge', 5000, 'Samsung galaxy s7 edge', 'product07.png', 'samsung mobile electronics'),
(2, 1, 3, 'iPhone 5s', 25000, 'iphone 5s', 'http___pluspng.com_img-png_iphone-hd-png-iphone-apple-png-file-550.png', 'mobile iphone apple'),
(3, 1, 3, 'iPad air 2', 30000, 'ipad apple brand', 'da4371ffa192a115f922b1c0dff88193.png', 'apple ipad tablet'),
(4, 1, 3, 'iPhone 6s', 32000, 'Apple iPhone ', 'http___pluspng.com_img-png_iphone-6s-png-iphone-6s-gold-64gb-1000.png', 'iphone apple mobile'),
(5, 1, 2, 'iPad 2', 10000, 'samsung ipad', 'iPad-air.png', 'ipad tablet samsung'),
(6, 1, 1, 'samsung Laptop r series', 35000, 'samsung Black combination Laptop', 'laptop_PNG5939.png', 'samsung laptop '),
(7, 1, 1, 'Laptop Pavillion', 50000, 'Laptop Hp Pavillion', 'laptop_PNG5930.png', 'Laptop Hp Pavillion'),
(8, 1, 4, 'Sony', 40000, 'Sony Mobile', '530201353846AM_635_sony_xperia_z.png', 'sony mobile'),
(9, 1, 3, 'iPhone New', 12000, 'iphone', 'iphone-hd-png-iphone-apple-png-file-550.png', 'iphone apple mobile'),
(10, 2, 6, 'Red Ladies dress', 1000, 'red dress for girls', 'red dress.jpg', 'red dress '),
(11, 2, 6, 'Blue Heave dress', 1200, 'Blue dress', 'images.jpg', 'blue dress cloths'),
(12, 2, 6, 'Ladies Casual Cloths', 1500, 'ladies casual summer two colors pleted', '7475-ladies-casual-dresses-summer-two-colors-pleated.jpg', 'girl dress cloths casual'),
(13, 2, 6, 'SpringAutumnDress', 1200, 'girls dress', 'Spring-Autumn-Winter-Young-Ladies-Casual-Wool-Dress-Women-s-One-Piece-Dresse-Dating-Clothes-Medium.jpg_640x640.jpg', 'girl dress'),
(14, 2, 6, 'Casual Dress', 1400, 'girl dress', 'download.jpg', 'ladies cloths girl'),
(15, 2, 6, 'Formal Look', 1500, 'girl dress', 'shutterstock_203611819.jpg', 'ladies wears dress girl'),
(16, 3, 6, 'Sweter for men', 600, '2012-Winter-Sweater-for-Men-for-better-outlook', '2012-Winter-Sweater-for-Men-for-better-outlook.jpg', 'black sweter cloth winter'),
(17, 3, 6, 'Gents formal', 1000, 'gents formal look', 'gents-formal-250x250.jpg', 'gents wear cloths'),
(19, 3, 6, 'Formal Coat', 3000, 'ad', 'images (1).jpg', 'coat blazer gents'),
(20, 3, 6, 'Mens Sweeter', 1600, 'jg', 'Winter-fashion-men-burst-sweater.png', 'sweeter gents '),
(21, 3, 6, 'T shirt', 800, 'ssds', 'IN-Mens-Apparel-Voodoo-Tiles-09._V333872612_.jpg', 'formal t shirt black'),
(22, 4, 6, 'Yellow T shirt ', 1300, 'yello t shirt with pant', '1.0x0.jpg', 'kids yellow t shirt'),
(23, 4, 6, 'Girls cloths', 1900, 'sadsf', 'GirlsClothing_Widgets.jpg', 'formal kids wear dress'),
(24, 4, 6, 'Blue T shirt', 700, 'g', 'images.jpg', 'kids dress'),
(25, 4, 6, 'Yellow girls dress', 750, 'as', 'images (3).jpg', 'yellow kids dress'),
(27, 4, 6, 'Formal look', 690, 'sd', 'image28.jpg', 'formal kids dress'),
(32, 5, 0, 'Book Shelf', 2500, 'book shelf', 'furniture-book-shelf-250x250.jpg', 'book shelf furniture'),
(33, 6, 2, 'Refrigerator', 35000, 'Refrigerator', 'CT_WM_BTS-BTC-AppliancesHome_20150723.jpg', 'refrigerator samsung'),
(34, 6, 4, 'Emergency Light', 1000, 'Emergency Light', 'emergency light.JPG', 'emergency light'),
(35, 6, 0, 'Vaccum Cleaner', 6000, 'Vaccum Cleaner', 'images (2).jpg', 'Vaccum Cleaner'),
(36, 6, 5, 'Iron', 1500, 'gj', 'iron.JPG', 'iron'),
(37, 6, 5, 'LED TV', 20000, 'LED TV', 'images (4).jpg', 'led tv lg'),
(38, 6, 4, 'Microwave Oven', 3500, 'Microwave Oven', 'images.jpg', 'Microwave Oven'),
(39, 6, 5, 'Mixer Grinder', 2500, 'Mixer Grinder', 'singer-mixer-grinder-mg-46-medium_4bfa018096c25dec7ba0af40662856ef.jpg', 'Mixer Grinder'),
(40, 2, 6, 'Formal girls dress', 3000, 'Formal girls dress', 'girl-walking.jpg', 'ladies'),
(45, 1, 2, 'Samsung Galaxy Note 3', 10000, '0', 'samsung_galaxy_note3_note3neo.JPG', 'samsung galaxy Note 3 neo'),
(46, 1, 2, 'Samsung Galaxy Note 3', 10000, '', 'samsung_galaxy_note3_note3neo.JPG', 'samsung galxaxy note 3 neo'),
(47, 4, 6, 'Laptop', 650, 'nbk', 'product01.png', 'Dell Laptop'),
(48, 1, 7, 'Headphones', 250, 'Headphones', 'product05.png', 'Headphones Sony'),
(49, 1, 7, 'Headphones', 250, 'Headphones', 'product05.png', 'Headphones Sony'),
(50, 3, 6, 'boys shirts', 350, 'shirts', 'pm1.JPG', 'suit boys shirts'),
(51, 3, 6, 'boys shirts', 270, 'shirts', 'pm2.JPG', 'suit boys shirts'),
(52, 3, 6, 'boys shirts', 453, 'shirts', 'pm3.JPG', 'suit boys shirts'),
(53, 3, 6, 'boys shirts', 220, 'shirts', 'ms1.JPG', 'suit boys shirts'),
(54, 3, 6, 'boys shirts', 290, 'shirts', 'ms2.JPG', 'suit boys shirts'),
(55, 3, 6, 'boys shirts', 259, 'shirts', 'ms3.JPG', 'suit boys shirts'),
(56, 3, 6, 'boys shirts', 299, 'shirts', 'pm7.JPG', 'suit boys shirts'),
(57, 3, 6, 'boys shirts', 260, 'shirts', 'i3.JPG', 'suit boys shirts'),
(58, 3, 6, 'boys shirts', 350, 'shirts', 'pm9.JPG', 'suit boys shirts'),
(59, 3, 6, 'boys shirts', 855, 'shirts', 'a2.JPG', 'suit boys shirts'),
(60, 3, 6, 'boys shirts', 150, 'shirts', 'pm11.JPG', 'suit boys shirts'),
(61, 3, 6, 'boys shirts', 215, 'shirts', 'pm12.JPG', 'suit boys shirts'),
(62, 3, 6, 'boys shirts', 299, 'shirts', 'pm13.JPG', 'suit boys shirts'),
(63, 3, 6, 'boys Jeans Pant', 550, 'Pants', 'pt1.JPG', 'boys Jeans Pant'),
(64, 3, 6, 'boys Jeans Pant', 460, 'pants', 'pt2.JPG', 'boys Jeans Pant'),
(65, 3, 6, 'boys Jeans Pant', 470, 'pants', 'pt3.JPG', 'boys Jeans Pant'),
(66, 3, 6, 'boys Jeans Pant', 480, 'pants', 'pt4.JPG', 'boys Jeans Pant'),
(67, 3, 6, 'boys Jeans Pant', 360, 'pants', 'pt5.JPG', 'boys Jeans Pant'),
(68, 3, 6, 'boys Jeans Pant', 550, 'pants', 'pt6.JPG', 'boys Jeans Pant'),
(69, 3, 6, 'boys Jeans Pant', 390, 'pants', 'pt7.JPG', 'boys Jeans Pant'),
(70, 3, 6, 'boys Jeans Pant', 399, 'pants', 'pt8.JPG', 'boys Jeans Pant'),
(71, 1, 2, 'Samsung galaxy s7', 5000, 'Samsung galaxy s7', 'product07.png', 'samsung mobile electronics'),
(72, 7, 2, 'sony Headphones', 3500, 'sony Headphones', 'product02.png', 'sony Headphones electronics gadgets'),
(73, 7, 2, 'samsung Headphones', 3500, 'samsung Headphones', 'product05.png', 'samsung Headphones electronics gadgets'),
(74, 1, 1, 'HP i5 laptop', 5500, 'HP i5 laptop', 'product01.png', 'HP i5 laptop electronics'),
(75, 1, 1, 'HP i7 laptop 8gb ram', 5500, 'HP i7 laptop 8gb ram', 'product03.png', 'HP i7 laptop 8gb ram electronics'),
(76, 1, 5, 'sony note 6gb ram', 4500, 'sony note 6gb ram', 'product04.png', 'sony note 6gb ram mobile electronics'),
(77, 1, 4, 'MSV laptop 16gb ram NVIDEA Graphics', 5499, 'MSV laptop 16gb ram', 'product06.png', 'MSV laptop 16gb ram NVIDEA Graphics electronics'),
(78, 1, 5, 'dell laptop 8gb ram intel integerated Graphics', 4579, 'dell laptop 8gb ram intel integerated Graphics', 'product08.png', 'dell laptop 8gb ram intel integerated Graphics electronics'),
(79, 7, 2, 'camera with 3D pixels', 2569, 'camera with 3D pixels', 'product09.png', 'camera with 3D pixels camera electronics gadgets'),
(80, 1, 1, 'ytrfdkjsd', 12343, 'sdfhgh', '1542455446_thythtf .jpeg', 'dfgh'),
(81, 4, 6, 'Kids blue dress', 300, 'blue dress', '1543993724_pg4.jpg', 'kids blue dress');


CREATE TABLE "user_info" (
  "user_id" INTEGER NOT NULL,
  "first_name" varchar(100) NOT NULL,
  "last_name" varchar(100) NOT NULL,
  "email" varchar(300) NOT NULL,
  "password" varchar(300) NOT NULL,
  "mobile" varchar(10) NOT NULL,
  "address1" varchar(300) NOT NULL,
  "address2" varchar(11) NOT NULL
);
INSERT INTO "user_info" ("user_id", "first_name", "last_name", "email", "password", "mobile", "address1", "address2") VALUES
(12, 'puneeth', 'Reddy', 'puneethreddy951@gmail.com', 'puneeth', '9448121558', '123456789', 'sdcjns,djc'),
(15, 'hemu', 'ajhgdg', 'puneethreddy951@gmail.com', '346778', '536487276', ',mdnbca', 'asdmhmhvbv'),
(16, 'venky', 'vs', 'venkey@gmail.com', '1234534', '9877654334', 'snhdgvajfehyfygv', 'asdjbhfkeur'),
(19, 'abhishek', 'bs', 'abhishekbs@gmail.com', 'asdcsdcc', '9871236534', 'bangalore', 'hassan'),
(21, 'prajval', 'mcta', 'prajvalmcta@gmail.com', '1234545662', '202-555-01', 'bangalore', 'kumbalagodu'),
(22, 'puneeth', 'v', 'hemu@gmail.com', '1234534', '9877654334', 'snhdgvajfehyfygv', 'asdjbhfkeur'),
(23, 'hemanth', 'reddy', 'hemanth@gmail.com', 'Puneeth@123', '9876543234', 'Bangalore', 'Kumbalagodu'),
(24, 'newuser', 'user', 'newuser@gmail.com', 'puneeth@123', '9535688928', 'Bangalore', 'Kumbalagodu'),
(25, 'otheruser', 'user', 'otheruser@gmail.com', 'puneeth@123', '9535688928', 'Bangalore', 'Kumbalagodu');


CREATE OR REPLACE FUNCTION after_user_info_insert_fn()
RETURNS trigger
LANGUAGE plpgsql
AS $$
BEGIN
    INSERT INTO user_info_backup(
        user_id, first_name, last_name, email, password, mobile, address1, address2
    )
    VALUES(
        NEW.user_id, NEW.first_name, NEW.last_name, NEW.email,
        NEW.password, NEW.mobile, NEW.address1, NEW.address2
    );
    RETURN NEW;
END;
$$;

CREATE TRIGGER after_user_info_insert
AFTER INSERT ON user_info
FOR EACH ROW
EXECUTE FUNCTION after_user_info_insert_fn();



CREATE TABLE "user_info_backup" (
  "user_id" INTEGER NOT NULL,
  "first_name" varchar(100) NOT NULL,
  "last_name" varchar(100) NOT NULL,
  "email" varchar(300) NOT NULL,
  "password" varchar(300) NOT NULL,
  "mobile" varchar(10) NOT NULL,
  "address1" varchar(300) NOT NULL,
  "address2" varchar(11) NOT NULL
);
INSERT INTO "user_info_backup" ("user_id", "first_name", "last_name", "email", "password", "mobile", "address1", "address2") VALUES
(12, 'puneeth', 'Reddy', 'puneethreddy951@gmail.com', '123456789', '9448121558', '123456789', 'sdcjns,djc'),
(14, 'hemanthu', 'reddy', 'hemanthreddy951@gmail.com', '123456788', '6526436723', 's,dc wfjvnvn', 'b efhfhvvbr'),
(15, 'hemu', 'ajhgdg', 'keeru@gmail.com', '346778', '536487276', ',mdnbca', 'asdmhmhvbv'),
(16, 'venky', 'vs', 'venkey@gmail.com', '1234534', '9877654334', 'snhdgvajfehyfygv', 'asdjbhfkeur'),
(19, 'abhishek', 'bs', 'abhishekbs@gmail.com', 'asdcsdcc', '9871236534', 'bangalore', 'hassan'),
(20, 'pramod', 'vh', 'pramod@gmail.com', '124335353', '9767645653', 'ksbdfcdf', 'sjrgrevgsib'),
(21, 'prajval', 'mcta', 'prajvalmcta@gmail.com', '1234545662', '202-555-01', 'bangalore', 'kumbalagodu'),
(22, 'puneeth', 'v', 'hemu@gmail.com', '1234534', '9877654334', 'snhdgvajfehyfygv', 'asdjbhfkeur'),
(23, 'hemanth', 'reddy', 'hemanth@gmail.com', 'Puneeth@123', '9876543234', 'Bangalore', 'Kumbalagodu'),
(24, 'newuser', 'user', 'newuser@gmail.com', 'puneeth@123', '9535688928', 'Bangalore', 'Kumbalagodu'),
(25, 'otheruser', 'user', 'otheruser@gmail.com', 'puneeth@123', '9535688928', 'Bangalore', 'Kumbalagodu');



ALTER TABLE admin_info ALTER COLUMN admin_id ADD GENERATED BY DEFAULT AS IDENTITY;
ALTER TABLE brands ALTER COLUMN brand_id ADD GENERATED BY DEFAULT AS IDENTITY;
ALTER TABLE cart ALTER COLUMN id ADD GENERATED BY DEFAULT AS IDENTITY;
ALTER TABLE categories ALTER COLUMN cat_id ADD GENERATED BY DEFAULT AS IDENTITY;
ALTER TABLE email_info ALTER COLUMN email_id ADD GENERATED BY DEFAULT AS IDENTITY;
ALTER TABLE logs ALTER COLUMN id ADD GENERATED BY DEFAULT AS IDENTITY;
ALTER TABLE orders ALTER COLUMN order_id ADD GENERATED BY DEFAULT AS IDENTITY;
ALTER TABLE orders_info ALTER COLUMN order_id ADD GENERATED BY DEFAULT AS IDENTITY;
ALTER TABLE order_products ALTER COLUMN order_pro_id ADD GENERATED BY DEFAULT AS IDENTITY;
ALTER TABLE products ALTER COLUMN product_id ADD GENERATED BY DEFAULT AS IDENTITY;
ALTER TABLE user_info ALTER COLUMN user_id ADD GENERATED BY DEFAULT AS IDENTITY;
ALTER TABLE user_info_backup ALTER COLUMN user_id ADD GENERATED BY DEFAULT AS IDENTITY;



-- ALTER TABLE brands
--   ALTER COLUMN brand_id ADD GENERATED BY DEFAULT AS IDENTITY;
--   SELECT setval(pg_get_serial_sequence('brands', 'brand_id'),
--               COALESCE(MAX(brand_id), 0) + 1, false) FROM brands;

-- ALTER TABLE "cart" ALTER COLUMN "id" ADD GENERATED BY DEFAULT AS IDENTITY;
-- SELECT setval(pg_get_serial_sequence('"cart"', 'id'),
--               COALESCE(MAX("id"), 0) + 1, false) FROM "cart";

-- ALTER TABLE "categories" ALTER COLUMN "cat_id" ADD GENERATED BY DEFAULT AS IDENTITY;
-- SELECT setval(pg_get_serial_sequence('"categories"', 'cat_id'),
--               COALESCE(MAX("cat_id"), 0) + 1, false) FROM "categories";

-- ALTER TABLE "email_info" ALTER COLUMN "email_id" ADD GENERATED BY DEFAULT AS IDENTITY;
-- SELECT setval(pg_get_serial_sequence('"email_info"', 'email_id'),
--               COALESCE(MAX("email_id"), 0) + 1, false) FROM "email_info";

-- ALTER TABLE "logs" ALTER COLUMN "id" ADD GENERATED BY DEFAULT AS IDENTITY;
-- SELECT setval(pg_get_serial_sequence('"logs"', 'id'),
--               COALESCE(MAX("id"), 0) + 1, false) FROM "logs";

-- ALTER TABLE "orders" ALTER COLUMN "order_id" ADD GENERATED BY DEFAULT AS IDENTITY;
-- SELECT setval(pg_get_serial_sequence('"orders"', 'order_id'),
--               COALESCE(MAX("order_id"), 0) + 1, false) FROM "orders";

-- ALTER TABLE "orders_info" ALTER COLUMN "order_id" ADD GENERATED BY DEFAULT AS IDENTITY;
-- SELECT setval(pg_get_serial_sequence('"orders_info"', 'order_id'),
--               COALESCE(MAX("order_id"), 0) + 1, false) FROM "orders_info";

-- ALTER TABLE "order_products" ALTER COLUMN "order_pro_id" ADD GENERATED BY DEFAULT AS IDENTITY;
-- SELECT setval(pg_get_serial_sequence('"order_products"', 'order_pro_id'),
--               COALESCE(MAX("order_pro_id"), 0) + 1, false) FROM "order_products";

-- ALTER TABLE "products" ALTER COLUMN "product_id" ADD GENERATED BY DEFAULT AS IDENTITY;
-- SELECT setval(pg_get_serial_sequence('"products"', 'product_id'),
--               COALESCE(MAX("product_id"), 0) + 1, false) FROM "products";

-- ALTER TABLE "user_info" ALTER COLUMN "user_id" ADD GENERATED BY DEFAULT AS IDENTITY;
-- SELECT setval(pg_get_serial_sequence('"user_info"', 'user_id'),
--               COALESCE(MAX("user_id"), 0) + 1, false) FROM "user_info";

-- ALTER TABLE "user_info_backup" ALTER COLUMN "user_id" ADD GENERATED BY DEFAULT AS IDENTITY;
-- SELECT setval(pg_get_serial_sequence('"user_info_backup"', 'user_id'),
--               COALESCE(MAX("user_id"), 0) + 1, false) FROM "user_info_backup";





--
-- Constraints for table "order_products"
--
ALTER TABLE "orders_info"
  ADD CONSTRAINT orders_info_pkey PRIMARY KEY ("order_id");

ALTER TABLE "products"
  ADD CONSTRAINT products_pkey PRIMARY KEY ("product_id");

-- PostgreSQL equivalent of MySQL procedure `getcat`
CREATE OR REPLACE FUNCTION getcat(cid INTEGER)
RETURNS SETOF "categories"
LANGUAGE sql
STABLE
AS $$
    SELECT * FROM "categories" WHERE "cat_id" = cid;
$$;



-- PostgreSQL equivalent trigger for after_user_info_insert
CREATE OR REPLACE FUNCTION after_user_info_insert_fn()
RETURNS trigger
LANGUAGE plpgsql
AS $$
BEGIN
    INSERT INTO "user_info_backup"(
        "user_id","first_name","last_name","email","password","mobile","address1","address2"
    )
    VALUES(NEW."user_id", NEW."first_name", NEW."last_name", NEW."email", NEW."password", NEW."mobile", NEW."address1", NEW."address2");
    RETURN NEW;
END;
$$;

DO $$
BEGIN
    IF NOT EXISTS (
        SELECT 1 FROM pg_trigger WHERE tgname = 'after_user_info_insert'
    ) THEN
        CREATE TRIGGER "after_user_info_insert"
        AFTER INSERT ON "user_info"
        FOR EACH ROW
        EXECUTE FUNCTION after_user_info_insert_fn();
    END IF;
END $$;