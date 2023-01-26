CREATE DATABASE gms;

USE gms;

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

drop table user_types;
drop table user_status;
drop table users;

