-- mysql workbench
drop database hrms ;
CREATE DATABASE HRMS;

use HRMS;


-- table for positions
CREATE TABLE positions(
	position_id INT(10) primary	key auto_increment,
    position_name VARCHAR(50) NOT NULL UNIQUE,
    position_details VARCHAR(100) NOT NULL,
    position_salary FLOAT NOT NULL
);

-- data for position
INSERT INTO positions VALUES
	(null,
    'instructor',
    'a real time instructor',
    '30000'
	),
    (null,
    'visiting lecturer',
    'a real time instructor',
    '30000'
	),
    (null,
    'professor',
    'a real time instructor',
    '30000'
	),
    (null,
    'dean',
    'a real time instructor',
    '30000'
	),
    (null,
    'head',
    'a real time instructor',
    '30000'
	),(null,
    'none',
    'a real time instructor',
    '30000'
	);

-- table for roles
CREATE TABLE roles(
	role_id INT(10) primary	key auto_increment,
    role_details VARCHAR(100) NOT NULL
);

-- data for roles
INSERT INTO roles VALUES
(
	null,
    'employee'
),(
	null,
    'admin'
),(
	null,
    'staff'
),(
	null,
    'employee'
);

-- table for hrms_employee_details
CREATE TABLE hrms_employee_details(
	emp_id INT(10) primary key auto_increment,
    emp_username VARCHAR(30) NOT NULL, 
    emp_password VARCHAR(255) NOT NULL,
    emp_firstname VARCHAR(30) NOT NULL,
    emp_lastname VARCHAR(30) NOT NULL,
    emp_middlename VARCHAR(30),
    emp_position_id INT(10) NOT NULL,
    emp_birthdate DATE NOT NULL,
    emp_age INT(10) NOT NULL,
    emp_sex CHAR(1) NOT NULL,
    emp_address VARCHAR(255) NOT NULL,
    emp_employed_date DATE NOT NULL,
    emp_role_id INT(10) NOT NULL,
    FOREIGN KEY (emp_role_id) REFERENCES roles(role_id),
    FOREIGN KEY (emp_position_id) REFERENCES positions(position_id)
);

-- setting index for username,password, first name, lastname for search queries
CREATE INDEX idx_emp_username ON hrms_employee_details(emp_username);
CREATE INDEX idx_emp_password ON hrms_employee_details(emp_password);
CREATE INDEX idx_emp_firstname ON hrms_employee_details(emp_firstname);
CREATE INDEX idx_emp_lastname ON hrms_employee_details(emp_lastname);


-- data for employees
INSERT INTO hrms_employee_details VALUES
(	null,
	'hanrickson',
    'hanrickson',
    'hanrickson',
    'dumapit',
    'E',
    (SELECT (position_id) FROM positions WHERE position_name= 'instructor'),
	DATE("2000-08-31"),
    '22',
    'M',
    'malagutay',
    NOW(),
    (SELECT (role_id) FROM roles WHERE role_details= 'staff')
),(	null,
	'andre',
    'que',
    'andre',
    'que',
    'E',
    (SELECT (position_id) FROM positions WHERE position_name= 'instructor'),
	DATE("2002-08-31"),
    '20',
    'M',
    'baliwasan',
    NOW(),
    (SELECT (role_id) FROM roles WHERE role_details= 'staff')
),(	null,
	'khay',
    'sali',
    'khay',
    'sali',
    'A',
    (SELECT (position_id) FROM positions WHERE position_name= 'instructor'),
	DATE("2000-08-31"),
    '21',
    'M',
    'talon-talon',
    NOW(),
    (SELECT (role_id) FROM roles WHERE role_details= 'staff')
),(	null,
	'charity',
    'emanuel',
    'charity',
    'emanuel',
    'G',
    (SELECT (position_id) FROM positions WHERE position_name= 'instructor'),
	DATE("2000-08-31"),
    '22',
    'F',
    'Suterville',
    NOW(),
    (SELECT (role_id) FROM roles WHERE role_details= 'staff')
);
-- PLEASE NOTE THAT WE CAN JUST USE ROLE ID OR POSITION ID DIRECTLY, THIS JUST ENSURES THAT THE NAME INDICATED IS FOUND AND FAIL SAFE

