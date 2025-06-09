<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { defineProps } from 'vue';
import { Box, Trash2, Pencil } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
	{
        title: 'Productos',
        href: '/products',
	},
];

defineProps({
    products: {
        type: Array,
        required: true,
    },
});

function addToCart(productId) {
    fetch('/cart', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        },
        body: JSON.stringify({ product_id: productId }),
    })
    .then(res => {
        if(res.ok) alert('Producto agregado al carrito');
        else alert('Error al agregar');
    });
}

</script>

<template>
	<Head title="Productos" />

	<AppLayout :breadcrumbs="breadcrumbs">
		<section class="py-8 antialiased md:py-12">
			<div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
				<!-- Heading & Filters -->
				<div class="mb-4 items-end justify-between space-y-4 sm:flex sm:space-y-0 md:mb-8">
                    <h2 class="mt-3 text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Productos</h2>
                    <template v-if="$page.props.auth.user && $page.props.auth.user.role === 'admin'">
                        <Link href="/products/create" class="rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700">Agregar producto</Link>
                    </template>
				</div>
				<div v-if="products.length > 0" class="mb-4 grid gap-4 sm:grid-cols-2 md:mb-8 lg:grid-cols-3 xl:grid-cols-4 mt-8">
                    <div v-for="product in products" :key="product.id" class="relative rounded-3xl border border-gray-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-neutral-800">
                        <div class="pt-6">
                            <div class="absolute top-2 right-2 flex gap-1">
                                <template v-if="$page.props.auth.user && $page.props.auth.user.role === 'admin'">
                                    <Link :href="route('products.edit', product.id)" method="get" as="button"
                                    class="rounded-2xl object-contain px-2 py-2 text-sm font-medium text-blue-600 hover:bg-blue-200 hover:text-blue-800 focus:z-10 focus:outline-none focus:ring-4 focus:ring-blue-100 dark:border-neutral-600 dark:bg-neutral-800 transition-colors dark:text-blue-200 dark:hover:bg-blue-700 dark:hover:text-white dark:focus:ring-blue-700">
                                        <Pencil />
                                    </Link>
                                    <Link :href="route('products.destroy', product.id)"
                                    method="delete"
                                    as="button"
                                    class="rounded-2xl object-contain px-2 py-2 text-sm font-medium text-red-600 hover:bg-red-200 hover:text-red-800 focus:z-10 focus:outline-none focus:ring-4 focus:ring-red-100 dark:border-red-600 dark:bg-neutral-800 transition-colors dark:text-red-200 dark:hover:bg-red-700 dark:hover:text-white dark:focus:ring-red-700"
                                    >
                                        <Trash2 />
                                    </Link>
                                </template>
                            </div>

                            <div class="flex items-center gap-4 mt-6">
                                <Box />
                                <h3 class="text-lg font-semibold leading-tight text-gray-900 dark:text-white">{{ product.name }}</h3>
                            </div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mt-2">{{ product.description }}</p>
                            <div class="flex justify-between items-center mt-6">
    <p class="font-extrabold leading-tight text-gray-900 dark:text-white">{{ product.stock }} U.</p>
    <button
        v-if="$page.props.auth.user && $page.props.auth.user.role === 'client'"
        @click="addToCart(product.id)"
        class="ml-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
    >
        Agregar al carrito
    </button>
</div>
                        </div>
                    </div>
				</div>
                <div class="flex items-center justify-center mt-8" v-else>
                    <p class="text-gray-500">No hay productos</p>
                </div>
			</div>
		</section>
	</AppLayout>
</template>
