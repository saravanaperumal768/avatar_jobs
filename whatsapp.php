<?php
require 'vendors/autoload.php'; // Ensure you have included the Guzzle library

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

$client = new Client();
$mobile = "8300923800"; // Ensure this variable is correctly assigned
$name = "sarap";



$apiUrl = 'https://live-mt-server.wati.io/302251/api/v1/sendTemplateMessage';
$requestPayload = [
    'template_name' => 'test5',
    'broadcast_name' => 'test5_200720241629',
    'receivers' => [
        [
            'whatsappNumber' => '918300923800',
        ],
    ],
];



$requestPayloadJson = json_encode($requestPayload);

// Log the payload
error_log("Request Payload: " . $requestPayloadJson);

$headers = [
    'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJqdGkiOiI5YzA0YzExNi0xMTQwLTQ5NWItOWFjOC05NDM0ZTU1NjQ5MzQiLCJ1bmlxdWVfbmFtZSI6ImJ1c2luZXNzQGF2YXRhcnByaW50cy5jb20iLCJuYW1laWQiOiJidXNpbmVzc0BhdmF0YXJwcmludHMuY29tIiwiZW1haWwiOiJidXNpbmVzc0BhdmF0YXJwcmludHMuY29tIiwiYXV0aF90aW1lIjoiMDcvMjAvMjAyNCAwOTo1NzoxNiIsImRiX25hbWUiOiJtdC1wcm9kLVRlbmFudHMiLCJ0ZW5hbnRfaWQiOiIzMDIyNTEiLCJodHRwOi8vc2NoZW1hcy5taWNyb3NvZnQuY29tL3dzLzIwMDgvMDYvaWRlbnRpdHkvY2xhaW1zL3JvbGUiOiJBRE1JTklTVFJBVE9SIiwiZXhwIjoyNTM0MDIzMDA4MDAsImlzcyI6IkNsYXJlX0FJIiwiYXVkIjoiQ2xhcmVfQUkifQ.yXrG1K4HNQ-euZ09FOq5EFj5HW9z2inAMcWk_rG61tg',
    'Content-Type' => 'application/json',
];

try {
    $response = $client->request('POST', $apiUrl, [
        'body' => $requestPayloadJson,
        'headers' => $headers,
    ]);

    if ($response->getStatusCode() == 200) {
        $responseBody = $response->getBody()->getContents();
        echo json_encode([
            "result" => true,
            "info" => "success",
            "response" => json_decode($responseBody),
            "validWhatsAppNumber" => true
        ]);
    } else {
        echo json_encode([
            "result" => false,
            "info" => "API call failed.",
            "statusCode" => $response->getStatusCode(),
            "response" => json_decode($response->getBody()->getContents()),
            "validWhatsAppNumber" => true
        ]);
    }
} catch (RequestException $e) {
    echo json_encode([
        "result" => false,
        "info" => 'Caught exception: ' . $e->getMessage(),
        "validWhatsAppNumber" => true
    ]);
}
?>
