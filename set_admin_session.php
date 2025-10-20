<?php
session_start();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método não permitido']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['admin'])) {
    echo json_encode(['success' => false, 'message' => 'Dados do admin não fornecidos']);
    exit;
}

// Sanitiza os dados antes de armazenar na sessão
$_SESSION['admin'] = [
    'id' => filter_var($data['admin']['id'], FILTER_SANITIZE_NUMBER_INT),
    'email' => filter_var($data['admin']['email'], FILTER_SANITIZE_EMAIL),
    'nome' => filter_var($data['admin']['nome'], FILTER_SANITIZE_STRING),
    'logged_in' => true,
    'last_login' => time()
];

echo json_encode(['success' => true, 'message' => 'Sessão criada com sucesso']);