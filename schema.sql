CREATE DATABASE yeticave
DEFAULT CHARACTER SET UTF8
DEFAULT COLLATE UTF8_GENERAL_CI;

USE yeticave;

CREATE TABLE category (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name CHAR(128) NOT NULL,
    symbol_code CHAR(128) NOT NULL
);

CREATE TABLE lot (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date_create DATETIME DEFAULT CURRENT_TIMESTAMP,
    name CHAR(128) NOT NULL,
    description TEXT NOT NULL,
    image CHAR(255) NOT NULL,
    start_price INT NOT NULL,
    date_end DATETIME NOT NULL,
    price_step INT NOT NULL,
    user_id INT,
    winner_id INT,
    category_id INT
);

CREATE TABLE bet (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bet_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    bet_price INT NOT NULL,
    user_id INT,
    lot_id INT
);

CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reg_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    email CHAR(128) NOT NULL UNIQUE,
    name CHAR(128) NOT NULL,
    password CHAR(128) NOT NULL,
    icon CHAR(255),
    contact TEXT NOT NULL
);

CREATE INDEX category_name ON category(category_name);
CREATE INDEX lot_name ON lot(lot_name);
CREATE INDEX user_name ON user(user_name);