-- table for departments
CREATE TABLE departments(
	dept_id INT(10) primary	key auto_increment,
    dept_head_emp_id int(10) NOT NULL,
    dept_name varchar(255),
    department_desc varchar(255),
    FOREIGN KEY (dept_head_emp_id) REFERENCES hrms_employee_details(emp_id)
);

-- table for employee departments 
CREATE TABLE employee_departments(
	employee_department_id INT(10) primary	key auto_increment,
    employee_department_dept_id int(10) NOT NULL,
    employee_department_emp_id int(10) NOT NULL,
    FOREIGN KEY (employee_department_emp_id) REFERENCES hrms_employee_details(emp_id),
    FOREIGN KEY (employee_department_dept_id) REFERENCES departments(dept_id)
);

-- data for departments
INSERT INTO departments VALUES
(	null,
	(SELECT (emp_id) FROM hrms_employee_details WHERE emp_username= 'hanrickson'),
    'Computer Science',
    'A college where it produces professioals that is equipped with competent computer skils'
),(	null,
	(SELECT (emp_id) FROM hrms_employee_details WHERE emp_username= 'hanrickson'),
    'Information Technology',
    'A college where it produces professioals that is equipped with competent computer skils'
);
-- PLEASE NOTE THAT WE CAN JUST USE EMP ID DIRECTLY, THIS JUST ENSURES THAT THE NAME INDICATED IS FOUND AND FAIL SAFE

-- table for hrms status
CREATE TABLE hrms_status(
	status_id INT(10) primary	key auto_increment,
    status_details VARCHAR(100) NOT NULL
);

-- data for hrms status
INSERT INTO hrms_status VALUES
(
	null,
    'active'
),(
	null,
    'inactive'
),(
	null,
    'pending'
),(
	null,
    'complete'
);


-- table for hrms employee salary
CREATE TABLE hrms_employee_salary(
	salary_id INT(10) primary	key auto_increment,
    salary_emp_id INT(10) NOT NULL,
    salary_taxable FLOAT ,
    salary_loans FLOAT,
    salary_insurance_loans FLOAT,
    FOREIGN KEY (salary_emp_id) REFERENCES hrms_employee_details(emp_id)
);

--  table for hrms projects
CREATE TABLE hrms_projects(
	project_id INT(10) primary key auto_increment,
    project_handled VARCHAR(50) NOT NULL UNIQUE,
    project_date_started DATE DEFAULT (CURDATE()) ,
    project_date_ended DATE ,
    project_status_id INT NOT NULL,
    FOREIGN KEY (project_status_id) REFERENCES hrms_status(status_id)
);

-- data for project
INSERT INTO hrms_projects VALUES
(
	null,
    'Chair project',
    CURDATE(),
    null,
    (SELECT (status_id) FROM hrms_status WHERE status_details= 'active')
),(
	null,
    'Computer Project',
    CURDATE(),
    null,
    (SELECT (status_id) FROM hrms_status WHERE status_details= 'active')
),(
	null,
    'Dasbidanya project',
    CURDATE(),
    null,
    (SELECT (status_id) FROM hrms_status WHERE status_details= 'active')
);

-- PLEASE NOTE THAT WE CAN JUST USE STATUS_ID DIRECTLY, THIS JUST ENSURES THAT THE NAME INDICATED IS FOUND AND FAIL SAFE



-- table for hrms employee projects
CREATE TABLE hrms_employee_projects(
	hrms_employee_project_id INT(10) primary key auto_increment,
    hrms_employee_projects_emp_id INT(10) NOT NULL,
    hrms_employee_project_project_id INT(10) NOT NULL ,
    FOREIGN KEY (hrms_employee_projects_emp_id) REFERENCES hrms_employee_details(emp_id),
    FOREIGN KEY (hrms_employee_project_project_id) REFERENCES hrms_projects(project_id)
);

