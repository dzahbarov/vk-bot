CREATE DATABASE IF NOT EXISTS bot_db;

use bot_db;

create table Students
(
    user_vk_id int PRIMARY KEY,
    group_id   int
);

create table `Groups`
(
    group_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    group_no char(6)
);

create table Exams
(
    exam_id    int AUTO_INCREMENT PRIMARY KEY,
    group_id   int,
    subject_id int,
    ts         Date null
);

create table Subjects
(
    subject_id   int AUTO_INCREMENT PRIMARY KEY,
    group_id     int,
    subject_name varchar(50),
    lector       varchar(50),
    location     varchar(30)
);

create table Useful
(
    useful_id  int AUTO_INCREMENT PRIMARY KEY,
    subject_id int,
    link_name  varchar(30),
    link       varchar(300)
);

create table Classes
(
    class_id    int AUTO_INCREMENT PRIMARY KEY,
    weekday     int,
    subject_id  int,
    start_class Time,
    end_class   Time
);

alter table Subjects
    add constraint subject_group_id
        foreign key (group_id) references `Groups` (group_id);

alter table Useful
    add constraint useful_subject_id
        foreign key (subject_id) references `Subjects` (subject_id);

alter table Classes
    add constraint classes_subject_id
        foreign key (subject_id) references `Subjects` (subject_id);

alter table Students
    add constraint student_group_id
        foreign key (group_id) references `Groups` (group_id);


alter table Exams
    add constraint exams_subject_id
        foreign key (subject_id) references `Subjects` (subject_id);

insert into `Groups`(group_no)
values ('M33371');

insert into Subjects(group_id, subject_name, lector)
values (1, 'Анализ данных', 'Муравьёв Сергей Борисович'),
       (1, 'Методы трансляции', 'Станкевич Андрей Сергеевич'),
       (1, 'Параллельное программирование', 'Елизаров Роман Анатольевич'),
       (1, 'Математическая статистика', 'Блаженов Алексей Викторович'),
       (1, 'Функциональное программирование', 'Serokell'),
       (1, 'PHP', 'VK'),
       (1, 'Blockchain', 'MixBytes');

insert into Useful(subject_id, link_name, link)
values (1, 'Баллы', 'https://vk.cc/cjQcVA'),
       (1, 'ДЗ', 'https://vk.cc/cjQcXn'),
       (1, 'Диск', 'https://vk.cc/cjQcYA'),
       (1, 'YouTube', 'https://vk.cc/cjQcZr'),
       (1, 'Очередь', 'https://vk.cc/cjQcZr'),
       (1, 'Запись', 'https://vk.cc/cjQd0K'),
       (2, 'Баллы', 'https://vk.cc/cjQd24'),
       (2, 'Лабы', 'https://vk.cc/cjQd2N'),
       (2, 'Запись', 'https://vk.cc/cjQd3A'),
       (2, 'Очередь', 'https://vk.cc/cjQd4b'),
       (2, 'YouTube', 'https://vk.cc/cjQd4V');

insert into Exams(group_id, subject_id, ts)
values (1, 2, '2022-01-13'),
       (1, 3, '2022-01-17'),
       (1, 4, '2022-01-23');

insert into Classes(subject_id, weekday, start_class, end_class)
values (4, 1, '11:40:00', '13:10:00'),
       (4, 1, '15:20:00', '16:50:00'),
       (3, 1, '17:00:00', '18:30:00'),
       (3, 1, '18:40:00', '20:10:00'),
       (2, 2, '13:30:00', '15:00:00'),
       (1, 2, '15:20:00', '16:50:00'),
       (1, 2, '17:00:00', '18:30:00'),
       (6, 3, '17:00:00', '18:30:00'),
       (7, 4, '12:00:00', '13:30:00'),
       (5, 5, '11:40:00', '13:10:00'),
       (5, 5, '13:30:00', '15:00:00');

