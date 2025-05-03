-- data_for_store.sql --

-- CSCI 466 --
-- Section 1 --

-- Abraham Gonzalez z2012791 --
-- Om Patel z2043569 --
-- Anthony Aguilar-Herrera z1878942 --
-- Jason Rosas z2045088 --

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
INSERT INTO SHIPMENT (SHIPID, ORDERID, TRACKNUM, SHIPDATE) VALUES
('S1', 'O1', '1Z999AA101234', '2025-04-11'),
('S2', 'O2', '999999999999', '2025-04-13'),
('S3', 'O3', 'TRACK123', '2025-04-11'),
('S4', 'O4', 'KS230JENWP07', '2025-05-05'),
('S5', 'O5', 'NNO3234GWNWLSI', '2025-05-2');
