CREATE DATABASE FORECAST;

USE FORECAST;

DROP TABLE user_types;
CREATE TABLE user_types(
	user_type_id integer primary key auto_increment,
    user_description varchar(255) unique
);

INSERT INTO user_types(user_description) VALUES('admin');
INSERT INTO user_types(user_description) VALUES('staff');

SELECT * FROM user_types;

DROP TABLE users;


CREATE TABLE users(
	user_id INTEGER primary key auto_increment,
    username varchar(255) unique not null,
    user_password varchar(255) not null,
    firstname varchar(255) not null,
    lastname varchar(255) not null,
    user_type_id INTEGER,
    FOREIGN KEY (user_type_id) REFERENCES user_types(user_type_id)
);

INSERT INTO users VALUES(
	null,
	'jaydee',
    'jaydee',
    'Jaydee',
    'Ballaho',
    1
);

INSERT INTO users VALUES(
	null,
	'root',
    'root',
    'Root',
    'Root',
    (SELECT (user_type_id) FROM user_types  WHERE user_description = 'admin')
);

INSERT INTO users (username,user_password,firstname,lastname,user_type_id) VALUES(
	'natsu',
    'natsu',
    'Natsu',
    'Dragneel',
    (SELECT (user_type_id) FROM user_types  WHERE user_description = 'staff')
);

SELECT * FROM users;
SELECT user_id,username,firstname,lastname,user_types.user_description FROM users
 INNER JOIN user_types ON users.user_type_id=user_types.user_type_id
 WHERE username = 'new' AND user_password ='new';
 
 
 SELECT * FROM users  WHERE username = 'root' AND user_password ='root';
 
 
 CREATE TABLE academic_ranks(
	academic_rank_id INTEGER primary key auto_increment,
	academic_rank_description varchar(255) unique
);

INSERT INTO academic_ranks(academic_rank_description) VALUES('Instructor');
INSERT INTO academic_ranks(academic_rank_description) VALUES('Asst. Professor');
INSERT INTO academic_ranks(academic_rank_description) VALUES('Asso. Professor');
INSERT INTO academic_ranks(academic_rank_description) VALUES('Professor');

SELECT * FROM academic_ranks;


 CREATE TABLE departments(
	department_id INTEGER primary key auto_increment,
	department_description varchar(255) unique
);

INSERT INTO departments(department_description) VALUES('Computer Science');
INSERT INTO departments(department_description) VALUES('Information Technology');

SELECT * FROM departments;

CREATE TABLE admission_roles(
	admission_role_id INTEGER primary key auto_increment,
	admission_role_description varchar(255) unique
);

INSERT INTO admission_roles(admission_role_description) VALUES('Admission Officer');
INSERT INTO admission_roles(admission_role_description) VALUES('Interviewer');

SELECT * FROM admission_roles;


 CREATE TABLE faculty_statuses(
	faculty_status_id INTEGER primary key auto_increment,
	faculty_status_description varchar(255) unique
);

INSERT INTO faculty_statuses(faculty_status_description) VALUES('Active Employee');
INSERT INTO faculty_statuses(faculty_status_description) VALUES('Inactive');

SELECT * FROM faculty_statuses;


DROP TABLE faculties;
 CREATE TABLE faculties(
	faculty_id  INTEGER primary key auto_increment,
    firstname VARCHAR(255),
    lastname VARCHAR(255),
    email VARCHAR(255) unique,	-- not unique idk how to alter this if this is unique during run time
    academic_rank_id integer,	-- foreign key
    department_id integer,		-- foreign key
    admission_role_id integer,	-- forein key	 could be boolean tho
    faculty_status_id integer,	-- forein key	 could be boolean tho
    FOREIGN KEY (academic_rank_id) REFERENCES academic_ranks(academic_rank_id),
    FOREIGN KEY (department_id) REFERENCES departments(department_id),
    FOREIGN KEY (admission_role_id) REFERENCES admission_roles(admission_role_id),
    FOREIGN KEY (faculty_status_id) REFERENCES faculty_statuses(faculty_status_id)
 );
 
