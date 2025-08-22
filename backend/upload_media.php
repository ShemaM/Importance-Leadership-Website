<?php
require_once 'auth_check.php';
require_once 'db_connect.php';

// Verify CSRF token
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    http_response_code(403);
    die(json_encode(['success' => false, 'message' => 'CSRF token validation failed']));
}

// Check if event ID is provided
if (!isset($_GET['event_id'])) {
    http_response_code(400);
    die(json_encode(['success' => false, 'message' => 'Event ID not provided']));
}

$eventId = (int)$_GET['event_id'];

// Verify user has permission to upload media for this event
// (Add your specific permission checks here)

// Create upload directory if it doesn't exist
$uploadDir = 'uploads/events/' . $eventId . '/';
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Allowed file types
$allowedTypes = [
    'image/jpeg',
    'image/png',
    'image/gif',
    'image/webp',
    'video/mp4',
    'video/webm',
    'video/quicktime',
    'application/pdf',
    'application/msword',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'application/vnd.ms-powerpoint',
    'application/vnd.openxmlformats-officedocument.presentationml.presentation'
];

// Process the uploaded file
try {
    if (!isset($_FILES['file'])) {
        throw new Exception('No file uploaded');
    }

    $file = $_FILES['file'];

    // Validate file
    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new Exception('Upload error: ' . $file['error']);
    }

    if (!in_array($file['type'], $allowedTypes)) {
        throw new Exception('File type not allowed');
    }

    if ($file['size'] > 20 * 1024 * 1024) { // 20MB limit
        throw new Exception('File size exceeds 20MB limit');
    }

    // Generate unique filename
    $fileExt = pathinfo($file['name'], PATHINFO_EXTENSION);
    $fileName = uniqid() . '.' . $fileExt;
    $filePath = $uploadDir . $fileName;

    // Move the file
    if (!move_uploaded_file($file['tmp_name'], $filePath)) {
        throw new Exception('Failed to move uploaded file');
    }

    // Determine media type
    $mediaType = 'document';
    if (strpos($file['type'], 'image/') === 0) {
        $mediaType = 'image';
        
        // Create thumbnail for images
        $thumbnailPath = $uploadDir . 'thumb_' . $fileName;
        createThumbnail($filePath, $thumbnailPath, 300, 200);
    } elseif (strpos($file['type'], 'video/') === 0) {
        $mediaType = 'video';
        
        // For videos, you might want to extract a frame as thumbnail
        // Extract a frame from the video as a thumbnail
        $thumbnailPath = $uploadDir . 'thumb_' . pathinfo($fileName, PATHINFO_FILENAME) . '.jpg';
        $ffmpegCommand = "ffmpeg -i " . escapeshellarg($filePath) . " -ss 00:00:01.000 -vframes 1 " . escapeshellarg($thumbnailPath);
        exec($ffmpegCommand, $output, $returnVar);

        if ($returnVar !== 0) {
            throw new Exception('Failed to generate video thumbnail');
        }
        $thumbnailPath = null;
    } else {
        $thumbnailPath = null;
    }

    // Insert into database
    $stmt = $pdo->prepare("
        INSERT INTO event_media (
            event_id, 
            media_type, 
            file_url, 
            file_name, 
            file_size, 
            file_mime_type, 
            thumbnail_url, 
            uploaded_by
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $eventId,
        $mediaType,
        $filePath,
        $file['name'],
        $file['size'],
        $file['type'],
        $thumbnailPath,
        $_SESSION['user_id']
    ]);

    // Return success response
    echo json_encode([
        'success' => true,
        'filePath' => $filePath,
        'fileName' => $file['name']
    ]);

} catch (Exception $e) {
    // Clean up if file was uploaded but something else failed
    if (isset($filePath)) {
        @unlink($filePath);
    }
    if (isset($thumbnailPath)) {
        @unlink($thumbnailPath);
    }

    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

/**
 * Create thumbnail for uploaded image
 */
function createThumbnail($sourcePath, $destPath, $width, $height) {
    $info = getimagesize($sourcePath);
    
    switch ($info['mime']) {
        case 'image/jpeg':
            $source = imagecreatefromjpeg($sourcePath);
            break;
        case 'image/png':
            $source = imagecreatefrompng($sourcePath);
            break;
        case 'image/gif':
            $source = imagecreatefromgif($sourcePath);
            break;
        case 'image/webp':
            $source = imagecreatefromwebp($sourcePath);
            break;
        default:
            return false;
    }
    
    $sourceWidth = imagesx($source);
    $sourceHeight = imagesy($source);
    
    // Calculate aspect ratio
    $sourceRatio = $sourceWidth / $sourceHeight;
    $thumbRatio = $width / $height;
    
    if ($sourceRatio > $thumbRatio) {
        // Source is wider than thumbnail
        $newHeight = $height;
        $newWidth = (int)($height * $sourceRatio);
    } else {
        // Source is taller than thumbnail
        $newWidth = $width;
        $newHeight = (int)($width / $sourceRatio);
    }
    
    // Create new image
    $thumb = imagecreatetruecolor($width, $height);
    
    // Resize and crop
    imagecopyresampled(
        $thumb, $source,
        0, 0,
        (int)(($sourceWidth - $newWidth) / 2), (int)(($sourceHeight - $newHeight) / 2),
        $width, $height,
        $newWidth, $newHeight
    );
    
    // Save the thumbnail
    switch ($info['mime']) {
        case 'image/jpeg':
            imagejpeg($thumb, $destPath, 85);
            break;
        case 'image/png':
            imagepng($thumb, $destPath, 8);
            break;
        case 'image/gif':
            imagegif($thumb, $destPath);
            break;
        case 'image/webp':
            imagewebp($thumb, $destPath, 85);
            break;
    }
    
    // Free memory
    imagedestroy($source);
    imagedestroy($thumb);
    
    return true;
}