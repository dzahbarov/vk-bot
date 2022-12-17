CREATE DATABASE IF NOT EXISTS bot_db;

use bot_db;

create table Students
(
    user_vk_id int PRIMARY KEY,
    group_id int
);

create table `Groups`
(
    group_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    group_no char(6)
);

create table Exams
(
    group_id int,
    subject_id int,
    ts Date null
);

create table Subjects
(
    subject_id int AUTO_INCREMENT PRIMARY KEY,
    subject_name varchar(50),
    lector varchar(50)
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
    ('PHP', 'VK'),
    ('Blockchain', 'MixBytes');

insert into Exams(group_id, subject_id, ts) values
    (1, 2, '2022-01-13'),
    (1, 3, '2022-01-17'),
    (1, 4, '2022-01-23')




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

