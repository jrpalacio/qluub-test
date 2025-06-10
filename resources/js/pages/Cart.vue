<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import { defineProps } from 'vue';
import { router } from '@inertiajs/vue3';
import { Trash, X, ShoppingBag } from 'lucide-vue-next';

const loading = ref(false);

interface CartItem {
  id: number;
  product: {
    id: number;
    name: string;
    description: string;
  };
}

defineProps({
  cartItems: {
    type: Array<CartItem>,
    required: true,
  },
});

const breadcrumbs: BreadcrumbItem[] = [
  {
      title: 'Carrito de compras',
      href: '/dashboard',
  },
];

function removeFromCart(id: number) {
    loading.value = true;
    router.delete(route('cart.destroy', id), {
        preserveScroll: true,
        onSuccess: () => {
            loading.value = false;
        },
    });
}

function clearCart() {
    loading.value = true;
    router.delete(route('cart.clear'), {
        preserveScroll: true,
        onSuccess: () => {
            loading.value = false;
        },
    });
}
</script>

<template>
  <Head title="Carrito de compras" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <section class="py-8 antialiased md:py-12">
      <div class="mx-auto max-w-screen-md px-4 2xl:px-0">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold">Carrito de compras</h2>
            <button v-if="cartItems.length > 1" @click="clearCart" class="px-4 py-2 text-white flex items-center gap-2 rounded hover:bg-red-600"><Trash /> Vaciar</button>
        </div>
        <div v-if="loading" class="text-center">Cargando...</div>
        <div v-else>
          <div v-if="cartItems.length > 0">
            <ul class="divide-y divide-gray-200 dark:divide-neutral-700">
              <li v-for="item in cartItems" :key="item.id" class="py-4 flex items-center justify-between">
                <div>
                  <div class="font-semibold">{{ item.product.name }}</div>
                  <div class="text-sm text-gray-500">{{ item.product.description }}</div>
                </div>
                <button @click="removeFromCart(item.id)" class="text-red-500 hover:underline cursor-pointer"><X /></button>
              </li>
            </ul>
            <div class="mt-6 flex justify-between">
              <button class="px-4 py-2 bg-neutral-600 text-white rounded-full hover:bg-neutral-700 w-full font-semibold">Comprar</button>
            </div>
          </div>
          <div v-else class="text-gray-500 text-center py-8 h-[calc(100vh-20rem)] flex flex-col gap-4 items-center justify-center">
            <ShoppingBag class="w-24 h-24 text-gray-400" aria-hidden="true" />
            Tu carrito está vacío.</div>
        </div>
      </div>
    </section>
  </AppLayout>
</template>
