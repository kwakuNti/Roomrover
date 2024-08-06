import mysql.connector
import numpy as np
import json
from scipy.spatial.distance import cosine

# Database connection
db = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="room_rover"
)

# Retrieve user preferences
cursor = db.cursor()
cursor.execute("""
    SELECT up.UserID, p.PreferenceID
    FROM UserPreferences up
    JOIN Preferences p ON up.PreferenceID = p.PreferenceID;
""")
preferences = cursor.fetchall()

# Close the database connection
cursor.close()
db.close()

# Process the data
user_preferences = {}
for user_id, preference_id in preferences:
    if user_id not in user_preferences:
        user_preferences[user_id] = []
    user_preferences[user_id].append(preference_id)

# Create a list of all users and preferences
all_users = list(user_preferences.keys())
all_preferences = list({pref for prefs in user_preferences.values() for pref in prefs})

# Create a user-preference matrix
user_pref_matrix = np.zeros((len(all_users), len(all_preferences)))

for i, user_id in enumerate(all_users):
    for j, pref_id in enumerate(all_preferences):
        if pref_id in user_preferences[user_id]:
            user_pref_matrix[i, j] = 1

# Compute cosine similarities
similarities = []
for i in range(len(all_users)):
    for j in range(i + 1, len(all_users)):
        similarity = 1 - cosine(user_pref_matrix[i], user_pref_matrix[j])
        if similarity >= 0.3:
            similarities.append((all_users[i], all_users[j], similarity))

# Convert the result to JSON
result = [{"UserID1": pair[0], "UserID2": pair[1], "Similarity": pair[2]} for pair in similarities]
json_result = json.dumps(result)

# Output the JSON result
print(json_result)
