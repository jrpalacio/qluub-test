<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';

import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import InputError from '@/components/InputError.vue';
import { defineProps } from 'vue';

import { LoaderCircle } from 'lucide-vue-next';

import { useForm } from '@inertiajs/vue3';
import { Head, Link } from '@inertiajs/vue3';

import { ChevronLeft } from 'lucide-vue-next';


const breadcrumbs: BreadcrumbItem[] = [
  {
      title: 'Editar producto',
      href: '/products/edit',
  },
];

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    name: props.product.name,
    description: props.product.description,
    stock: props.product.stock,
});

const submit = () => {
    form.patch(route('products.update', props.product.id), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
  <Head title="Editar producto" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <section class="py-8 antialiased md:py-12">
        <div class="mx-auto max-w-lg px-4">
            <!-- Heading & Filters -->
            <div class="flex items-center gap-2 mb-4">
                <Link href="/products" class="p-2">
                    <ChevronLeft />
                </Link>
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Editar producto</h2>
            </div>

            <form @submit.prevent="submit" class="flex flex-col gap-6">
                <div class="grid gap-6">
                    <div class="grid gap-2">
                        <Label for="name">Nombre</Label>
                        <Input
                        id="name"
                        type="text"
                        required
                        autofocus
                        :tabindex="1"
                        autocomplete="name"
                        v-model="form.name"
                        placeholder=""
                        />
                        <InputError :message="form.errors.name" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="description">Descripción</Label>
                        <Input
                        id="description"
                        type="text"
                        required
                        autofocus
                        :tabindex="2"
                        autocomplete="description"
                        v-model="form.description"
                        placeholder=""
                        />
                        <InputError :message="form.errors.description" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="stock">Stock</Label>
                        <Input
                        id="stock"
                        type="number"
                        required
                        autofocus
                        :tabindex="3"
                        autocomplete="stock"
                        v-model="form.stock"
                        placeholder=""
                        />
                        <InputError :message="form.errors.stock" />
                    </div>

                    <Button type="submit" class="mt-4 w-full" :tabindex="4" :disabled="form.processing">
                        <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                        Actualizar
                    </Button>
                </div>
            </form>

        </div>

</section>
  </AppLayout>
</template>
