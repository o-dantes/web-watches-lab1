<?php
// Файл: web-watches-lab1/src/partials/catalog.php

// Увімкніть показ помилок під час налагодження, якщо потрібно:
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// Отримуємо значення фільтру з GET-запиту
$filter = isset($_GET['filter']) ? trim($_GET['filter']) : '';

// Допоміжна функція для перевірки відповідності назви та фільтра
function matchesFilter(string $title, string $filter): bool {
    if ($filter === '') {
        return true;
    }
    // Використовуємо stripos (не mb_stripos), щоб уникнути помилки, 
    // оскільки назви у нас латинкою/ASCII
    return stripos($title, $filter) !== false;
}

// Статичний список товарів з даними про ціну та зображення
$items = [
    [
        'id'     => 1,
        'title'  => 'Garmin Fenix 7X Pro Sapphire Solar',
        'price'  => 500.00, // у EUR для прикладу
        'sources'=> [
            ['media' => '(min-width: 1280px)', 'srcset' => '/src/img/catalog/garminfenix7xprosapphiresolar1x.webp 1x, /src/img/catalog/garminfenix7xprosapphiresolar-2x.webp 2x'],
            ['media' => '(min-width: 768px)',  'srcset' => '/src/img/catalog/garminfenix7xprosapphiresolar1xtablet.webp 1x, /src/img/catalog/garminfenix7xprosapphiresolar2xtablet.webp 2x'],
            ['media' => '(min-width: 320px)',  'srcset' => '/src/img/catalog/garminfenix7xprosapphiresolar1xmobile.webp 1x, /src/img/catalog/garminfenix7xprosapphiresolar2xmobile.webp 2x'],
        ],
        'img'    => '/src/img/catalog/garminfenix7xprosapphiresolar1x.webp',
        'alt'    => 'Garmin Fenix 7X Pro Sapphire Solar',
    ],
    [
        'id'     => 2,
        'title'  => 'Garmin Marq Athlete',
        'price'  => 450.00,
        'sources'=> [
            ['media' => '(min-width: 1280px)', 'srcset' => '/src/img/catalog/garminmarqathlete.webp 1x, /src/img/catalog/garminmarqathlete-2x.webp 2x'],
            ['media' => '(min-width: 768px)',  'srcset' => '/src/img/catalog/garminmarqathlete1xtablet.webp 1x, /src/img/catalog/garminmarqathlete2xtablet.webp 2x'],
            ['media' => '(min-width: 320px)',  'srcset' => '/src/img/catalog/garminmarqathlete1xmobile.webp 1x, /src/img/catalog/garminmarqathlete2xmobile.webp 2x'],
        ],
        'img'    => '/src/img/catalog/garminmarqathlete.webp',
        'alt'    => 'Garmin Marq Athlete',
    ],
    [
        'id'     => 3,
        'title'  => 'Garmin Descent MK1',
        'price'  => 680.00,
        'sources'=> [
            ['media' => '(min-width: 1280px)', 'srcset' => '/src/img/catalog/garmindescentmk1.webp 1x, /src/img/catalog/garmindescentmk1-2x.webp 2x'],
            ['media' => '(min-width: 768px)',  'srcset' => '/src/img/catalog/garmindescentmk1xtablet.webp 1x, /src/img/catalog/garmindescentmk2xtablet.webp 2x'],
            ['media' => '(min-width: 320px)',  'srcset' => '/src/img/catalog/garmindescentmk1xmobile.webp 1x, /src/img/catalog/garmindescentmk2xmobile.webp 2x'],
        ],
        'img'    => '/src/img/catalog/garmindescentmk1.webp',
        'alt'    => 'Garmin Descent MK1',
    ],
    [
        'id'     => 4,
        'title'  => 'Garmin D2 Delta PX',
        'price'  => 380.00,
        'sources'=> [
            ['media' => '(min-width: 1280px)', 'srcset' => '/src/img/catalog/garmind2deltapx.webp 1x, /src/img/catalog/garmind2deltapx-2x.webp 2x'],
            ['media' => '(min-width: 768px)',  'srcset' => '/src/img/catalog/garmind2deltapx1xtablet.webp 1x, /src/img/catalog/garmind2deltapx2xtablet.webp 2x'],
            ['media' => '(min-width: 320px)',  'srcset' => '/src/img/catalog/garmind2deltapx-1xmobile.webp 1x, /src/img/catalog/garmind2deltapx-2xmobile.webp 2x'],
        ],
        'img'    => '/src/img/catalog/garmind2deltapx.webp',
        'alt'    => 'Garmin D2 Delta PX',
    ],
    [
        'id'     => 5,
        'title'  => 'Garmin Fenix 6 Pro Solar',
        'price'  => 400.00,
        'sources'=> [
            ['media' => '(min-width: 1280px)', 'srcset' => '/src/img/catalog/garminfenix6prosolar.webp 1x, /src/img/catalog/garminfenix6prosolar-2x.webp 2x'],
            ['media' => '(min-width: 768px)',  'srcset' => '/src/img/catalog/garminfenix6prosolar1xtablet.webp 1x, /src/img/catalog/garminfenix6prosolar2xtablet.webp 2x'],
            ['media' => '(min-width: 320px)',  'srcset' => '/src/img/catalog/garminfenix6prosolar1xmobile.webp 1x, /src/img/catalog/garminfenix6prosolar2xmobile.webp 2x'],
        ],
        'img'    => '/src/img/catalog/garminfenix6prosolar.webp',
        'alt'    => 'Garmin Fenix 6 Pro Solar',
    ],
    [
        'id'     => 6,
        'title'  => 'Tube Watch S42 Date Steel With Black Case',
        'price'  => 395.00,
        'sources'=> [
            ['media' => '(min-width: 1280px)', 'srcset' => '/src/img/catalog/tubewatchs42datesteelwithblackcase1x.webp 1x, /src/img/catalog/tubewatchs42datesteelwithblackcase2x.webp 2x'],
            ['media' => '(min-width: 768px)',  'srcset' => '/src/img/catalog/tubewatchs42datesteelwithblackcase1xtablet.webp 1x, /src/img/catalog/tubewatchs42datesteelwithblackcase2xtablet.webp 2x'],
            ['media' => '(min-width: 320px)',  'srcset' => '/src/img/catalog/tubewatchs42datesteelwithblackcase1xmobile.webp 1x, /src/img/catalog/tubewatchs42datesteelwithblackcase2xmobile.webp 2x'],
        ],
        'img'    => '/src/img/catalog/tubewatchs42datesteelwithblackcase1x.webp',
        'alt'    => 'Tube Watch S42 Date Steel With Black Case',
    ],
];
?>
<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <title>Каталог товарів</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Підключаємо стилі для каталогу -->
  <link rel="stylesheet" href="/src/css/catalog.css">
  <style>
    /* Дрібні стилі для фільтра та кнопок */
    .filter-form {
      margin: 20px auto;
      text-align: center;
    }
    .filter-form input[type="text"] {
      padding: 8px 10px;
      width: 200px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 1rem;
    }
    .filter-form button {
      padding: 8px 15px;
      margin-left: 5px;
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 1rem;
    }
    .filter-form button:hover {
      background-color: #45a049;
    }
    .add-to-cart {
      margin-top: 10px;
      display: inline-block;
      background-color: #007BFF;
      color: #fff;
      padding: 8px 12px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 1rem;
      text-align: center;
    }
    .add-to-cart:hover {
      background-color: #0069d9;
    }
  </style>
