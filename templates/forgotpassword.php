<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/login.css">
    <link rel="stylesheet" href="../public/css/snackbar.css">
    <script src="../public/js/snackbar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Forgot Password | Ludiflex</title>
</head>
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
<body>
    <div class="login-box">
        <div class="login-header">
            <header>Forgot Password</header>
        </div>
        <form id="forgotPasswordForm" action="../actions/forgot_password.php" method="POST">
            <div class="input-box">
                <input type="email" class="input-field" name="email" placeholder="Enter your email" autocomplete="off" required>
            </div>
            <div class="input-submit">
                <button class="submit-btn" id="submit" type="submit">Send Password</button>
            </div>
        </form>
    </div>
</body>
</html>