-- data for employee projects
INSERT INTO hrms_employee_projects VALUES
(	
	null,
    (SELECT (emp_id) FROM hrms_employee_details WHERE emp_username= 'hanrickson'),
    (SELECT (project_id) FROM hrms_projects WHERE project_handled= 'Dasbidanya project')
);
-- PLEASE NOTE THAT WE CAN JUST USE EMP ID OR PROJECT ID DIRECTLY, THIS JUST ENSURES THAT THE NAME INDICATED IS FOUND AND FAIL SAFE


-- table for hrms news
CREATE TABLE hrms_news(
	news_id INT(10) primary key auto_increment,
    news_author_id INT(10) NOT NULL,
    news_summary VARCHAR(512) NOT NULL,
    news_content VARCHAR(1024) NOT NULL, 
    FOREIGN KEY (news_author_id) REFERENCES hrms_employee_details(emp_id)
);

-- data for hrms news
INSERT INTO hrms_news VALUES
(
	NULL,
    (SELECT (emp_id) FROM hrms_employee_details WHERE emp_username= 'hanrickson'),
    'SUMMARY',
    'content'
),(
	NULL,
    (SELECT (emp_id) FROM hrms_employee_details WHERE emp_username= 'hanrickson'),
    'SUMMARY1',
    'content1'
),(
	NULL,
    (SELECT (emp_id) FROM hrms_employee_details WHERE emp_username= 'hanrickson'),
    'SUMMARY2',
    'content2'
),(
	NULL,
    (SELECT (emp_id) FROM hrms_employee_details WHERE emp_username= 'hanrickson'),
    'SUMMARY3',
    'content3'
);


-- table for hrms_employee_trainings
CREATE TABLE hrms_employee_trainings(
	training_id INT(10) primary key auto_increment,
    training_emp_id INT(10) NOT NULL,
    training_skills VARCHAR(50) NOT NULL,
    training_reqt VARCHAR(50) NOT NULL,
    traning_bond VARCHAR(50) NOT NULL,
    FOREIGN KEY (training_emp_id) REFERENCES hrms_employee_details(emp_id)
);

-- data for hrms employee trainings
INSERT INTO hrms_employee_trainings VALUES
(
	null,
    (SELECT (emp_id) FROM hrms_employee_details WHERE emp_username= 'hanrickson'),
    'intructor',
    'none',
    'training bond'
),(
	null,
    (SELECT (emp_id) FROM hrms_employee_details WHERE emp_username= 'hanrickson'),
    'intructor',
    'none',
    'training bond'
),(
	null,
    (SELECT (emp_id) FROM hrms_employee_details WHERE emp_username= 'hanrickson'),
    'intructor',
    'none',
    'training bond'
),(
	null,
    (SELECT (emp_id) FROM hrms_employee_details WHERE emp_username= 'hanrickson'),
    'intructor',
    'none',
    'training bond'
);

-- table for hrms leaves
CREATE TABLE hrms_leaves(
	leave_id INT(10) primary key auto_increment,
    leave_name VARCHAR(100) NOT NULL,
    days INT(10) NOT NULL
);

-- data for hrms leaves
INSERT INTO hrms_leaves VALUES
(
	null,
    'Vacation leave',
    3
),(
	null,
    'Long leave of absence',
    30
),(
	null,
    'Study Leave',
    5
),(
	null,
    'Sick Leave',
    1
);


-- table for hrms employee leaves
CREATE TABLE hrms_employee_leaves(
	employee_leave_id INT(10) primary key auto_increment,
    employee_leave_emp_id INT(10) NOT NULL,
    employee_leave_start_date DATE DEFAULT (CURDATE()),
    employee_leave_end_date DATE,
	FOREIGN KEY (employee_leave_id) REFERENCES hrms_employee_details(emp_id)
);

-- data for hrms_employee_leaves
INSERT INTO hrms_employee_leaves VALUES
(
	null,
    (SELECT (emp_id) FROM hrms_employee_details WHERE emp_username= 'hanrickson'),
    CURDATE(),
    DATE_ADD(CURDATE(), INTERVAL (SELECT (days) FROM hrms_leaves WHERE leave_name= 'Vacation leave') DAY)
),(
	null,
    (SELECT (emp_id) FROM hrms_employee_details WHERE emp_username= 'hanrickson'),
    CURDATE(),
    DATE_ADD(CURDATE(), INTERVAL (SELECT (days) FROM hrms_leaves WHERE leave_name= 'Long leave of absence') DAY)
),(
	null,
    (SELECT (emp_id) FROM hrms_employee_details WHERE emp_username= 'hanrickson'),
    CURDATE(),
    DATE_ADD(CURDATE(), INTERVAL (SELECT (days) FROM hrms_leaves WHERE leave_name= 'Study Leave') DAY)
);


