<?php
// catalog.php — додайте відразу після відкриття тегу
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    // Під’єднуємося до SQLite
    $db = new SQLite3(__DIR__ . '/../../database.sqlite');
} catch (Exception $e) {
    echo "<p>Неможливо відкрити базу даних: " . htmlspecialchars($e->getMessage()) . "</p>";
    exit;
}

// Виконуємо запит, можливо з фільтрацією (якщо передано GET-параметр filter)
$filter = isset($_GET['filter']) ? trim($_GET['filter']) : '';
if ($filter !== '') {
    // елементарний захист від SQL-injection через escapeString
    $safe = SQLite3::escapeString($filter);
    $query = "SELECT * FROM items WHERE name LIKE '%$safe%' ORDER BY id";
} else {
    $query = "SELECT * FROM items ORDER BY id";
}

$results = $db->query($query);
$items = [];
while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
    $items[] = $row;
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <title>Каталог товарів</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Підключаємо CSS для каталогу та модалки -->
  <link rel="stylesheet" href="/css/catalog.css">
</head>
<body>
  <section class="catalog" id="catalog">
    <div class="container catalog-container">
      <h2 class="catalog-main-title">Каталог</h2>
      
      <!-- Форма для фільтрації -->
      <form method="get" action="" class="filter-form">
        <input type="text" name="filter" placeholder="Пошук..." value="<?= htmlspecialchars($filter) ?>">
        <button type="submit">Фільтрувати</button>
      </form>

      <ul class="catalog-list">
        <?php if (count($items) === 0): ?>
          <li>Товарів не знайдено.</li>
        <?php else: ?>
          <?php foreach ($items as $item): ?>
            <li class="catalog-list-item">
              <!-- Тут можна вставити <img> за потребою -->
              <div class="product-info">
                <h3><?= htmlspecialchars($item['name']) ?></h3>
                <p>Ціна: <strong><?= number_format($item['price'], 2, ',', ' ') ?> грн</strong></p>
                <button class="add-to-cart" 
                        data-id="<?= $item['id'] ?>" 
                        data-name="<?= htmlspecialchars($item['name']) ?>" 
                        data-price="<?= $item['price'] ?>">
                  Додати в кошик
                </button>
              </div>
            </li>
          <?php endforeach; ?>
        <?php endif; ?>
      </ul>
    </div>
  </section>

  <!-- Кошик-модалка -->
  <div id="cart-modal" class="modal">
    <div class="modal-content">
      <span class="close" id="cart-close">&times;</span>
      <h2>Кошик</h2>
      <div id="cart-items-container">
        <!-- JS динамічно вставляє сюди товари -->
      </div>
      <div class="total">
        <strong>Сума: <span id="cart-total">0.00</span> грн</strong>
      </div>
      <div class="actions">
        <button id="submit-order" class="submit-button">Оформити замовлення</button>
      </div>
    </div>
  </div>

  <!-- Підключаємо JS для роботи кошика -->
  <script src="/js/cart.js"></script>
</body>
</html>
