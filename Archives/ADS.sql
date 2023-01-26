USE dbschedule;

CREATE TABLE tblsyllabus(
	syllabus_id integer primary key auto_increment,
    subject_id integer,
    syllabus_code varchar(50),
    syllabus_author varchar(255),
    FOREIGN KEY (subject_id) REFERENCES tblsubjects(subject_id)
);

drop table tblsyllabus;

insert into tblsyllabus (subject_id,syllabus_code,syllabus_author) VALUES(
	'5','something code','autthor'
);

select * from tblsubjects
LEFT JOIN tblsyllabus
ON tblsyllabus.subject_id = tblsubjects.subject_id;


select * from tblsyllabus;
DELETE from tblsubjects 
WHERE subject_id = '6';

DELETE from tblsubjects 
WHERE subject_id = '6';

DELETE from tblsyllabus 
WHERE subject_id = '6';