use if0_38042764_elounge;

create table users (
    id int primary key auto_increment,
    name varchar(255) not null,
    email varchar(255) not null,
    password varchar(255) not null,
    matric varchar(255) not null,
    isadmin int default 0,
    gender varchar(255) not null,
    profile_pic varchar(255) not null,
    faculty varchar(255) not null,
    phone varchar(255) not null,
    residential varchar(255) not null,
    bio varchar(255) not null,
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
    fullname varchar(255) not null,
    student_id int not null,
    room_type varchar(255) not null,
    book_date varchar(255) not null,
    durationhour int not null,
    purpose varchar(255) not null,
    total_person int not null,
    extra varchar(255) not null,
    booking_time varchar(255) not null,
    approval varchar(255) not null,
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