-- table for evaluation
CREATE TABLE evaluations(
	evaluation_id INT(10) primary key auto_increment,
    evaluation_emp_id INT(10) NOT NULL,
    evaluation_name VARCHAR(20) NOT NULL,
    evaluation_rating TINYINT(5) NOT NULL,
    evaluation_description VARCHAR(255) NOT NULL,
    evaluation_date DATE DEFAULT (CURDATE()),
    FOREIGN KEY (evaluation_emp_id) REFERENCES hrms_employee_details(emp_id)
);

-- data for evaluation'
INSERT INTO evaluations VALUES
(
	null,
    (SELECT (emp_id) FROM hrms_employee_details WHERE emp_username= 'hanrickson'),
    'Teaching Evaluation',
    '4',
    'Teaching evaluation for 2022',
    CURDATE()
),(
	null,
    (SELECT (emp_id) FROM hrms_employee_details WHERE emp_username= 'andre'),
    'Teaching Evaluation',
    '4',
    'Teaching evaluation for 2022',
    CURDATE()
),(
	null,
    (SELECT (emp_id) FROM hrms_employee_details WHERE emp_username= 'khay'),
    'Teaching Evaluation',
    '4',
    'Teaching evaluation for 2022',
    CURDATE()
);


-- table for employee attendance
CREATE TABLE employee_attendances(
	attendance_id INT(10) primary key auto_increment,
    attendance_emp_id INT(10) NOT NULL,
	attendance_timeIn_date DATETIME,
    attendance_timeOut_date DATETIME,
    attendance_remarks VARCHAR(50),
	FOREIGN KEY (attendance_emp_id) REFERENCES hrms_employee_details(emp_id)
);

-- data for attendance
INSERT INTO employee_attendances VALUES
(
	NULL,
    (SELECT (emp_id) FROM hrms_employee_details WHERE emp_username= 'khay'),
	now(),
    DATE_ADD(NOW(), INTERVAL 8 HOUR),
    NULL	
),(
	NULL,
    (SELECT (emp_id) FROM hrms_employee_details WHERE emp_username= 'hanrickson'),
	now(),
    DATE_ADD(NOW(), INTERVAL 8 HOUR),
    NULL	
),(
	NULL,
    (SELECT (emp_id) FROM hrms_employee_details WHERE emp_username= 'andre'),
	now(),
    DATE_ADD(NOW(), INTERVAL 8 HOUR),
    NULL	
);


-- LOGIN
	SELECT emp_id,emp_username,emp_firstname,emp_lastname FROM hrms_employee_details 
	WHERE  BINARY emp_username = ('hanrickson') AND BINARY emp_password = 'hanrickson';
    
-- SIGN UP
	INSERT INTO hrms_employee_details VALUES
(	null,
	'hanrickson1',
    'hanrickson1',
    'hanrickson',
    'dumapit',
    'E',
    (SELECT (position_id) FROM positions WHERE position_name= 'none'),
	DATE("2000-08-31"),
    '22',
    'M',
    'malagutay',
    NOW(),
    (SELECT (role_id) FROM roles WHERE role_details= 'staff')
);

-- PROFILE UPDATE
UPDATE hrms_employee_details
SET emp_firstname = 'HANZ', emp_lastname= 'Dumapit', emp_middlename = 'E', emp_birthdate = DATE("2000-08-31"),emp_sex = 'M'
WHERE emp_id = '1';

-- PROJECT MANAGEMENT

-- ADDING PROJECT
	INSERT INTO hrms_projects VALUES
	(
		null,
		'Gardening project1',
		CURDATE(),
		null,
		(SELECT (status_id) FROM hrms_status WHERE status_details= 'active')
	);
    
