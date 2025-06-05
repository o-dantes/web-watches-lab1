<template>
  <div>
    <h2 class="text-2xl mb-4">Наші товари</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
      <div v-for="item in items" :key="item.id" class="border p-4 rounded shadow">
        <h3 class="text-lg font-bold">{{ item.name }}</h3>
        <p>Ціна: {{ item.price }} грн</p>
        <button @click="addToCart(item)" class="mt-2 bg-blue-600 text-white px-4 py-2 rounded">Додати в кошик</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['addToCart'],
  data() {
    return {
      items: []
    }
  },
  mounted() {
    fetch('/get_items.php')
      .then(res => res.json())
      .then(data => this.items = data);
  }
}
</script>
