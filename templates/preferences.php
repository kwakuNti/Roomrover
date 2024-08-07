<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Preference Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
    <link rel="stylesheet" href="../public/css/preferences.css">
    <link rel="stylesheet" href="../public/css/snackbar.css">
</head>
<body>
<?php if (isset($_GET['msg'])): ?>
        <div id="snackbar"><?php echo htmlspecialchars($_GET['msg']); ?></div>
        <script>
            window.onload = function() {
                var snackbar = document.getElementById('snackbar');
                snackbar.className = "show";
                setTimeout(function(){ snackbar.className = snackbar.className.replace("show", ""); }, 3000);
            };
        </script>
    <?php endif; ?>
    <nav class="container-fluid">
        <ul>
            <li><strong>Preferences</strong></li>
        </ul>
    </nav>
    <main class="container">
        <div id="likesSection" class="section active">
            <h2>Likes</h2>
            <div class="cards">
                <div class="card" data-preference-id="1" onclick="toggleSelection(this)">Reading</div>
                <div class="card" data-preference-id="2" onclick="toggleSelection(this)">Music</div>
                <div class="card" data-preference-id="3" onclick="toggleSelection(this)">Sports</div>
                <div class="card" data-preference-id="4" onclick="toggleSelection(this)">Traveling</div>
                <div class="card" data-preference-id="5" onclick="toggleSelection(this)">Cooking</div>
                <div class="card" data-preference-id="6" onclick="toggleSelection(this)">Gaming</div>
                <div class="card" data-preference-id="7" onclick="toggleSelection(this)">Photography</div>
                <div class="card" data-preference-id="8" onclick="toggleSelection(this)">Movies</div>
            </div>
        </div>
        <div id="dislikesSection" class="section">
            <h2>Dislikes</h2>
            <div class="cards">
                <div class="card" data-preference-id="1" onclick="toggleSelection(this)">Noise</div>
                <div class="card" data-preference-id="2" onclick="toggleSelection(this)">Crowds</div>
                <div class="card" data-preference-id="3" onclick="toggleSelection(this)">Cold weather</div>
                <div class="card" data-preference-id="4" onclick="toggleSelection(this)">Traffic</div>
                <div class="card" data-preference-id="5" onclick="toggleSelection(this)">Waiting</div>
                <div class="card" data-preference-id="6" onclick="toggleSelection(this)">Spam</div>
                <div class="card" data-preference-id="7" onclick="toggleSelection(this)">Bugs</div>
                <div class="card" data-preference-id="8" onclick="toggleSelection(this)">Heat</div>
            </div>
        </div>
        <div id="knowsSection" class="section">
            <h2>Knows</h2>
            <div class="cards">
                <div class="card" data-preference-id="1" onclick="toggleSelection(this)">JavaScript</div>
                <div class="card" data-preference-id="2" onclick="toggleSelection(this)">Python</div>
                <div class="card" data-preference-id="3" onclick="toggleSelection(this)">HTML & CSS</div>
                <div class="card" data-preference-id="4" onclick="toggleSelection(this)">Flutter</div>
                <div class="card" data-preference-id="5" onclick="toggleSelection(this)">React</div>
                <div class="card" data-preference-id="6" onclick="toggleSelection(this)">Dart</div>
                <div class="card" data-preference-id="7" onclick="toggleSelection(this)">SQL</div>
                <div class="card" data-preference-id="8" onclick="toggleSelection(this)">Node.js</div>
            </div>
        </div>
    </main>
    <div class="navigation">
        <div id="likesButton" class="toggle-circle"></div>
        <div id="dislikesButton" class="toggle-circle"></div>
        <div id="knowsButton" class="toggle-circle"></div>
        <div id="doneButton" class="hidden">Done</div>
    </div>
    <script src="../public/js/preferences.js"></script>
</body>
</html>
