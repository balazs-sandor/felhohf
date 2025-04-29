<?php
function detectFacesRaw($imagePath) {

    $img = base64_encode(file_get_contents($imagePath));
    $response = file_get_contents("http://10.101.2.4:5000/v1/vision/detection", false, stream_context_create([
        "http" => [
            "method"  => "POST",
            "header"  => "Content-Type: application/json",
            "content" => json_encode(["image" => $img]),
        ]
    ]));
    $data = json_decode($response, true);
    $peopleCount = count($data["predictions"]);
    return file_get_contents($imagePath);
}
?>