INSERT INTO faculties (firstname, lastname, email, academic_rank_id, department_id, admission_role_id, faculty_status_id) VALUES(
	'hanrickson',
    'dumapit',
    'hanz.dumapit53@gmail.com',
    (SELECT (academic_rank_id) FROM academic_ranks  WHERE academic_rank_description = 'Instructor'),
    (SELECT (department_id) FROM departments  WHERE department_description = 'Computer Science'),
    (SELECT (admission_role_id) FROM admission_roles  WHERE admission_role_description = 'Interviewer'),
    (SELECT (faculty_status_id) FROM faculty_statuses  WHERE faculty_status_description = 'Active')
 );
 
 INSERT INTO faculties (firstname, lastname, email, academic_rank_id, department_id, admission_role_id, faculty_status_id) VALUES(
	'Jaydee',
    'Ballaho',
    'jaydee.ballaho@wmsu.edu.ph',
    (SELECT (academic_rank_id) FROM academic_ranks  WHERE academic_rank_description = 'Instructor'),
    (SELECT (department_id) FROM departments  WHERE department_description = 'Computer Science'),
    (SELECT (admission_role_id) FROM admission_roles  WHERE admission_role_description = 'Admission Officer'),
    (SELECT (faculty_status_id) FROM faculty_statuses  WHERE faculty_status_description = 'Active Employee')
 );
 INSERT INTO faculties (firstname, lastname, email, academic_rank_id, department_id, admission_role_id, faculty_status_id) VALUES(
	'Gadmar',
    'Belamide',
    'gadmar.belamide@wmsu.edu.ph',
    (SELECT (academic_rank_id) FROM academic_ranks  WHERE academic_rank_description = 'Asst. Professor'),
    (SELECT (department_id) FROM departments  WHERE department_description = 'Computer Science'),
    (SELECT (admission_role_id) FROM admission_roles  WHERE admission_role_description = 'Interviewer'),
    (SELECT (faculty_status_id) FROM faculty_statuses  WHERE faculty_status_description = 'Active Employee')
 );
 
 INSERT INTO faculties (firstname, lastname, email, academic_rank_id, department_id, admission_role_id, faculty_status_id) VALUES(
	'Jason',
    'Catadman',
    'jason.catadman@wmsu.edu.ph',
    (SELECT (academic_rank_id) FROM academic_ranks  WHERE academic_rank_description = 'Instructor'),
    (SELECT (department_id) FROM departments  WHERE department_description = 'Information Technology'),
    (SELECT (admission_role_id) FROM admission_roles  WHERE admission_role_description = 'Interviewer'),
    (SELECT (faculty_status_id) FROM faculty_statuses  WHERE faculty_status_description = 'Active Employee')
 );
 
 INSERT INTO faculties (firstname, lastname, email, academic_rank_id, department_id, admission_role_id, faculty_status_id) VALUES(
	'Pauleen',
    'Gregana',
    'pauleen.gregana@wmsu.edu.ph',
    (SELECT (academic_rank_id) FROM academic_ranks  WHERE academic_rank_description = 'Instructor'),
    (SELECT (department_id) FROM departments  WHERE department_description = 'Information Technology'),
    (SELECT (admission_role_id) FROM admission_roles  WHERE admission_role_description = 'Admission Officer'),
    (SELECT (faculty_status_id) FROM faculty_statuses  WHERE faculty_status_description = 'Active Employee')
 );
 
 INSERT INTO faculties (firstname, lastname, email, academic_rank_id, department_id, admission_role_id, faculty_status_id) VALUES(
	'Marjorie',
    'Rojas',
    'marjorie.rojas@wmsu.edu.ph',
    (SELECT (academic_rank_id) FROM academic_ranks  WHERE academic_rank_description = 'Asst. Professor'),
    (SELECT (department_id) FROM departments  WHERE department_description = 'Computer Science'),
    (SELECT (admission_role_id) FROM admission_roles  WHERE admission_role_description = 'Interviewer'),
    (SELECT (faculty_status_id) FROM faculty_statuses  WHERE faculty_status_description = 'Active Employee')
 );
 
 
