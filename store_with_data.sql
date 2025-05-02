-- Group project - Online store database --
-- CSCI 466 --
-- Abraham Gonzalez z2012791 --
-- Om Patel z2043569 --

-- Creating tables --

-- USER/ACCOUNT table--
-- Phone numbers are limited to the US (foreign numbers can be longer or shorter)
CREATE TABLE USERS
(
    USERID CHAR(10) NOT NULL PRIMARY KEY,
    FIRST_NAME VARCHAR(20) NOT NULL,
    LAST_NAME VARCHAR(20) NOT NULL,
    EMAIL VARCHAR(30) UNIQUE,
    PASSWORD VARCHAR(20) NOT NULL,
    ADDRESS CHAR(40) NOT NULL,
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
    STOCKQTY INT(3) NOT NULL DEFAULT 0
);

-- SHOPPING CART table --
-- QTY should not be null and should at least have '0' if none --
CREATE TABLE SHOPPING_CART
(
    USERID CHAR(10) NOT NULL,
    PRODUCTID CHAR(2) NOT NULL,
    RANDID CHAR(5) NOT NULL,
    ORDERCHECK ENUM('FALSE', 'TRUE') DEFAULT 'FALSE',
    ORDERID CHAR(2),
    USERQTY INT NOT NULL DEFAULT 1,
    PRIMARY KEY (USERID, PRODUCTID, RANDID, ORDERCHECK),
    FOREIGN KEY (USERID) REFERENCES USERS(USERID),
    FOREIGN KEY (PRODUCTID) REFERENCES PRODUCT(PRODUCTID)
);
-- CART DATE CAN BE NULL --
--ALTER TABLE SHOPPING_CART ADD CARTDATE DATE;
-- ORDER table --
-- STATUS should be limited to words of PENDING PROCESSING CANCELLED and COMPLETED --
CREATE TABLE ORDERS
(
    ORDERDATE DATE NOT NULL,
    ORDERID CHAR(2) NOT NULL,
    USERID CHAR(10) NOT NULL,
    TOTAL DECIMAL(10,2) NOT NULL,
    OSTATUS ENUM('PENDING', 'PROCESSING', 'SHIPPED', 'COMPLETED', 'CANCELLED', 'RETURNED') DEFAULT 'PENDING',
    PRIMARY KEY (ORDERID, USERID, ORDERDATE),
    FOREIGN KEY (USERID) REFERENCES USERS(USERID)
);

-- SHIPMENT table --
-- STATUS should be limited to words of SHIPPED and DELIVERED --
CREATE TABLE SHIPMENT
(
    SHIPDATE DATE NOT NULL,
    SHIPID CHAR(2) PRIMARY KEY,
    ORDERID CHAR(2) NOT NULL,
    TRACKNUM VARCHAR(20) NOT NULL,
    SSTATUS ENUM('PENDING', 'SHIPPED', 'IN_TRANSIT', 'OUT_FOR_DELIVERY', 'DELIVERED', 'FAILED_DELIVERY', 'RETURNED') DEFAULT 'PENDING',
    FOREIGN KEY (ORDERID) REFERENCES ORDERS(ORDERID)
);

-- INSERT SAMPLE DATA --

-- USERS
INSERT INTO USERS (USERID, FIRST_NAME, LAST_NAME, EMAIL, PASSWORD, ADDRESS, PHONENUM, BILLINFO) VALUES
('U1', 'Alice', 'Smith', 'alice@example.com', 'pass123', '123 Main St', '555-1234', 'token1'),
('U2', 'Bob', 'Jones', 'bob@example.com', 'pass456', '456 Elm St', '555-5678', 'token2'),
('U3', 'Clara', 'Lee', 'clara@example.com', 'pass789', '789 Oak St', '555-9876', 'token3'),
('U4', 'Michael', 'Mckeen', 'mckeen@example.com', 'pass135', '142 Smith St', '555-7896', 'token4'),
('U5', 'Maria', 'Hill', 'maria@example.com', 'pass246', '253 Clover St', '555-2983', 'token5');

-- PRODUCT
INSERT INTO PRODUCT (PRODUCTID, PNAME, DESCRIPTION, PRICE, STOCKQTY) VALUES
('P1', 'Laptop', '15 Inch display', 899.99, 12),
('P2', 'Phone', '128GB Storage', 499.49, 30),
('P3', 'Monitor', '49 Inch LED', 159.99, 20),
('P4', 'Keyboard', 'Vintage Mechanical', 79.99, 45),
('P5', 'Mouse', 'Wireless RGB', 39.99, 50),
('P6', 'Tablet', '10 Inch Display', 349.99, 25),
('P7', 'Stylus Pen', 'Precision Tip Pen', 19.99, 24),
('P8', 'Smartwatch', 'Fitness Tracker', 69.99, 40),
('P9', 'Headphones', 'Noise Cancelling', 99.99, 35),
('PX', 'Bluetooth Earbuds', 'Sport Earbuds', 35.99, 55),
('X1', 'Speaker', 'Portable Audio', 99.99, 35),
('X2', 'Camera', 'Vlogging Camera', 89.99, 30),
('X3', 'Printer', 'Color Printer', 129.49, 15),
('X4', 'Flash Drive', '512GB Storage', 45.99, 55),
('X5', 'Webcam', '1080p HD Webcam', 45.99, 55),
('X6', 'TI-84 calculator', 'Graphing Calculator', 66.99, 45),
('X7', 'External HDD', '2TB Storage', 356.99, 10),
('X8', 'Power Bank', 'Fast Charge Power', 57.49, 20),
('X9', 'Microphone', 'Wireless Audio', 28.99, 50),
('XX', 'Drone', 'HD Camera Drone', 178.99, 12);

-- ORDERS (with ORDERDATE)
INSERT INTO ORDERS (ORDERID, USERID, TOTAL, OSTATUS, ORDERDATE) VALUES
('O1', 'U1', 1219.97, 'PROCESSING', '2025-04-10'),
('O2', 'U2', 499.49, 'COMPLETED', '2025-04-09'),
('O3', 'U3', 199.96, 'PENDING', '2025-04-11'),
('O4', 'U4', 79.98, 'COMPLETED', '2025-04-30'),
('O5', 'U5', 659.48, 'COMPLETED', '2025-05-1');

-- SHIPMENT (with SHIPDATE)
INSERT INTO SHIPMENT (SHIPID, ORDERID, TRACKNUM, SSTATUS, SHIPDATE) VALUES
('S1', 'O1', '1Z999AA101234', 'PENDING', '2025-04-11'),
('S2', 'O2', '999999999999', 'RETURNED', '2025-04-13'),
('S3', 'O3', 'TRACK123', 'PENDING', '2025-04-11'),
('S4', 'O4', 'KS230JENWP07', 'FAILED_DELIVERY', '2025-05-05'),
('S5', 'O5', 'NNO3234GWNWLSI', 'OUT_FOR_DELIVERY', '2025-05-2');
