CREATE TABLE Clients (
ClientID VARCHAR(20),
CName VARCHAR(20) NOT NULL,
CEmail VARCHAR(20) NOT NULL,
CPassword VARCHAR(20) NOT NULL,
CAddress VARCHAR(100),
CPhone VARCHAR(20),
PRIMARY KEY (ClientID),
UNIQUE(CEmail),
CHECK (REGEXP_LIKE(CEmail,'^\w+(\.\w+)*+@\w+(\.\w+)+$')));

CREATE TABLE Sellers (
SellerID VARCHAR(20),
SName VARCHAR(20) NOT NULL,
SEmail VARCHAR(20) NOT NULL,
SPassword VARCHAR(20) NOT NULL,
Reputation VARCHAR(10),
Speed VARCHAR(10),
SalesVolume INTEGER,
PRIMARY KEY (SellerID),
UNIQUE (SEmail),
CHECK (Speed = 'Slow' OR Speed = 'Mediocre' OR Speed = 'Fast'),
CHECK (Reputation = 'Bad' OR Reputation = 'Mediocre' OR Reputation = 'Good' OR Reputation = 'Great'),
CHECK (REGEXP_LIKE(SEmail,'^\w+(\.\w+)*+@\w+(\.\w+)+$')));

CREATE TABLE Appetites_Request (
AppetiteID VARCHAR(20),
AFlavor VARCHAR(20),
ACost INTEGER,
ARating INTEGER,
ClientID VARCHAR(20),
PRIMARY KEY (AppetiteID, ClientID),
FOREIGN KEY (ClientID) REFERENCES Clients (ClientID) ON DELETE CASCADE,
CHECK (AFlavor = 'Burgers' OR AFlavor = 'Pizza' OR AFlavor = 'Food with rice' OR  AFlavor = 'Others'),
CHECK (ACost > 0),
CHECK (ARating = 1 OR ARating = 2 OR ARating = 3 OR ARating = 4 OR ARating = 5));

CREATE TABLE Restaurants_Own (
RestaurantID VARCHAR(20),
RName VARCHAR(50) NOT NULL,
RAddress VARCHAR(50),
RPhone VARCHAR(20),
RFlavor VARCHAR(20),
RCost INTEGER,
RRating INTEGER,
RHours VARCHAR(20),
SellerID VARCHAR(20),
PRIMARY KEY (RestaurantID, SellerID),
FOREIGN KEY (SellerID) REFERENCES Sellers (SellerID) ON DELETE CASCADE,
CHECK (RFlavor = 'Burgers' OR RFlavor = 'Pizza' OR RFlavor = 'Food with rice' OR  RFlavor = 'Others'),
CHECK (RCost >0),
CHECK (RRating = 1 OR RRating = 2 OR RRating = 3 OR RRating = 4 OR RRating = 5));

CREATE TABLE Reviews_Have (
ReviewID VARCHAR(20),
Photo LONGBLOB,
RVRating INTEGER,
Description VARCHAR(1000),
ReviewDate DATE,
RestaurantID VARCHAR(20),
PRIMARY KEY (ReviewID, RestaurantID),
FOREIGN KEY (RestaurantID) REFERENCES Restaurants_Own(RestaurantID) ON DELETE CASCADE,
CHECK (RVRating = 1 OR RVRating = 2 OR RVRating = 3 OR RVRating = 4 OR RVRating = 5));

CREATE TABLE Reviews_Write (
ReviewID VARCHAR(20),
ClientID VARCHAR(20),
PRIMARY KEY (ReviewID, ClientID),
FOREIGN KEY (ReviewID) REFERENCES Reviews_Have(ReviewID) ON DELETE CASCADE,
FOREIGN KEY (ClientID) REFERENCES Clients(ClientID));

CREATE TABLE Orders_Deliver (
OrderID VARCHAR(20),
OrderedTime TIMESTAMP,
DeliveredTime TIMESTAMP,
Price VARCHAR(20),
SellerID VARCHAR(20),
PRIMARY KEY (OrderID, SellerID),
FOREIGN KEY (SellerID) REFERENCES Sellers(SellerID) ON DELETE CASCADE,
CHECK (OrderedTime < DeliveredTime));

CREATE TABLE Orders_Delivered (
    OrderID VARCHAR(20),
    ClientID VARCHAR(20),
PRIMARY KEY (OrderID, ClientID),
FOREIGN KEY (OrderID) REFERENCES Orders_Deliver(OrderID) ON DELETE CASCADE,
FOREIGN KEY (ClientID) REFERENCES Clients(ClientID) ON DELETE CASCADE);
