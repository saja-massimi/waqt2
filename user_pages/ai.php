<?php
require_once '../user_pages/models/dbh.php';
require_once '../user_pages/models/productsModel.php';
require_once '../user_pages/controllers/productsController.php';

header("Content-Type: application/json");
$products_ai = new productsController();
$allProducts = $products_ai->showAllProducts();

// Shuffle the array to randomize the order


// Get the first 25 products from the shuffled array
$randomProducts = array_slice($allProducts, 0, 10);

// Format the output
$formattedText = "";

foreach ($randomProducts as $product) {
    $formattedText .= "Product Name: " . $product['watch_name'] . "\n";
    $formattedText .= "Description: " . $product['watch_description'] . "\n";
    $formattedText .= "Price: $" . $product['watch_price'] . "\n";
    $formattedText .= "Category: " . $product['watch_category'] . "\n";
    $formattedText .= "Brand: " . $product['watch_brand'] . "\n";
    $formattedText .= "Model: " . $product['watch_model'] . "\n";
    $formattedText .= "Gender: " . $product['watch_gender'] . "\n";
    $formattedText .= "Strap Material: " . $product['strap_material'] . "\n";
    $formattedText .= "Available Quantity: " . $product['quantity'] . "\n";
    $formattedText .= "----------------------\n"; // Separator for readability
}



// Set your API key here securely
$apiKey = "api key";

// Get the incoming JSON data
$requestBody = file_get_contents("php://input");
$chats = json_decode($requestBody, true); // Decode to an associative array

// Prepare the messages array
$messages = [
    [
        "role" => "system",
        "content" => "You are Waqtify, an intelligent assistant chatbot for an e-commerce website specializing in watches.\n 
                     ### rules:
                     - **Only provide answers based on the data available to you.**
                     - **You do not have the ability to make orders or execute tasks.**
                     - **If a user requests an order or something beyond your capabilities, give them the appropriate contact details.**
                     - **Your respone must not exceed 100 letters**
                     - **All Our prices is Jordanian only**


### Contact Information:\n
                     - **Manager**: Omar Fathi\n
                     - **Phone**: 0781616916\n\n
                     ### Location:\n
                     - **City**: Amman\n
                     - **Branches**: Khalda, Tla Al Aali\n\n
                     ### Delivery Information:\n
                     - **Delivery Areas**: All governorates\n
                     - **Delivery Fees**: 2 dinars within Amman, 3 dinars for other areas\n
                     - **Shipping Time**: 1-2 days\n\n
                     ### Logo:\n
                     - Our logo name is **WAQT**.\n\n
                     ### Business Hours:\n
                     - Open every day except Friday from 10 AM to 12 PM.\n\n
                     ### Your Role:\n
                     Assist customers in finding the perfect watch by providing:\n
                     - Information on styles and features.\n
                     - Details on promotions and offers.\n\n
                     ### Response Guidelines:\n
                     Keep your answers specific and simple.\n\n
                     
                     ### Some Products data:\n
                     ".nl2br($formattedText)
    ]
];


// Add user messages to the messages array
foreach ($chats as $chat) {
    $messages[] = [
        "role" => $chat['role'], // Use 'role' key directly
        "content" => $chat['content'] // Use 'content' key directly
    ];
}



// Set up the request to the OpenAI API
$apiUrl = "https://api.openai.com/v1/chat/completions";
$data = [
    "model" => "gpt-3.5-turbo",
    "messages" => $messages,
];

$options = [
    "http" => [
        "header" => [
            "Content-Type: application/json",
            "Authorization: Bearer $apiKey"
        ],
        "method" => "POST",
        "content" => json_encode($data),
    ],
];

$context = stream_context_create($options);
$response = file_get_contents($apiUrl, false, $context);

// Check if the response is valid
if ($response === false) {
    http_response_code(500);
    echo json_encode(["error" => "Failed to connect to OpenAI API."]);
    exit;
}

// Decode the response and send it back to the client
$responseData = json_decode($response, true);
if (isset($responseData['choices'][0]['message']['content'])) {
    echo json_encode(["message" => $responseData['choices'][0]['message']['content']]);
} else {
    echo json_encode(["error" => "Invalid response from OpenAI."]);
}
?>
