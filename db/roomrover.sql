-- Database: room_rover

DROP DATABASE IF EXISTS room_rover;
CREATE DATABASE room_rover;
USE room_rover;

-- Users table to store user information
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
    Country VARCHAR(150),
    UserType VARCHAR(10),
    LinkedIn VARCHAR(255),
    Instagram VARCHAR(255),
    ProfileImage VARCHAR(255), 
    DisabilityStatus BOOLEAN
);

-- Hostels table to store hostel information
CREATE TABLE Hostels (
    HostelID INT PRIMARY KEY AUTO_INCREMENT,
    HostelName VARCHAR(50) UNIQUE
);

-- Rooms table to store room information within each hostel
CREATE TABLE Rooms (
    RoomID INT PRIMARY KEY AUTO_INCREMENT,
    HostelID INT,
    RoomNumber VARCHAR(10),
    Capacity INT,
    RoomImage VARCHAR(255),
    FOREIGN KEY (HostelID) REFERENCES Hostels(HostelID)
);

-- Slots table to manage the availability of each slot within a room
CREATE TABLE Slots (
    SlotID INT PRIMARY KEY AUTO_INCREMENT,
    RoomID INT,
    SlotNumber INT,
    IsAvailable BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (RoomID) REFERENCES Rooms(RoomID)
);

-- Bookings table to manage the assignment of users to specific slots in rooms
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

-- Pairings table to store potential room pairings and their compatibility scores
CREATE TABLE Pairings (
    PairingID INT PRIMARY KEY AUTO_INCREMENT,
    CompatibilityScore DECIMAL(5,2)
);

-- PairingMembers table to associate users with specific pairings
CREATE TABLE PairingMembers (
    PairingMemberID INT PRIMARY KEY AUTO_INCREMENT,
    PairingID INT,
    UserID INT,
    FOREIGN KEY (PairingID) REFERENCES Pairings(PairingID),
    FOREIGN KEY (UserID) REFERENCES Users(UserID)
);

-- Notifications table to store notifications for users
CREATE TABLE Notifications (
    NotificationID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT,
    NotificationText TEXT,
    DateCreated TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (UserID) REFERENCES Users(UserID)
);

-- Blacklist table to manage users who have been blacklisted
CREATE TABLE Blacklist (
    BlacklistID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT,
    Reason TEXT,
    DateAdded TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (UserID) REFERENCES Users(UserID)
);


CREATE TABLE Requests (
    RequestID INT PRIMARY KEY AUTO_INCREMENT,
    SenderUserID INT,          
    ReceiverUserID INT,       
    RequestDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    Accepted BOOLEAN DEFAULT FALSE,   
    FOREIGN KEY (SenderUserID) REFERENCES Users(UserID),
    FOREIGN KEY (ReceiverUserID) REFERENCES Users(UserID)
);

CREATE TABLE Feedback (
    FeedbackID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT,
    FeedbackText TEXT,
    DateCreated TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (UserID) REFERENCES Users(UserID)
);

-- Likes, Dislikes, and Knows tables to manage user preferences and knowledge
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

-- UserLikes, UserDislikes, and UserKnows tables to associate preferences and knowledge with users
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

-- Insert initial data into Hostels table
INSERT INTO Hostels (HostelName) VALUES
('Kofi Tawiah'),
('Wangari Mathai'),
('Walter Sisulu'),
('Ephraim-Amu'),
('Oteng Korankye'),
('Hostel 2C'),
('Hostel 2D');

-- Insert initial data into Rooms table
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

-- Insert initial data into Slots table
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
