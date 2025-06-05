<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['cart'])) {
  http_response_code(400);
  echo json_encode(['message' => 'Невірні дані']);
  exit;
}

// TODO: заміни цими свої реальні значення
$dbHost = 'localhost';
$dbUser = 'your_db_user';
$dbPass = 'your_db_pass';
$dbName = 'your_db_name';

$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
if ($conn->connect_error) {
  http_response_code(500);
  echo json_encode(['message' => 'Помилка бази даних']);
  exit;
}

// Збереження замовлення
$orderData = json_encode($data['cart']);
$stmt = $conn->prepare("INSERT INTO orders (order_data) VALUES (?)");
$stmt->bind_param("s", $orderData);

if ($stmt->execute()) {
  echo json_encode(['message' => 'Замовлення збережено!']);
} else {
  http_response_code(500);
  echo json_encode(['message' => 'Не вдалося зберегти замовлення']);
}

$stmt->close();
$conn->close();
?>
