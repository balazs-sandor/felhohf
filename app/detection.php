<?php
function detectFacesRaw($imagePath) {
    $visionhost = getenv('VISION_HOST') ?: '10.101.2.4';
    $url = 'http://' . $visionhost . ':5000/v1/vision/detection';

    // Check if the file exists
    if (!file_exists($imagePath)) {
        echo "File not found: $imagePath";
        return ['error' => 'Image file not found'];
    }

    // Initialize CURL session
    $ch = curl_init();

    // Prepare POST fields
    $postFields = [
        'image' => new CURLFile($imagePath)
    ];

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);

    // Execute CURL and get response
    $response = curl_exec($ch);

    // Check for CURL errors
    if (curl_errno($ch)) {
        $error_msg = curl_error($ch);
        curl_close($ch);
        echo "CURL error: $error_msg";
        return ['error' => $error_msg];
    }

    curl_close($ch);

    // Decode the JSON response
    $data = json_decode($response, true);

    // Filter for 'person' objects only
    $persons = array_filter($data['predictions'] ?? [], function ($prediction) {
        return strtolower($prediction['label']) === 'person';
    });


    $detectionresult = array_values($persons);

    $imageData = file_get_contents($imagePath);

    $imageResource = imagecreatefromstring($imageData);

    foreach ($detectionresult as $detection) {
        $xMin = $detection['x_min'];
        $yMin = $detection['y_min'];
        $xMax = $detection['x_max'];
        $yMax = $detection['y_max'];

        $color = imagecolorallocate($imageResource, 255, 0, 0); // Red color for rectangles
        imagerectangle($imageResource, $xMin, $yMin, $xMax, $yMax, $color);
    }

    ob_start();
    imagejpeg($imageResource);
    $detectionImage = ob_get_clean();
    imagedestroy($imageResource);

    return ['detectionImage' => $detectionImage, 'detectionCount' => count($detectionresult)];
}
?>