<template>
  <div class="product-list">
    <div v-for="product in products" :key="product.id" class="product">
      <h3>{{ product.name }}</h3>
      <p>{{ product.price }} грн</p>
      <button @click="addToCart(product)">Додати до кошика</button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      products: [
        { id: 1, name: 'Годинник A', price: 1000 },
        { id: 2, name: 'Годинник B', price: 1500 },
        // Додай більше товарів за потреби
      ]
    };
  },
  methods: {
    addToCart(product) {
      this.$emit('add-to-cart', product);
    }
  }
};
</script>
