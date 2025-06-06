<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

interface Product {
    id: number;
    name: string;
    description: string;
    stock: number;
}

defineProps<{ products: Product[] }>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Productos',
        href: '/products',
    },
];
</script>

<template>
  <Head title="Productos" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <section class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
      <div class="grid auto-rows-min gap-4 md:grid-cols-2 lg:grid-cols-4">
        <article
          v-for="product in products"
          :key="product.id"
          class="relative flex items-center justify-between overflow-hidden rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border"
        >
          <img src="https://picsum.photos/200" alt="Producto" class="size-20 rounded-xl" />
          <div>
            <h2 class="text-xl font-semibold">{{ product.name }}</h2>
            <p class="text-sm text-muted-foreground">{{ product.description }}</p>
            <p class="text-xl font-semibold">{{ product.stock }}</p>
          </div>
        </article>
      </div>
    </section>
  </AppLayout>
</template>
