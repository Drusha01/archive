CREATE DATABASE TEST;

USE TEST;


CREATE TABLE customer 
(
   customer_id int primary key auto_increment,
   cust_name varchar(100),
   cust_name_reverse varchar(100)
);

CREATE TABLE users(
	user_id int primary key auto_increment,
    user_name varchar(100)
);

CREATE INDEX idx_user_name ON users(user_name);

INSERT INTO users VALUES
(
	null,
    'NICE'
);


CREATE TABLE users_login(
	user_id int primary key auto_increment,
    user_email VARCHAR(100) not null,
    user_password VARCHAR(255) not null,
    user_password_hashed VARCHAR(255) not null
);
CREATE INDEX idx_user_email ON users_login(user_email);
CREATE INDEX idx_user_password ON users_login(user_password);
CREATE INDEX idx_user_password_hashed ON users_login(user_password_hashed);


CREATE TABLE users_login_unique(
	user_id int primary key auto_increment,
    user_email VARCHAR(100) not null unique,
    user_password VARCHAR(255) not null,
    user_password_hashed VARCHAR(255) not null
);
CREATE INDEX idx_user_email ON users_login_unique(user_email);
CREATE INDEX idx_user_password ON users_login_unique(user_password);
CREATE INDEX idx_user_password_hashed ON users_login_unique(user_password_hashed);

SELECT user_id,user_password_hashed FROM users_login_unique
WHERE  user_email =binary'HanzOJZXH@gmail.com';
SELECT * FROM users_login_unique;

SELECT COUNT(*) FROM users_login_unique;


SELECT * FROM users_login;

SELECT COUNT(*) FROM users_login;

SELECT * FROM users_login 
WHERE user_email LIKE 'ZZa%';

SELECT * FROM users_login 
WHERE user_email LIKE 'Zz%';

SELECT * FROM users_login 
WHERE user_email = 'ZzAvzev@gmail.com' AND user_password_hashed ='$argon2i$v=19$m=65536,t=4,p=1$a1I4ZlNwb1Q3NlBlRnZFMw$WKMw9iXXFIxoSY2ph5W7nuoJt7FZhLUUVSwoRVuIk7I';


CREATE INDEX idx_cust_name ON customer(cust_name);
CREATE INDEX idx_cust_name_reverse ON customer(cust_name_reverse, cust_name);

INSERT INTO customer VALUES
(
	null,
	'Hanrickson Dumapit',
    'tipamuD noskcirnaH'
);

SELECT * FROM customer;

SELECT COUNT(*) FROM users;




SELECT cust_name FROM customer 
WHERE cust_name LIKE '%FddBlvfno slaBuL';


SELECT COUNT(cust_name)
FROM customer 
WHERE cust_name LIKE 'Ha%';

SELECT cust_name FROM customer 
WHERE cust_name LIKE '%Ha';

SELECT cust_name FROM customer 
WHERE cust_name LIKE 'Ha%';

SELECT cust_name FROM customer 
WHERE cust_name_reverse LIKE REVERSE('%Ha');


SELECT user_name FROM users 
WHERE user_name LIKE 'Ha%';