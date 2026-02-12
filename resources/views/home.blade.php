<x-layouts.app title="جلابة - أزياء مغربية أصيلة">
    {{-- Hero Section --}}
    <section
        class="relative overflow-hidden bg-gradient-to-bl from-brand-800 via-brand-700 to-brand-900 min-h-[70vh] flex items-center">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-10 right-10 w-72 h-72 bg-white rounded-full blur-3xl animate-float"></div>
            <div
                class="absolute bottom-10 left-10 w-96 h-96 bg-brand-400 rounded-full blur-3xl animate-float animation-delay-200">
            </div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
            <span class="inline-block text-6xl mb-6 animate-fade-in-up">🧵</span>
            <h1
                class="text-5xl sm:text-6xl md:text-7xl font-black text-white mb-6 animate-fade-in-up animation-delay-100">
                جلابة
            </h1>
            <p
                class="text-xl sm:text-2xl text-brand-200 max-w-2xl mx-auto mb-10 leading-relaxed animate-fade-in-up animation-delay-200">
                اكتشفي أناقة الأصالة المغربية مع تشكيلتنا الفاخرة من الجلابات التقليدية والعصرية
            </p>
            <a href="#products"
                class="inline-block btn-primary text-lg px-10 py-4 animate-fade-in-up animation-delay-300">
                تصفحي المجموعة ✨
            </a>
        </div>
    </section>

    {{-- Features Bar --}}
    <section class="bg-white border-b border-brand-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                <div class="flex flex-col items-center gap-2">
                    <span class="text-2xl">🚚</span>
                    <span class="text-sm font-semibold text-brand-700">توصيل لجميع المدن</span>
                </div>
                <div class="flex flex-col items-center gap-2">
                    <span class="text-2xl">⭐</span>
                    <span class="text-sm font-semibold text-brand-700">جودة عالية</span>
                </div>
                <div class="flex flex-col items-center gap-2">
                    <span class="text-2xl">🧵</span>
                    <span class="text-sm font-semibold text-brand-700">تطريز يدوي</span>
                </div>
                <div class="flex flex-col items-center gap-2">
                    <span class="text-2xl">💎</span>
                    <span class="text-sm font-semibold text-brand-700">تصاميم حصرية</span>
                </div>
            </div>
        </div>
    </section>

    {{-- Products Section --}}
    <section id="products" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center mb-12">
            <h2 class="text-3xl sm:text-4xl font-black text-brand-800 mb-4">تشكيلتنا المميزة</h2>
            <p class="text-brand-500 text-lg max-w-xl mx-auto">اختاري من بين أجمل الجلابات المغربية المصنوعة بعناية ودقة
            </p>
            <div class="w-24 h-1 bg-gradient-to-l from-brand-400 to-brand-600 mx-auto mt-4 rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($products as $index => $product)
                <div class="card group opacity-0 animate-fade-in-up"
                    style="animation-delay: {{ $index * 0.1 }}s; animation-fill-mode: forwards;">
                    <div class="relative overflow-hidden aspect-[3/4]">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                        </div>
                        @if($product->inStock())
                            <span
                                class="absolute top-3 start-3 bg-emerald-500 text-white text-xs font-bold px-3 py-1 rounded-full">متوفر</span>
                        @else
                            <span
                                class="absolute top-3 start-3 bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full">غير
                                متوفر</span>
                        @endif
                    </div>
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-brand-800 mb-2 line-clamp-1">{{ $product->name }}</h3>
                        <p class="text-brand-500 text-sm mb-4 line-clamp-2 leading-relaxed">{{ $product->description }}</p>
                        <div class="flex items-center justify-between">
                            <span class="text-xl font-black text-brand-700">{{ number_format($product->price) }} <span
                                    class="text-sm font-medium">د.م</span></span>
                            <a href="{{ route('product.show', $product) }}"
                                class="bg-brand-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-brand-700 transition-all duration-300 hover:shadow-md">
                                عرض التفاصيل
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="bg-gradient-to-bl from-brand-700 to-brand-900 py-16">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-3xl sm:text-4xl font-black text-white mb-4">هل تحتاجين مساعدة في الاختيار؟</h2>
            <p class="text-brand-200 text-lg mb-8">تواصلي معنا عبر واتساب وسنساعدك في اختيار الجلابة المثالية</p>
            <a href="https://wa.me/{{ config('app.whatsapp_number', '212600000000') }}?text=مرحباً، أريد الاستفسار عن منتجاتكم"
                target="_blank"
                class="inline-flex items-center gap-3 bg-emerald-500 text-white px-8 py-4 rounded-xl text-lg font-bold hover:bg-emerald-600 transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                </svg>
                تواصلي معنا عبر واتساب
            </a>
        </div>
    </section>
</x-layouts.app>