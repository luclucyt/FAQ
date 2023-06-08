<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

$targetDir = '../img/antwoord/';

$fileName = uniqid() . '_' . $_FILES['file']['name'];
$targetPath = $targetDir . $fileName;

// Check if the file was uploaded successfully
if (move_uploaded_file($_FILES['file']['tmp_name'], $targetPath)) {
    $response = array(
        'link' => '../img/antwoord/' . $fileName,
        'title' => $fileName
    );
  
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    echo 'Error uploading the file.';
}
?>
