CREATE DATABASE Archives;

USE Archives;


CREATE TABLE user_types(
	user_type_id int primary key auto_increment,
    user_type_details varchar(50) not null unique	
);

INSERT into user_types VALUES
(	
	null,
    'normal'
);
INSERT into user_types VALUES
(	
	null,
    'admin'
);

drop table user_types;
drop table user_status;
drop table users;
drop table posts;

CREATE TABLE user_status(
	user_status_id int primary key auto_increment,
    user_status_details varchar(50) not null unique
);

INSERT INTO user_status VALUES
(
	null,
    'active'
),
(
	null,
	'inactive'
);

SELECT user_status_id FROM user_status
WHERE user_status_details = 'active';

SELECT * FROM user_status;


CREATE TABLE users(
	user_id int primary key auto_increment,
    user_status_id int not null,
    user_type_id int not null,
    user_email VARCHAR(100) not null unique,
    user_password_hashed VARCHAR(255) not null,
    user_firstname varchar(255) not null,
    user_lastname varchar(255) not null,
    user_storage_used float default 0,
    user_profile_picture varchar(100),
    user_date_created datetime,
    user_date_updated datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_type_id) REFERENCES user_types(user_type_id),
	FOREIGN KEY (user_status_id) REFERENCES user_status(user_status_id)
);
INSERT INTO users VALUES(
                null,
                (SELECT user_status_id FROM user_status WHERE user_status_details = 'active'),
                (SELECT user_type_id FROM user_types WHERE user_type_details = 'normal'),
                '$email',
                '$password',
                '$fname',
                '$lname',
                0,
                'default.png',
                now(),
                now()
                );      
UPDATE users
SET user_firstname = 'nice', user_lastname = 'nice' ,user_profile_picture = ''
WHERE user_id = 4;

SELECT user_profile_picture FROM users
WHERE user_id = '4';

select * from users;

INSERT INTO users

UPDATE users 
SET user_status_id = (SELECT user_status_id FROM user_status WHERE user_status_details = 'inactive')
WHERE user_id = 1;

SELECT user_id,user_status_details,user_type_details,user_name,user_firstname,user_lastname from users
LEFT OUTER JOIN user_status ON users.user_status_id=user_status.user_status_id
LEFT OUTER JOIN user_types ON users.user_type_id=user_types.user_type_id;

SELECT user_id,user_status_details,user_type_details,user_name,user_firstname,user_lastname from users
LEFT OUTER JOIN user_status ON users.user_status_id=user_status.user_status_id
LEFT OUTER JOIN user_types ON users.user_type_id=user_types.user_type_id
WHERE user_name != BINARY 'Hanrickson';
;


UPDATE users 
SET user_status_id = (SELECT user_status_id FROM user_status WHERE user_status_details = 'active')
WHERE user_id = 2;

insert into users VALUES(
	null,
    1,
    1,
    'hanrickson',
    'Uwat09hanz',
    'Hanrickson',
    'Dumapit'
);

insert into users VALUES(
	null,
	(SELECT user_status_id FROM user_status WHERE user_status_details = 'inactive'),
	(SELECT user_type_id FROM user_types WHERE user_type_details = 'normal'),
	'$username',
	'$password',
	'$fname',
	'$lname'
);


SELECT user_id,user_password_hashed,user_firstname,user_lastname,user_status_details FROM users
        LEFT OUTER JOIN user_status ON users.user_status_id=user_status.user_status_id
        WHERE user_email = BINARY 'hanz.dumapit53@gmail.com';
        
SELECT user_id FROM users
WHERE user_type_id = (SELECT user_type_id FROM user_types WHERE user_type_details = 'admin');

SELECT user_id,user_password_hashed,user_firstname,user_lastname,user_status_details FROM users
LEFT OUTER JOIN user_status ON users.user_status_id=user_status.user_status_id
WHERE user_name = BINARY 'Hanrickson9';

SELECT user_id, user_name,user_firstname,user_lastname FROM users
WHERE user_status_id = (SELECT user_status_id FROM user_status WHERE user_status_details = 'active') AND user_name LIKE 'H%';

SELECT user_status_details,user_firstname,user_lastname,user_profile_picture FROM users 
LEFT OUTER JOIN user_status ON users.user_status_id=user_status.user_status_id
WHERE user_id = '4';

SELECT user_status_details,user_firstname,user_lastname,user_profile_picture FROM users 
LEFT OUTER JOIN user_status ON users.user_status_id=user_status.user_status_id
WHERE user_id = '2';

UPDATE users
SET user_type_id = (SELECT user_type_id FROM user_types WHERE user_type_details = 'admin'), user_status_id = (SELECT user_status_id FROM user_status WHERE user_status_details = 'active')
WHERE user_email = BINARY 'hanz.dumapit53@gmail.com';



CREATE INDEX idx_user_email ON users(user_email);
CREATE INDEX idx_user_password_hashed ON users(user_password_hashed);

