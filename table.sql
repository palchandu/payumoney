CREATE TABLE info_payment(
 id int NOT NULL AUTO_INCREMENT,
 fullname varchar(100) NOT NULL,
 email varchar(50) NOT NULL,
 phone varchar(10) NOT NULL,
 amount decimal(10,2) NOT NULL DEFAULT 0.00,
 product_info varchar(500) NOT NULL,
 txn_id varchar(200),
 whatsapp_num varchar(10),
 state varchar(50),
 branch varchar(50),
 remarks varchar(100),
 address varchar(500),
 pincode varchar(6),
 paymentpurpose varchar(50),
 reference_id varchar(100),
 payment_status varchar(50),
 created int,
 updated int,
 created_by varchar(10),
 updated_by varchar(10),
 deleted varchar(2) DEFAULT 'N',
 PRIMARY KEY(id)
);

alter table info_payment add column payment_mode varchar(10);
alter table info_payment add column card_categoty varchar(50);
alter table info_payment add column payment_date varchar(50);
alter table info_payment add column cardnum varchar(50);
alter table info_payment add column name_on_card varchar(50);
