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
            'reserved' => false,
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
}
