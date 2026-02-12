<x-layouts.app :title="$product->name . ' - جلابة'">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Breadcrumb --}}
        <nav class="mb-8">
            <ol class="flex items-center gap-2 text-sm text-brand-500">
                <li><a href="{{ route('home') }}" class="hover:text-brand-700 transition-colors">الرئيسية</a></li>
                <li><span class="mx-1">/</span></li>
                <li><a href="{{ route('home') }}#products" class="hover:text-brand-700 transition-colors">المنتجات</a>
                </li>
                <li><span class="mx-1">/</span></li>
                <li class="text-brand-800 font-semibold">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            {{-- Product Image --}}
            {{-- Product Image Gallery --}}
            <div class="relative group" x-data="{ activeImage: '{{ $product->image_url }}' }">
                <div class="rounded-2xl overflow-hidden shadow-xl bg-white aspect-[3/4] mb-4">
                    <img :src="activeImage" alt="{{ $product->name }}"
                        class="w-full h-full object-cover transition-all duration-500">
                </div>

                {{-- Thumbnails --}}
                @if($product->images->count() > 0)
                    <div class="flex gap-2 overflow-x-auto pb-2">
                        <button @click="activeImage = '{{ $product->image_url }}'"
                            class="shrink-0 w-20 h-20 rounded-lg overflow-hidden border-2 transition-all"
                            :class="activeImage === '{{ $product->image_url }}' ? 'border-brand-500 hover:opacity-100' : 'border-transparent opacity-70 hover:opacity-100'">
                            <img src="{{ $product->image_url }}" class="w-full h-full object-cover">
                        </button>
                        @foreach($product->images as $image)
                            <button @click="activeImage = '{{ $image->image_url }}'"
                                class="shrink-0 w-20 h-20 rounded-lg overflow-hidden border-2 transition-all"
                                :class="activeImage === '{{ $image->image_url }}' ? 'border-brand-500 hover:opacity-100' : 'border-transparent opacity-70 hover:opacity-100'">
                                <img src="{{ $image->image_url }}" class="w-full h-full object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif

                @if($product->inStock())
                    <span
                        class="absolute top-4 start-4 bg-emerald-500 text-white text-sm font-bold px-4 py-2 rounded-full shadow-lg">
                        متوفر في المخزون
                    </span>
                @else
                    <span
                        class="absolute top-4 start-4 bg-red-500 text-white text-sm font-bold px-4 py-2 rounded-full shadow-lg">
                        غير متوفر حالياً
                    </span>
                @endif
            </div>

            {{-- Product Info & Order Form --}}
            <div class="space-y-6">
                <div class="animate-fade-in-up">
                    <h1 class="text-3xl sm:text-4xl font-black text-brand-800 mb-4">{{ $product->name }}</h1>
                    <div class="flex items-baseline gap-2 mb-6">
                        <span class="text-4xl font-black text-brand-700">{{ number_format($product->price) }}</span>
                        <span class="text-lg font-medium text-brand-500">د.م</span>
                    </div>
                </div>

                <div
                    class="bg-white rounded-2xl p-6 shadow-sm border border-brand-100 animate-fade-in-up animation-delay-100">
                    <h3 class="text-lg font-bold text-brand-800 mb-3">وصف المنتج</h3>
                    <p class="text-brand-600 leading-loose">{{ $product->description }}</p>
                </div>

                <div
                    class="bg-white rounded-2xl p-6 shadow-sm border border-brand-100 animate-fade-in-up animation-delay-200">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="text-brand-600">📦</span>
                        <span class="font-semibold text-brand-700">المخزون:</span>
                        <span class="text-brand-600">{{ $product->stock }} قطعة متوفرة</span>
                    </div>
                </div>

                {{-- Order Form --}}
                @if($product->inStock())
                    <div class="animate-fade-in-up animation-delay-300">
                        <livewire:order-form :product="$product" />
                    </div>
                @else
                    <div class="bg-red-50 border border-red-200 rounded-2xl p-6 text-center">
                        <p class="text-red-600 font-semibold text-lg">هذا المنتج غير متوفر حالياً</p>
                        <p class="text-red-400 mt-2">يرجى التواصل معنا للاستفسار عن موعد التوفر</p>
                    </div>
                @endif

                {{-- WhatsApp Button --}}
                <a href="https://wa.me/{{ config('app.whatsapp_number', '212600000000') }}?text={{ urlencode('أرغب في طلب هذا المنتج: ' . $product->name) }}"
                    target="_blank"
                    class="flex items-center justify-center gap-3 w-full bg-emerald-500 text-white py-4 rounded-xl font-bold text-lg hover:bg-emerald-600 transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                    </svg>
                    اطلبي عبر واتساب
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>