</head>
<body>

  <section class="catalog" id="catalog">
    <div class="container catalog-container">
      <h2 class="catalog-main-title">Catalog</h2>

      <!-- Форма фільтрації -->
      <form method="get" action="" class="filter-form">
        <input
          type="text"
          name="filter"
          placeholder="Пошук за назвою..."
          value="<?= htmlspecialchars($filter, ENT_QUOTES) ?>"
        />
        <button type="submit">Фільтрувати</button>
      </form>

      <ul class="catalog-list">
        <?php foreach ($items as $item): ?>
          <?php if (!matchesFilter($item['title'], $filter)) continue; ?>
          <li class="catalog-list-item">
            <picture>
              <?php foreach ($item['sources'] as $source): ?>
                <source
                  media="<?= htmlspecialchars($source['media'], ENT_QUOTES) ?>"
                  srcset="<?= htmlspecialchars($source['srcset'], ENT_QUOTES) ?>"
                />
              <?php endforeach; ?>
              <img
                class="catalog-pic"
                src="<?= htmlspecialchars($item['img'], ENT_QUOTES) ?>"
                alt="<?= htmlspecialchars($item['alt'], ENT_QUOTES) ?>"
                loading="lazy"
              />
            </picture>
            <div class="catalog-text-wrapper">
              <h3 class="catalog-title"><?= htmlspecialchars($item['title'], ENT_QUOTES) ?></h3>
              <p class="catalog-text"><?= htmlspecialchars($item['price'], ENT_QUOTES) ?></p>
              <!-- Кнопка Купити з даними для JS-калькуляції -->
              <button
                class="add-to-cart"
                data-id="<?= $item['id'] ?>"
                data-name="<?= htmlspecialchars($item['title'], ENT_QUOTES) ?>"
                data-price="<?= $item['price'] ?>"
              >
                Купити
              </button>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>

      <button type="button" class="catalog-btn" id="show-more">Show more</button>
    </div>
  </section>

  <!-- Модалка кошика з підрахунком кількості та суми -->
  <div id="cart-modal" class="modal">
    <div class="modal-content">
      <span class="close" id="cart-close">&times;</span>
      <h2>Кошик</h2>
      <div id="cart-items-container">
        <!-- JS додаватиме сюди товари з quantity, price -->
      </div>
      <div class="total">
        <strong>Сума: <span id="cart-total">0.00</span> грн</strong>
      </div>
      <div class="actions">
        <button id="submit-order" class="submit-button">Оформити замовлення</button>
      </div>
    </div>
  </div>

  <!-- Підключаємо файл JS, який відповідає за поведінку кошика -->
  <script src="/src/js/cart.js"></script>
  <script>
    // Якщо у вас немає ще cart.js, ось мінімальний приклад:
    document.addEventListener('DOMContentLoaded', () => {
      let cart = [];

      const modal = document.getElementById('cart-modal');
      const closeBtn = document.getElementById('cart-close');
      const cartItemsContainer = document.getElementById('cart-items-container');
      const cartTotalElem = document.getElementById('cart-total');
      const submitOrderBtn = document.getElementById('submit-order');

      function openModal() {
        renderCart();
        modal.style.display = 'block';
      }
      function closeModal() {
        modal.style.display = 'none';
      }

      function renderCart() {
        cartItemsContainer.innerHTML = '';
        let total = 0;
        cart.forEach(item => {
          const row = document.createElement('div');
          row.className = 'cart-item';
          row.setAttribute('data-id', item.id);

          const nameSpan = document.createElement('span');
          nameSpan.textContent = item.name;

          const qtyInput = document.createElement('input');
          qtyInput.type = 'number';
          qtyInput.min = 1;
          qtyInput.value = item.quantity;
          qtyInput.addEventListener('change', () => {
            const newQty = parseInt(qtyInput.value);
            if (newQty < 1) {
              qtyInput.value = 1;
              return;
            }
            item.quantity = newQty;
            updateCart();
          });

          const priceSpan = document.createElement('span');
          priceSpan.textContent = (item.price * item.quantity).toFixed(2) + ' грн';

          const removeBtn = document.createElement('button');
          removeBtn.textContent = 'Видалити';
          removeBtn.addEventListener('click', () => {
            cart = cart.filter(x => x.id !== item.id);
            updateCart();
          });

          row.appendChild(nameSpan);
          row.appendChild(qtyInput);
          row.appendChild(priceSpan);
          row.appendChild(removeBtn);
          cartItemsContainer.appendChild(row);

          total += item.price * item.quantity;
        });
        cartTotalElem.textContent = total.toFixed(2);
      }

      function updateCart() {
        renderCart();
      }

      function addToCart(id, name, price) {
        const existing = cart.find(x => x.id === id);
        if (existing) {
          existing.quantity += 1;
        } else {
          cart.push({ id, name, price, quantity: 1 });
        }
        openModal();
      }

      function submitOrder() {
        if (cart.length === 0) {
          alert('Кошик порожній.');
          return;
        }
        // Відправка замовлення на сервер (save_order.php)
        fetch('/save_order.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ cart })
        })
        .then(res => res.json())
        .then(data => {
          alert(data.message || 'Замовлення успішно надіслано!');
          cart = [];
          updateCart();
          closeModal();
        })
        .catch(err => {
          alert('Помилка при відправці: ' + err.message);
        });
      }

      // Прив’язуємо кнопку відкриття кошика (якщо є така кнопка окремо)
      document.getElementById('open-cart-button')?.addEventListener('click', openModal);
      closeBtn.addEventListener('click', closeModal);
      window.addEventListener('click', e => {
        if (e.target === modal) closeModal();
      });
      submitOrderBtn.addEventListener('click', submitOrder);

      // Прив’язуємо кнопки Купити
      document.querySelectorAll('.add-to-cart').forEach(btn => {
        btn.addEventListener('click', () => {
          const id = parseInt(btn.getAttribute('data-id'));
          const name = btn.getAttribute('data-name');
          const price = parseFloat(btn.getAttribute('data-price'));
          addToCart(id, name, price);
        });
      });

      // Show more (закоментовано, доки нема логіки)
      document.getElementById('show-more')?.addEventListener('click', () => {
        alert('Show more functionality not implemented.');
      });
    });
  </script>
</body>
</html>


