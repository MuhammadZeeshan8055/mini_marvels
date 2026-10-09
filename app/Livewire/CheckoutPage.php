<?php

namespace App\Livewire;

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

    public array $items = [
        [
            'name' => 'Light Weight Baby Stroller',
            'quantity' => 1,
            'price' => 24.85,
            'image' => 'https://images.unsplash.com/photo-1587654780291-39c9404d746b?w=160&h=160&fit=crop',
        ],
        [
            'name' => 'Wooden Rocking Horse',
            'quantity' => 1,
            'price' => 15.60,
            'image' => 'https://images.unsplash.com/photo-1594787318286-3d835c1d207f?w=160&h=160&fit=crop',
        ],
    ];

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
        $this->validate();

        $this->orderNumber = 'MM-'.now()->format('ymd').'-'.random_int(1000, 9999);
        $this->orderPlaced = true;
    }

    public function getTotalProperty(): float
    {
        return collect($this->items)->sum(
            fn (array $item) => $item['price'] * $item['quantity']
        );
    }

    public function render()
    {
        return view('livewire.checkout-page')->layout('layouts.app', [
            'title' => 'Checkout — Mini Marvels',
            'metaDescription' => 'Complete your Mini Marvels order.',
        ]);
    }
}
