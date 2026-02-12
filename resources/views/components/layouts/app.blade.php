<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="جلابة - أرقى الجلابات المغربية التقليدية والعصرية">
    <title>{{ $title ?? 'جلابة - أزياء مغربية أصيلة' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="min-h-screen flex flex-col">
    {{-- Navigation --}}
    <nav class="glass sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <span class="text-3xl">🧵</span>
                    <span
                        class="text-2xl font-black text-brand-700 group-hover:text-brand-500 transition-colors duration-300">جلابة</span>
                </a>
                <div class="flex items-center gap-6">
                    <a href="{{ route('home') }}"
                        class="text-brand-700 hover:text-brand-500 font-semibold transition-colors duration-300">الرئيسية</a>
                    <a href="{{ route('home') }}#products"
                        class="text-brand-700 hover:text-brand-500 font-semibold transition-colors duration-300">المنتجات</a>
                </div>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="flex-1">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer class="bg-brand-900 text-brand-200 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center md:text-right">
                <div>
                    <h3 class="text-2xl font-black text-white mb-4">🧵 جلابة</h3>
                    <p class="text-brand-300 leading-relaxed">أرقى الجلابات المغربية التقليدية والعصرية. نقدم لكِ أجمل
                        التصاميم بأفضل الأقمشة.</p>
                </div>
                <div>
                    <h4 class="text-lg font-bold text-white mb-4">روابط سريعة</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}"
                                class="hover:text-white transition-colors duration-300">الرئيسية</a></li>
                        <li><a href="{{ route('home') }}#products"
                                class="hover:text-white transition-colors duration-300">المنتجات</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-bold text-white mb-4">تواصلي معنا</h4>
                    <a href="https://wa.me/{{ config('app.whatsapp_number', '212600000000') }}" target="_blank"
                        class="inline-flex items-center gap-2 text-emerald-400 hover:text-emerald-300 transition-colors duration-300">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                        </svg>
                        واتساب
                    </a>
                </div>
            </div>
            <div class="border-t border-brand-800 mt-8 pt-8 text-center text-brand-400 text-sm">
                <p>© {{ date('Y') }} جلابة. جميع الحقوق محفوظة.</p>
            </div>
        </div>
    </footer>

    <livewire:toast />
    @livewireScripts
</body>

</html>