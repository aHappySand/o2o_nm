/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     2019/8/9 22:00:28                            */
/*==============================================================*/


drop table if exists Token;

drop index business_city_id_idx on business;

drop table if exists business;

drop index business_user_username_idx on business_user;

drop table if exists business_user;

drop table if exists category;

drop index city_item on city;

drop table if exists city;

drop table if exists coupon;

drop index member_mobile_index on member;

drop index member_email_index on member;

drop index member_username_index on member;

drop table if exists member;

drop index product_current_price on product;

drop index product_business_id on product;

drop index product_catetory_id on product;

drop table if exists product;

drop table if exists recommend;

drop index shop_city_id_idx on shop;

drop index shop_category_id_idx on shop;

drop table if exists shop;

drop table if exists shop_manager;

drop table if exists shop_order;

drop index tradeArea_city_id_idx on trade_area;

drop table if exists trade_area;

/*==============================================================*/
/* Table: Token                                                 */
/*==============================================================*/
create table Token
(
   id                   int not null auto_increment,
   token_val            varchar(255),
   token_type           enum("1","2","3") default '1' comment 'token类型，1:pc,2:app，3:ipad',
   time_out             int(11) comment '过期时间',
   weight               int comment '权重',
   create_time          int(11) not null comment '创建时间',
   update_time          int(11) not null comment '更新时间',
   status               tinyint(1) not null default 1 comment '状态',
   primary key (id)
);

alter table Token comment 'token管理';

/*==============================================================*/
/* Table: business                                              */
/*==============================================================*/
create table business
(
   id                   int not null auto_increment,
   name                 varchar(50) comment '商户名称',
   email                varchar(50) comment '商户邮件地址',
   logo                 varchar(255) comment 'logo地址',
   licence_logo         varchar(255) comment '营业执照图片地址',
   description          text comment '描述',
   city_id              smallint,
   city_path            varchar(50) comment '城市路径，比如1,2',
   bank_info            varchar(50) comment '银行账户',
   money                decimal(20,2) comment '余额',
   bank_name            varchar(50) comment '开户行',
   bank_user            varchar(50) comment '账户名',
   legal_user           varchar(50) comment '法人',
   legal_tel            varchar(20) comment '法人联系电话',
   weight               int comment '权重',
   create_time          int(11) not null comment '创建时间',
   update_time          int(11) not null comment '更新时间',
   status               tinyint(2) not null default 1 comment '状态',
   primary key (id)
);

alter table business comment '商户';

/*==============================================================*/
/* Index: business_city_id_idx                                  */
/*==============================================================*/
create index business_city_id_idx on business
(
   city_id
);

/*==============================================================*/
/* Table: business_user                                         */
/*==============================================================*/
create table business_user
(
   id                   int not null auto_increment,
   username             varchar(30) comment '用户名',
   password             char(32) comment '密码',
   code                 varchar(10) comment '随机数',
   business_id          int,
   last_login_ip        varchar(20) comment '最后登录的IP',
   last_login_time      int,
   is_main              smallint comment '是否为总管理员',
   weight               int comment '权重',
   create_time          int(11) not null comment '创建时间',
   update_time          int(11) not null comment '更新时间',
   status               tinyint(2) not null default 1 comment '状态',
   primary key (id)
);

alter table business_user comment '商户账户';

/*==============================================================*/
/* Index: business_user_username_idx                            */
/*==============================================================*/
create unique index business_user_username_idx on business_user
(
   username
);

/*==============================================================*/
/* Table: category                                              */
/*==============================================================*/
create table category
(
   id                   int not null auto_increment,
   parent_id            smallint default 0,
   item                 varchar(50) not null,
   code                 varchar(10) not null,
   weight               int comment '权重',
   create_time          int(11) not null comment '创建时间',
   update_time          int(11) not null comment '更新时间',
   status               tinyint(2) not null default 1 comment '状态',
   primary key (id)
);

alter table category comment '分类';

/*==============================================================*/
/* Table: city                                                  */
/*==============================================================*/
create table city
(
   id                   int not null auto_increment,
   parent_id            smallint default 0,
   item                 varchar(50) not null,
   code                 varchar(10) not null,
   weight               int comment '权重',
   create_time          int(11) not null comment '创建时间',
   update_time          int(11) not null comment '更新时间',
   status               tinyint(2) not null default 1 comment '状态',
   primary key (id)
);

alter table city comment '城市';

/*==============================================================*/
/* Index: city_item                                             */
/*==============================================================*/
create index city_item on city
(
   item
);

/*==============================================================*/
/* Table: coupon                                                */
/*==============================================================*/
create table coupon
(
   id                   int not null auto_increment,
   weight               int comment '权重',
   create_time          int(11) not null comment '创建时间',
   update_time          int(11) not null comment '更新时间',
   status               tinyint(2) not null default 1 comment '状态',
   primary key (id)
);

alter table coupon comment '消费券';

/*==============================================================*/
/* Table: member                                                */
/*==============================================================*/
create table member
(
   id                   int not null auto_increment,
   username             varchar(20) not null,
   password             char(32) not null,
   code                 varchar(10),
   last_login_ip        varchar(20) not null,
   last_login_time      int not null,
   email                varchar(32) not null,
   mobile               varchar(20) not null,
   weight               int comment '权重',
   create_time          int(11) not null comment '创建时间',
   update_time          int(11) not null comment '更新时间',
   status               tinyint(2) not null default 1 comment '状态',
   primary key (id)
);

