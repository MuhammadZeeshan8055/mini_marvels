<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CheckoutPage extends Component
{
    public string $name = '';

    public string $email = '';

    public string $phone = '';

    public string $address = '';

    public string $note = '';

    public bool $terms = false;

    public bool $orderPlaced = false;

    public string $orderNumber = '';

    public function mount(): void
    {
        if (Cart::isEmpty() && ! $this->orderPlaced) {
            $this->redirect(route('cart'), navigate: true);

            return;
        }

        if (Auth::check()) {
            $user = Auth::user();
            $this->name = $user->name ?? '';
            $this->email = $user->email ?? '';
        }
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'phone' => ['required', 'string', 'min:7', 'max:25', 'regex:/^[0-9+()\-\s]+$/'],
            'address' => ['required', 'string', 'min:10', 'max:500'],
            'note' => ['nullable', 'string', 'max:1000'],
            'terms' => ['accepted'],
        ];
    }

    protected function messages(): array
    {
        return [
            'address.required' => 'Please enter your complete delivery address.',
            'address.min' => 'Please provide a little more detail in your address.',
            'phone.regex' => 'Please enter a valid phone number.',
            'terms.accepted' => 'Please agree to the terms before placing your order.',
        ];
    }

    public function placeOrder(): void
    {
        if (Cart::isEmpty()) {
            $this->redirect(route('cart'), navigate: true);

            return;
        }

        $this->validate();

        $items = Cart::items();
        $subtotal = Cart::subtotal();
        $discount = Cart::discount();
        $total = Cart::total();
        $coupon = Cart::coupon();

        $order = DB::transaction(function () use ($items, $subtotal, $discount, $total, $coupon) {
            $order = Order::create([
                'order_number' => $this->generateOrderNumber(),
                'user_id' => Auth::id(),
                'customer_name' => $this->name,
                'customer_email' => $this->email,
                'customer_phone' => $this->phone,
                'shipping_address' => $this->address,
                'note' => $this->note ?: null,
                'coupon_code' => $coupon,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'total' => $total,
                'payment_method' => 'cod',
                'status' => 'pending',
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'product_name' => $item['name'],
                    'product_slug' => $item['slug'] ?? null,
                    'color' => $item['color'] ?? null,
                    'image' => $item['image'] ?? null,
                    'unit_price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'line_total' => round($item['price'] * $item['quantity'], 2),
                ]);

                $product = Product::query()->find($item['id']);

                if ($product && $product->stock > 0) {
                    $product->decrement('stock', min($item['quantity'], $product->stock));
                }
            }

            return $order;
        });

        Cart::clear();
        $this->dispatch('cart-updated');

        $this->orderNumber = $order->order_number;
        $this->orderPlaced = true;
    }

    protected function generateOrderNumber(): string
    {
        do {
            $number = 'MM-'.now()->format('ymd').'-'.random_int(1000, 9999);
        } while (Order::query()->where('order_number', $number)->exists());

        return $number;
    }

    public function getItemsProperty(): array
    {
        return Cart::items();
    }

    public function getSubtotalProperty(): float
    {
        return Cart::subtotal();
    }

    public function getDiscountProperty(): float
    {
        return Cart::discount();
    }

    public function getTotalProperty(): float
    {
        return Cart::total();
    }

    public function render()
    {
        return view('livewire.checkout-page')->layout('layouts.app', [
            'title' => 'Checkout — Mini Marvels',
            'metaDescription' => 'Complete your Mini Marvels order.',
        ]);
    }
}
