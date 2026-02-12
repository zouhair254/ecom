<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - لوحة التحكم</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-bl from-brand-100 via-brand-50 to-white p-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8 animate-fade-in-up">
            <span class="text-5xl mb-4 block">🧵</span>
            <h1 class="text-3xl font-black text-brand-800">لوحة التحكم</h1>
            <p class="text-brand-500 mt-2">قم بتسجيل الدخول للمتابعة</p>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-8 border border-brand-100 animate-fade-in-up animation-delay-100">
            <form method="POST" action="{{ route('admin.login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-semibold text-brand-700 mb-2">البريد الإلكتروني</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                        placeholder="admin@jelaba.ma" class="input-field @error('email') !border-red-400 @enderror">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-brand-700 mb-2">كلمة المرور</label>
                    <input type="password" id="password" name="password" required placeholder="••••••••"
                        class="input-field @error('password') !border-red-400 @enderror">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" name="remember" id="remember"
                        class="w-4 h-4 text-brand-600 border-brand-300 rounded focus:ring-brand-500">
                    <label for="remember" class="text-sm text-brand-600">تذكرني</label>
                </div>

                <button type="submit" class="w-full btn-primary text-lg py-4">
                    تسجيل الدخول
                </button>
            </form>
        </div>

        <p class="text-center text-brand-400 text-sm mt-6">
            <a href="{{ route('home') }}" class="hover:text-brand-600 transition-colors">← العودة إلى الموقع</a>
        </p>
    </div>
</body>

</html>