-- UPDATING PROJECT
	UPDATE hrms_projects
    SET project_handled = 'Gardening'  -- note that you can add here what ever column you want to update. 
    WHERE project_id = '1';
    
-- DELETING PROJECT   (note that this cant be deleted if the employee project has link with it, hence you need to delete the employee project first then
-- 						then delete this afterwards or just do a soft delete. either way will ruin data integrity)
    DELETE FROM hrms_projects WHERE project_id=2 ;
    
-- VIEWING LIST OF PROJECT WITH LIMIT
	SELECT project_id,project_handled,project_date_started,project_date_ended, hrms_status.status_details
    FROM hrms_projects
    LEFT OUTER JOIN hrms_status ON hrms_projects.project_status_id=hrms_status.status_id
    LIMIT 20;
    
-- VIEWING LIST OF PROJECT WITH LIMIT AND OFFSET
	SELECT project_id,project_handled,project_date_started,project_date_ended, hrms_status.status_details
	FROM hrms_projects
	LEFT OUTER JOIN hrms_status ON hrms_projects.project_status_id=hrms_status.status_id
	ORDER BY project_handled
	LIMIT 2 OFFSET 1;

-- ADDING employee to a project
	INSERT INTO hrms_employee_projects VALUES
    (	
	null,
    (SELECT (emp_id) FROM hrms_employee_details WHERE emp_username= 'khay'),
    (SELECT (project_id) FROM hrms_projects WHERE project_handled= 'Dasbidanya project')
);

-- DELETING employee from a project
	DELETE FROM hrms_employee_projects 
    WHERE hrms_employee_projects_emp_id= '3';


-- SHOWING LIST OF hrms_employee in 1 project
	SELECT hrms_employee_project_id, emp_id, emp_username,emp_firstname,emp_lastname,position_name,project_date_started,status_details FROM hrms_employee_projects 
    LEFT OUTER JOIN hrms_employee_details ON hrms_employee_projects.hrms_employee_projects_emp_id=hrms_employee_details.emp_id
    LEFT OUTER JOIN hrms_projects ON hrms_employee_projects.hrms_employee_project_project_id=hrms_projects.project_id
    LEFT OUTER JOIN positions ON hrms_employee_details.emp_position_id=positions.position_id
    LEFT OUTER JOIN hrms_status ON hrms_projects.project_status_id=hrms_status.status_id
    WHERE hrms_employee_project_project_id = '3';
    
    
-- SEARCHING FROM EMPLOYEE using wild card
	SELECT * FROM hrms_employee_details 
	WHERE emp_username LIKE 'H%';
    
    
-- ADDING DEPARTMENT
	INSERT INTO departments VALUES
	(	null,
		(SELECT (emp_id) FROM hrms_employee_details WHERE emp_username= 'hanrickson'),
		'Computer Science',
		'A college where it produces professioals that is equipped with competent computer skils'
	);
    
-- DELETING DEPARTMENT
	DELETE FROM departments 
    WHERE dept_id= '1';
    
-- UPDATING DEPARTMENT
	UPDATE departments
    SET dept_name = 'Comp Sci', department_desc = 'A college for computer Science students'
    WHERE dept_id = '1';
    
-- VIEW THE LIST OF DEPARTMENT
	SELECT * FROM departments;
    
-- VIEW THE LIST OF DEPARTMENT WITH LIMIT
	SELECT * FROM departments
	LIMIT 50;

-- ADD EMPLOYEES UNDER A DEPARTMENT 
	INSERT INTO employee_departments VALUES
    (
		null,
        (SELECT dept_id FROM departments WHERE dept_name = 'Computer Science'),
        (SELECT (emp_id) FROM hrms_employee_details WHERE emp_username= 'hanrickson')
    );
-- DELETE THE EMPLOYEE UNDER A DEPARTMENT
	DELETE FROM employee_departments 
    WHERE employee_department_id = (SELECT (emp_id) FROM hrms_employee_details WHERE emp_username= 'hanrickson')  ;

-- VIEW THE LIST OF EMPLOYEES 
	SELECT * FROM employee_departments;
    
