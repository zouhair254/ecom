<div class="bg-white rounded-2xl p-6 shadow-sm border border-brand-100">
    <h3 class="text-xl font-bold text-brand-800 mb-6 flex items-center gap-2">
        <span>📝</span>
        اطلبي الآن
    </h3>

    <form wire:submit="submitOrder" class="space-y-5">
        {{-- Name --}}
        <div>

            {{-- Options Selection --}}
            @if(!empty($product->colors))
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-brand-700 mb-2">اللون</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach($product->colors as $c)
                            <button type="button" wire:click="$set('color', '{{ $c }}')"
                                class="px-4 py-2 rounded-lg border-2 text-sm font-medium transition-all {{ $color === $c ? 'border-brand-500 bg-brand-50 text-brand-700 shadow-sm' : 'border-gray-200 text-gray-600 hover:border-brand-200' }}">
                                {{ $c }}
                            </button>
                        @endforeach
                    </div>
                    @error('color') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            @endif

            @if(!empty($product->sizes))
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-brand-700 mb-2">المقاس</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach($product->sizes as $s)
                            <button type="button" wire:click="$set('size', '{{ $s }}')"
                                class="w-10 h-10 rounded-lg border-2 text-sm font-bold flex items-center justify-center transition-all {{ $size === $s ? 'border-brand-500 bg-brand-50 text-brand-700 shadow-sm' : 'border-gray-200 text-gray-600 hover:border-brand-200' }}">
                                {{ $s }}
                            </button>
                        @endforeach
                    </div>
                    @error('size') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            @endif

            <label for="name" class="block text-sm font-semibold text-brand-700 mb-2">الاسم الكامل</label>
            <input type="text" id="name" wire:model="name" placeholder="أدخلي اسمك الكامل"
                class="input-field @error('name') !border-red-400 !ring-red-100 @enderror">
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Phone --}}
        <div>
            <label for="phone" class="block text-sm font-semibold text-brand-700 mb-2">رقم الهاتف</label>
            <input type="tel" id="phone" wire:model="phone" placeholder="06XXXXXXXX" dir="ltr" class="text-right"
                class="input-field @error('phone') !border-red-400 !ring-red-100 @enderror">
            @error('phone')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Address --}}
        <div>
            <label for="address" class="block text-sm font-semibold text-brand-700 mb-2">العنوان</label>
            <textarea id="address" wire:model="address" rows="2" placeholder="أدخلي عنوانك الكامل"
                class="input-field resize-none @error('address') !border-red-400 !ring-red-100 @enderror"></textarea>
            @error('address')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- City --}}
        <div>
            <label for="city" class="block text-sm font-semibold text-brand-700 mb-2">المدينة</label>
            <input type="text" id="city" wire:model="city" placeholder="مثال: الدار البيضاء"
                class="input-field @error('city') !border-red-400 !ring-red-100 @enderror">
            @error('city')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Quantity --}}
        <div>
            <label class="block text-sm font-semibold text-brand-700 mb-2">الكمية</label>
            <div class="flex items-center gap-3">
                <button type="button" wire:click="decrement"
                    class="w-10 h-10 rounded-xl bg-brand-100 text-brand-700 font-bold text-xl hover:bg-brand-200 transition-colors cursor-pointer flex items-center justify-center">
                    −
                </button>
                <span class="w-14 text-center text-lg font-bold text-brand-800">{{ $quantity }}</span>
                <button type="button" wire:click="increment"
                    class="w-10 h-10 rounded-xl bg-brand-100 text-brand-700 font-bold text-xl hover:bg-brand-200 transition-colors cursor-pointer flex items-center justify-center">
                    +
                </button>
            </div>
            @error('quantity')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Total --}}
        <div class="bg-brand-50 rounded-xl p-4 flex items-center justify-between">
            <span class="font-semibold text-brand-700">المجموع:</span>
            <span class="text-2xl font-black text-brand-800">{{ number_format($product->price * $quantity) }} <span
                    class="text-sm font-medium">د.م</span></span>
        </div>

        {{-- Submit --}}
        <button type="submit" wire:loading.attr="disabled"
            class="w-full btn-primary text-lg py-4 flex items-center justify-center gap-2 disabled:opacity-50">
            <span wire:loading.remove>
                تأكيد الطلب 🛒
            </span>
            <span wire:loading class="flex items-center gap-2">
                <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
                جاري الإرسال...
            </span>
        </button>
    </form>
</div>