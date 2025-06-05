<?php
// init_db.php — run this ONCE to create and seed the database

$db = new SQLite3('database.sqlite');

// Create table
$db->exec("CREATE TABLE IF NOT EXISTS items (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    price INTEGER NOT NULL
)");

// Sample data
$items = [
    ['Casio G-Shock', 2500],
    ['Rolex Submariner', 120000],
    ['Seiko 5', 3800],
    ['Tissot PRX', 8500],
    ['Omega Speedmaster', 105000],
];

$db->exec("DELETE FROM items"); // clear old

foreach ($items as $item) {
    $stmt = $db->prepare("INSERT INTO items (name, price) VALUES (:name, :price)");
    $stmt->bindValue(':name', $item[0], SQLITE3_TEXT);
    $stmt->bindValue(':price', $item[1], SQLITE3_INTEGER);
    $stmt->execute();
}

echo "✅ Database initialized successfully.\n";
