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

CREATE TABLE Rooms (
    RoomID INT PRIMARY KEY AUTO_INCREMENT,
    RoomNumber VARCHAR(10),
    Building VARCHAR(50),
    Capacity INT,
    AvailableSlots INT,
    RoomImage VARCHAR(255)
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
