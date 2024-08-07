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
    UserType VARCHAR(10),
    ProfileImage VARCHAR(255), 
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

-- Preferences table to store different preference options
CREATE TABLE Preferences (
    PreferenceID INT PRIMARY KEY AUTO_INCREMENT,
    PreferenceName VARCHAR(100)
);

-- Insert preferences
INSERT INTO Preferences (PreferenceName) VALUES
('Reading'),
('Music'),
('Sports'),
('Traveling'),
('Cooking'),
('Gaming'),
('Photography'),
('Movies');

-- UserPreferences table to connect users to their preferences
CREATE TABLE UserPreferences (
    UserPreferenceID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT,
    PreferenceID INT,
    FOREIGN KEY (UserID) REFERENCES Users(UserID),
    FOREIGN KEY (PreferenceID) REFERENCES Preferences(PreferenceID)
);
