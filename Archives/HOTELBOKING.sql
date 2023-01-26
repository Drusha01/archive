
-- 1
CREATE DATABASE HOTELBOOKING;

-- 2
USE HOTELBOOKING;

drop database hotelbooking;

-- 3
CREATE TABLE user_statuses(
	user_status_id integer auto_increment primary key,
    user_status_description varchar(255)
);

-- 4
INSERT into user_statuses VALUES(
null,
'active'
);

-- 5 
INSERT into user_statuses VALUES(
null,
'inactive'
);
 -- 6
INSERT into user_statuses VALUES(
null,
'deleted'
);

-- 7
CREATE TABLE users(
	user_id INTEGER primary key auto_increment,
    user_status_id INTEGER not null, -- foreign key
    user_verified boolean not null,
    user_name VARCHAR(255) unique not null,
    user_password VARCHAR(255) not null,
    user_firstname VARCHAR(255) not null,
    user_lastname VARCHAR(255) not null,
    user_email VARCHAR(255) unique not null,
    user_phonenumber CHAR(10),
    user_gender CHAR(1) not null,
    user_birthdate VARCHAR(255),
    user_photo CHAR(20) default 'default.png',
    user_address VARCHAR(255),
    date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
    date_updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_status_id) REFERENCES user_statuses(user_status_id)
);

-- (user_id, user_status_id, user_verified, user_name, user_firstname, user_lastname, user_email, user_phonenumber,user_gender, user_birthdate,user_photo, user_address,date_created,date_updated)

INSERT INTO users (user_status_id, user_verified,user_name, user_password, user_firstname, user_lastname, user_email, user_gender, user_birthdate) VALUES(
	1,
    0,
    'drusha2',
    'drusha2',
    'Hanrickson',
    'Dumapit',
    'Hanrickson@gmail.com',
    'M',
    now()
);

select * from users;

SELECT user_password from users WHERE user_id = '1';

UPDATE users
SET user_password = '$argon2i$v=19$m=65536,t=4,p=1$SmZhRnBKLjU1bExSbTVURQ$usOKOMVG9KqDyIjpk5VT+HBcKAtcHLsVN6AtDSiH50o'
WHERE user_id=9;

UPDATE users
SET user_birthdate = '2000-08-29'
WHERE user_id=1;
UPDATE users
SET user_firstname = 'harnciskon', user_lastname ='dumapit',
 user_email = 'bg201802518@wmsu.edu.ph', user_phonenumber = '', user_birthdate ='2000-09-31'
WHERE user_id=1;

UPDATE users
SET user_phonenumber = '9265827342'
WHERE user_id=5;

SELECT user_id, user_status_id, user_verified, user_name, user_firstname, user_lastname, user_email, user_phonenumber,user_gender, user_birthdate,user_photo, user_address, date_created, date_updated FROM users 
WHERE user_id = (SELECT user_id FROM users WHERE user_name ='drusha');

(SELECT user_id FROM users WHERE user_name ='drusha');

INSERT INTO users VALUES(
null,
1,
false,
'drusha',
'drusha',
'hanrickson',
'dumapit',
'hanz.dumapit53@gmail.com',
'9265827342',
'm',
now(),
'something',
null,
now(),
null
);

INSERT INTO users VALUES(
null,
1,
false,
'drusha1',
'drusha1',
'khayzel',
'sali',
'khay.sali@gmail.com',
'9265827342',
'm',
now(),
'something',
null,
now(),
null
);

INSERT INTO users VALUES(
null,
1,
false,
'drusha',
'drusha',
'hanrickson',
'dumapit',
'hanz.dumapit54@gmail.com',
'9265827342',
'me',
now(),
'something',
null,
now(),
null
);

select * from users
 WHERE user_name ='drusha1' and user_email = 'hanz.dumapit53@gmail.com';

drop table users;

DROP TABLE user_statuses;



select * from user_statuses;

CREATE TABLE datenow(
	datenow datetime default  CURRENT_TIMESTAMP   
);


INSERT INTO datenow VALUES();
SELECT *FROM datenow   ;

UPDATE datenow SET date_created = now() where id = '1';

SELECT  NOW() ;

-- 9
CREATE TABLE hotel_statuses(
	hotel_status_id integer primary key auto_increment,
    hotel_status_id_description varchar(255)
);

-- 10
insert into hotel_statuses VALUES(
null,
'active'
);

 -- 11
insert into hotel_statuses VALUES(
null,
'inactive'
);

-- 12
insert into hotel_statuses VALUES(
null,
'deactivate'
);

-- 13
insert into hotel_statuses VALUES(
null,
'terminated'
);

select * from hotel_statuses;

drop table amenities;


-- 14
CREATE TABLE amenities(
	hotel_amenity_id integer primary key auto_increment,
    amenities_description varchar(1024) -- in json format???
);


insert into amenities values (
null,
'nothing'
);

drop table hotels;

-- 15
CREATE TABLE hotels(
	hotel_id integer primary key auto_increment,
    user_id integer unique,
    hotel_name varchar(255) not null,
    hotel_status_id integer not null,
    hotel_back_ground_photo varchar(50) not null,
    hotel_thumbnail_photo varchar(50) not null,
	hotel_description varchar(1024) not null,
    hotel_address varchar(255) , -- not null but just for the sake of making my life easier
    hotel_phone_number char(12), -- not null but just for the sake of making my life easier
    hotel_location_longitude float, 
    hotel_location_latitude float,
    hotel_amenity_id integer, -- not null but just for the sake of making my life easier
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (hotel_status_id) REFERENCES hotel_statuses(hotel_status_id),
    FOREIGN KEY (hotel_amenity_id) REFERENCES amenities(hotel_amenity_id)
);

-- 10
insert into hotels VALUES(
null,
9,
'hanrickson hotel nice', -- hotel name
1,	-- hotel status
'hotel_background_photo',
'hotel_thumbnail_photo',
'a hotel that no one knows', -- description
'de alya alya lang',
'639265827342',
'69.69',
'69.69',
1

);

insert into hotels VALUES(
null,
'16',
'hanrickson hotel nice', -- hotel name
1,	-- hotel status
'hotel_background_photo',
'hotel_thumbnail_photo.jpg',
'a hotel that no one knows', -- description
'de alya alya lang',
'639265827342',
'69.69',
'69.69',
1

);

update hotels
set hotel_name = 'sakbutan' where hotel_id =9;

select * from hotels;
select * from users;

select * from hotels;

update hotels
SET hotel_name= 'sabulakan', hotel_back_ground_photo ='hotel_thumbnail_photo.jpg',hotel_thumbnail_photo ='hotel_thumbnail_photo.jpg', hotel_description ='huh alam mo yan?',hotel_phone_number='096969696969' 
WHERE user_id= 9 AND hotel_id= 1;
;

insert into hotels(user_id, hotel_name, hotel_status_id, hotel_back_ground_photo, hotel_thumbnail_photo, hotel_description, hotel_address, hotel_phone_number)  values(
21,
'somename',
1,
'hotel_thumbnail_photo.jpg',
'hotel_thumbnail_photo.jpg',
'hotel description',
'address',
'912312312'
);

update hotels 
set hotel_back_ground_photo = '24.jpg', hotel_thumbnail_photo= '24.jpg'
WHERE hotel_id= '24';
