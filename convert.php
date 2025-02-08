<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['fileUpload'])) {
    // Get file details
    $file = $_FILES['fileUpload'];
    
    // Check if file upload is successful
    if ($file['error'] == 0) {
        $fileTmpName = $file['tmp_name'];
        $fileName = $file['name'];
        $fileSize = $file['size'];
        $fileType = $file['type'];
        
        // Read the uploaded file
        $fileContent = file_get_contents($fileTmpName);
        
        // Process and format the content of the file
        $lines = explode("\n", $fileContent);
        $htmlContent = "<h2>Converted Chat Log</h2><div style='white-space: pre-wrap; font-family: Arial, sans-serif;'>";
        
        foreach ($lines as $line) {
            // Assuming each chat message has a format like "User: Message"
            $line = trim($line);
            if (empty($line)) continue;
            
            // Split by first occurrence of ":"
            $parts = explode(":", $line, 2);
            if (count($parts) == 2) {
                $user = htmlspecialchars(trim($parts[0]));
                $message = htmlspecialchars(trim($parts[1]));
                
                // Format as HTML
                $htmlContent .= "<p><strong>$user:</strong> $message</p>";
            }
        }
        
        $htmlContent .= "</div>";
        
        // Output the HTML content
        echo $htmlContent;
    } else {
        echo "<p>Error uploading the file. Please try again.</p>";
    }
} else {
    echo "<p>No file uploaded.</p>";
}
?>