SELECT post_status_id from post_status WHERE post_status_details ='active';
CREATE TABLE post_status(
	post_status_id int primary key auto_increment,
    post_status_details varchar(50) not null unique
);

INSERT into post_status VALUES
(
	null,
    'active'
),
(
	null,
    'inactive'
);

SELECT target_type_id from target_type where target_type_details = 'public';
SELECT target_type_details FROM target_type;
CREATE TABLE target_type(
	target_type_id int primary key auto_increment,
    target_type_details varchar(50) not null unique
);
INSERT into target_type VALUES
(
	null,
    'public'
),
(
	null,
    'followers'
),
(
	null,
    'followers-except'
),
(
	null,
    'specific-followers'
),
(
	null,
    'only-me'
);

DROP TABLE POSTS;

DELETE FROM posts WHERE post_id = 5;

CREATE TABLE posts(
	post_id int primary key auto_increment, --
    post_status_id int not null ,
    post_user_id int not null,
    post_title varchar(255) not null,
    post_target_type int not null ,
    post_uuid varchar(255) not null,
    post_date_posted datetime,
    post_date_updated datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (post_user_id) REFERENCES users(user_id),
    FOREIGN KEY (post_target_type) REFERENCES target_type(target_type_id)
);
CREATE INDEX idx_post_title ON post(post_title);

SELECT post_id,post_user_id,target_type_details FROM posts 
LEFT OUTER JOIN target_type ON posts.post_target_type=target_type.target_type_id;

SELECT post_id,post_title,CAST(post_date_posted AS DATE) AS post_date_posted_date,post_date_updated FROM posts
WHERE post_user_id = '4' 
ORDER BY post_date_posted DESC;

insert into posts VALUES
(
	null,
    1,
    'nice',
    CAST('23-12-22 04:32:46' AS DATETIME),
    now()
);


SELECT CAST('2022-12-25' AS DATETIME);

SELECT 
    CAST(N() AS DATE) date;

SELECT CAST(post_date_posted AS DATE) AS post_date_posted FROM posts WHERE post_id = 1;

SELECT post_id FROM posts WHERE CAST(post_date_posted AS DATE)  = '$date' AND post_user_id = '$user_id' AND post_title = '$title';
SELECT post_id FROM posts WHERE CAST(post_date_posted AS DATE)  = '2022-12-26' AND post_user_id = '4' AND post_title = 'hermosa';
update posts
set post_title = 'not nice'
where post_id = 1;

SELECT * FROM posts;
drop table posts;

SELECT post_id,post_title FROM posts 
WHERE CAST(post_date_posted AS DATE)  = '2023-12-22' AND post_user_id = '1' AND post_title = 'nice';


SELECT  post_id,post_title,CAST(post_date_posted AS DATE) AS post_date_posted,post_date_updated FROM posts
WHERE post_user_id = '1' 
ORDER BY post_date_posted DESC
LIMIT 20;

drop table contents;

SELECT * FROM contents;
SELECT * FROM contents WHERE content_post_id = 7;
CREATE TABLE contents
(
	content_id int primary key auto_increment,
    content_post_id int not null,
    content_name varchar(100) not null unique,
    content_size int not null,
	content_extension varchar(50),
    content_caption varchar(2048),
    FOREIGN KEY (content_post_id) REFERENCES posts(post_id)
);

SELECT SUM(content_size) FROM contents 
LEFT OUTER JOIN posts ON contents.content_post_id=posts.post_id
LEFT OUTER JOIN users ON posts.post_user_id=users.user_id
WHERE user_id =4;
;

INSERT INTO contents VALUES(
              null,
              '15',
              '4_87e593c52d98750354a52b10f2f277c3.jpg',
              '12312',
              'jpg',
              ''
              );

SELECT SUM(content_size) FROM contents; 
WHERE content_post_id = 1;

INSERT INTO contents VALUES(
	null,
    1,
    'IMG20210106134544.jpg'
);

SELECT COUNT *(content_id) from contents WHERE content_post_id = '1';



SELECT COUNT(*) FROM contents WHERE content_post_id = '1';



SELECT  CURDATE()  ;
CREATE TABLE post_access(
	post_access_id int primary key auto_increment,
    post_access_post_id,
    post_access_user_id,
    post_access_date,
    FOREIGN KEY (post_access_post_id) REFERENCES post(user_id),
    FOREIGN KEY (post_access_user_id) REFERENCES users(user_id)
);


CREATE TABLE access_types(
	access_type_id int primary key auto_increment,
    access_type_details varchar(100) not null
);

INSERT INTO access_types VALUES
(	
	null,
    'normal'
);

drop table targets;
CREATE TABLE targets(
	target_id BIGINT primary key auto_increment,
    target_post_id int not null,
    target_user_id int not null,
    target_access_type_id int not null,
	FOREIGN KEY (target_post_id) REFERENCES posts(post_id),
    FOREIGN KEY (target_user_id) REFERENCES users(user_id),
    FOREIGN KEY (target_access_type_id) REFERENCES access_types(access_type_id)
);

