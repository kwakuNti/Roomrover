<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../config/core.php';
include '../config/connection.php';

if (!isset($_SESSION['UserID'])) {
    die("Error: User is not logged in.");
}

$target_user_id = $_SESSION['UserID'];

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

// Function to retrieve user attributes from the database
function getUserAttributes($conn, $table) {
    $sql = "SELECT UserID, {$table}ID FROM User{$table}s";
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
            $similarityPercentage = round($similarity * 100, 2);
            $similarities[] = ['UserID' => $userID, 'Similarity' => $similarityPercentage];
        }
    }

    usort($similarities, function($a, $b) {
        return $b['Similarity'] <=> $a['Similarity'];
    });

    return $similarities;
}

// Function to get user profile details including bio
function get_user_profile($conn, $userID) {
    $sql = "SELECT UserID, FirstName, LastName, ProfileImage, Bio FROM Users WHERE UserID = ?";
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

// Function to generate roommate suggestions
function generateRoommateSuggestions($conn, $target_user_id) {
    $userLikes = getUserAttributes($conn, 'Like');
    $userDislikes = getUserAttributes($conn, 'Dislike');
    $userKnows = getUserAttributes($conn, 'Know');

    $likesMatrix = createUserAttributeMatrix($userLikes);
    $dislikesMatrix = createUserAttributeMatrix($userDislikes);
    $knowsMatrix = createUserAttributeMatrix($userKnows);

    $combinedMatrix = [];
    $allUsers = array_unique(array_merge(array_keys($likesMatrix), array_keys($dislikesMatrix), array_keys($knowsMatrix)));

    foreach ($allUsers as $userID) {
        $combinedMatrix[$userID] = array_merge(
            $likesMatrix[$userID] ?? [],
            $dislikesMatrix[$userID] ?? [],
            $knowsMatrix[$userID] ?? []
        );
    }

    if (!isset($combinedMatrix[$target_user_id])) {
        return ["error" => "Target user not found in the attribute matrices."];
    }

    $similarUsers = findSimilarUsers($target_user_id, $combinedMatrix);

    $filteredUsers = array_filter($similarUsers, function($pair) {
        return $pair['Similarity'] > 30;
    });

    $similarUsersData = [];

    foreach ($filteredUsers as $pair) {
        $user_profile = get_user_profile($conn, $pair['UserID']);
        $similarity = $pair['Similarity'];

        if (isset($user_profile['error'])) {
            continue;
        }

        $similarUsersData[] = [
            'UserID' => $user_profile['UserID'],
            'FirstName' => $user_profile['FirstName'],
            'LastName' => $user_profile['LastName'],
            'ProfileImage' => $user_profile['ProfileImage'],
            'Bio' => $user_profile['Bio'], // Include the user bio
            'Similarity' => $similarity
        ];
    }

    return $similarUsersData;
}

// Generate roommate suggestions
$suggestions = generateRoommateSuggestions($conn, $target_user_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../public/css/roomates_new.css">
    <title>AdminSite</title>
</head>
<body>
<div class="wrapper">
    <div class="band">
        <h1>SUGGESTED ROOMMATES</h1>
    </div>
    <div id="suggestions-container">
        <?php if (isset($suggestions['error'])): ?>
            <p><?php echo $suggestions['error']; ?></p>
        <?php else: ?>
            <?php foreach ($suggestions as $user): ?>
                <div class="card">
                    <input type="checkbox" id="card<?php echo $user['UserID']; ?>" class="more" aria-hidden="true">
                    <div class="content">
                        <div class="front" style="background-image: url('<?php echo $user['ProfileImage']; ?>');">
                            <div class="inner">
                                <h2><?php echo $user['FirstName'] . ' ' . $user['LastName']; ?></h2>
                                <div class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                                <label for="card<?php echo $user['UserID']; ?>" class="button" aria-hidden="true">
                                    Details
                                </label>
                            </div>
                        </div>
                        <div class="back">
                            <div class="inner">
                                <div class="info">
                                    <span><?php echo $user['Similarity']; ?>%</span>
                                    <div class="icon">
                                        <i class="fas fa-users"></i>
                                        <span>similarity</span>
                                    </div>
                                </div>
                                <div class="description">
                                    <p><?php echo $user['Bio']; ?></p> <!-- Display the user bio here -->
                                </div>
                                <form action="../templates/bio.php?user_id=<?php echo $user['UserID']; ?>" method="POST"> <!-- Add a form for the button -->
                                    <input type="hidden" name="userID" value="<?php echo $user['UserID']; ?>">
                                    <button type="submit" class="button return">Check Bio</button> <!-- "Request as Roommate" button -->
                                </form>
                                <label for="card<?php echo $user['UserID']; ?>" class="button return" aria-hidden="true">
                                    <i class="fas fa-arrow-left"></i> Back
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
