<?php

// After successful signup:
$_SESSION['signup_success'] = true;
$_SESSION['user_id'] = $newUserId; // From your registration logic
header("Location: signUpSuccess.html");

$servername = "localhost"; // Replace with your server name
$username = "root"; // Replace with your database username
$password = "secret"; // Replace with your database password
$dbname = "importanceleadership"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$role = $firstname = $lastname = $email = $password = $profession = $expertise = $interests = $goals = "";
$errors = [];

// Form submission handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Validate and sanitize input
  $role = htmlspecialchars(trim($_POST["role"]));
  $firstname = htmlspecialchars(trim($_POST["firstname"]));
  $lastname = htmlspecialchars(trim($_POST["lastname"]));
  $email = htmlspecialchars(trim($_POST["email"]));
  $password = htmlspecialchars(trim($_POST["password"]));
  $profession = htmlspecialchars(trim($_POST["profession"]));
  $expertise = htmlspecialchars(trim($_POST["expertise"]));
  $interests = htmlspecialchars(trim($_POST["interests"]));
  $goals = htmlspecialchars(trim($_POST["goals"]));

  // Validation
  if (empty($role)) {
    $errors[] = "Role is required.";
  }
  if (empty($firstname)) {
    $errors[] = "First name is required.";
  }
  if (empty($lastname)) {
    $errors[] = "Last name is required.";
  }
  if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Valid email is required.";
  }
  if (empty($password) || strlen($password) < 8) {
    $errors[] = "Password must be at least 8 characters long.";
  }
  if ($role === "mentor" && (empty($profession) || empty($expertise))) {
    $errors[] = "Profession and expertise are required for mentors.";
  }
  if ($role === "mentee" && (empty($interests) || empty($goals))) {
    $errors[] = "Interests and goals are required for mentees.";
  }

  // If no errors, insert data into the appropriate table
  if (empty($errors)) {
    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    if ($role === "mentor") {
      // Insert into mentors table
      $stmt = $conn->prepare("INSERT INTO mentors (firstname, lastname, email, password, profession, expertise) VALUES (?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("ssssss", $firstname, $lastname, $email, $hashed_password, $profession, $expertise);
    } elseif ($role === "mentee") {
      // Insert into mentees table
      $stmt = $conn->prepare("INSERT INTO mentees (firstname, lastname, email, password, interests, goals) VALUES (?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("ssssss", $firstname, $lastname, $email, $hashed_password, $interests, $goals);
    }

    // Execute the statement
    if ($stmt->execute()) {
      // Close the statement
      $stmt->close();
      // Redirect to success page
      header("Location: signupSuccess.html");
      exit();
    } else {
      // Close the statement
      $stmt->close();
      // After successful signup:
      $_SESSION['signup_success'] = true;
      $_SESSION['user_id'] = $conn->insert_id; // Store the last inserted ID
      header("Location: signUpSuccess.html");
      exit();
    }
  }

  // Close the connection
  $conn->close();
}
?>