alter table member comment '会员';

/*==============================================================*/
/* Index: member_username_index                                 */
/*==============================================================*/
create unique index member_username_index on member
(
   username
);

/*==============================================================*/
/* Index: member_email_index                                    */
/*==============================================================*/
create unique index member_email_index on member
(
   email
);

/*==============================================================*/
/* Index: member_mobile_index                                   */
/*==============================================================*/
create unique index member_mobile_index on member
(
   mobile
);

/*==============================================================*/
/* Table: product                                               */
/*==============================================================*/
create table product
(
   id                   int not null auto_increment,
   name                 varchar(100),
   catetory_id          smallint,
   se_category_id       smallint,
   business_id          int comment '商家',
   shop_id              varchar(40) comment '店面，可能为多个',
   image                varchar(200),
   description          text comment '描述',
   start_time           int(11) comment '团购开始时间',
   end_time             int(11) comment '结束时间',
   current_price        decimal(10,2) comment '当前价',
   origin_price         decimal(10,2) comment '原价',
   total_count          int comment '库存',
   buy_count            int comment '购买份数',
   coupons_start_time   int(11) comment '消费券开始时间',
   coupons_end_time     int(11) comment '消费券结束时间',
   business_user_id     int comment '属于哪个商家',
   balance_price        decimal(10,2) comment '平台提成',
   note                 text comment '提示',
   weight               int comment '权重',
   create_time          int(11) not null comment '创建时间',
   update_time          int(11) not null comment '更新时间',
   status               tinyint(2) not null default 1 comment '状态',
   primary key (id)
);

alter table product comment '商品';

/*==============================================================*/
/* Index: product_catetory_id                                   */
/*==============================================================*/
create index product_catetory_id on product
(
   catetory_id
);

/*==============================================================*/
/* Index: product_business_id                                   */
/*==============================================================*/
create index product_business_id on product
(
   business_id
);

/*==============================================================*/
/* Index: product_current_price                                 */
/*==============================================================*/
create index product_current_price on product
(
   current_price
);

/*==============================================================*/
/* Table: recommend                                             */
/*==============================================================*/
create table recommend
(
   id                   int not null auto_increment,
   type                 smallint comment '类型',
   title                varchar(30) comment '标题',
   image                varchar(255) comment '图片',
   url                  varchar(255) comment '商品链接',
   description          varchar(255) comment '描述',
   weight               int comment '权重',
   create_time          int(11) not null comment '创建时间',
   update_time          int(11) not null comment '更新时间',
   status               tinyint(2) not null default 1 comment '状态',
   primary key (id)
);

alter table recommend comment '推荐位';

/*==============================================================*/
/* Table: shop                                                  */
/*==============================================================*/
create table shop
(
   id                   int not null auto_increment,
   name                 varchar(50) comment '门店名',
   logo                 varchar(255),
   address              varchar(255) comment '门店地址',
   tel                  varchar(20) comment '联系方式',
   contact              varchar(20) comment '联系人',
   xpoint               varchar(20) comment '经度',
   ypoint               varchar(20) comment '纬度',
   business_id          int comment '所属商户',
   open_time            int comment '开业时间',
   description          text comment '描述',
   is_main              int comment '是否为总店',
   api_address          char(10),
   city_id              smallint,
   city_path            varchar(20),
   category_id          int,
   catetory_path        varchar(20),
   bank_info            varchar(50),
   weight               int comment '权重',
   create_time          int(11) not null comment '创建时间',
   update_time          int(11) not null comment '更新时间',
   status               tinyint(2) not null default 1 comment '状态',
   primary key (id)
);

alter table shop comment '门店';

/*==============================================================*/
/* Index: shop_category_id_idx                                  */
/*==============================================================*/
create index shop_category_id_idx on shop
(
   category_id
);

/*==============================================================*/
/* Index: shop_city_id_idx                                      */
/*==============================================================*/
create index shop_city_id_idx on shop
(
   city_id
);

/*==============================================================*/
/* Table: shop_manager                                          */
/*==============================================================*/
create table shop_manager
(
   id                   int not null auto_increment,
   weight               int comment '权重',
   create_time          int(11) not null comment '创建时间',
   update_time          int(11) not null comment '更新时间',
   status               tinyint(2) not null default 1 comment '状态',
   primary key (id)
);

alter table shop_manager comment '门店管理员';

/*==============================================================*/
/* Table: shop_order                                            */
/*==============================================================*/
create table shop_order
(
   id                   int not null auto_increment,
   weight               int comment '权重',
   create_time          int(11) not null comment '创建时间',
   update_time          int(11) not null comment '更新时间',
   status               tinyint(2) not null default 1 comment '状态',
   primary key (id)
);

alter table shop_order comment '订单';

/*==============================================================*/
/* Table: trade_area                                            */
/*==============================================================*/
create table trade_area
(
   id                   int not null auto_increment,
   name                 varchar(50) comment '名称',
   city_id              smallint,
   parent_id            int,
   weight               int comment '权重',
   create_time          int(11) not null comment '创建时间',
   update_time          int(11) not null comment '更新时间',
   status               tinyint(2) not null default 1 comment '状态',
   primary key (id)
);

alter table trade_area comment '商圈';

/*==============================================================*/
/* Index: tradeArea_city_id_idx                                 */
/*==============================================================*/
create index tradeArea_city_id_idx on trade_area
(
   city_id
);

