<?php
$source = 'public/assets/aktivitas-anak/mockup-buku.png';
$destination = 'public/assets/aktivitas-anak/mockup-buku.webp';
$quality = 80;

if (!file_exists($source)) {
    die("Error: Source file not found.\n");
}

$info = getimagesize($source);
if ($info['mime'] == 'image/png') {
    $image = imagecreatefrompng($source);
    
    // Maintain transparency
    imagepalettetotruecolor($image);
    imagealphablending($image, false);
    imagesavealpha($image, true);
    
    if (function_exists('imagewebp')) {
        $result = imagewebp($image, $destination, $quality);
        if ($result) {
            echo "Success: Compressed to WEBP.\n";
            echo "Old Size: " . round(filesize($source) / 1024, 2) . " KB\n";
            echo "New Size: " . round(filesize($destination) / 1024, 2) . " KB\n";
        } else {
            echo "Error: Failed to save WEBP.\n";
        }
    } else {
        echo "Error: imagewebp function not available.\n";
    }
    
    imagedestroy($image);
} else {
    echo "Error: Not a valid PNG.\n";
}
?>