UPDATE  faculties
SET firstname = 'nice', 
lastname = 'nice', 
email = 'email@gmail.com', 
academic_rank_id = (SELECT (academic_rank_id) FROM academic_ranks  WHERE academic_rank_description = 'Asst. Professor'),
department_id =  (SELECT (department_id) FROM departments  WHERE department_description = 'Computer Science'),
admission_role_id = (SELECT (admission_role_id) FROM admission_roles  WHERE admission_role_description = 'Interviewer'),
faculty_status_id = (SELECT (faculty_status_id) FROM faculty_statuses  WHERE faculty_status_description = 'Active Employee')
WHERE faculty_id = '11' ;

 
 
 SELECT * FROM faculties where faculty_id =1000;
 
SELECT faculty_id, firstname, lastname, email, academic_ranks.academic_rank_description, departments.department_description, admission_roles.admission_role_description, faculty_statuses.faculty_status_description FROM faculties
INNER JOIN academic_ranks ON faculties.academic_rank_id=academic_ranks.academic_rank_id
INNER JOIN departments ON faculties.department_id=departments.department_id
INNER JOIN admission_roles ON faculties.admission_role_id=admission_roles.admission_role_id
INNER JOIN faculty_statuses ON faculties.faculty_status_id=faculty_statuses.faculty_status_id
;

SELECT faculty_id, firstname, lastname, email, academic_ranks.academic_rank_description, departments.department_description, admission_roles.admission_role_description, faculty_statuses.faculty_status_description FROM faculties
INNER JOIN academic_ranks ON faculties.academic_rank_id=academic_ranks.academic_rank_id
INNER JOIN departments ON faculties.department_id=departments.department_id
INNER JOIN admission_roles ON faculties.admission_role_id=admission_roles.admission_role_id
INNER JOIN faculty_statuses ON faculties.faculty_status_id=faculty_statuses.faculty_status_id
ORDER BY faculty_id ASC
LIMIT 500 OFFSET 600000;

SELECT faculty_id, firstname, lastname, email, academic_ranks.academic_rank_description, departments.department_description, admission_roles.admission_role_description, faculty_statuses.faculty_status_description FROM faculties
LEFT OUTER JOIN academic_ranks ON faculties.academic_rank_id=academic_ranks.academic_rank_id
LEFT OUTER JOIN departments ON faculties.department_id=departments.department_id
LEFT OUTER JOIN admission_roles ON faculties.admission_role_id=admission_roles.admission_role_id
LEFT OUTER JOIN faculty_statuses ON faculties.faculty_status_id=faculty_statuses.faculty_status_id
ORDER BY faculty_id ASC
LIMIT 50 OFFSET 200000;

 SELECT faculty_id, firstname, lastname, email, academic_rank_id, department_id, admission_role_id, faculty_status_id FROM faculties
ORDER BY faculty_id ASC
LIMIT 50 OFFSET 200000;
 
 
SELECT (data_length+index_length)/power(1024,2) tablesize_mb
FROM information_schema.tables
WHERE table_schema='FORECAST' and table_name='mytable';
SELECT COUNT(*)
FROM faculties;


 DELETE FROM faculties WHERE faculty_id = '9';
 
 
 SELECT firstname, lastname, email, academic_rank_id FROM faculties WHERE firstname = 'hanrickson698847';

DROP TABLE program_codes;

 CREATE TABLE program_codes(
	program_code_id INTEGER primary key auto_increment,
    program_code_CODE varchar(255) unique,
    program_code_description varchar(255) 
 );
 
 SELECT * FROM program_codes;
 
 INSERT INTO program_codes(program_code_CODE, program_code_description) VALUES(
	'BSCS',
    'BS Computer Science'
 );
 SELECT * FROM program_codes
 WHERE program_code_CODE = 'BSCS';
 
 CREATE TABLE program_statuses(
	program_status_id INTEGER primary key auto_increment,
    program_status_description varchar(255) unique
);
 INSERT INTO program_statuses(program_status_description) VALUES('Offering');
 INSERT INTO program_statuses(program_status_description) VALUES('Phase-Out');
 
 SELECT * FROM program_statuses;

