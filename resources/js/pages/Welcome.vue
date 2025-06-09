<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ref, defineProps } from 'vue';
import { ShoppingCart, Menu, X, LogIn, UserPlus } from 'lucide-vue-next';

const showMobileMenu = ref(false);

const props = defineProps({
    products: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <Head title="Welcome">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <div class="flex min-h-screen flex-col items-center bg-[#FDFDFC] p-6 text-[#1b1b18] dark:bg-[#0a0a0a]">
        <header class="not-has-[nav]:hidden  w-full  text-sm border-b border-neutral-300/20 pb-4">
            <nav class="flex items-center justify-between gap-4">
                <Link
                    :href="route('home')"
                    class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-md font-semibold leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] "
                >
                <img src="images/logo-qluub.png" alt="Logo QLuub" class="w-full object-contain h-12" >

                </Link>
                <Button variant="ghost" size="icon" class="group h-9 w-9 cursor-pointer lg:hidden dark:text-white text-[#1b1b18]" @click="showMobileMenu = !showMobileMenu">
                    <Menu />
                </Button>
                <!-- Menú móvil -->
                <transition name="fade">
                    <div v-if="showMobileMenu" class="fixed inset-0 z-50 bg-black/40 flex lg:hidden">
                        <div class="bg-white dark:bg-neutral-900 w-64 h-full shadow-lg p-6 flex flex-col gap-4">
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-xl font-bold">QLuub</span>
                                <button @click="showMobileMenu = false" class="text-2xl font-bold text-gray-600 dark:text-gray-200"><X /></button>
                            </div>
                            <Link v-if="$page.props.auth.user" :href="route('products.index')" class="flex items-center gap-4 rounded px-4 py-2 text-left text-gray-900 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-neutral-800">
                                <ShoppingCart /> Productos
                            </Link>
                            <template v-else>
                                <Link :href="route('login')" class="flex items-center gap-4 rounded px-4 py-2 text-left text-gray-900 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-neutral-800">
                                    <LogIn /> Iniciar sesión
                                </Link>
                                <Link :href="route('register')" class="flex items-center gap-4 rounded px-4 py-2 text-left text-gray-900 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-neutral-800">
                                    <UserPlus /> Registrarse
                                </Link>
                            </template>
                        </div>
                        <div class="flex-1" @click="showMobileMenu = false"></div>
                    </div>
                </transition>
        <!-- Menú escritorio -->
        <div class="lg:flex lg:items-center lg:gap-2 hidden">
            <Link
            v-if="$page.props.auth.user && $page.props.auth.user.role === 'admin'"
            :href="route('products.index')"
            class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
        >
            Productos
            </Link>
            <template v-else>
                <Link
                    :href="route('login')"
                    class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                >
                    Iniciar sesión
                </Link>
                <Link
                    :href="route('register')"
                    class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                >
                    Registrarse
                </Link>
            </template>
        </div>
            </nav>
        </header>
        <div class="w-full max-w-6xl mx-auto mt-8">
            <h1 class="text-3xl font-bold mb-8 text-gray-900 dark:text-white" v-if="products.length > 0" >Productos destacados</h1>
            <div v-if="products.length > 0" class="grid gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                <div v-for="product in products" :key="product.id" class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-neutral-800">
                    <div class="flex flex-col gap-2 items-start">
                        <h3 class="text-lg font-semibold leading-tight text-gray-900 dark:text-white">{{ product.name }}</h3>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ product.description }}</p>
                        <span class="inline-block mt-2 px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Stock: {{ product.stock }}</span>
                    </div>
                </div>
            </div>
            <div v-else class="flex flex-col gap-3 items-center justify-center h-[calc(100vh-20rem)]">
                <ShoppingCart class="w-24 h-24 text-gray-400" />
                <p class="text-gray-500 text-lg text-center lg:text-2xl">No hay productos disponibles por el momento.</p>
            </div>
        </div>
    </div>
</template>
