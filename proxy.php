<?php

header("Access-Control-Allow-Origin: *");

header("Content-Type: application/json; charset=UTF-8");

header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS"); // Adicionei DELETE

header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");



if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {

    http_response_code(200);

    exit;

}



// Pega e valida o endpoint

$endpoint = $_GET['endpoint'] ?? '';

if (empty($endpoint)) {

    http_response_code(400);

    die(json_encode(['error' => 'Endpoint não especificado']));

}



// Configura a requisição para o n8n

$n8nUrl = 'https://n8neditor.marcosconde.sytes.net/webhook/' . $endpoint;

$ch = curl_init($n8nUrl);



$options = [

    CURLOPT_RETURNTRANSFER => true,

    CURLOPT_FOLLOWLOCATION => true,

    CURLOPT_HTTPHEADER => [

        'Authorization: Bearer 30041986',

        'Content-Type: application/json'

    ],

    CURLOPT_TIMEOUT => 10,

    CURLOPT_FAILONERROR => true

];



// Configura conforme o método

switch ($_SERVER['REQUEST_METHOD']) {

    case 'GET':

        $params = $_GET;

        unset($params['endpoint']);

        if (!empty($params)) {

            $n8nUrl .= '?' . http_build_query($params);

            curl_setopt($ch, CURLOPT_URL, $n8nUrl);

        }

        break;

        

    case 'POST':

        $options[CURLOPT_POST] = true;

        $options[CURLOPT_POSTFIELDS] = file_get_contents('php://input');

        break;

        

    case 'DELETE':

        $options[CURLOPT_CUSTOMREQUEST] = 'DELETE';

        $options[CURLOPT_POSTFIELDS] = file_get_contents('php://input');

        break;

}



curl_setopt_array($ch, $options);



// Executa e trata a resposta

try {

    $response = curl_exec($ch);

    

    if (curl_errno($ch)) {

        throw new Exception('Erro no curl: ' . curl_error($ch));

    }



    // Verifica se a resposta é JSON válido

    $decoded = json_decode($response);

    if (json_last_error() !== JSON_ERROR_NONE) {

        throw new Exception('Resposta inválida do servidor n8n');

    }



    // Repassa a resposta do n8n

    http_response_code(curl_getinfo($ch, CURLINFO_HTTP_CODE));

    echo $response;



} catch (Exception $e) {
    // Tente obter o código HTTP retornado pelo n8n, se houver
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    http_response_code(500);
    echo json_encode([
        'success' => false,
        // **MENSAGEM CRÍTICA DE DEBUG**
        'message_php' => 'Erro interno do proxy: ' . $e->getMessage(),
        'n8n_response' => curl_error($ch), // Mostra o erro exato do cURL
        'n8n_status' => $httpCode, // Mostra o status retornado pelo n8n (se alcançado)
    ]);
} finally {
    curl_close($ch);
}

?>