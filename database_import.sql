drop database if exists dayscorer;
create database dayscorer;
use dayscorer;
create table users (
    id int AUTO_INCREMENT PRIMARY KEY,
    username varchar(60),
    pass varbinary(255)
);
CREATE TABLE weekdata (dayname varchar(128),
    score int,
    sleep int,
    work int,
    rest int,
    outside int,
    highlight varchar(128),
    userscore int,
    weekofyear int,
    userid int,
    FOREIGN KEY (userid) REFERENCES users(id));