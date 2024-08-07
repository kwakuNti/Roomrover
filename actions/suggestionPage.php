<?php
// Include the core file for session handling
include '../config/core.php';

// Now we know the user is logged in and we have their UserID
$target_user_id = $_SESSION['UserID'];

// Include the database configuration
include '../config/connection.php';

// Function to calculate cosine similarity between two vectors
function cosineSimilarity($a, $b) {
    $dotProduct = 0;
    $normA = 0;
    $normB = 0;
    for ($i = 0; $i < count($a); $i++) {
        $dotProduct += $a[$i] * $b[$i];
        $normA += $a[$i] * $a[$i];
        $normB += $b[$i] * $b[$i];
    }
    $normA = sqrt($normA);
    $normB = sqrt($normB);
    
    if ($normA == 0 || $normB == 0) {
        return 0;
    }
    
    return $dotProduct / ($normA * $normB);
}

// Function to retrieve user preferences from the database
function getUserPreferences($conn) {
    $sql = "SELECT up.UserID, p.PreferenceID
            FROM UserPreferences up
            JOIN Preferences p ON up.PreferenceID = p.PreferenceID";
    $result = $conn->query($sql);
    
    $userPreferences = [];
    while ($row = $result->fetch_assoc()) {
        $userID = $row['UserID'];
        $preferenceID = $row['PreferenceID'];
        if (!isset($userPreferences[$userID])) {
            $userPreferences[$userID] = [];
        }
        $userPreferences[$userID][] = $preferenceID;
    }
    
    return $userPreferences;
}

// Function to create a matrix of user preferences
function createUserPreferenceMatrix($userPreferences) {
    $allPreferences = [];
    foreach ($userPreferences as $preferences) {
        $allPreferences = array_merge($allPreferences, $preferences);
    }
    $allPreferences = array_unique($allPreferences);
    
    $matrix = [];
    foreach ($userPreferences as $userID => $preferences) {
        $matrix[$userID] = array_fill_keys($allPreferences, 0);
        foreach ($preferences as $pref) {
            $matrix[$userID][$pref] = 1;
        }
    }
    
    return $matrix;
}

// Function to find similar users based on cosine similarity
function findSimilarUsers($targetUserID, $matrix, $limit = 5) {
    $similarities = [];
    $targetVector = $matrix[$targetUserID];
    
    foreach ($matrix as $userID => $vector) {
        if ($userID != $targetUserID) {
            $similarity = cosineSimilarity(array_values($targetVector), array_values($vector));
            // Convert similarity to percentage and round to 2 decimal places
            $similarityPercentage = round($similarity * 100, 2);
            $similarities[] = ['UserID' => $userID, 'Similarity' => $similarityPercentage];
        }
    }

    // Sort similarities in descending order
    usort($similarities, function($a, $b) {
        return $b['Similarity'] <=> $a['Similarity'];
    });

    // Return only the top $limit similar users
    return array_slice($similarities, 0, $limit);
}

// Function to get user profile details
function get_user_profile($userID) {
    global $host, $user, $password, $database;

    $conn = new mysqli($host, $user, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT UserID, FirstName, LastName, DateOfBirth, Gender, Email, PhoneNumber, UserType, ProfileImage, DisabilityStatus 
            FROM Users WHERE UserID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user_profile = $result->fetch_assoc();
    } else {
        $user_profile = ["error" => "User not found"];
    }

    $stmt->close();
    $conn->close();

    return $user_profile;
}

// Set the number of similar users you want to return
$number_of_similar_users = 3; // Change this to get more or fewer results

// Database connection
$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user preferences from the database
$userPreferences = getUserPreferences($conn);

// Create the user-preference matrix
$matrix = createUserPreferenceMatrix($userPreferences);

// Find similar users
$similarUsers = findSimilarUsers($target_user_id, $matrix, $number_of_similar_users);

$conn->close();

// Output similar users
echo "<h1>Top {$number_of_similar_users} Similar Users for User {$target_user_id}</h1>";

foreach ($similarUsers as $pair) {
    $user_profile = get_user_profile($pair['UserID']);
    $similarity = $pair['Similarity'];

    if (isset($user_profile['error'])) {
        continue;
    }

    echo "<div class='pairing'>";
    echo "<p>User: {$user_profile['FirstName']} {$user_profile['LastName']} (UserID: {$user_profile['UserID']})</p>";
    echo "<p>Similarity: {$similarity}%</p>";
    echo "</div><hr>";
}
?>