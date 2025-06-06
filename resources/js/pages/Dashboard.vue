<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
  {
      title: 'Productos',
      href: '/dashboard',
  },
];
</script>

<template>
  <Head title="Dashboard" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <section class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
        <div class="grid auto-rows-min gap-4 md:grid-cols-2 lg:grid-cols-4">
            <article class="relative overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-4 flex items-center justify-between">

                <img src="https://picsum.photos/200" alt="Producto" class="size-20 rounded-xl" />
                <div>
                    <h2 class="text-xl font-semibold">Nombre del producto</h2>
                    <p class="text-sm text-muted-foreground">Descripción del producto</p>
                    <p class="text-xl font-semibold">1000</p>
                </div>
            </article>
        </div>
    </section>
  </AppLayout>
</template>
