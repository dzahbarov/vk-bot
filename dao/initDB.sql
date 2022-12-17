CREATE DATABASE IF NOT EXISTS test_db;

use test_db;

create table test_table
(
    test_col int null
);

insert into test_table(test_col)
values (42);

