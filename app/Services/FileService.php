<?php

namespace app\Services;

class FileService
{
    /**
     * Handles file upload
     *
     * @param array $file The file data from the $_FILES superglobal
     * @param string $targetDir The directory where the file should be uploaded
     * @param array $allowedTypes Allowed MIME types for the upload
     * @param int $maxSize Maximum allowed file size in bytes
     *
     * @return string|bool The uploaded file name on success, false on failure
     */
    public static function uploadFile($file, $targetDir = '/uploads/', $allowedTypes = ['image/jpeg', 'image/png'], $maxSize = 5000000)
    {
        // Check if the file was uploaded successfully
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return "❌ Error: File upload failed.";
        }

        // Check if the uploaded file type is allowed
        if (!in_array($file['type'], $allowedTypes)) {
            return "❌ Error: Invalid file type. Only " . implode(", ", $allowedTypes) . " are allowed.";
        }

        // Check if the file size is within the allowed limit
        if ($file['size'] > $maxSize) {
            return "❌ Error: File is too large. Maximum size is " . ($maxSize / 1000000) . " MB.";
        }

        // Generate a unique name for the uploaded file to avoid overwriting
        $fileName = uniqid('file_', true) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);

        // Create target directory if it doesn't exist
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true); // Create the directory with proper permissions
        }

        // Move the uploaded file to the target directory
        $targetPath = $targetDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return $fileName; // Success: return the new file name
        } else {
            return "❌ Error: Failed to move the uploaded file.";
        }
    }
}
