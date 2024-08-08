<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="../public/css/admin.css">
	<title>AdminSite</title>
	<style>
		/* High-Level CSS for the Form */
		.form-container {
			background: #fff;
			border-radius: 10px;
			box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
			padding: 20px;
			width: 100%;
			max-width: 600px;
			margin: 50px auto;
		}

		.form-container h2 {
			text-align: center;
			margin-bottom: 20px;
			color: #333;
			font-size: 24px;
		}

		.form-group {
			margin-bottom: 15px;
			display: flex;
			align-items: center;
			justify-content: space-between;
		}

		.form-group label {
			margin-right: 10px;
			color: #555;
			font-weight: bold;
		}

		.form-group select {
			width: 30%;
			padding: 10px;
			border: 1px solid #ccc;
			border-radius: 5px;
			font-size: 16px;
			color: #333;
		}

		.form-group button {
			width: 30%;
			padding: 10px;
			border: none;
			border-radius: 5px;
			background-color: #923d41;
			color: white;
			font-size: 18px;
			cursor: pointer;
		}

		.form-group button:hover {
			background-color: #45a049;
		}
	</style>
</head>
<body>
	
	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand"><i class='bx bxs-smile icon'></i> Roomrover</a>
		<ul class="side-menu">
			<li><a href="admin.php" class="active"><i class='bx bxs-dashboard icon' ></i> Dashboard</a></li>
			<li class="divider" data-text="main">Main</li>
			<!-- <li>
				<a href="#"><i class='bx bxs-inbox icon' ></i> Elements <i class='bx bx-chevron-right icon-right' ></i></a>
			</li>
			<li><a href="#"><i class='bx bxs-chart icon' ></i> Charts</a></li> -->
			<li><a href="#"><i class='bx bxs-widget icon' ></i> Add Room</a></li>
			<li class="divider" data-text="table and forms">Block & Report</li>
			<li><a href="blocked_users.php"><i class='bx bx-table icon' ></i> Block Users</a></li>
			<li>
				<a href="reports.php"><i class='bx bxs-notepad icon' ></i> Reports</a>
			</li>
		</ul>
		<div class="ads">
			<div class="wrapper">
				<a href="#" class="btn-upgrade">Logout</a>
			</div>
		</div>
	</section>
	<!-- SIDEBAR -->

	<!-- NAVBAR -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
			<i class='bx bx-menu toggle-sidebar' ></i>
			<form action="#">
				<div class="form-group">
					<input type="text" placeholder="Search...">
					<i class='bx bx-search icon' ></i>
				</div>
			</form>
			<a href="#" class="nav-link">
				<i class='bx bxs-bell icon' ></i>
				<span class="badge">5</span>
			</a>
			<a href="#" class="nav-link">
				<i class='bx bxs-message-square-dots icon' ></i>
				<span class="badge">8</span>
			</a>
			<span class="divider"></span>
			<div class="profile">
				<img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixid=MnwxMjA3fDB8MHxzZWFyY2h8NHx8cGVvcGxlfGVufDB8fDB8fA%3D%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="">
				<ul class="profile-link">
					<li><a href="#"><i class='bx bxs-user-circle icon' ></i> Profile</a></li>
					<li><a href="#"><i class='bx bxs-cog' ></i> Settings</a></li>
					<li><a href="#"><i class='bx bxs-log-out-circle' ></i> Logout</a></li>
				</ul>
			</div>
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
            <div class="form-container">
                <h2>Hostel and Room Details</h2>
                <form id="hostel-form">
                    <!-- Hostel Select Row -->
                    <div class="form-group">
                        <label for="hostel-select">Hostel:</label>
                        <select id="hostel-select" name="hostel-select" required>
                            <option value="">Select Hostel</option>
                            <option value="hostel1">Hostel 1</option>
                            <option value="hostel2">Hostel 2</option>
                            <option value="hostel3">Hostel 3</option>
                        </select>
                        <select id="hostel-status" name="hostel-status" required>
                            <option value="available">Available</option>
                            <option value="unavailable">Unavailable</option>
                        </select>
                        <button type="submit">Submit</button>
                    </div>
                </form>

                <form id="room-form">
                    <!-- Room Select Row -->
                    <div class="form-group">
                        <label for="hostel-select-room">Hostel:</label>
                        <select id="hostel-select-room" name="hostel-select-room" required>
                            <option value="">Select Hostel</option>
                            <option value="hostel1">Hostel 1</option>
                            <option value="hostel2">Hostel 2</option>
                            <option value="hostel3">Hostel 3</option>
                        </select>
                        <select id="room-select" name="room-select" required>
                            <option value="">Select Room</option>
                            <option value="room1">Room 1</option>
                            <option value="room2">Room 2</option>
                            <option value="room3">Room 3</option>
                        </select>
                        <select id="room-status" name="room-status" required>
                            <option value="available">Available</option>
                            <option value="unavailable">Unavailable</option>
                        </select>
                        <button type="submit">Submit</button>
                    </div>
                </form>
            </div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- NAVBAR -->

	<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
	<script src="../public/js/admin.js"></script>
</body>
</html>
