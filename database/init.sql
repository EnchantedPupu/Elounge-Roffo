create database elounge;
use elounge;

create table users (
    id int primary key auto_increment,
    username varchar(255) not null,
    password varchar(255) not null,
    email varchar(255) not null,
    created_at timestamp default current_timestamp
);

create user 'elounge'@'localhost' identified by '123456';
grant select, insert, update on * to 'elounge'@'localhost';