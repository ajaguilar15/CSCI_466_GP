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
    STOCKQTY INT(3)
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
    USERID CHAR(2) NOT NULL,
    TOTAL DECIMAL(10,2) NOT NULL,
    OSTATUS CHAR(10) NOT NULL,

    FOREIGN KEY (USERID) REFERENCES USERS(USERID)
);

-- SHIPMENT table --
-- STATUS should be limited to words of SHIPPED and DELIVERED --
CREATE TABLE SHIPMENT
(
    SHIPID CHAR(2) PRIMARY KEY,
    ORDERID CHAR(2) NOT NULL,
    TRACKNUM VARCHAR(20) NOT NULL,
    SSTATUS VARCHAR(20) NOT NULL CHECK (SSTATUS IN ('SHIPPED', 'DELIVERED')),
    FOREIGN KEY (ORDERID) REFERENCES ORDERS(ORDERID)
);

-- Inserting data into tables --




-- INSERT SAMPLE DATA --

-- 1. USERS
INSERT INTO USERS (USERID, FIRST_NAME, LAST_NAME, EMAIL, PASSWORD, ADDRESS, PHONENUM, BILLINFO) VALUES
('U1', 'Alice', 'Smith', 'alice@example.com', 'pass123', '123 Main St', '555-1234', 'token1'),
('U2', 'Bob', 'Jones', 'bob@example.com', 'pass456', '456 Elm St', '555-5678', 'token2'),
('U3', 'Clara', 'Lee', 'clara@example.com', 'pass789', '789 Oak St', '555-9876', 'token3');

-- 2. PRODUCT
INSERT INTO PRODUCT (PRODUCTID, PNAME, DESCRIPTION, PRICE, STOCKQTY) VALUES
('P1', 'Laptop', '15 inch display', 899.99, 12),
('P2', 'Phone', '128GB storage', 499.49, 30),
('P3', 'Monitor', '24 inch LED', 159.99, 20),
('P4', 'Keyboard', 'Mechanical', 79.99, 45),
('P5', 'Mouse', 'Wireless', 39.99, 50);

-- 3. ORDERS
INSERT INTO ORDERS (ORDERID, USERID, OrderDate, STATUS) VALUES
('O1', 'U1', '2025-04-01', 'PROCESSING'),
('O2', 'U2', '2025-04-02', 'COMPLETED'),
('O3', 'U3', '2025-04-03', 'PENDING');

-- 4. SHIPMENTS
INSERT INTO SHIPMENTS (SHIPMENTID, ORDERID, SHIPMENTDATE, ESTIMATEDARRIVAL, TRACKINGNUMBER, STATUS) VALUES
('S1', 'O1', '2025-04-02', '2025-04-06', '1Z999AA10123456784', 'SHIPPED'),
('S2', 'O2', '2025-04-02', '2025-04-05', '999999999999', 'DELIVERED'),
('S3', 'O3', NULL, NULL, NULL, 'PENDING');
