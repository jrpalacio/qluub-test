<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CartController extends Controller
{
    // Listar items del carrito del usuario autenticado
    public function index()
{
    $cartItems = CartItem::with('product')
        ->where('user_id', auth()->id())
        ->get();

    return Inertia::render('Cart', [
        'cartItems' => $cartItems,
    ]);
}

    // Agregar producto al carrito
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        CartItem::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'reserved' => true,
        ]);

        return redirect()->route('cart.index');
    }

    // Quitar producto del carrito
    public function destroy($id)
    {
        $item = CartItem::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $item->delete();
        return redirect()->route('cart.index');
    }

    // Vaciar carrito
    public function clear()
    {
        CartItem::where('user_id', Auth::id())->delete();
        return redirect()->route('cart.index');
    }

    // Comprar: descuenta stock y vacía el carrito
    public function purchase()
    {
        $userId = auth()->id();

        $cartItems = CartItem::with('product')
            ->where('user_id', $userId)
            ->get();

        if ($cartItems->isEmpty()) {
            return back()->withErrors('El carrito está vacío.');
        }

        foreach ($cartItems as $item) {
            if ($item->product->stock < 1) {
                return back()->withErrors("El producto {$item->product->name} no tiene stock suficiente.");
            }
        }

        // Crear la compra
        $purchase = \App\Models\Purchase::create([
            'user_id' => $userId,
        ]);

        foreach ($cartItems as $item) {
            // Descontar stock
            $item->product->decrement('stock');
            // Crear el ítem de compra
            \App\Models\PurchaseItem::create([
                'purchase_id' => $purchase->id,
                'product_id' => $item->product->id,
                'quantity' => 1, // Si tienes cantidad, cámbialo aquí
                // 'price' => $item->product->price, // Si tienes campo price
            ]);
            $item->update(['reserved' => true]);
        }

        CartItem::where('user_id', $userId)->delete();

        return redirect()->route('cart.index')->with('success', 'Compra realizada con éxito.');
    }

}
