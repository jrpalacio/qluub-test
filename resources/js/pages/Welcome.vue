<script setup lang="ts">
import { Head, Link, usePage } from '@inertiajs/vue3'
import { ref, defineProps, computed } from 'vue'
import { ShoppingCart, Menu, X, LogIn, UserPlus, LogOut } from 'lucide-vue-next'
import { router } from '@inertiajs/vue3';

const page = usePage()
const showMobileMenu = ref(false)

interface Product {
  id: number;
  name: string;
  description: string;
  stock: number;
}

defineProps({
  products: {
    type: Array<Product>,
    required: true,
  },
})

const user = computed(() => page.props.auth?.user ?? null)
const isAuthenticated = computed(() => !!user.value)
const isAdmin = computed(() => user.value?.role === 'admin')
const isClient = computed(() => user.value?.role === 'client')

function addToCart(productId: number) {
    router.post(route('cart.store'), { product_id: productId }, {
        preserveScroll: true,
        onSuccess: () => {

        },
    });
}
</script>

<template>
  <Head>
    <title>QLuub shop</title>
    <link rel="preconnect" href="https://rsms.me/" />
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
  </Head>

  <div class="flex min-h-screen flex-col items-center bg-[#FDFDFC] p-6 text-[#1b1b18] dark:bg-[#0a0a0a]">
    <!-- Header -->
    <header class="w-full text-sm border-b border-neutral-300/20 pb-4">
      <nav class="flex items-center justify-between gap-4">
        <!-- Logo -->
        <Link :href="route('home')" class="inline-block px-5 py-1.5">
          <img src="images/logo-qluub.png" alt="Logo QLuub" class="h-12 object-contain w-full" />
        </Link>

        <!-- Mobile Menu Button -->
        <div class="flex items-center gap-2">
            <template v-if="isAuthenticated && isClient">
                <Link :href="route('cart.index')" class="text-white flex items-center gap-2" @click="addToCart(product.id)">
                    <ShoppingCart class="h-5 w-5" /> Carrito
                </Link>
            </template>
            <button
                class="h-9 w-9 flex items-center justify-center text-[#1b1b18] dark:text-white"
                @click="showMobileMenu = !showMobileMenu"
                aria-label="Abrir menú"
                >
                <Menu />
            </button>
        </div>
      </nav>

      <!-- Mobile Menu -->
      <transition name="fade">
        <div
          v-if="showMobileMenu"
          class="fixed inset-0 z-50 flex  bg-black/40"
          role="dialog"
          aria-modal="true"
          aria-labelledby="mobile-menu-title"
        >
          <div class="bg-white dark:bg-neutral-900 w-64 h-full shadow-lg p-6 flex flex-col gap-4">
            <div class="flex justify-between items-center mb-4">
              <span id="mobile-menu-title" class="text-xl font-bold">QLuub</span>
              <button @click="showMobileMenu = false" class="text-gray-600 dark:text-gray-200" aria-label="Cerrar menú">
                <X />
              </button>
            </div>
            <template v-if="isAuthenticated && isAdmin">
              <Link
                :href="route('products.index')"
                class="flex items-center gap-4 rounded px-4 py-2 text-gray-900 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-neutral-800"
              >
                <ShoppingCart aria-hidden="true" /> Productos
              </Link>
            </template>
            <template v-else-if="isAuthenticated">
              <p class="text-sm font-medium text-gray-900 dark:text-white">{{ user.name }}</p>
              <Link
                :href="route('logout')"
                method="post"
                class="flex items-center gap-4 rounded px-4 py-2 text-gray-900 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-neutral-800"
              >
                <LogOut aria-hidden="true" /> Cerrar sesión
              </Link>
            </template>
            <template v-else>
              <Link
                :href="route('login')"
                class="flex items-center gap-4 rounded px-4 py-2 text-gray-900 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-neutral-800"
              >
                <LogIn aria-hidden="true" /> Inicia sesión
              </Link>
              <Link
                :href="route('register')"
                class="flex items-center gap-4 rounded px-4 py-2 text-gray-900 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-neutral-800"
              >
                <UserPlus aria-hidden="true" /> Regístrate
              </Link>
            </template>
          </div>
          <div class="flex-1" @click="showMobileMenu = false" />
        </div>
      </transition>
    </header>

    <!-- Main Content -->
    <main class="w-full max-w-6xl mx-auto mt-8">
      <template v-if="products.length > 0">
        <h1 class="text-3xl font-bold mb-8 text-gray-900 dark:text-white">Productos destacados</h1>
        <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
          <div
            v-for="product in products"
            :key="product.id"
            class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-neutral-800"
          >
            <div class="flex flex-col gap-2 items-start">
              <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                {{ product.name }}
              </h3>
              <p class="text-sm text-gray-500 dark:text-gray-400">{{ product.description }}</p>
              <span class="inline-block mt-2 px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                Stock: {{ product.stock }}
              </span>
              <button
                class="mt-4 px-4 py-2 bg-green-600 text-white rounded-full w-full hover:bg-green-700"
                @click="addToCart(product.id)"
              >
                Agregar al carrito
              </button>
            </div>
          </div>
        </div>
      </template>

      <template v-else>
        <div class="flex flex-col gap-3 items-center justify-center h-[calc(100vh-20rem)]">
          <ShoppingCart class="w-24 h-24 text-gray-400" aria-hidden="true" />
          <p class="text-gray-500 text-lg text-center lg:text-2xl">No hay productos disponibles por el momento.</p>
        </div>
      </template>
    </main>
  </div>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
