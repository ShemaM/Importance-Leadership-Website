<?php
// donation_success.php
$amount = isset($_GET['amount']) ? floatval($_GET['amount']) : 0;
$email = isset($_GET['email']) ? htmlspecialchars($_GET['email']) : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Successful</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .success-icon {
            font-size: 5rem;
            color: #28a745;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 text-center">
                <div class="card shadow">
                    <div class="card-header bg-success text-white">
                        <h2 class="mb-0">Donation Successful!</h2>
                    </div>
                    <div class="card-body p-5">
                        <i class="fas fa-check-circle success-icon mb-4"></i>
                        <h3 class="mb-3">Thank you for your generosity!</h3>
                        <p class="lead">
                            Your donation of <strong>
                                $<?php echo $amount > 0 ? number_format($amount, 2) : '0.00'; ?>
                            </strong> has been processed successfully.
                        </p>
                        <p>
                            <?php if (!empty($email)): ?>
                                A receipt has been sent to <strong><?php echo $email; ?></strong>.
                            <?php else: ?>
                                No email address was provided.
                            <?php endif; ?>
                        </p>
                        <a href="index.html" class="btn btn-success btn-lg mt-3">Return to Homepage</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>