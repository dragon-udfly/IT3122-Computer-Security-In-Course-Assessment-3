CREATE DATABASE IF NOT EXISTS security_db;
USE security_db;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);

INSERT INTO users (username, password) VALUES ('admin', 'password123');
INSERT INTO users (username, password) VALUES ('admin34', 'Jskeoce');
INSERT INTO users (username, password) VALUES ('user78', 'HX90Srto_+');
INSERT INTO users (username, password) VALUES ('edwinl', 'tokio934');

CREATE TABLE IF NOT EXISTS comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    comment_text TEXT NOT NULL
);