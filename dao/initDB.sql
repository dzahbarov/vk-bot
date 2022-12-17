CREATE DATABASE IF NOT EXISTS bot_db;

use bot_db;

create table group_table
(
    user_vk_id int not null,
    group_name tinytext not null
);

# insert into test_table(test_col)
# values (42);

