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
    group_id int,
    weekday char(3),
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

alter table Students
    add constraint student_group_id
    foreign key (group_id) references `Groups`(group_id);

alter table Useful
    add constraint useful_subject_id
        foreign key (subject_id) references `Subjects`(subject_id);

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
    (1, 'YouTube', 'https://www.youtube.com/playlist?list=PLI83Pf8BmFlcEfss4dyvSNWi93DNsax0A'),
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

insert into Students values (171330601, 1);

# insert into Classes(subject_id, start_class, end_class) values
#     (4, '11:40:00', '13:10:00'),
#     (4, '15:20:00', '16:40:00'),
#     (3, '17:00:00', '18:20:00'),
#     (3, '18:40:00', '20:00:00')
#     (2, '13:30:')



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

