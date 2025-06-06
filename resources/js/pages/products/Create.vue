<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { LoaderCircle } from 'lucide-vue-next';

const form = useForm({
    name: '',
    description: '',
    stock: 0,
});

const breadcrumbs: BreadcrumbItem[] = [
  {
      title: 'Nuevo registro',
      href: '/products/create',
  },
];
</script>

<template>
  <Head title="Nuevo registro" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <section class="flex h-full flex-1 flex-col gap-4  p-4  ">
      <form @submit.prevent="form.post(route('products.store'))" class="flex flex-col gap-6 max-w-lg">
          <div class="grid gap-2">
              <div class="grid gap-1">
                  <Label for="name">Nombre</Label>
                  <Input
                      id="name"
                      type="text"
                      required
                      autofocus
                      :tabindex="1"
                      autocomplete="name"
                      v-model="form.name"
                      class="border border-neutral-600 rounded-lg p-2"
                  />
                  <InputError :message="form.errors.name" />
              </div>

              <div class="grid gap-1">
                  <Label for="description">Descripción</Label>
                  <Input
                      id="description"
                      type="text"
                      required
                      autofocus
                      :tabindex="2"
                      autocomplete="description"
                      v-model="form.description"
                      class="border border-neutral-600 rounded-lg p-2"
                  />
                  <InputError :message="form.errors.description" />
              </div>

              <div class="grid gap-1">
                  <Label for="stock">Strock</Label>
                  <Input
                          id="stock"
                          type="number"
                          required
                          autofocus
                          :tabindex="3"
                          autocomplete="stock"
                          v-model="form.stock"
                          class="border border-neutral-600 rounded-lg p-2"
                      />
                      <InputError :message="form.errors.stock" />
              </div>

              <Button type="submit" class="mt-4 w-full bg-neutral-500 rounded-lg p-2" :tabindex="4" :disabled="form.processing">
                  <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                  Registrar
              </Button>
          </div>
        </form>
    </section>
  </AppLayout>
</template>
