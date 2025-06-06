<?php

use App\Models\Product;
use App\Models\User;

it('can create a product', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->post(route('products.store'), [
        'name' => 'Test',
        'description' => 'Desc',
        'stock' => 10,
    ]);

    $response->assertRedirect(route('products.index', absolute: false));
    expect(Product::where('name', 'Test')->exists())->toBeTrue();
});

it('can update a product', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $product = Product::factory()->create();

    $response = $this->put(route('products.update', $product->id), [
        'name' => 'Updated',
        'description' => 'Updated desc',
        'stock' => 5,
    ]);

    $response->assertRedirect(route('products.index', absolute: false));
    expect($product->refresh()->name)->toBe('Updated');
});

it('can delete a product', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $product = Product::factory()->create();

    $response = $this->delete(route('products.destroy', $product->id));

    $response->assertRedirect(route('products.index', absolute: false));
    expect(Product::find($product->id))->toBeNull();
});
