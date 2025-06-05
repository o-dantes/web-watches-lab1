<template>
  <div v-if="isVisible" class="modal">
    <div class="modal-content">
      <span class="close" @click="closeModal">&times;</span>
      <h2>Кошик</h2>
      <div v-for="item in cartItems" :key="item.id" class="cart-item">
        <span>{{ item.name }}</span>
        <input type="number" v-model.number="item.quantity" @change="updateQuantity(item)" min="1" />
        <span>{{ item.price * item.quantity }} грн</span>
        <button @click="removeFromCart(item.id)">Видалити</button>
      </div>
      <div class="total">
        <strong>Сума: {{ total }} грн</strong>
      </div>
      <div class="actions">
        <button @click="submitOrder" class="submit-button">Оформити замовлення</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['cartItems', 'isVisible'],
  computed: {
    total() {
      return this.cartItems.reduce((sum, item) => sum + item.price * item.quantity, 0);
    }
  },
  methods: {
    closeModal() {
      this.$emit('close');
    },
    updateQuantity(item) {
      this.$emit('update-quantity', item);
    },
    removeFromCart(id) {
      this.$emit('remove-from-cart', id);
    },
    submitOrder() {
      this.$emit('submit-order');
    }
  }
};
</script>

<style>
/* Додай стилі для модального вікна */
.modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0,0,0,0.6);
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-content {
  background: white;
  padding: 2rem;
  border-radius: 8px;
  width: 400px;
  max-width: 90%;
}

.cart-item {
  display: flex;
  justify-content: space-between;
  margin-bottom: 1rem;
}

.total {
  margin-top: 1rem;
  font-size: 1.2rem;
}

.actions {
  margin-top: 1rem;
  text-align: right;
}

.submit-button {
  padding: 0.5rem 1rem;
  background-color: #4CAF50;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.submit-button:hover {
  background-color: #45a049;
}

.close {
  float: right;
  font-size: 1.5rem;
  cursor: pointer;
}
</style>

