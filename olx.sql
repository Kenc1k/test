create DATABASE olx_db;

use olx_db;

CREATE table users(
    id INT PRIMARY KEY auto_increment,
    name VARCHAR(100),
    email VARCHAR(200),
    password VARCHAR(255),
    role VARCHAR(50) DEFAULT 'user'

);

create Table products(
    id INT PRIMARY key auto_increment,
    user_id int,
    category_id INT,
    name VARCHAR(200),
    price FLOAT,
    img VARCHAR(200),
    count INT
);

CREATE Table category(
    id int PRIMARY key auto_increment,
    name VARCHAR(255),
    number INT,
    active BOOLEAN
);

CREATE Table orders(
    id INT PRIMARY KEY auto_increment,
    client_id INT,
    owner_id INT,
    product_id INT,
    count INT,
    status VARCHAR(100)
);