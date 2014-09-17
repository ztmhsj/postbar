create table user
(
    uid int unsigned not null auto_increment primary key,
    username char(16) not null unique,
    passwd char(32) not null ,
    email  varchar(30) not null default 'xxx@xx.com',
    create_time int unsigned not null,
    permission tinyint unsigned not null default 0,
    icon tinyint unsigned default 0,
    index(username)
)engine innodb charset utf8;

insert into user (username,passwd,email,create_time,permission)
values
( 'zz',md5(123),'xxxxx@xx.com',unix_timestamp(),3),
( 'user1',md5(123),'xx@xx.com',unix_timestamp(),0 );

create table thread
(
     tid int unsigned not null auto_increment primary key,
     subject char(30) not null ,
     uid int unsigned not null ,
     lastime int unsigned not null default 0,
     post_count int unsigned not null default 0,
     fine tinyint unsigned not null default 0,
     foreign key (uid) references user (uid) on delete cascade
)engine innodb charset utf8;


create table post
(
    pid int unsigned not null auto_increment primary key,
    tid int unsigned not null,
    content varchar(2000) not null,
    uid int unsigned not null,
    public_time int unsigned not null,
    foreign key (uid) references user (uid) on delete cascade,
    foreign key (tid) references thread (tid) on delete cascade
)engine innodb charset utf8;



create table reply
(
    rid int unsigned not null auto_increment primary key,
    pid int unsigned not null,
    content varchar(100) not null,
    uid int unsigned not null,
    public_time int unsigned not null,
    foreign key (pid) references post (pid) on delete cascade,
    foreign key (uid) references user (uid) on delete cascade
)engine innodb charset utf8;


create view vthread as (select post.tid,subject,content,user.uid,post_count,username,permission,public_time,lastime,fine,icon
from thread left join user on thread.uid=user.uid left join post on thread.tid=post.tid group by tid);

create view vpost as (select pid,tid,content,user.uid,username,permission,public_time,icon
from post left join user on post.uid=user.uid);

create view vreply as (select rid,pid,content,user.uid,username,permission,public_time,icon
from reply left join user on reply.uid=user.uid);
