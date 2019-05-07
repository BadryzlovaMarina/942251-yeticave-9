INSERT INTO category (name, symbol_code)
VALUES ('Доски и лыжи', 'boards'), ('Крепления', 'attachment'), ('Ботинки', 'boots'), ('Одежда', 'clothing'), ('Инструменты', 'tools'), ('Разное', 'other');

INSERT INTO user (email, name, password, icon, contact)
VALUES ('Alina@mail.ru', 'Alina', '12345', 'icon-1.jpg', '232323'), ('Alisa@mail.ru', 'Alisa', '54321', 'icon-2.jpg', '434343');

INSERT INTO lot (name, description, image, start_price, date_end, price_step, user_id, category_id)
VALUES ('2014 Rossignol District Snowboard', 'Описание 1', 'img/lot-1.jpg', '10999', '2019-05-09', '1000', '1', '1'),
('DC Ply Mens 2016/2017 Snowboard', 'Описание 2', 'img/lot-2.jpg', '159999', '2019-05-09', '1000', '2', '1'),
('Крепления Union Contact Pro 2015 года размер L/XL', 'Описание 3', 'img/lot-3.jpg', '8000', '2019-05-09', '1000', '2', '2'),
('Ботинки для сноуборда DC Mutiny Charocal', 'Описание 4', 'img/lot-4.jpg', '10999', '2019-05-09', '1000', '1', '3'),
('Куртка для сноуборда DC Mutiny Charocal', 'Описание 5', 'img/lot-5.jpg', '7500', '2019-05-09', '100', '1', '4'),
('Маска Oakley Canopy', 'Описание 6', 'img/lot-6.jpg', '5400', '2019-05-09', '100', '2', '6');

INSERT INTO bet (bet_price, user_id, lot_id)
VALUES ('7000', '1', '3'), ('8000', '2', '1');

SELECT * FROM category;

SELECT date_create, l.name, start_price, image, bet_price, c.name FROM lot l
JOIN category c ON l.category_id=c.id
JOIN bet b ON l.id=b.lot_id
WHERE date_create >= DATE_ADD(now(), INTERVAL - 1 DAY)
ORDER BY date_create DESC;

SELECT date_create, l.name, date_end, c.name FROM lot l
JOIN category c
ON l.category_id=c.id
WHERE l.id=2;

UPDATE lot
SET name='Jones Aviator Snowboard'
WHERE id=1;

SELECT bet_date, bet_price
FROM bet
WHERE bet_date >= DATE_ADD(now(), INTERVAL - 1 DAY) and lot_id=3
ORDER BY bet_date DESC;