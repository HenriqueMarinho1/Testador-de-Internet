<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $startTime = isset($_POST['start_time']) ? floatval($_POST['start_time']) : 0;
    $endTime = microtime(true);

    if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(["error" => "Erro no upload"]);
        exit;
    }

    $fileSize = $_FILES['file']['size']; 
    $duration = $endTime - $startTime; 

    if ($duration <= 0) {
        echo json_encode(["error" => "Tempo inválido"]);
        exit;
    }

    $uploadSpeedMbps = ($fileSize * 8) / ($duration * 1024 * 1024); 
    echo json_encode(["upload_speed" => round($uploadSpeedMbps, 2)]);
    exit;
}

// Medição de Download (100MB)
$fileSize = 100 * 1024 * 1024;
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=testfile.bin");
header("Content-Length: " . $fileSize);
flush();
echo str_repeat("0", $fileSize);
?>