DROP TABLE program_statuses;


 CREATE TABLE program_level(
	program_level_id INTEGER primary key auto_increment,
    program_level_description varchar(255) unique
);

INSERT INTO program_level(program_level_description) VALUES('Diploma');
INSERT INTO program_level(program_level_description) VALUES('Associate');
INSERT INTO program_level(program_level_description) VALUES('Bachelor');
INSERT INTO program_level(program_level_description) VALUES('Masteral');
INSERT INTO program_level(program_level_description) VALUES('Doctorate');

SELECT * FROM program_level;

 CREATE TABLE programs(
	program_id INTEGER primary key auto_increment,
    program_code varchar(255) unique,
    program_code_description varchar(255),
    program_years integer,	
    program_level_id integer not null,	-- foreign key	
    cet float,
    program_status_id int not null,		-- foreign key
    FOREIGN KEY (program_level_id) REFERENCES program_level(program_level_id),
    FOREIGN KEY (program_status_id) REFERENCES program_statuses(program_status_id)
 );
 
SELECT * FROM programs;
DROP TABLE programs;


-- 
 INSERT INTO program_codes(program_code_CODE, program_code_description) VALUES(
	'BSCS',
    'BS Computer Science'
 );
 
-- first do the select if the query dont returns something then it must be okay to insert the programs data.
SELECT * FROM program_codes
 WHERE program_code_CODE = 'BSCS';

INSERT INTO program_codes(program_code_CODE, program_code_description) VALUES(
	'BSCS',
    'BS Computer Science'
 );
 
 INSERT INTO program_codes(program_code_CODE, program_code_description) VALUES(
	'ACS',
    'Associate in Computer Science'
 );
 
 SELECT program_code_id FROM program_codes  WHERE program_code_CODE = 'BSCS';
 
INSERT INTO programs (program_code,program_code_description, program_years, program_level_id, cet, program_status_id) VALUES(
	'BSCS',
    'BS Computer Science',
    '4',
    (SELECT (program_level_id) FROM program_level  WHERE program_level_description = 'Diploma'),
    '89.4',
    (SELECT (program_status_id) FROM program_statuses  WHERE program_status_description = 'Offering')
);

INSERT INTO programs (program_code,program_code_description, program_years, program_level_id, cet, program_status_id) VALUES(
	'ACS',
    'Associate in Computer Science',
    '2',
    (SELECT (program_level_id) FROM program_level  WHERE program_level_description = 'Diploma'),
    '89.4',
    (SELECT (program_status_id) FROM program_statuses  WHERE program_status_description = 'Offering')
);
 
 
SELECT program_id,program_code,program_code_description ,program_years, program_level.program_level_description, cet, program_statuses.program_status_description  FROM programs
INNER JOIN program_level ON programs.program_level_id=program_level.program_level_id
INNER JOIN program_statuses ON programs.program_status_id=program_statuses.program_status_id
 ;
 
SELECT program_id,program_code,program_code_description ,program_years, program_level.program_level_description, cet, program_statuses.program_status_description  FROM programs
INNER JOIN program_level ON programs.program_level_id=program_level.program_level_id
INNER JOIN program_statuses ON programs.program_status_id=program_statuses.program_status_id
WHERE program_id = '7';
 ;
 
SELECT program_id,program_code,program_code_description ,program_years, program_level.program_level_description, cet, program_statuses.program_status_description  FROM programs
INNER JOIN program_level ON programs.program_level_id=program_level.program_level_id
INNER JOIN program_statuses ON programs.program_status_id=program_statuses.program_status_id
ORDER BY program_id ASC;
 
DELETE FROM programs WHERE program_id = '1';
 
-- program_code,program_code_description, program_years, program_level_id, cet, program_status_id
UPDATE  programs
SET program_code = 'nice', 
program_code_description = 'nice', 
program_years = '4', 
program_level_id = (SELECT (program_level_id) FROM program_level  WHERE program_level_description = 'Diploma'),
cet =  '79',
program_status_id = (SELECT (program_status_id) FROM program_statuses  WHERE program_status_description = 'Offering')
WHERE program_id = '16' ;
 
 SELECT * FROM programs WHERE program_code = 'BSCS';