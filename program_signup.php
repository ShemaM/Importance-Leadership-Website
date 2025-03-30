<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "secret";
$database = "importanceleadership";

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define valid programs
$validPrograms = [
    'Leadership Development' => 'Build essential leadership skills',
    'Mentorship Program' => 'Get guidance from experienced mentors',
    'Community Impact' => 'Drive change in your community'
];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $country = trim($_POST['country']);
    $city = trim($_POST['city']);
    $education = trim($_POST['education']);
    $organization = trim($_POST['organization']);
    $job_title = trim($_POST['job_title']);
    $program = $_POST['program'];
    $goals = trim($_POST['goals']);
    $motivation = trim($_POST['motivation']);

    // Validate selected program
    if (!array_key_exists($program, $validPrograms)) {
        die("Invalid program selected.");
    }

    // Prepare SQL statement
    $sql = "INSERT INTO participants (name, email, phone, gender, dob, country, city, education, organization, job_title, program, goals, motivation) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("SQL Error: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("sssssssssssss", $name, $email, $phone, $gender, $dob, $country, $city, $education, $organization, $job_title, $program, $goals, $motivation);

    // Execute and confirm
    if ($stmt->execute()) {
        echo "<script>alert('Registration successful!; success.html'); window.location.href='index.html';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Program Signup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-weight: bold !important;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
            background-image: url('image/homepage-bg.jpg');
            background-attachment: fixed;
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
        }
        .container {
            max-width: 800px;
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            background-color: #ffff;
            font-weight: bold;
        }
        .btn-custom {
            background-color: #218838;
            color: white;
            font-size: 18px;
            padding: 12px;
            width: 100%;
            border-radius: 6px;
            transition: background 0.3s ease;
        }
        .btn-custom:hover {
            background-color: #1e7e34;
        }
    </style>
</head>
<body>
  <!-- Load Header -->
    
  <div id="header-container"></div>
    <script src="loadHeader.js"></script>

<div class="container">
    <h2 class="text-center text-primary mb-4">Join A Program Today</h2>
    <form method="POST" action="">
        <div class="row">
            <div class="col-md-6">
                <label class="form-label">Name:</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <label class="form-label">Phone:</label>
                <input type="text" name="phone" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Gender:</label>
                <select name="gender" class="form-select" required>
                    <option value="">Select...</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <label class="form-label">Date of Birth:</label>
                <input type="date" name="dob" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Country:</label>
                <input type="text" name="country" class="form-control" required>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <label class="form-label">City:</label>
                <input type="text" name="city" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Education Level:</label>
                <input type="text" name="education" class="form-control" required>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <label class="form-label">Organization:</label>
                <input type="text" name="organization" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Job Title:</label>
                <input type="text" name="job_title" class="form-control">
            </div>
        </div>

        <div class="mt-3">
            <label class="form-label">Program:</label>
            <select name="program" class="form-select" required>
                <option value="">Select a Program...</option>
                <?php foreach ($validPrograms as $key => $value) { ?>
                    <option value="<?php echo htmlspecialchars($key); ?>"><?php echo htmlspecialchars($key); ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="mt-3">
            <label class="form-label">Goals:</label>
            <textarea name="goals" class="form-control" rows="3" required></textarea>
        </div>

        <div class="mt-3">
            <label class="form-label">Motivation:</label>
            <textarea name="motivation" class="form-control" rows="3" required></textarea>
        </div>

        <button type="submit" class="btn btn-custom fw-bold fs-30">Submit</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
