<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import { defineProps } from 'vue';

const loading = ref(false);


defineProps({
  cartItems: {
    type: Array,
    required: true,
  },
});


</script>

<template>
  <Head title="Carrito de compras" />
  <AppLayout>
    <section class="py-8 antialiased md:py-12">
      <div class="mx-auto max-w-screen-md px-4 2xl:px-0">
        <h2 class="text-2xl font-bold mb-6">Carrito de compras</h2>
        <div v-if="loading" class="text-center">Cargando...</div>
        <div v-else>
          <div v-if="cartItems.length > 0">
            <ul class="divide-y divide-gray-200 dark:divide-neutral-700">
              <li v-for="item in cartItems" :key="item.id" class="py-4 flex items-center justify-between">
                <div>
                  <div class="font-semibold">{{ item.product.name }}</div>
                  <div class="text-sm text-gray-500">{{ item.product.description }}</div>
                </div>
                <button @click="removeFromCart(item.id)" class="text-red-500 hover:underline">Quitar</button>
              </li>
            </ul>
            <div class="mt-6 flex justify-between">
              <button @click="clearCart" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Vaciar carrito</button>
              <button class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Proceder a compra</button>
            </div>
          </div>
          <div v-else class="text-gray-500 text-center py-8">Tu carrito está vacío.</div>
        </div>
      </div>
    </section>
  </AppLayout>
</template>
