<?php

// Define the access token

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$accessToken = "pat-eu1-43393fe4-e725-419d-b3ab-cb08d1763915";

// Contact Data
$contactData = array(
    'properties' => array(
        'firstname' => isset($_POST['name']) ? $_POST['name'] : '',
        'email' => isset($_POST['email']) ? $_POST['email'] : '',
        'phone' => isset($_POST['phone']) ? $_POST['phone'] : '',
        'company' => isset($_POST['company']) ? $_POST['company'] : '',
        'message' => isset($_POST['comment']) ? $_POST['comment'] : '',
    )
);

// Convert data to JSON format
$data_string = json_encode($contactData);


// HubSpot CRM API endpoint
$url = 'https://api.hubapi.com/crm/v3/objects/contacts';

// Initialize cURL
$ch = curl_init($url);

// Set cURL options
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer ' . $accessToken, // Added space after 'Bearer'
    'Content-Type: application/json'
));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute cURL request
$response = curl_exec($ch);
curl_close($ch);

// Decode the response JSON to an array
$response_data = json_decode($response, true);

// Check for errors in the response
if (isset($response_data['status']) && $response_data['status'] === 'error') {
    echo json_encode(array('status' => 'error', 'message' => $response_data['message']));
} else {
    echo json_encode(array('status' => 'success', 'message' => 'Contact created successfully'));
}
} else {
echo json_encode(array('status' => 'error', 'message' => 'Form not submitted correctly.'));
}


?>