-- VIEW THE LIST OF EMPLOYEES IN 1 DEPARTMENT
	SELECT * FROM employee_departments
    WHERE employee_department_dept_id = '1';
    
-- VIEW THE LIST OF EMPLOYEES IN 1 DEPARTMENT (FULL DETAILS)
	SELECT emp_firstname,emp_lastname,dept_name,department_desc FROM employee_departments
     LEFT OUTER JOIN hrms_employee_details ON employee_departments.employee_department_emp_id=hrms_employee_details.emp_id
     LEFT OUTER JOIN departments ON employee_departments.employee_department_dept_id=departments.dept_id
	WHERE employee_department_dept_id = '1';
    
-- UPDATE DEPARTMENT HEAD
	UPDATE departments
    SET dept_head_emp_id = (SELECT (emp_id) FROM hrms_employee_details WHERE emp_username= 'khay')
    WHERE dept_id = 2 ;
    
    
-- ADDING ATTENDANCE
	INSERT INTO employee_attendances VALUES
	(
		NULL,
		(SELECT (emp_id) FROM hrms_employee_details WHERE emp_username= 'khay'),
		now(),
		DATE_ADD(NOW(), INTERVAL 8 HOUR),
		NULL	
	);
    
-- DELETE ATTENDANCE
	DELETE FROM employee_attendances 
    WHERE attendance_id = 2 ;

-- UPDATE ATTENDANCE
	UPDATE employee_attendances 
    SET attendance_remarks = 'late'
    WHERE attendance_id = 4;
    
-- VIEW ATTENDANCE
	SELECT * FROM employee_attendances;
    
-- VIEW ATTENDANCE OF 1 EMPLOYEE
	SELECT * FROM employee_attendances
	WHERE attendance_emp_id = '3';
    ;

-- ADD TRAINING EMPLOYEES
	INSERT INTO hrms_employee_trainings VALUES
	(
		null,
		(SELECT (emp_id) FROM hrms_employee_details WHERE emp_username= 'hanrickson'),
		'intructor',
		'none',
		'training bond'
	);

-- DELETE TRAINING
	DELETE FROM hrms_employee_trainings
    WHERE training_id = 1;
    
-- UPDATE TRAINING
	UPDATE hrms_employee_trainings
    SET traning_bond = 'nice'
    WHERE training_id = 3;
    
-- LIST ALL TRAINING
	SELECT emp_firstname,emp_lastname,training_skills, training_reqt,traning_bond FROM hrms_employee_trainings
    LEFT OUTER JOIN hrms_employee_details ON hrms_employee_trainings.training_emp_id=hrms_employee_details.emp_id;
-- LIST ALL TRAINING OF 1 EMPLOYEE
	SELECT  emp_firstname,emp_lastname,training_skills, training_reqt,traning_bond FROM hrms_employee_trainings
    LEFT OUTER JOIN hrms_employee_details ON hrms_employee_trainings.training_emp_id=hrms_employee_details.emp_id
	WHERE training_emp_id = '1';


-- ADD NEWS
	INSERT INTO hrms_news VALUES
	(
		NULL,
		(SELECT (emp_id) FROM hrms_employee_details WHERE emp_username= 'hanrickson'),
		'new_summary',
		'new_content'
	);

-- DELETE NEWS
	DELETE FROM hrms_news 
    WHERE news_id = '3';

-- UPDATE NEWS
	UPDATE hrms_news
    SET news_summary ='new_summary', news_content = 'new_news_content'
    WHERE news_id = '3' ;
    
-- VIEW LIST OF NEWS
	SELECT * FROM hrms_news;
    
-- VIEW LIST OF NEWS FULL DETAILS
	SELECT news_id,CONCAT(emp_firstname ,' ', emp_lastname) as news_author, news_summary, news_content FROM hrms_news
    LEFT OUTER JOIN hrms_employee_details ON hrms_news.news_author_id=hrms_employee_details.emp_id;
	SELECT CONCAT(emp_firstname ,' ', emp_lastname) as news_author, news_summary, news_content FROM hrms_news
    LEFT OUTER JOIN hrms_employee_details ON hrms_news.news_author_id=hrms_employee_details.emp_id;   
    
 