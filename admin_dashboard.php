<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}


if (isset($_SESSION['message'])) {
    echo "<div style='text-align: center; padding: 10px; background: #4CAF50; color: white;'>" . $_SESSION['message'] . "</div>";
    unset($_SESSION['message']);
}

$servername = "localhost"; // Your server
$username = "root"; // Your DB username (default is often 'root')
$password = ""; // Your DB password (leave empty if you're not using a password)
$dbname = "football_tickets"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle adding a new match
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_match'])) {
    $home_team = $conn->real_escape_string($_POST['home_team']);
    $away_team = $conn->real_escape_string($_POST['away_team']);
    $match_date = $conn->real_escape_string($_POST['match_date']);
    $stadium = $conn->real_escape_string($_POST['stadium']); // Add this line
    
    // Updated SQL query to include the stadium field
    $sql = "INSERT INTO matches (home_team, away_team, match_date, stadium) 
            VALUES ('$home_team', '$away_team', '$match_date', '$stadium')";
	            
    if ($conn->query($sql) === TRUE) {
        $message = "New match added successfully!";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle deleting a match
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM matches WHERE id=$id";
    
    if ($conn->query($sql)) {
        $_SESSION['message'] = "Match deleted successfully";
    }
    
    header("Location: admin_dashboard.php");
    exit();
}

// Handle editing a match
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM matches WHERE id=$id");
    $match = $result->fetch_assoc();
    
    // Check if 'stadium' is set in $_POST before accessing it
        if (isset($_POST['stadium'])) {
            $stadium = $conn->real_escape_string($_POST['stadium']);
        } else {
            $stadium = '';  // Set a default value if 'stadium' is not set
        }
    
}

// Also update the edit/update functionality
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_match'])) {
    $id = $_POST['id'];
    $home_team = $conn->real_escape_string($_POST['home_team']);
    $away_team = $conn->real_escape_string($_POST['away_team']);
    $match_date = $conn->real_escape_string($_POST['match_date']);
    $stadium = $conn->real_escape_string($_POST['stadium']); // Add this line

    $sql = "UPDATE matches SET 
            home_team='$home_team', 
            away_team='$away_team', 
            match_date='$match_date',
            stadium='$stadium'  
            WHERE id=$id";
            
    if ($conn->query($sql) === TRUE) {
        $message = "Match updated successfully!";
    } else {
        $message = "Error updating match: " . $conn->error;
    }
}


// Fetch existing matches
$sql = "SELECT * FROM matches";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #004aad;
            color: white;
        }
        .btn {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #218838;
        }
        .message {
            color: green;
        }
        .error {
            color: red;
        }
        .form-container {
            margin-bottom: 30px;
            padding: 20px;
            background: white;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<h2>Admin Dashboard</h2>
<?php if (isset($message)): ?>
    <p class="message"><?php echo $message; ?></p>
<?php endif; ?>

<h3><?php echo isset($match) ? 'Edit Match' : 'Add New Match'; ?></h3>
<div class="form-container">
    <form method="POST" action="">
        <input type="hidden" name="id" value="<?php echo isset($match) ? $match['id'] : ''; ?>">
        <input type="text" name="home_team" placeholder="Home Team" required value="<?php echo isset($match) ? $match['home_team'] : ''; ?>">
        <input type="text" name="away_team" placeholder="Away Team" required value="<?php echo isset($match) ? $match['away_team'] : ''; ?>">
        <input type="date" name="match_date" required value="<?php echo isset($match) ? $match['match_date'] : ''; ?>">
        <input type="text" name="stadium" placeholder="Stadium" required value="<?php echo isset($match) ? $match['stadium'] : ''; ?>">
        <button type="submit" name="<?php echo isset($match) ? 'update_match' : 'add_match'; ?>" class="btn">
            <?php echo isset($match) ? 'Update Match' : 'Add Match'; ?>
        </button>
	</br>
	</br>
	<div class="dashboard-container">
	    <!-- Navigation Buttons -->
	    <div class="admin-nav">
	        <a href="ticket_verification.php" class="btn">Ticket Verification</a>
	    </div>
	</br>
	
    </form>
</div>

<h3>Current Matches</h3>
<table>
    <tr>
        <th>ID</th>
        <th>Home</th>
        <th>Away</th>
        <th>Match Date</th>
        <th>Actions</th>
    </tr>
    <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['home_team']; ?></td>
                <td><?php echo $row['away_team']; ?></td>
                <td><?php echo $row['match_date']; ?></td>
                <td>
                    <a href="?edit=<?php echo $row['id']; ?>" class="btn" style="background-color: #007BFF;">Edit</a>
                    <a href="?delete=<?php echo $row['id']; ?>" class="btn" style="background-color: #dc3545;">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="5">No matches found.</td></tr>
    <?php endif; ?>
</table>

<a href="admin_logout.php" class="btn" style="background-color: #007BFF;">Logout</a>

</body>
</html>



