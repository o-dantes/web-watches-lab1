<?php
// save_order.php

// Повінстю чистий PHP — без проміжного HTML або пробілів до <?php
header('Content-Type: application/json; charset=utf-8');

// Отримуємо “сире” тіло запиту
$rawBody = file_get_contents('php://input');
if ($rawBody === false || strlen($rawBody) === 0) {
    http_response_code(400);
    echo json_encode([
        'status'  => 'error',
        'message' => 'Не отримано дані замовлення.'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// Декодуємо JSON
$data = json_decode($rawBody, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode([
        'status'  => 'error',
        'message' => 'Невірний формат JSON: ' . json_last_error_msg()
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

if (!isset($data['cart']) || !is_array($data['cart'])) {
    http_response_code(400);
    echo json_encode([
        'status'  => 'error',
        'message' => 'Немає даних кошика або невірний формат.'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// Для прикладу просто збережемо у файл (або можна реалізувати запис у базу)
$ordersDir = __DIR__ . '/orders';
if (!is_dir($ordersDir)) {
    mkdir($ordersDir, 0755, true);
}
$orderFile = $ordersDir . '/order_' . date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . '.json';

$orderData = [
    'timestamp' => date('c'),
    'cart'      => $data['cart']
];

if (file_put_contents($orderFile, json_encode($orderData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)) === false) {
    http_response_code(500);
    echo json_encode([
        'status'  => 'error',
        'message' => 'Не вдалося зберегти замовлення на сервері.'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// Якщо все гаразд, повернемо відповідь 200 та JSON
http_response_code(200);
echo json_encode([
    'status'  => 'success',
    'message' => 'Замовлення успішно отримано. Дякуємо за покупку!'
], JSON_UNESCAPED_UNICODE);
exit;
