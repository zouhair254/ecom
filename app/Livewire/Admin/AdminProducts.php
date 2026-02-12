<?php

namespace App\Livewire\Admin;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class AdminProducts extends Component
{
    use WithFileUploads;

    public bool $showForm = false;
    public bool $isEditing = false;
    public ?int $editingProductId = null;

    public string $name = '';
    public string $description = '';
    public string $price = '';
    public string $stock = '';
    public $image;
    public ?string $existingImage = null;
    public $newImages = [];
    public $colors = [];
    public $sizes = [];

    public bool $confirmingDelete = false;
    public ?int $deletingProductId = null;

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'description' => ['required', 'string', 'min:10'],
            'price' => ['required', 'numeric', 'min:1'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => $this->isEditing ? ['nullable', 'image', 'max:2048'] : ['nullable', 'image', 'max:2048'],
        ];
    }

    protected function messages(): array
    {
        return [
            'name.required' => 'اسم المنتج مطلوب.',
            'name.min' => 'اسم المنتج يجب أن يكون 3 أحرف على الأقل.',
            'description.required' => 'وصف المنتج مطلوب.',
            'description.min' => 'الوصف يجب أن يكون 10 أحرف على الأقل.',
            'price.required' => 'السعر مطلوب.',
            'price.numeric' => 'السعر يجب أن يكون رقماً.',
            'price.min' => 'السعر يجب أن يكون أكبر من 0.',
            'stock.required' => 'الكمية مطلوبة.',
            'stock.integer' => 'الكمية يجب أن تكون عدداً صحيحاً.',
            'stock.min' => 'الكمية لا يمكن أن تكون أقل من 0.',
            'image.image' => 'الملف يجب أن يكون صورة.',
            'image.max' => 'حجم الصورة يجب أن لا يتجاوز 2 ميجابايت.',
            'newImages.*.image' => 'كل ملف يجب أن يكون صورة.',
            'newImages.*.max' => 'حجم كل صورة يجب أن لا يتجاوز 2 ميجابايت.',
        ];
    }

    public function mount()
    {
        // Initialize default sizes if needed or leave empty
    }

    public function openCreateForm(): void
    {
        $this->resetForm();
        $this->showForm = true;
        $this->isEditing = false;
    }

    public function editProduct(int $id): void
    {
        $product = Product::findOrFail($id);
        $this->editingProductId = $product->id;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->price = (string) $product->price;
        $this->stock = (string) $product->stock;
        $this->colors = $product->colors ?? [];
        $this->sizes = $product->sizes ?? [];
        $this->existingImage = $product->image;
        $this->image = null;
        $this->newImages = [];
        $this->showForm = true;
        $this->isEditing = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'slug' => Str::slug($this->name, '-', null),
            'description' => $this->description,
            'price' => $this->price,
            'stock' => $this->stock,
            'colors' => $this->colors,
            'sizes' => $this->sizes,
        ];

        if ($this->image) {
            $data['image'] = $this->image->store('products', 'public');
        }

        if ($this->isEditing && $this->editingProductId) {
            $product = Product::findOrFail($this->editingProductId);
            $product->update($data);

            // Handle new additional images
            if (!empty($this->newImages)) {
                foreach ($this->newImages as $img) {
                    $product->images()->create([
                        'image_path' => $img->store('product_images', 'public')
                    ]);
                }
            }

            $this->dispatch('toast', message: 'تم تحديث المنتج بنجاح');
        } else {
            $product = Product::create($data);

            // Handle main image as first gallery image too? Optional.
            // Handle additional images
            if (!empty($this->newImages)) {
                foreach ($this->newImages as $img) {
                    $product->images()->create([
                        'image_path' => $img->store('product_images', 'public')
                    ]);
                }
            }

            $this->dispatch('toast', message: 'تم إضافة المنتج بنجاح');
        }

        $this->resetForm();
    }

    public function confirmDelete(int $id): void
    {
        $this->confirmingDelete = true;
        $this->deletingProductId = $id;
    }

    public function deleteProduct(): void
    {
        if ($this->deletingProductId) {
            Product::findOrFail($this->deletingProductId)->delete();
            $this->dispatch('toast', message: 'تم حذف المنتج بنجاح');
        }
        $this->confirmingDelete = false;
        $this->deletingProductId = null;
    }

    public function cancelDelete(): void
    {
        $this->confirmingDelete = false;
        $this->deletingProductId = null;
    }

    public function cancelForm(): void
    {
        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->showForm = false;
        $this->isEditing = false;
        $this->editingProductId = null;
        $this->name = '';
        $this->description = '';
        $this->price = '';
        $this->stock = '';
        $this->image = null;
        $this->existingImage = null;
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.admin.admin-products', [
            'products' => Product::latest()->get(),
        ])->layout('components.layouts.admin');
    }
}
