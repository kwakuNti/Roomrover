--  ../INCLUDE/ROOM_SELECTION.PHP

DROP DATABASE IF EXISTS room_rover;
CREATE DATABASE room_rover;
USE room_rover;

CREATE TABLE Users (
    UserID INT PRIMARY KEY AUTO_INCREMENT,
    FirstName VARCHAR(50),
    LastName VARCHAR(50),
    DateOfBirth DATE,
    Gender VARCHAR(10),
    Email VARCHAR(60) UNIQUE,
    PhoneNumber VARCHAR(15),
    Password VARCHAR(255),
    Bio TEXT,
    UserType VARCHAR(10),
    LinkedIn VARCHAR(255),
    Instagram VARCHAR(255),
    ProfileImage VARCHAR(255), 
    DisabilityStatus BOOLEAN
);

-- Create the Hostels table
CREATE TABLE Hostels (
    HostelID INT PRIMARY KEY AUTO_INCREMENT,
    HostelName VARCHAR(50) UNIQUE
);

-- Create the Rooms table, referencing Hostels
CREATE TABLE Rooms (
    RoomID INT PRIMARY KEY AUTO_INCREMENT,
    HostelID INT,
    RoomNumber VARCHAR(10),
    Capacity INT,
    RoomImage VARCHAR(255),
    FOREIGN KEY (HostelID) REFERENCES Hostels(HostelID)
);

-- Create the Slots table with SlotNumber
CREATE TABLE Slots (
    SlotID INT PRIMARY KEY AUTO_INCREMENT,
    RoomID INT,
    SlotNumber INT,
    IsAvailable BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (RoomID) REFERENCES Rooms(RoomID)
);

-- Create the Bookings table, referencing SlotID from the Slots table
CREATE TABLE Bookings (
    BookingID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT,
    RoomID INT,
    SlotID INT, -- Reference SlotID for individual slot booking
    BookingDate DATE,
    FOREIGN KEY (UserID) REFERENCES Users(UserID),
    FOREIGN KEY (RoomID) REFERENCES Rooms(RoomID),
    FOREIGN KEY (SlotID) REFERENCES Slots(SlotID)
);

CREATE TABLE Pairings (
    PairingID INT PRIMARY KEY AUTO_INCREMENT,
    CompatibilityScore DECIMAL(5,2)
);

CREATE TABLE PairingMembers (
    PairingMemberID INT PRIMARY KEY AUTO_INCREMENT,
    PairingID INT,
    UserID INT,
    FOREIGN KEY (PairingID) REFERENCES Pairings(PairingID),
    FOREIGN KEY (UserID) REFERENCES Users(UserID)
);

CREATE TABLE Notifications (
    NotificationID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT,
    NotificationText TEXT,
    DateCreated TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (UserID) REFERENCES Users(UserID)
);

CREATE TABLE Blacklist (
    BlacklistID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT,
    Reason TEXT,
    DateAdded TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (UserID) REFERENCES Users(UserID)
);

CREATE TABLE Feedback (
    FeedbackID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT,
    FeedbackText TEXT,
    DateCreated TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (UserID) REFERENCES Users(UserID)
);

CREATE TABLE Likes (
    LikeID INT PRIMARY KEY AUTO_INCREMENT,
    LikeText VARCHAR(255)
);

CREATE TABLE Dislikes (
    DislikeID INT PRIMARY KEY AUTO_INCREMENT,
    DislikeText VARCHAR(255)
);

CREATE TABLE Knows (
    KnowID INT PRIMARY KEY AUTO_INCREMENT,
    KnowText VARCHAR(255)
);

CREATE TABLE UserLikes (
    UserLikeID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT,
    LikeID INT,
    FOREIGN KEY (UserID) REFERENCES Users(UserID),
    FOREIGN KEY (LikeID) REFERENCES Likes(LikeID)
);

CREATE TABLE UserDislikes (
    UserDislikeID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT,
    DislikeID INT,
    FOREIGN KEY (UserID) REFERENCES Users(UserID),
    FOREIGN KEY (DislikeID) REFERENCES Dislikes(DislikeID)
);

CREATE TABLE UserKnows (
    UserKnowID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT,
    KnowID INT,
    FOREIGN KEY (UserID) REFERENCES Users(UserID),
    FOREIGN KEY (KnowID) REFERENCES Knows(KnowID)
);

-- Populate the Hostels table with 7 hostels
INSERT INTO Hostels (HostelName) VALUES
('Hostel A'),
('Hostel B'),
('Hostel C'),
('Hostel D'),
('Hostel E'),
('Hostel F'),
('Hostel G');

-- Populate the Rooms table with the new structure
INSERT INTO Rooms (HostelID, RoomNumber, Capacity, RoomImage) VALUES
(1, '101', 4, '../templates/img/banner/banner.png'),
(1, '102', 2, '../templates/img/banner/banner.png'),
(1, '103', 4, '../templates/img/banner/banner.png'),
(2, '201', 2, '../templates/img/banner/banner.png'),
(2, '202', 4, '../templates/img/banner/banner.png'),
(2, '203', 2, '../templates/img/banner/banner.png'),
(3, '301', 4, '../templates/img/banner/banner.png'),
(3, '302', 2, '../templates/img/banner/banner.png'),
(3, '303', 4, '../templates/img/banner/banner.png'),
(4, '401', 2, '../templates/img/banner/banner.png'),
(4, '402', 4, '../templates/img/banner/banner.png'),
(4, '403', 2, '../templates/img/banner/banner.png');

-- Populate the Slots table with slots for each room
INSERT INTO Slots (RoomID, SlotNumber, IsAvailable) VALUES
(1, 1, TRUE),
(1, 2, TRUE),
(1, 3, TRUE),
(1, 4, TRUE),
(2, 1, TRUE),
(2, 2, TRUE),
(3, 1, TRUE),
(3, 2, TRUE),
(3, 3, TRUE),
(3, 4, TRUE),
(4, 1, TRUE),
(4, 2, TRUE),
(5, 1, TRUE),
(5, 2, TRUE),
(5, 3, TRUE),
(5, 4, TRUE),
(6, 1, TRUE),
(6, 2, TRUE),
(7, 1, TRUE),
(7, 2, TRUE),
(7, 3, TRUE),
(7, 4, TRUE);
