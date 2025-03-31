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

$programMap = [
    'Leadership' => [
        'table' => 'leadership_participants',
        'display' => 'Leadership Development Program',
        'redirect' => 'leadershipDevelopment.html'
    ],
    'Mentorship' => [
        'table' => 'mentorship_participants',
        'display' => 'Professional Mentorship Initiative',
        'redirect' => 'mentorshipProgram.html'
    ],
    'Community Impact' => [
        'table' => 'community_impact_participants',
        'display' => 'Community Impact Fellowship',
        'redirect' => 'communityImpact.html'
    ]
];

$educationLevels = [
    'high-school' => ['display' => 'High School Graduate'],
    'undergraduate' => ['display' => 'Undergraduate'],
    'masters' => ['display' => 'Masters'],
    'doctoral' => ['display' => 'Doctoral']
];


// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ... [previous program validation code]

    // Normalize email
    $email = strtolower(trim($_POST['email']));
    
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>
            alert('Invalid email format. Please enter a valid email.');
            window.history.back();
        </script>";
        exit();
    }
    $program = $_POST['program'] ?? '';
    if (!array_key_exists($program, $programMap)) {
        die("Invalid program selected.");
    }
    $targetTable = $programMap[$program]['table'];

    $checkStmt = $conn->prepare("SELECT id FROM $targetTable WHERE email = ?");
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        echo "<script>
            alert('This email is already registered for this program.');
            window.history.back();
        </script>";
        exit();
    }

    // Handle database errors
    try {
        // Ensure $stmt is initialized before execution
        $stmt = $conn->prepare("INSERT INTO $targetTable (name, email, phone, gender, dob, country, city, education, organization, job_title, program, goals, motivation, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("sssssssssssss", 
            $name, $email, $phone, $gender, $dob, $country, $city, 
            $education, $organization, $job_title, $program, $goals, $motivation
        );
        $stmt->execute();
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() === 1062) {
            echo "<script>
                alert('This email is already registered.');
                window.history.back();
            </script>";
        } else {
            error_log("Database error: " . $e->getMessage());
            echo "An error occurred. Please try again later.";
        }
        exit();
    }
}



// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate selected program first
    $program = $_POST['program'] ?? '';
    if (!array_key_exists($program, $programMap)) {
        die("Invalid program selected.");
    }

    // Get the target table from the program map
    $targetTable = $programMap[$program]['table'];

    // Sanitize inputs
    $name = trim($conn->real_escape_string($_POST['name']));
    $email = trim($conn->real_escape_string($_POST['email']));
    $phone = trim($conn->real_escape_string($_POST['phone']));
    $gender = $conn->real_escape_string($_POST['gender']);
    $dob = $conn->real_escape_string($_POST['dob']);
    $country = trim($conn->real_escape_string($_POST['country']));
    $city = trim($conn->real_escape_string($_POST['city']));
    $education = trim($conn->real_escape_string($_POST['education']));
    $organization = trim($conn->real_escape_string($_POST['organization']));
    $job_title = trim($conn->real_escape_string($_POST['job_title']));
    $goals = trim($conn->real_escape_string($_POST['goals']));
    $motivation = trim($conn->real_escape_string($_POST['motivation']));

    // Prepare SQL statement for dynamic table
    $sql = "INSERT INTO $targetTable 
            (name, email, phone, gender, dob, country, city, education, organization, job_title, program, goals, motivation, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        die("SQL Error: " . $conn->error);
    }

    // Bind parameters (13 parameters + created_at is handled by NOW())
    $stmt->bind_param("sssssssssssss", 
        $name, $email, $phone, $gender, $dob, $country, $city, 
        $education, $organization, $job_title, $program, $goals, $motivation
    );

   // Execute and handle result
if ($stmt->execute()) {
    // Get redirect URL from program map
    $redirectUrl = 'index.html'; // Default fallback
    
    if (isset($programMap[$program]['redirect'])) {
        $redirectUrl = $programMap[$program]['redirect'];
    }

    echo "<script>
        alert('Registration successful!');
        window.location.href = '$redirectUrl';
    </script>";
}
    else {
        error_log("Database error: " . $stmt->error);
        echo "<script>
            alert('Registration failed. Please try again.');
            window.history.back();
        </script>";
    }

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
            
            <!--education level dropdown-->
            <div class="mt-3">
    <label class="form-label">Education Level:</label>
    <select name="education" class="form-select" required>
        <option value="">Select education level...</option>
        <?php foreach ($educationLevels as $levelId => $levelData) { ?>
            <option value="<?= htmlspecialchars($levelId) ?>">
                <?= htmlspecialchars($levelData['display']) ?>
            </option>
        <?php } ?>
    </select>
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
        <?php foreach ($programMap as $programId => $programData) { ?>
            <option value="<?= htmlspecialchars($programId) ?>">
                <?= htmlspecialchars($programData['display']) ?>
            </option>
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
