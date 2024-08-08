<?php
include '../includes/bio_function.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link rel="stylesheet" href="../public/css/bio.css">
    <title>Bio</title>
</head>
<body
    <main class="wrapper">
       <section class="featured-box" id="home">
          <div class="featured-text">
            <div class="featured-text-card">
            <span><?php echo $fullName; ?></span>
            </div>
            <div class="featured-name">
                <p>I'm <span class="typedText"></span></p>
            </div>
            <div class="featured-text-info">
                <p>Experienced frontend developer with a passion for creating visually stunning
                   and user-friendly websites.
                </p>
            </div>
            <div class="featured-text-btn">
                <button class="btn blue-btn">Request As Roomate</button>
            </div>
            <div class="social_icons">
                <div class="icon"><i class="uil uil-instagram"></i></div>
                <div class="icon"><i class="uil uil-linkedin-alt"></i></div>
                <div class="icon"><i class="uil uil-dribbble"></i></div>
                <div class="icon"><i class="uil uil-github-alt"></i></div>
            </div>
          </div>
          <div class="featured-image">
            <div class="image">
            <img src="<?php echo $profileImage; ?>" alt="<?php echo $fullName; ?>">
            </div>
          </div>
          <div class="scroll-icon-box">
            <a href="#about" class="scroll-btn">
                <i class="uil uil-mouse-alt"></i>
                <p>Know more</p>
            </a>
          </div>

       </section>
       <!-- -------------- ABOUT BOX ---------------- -->
       <section class="section" id="about">
          <div class="top-header">
            <h1>About Me</h1>
          </div>
          <div class="row">
            <div class="col">
                <div class="about-info">
                    <h3>My introduction</h3>
                    <p>I am well-versed in HTML, CSS and JavaScript , and other cutting edge
                       frameworks and libraries,which allows me to implement interactive features.
                       Additionally, I have experirence working with content management systems (CMS) like
                       WordPress.
                    </p>
                </div>
            </div>
            <div class="col">
                <div class="skills-box">
                    <div class="skills-header">
                        <h3>Likes</h3>
                    </div>
                    <div class="skills-list">
                        <span>food</span>
                        <span>studying</span>
                        <span>fun</span>
                        <span>book</span>
                        <span>music</span>
                        <span>React</span>
                        <span>Angular</span>
                    </div>
                </div>
                <div class="skills-box">
                    <div class="skills-header">
                        <h3>Dislikes</h3>
                    </div>
                    <div class="skills-list">
                        <span>dirt</span>
                        <span>nosy roomates</span>
                        <span>silence</span>
                        <span>not fun</span>
                    </div>
                </div>
                <div class="skills-box">
                    <div class="skills-header">
                        <h3>Know</h3>
                    </div>
                    <div class="skills-list">
                        <span>I have a girlfriend</span>
                        <span>im barely in the room</span>
                        <span>always availble</span>
                    </div>
                </div>
            </div>
          </div>
       </section>

       <!-- -------------- CONTACT BOX ---------------- -->

       <section class="section" id="contact">
          <div class="top-header">
            <h1>Get in touch</h1>
            <span>Do you want to be my roomate? , Send a request and drop a short reason</span>
          </div>
          <div class="row">
             <div class="col">
                <div class="contact-info">
                    <h2>Find Me <i class="uil uil-corner-right-down"></i></h2>
                    <p><i class="uil uil-envelope"></i> Email: <?php echo $email; ?></p>
                    <p><i class="uil uil-phone"></i> Tel: +250 708 770 000</p>
                    <p><i class="uil uil-message"></i> Class of: 2025</p>
                </div>
             </div>
             <div class="col">
                <div class="form-control">
                    <div class="text-area">
                        <textarea placeholder="Message"></textarea>
                    </div>
                    <div class="form-button">
                        <button class="btn">Send<i class="uil uil-message"></i></button>
                    </div>
                </div>
             </div>
          </div>
       </section>

    </main>
    </div>
    <script src="https://unpkg.com/typed.js@2.0.16/dist/typed.umd.js"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="../public/js/bio.js"></script>
</body>
</html>