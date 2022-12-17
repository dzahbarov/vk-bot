CREATE DATABASE IF NOT EXISTS bot_db;

use bot_db;

create table Students
(
    user_vk_id int PRIMARY KEY,
    group_id int
);

create table 'Groups'
(
    group_id int PRIMARY KEY AUTO_INCREMENT,
    group_no char(6)
);

create table Exams
(
    group_id int,
    subject_id int,
    ts timestamp null
);

create table Subjects
(
    subject_id int PRIMARY KEY AUTO_INCREMENT,
    subject_name varchar(50),
    lector varchar(50),
    exam boolean
);

alter table Students
    add constraint student_group_id
    foreign key (group_id) references `Groups`(group_id);

alter table Exams
    add constraint Exams_subject_id
        foreign key (subject_id) references `Subjects`(subject_id);


insert into `Groups`(group_no) values ('M33371');

insert into Subjects(subject_name, lector) values
    ('Анализ данных', 'Муравьёв Сергей Борисович'),
    ('Методы трансляции', 'Станкевич Андрей Сергеевич'),
    ('Параллельное программирование', 'Елизаров Роман Анатольевич'),
    ('Математическая статистика', 'Блаженов Алексей Викторович'),
    ('Функциональное программирование', 'Serokell'),
    ('PHP', 'VK');





# create table schedule_table_help
# (
#     group_name tinytext not null,
#     schedule_id int not null
# );

# create table schedule_table
# (
#     schedule_id int not null,
#     weekday int not null,
#     day_schedule_id int not null
# );

# create table day_schedule
# (
#     day_schedule_id int not null,
#     slot0;
#     slot1;
#     slot2;
#     slot3;
#     slot4
# )




# insert into test_table(test_col)
# values (42);

