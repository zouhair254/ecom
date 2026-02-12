<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'لوحة التحكم - جلابة' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="min-h-screen bg-gray-50">
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside class="w-64 bg-brand-900 text-white flex-shrink-0 hidden lg:block">
            <div class="p-6">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                    <span class="text-2xl">🧵</span>
                    <span class="text-xl font-black">لوحة التحكم</span>
                </a>
            </div>
            <nav class="mt-6 px-3 space-y-1">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300
                          {{ request()->routeIs('admin.dashboard') ? 'bg-brand-700 text-white' : 'text-brand-300 hover:bg-brand-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    الرئيسية
                </a>
                <a href="{{ route('admin.products') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300
                          {{ request()->routeIs('admin.products') ? 'bg-brand-700 text-white' : 'text-brand-300 hover:bg-brand-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    المنتجات
                </a>
                <a href="{{ route('admin.orders') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300
                          {{ request()->routeIs('admin.orders') ? 'bg-brand-700 text-white' : 'text-brand-300 hover:bg-brand-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    الطلبات
                </a>
                <div class="pt-4 mt-4 border-t border-brand-800">
                    <a href="{{ route('home') }}" target="_blank"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl text-brand-300 hover:bg-brand-800 hover:text-white transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        عرض الموقع
                    </a>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-400 hover:bg-red-900/30 hover:text-red-300 transition-all duration-300 cursor-pointer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            تسجيل الخروج
                        </button>
                    </form>
                </div>
            </nav>
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col">
            {{-- Top Header --}}
            <header class="bg-white shadow-sm border-b border-gray-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h1 class="text-xl font-bold text-brand-800">{{ $header ?? 'لوحة التحكم' }}</h1>
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-gray-500">مرحباً، {{ auth()->user()->name ?? 'المدير' }}</span>
                    </div>
                </div>
            </header>

            {{-- Page Content --}}
            <main class="flex-1 p-6">
                {{ $slot }}
            </main>
        </div>
    </div>

    <livewire:toast />
    @livewireScripts
</body>

</html>