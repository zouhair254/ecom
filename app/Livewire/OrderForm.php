<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\Product;
use Livewire\Component;

class OrderForm extends Component
{
    public Product $product;

    public string $name = '';
    public string $phone = '';
    public string $address = '';
    public string $city = '';
    public int $quantity = 1;
    public ?string $color = null;
    public ?string $size = null;

    public function mount(Product $product): void
    {
        $this->product = $product;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'phone' => ['required', 'regex:/^(0|\+212|212)[5-7]\d{8}$/'],
            'address' => ['required', 'string', 'min:5', 'max:500'],
            'city' => ['required', 'string', 'min:2', 'max:100'],
            'quantity' => ['required', 'integer', 'min:1', 'max:' . $this->product->stock],
            'color' => !empty($this->product->colors) ? ['required', 'string'] : ['nullable'],
            'size' => !empty($this->product->sizes) ? ['required', 'string'] : ['nullable'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'الاسم الكامل مطلوب.',
            'name.min' => 'الاسم يجب أن يكون 3 أحرف على الأقل.',
            'phone.required' => 'رقم الهاتف مطلوب.',
            'phone.regex' => 'يرجى إدخال رقم هاتف مغربي صحيح.',
            'address.required' => 'العنوان مطلوب.',
            'address.min' => 'العنوان يجب أن يكون 5 أحرف على الأقل.',
            'city.required' => 'المدينة مطلوبة.',
            'city.min' => 'اسم المدينة يجب أن يكون حرفين على الأقل.',
            'quantity.required' => 'الكمية مطلوبة.',
            'quantity.min' => 'الكمية يجب أن تكون 1 على الأقل.',
            'quantity.max' => 'الكمية المطلوبة غير متوفرة في المخزون.',
            'color.required' => 'يرجى اختيار اللون.',
            'size.required' => 'يرجى اختيار المقاس.',
        ];
    }

    public function increment(): void
    {
        if ($this->quantity < $this->product->stock) {
            $this->quantity++;
        }
    }

    public function decrement(): void
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function submitOrder(): void
    {
        $this->validate();

        Order::create([
            'product_id' => $this->product->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'address' => $this->address,
            'city' => $this->city,
            'quantity' => $this->quantity,
            'color' => $this->color,
            'size' => $this->size,
        ]);

        $this->product->decrement('stock', $this->quantity);

        $this->reset(['name', 'phone', 'address', 'city', 'color', 'size']);
        $this->quantity = 1;

        $this->dispatch('toast', message: 'شكراً لك، سنقوم بالتواصل معك قريباً');
    }

    public function render()
    {
        return view('livewire.order-form');
    }
}
