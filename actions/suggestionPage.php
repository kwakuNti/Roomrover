<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the core file for session handling
include '../config/core.php';

// Check if user is logged in and session user ID is set
if (!isset($_SESSION['UserID'])) {
    die("Error: User is not logged in.");
}

// Get the target user ID from the session
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

// Function to retrieve user likes, dislikes, and knows from the database
function getUserAttributes($conn, $table) {
    $sql = "SELECT UserID, {$table}ID FROM User{$table}s"; // Add 's' to match the table names
    $result = $conn->query($sql);
    
    $userAttributes = [];
    while ($row = $result->fetch_assoc()) {
        $userID = $row['UserID'];
        $attributeID = $row["{$table}ID"];
        if (!isset($userAttributes[$userID])) {
            $userAttributes[$userID] = [];
        }
        $userAttributes[$userID][] = $attributeID;
    }
    
    return $userAttributes;
}

// Function to create a matrix of user attributes
function createUserAttributeMatrix($userAttributes) {
    $allAttributes = [];
    foreach ($userAttributes as $attributes) {
        $allAttributes = array_merge($allAttributes, $attributes);
    }
    $allAttributes = array_unique($allAttributes);
    
    $matrix = [];
    foreach ($userAttributes as $userID => $attributes) {
        $matrix[$userID] = array_fill_keys($allAttributes, 0);
        foreach ($attributes as $attr) {
            $matrix[$userID][$attr] = 1;
        }
    }
    
    return $matrix;
}

// Function to find similar users based on cosine similarity
function findSimilarUsers($targetUserID, $matrix) {
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

    return $similarities;
}

// Function to get user profile details
function get_user_profile($conn, $userID) {
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

    return $user_profile;
}

// Database connection
$conn = new mysqli($db_server, $db_user, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user attributes from the database
$userLikes = getUserAttributes($conn, 'Like');
$userDislikes = getUserAttributes($conn, 'Dislike');
$userKnows = getUserAttributes($conn, 'Know');

// Debug: Print out the retrieved attributes
echo "<h2>Debug Information:</h2>";
echo "<pre>";
echo "User Likes:\n";
print_r($userLikes);
echo "\nUser Dislikes:\n";
print_r($userDislikes);
echo "\nUser Knows:\n";
print_r($userKnows);
echo "</pre>";

// Create the user-attribute matrices
$likesMatrix = createUserAttributeMatrix($userLikes);
$dislikesMatrix = createUserAttributeMatrix($userDislikes);
$knowsMatrix = createUserAttributeMatrix($userKnows);

// Merge matrices to create a combined attribute matrix
$combinedMatrix = [];
$allUsers = array_unique(array_merge(array_keys($likesMatrix), array_keys($dislikesMatrix), array_keys($knowsMatrix)));

foreach ($allUsers as $userID) {
    $combinedMatrix[$userID] = array_merge(
        $likesMatrix[$userID] ?? [],
        $dislikesMatrix[$userID] ?? [],
        $knowsMatrix[$userID] ?? []
    );
}

// Debug: Print out the combined matrix
echo "<h2>Combined Matrix:</h2>";
echo "<pre>";
print_r($combinedMatrix);
echo "</pre>";

// Check if the target user exists in the combined matrix
if (!isset($combinedMatrix[$target_user_id])) {
    die("Error: Target user not found in the attribute matrices.");
}

// Output the target user vector for debugging
echo "<h2>Target User Vector:</h2>";
echo "<pre>";
print_r($combinedMatrix[$target_user_id]);
echo "</pre>";

// Find similar users
$similarUsers = findSimilarUsers($target_user_id, $combinedMatrix);

// Output similar users
echo "<h1>Similar Users for User {$target_user_id}</h1>";
foreach ($similarUsers as $pair) {
    $user_profile = get_user_profile($conn, $pair['UserID']);
    $similarity = $pair['Similarity'];

    if (isset($user_profile['error'])) {
        continue;
    }

    echo "<div class='pairing'>";
    echo "<p>User: {$user_profile['FirstName']} {$user_profile['LastName']} (UserID: {$user_profile['UserID']})</p>";
    echo "<p>Similarity: {$similarity}%</p>";
    echo "</div><hr>";
}

// Test cosine similarity calculation with known vectors
$vectorA = $combinedMatrix[$target_user_id];
$testUserID = 1; // Example user ID to test similarity with
$vectorB = $combinedMatrix[$testUserID] ?? [];

$testSimilarity = cosineSimilarity(array_values($vectorA), array_values($vectorB));
echo "<h2>Cosine Similarity Test:</h2>";
echo "Similarity between User {$target_user_id} and User {$testUserID}: " . ($testSimilarity * 100) . "%";

$conn->close();
?>
