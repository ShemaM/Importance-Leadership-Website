<?php
require_once 'config.php';

header('Content-Type: application/json');

try {
    // Get and validate the POST data first
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    
    // Debug: log the incoming data
    error_log('Incoming donation data: ' . print_r($data, true));
    
    // Validate required fields - including donationType
    $required = ['amount', 'name', 'email', 'donationType'];
    foreach ($required as $field) {
        if (empty($data[$field])) {
            throw new Exception("Missing required field: $field");
        }
    }
    
    // Validate donationType specifically
    $validDonationTypes = ['one-time', 'monthly', 'project'];
    if (!in_array($data['donationType'], $validDonationTypes)) {
        throw new Exception('Invalid donation type specified');
    }
    
    // Validate amount
    $amount = filter_var($data['amount'], FILTER_VALIDATE_INT);
    if ($amount === false || $amount <= 0) {
        throw new Exception('Invalid amount specified');
    }
    
    // Validate email
    $email = filter_var($data['email'], FILTER_VALIDATE_EMAIL);
    if ($email === false) {
        throw new Exception('Invalid email address');
    }

    // Create a PaymentIntent with all validated data
    $paymentIntent = \Stripe\PaymentIntent::create([
        'amount' => $amount,
        'currency' => $data['currency'] ?? 'usd',
        'metadata' => [
            'donation_type' => $data['donationType'],
            'donor_name' => $data['name'],
            'donor_email' => $email
        ],
        'description' => ucfirst($data['donationType']) . ' donation from ' . $data['name']
    ]);

    // Return the client secret and other needed data
    echo json_encode([
        'clientSecret' => $paymentIntent->client_secret,
        'status' => 'success',
        'donationType' => $data['donationType'] // Echo back for debugging
    ]);
    
} catch (\Stripe\Exception\ApiErrorException $e) {
    // Stripe-specific errors
    error_log('Stripe error: ' . $e->getMessage());
    http_response_code(400);
    echo json_encode([
        'error' => 'Payment processing error: ' . $e->getMessage(),
        'status' => 'error'
    ]);
} catch (Exception $e) {
    // General errors
    error_log('Donation error: ' . $e->getMessage());
    http_response_code(400);
    echo json_encode([
        'error' => $e->getMessage(),
        'status' => 'error'
    ]);
}
?>