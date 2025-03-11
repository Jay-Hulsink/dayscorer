drop database if exists dayscorer;
create database dayscorer;
use dayscorer;
create table users (
    id int AUTO_INCREMENT PRIMARY KEY,
    username varchar(60),
    pass varbinary(255)
);