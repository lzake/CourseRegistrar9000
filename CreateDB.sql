-- This is to create the DB in MySQL for the CourseRegistrar9000

-- Create a database
CREATE DATABASE course_registrar_database;
-- Use it
Use course_registrar_database;
-- Create a MySQL database table named “tbl_student”
CREATE TABLE tbl_student(student_id INT(10) PRIMARY KEY AUTO_INCREMENT,  student_email VARCHAR(20), student_hashed_password VARCHAR(20), student_phone VARCHAR(11));
-- Create a MySQL database table named “tbl_course”
CREATE TABLE tbl_course(course_id INT(10) PRIMARY KEY AUTO_INCREMENT, course_instructor VARCHAR(20), student_count INT(2), course_title VARCHAR(20));
-- Create a MySQL database table named “tbl_student_course_registered”
CREATE TABLE tbl_student_course_registered(student_course_registration_id INT(10) PRIMARY KEY AUTO_INCREMENT, student_id INT(10), CONSTRAINT student_id FOREIGN KEY(student_id) REFERENCES tbl_student(student_id), course_id INT(10), CONSTRAINT course_id FOREIGN KEY(course_id) REFERENCES tbl_course(course_id));
