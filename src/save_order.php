<?php
// Файл: save_order.php
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['cart']) || !is_array($data['cart'])) {
    http_response_code(400);
    echo json_encode(['message' => 'Невірні дані']);
    exit;
}

try {
    // Підключаємося до тієї ж SQLite-бази
    $db = new SQLite3(__DIR__ . '/database.sqlite');
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['message' => 'Помилка підключення до бази: ' . $e->getMessage()]);
    exit;
}

// Перевіримо існування таблиці orders (зазвичай вона вже є після init_db.php)
$db->exec('
    CREATE TABLE IF NOT EXISTS orders (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        order_data TEXT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );
');

// Готуємо JSON із вмістом кошика
$orderData = json_encode($data['cart'], JSON_UNESCAPED_UNICODE);

// Виконуємо вставку
$stmt = $db->prepare('INSERT INTO orders (order_data) VALUES (:orderData)');
$stmt->bindValue(':orderData', $orderData, SQLITE3_TEXT);
$result = $stmt->execute();

if ($result) {
    echo json_encode(['message' => 'Замовлення успішно збережено!']);
} else {
    http_response_code(500);
    echo json_encode(['message' => 'Не вдалося зберегти замовлення']);
}

$stmt->close();
$db->close();
