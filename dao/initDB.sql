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
    group_id int,
    subject_name varchar(50),
    lector varchar(50),
    location varchar(30)
);

create table Useful
(
    useful_id int AUTO_INCREMENT PRIMARY KEY,
    subject_id int,
    link_name varchar(30),
    link varchar(300)
);

create table Schedule
(
    schedule_id int AUTO_INCREMENT PRIMARY KEY,
    group_id int,
    weekday int,
    class1_id int,
    class2_id int,
    class3_id int,
    class4_id int,
    class5_id int,
    class6_id int,
    class7_id int
);

create table Classes
(
  class_id int AUTO_INCREMENT PRIMARY KEY,
  subject_id int,
  start_class Time,
  end_class Time
);

alter table Subjects
    add constraint subject_group_id
        foreign key (group_id) references `Groups`(group_id);

alter table Useful
    add constraint useful_subject_id
        foreign key (subject_id) references `Subjects`(subject_id);

alter table Schedule
    add constraint schedule_group_id
        foreign key (group_id) references `Groups`(group_id);

alter table Classes
    add constraint classes_subject_id
        foreign key (subject_id) references `Subjects`(subject_id);

alter table Students
    add constraint student_group_id
    foreign key (group_id) references `Groups`(group_id);


alter table Exams
    add constraint exams_subject_id
        foreign key (subject_id) references `Subjects`(subject_id);

alter table Schedule
    add constraint schedule_class1_id
        foreign key (class1_id) references `Classes`(class_id);

alter table Schedule
    add constraint schedule_class2_id
        foreign key (class2_id) references `Classes`(class_id);

alter table Schedule
    add constraint schedule_class3_id
        foreign key (class3_id) references `Classes`(class_id);

alter table Schedule
    add constraint schedule_class4_id
        foreign key (class4_id) references `Classes`(class_id);

alter table Schedule
    add constraint schedule_class5_id
        foreign key (class5_id) references `Classes`(class_id);

alter table Schedule
    add constraint schedule_class6_id
        foreign key (class6_id) references `Classes`(class_id);

alter table Schedule
    add constraint schedule_class7_id
        foreign key (class7_id) references `Classes`(class_id);


insert into `Groups`(group_no) values ('M33371');

insert into Subjects(group_id, subject_name, lector) values
    (1, 'Анализ данных', 'Муравьёв Сергей Борисович'),
    (1, 'Методы трансляции', 'Станкевич Андрей Сергеевич'),
    (1, 'Параллельное программирование', 'Елизаров Роман Анатольевич'),
    (1, 'Математическая статистика', 'Блаженов Алексей Викторович'),
    (1, 'Функциональное программирование', 'Serokell'),
    (1, 'PHP', 'VK'),
    (1, 'Blockchain', 'MixBytes');

insert into Useful(subject_id, link_name, link) values
    (1, 'Баллы', 'https://vk.cc/cjQcVA'),
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

insert into Exams(group_id, subject_id, ts) values
    (1, 2, '2022-01-13'),
    (1, 3, '2022-01-17'),
    (1, 4, '2022-01-23');

insert into Classes(subject_id, start_class, end_class) values
    (4, '11:40:00', '13:10:00'),
    (4, '15:20:00', '16:50:00'),
    (3, '17:00:00', '18:30:00'),
    (3, '18:40:00', '20:10:00'),
    (2, '13:30:00', '15:00:00'),
    (1, '15:20:00', '16:50:00'),
    (1, '17:00:00', '18:30:00'),
    (6, '17:00:00', '18:30:00'),
    (7, '12:00:00', '13:30:00'),
    (5, '11:40:00', '13:10:00'),
    (5, '13:30:00', '15:00:00');

# 8:20 10:00 11:40 13:30 15:20 17:00 18:40 20:00
insert into Schedule(group_id, weekday, class1_id, class2_id, class3_id, class4_id, class5_id, class6_id, class7_id) values
    (1, 1, null, null, 1, null, 2, 3, 4),
    (1, 2, null, null, null, 5, 6, 7, null),
    (1, 3, null, null, null, null, null, 8, null),
    (1, 4, null, null, 9, null, null, null, null),
    (1, 5, null, null, 10, 11, null, null, null);




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

