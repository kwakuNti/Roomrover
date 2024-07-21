DROP DATABASE IF EXISTS room_rover;
CREATE DATABASE room_rover;
USE room_rover;

CREATE TABLE Users (
    UserID INT PRIMARY KEY AUTO_INCREMENT,
    FirstName VARCHAR(50),
    LastName VARCHAR(50),
    DateOfBirth DATE,
    Gender VARCHAR(10),
    Email VARCHAR(100) UNIQUE,
    PhoneNumber VARCHAR(15),
    Password VARCHAR(255),
    UserType VARCHAR(10),
    ProfileImage VARCHAR(255), -- or BLOB depending on storage choice
    DisabilityStatus BOOLEAN
);

CREATE TABLE Rooms (
    RoomID INT PRIMARY KEY AUTO_INCREMENT,
    RoomNumber VARCHAR(10),
    Building VARCHAR(50),
    Capacity INT,
    AvailableSlots INT
);

CREATE TABLE Bookings (
    BookingID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT,
    RoomID INT,
    BookingDate DATE,
    CheckInDate DATE,
    CheckOutDate DATE,
    FOREIGN KEY (UserID) REFERENCES Users(UserID),
    FOREIGN KEY (RoomID) REFERENCES Rooms(RoomID)
);

CREATE TABLE Questionnaires (
    QuestionnaireID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT,
    Interests TEXT,
    StudyHabits TEXT,
    SleepPatterns TEXT,
    OtherCriteria TEXT,
    FOREIGN KEY (UserID) REFERENCES Users(UserID)
);

CREATE TABLE Pairings (
    PairingID INT PRIMARY KEY AUTO_INCREMENT,
    UserID1 INT,
    UserID2 INT,
    CompatibilityScore DECIMAL(5,2),
    FOREIGN KEY (UserID1) REFERENCES Users(UserID),
    FOREIGN KEY (UserID2) REFERENCES Users(UserID)
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
