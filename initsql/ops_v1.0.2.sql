#增加用户表page字段，用于用户列表显示分页，默认按每页10条记录分页
alter table ops_user add page int(3) default 10 not null;
