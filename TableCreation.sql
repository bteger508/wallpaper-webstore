DROP TABLE IF  EXISTS USER;
DROP TABLE IF  EXISTS PRODUCT;
DROP TABLE IF  EXISTS SHOPPING_CART;

CREATE TABLE USER(
Userid varchar(12) NOT NULL,
Password varchar(256) NOT NULL,
Fname varchar(15) NOT NULL,
Minit char,
Lname varchar(15) NOT NULL,
Bdate Date,
Sex   char,
DateRegistered Date,
DateLastActive Date,
primary key(Userid)
);

CREATE TABLE PRODUCT(
Productid varchar(12) NOT NULL,
Price decimal(15,2),
Path varchar (100),
primary key(Productid)
);

CREATE TABLE SHOPPING_CART(
Cartid varchar(12) NOT NULL,
Userid varchar(12) NOT NULL,
Productid varchar(12) NOT NULL,
Quantity INT NOT NULL,
primary key(Cartid),
foreign key(Productid) references PRODUCT(Productid),
foreign key(Userid) references USER(Userid)
);
