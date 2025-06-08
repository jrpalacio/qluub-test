<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { defineProps } from 'vue';

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
    <div class="flex min-h-screen flex-col items-center bg-[#FDFDFC] p-6 text-[#1b1b18] dark:bg-[#0a0a0a] lg:justify-center lg:p-8">
        <header class="not-has-[nav]:hidden mb-6 w-full max-w-[335px] text-sm lg:max-w-4xl">
            <nav class="flex items-center justify-end gap-4">
                <Link
                    :href="route('home')"
                    class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                >
                    QLuub
                </Link>
                <Link
                    v-if="$page.props.auth.user"
                    :href="route('dashboard')"
                    class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                >
                    Dashboard
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
            </nav>
        </header>
        <div class="w-full max-w-6xl mx-auto mt-8">
            <h1 class="text-3xl font-bold text-center mb-8 text-gray-900 dark:text-white">Productos destacados</h1>
            <div v-if="products.length > 0" class="grid gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                <div v-for="product in products" :key="product.id" class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-neutral-800">
                    <div class="flex flex-col gap-2 items-start">
                        <h3 class="text-lg font-semibold leading-tight text-gray-900 dark:text-white">{{ product.name }}</h3>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ product.description }}</p>
                        <span class="inline-block mt-2 px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Stock: {{ product.stock }}</span>
                    </div>
                </div>
            </div>
            <div v-else class="flex items-center justify-center mt-12">
                <p class="text-gray-500 text-lg">No hay productos disponibles por el momento.</p>
            </div>
        </div>
    </div>
</template>
