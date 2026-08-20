<?php

function sendResponse(
    int $statusCode,
    bool $success,
    string $message,
    array $data = []
): never {

    http_response_code($statusCode);

    echo json_encode([
        "status" => $success,
        "message" => $message,
        "data" => $data
    ]);

    exit;
}

?>