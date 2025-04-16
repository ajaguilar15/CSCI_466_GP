-- Group project - Online store database --

-- Creating tables --

-- USER/ACCOUNT table--
-- Double check to make sure that the table name work --
-- Phone numbers are limited to the US (foreign numbers can be longer or shorter)
CREATE TABLE [USER]
(
    USERID CHAR(2) NOT NULL PRIMARY KEY,
    NAME VARCHAR(20) NOT NULL,
    EMAIL VARCHAR(20),
    PASSWORD VARCHAR(20) NOT NULL,
    ADDRESS CHAR(40)NOT NULL,
    PHONENUM INT(10) NOT NULL,
    BILLINFO INT(16) NOT NULL
);

-- PRODUCT table --
-- QTY should not be null and should be at least have '0' in none --
CREATE TABLE PRODUCT
(
    PRODUCTID CHAR(2) PRIMARY KEY,
    PNAME VARCHAR(20) NOT NULL,
    DESCRIPTION VARCHAR(20),
    PRICE DECIMAL(10,2) NOT NULL,
    STOCKQTY INT(3) NOT NULL
);

-- SHOPPING CART table --
-- QTY should not be null and should at least have '0' if none --
CREATE TABLE CART
(
    CARTID CHAR(2) PRIMARY KEY,
    PRODUCTID CHAR(2) NOT NULL,
    USERQTY INT(2) NOT NULL,
    FOREIGN KEY (PRODUCTID) REFERENCES PRODUCT(PRODUCTID)
);

-- ORDER table --
-- Double check to make sure that the table name works --
-- STATUS should be limited to words of PENDING PROCESSING CANCELLED and COMPLETED --
CREATE TABLE [ORDER]
(
    ORDERID CHAR(2) PRIMARY KEY,
    CARTID CHAR(2) NOT NULL,
    USERID CHAR(2)NOT NULL,
    TOTAL DECIMAL(10,2)NOT NULL,
    OSTATUS CHAR(10)NOT NULL,

    FOREIGN KEY (CARTID) REFERENCES CART(CARTID)
    FOREIGN KEY (USERID) REFERENCES [USER](USERID)
);

-- SHIPMENT table --
-- STATUS should be limited to words of SHIPPED and DELIVERED --
CREATE TABLE SHIPMENT
(
    SHIPID CHAR(2)PRIMARY KEY,
    ORDERID CHAR(2) NOT NULL,
    TRACKNUM INT(10) NOT NULL,
    SSTATUS CHAR(10)NOT NULL,

    FOREIGN KEY (ORDERID) REFERENCES [ORDER](ORDERID)
);

-- Inserting data into tables --

