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

-- Update the Rooms table to reference Hostels instead of Building
CREATE TABLE Rooms (
    RoomID INT PRIMARY KEY AUTO_INCREMENT,
    HostelID INT,
    RoomNumber VARCHAR(10),
    Capacity INT,
    AvailableSlots INT,
    RoomImage VARCHAR(255),
    FOREIGN KEY (HostelID) REFERENCES Hostels(HostelID)
);

CREATE TABLE Bookings (
    BookingID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT,
    RoomID INT,
    BookingDate DATE,
    FOREIGN KEY (UserID) REFERENCES Users(UserID),
    FOREIGN KEY (RoomID) REFERENCES Rooms(RoomID)
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
INSERT INTO Rooms (HostelID, RoomNumber, Capacity, AvailableSlots, RoomImage) VALUES
(1, '101', 4, 2, 'images/room101.jpg'),
(1, '102', 4, 4, 'images/room102.jpg'),
(1, '103', 2, 1, 'images/room103.jpg'),
(2, '201', 3, 3, 'images/room201.jpg'),
(2, '202', 4, 3, 'images/room202.jpg'),
(2, '203', 2, 2, 'images/room203.jpg'),
(3, '301', 5, 1, 'images/room301.jpg'),
(3, '302', 3, 0, 'images/room302.jpg'),
(3, '303', 2, 1, 'images/room303.jpg'),
(4, '401', 6, 4, 'images/room401.jpg'),
(4, '402', 4, 2, 'images/room402.jpg'),
(4, '403', 3, 1, 'images/room403.jpg');
