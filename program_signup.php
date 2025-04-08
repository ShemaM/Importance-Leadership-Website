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
        'display' => 'Leadership Development Program',
        'redirect' => 'leadershipDevelopment.html'
    ],
    'Mentorship' => [
        'display' => 'Professional Mentorship Initiative',
        'redirect' => 'mentorshipProgram.html'
    ],
    'Community Impact' => [
        'display' => 'Community Impact Fellowship',
        'redirect' => 'communityImpact.html'
    ]
];

$educationLevels = [
    'high-school' => 'High School Graduate',
    'undergraduate' => 'Undergraduate',
    'masters' => 'Masters',
    'doctoral' => 'Doctoral'
];

$countries = [
    'AF' => 'Afghanistan',
    'AL' => 'Albania',
    'DZ' => 'Algeria',
    'AS' => 'American Samoa',
    'AD' => 'Andorra',
    'AO' => 'Angola',
    'AI' => 'Anguilla',
    'AQ' => 'Antarctica',
    'AG' => 'Antigua and Barbuda',
    'AR' => 'Argentina',
    'AM' => 'Armenia',
    'AW' => 'Aruba',
    'AU' => 'Australia',
    'AT' => 'Austria',
    'AZ' => 'Azerbaijan',
    'BS' => 'Bahamas',
    'BH' => 'Bahrain',
    'BD' => 'Bangladesh',
    'BB' => 'Barbados',
    'BY' => 'Belarus',
    'BE' => 'Belgium',
    'BZ' => 'Belize',
    'BJ' => 'Benin',
    'BM' => 'Bermuda',
    'BT' => 'Bhutan',
    'BO' => 'Bolivia',
    'BA' => 'Bosnia and Herzegovina',
    'BW' => 'Botswana',
    'BV' => 'Bouvet Island',
    'BR' => 'Brazil',
    'IO' => 'British Indian Ocean Territory',
    'BN' => 'Brunei Darussalam',
    'BG' => 'Bulgaria',
    'BF' => 'Burkina Faso',
    'BI' => 'Burundi',
    'KH' => 'Cambodia',
    'CM' => 'Cameroon',
    'CA' => 'Canada',
    'CV' => 'Cape Verde',
    'KY' => 'Cayman Islands',
    'CF' => 'Central African Republic',
    'TD' => 'Chad',
    'CL' => 'Chile',
    'CN' => 'China',
    'CX' => 'Christmas Island',
    'CC' => 'Cocos (Keeling) Islands',
    'CO' => 'Colombia',
    'KM' => 'Comoros',
    'CG' => 'Congo',
    'CD' => 'Congo, the Democratic Republic of the',
    'CK' => 'Cook Islands',
    'CR' => 'Costa Rica',
    'CI' => 'Cote D\'Ivoire',
    'HR' => 'Croatia',
    'CU' => 'Cuba',
    'CY' => 'Cyprus',
    'CZ' => 'Czech Republic',
    'DK' => 'Denmark',
    'DJ' => 'Djibouti',
    'DM' => 'Dominica',
    'DO' => 'Dominican Republic',
    'EC' => 'Ecuador',
    'EG' => 'Egypt',
    'SV' => 'El Salvador',
    'GQ' => 'Equatorial Guinea',
    'ER' => 'Eritrea',
    'EE' => 'Estonia',
    'ET' => 'Ethiopia',
    'FK' => 'Falkland Islands (Malvinas)',
    'FO' => 'Faroe Islands',
    'FJ' => 'Fiji',
    'FI' => 'Finland',
    'FR' => 'France',
    'GF' => 'French Guiana',
    'PF' => 'French Polynesia',
    'TF' => 'French Southern Territories',
    'GA' => 'Gabon',
    'GM' => 'Gambia',
    'GE' => 'Georgia',
    'DE' => 'Germany',
    'GH' => 'Ghana',
    'GI' => 'Gibraltar',
    'GR' => 'Greece',
    'GL' => 'Greenland',
    'GD' => 'Grenada',
    'GP' => 'Guadeloupe',
    'GU' => 'Guam',
    'GT' => 'Guatemala',
    'GN' => 'Guinea',
    'GW' => 'Guinea-Bissau',
    'GY' => 'Guyana',
    'HT' => 'Haiti',
    'HM' => 'Heard Island and Mcdonald Islands',
    'VA' => 'Holy See (Vatican City State)',
    'HN' => 'Honduras',
    'HK' => 'Hong Kong',
    'HU' => 'Hungary',
    'IS' => 'Iceland',
    'IN' => 'India',
    'ID' => 'Indonesia',
    'IR' => 'Iran, Islamic Republic of',
    'IQ' => 'Iraq',
    'IE' => 'Ireland',
    'IL' => 'Israel',
    'IT' => 'Italy',
    'JM' => 'Jamaica',
    'JP' => 'Japan',
    'JO' => 'Jordan',
    'KZ' => 'Kazakhstan',
    'KE' => 'Kenya',
    'KI' => 'Kiribati',
    'KP' => 'Korea, Democratic People\'s Republic of',
    'KR' => 'Korea, Republic of',
    'KW' => 'Kuwait',
    'KG' => 'Kyrgyzstan',
    'LA' => 'Lao People\'s Democratic Republic',
    'LV' => 'Latvia',
    'LB' => 'Lebanon',
    'LS' => 'Lesotho',
    'LR' => 'Liberia',
    'LY' => 'Libyan Arab Jamahiriya',
    'LI' => 'Liechtenstein',
    'LT' => 'Lithuania',
    'LU' => 'Luxembourg',
    'MO' => 'Macao',
    'MK' => 'Macedonia, the Former Yugoslav Republic of',
    'MG' => 'Madagascar',
    'MW' => 'Malawi',
    'MY' => 'Malaysia',
    'MV' => 'Maldives',
    'ML' => 'Mali',
    'MT' => 'Malta',
    'MH' => 'Marshall Islands',
    'MQ' => 'Martinique',
    'MR' => 'Mauritania',
    'MU' => 'Mauritius',
    'YT' => 'Mayotte',
    'MX' => 'Mexico',
    'FM' => 'Micronesia, Federated States of',
    'MD' => 'Moldova, Republic of',
    'MC' => 'Monaco',
    'MN' => 'Mongolia',
    'MS' => 'Montserrat',
    'MA' => 'Morocco',
    'MZ' => 'Mozambique',
    'MM' => 'Myanmar',
    'NA' => 'Namibia',
    'NR' => 'Nauru',
    'NP' => 'Nepal',
    'NL' => 'Netherlands',
    'AN' => 'Netherlands Antilles',
    'NC' => 'New Caledonia',
    'NZ' => 'New Zealand',
    'NI' => 'Nicaragua',
    'NE' => 'Niger',
    'NG' => 'Nigeria',
    'NU' => 'Niue',
    'NF' => 'Norfolk Island',
    'MP' => 'Northern Mariana Islands',
    'NO' => 'Norway',
    'OM' => 'Oman',
    'PK' => 'Pakistan',
    'PW' => 'Palau',
    'PS' => 'Palestinian Territory, Occupied',
    'PA' => 'Panama',
    'PG' => 'Papua New Guinea',
    'PY' => 'Paraguay',
    'PE' => 'Peru',
    'PH' => 'Philippines',
    'PN' => 'Pitcairn',
    'PL' => 'Poland',
    'PT' => 'Portugal',
    'PR' => 'Puerto Rico',
    'QA' => 'Qatar',
    'RE' => 'Reunion',
    'RO' => 'Romania',
    'RU' => 'Russian Federation',
    'RW' => 'Rwanda',
    'SH' => 'Saint Helena',
    'KN' => 'Saint Kitts and Nevis',
    'LC' => 'Saint Lucia',
    'PM' => 'Saint Pierre and Miquelon',
    'VC' => 'Saint Vincent and the Grenadines',
    'WS' => 'Samoa',
    'SM' => 'San Marino',
    'ST' => 'Sao Tome and Principe',
    'SA' => 'Saudi Arabia',
    'SN' => 'Senegal',
    'CS' => 'Serbia and Montenegro',
    'SC' => 'Seychelles',
    'SL' => 'Sierra Leone',
    'SG' => 'Singapore',
    'SK' => 'Slovakia',
    'SI' => 'Slovenia',
    'SB' => 'Solomon Islands',
    'SO' => 'Somalia',
    'ZA' => 'South Africa',
    'GS' => 'South Georgia and the South Sandwich Islands',
    'ES' => 'Spain',
    'LK' => 'Sri Lanka',
    'SD' => 'Sudan',
    'SR' => 'Suriname',
    'SJ' => 'Svalbard and Jan Mayen',
    'SZ' => 'Swaziland',
    'SE' => 'Sweden',
    'CH' => 'Switzerland',
    'SY' => 'Syrian Arab Republic',
    'TW' => 'Taiwan, Province of China',
    'TJ' => 'Tajikistan',
    'TZ' => 'Tanzania, United Republic of',
    'TH' => 'Thailand',
    'TL' => 'Timor-Leste',
    'TG' => 'Togo',
    'TK' => 'Tokelau',
    'TO' => 'Tonga',
    'TT' => 'Trinidad and Tobago',
    'TN' => 'Tunisia',
    'TR' => 'Turkey',
    'TM' => 'Turkmenistan',
    'TC' => 'Turks and Caicos Islands',
    'TV' => 'Tuvalu',
    'UG' => 'Uganda',
    'UA' => 'Ukraine',
    'AE' => 'United Arab Emirates',
    'GB' => 'United Kingdom',
    'US' => 'United States',
    'UM' => 'United States Minor Outlying Islands',
    'UY' => 'Uruguay',
    'UZ' => 'Uzbekistan',
    'VU' => 'Vanuatu',
    'VE' => 'Venezuela',
    'VN' => 'Viet Nam',
    'VG' => 'Virgin Islands, British',
    'VI' => 'Virgin Islands, U.s.',
    'WF' => 'Wallis and Futuna',
    'EH' => 'Western Sahara',
    'YE' => 'Yemen',
    'ZM' => 'Zambia',
    'ZW' => 'Zimbabwe'
];
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate selected program
    $program = $_POST['program'] ?? '';
    if (!array_key_exists($program, $programMap)) {
        die("Invalid program selected.");
    }

    // Normalize and validate email
    $email = strtolower(trim($_POST['email']));
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>
            alert('Invalid email format. Please enter a valid email.');
            window.history.back();
        </script>";
        exit();
    }

    // Check for duplicate email in the same program
    $checkStmt = $conn->prepare("SELECT id FROM participants WHERE email = ? AND program = ?");
    $checkStmt->bind_param("ss", $email, $program);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        echo "<script>
            alert('This email is already registered for this program.');
            window.history.back();
        </script>";
        exit();
    }

    // Sanitize inputs
    $name = $conn->real_escape_string(trim($_POST['name']));
    $phone = $conn->real_escape_string(trim($_POST['phone']));
    $gender = $conn->real_escape_string($_POST['gender']);
    $dob = $conn->real_escape_string($_POST['dob']);
    $country = $conn->real_escape_string(trim($_POST['country']));
    $city = $conn->real_escape_string(trim($_POST['city']));
    $education = $conn->real_escape_string(trim($_POST['education']));
    $organization = $conn->real_escape_string(trim($_POST['organization'] ?? ''));
    $job_title = $conn->real_escape_string(trim($_POST['job_title'] ?? ''));
    $goals = $conn->real_escape_string(trim($_POST['goals']));
    $motivation = $conn->real_escape_string(trim($_POST['motivation']));

    // Insert into database
    $sql = "INSERT INTO participants 
            (name, email, phone, gender, dob, country, city, education, 
             organization, job_title, program, goals, motivation, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("SQL Error: " . $conn->error);
    }

    $stmt->bind_param("sssssssssssss", 
        $name, $email, $phone, $gender, $dob, $country, $city, 
        $education, $organization, $job_title, $program, $goals, $motivation
    );

    if ($stmt->execute()) {
        $redirectUrl = $programMap[$program]['redirect'] ?? 'index.html';
        echo "<script>
            echo 'alert(\"Thank you for registering for the $program program! Get to know what this program entails...  Redirecting...\");';
            window.location.href = '$redirectUrl';
        </script>";
    } else {
        error_log("Database error: " . $stmt->error);
        echo "<script>
            alert('Registration failed. Please try again.');
            window.history.back();
        </script>";
    }

    $stmt->close();
    $conn->close();
    exit();
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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-image: url('image/logo.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            height: 100vh;
            margin: 0;
            padding: 0;

        }
        .form-container {
            background: lightgray;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-top: 30px;
            max-width: 1400px;
        }
        .form-page {
            display: none;
    
        }
        .form-page.active {
            display: block;
        }
        .form-control, .form-select {
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        
        .progress-bar {
            height: 10px;
            background-color:rgb(224, 224, 224);
            margin-bottom: 20px;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 2px 6px black;
            border: 1px solid #ccc;
        }
        .progress {
            height: 100%;
            width: 0%;
            transition: width 0.4s ease-in-out;
            border-radius: 4px;
        }
        .btn-next, .btn-prev {
            padding: 10px 20px;
            border-radius: 4px;
            font-weight: 500;
        }
        .btn-next {
            background-color: #4285f4;
            color: white;
        }
        .btn-prev {
            background-color: white;
            color: #4285f4;
            border: 1px solid #4285f4;
            margin-right: 10px;
        }
        .form-title {
            color: #202124;
            font-size: 24px;
            margin-bottom: 20px;
            font-weight: 400;
        }
        .form-description {
            color: #5f6368;
            margin-bottom: 30px;
        }
        .required-field::after {
            content: " *";
            color: #d93025;
        }
    </style>
</head>
<body>

  <!-- Header -->
  <header id="header-container"></header>
  <script src="loadHeader.js"></script>
  
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="form-container">
                    <div class="progress-bar">
                        <div class="progress" id="form-progress"></div>
                    </div>
                    
                    <form id="multi-page-form" method="POST" action="">
                        <!-- Page 1: Personal Information -->
                        <div class="form-page active" id="page1">
                            <h2 class="form-title text-center fw-bold">Personal Information</h2>
                            <p class="form-description">Tell us about yourself</p>
                            
                            <div class="mb-3">
                                <label for="name" class="form-label required-field">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label required-field">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="phone" class="form-label required-field">Phone Number</label>
                                <input type="tel" class="form-control" id="phone" name="phone" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="gender" class="form-label required-field">Gender</label>
                                <select class="form-select" id="gender" name="gender" required>
                                    <option value="">Select...</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                    <option value="prefer-not-to-say">Prefer not to say</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="dob" class="form-label required-field">Date of Birth</label>
                                <input type="date" class="form-control" id="dob" name="dob" required>
                            </div>
                            
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-primary btn-next" onclick="nextPage(1)">Next</button>
                            </div>
                        </div>
                        
                        <!-- Page 2: Location and Education -->
                        <div class="form-page" id="page2">
                            <h2 class="form-title">Location & Education</h2>
                            <p class="form-description">Where are you located and what's your education level?</p>
                            
                            <div class="mb-3">
                                <label for="country" class="form-label required-field">Country</label>
                                <select class="form-select" id="country" name="country" required>
                                    <option value="">Select Country...</option>
                                    <?php foreach ($countries as $code => $name): ?>
                                        <option value="<?= htmlspecialchars($name) ?>"><?= htmlspecialchars($name) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="city" class="form-label required-field">City</label>
                                <input type="text" class="form-control" id="city" name="city" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="education" class="form-label required-field">Education Level</label>
                                <select class="form-select" id="education" name="education" required>
                                    <option value="">Select Education Level...</option>
                                    <?php foreach ($educationLevels as $value => $label): ?>
                                        <option value="<?= htmlspecialchars($value) ?>"><?= htmlspecialchars($label) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-primary btn-prev" onclick="prevPage(2)">Previous</button>
                                <button type="button" class="btn btn-primary btn-next" onclick="nextPage(2)">Next</button>
                            </div>
                        </div>
                        
                        <!-- Page 3: Professional Information -->
                        <div class="form-page" id="page3">
                            <h2 class="form-title">Professional Information</h2>
                            <p class="form-description">Tell us about your professional background</p>
                            
                            <div class="mb-3">
                                <label for="organization" class="form-label">Organization/Company</label>
                                <input type="text" class="form-control" id="organization" name="organization">
                            </div>
                            
                            <div class="mb-3">
                                <label for="job_title" class="form-label">Job Title</label>
                                <input type="text" class="form-control" id="job_title" name="job_title">
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-primary btn-prev" onclick="prevPage(3)">Previous</button>
                                <button type="button" class="btn btn-primary btn-next" onclick="nextPage(3)">Next</button>
                            </div>
                        </div>
                        
                        <!-- Page 4: Program Selection -->
                        <div class="form-page" id="page4">
                            <h2 class="form-title">Program Selection</h2>
                            <p class="form-description">Choose the program you're applying for</p>
                            
                            <div class="mb-3">
                                <label for="program" class="form-label required-field">Program</label>
                                <select class="form-select" id="program" name="program" required>
                                    <option value="">Select a Program...</option>
                                    <?php foreach ($programMap as $value => $data): ?>
                                        <option value="<?= htmlspecialchars($value) ?>"><?= htmlspecialchars($data['display']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-primary btn-prev" onclick="prevPage(4)">Previous</button>
                                <button type="button" class="btn btn-primary btn-next" onclick="nextPage(4)">Next</button>
                            </div>
                        </div>
                        
                        <!-- Page 5: Goals and Motivation -->
                        <div class="form-page" id="page5">
                            <h2 class="form-title">Your Goals & Motivation</h2>
                            <p class="form-description">Tell us why you want to join this program</p>
                            
                            <div class="mb-3">
                                <label for="goals" class="form-label required-field">What do you want to achieve?</label>
                                <textarea class="form-control" id="goals" name="goals" rows="4" required></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="motivation" class="form-label required-field">What motivates you to join this program?</label>
                                <textarea class="form-control" id="motivation" name="motivation" rows="4" required></textarea>
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-primary btn-prev" onclick="prevPage(5)">Previous</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const totalPages = 5;
        let currentPage = 1;
        
        // Initialize form
        document.addEventListener('DOMContentLoaded', function() {
            updateProgress();
        });
        
        function nextPage(pageNum) {
            if (validatePage(pageNum)) {
                document.getElementById(`page${pageNum}`).classList.remove('active');
                document.getElementById(`page${pageNum + 1}`).classList.add('active');
                currentPage = pageNum + 1;
                updateProgress();
                window.scrollTo(0, 0);
            }
        }
        
        function prevPage(pageNum) {
            document.getElementById(`page${pageNum}`).classList.remove('active');
            document.getElementById(`page${pageNum - 1}`).classList.add('active');
            currentPage = pageNum - 1;
            updateProgress();
            window.scrollTo(0, 0);
        }
        
        function updateProgress() {
            const progressPercentage = ((currentPage - 1) / (totalPages - 1)) * 100;
            document.getElementById('form-progress').style.width = `${progressPercentage}%`;
        }
        
        function validatePage(pageNum) {
            const page = document.getElementById(`page${pageNum}`);
            const inputs = page.querySelectorAll('[required]');
            let isValid = true;
            
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    input.classList.add('is-invalid');
                    isValid = false;
                } else {
                    input.classList.remove('is-invalid');
                }
                
                // Special validation for email
                if (input.type === 'email' && input.value.trim()) {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(input.value)) {
                        input.classList.add('is-invalid');
                        isValid = false;
                    }
                }
            });
            
            if (!isValid) {
                // Scroll to first invalid input
                const firstInvalid = page.querySelector('.is-invalid');
                firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstInvalid.focus();
            }
            
            return isValid;
        }
        
        // Remove invalid class when user starts typing
        document.querySelectorAll('[required]').forEach(input => {
            input.addEventListener('input', function() {
                if (this.value.trim()) {
                    this.classList.remove('is-invalid');
                }
            });
        });
    </script>
</body>
</html>