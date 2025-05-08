<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        return view('cart.index', compact('cart')); 
    }

    public function add(Request $request, $productId)
    {
        $product = Product::find($productId); 
        if (!$product) {
            return redirect()->back()->with('error', 'Produto não encontrado.');
        }

        $cart = Session::get('cart', []);

        if (isset($cart[$productId])) {

            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                'product' => $product,
                'quantity' => 1,
                'price' => $product->price
            ];
        }

        Session::put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Produto adicionado ao carrinho.');
    }
    public function remove($productId)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            Session::put('cart', $cart);
            return redirect()->route('cart.index')->with('success', 'Produto removido do carrinho.');
        }

        return redirect()->route('cart.index')->with('error', 'Produto não encontrado no carrinho.');
    }
    public function update(Request $request, $productId)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$productId])) {
            $quantity = $request->input('quantity');
            if ($quantity > 0) {
                $cart[$productId]['quantity'] = $quantity;
                Session::put('cart', $cart);
                return redirect()->route('cart.index')->with('success', 'Carrinho atualizado.');
            }
        }

        return redirect()->route('cart.index')->with('error', 'Quantidade inválida.');
    }
    public function clear()
    {
        Session::forget('cart');
        return redirect()->route('cart.index')->with('success', 'Carrinho limpo.');
    }
}
