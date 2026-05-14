CREATE DATABASE smartgruh;
USE smartgruh;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(15) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user', 'electrician') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
select *
from users;
CREATE TABLE rooms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    room_name VARCHAR(100) NOT NULL,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
CREATE TABLE switches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    room_id INT,
    switch_name VARCHAR(100),
    switch_type ENUM('fan', 'light'),
    status ENUM('ON', 'OFF') DEFAULT 'OFF',
    FOREIGN KEY (room_id) REFERENCES rooms(id)
);
ALTER TABLE switches
ADD pos_x INT DEFAULT 0,
    ADD pos_y INT DEFAULT 0;
USE smartgruh;
ALTER TABLE switches
ADD created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP;