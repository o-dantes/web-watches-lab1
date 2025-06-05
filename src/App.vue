<template>
  <div class="p-6">
    <h1 class="text-3xl mb-4 font-bold">Магазин годинників</h1>
    <ProductList :addToCart="addToCart" />
    <button @click="showCart = true" class="fixed bottom-4 right-4 bg-green-600 text-white px-6 py-3 rounded-full shadow-lg">
      🛒 {{ cart.length }}
    </button>
    <CartModal
      :visible="showCart"
      :cart="cart"
      @close="showCart = false"
      @remove="removeFromCart"
    />
  </div>
</template>

<script>
import ProductList from './components/ProductList.vue'
import CartModal from './components/CartModal.vue'

export default {
  components: { ProductList, CartModal },
  data() {
    return {
      cart: [],
      showCart: false
    }
  },
  methods: {
    addToCart(item) {
      const found = this.cart.find(i => i.id === item.id);
      if (found) {
        found.quantity += 1;
      } else {
        this.cart.push({ ...item, quantity: 1 });
      }
    },
    removeFromCart(id) {
      this.cart = this.cart.filter(i => i.id !== id);
    }
  }
}
</script>


