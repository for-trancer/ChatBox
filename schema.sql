
CREATE DATABASE chatbox;

USE chatbox;

CREATE TABLE users(id int AUTO_INCREMENT primary key,username varchar(30),email varchar(40),password varchar(80));

CREATE TABLE data(id int AUTO_INCREMENT primary key,userid int,message varchar(200),FOREIGN KEY (userid) REFERENCES users(id));

CREATE TABLE messages(id int AUTO_INCREMENT primary key,sender varchar(30),receiver varchar(30),message varchar(200));