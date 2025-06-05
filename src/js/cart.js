// Файл: cart.js

document.addEventListener('DOMContentLoaded', () => {
    // Структура для збереження товарів у кошику
    let cart = []; // кожен елемент {id, name, price, quantity}
  
    const modal = document.getElementById('cart-modal');
    const closeBtn = document.getElementById('cart-close');
    const cartItemsContainer = document.getElementById('cart-items-container');
    const cartTotalElem = document.getElementById('cart-total');
    const submitOrderBtn = document.getElementById('submit-order');
  
    // Відкрити модалку
    function openModal() {
      renderCart();
      modal.style.display = 'block';
    }
  
    // Закрити модалку
    function closeModal() {
      modal.style.display = 'none';
    }
  
    // Оновлює відображення кошика
    function renderCart() {
      cartItemsContainer.innerHTML = '';
      let total = 0;
  
      cart.forEach(item => {
        const itemRow = document.createElement('div');
        itemRow.className = 'cart-item';
        itemRow.setAttribute('data-id', item.id);
  
        const nameSpan = document.createElement('span');
        nameSpan.textContent = item.name;
  
        const qtyInput = document.createElement('input');
        qtyInput.type = 'number';
        qtyInput.min = 1;
        qtyInput.value = item.quantity;
        qtyInput.addEventListener('change', (e) => {
          const newQty = parseInt(e.target.value);
          if (newQty < 1) {
            e.target.value = 1;
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
          removeFromCart(item.id);
        });
  
        itemRow.appendChild(nameSpan);
        itemRow.appendChild(qtyInput);
        itemRow.appendChild(priceSpan);
        itemRow.appendChild(removeBtn);
  
        cartItemsContainer.appendChild(itemRow);
  
        total += item.price * item.quantity;
      });
  
      cartTotalElem.textContent = total.toFixed(2);
    }
  
    // Оновити суму та відобразити
    function updateCart() {
      renderCart();
    }
  
    // Додати товар у кошик
    function addToCart(id, name, price) {
      const existing = cart.find(x => x.id === id);
      if (existing) {
        existing.quantity += 1;
      } else {
        cart.push({id, name, price: parseFloat(price), quantity: 1});
      }
      openModal();
    }
  
    // Видалити товар із кошика
    function removeFromCart(id) {
      cart = cart.filter(x => x.id !== id);
      updateCart();
    }
  
    // Відправити замовлення на сервер
    function submitOrder() {
      if (cart.length === 0) {
        alert('Кошик порожній.');
        return;
      }
      // Формуємо payload
      const payload = {
        cart: cart.map(item => ({
          id: item.id,
          name: item.name,
          price: item.price,
          quantity: item.quantity
        }))
      };
  
      fetch('/save_order.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(payload)
      })
      .then(res => {
        if (!res.ok) throw new Error('Помилка у відповіді сервера');
        return res.json();
      })
      .then(data => {
        alert(data.message || 'Замовлення успішно надіслано!');
        cart = [];
        updateCart();
        closeModal();
      })
      .catch(err => {
        alert('Не вдалося відправити замовлення: ' + err.message);
      });
    }
  
    // Прив’язуємо натискання кнопок «Додати в кошик»
    document.querySelectorAll('.add-to-cart').forEach(btn => {
      btn.addEventListener('click', (e) => {
        const id = parseInt(btn.getAttribute('data-id'));
        const name = btn.getAttribute('data-name');
        const price = parseFloat(btn.getAttribute('data-price'));
        addToCart(id, name, price);
      });
    });
  
    // Закриття модалки по хрестику
    closeBtn.addEventListener('click', closeModal);
  
    // Клік поза модалкою закриває її
    window.addEventListener('click', (e) => {
      if (e.target === modal) {
        closeModal();
      }
    });
  
    // Обробник кнопки «Оформити замовлення»
    submitOrderBtn.addEventListener('click', submitOrder);
  });
  