<?php

// Database configuration
$dbHost = 'localhost'; // Database host
$dbUsername = 'username'; // Database username
$dbPassword = 'password'; // Database password
$dbName = 'hospital_db'; // Database name

// Connect to MySQL database
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize input data
function sanitize($data) {
    global $conn;
    return mysqli_real_escape_string($conn, htmlspecialchars(trim($data)));
}

// Signup form handling
if (isset($_POST['signup'])) {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password for security
    
    // Insert user data into database
    $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
    if ($conn->query($sql) === TRUE) {
        echo "Signup successful";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Login form handling
if (isset($_POST['login'])) {
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];
    
    // Retrieve user data from database
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            echo "Login successful";
        } else {
            echo "Invalid password";
        }
    } else {
        echo "User not found";
    }
}

// Booking form handling
if (isset($_POST['book'])) {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $phone = sanitize($_POST['phone']);
    $date = sanitize($_POST['date']);
    $time = sanitize($_POST['time']);
    $opd = sanitize($_POST['opd']);
    $message = sanitize($_POST['message']);
    
    // Insert booking data into database
    $sql = "INSERT INTO appointments (name, email, phone, date, time, opd, message) VALUES ('$name', '$email', '$phone', '$date', '$time', '$opd', '$message')";
    if ($conn->query($sql) === TRUE) {
        echo "Booking successful";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close database connection
$conn->close();

?>