SELECT access_type_id FROM access_types WHERE access_type_details = 'normal';

SELECT user_id FROM users WHERE user_name= BINARY 'Hanrickson9';
INSERT INTO targets VALUES
(
	null,
    1,
    1,
    CONCAT('1','_',(SELECT user_id FROM users WHERE user_name= BINARY 'Hanrickson9')),
    (SELECT access_type_id FROM access_types WHERE access_type_details = 'normal')
);
SELECT CONCAT('1','_',(SELECT user_id FROM users WHERE user_name= BINARY 'Hanrickson9'));
SELECT user_id,user_name,user_firstname,user_lastname,access_type_details FROM targets
LEFT OUTER JOIN access_types ON targets.target_access_type_id=access_types.access_type_id
LEFT OUTER JOIN users ON targets.target_user_id = users.user_id
WHERE target_post_id ='1';
;

SELECT * FROM targets;

SELECT 	target_id,target_post_id,post_status_id,user_name,post_title,CAST(post_date_posted AS DATETIME) AS post_date_posted,post_date_updated
FROM targets 
LEFT OUTER JOIN posts ON targets.target_post_id = posts.post_id
LEFT OUTER JOIN users ON posts.post_user_id = users.user_id
WHERE target_user_id ='1'
ORDER BY post_date_posted DESC;



-- table for except followers
CREATE TABLE except_followers(
	except_follower_id BIGINT primary key auto_increment,
    except_post_id int not null,
    except_user_id int not null
);

-- TABLE for specific followers
CREATE TABLE specific_followers(
	specific_follower_id BIGINT primary key auto_increment,
    specific_follower_post_id int not null,
    specific_follower_user_id int not null
);

DROP table follower_status;

-- TABLE follower_status
CREATE TABLE follower_status(
	follower_status_id int primary key	auto_increment,
    follower_status_details varchar(100) not null unique
);

INSERT INTO follower_status VALUES
(
	null,
    'active'
),
(
	null,
    'inactive'
),
(
	null,
    'black-listed'
);

-- single insert into follower status
INSERT INTO follower_status VALUES
(
	null,
    'requested'
);
INSERT INTO follower_status VALUES
(
	null,
    'deleted'
);

-- SELECT follower status id with where clause
SELECT follower_status_id FROM follower_status WHERE follower_status_details = 'request';
-- TABLE for followers
CREATE TABLE followers(
	follower_id BIGINT primary key auto_increment,
    follower_user_id int not null,
    follower_follow_to_id int not null,
    follower_follower_status_id int not null,
    follow_date datetime DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (follower_follower_status_id) REFERENCES follower_status(follower_status_id)
    
);

-- INSERT to followers
INSERT INTO followers VALUES
(
	null,
    2,
    3,
    (SELECT follower_status_id FROM follower_status WHERE follower_status_details = 'requested'),
    now()
);


-- SELECT all from followers
-- SELECT * FROM followers;

-- DROP table followers ;

-- update (accepting follower)
UPDATE followers 
SET follower_follower_status_id= (SELECT follower_status_id FROM follower_status WHERE follower_status_details = 'active')
WHERE follower_id = 16;

-- delete follow
DELETE FROM followers WHERE follower_follow_to_id = '' AND follower_user_id = '';

-- Count followers where follower status details is active
SELECT COUNT(follower_id) FROM followers
WHERE follower_follow_to_id = 3 AND follower_follower_status_id = (SELECT follower_status_id FROM follower_status WHERE follower_status_details = 'active');

-- count following where follower status details is active
SELECT COUNT(follower_id) FROM followers
WHERE follower_user_id = 3 AND follower_follower_status_id = (SELECT follower_status_id FROM follower_status WHERE follower_status_details = 'active');

SELECT follower_status_details FROM followers
LEFT OUTER JOIN follower_status ON followers.follower_follower_status_id = follower_status.follower_status_id
WHERE follower_user_id = '2' AND follower_follow_to_id ='3';

SELECT follower_id,follower_follow_to_id,follower_user_id,follower_status_details FROM followers
LEFT OUTER JOIN follower_status ON followers.follower_follower_status_id = follower_status.follower_status_id;

SELECT follower_id,user_firstname,user_lastname,user_profile_picture,follower_user_id,follow_date FROM followers
LEFT OUTER JOIN users ON followers.follower_user_id = users.user_id
WHERE follower_follow_to_id = '2' AND follower_follower_status_id = (SELECT follower_status_id FROM follower_status WHERE follower_status_details = 'requested')
ORDER BY follow_date DESC
LIMIT 4;

SELECT follower_id,user_firstname,user_lastname,user_profile_picture,follower_user_id,UNIX_TIMESTAMP(follow_date) AS follow_date  FROM followers
LEFT OUTER JOIN users ON followers.follower_user_id = users.user_id
WHERE follower_follow_to_id = '2' AND follower_follower_status_id = (SELECT follower_status_id FROM follower_status WHERE follower_status_details = 'requested')
ORDER BY follow_date DESC
LIMIT 4;

