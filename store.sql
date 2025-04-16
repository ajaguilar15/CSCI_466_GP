-- Group project - Online store database --
-- CSCI 466 --
-- Abraham Gonzalez z2012791 --
-- Om Patel z2043569 --

-- Creating tables --

-- USER/ACCOUNT table--
-- Double check to make sure that the table name work --
-- Phone numbers are limited to the US (foreign numbers can be longer or shorter)
CREATE TABLE USERS
(
    USERID CHAR(2) NOT NULL PRIMARY KEY,
    FIRST_NAME VARCHAR(20) NOT NULL,
    LAST_NAME VARCHAR(20) NOT NULL,
    EMAIL VARCHAR(20) UNIQUE,
    PASSWORD VARCHAR(20) NOT NULL,
    ADDRESS CHAR(40)NOT NULL,
    PHONENUM VARCHAR(15) NOT NULL,
    BILLINFO VARCHAR(25) -- placeholder for encrypted billing token
);

-- PRODUCT table --
-- QTY should not be null and should be at least have '0' in none --
CREATE TABLE PRODUCT
(
    PRODUCTID CHAR(2) PRIMARY KEY,
    PNAME VARCHAR(20) NOT NULL,
    DESCRIPTION VARCHAR(20),
    PRICE DECIMAL(10,2) NOT NULL,
    STOCKQTY INT(3),
);

-- SHOPPING CART table --
-- QTY should not be null and should at least have '0' if none --
CREATE TABLE SHOPPING_CART
(
    USERID CHAR(2) NOT NULL,
    PRODUCTID CHAR(2) NOT NULL,
    USERQTY INT NOT NULL DEFAULT 1,
    PRIMARY KEY (USERID, PRODUCTID),
    FOREIGN KEY (USERID) REFERENCES USERS(USERID),
    FOREIGN KEY (PRODUCTID) REFERENCES PRODUCT(PRODUCTID)
);

-- ORDER table --
-- Double check to make sure that the table name works --
-- STATUS should be limited to words of PENDING PROCESSING CANCELLED and COMPLETED --
CREATE TABLE ORDERS
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
    TRACKNUM VARCHAR(20) NOT NULL,
    SSTATUS VARCHAR(20) NOT NULL CHECK (SSTATUS IN ('SHIPPED', 'DELIVERED')),
    FOREIGN KEY (ORDERID) REFERENCES ORDERS(ORDERID)
);

-- Inserting data into tables --

