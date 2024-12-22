create database elounge;
use elounge;

create table users (
    id int primary key auto_increment,
    name varchar(255) not null,
    email varchar(255) not null,
    password varchar(255) not null,
    isadmin int default 0,
    gender varchar(255) not null,
    profile_pic varchar(255) not null,
    created_at timestamp default current_timestamp
);

create table rooms (
    id int primary key auto_increment,
    name varchar(255) not null,
    block varchar(255) not null,
    unit varchar(255) not null,
    type varchar(255) not null,
    status varchar(255) not null,
    max_persons int not null,
    created_at timestamp default current_timestamp
);

create table bookings (
    id int primary key auto_increment,
    user_id int not null,
    room_id int not null,
    date date not null,
    approval varchar(255) not null,
    check_in date not null,
    check_out date not null,
    total_person int not null,
    created_at timestamp default current_timestamp
);

create table transactions (
    id int primary key auto_increment,
    booking_id int not null,
    amount float not null,
    transactions_type varchar(255) not null,
    status varchar(255) not null,
    created_at timestamp default current_timestamp
);

create user 'elounge'@'localhost' identified by '123456';
grant select, insert, update, delete on * to 'elounge'@'localhost';