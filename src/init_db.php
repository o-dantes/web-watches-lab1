<?php
// Файл: init_db.php
// Запуск: php init_db.php
// Першого разу створить базу database.sqlite, таблиці items та orders, а також заповнить items

$dbFile = __DIR__ . '/database.sqlite';

// Якщо файл існує, нічого не робимо
if (file_exists($dbFile)) {
    echo "База даних вже існує: " . $dbFile . "\n";
    exit;
}

try {
    // Відкриваємо або створюємо SQLite-файл
    $db = new SQLite3($dbFile);

    // Створюємо таблицю items: id, name, price (float)
    $db->exec('
        CREATE TABLE IF NOT EXISTS items (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            price REAL NOT NULL
        );
    ');

    // Створюємо таблицю orders: id, order_data (JSON), created_at (timestamp)
    $db->exec('
        CREATE TABLE IF NOT EXISTS orders (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            order_data TEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );
    ');


    $items = [
        ['Garmin Fenix 7X Pro Sapphire Solar', 19999.00],
        ['Garmin Fenix 7X Pro Solar', 17999.00],
        ['Garmin Fenix 7X Sapphire', 18999.00],
        ['Garmin Fenix 7X', 16999.00]
    ];

    $stmt = $db->prepare('INSERT INTO items (name, price) VALUES (:name, :price)');
    foreach ($items as $it) {
        $stmt->bindValue(':name', $it[0], SQLITE3_TEXT);
        $stmt->bindValue(':price', $it[1], SQLITE3_FLOAT);
        $stmt->execute();
    }

    echo "База даних успішно створена та наповнена.\n";

    $db->close();
} catch (Exception $e) {
    echo "Помилка під час створення бази: " . $e->getMessage() . "\n";
    exit(1);
}

