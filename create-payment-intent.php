<?php
// donation-handler.php
require_once 'vendor/autoload.php';

// Initialize Stripe
\Stripe\Stripe::setApiKey('sk_test_your_secret_key_here');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validate CSRF token
        session_start();
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['token']) {
            throw new Exception('CSRF token validation failed');
        }
        
        // Validate inputs
        $required = ['amount', 'name', 'email', 'payment_method'];
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                throw new Exception("Missing required field: $field");
            }
        }
        
        $amount = (int)($_POST['amount'] * 100); // Convert to cents
        if ($amount < 50) { // Minimum $0.50
            throw new Exception('Amount must be at least $0.50');
        }
        
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        if (!$email) {
            throw new Exception('Invalid email address');
        }
        
        // Create customer in Stripe (optional)
        $customer = \Stripe\Customer::create([
            'email' => $email,
            'name' => $_POST['name'],
            'payment_method' => $_POST['payment_method'],
            'invoice_settings' => [
                'default_payment_method' => $_POST['payment_method']
            ]
        ]);
        
        // Create payment intent
        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $amount,
            'currency' => 'usd',
            'customer' => $customer->id,
            'payment_method' => $_POST['payment_method'],
            'off_session' => true,
            'confirm' => true,
            'metadata' => [
                'donation_type' => $_POST['donation_type'] ?? 'one-time',
                'donor_name' => $_POST['name'],
                'donor_email' => $email
            ]
        ]);
        
        // Payment succeeded
        header('Location: donation-success.php?amount=' . ($amount / 100) . '&email=' . urlencode($email));
        exit;
        
    } catch (\Stripe\Exception\CardException $e) {
        // Card was declined
        $error = $e->getMessage();
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

// Generate CSRF token if not exists
if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
?>
