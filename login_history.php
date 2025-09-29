<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Start session
session_start();

// Include database connection
require_once('database.php');

// Debug: Log initial session state
error_log("Initial session state: " . print_r($_SESSION, true));

// If already logged in, redirect to purchase history
if (isset($_SESSION['user_id'])) {
    header("Location: purchase_history.php");
    exit();
}

$error_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Debug: Log POST data
    error_log("POST data received: " . print_r($_POST, true));
    
    // Get user input with trimming
    $username = trim($_POST['user_name']);
    $password = $_POST['password'];
    
    // Debug: Log login attempt
    error_log("Login attempt for username: " . $username);
    
    // Get the most recent account for this username
    $sql = "SELECT id, username, password, email, role FROM users 
            WHERE username = ? 
            ORDER BY created_at DESC 
            LIMIT 1";
            
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        error_log("Prepare failed: " . $conn->error);
        die("Database error");
    }
    
    $stmt->bind_param("s", $username);
    
    if (!$stmt->execute()) {
        error_log("Execute failed: " . $stmt->error);
        die("Database error");
    }
    
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $login_successful = false;
        
        // Debug: Log password check
        error_log("Checking password for user ID: " . $user['id']);
        error_log("Stored password hash/value: " . substr($user['password'], 0, 10) . "...");
        
        // Check if password is bcrypt hashed
        if (strlen($user['password']) > 20 && strpos($user['password'], '$2y$10$') === 0) {
            if (password_verify($password, $user['password'])) {
                $login_successful = true;
                error_log("Bcrypt password verified successfully");
            } else {
                error_log("Bcrypt password verification failed");
            }
        } else {
            // Plain password comparison
            if ($password === $user['password']) {
                $login_successful = true;
                error_log("Plain password matched successfully");
            } else {
                error_log("Plain password match failed");
            }
        }
        
        if ($login_successful) {
            // Set all necessary session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['user_email'] = $user['email'];
            
            // Debug: Log successful login
            error_log("Login successful. Session data: " . print_r($_SESSION, true));
            
            header("Location: purchase_history.php");
            exit();
        } else {
            $error_message = "Invalid password!";
        }
    } else {
        $error_message = "Username not found!";
        error_log("No user found with username: " . $username);
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Purchase History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #001f3f;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: #fff;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
            width: 350px;
            text-align: center;
        }

        h1 {
            color: #e91e63;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        label {
            display: block;
            font-size: 14px;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #e91e63;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #d81b60;
        }

        .error-message {
            color: red;
            margin-bottom: 15px;
        }

        .signup-link {
            text-align: center;
            margin-top: 15px;
        }

        .signup-link a {
            color: #e91e63;
            text-decoration: none;
            font-weight: bold;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Login to View Purchase History</h1>

        <?php if (!empty($error_message)): ?>
            <p class="error-message"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="user_name">Username:</label>
                <input type="text" name="user_name" id="user_name" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <button type="submit">Log In</button>
        </form>

        <div class="signup-link">
            <p>Don't have an account? <a href="register.php">Sign up here</a><br>
            or <a href="index.php">Back to Home</a></p>
        </div>
    </div>
</body>
</html>


