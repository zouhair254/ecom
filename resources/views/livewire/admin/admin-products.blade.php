<div>
    @section('header', 'إدارة المنتجات')

    {{-- Header Actions --}}
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-brand-800">المنتجات ({{ $products->count() }})</h2>
        <button wire:click="openCreateForm" class="btn-primary flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            إضافة منتج
        </button>
    </div>

    {{-- Create/Edit Form Modal --}}
    @if($showForm)
        <div class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4" wire:click.self="cancelForm">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
                <div class="p-6 border-b border-brand-100 flex items-center justify-between">
                    <h3 class="text-xl font-bold text-brand-800">{{ $isEditing ? 'تعديل المنتج' : 'إضافة منتج جديد' }}</h3>
                    <button wire:click="cancelForm" class="text-brand-400 hover:text-brand-600 cursor-pointer">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form wire:submit="save" class="p-6 space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-brand-700 mb-2">اسم المنتج</label>
                        <input type="text" wire:model="name" class="input-field @error('name') !border-red-400 @enderror"
                            placeholder="مثال: جلابة مغربية تقليدية">
                        @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-brand-700 mb-2">وصف المنتج</label>
                        <textarea wire:model="description" rows="4"
                            class="input-field resize-none @error('description') !border-red-400 @enderror"
                            placeholder="أدخل وصفاً مفصلاً للمنتج"></textarea>
                        @error('description') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-brand-700 mb-2">السعر (د.م)</label>
                            <input type="number" wire:model="price" step="0.01"
                                class="input-field @error('price') !border-red-400 @enderror" placeholder="0.00">
                            @error('price') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-brand-700 mb-2">الكمية في المخزون</label>
                            <input type="number" wire:model="stock"
                                class="input-field @error('stock') !border-red-400 @enderror" placeholder="0">
                            @error('stock') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Product Images --}}
                    <div>
                        <label class="block text-sm font-semibold text-brand-700 mb-2">صورة المنتج الرئيسية</label>
                        @if($existingImage)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $existingImage) }}" class="w-24 h-24 rounded-xl object-cover"
                                    alt="الصورة الحالية">
                            </div>
                        @endif
                        <input type="file" wire:model="image" accept="image/*" class="file-input w-full">
                        @error('image') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-brand-700 mb-2">صور إضافية (معرض الصور)</label>
                        @if($isEditing && $editingProductId)
                            <div class="flex flex-wrap gap-2 mb-3">
                                @foreach(\App\Models\Product::find($editingProductId)->images as $img)
                                    <div class="relative group">
                                        <img src="{{ asset('storage/' . $img->image_path) }}"
                                            class="w-20 h-20 rounded-lg object-cover">
                                        <button type="button" wire:click="removeImage({{ $img->id }})"
                                            class="absolute top-0 right-0 bg-red-500 text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <input type="file" wire:model="newImages" multiple accept="image/*" class="file-input w-full">
                        @error('newImages.*') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Colors --}}
                    <div>
                        <label class="block text-sm font-semibold text-brand-700 mb-2">الألوان المتاحة</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach(['أبيض', 'أسود', 'أحمر', 'أخضر', 'أزرق', 'بيج', 'وردي', 'رمادي', 'بني', 'بنفسجي'] as $color)
                                <label
                                    class="cursor-pointer inline-flex items-center gap-2 bg-brand-50 px-3 py-1.5 rounded-full hover:bg-brand-100 transition-colors">
                                    <input type="checkbox" wire:model="colors" value="{{ $color }}"
                                        class="rounded text-brand-600 border-gray-300 focus:ring-brand-500">
                                    <span class="text-sm text-brand-700">{{ $color }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Sizes --}}
                    <div>
                        <label class="block text-sm font-semibold text-brand-700 mb-2">المقاسات المتاحة</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach(['S', 'M', 'L', 'XL', 'XXL', 'XXXL'] as $size)
                                <label
                                    class="cursor-pointer inline-flex items-center gap-2 bg-brand-50 px-3 py-1.5 rounded-full hover:bg-brand-100 transition-colors">
                                    <input type="checkbox" wire:model="sizes" value="{{ $size }}"
                                        class="rounded text-brand-600 border-gray-300 focus:ring-brand-500">
                                    <span class="text-sm text-brand-700 font-mono">{{ $size }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex items-center gap-3 pt-4">
                        <button type="submit" class="btn-primary flex-1">
                            {{ $isEditing ? 'تحديث المنتج' : 'إضافة المنتج' }}
                        </button>
                        <button type="button" wire:click="cancelForm" class="btn-secondary">إلغاء</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Delete Confirmation --}}
    @if($confirmingDelete)
        <div class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-8 text-center">
                <span class="text-5xl mb-4 block">⚠️</span>
                <h3 class="text-xl font-bold text-brand-800 mb-2">تأكيد الحذف</h3>
                <p class="text-brand-500 mb-6">هل أنت متأكد من حذف هذا المنتج؟ لا يمكن التراجع عن هذا الإجراء.</p>
                <div class="flex items-center gap-3 justify-center">
                    <button wire:click="deleteProduct" class="btn-danger px-6 py-3">نعم، احذف</button>
                    <button wire:click="cancelDelete" class="btn-secondary px-6 py-3">إلغاء</button>
                </div>
            </div>
        </div>
    @endif

    {{-- Products Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($products as $product)
            <div
                class="bg-white rounded-2xl shadow-sm border border-brand-100 overflow-hidden hover:shadow-lg transition-all duration-300">
                <div class="aspect-[4/3] overflow-hidden">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-brand-800 mb-1">{{ $product->name }}</h3>
                    <p class="text-sm text-brand-500 mb-3 line-clamp-2">{{ $product->description }}</p>
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-lg font-black text-brand-700">{{ number_format($product->price) }} د.م</span>
                        <span
                            class="text-sm px-3 py-1 rounded-full {{ $product->stock > 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                            المخزون: {{ $product->stock }}
                        </span>
                    </div>
                    <div class="flex items-center gap-2">
                        <button wire:click="editProduct({{ $product->id }})"
                            class="flex-1 bg-brand-100 text-brand-700 px-4 py-2 rounded-xl text-sm font-semibold hover:bg-brand-200 transition-colors cursor-pointer">
                            تعديل
                        </button>
                        <button wire:click="confirmDelete({{ $product->id }})"
                            class="bg-red-100 text-red-600 px-4 py-2 rounded-xl text-sm font-semibold hover:bg-red-200 transition-colors cursor-pointer">
                            حذف
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <span class="text-5xl mb-4 block">📦</span>
                <p class="text-lg text-brand-400">لا توجد منتجات بعد</p>
                <button wire:click="openCreateForm" class="btn-primary mt-4">أضف أول منتج</button>
            </div>
        @endforelse
    </div>
</div>