<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../public/css/profile_setup.css">
    <link rel="stylesheet" href="../public/css/snackbar.css">

    <title>Profile Setup</title>
    <script>
        function showSnackbar(message) {
            var snackbar = document.getElementById('snackbar');
            snackbar.innerHTML = message;
            snackbar.className = "show";
            setTimeout(function() { snackbar.className = snackbar.className.replace("show", ""); }, 3000);
        }

        function validateForm() {
            var firstName = document.forms["profileForm"]["FirstName"].value;
            var lastName = document.forms["profileForm"]["LastName"].value;
            var dateOfBirth = document.forms["profileForm"]["DateOfBirth"].value;
            var gender = document.forms["profileForm"]["Gender"].value;
            var phoneNumber = document.forms["profileForm"]["PhoneNumber"].value;
            var imageUpload = document.forms["profileForm"]["imageUpload"].value;

            if (firstName == "" || lastName == "" || dateOfBirth == "" || gender == "" || phoneNumber == "") {
                showSnackbar("All fields must be filled out before you can continue.");
                return false;
            }

            if (imageUpload == "") {
                showSnackbar("Please upload a profile image before continuing.");
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
    <div id="snackbar"></div>

    <div class="wrapper">
        <!----------------------------- Profile Setup Form ----------------------------->
        <div class="form-box">
            <div class="profile-setup-container">
                <div class="top">
                    <header>Profile Setup</header>
                </div>
                <form name="profileForm" action="../actions/profile_setup.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                    <div class="avatar-upload">
                        <div class="avatar-edit">
                            <input type="file" id="imageUpload" name="imageUpload" accept=".png, .jpg, .jpeg" />
                            <label for="imageUpload"></label>
                        </div>
                        <div class="avatar-preview">
                            <div id="imagePreview" style="background-image: url('default-avatar.png');"></div>
                        </div>
                    </div>
                    <div class="input-box">
                        <input type="text" class="input-field" placeholder="Firstname" name="FirstName" required>
                        <i class="bx bx-user"></i>
                    </div>
                    <div class="input-box">
                        <input type="text" class="input-field" placeholder="Lastname" name="LastName" required>
                        <i class="bx bx-user"></i>
                    </div>
                    <div class="input-box">
                        <input type="date" class="input-field" placeholder="Date of Birth" name="DateOfBirth" required>
                        <i class="bx bx-calendar"></i>
                    </div>
                    <div class="input-box">
                        <select class="input-field" name="Gender" required>
                            <option value="" disabled selected>Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                        <i class="bx bx-user"></i>
                    </div>
                    <div class="input-box">
                        <input type="text" class="input-field" placeholder="Phone Number" name="PhoneNumber" required pattern="\d{10,15}" title="Phone number must be between 10 and 15 digits">
                        <i class="bx bx-phone"></i>
                    </div>
                    <div class="input-box checkbox">
                        <input type="checkbox" id="disabilityStatus" name="DisabilityStatus">
                        <label for="disabilityStatus">Disability Status</label>
                    </div>
                    <div class="input-box">
                        <input type="submit" class="submit" value="Save">
                    </div>
                </form>
            </div>
        </div>
    </div>   
</body>
</html>
