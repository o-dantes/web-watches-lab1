<template>
  <div class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50" v-if="visible">
    <div class="bg-white rounded-lg p-6 w-[90%] max-w-xl relative">
      <button @click="$emit('close')" class="absolute top-2 right-2 text-xl">×</button>
      <h2 class="text-xl mb-4">Ваш кошик</h2>

      <div v-if="cart.length === 0">Кошик порожній.</div>

      <div v-else>
        <div v-for="item in cart" :key="item.id" class="flex justify-between items-center border-b py-2">
          <div>
            {{ item.name }} <br>
            <small>{{ item.price }} грн × </small>
            <input type="number" min="1" v-model.number="item.quantity" class="w-16 border px-1">
          </div>
          <button @click="$emit('remove', item.id)" class="text-red-500">Видалити</button>
        </div>

        <div class="mt-4 font-bold text-right">Загальна сума: {{ total }} грн</div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['visible', 'cart'],
  emits: ['close', 'remove'],
  computed: {
    total() {
      return this.cart.reduce((sum, item) => sum + item.price * item.quantity, 0);
    }
  }
}
</script>
