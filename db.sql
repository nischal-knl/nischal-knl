CREATE DATABASE student_db;

USE student_db;

-- Create the 'students' table
CREATE TABLE students (
    username VARCHAR(25),
    email VARCHAR(50),
    rollno INT(11),
    s_pass VARCHAR(40),
    faculty VARCHAR(50),
    PRIMARY KEY (rollno)
);

-- Create the 'subjects' table
CREATE TABLE subjects (
    subject_id INT(11) AUTO_INCREMENT,
    subject_name VARCHAR(100),
    faculty VARCHAR(50),
    PRIMARY KEY (subject_id)
);

-- Create the 'marks' table
CREATE TABLE marks (
    rollno INT(11),
    subject_id INT(11),
    marks INT(11),
    PRIMARY KEY (rollno, subject_id),
    FOREIGN KEY (rollno) REFERENCES students(rollno),
    FOREIGN KEY (subject_id) REFERENCES subjects(subject_id)
);

-- Create the 'teacher_table' table
CREATE TABLE teacher_table (
    t_id INT(11),
    t_name VARCHAR(250),
    t_pass VARCHAR(250),
    t_faculty VARCHAR(60),
    PRIMARY KEY (t_id)
);

-- Create the 'update_requests' table
CREATE TABLE update_requests (
    rollno VARCHAR(10),
    name VARCHAR(100),
    faculty VARCHAR(100),
    request_date TIMESTAMP,
    PRIMARY KEY (rollno)
);

-- Create the 'myadmin_table' table
CREATE TABLE myadmin_table (
    username VARCHAR(25),
    password VARCHAR(50),
    PRIMARY KEY (username)
);

--set admin id password
INSERT INTO myadmin_table (username, password) VALUES ('admin', 'admin123');
