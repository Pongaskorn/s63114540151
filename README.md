## ใช้ docker สร้้างสภาพแวดล้อม 
## database : php
## ลง wsl เพื่อเข้า docker

## ลง docker
## ลงเสร็จไป clone 
## clone เสร็จไป ใช้คำสั่ง docker-compose up
```
docker-compose up
```
## พอรันเสร็จ เข้าhttp://localhost:8080
ถ้า Error  ให้เข้าไปที่ http://localhost:8000 หรือ phpmyadmin 
เข้าไปสร้าง database และ Table
New แล้วตั้งชื่อ  MYSQL_DATABASE
แล้วสร้าง Table กดเข้าที่ SQL แล้วเข้าไปที่ไฟล์ data.sql ในงานของเรา ที่อยู๋ในโฟลเดอร์ database แล้วcopy Tableทั้งหมด มาวางในSQL แล้วกด Go หรือสร้างTable
## ก็อปมาวางทีล่ะTable เช่น 
CREATE TABLE `admin_info` (
  `admin_id` int(10) NOT NULL,
  `admin_name` varchar(100) NOT NULL,
  `admin_email` varchar(300) NOT NULL,
  `admin_password` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `admin_info` (`admin_id`, `admin_name`, `admin_email`, `admin_password`) VALUES
(1, 'admin', 'admin@gmail.com', '25f9e794323b453885f5181f1b624d0b');

## copy เสร็จไปวางใน SQL 



## http://localhost:8000 คือ phpmyadmin
MYSQL_USER

MYSQL_DATABASE

MYSQL_PASSWORD

MYSQL_ROOT_PASSWORD

## phpmyadmin ถ้าเข้าครั้งแรก
MYSQL_USER
MYSQL_PASSWORD

## กรณีเข้าแล้วเพิ่ม หรือNew tableไม่ได้ ให้กดlogoutออกแล้วเข้าใหม่โดยใช้
root
MYSQL_ROOT_PASSWORD





