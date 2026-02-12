<div>
    @section('header', 'لوحة التحكم')

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        {{-- Total Products --}}
        <div
            class="bg-white rounded-2xl p-6 shadow-sm border border-brand-100 hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-brand-500 font-medium">عدد المنتجات</p>
                    <p class="text-3xl font-black text-brand-800 mt-1">{{ $productsCount }}</p>
                </div>
                <div class="w-14 h-14 bg-brand-100 rounded-2xl flex items-center justify-center text-2xl">📦</div>
            </div>
        </div>

        {{-- Total Orders --}}
        <div
            class="bg-white rounded-2xl p-6 shadow-sm border border-brand-100 hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-brand-500 font-medium">عدد الطلبات</p>
                    <p class="text-3xl font-black text-brand-800 mt-1">{{ $ordersCount }}</p>
                </div>
                <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center text-2xl">📋</div>
            </div>
        </div>

        {{-- Pending Orders --}}
        <div
            class="bg-white rounded-2xl p-6 shadow-sm border border-brand-100 hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-brand-500 font-medium">قيد المعالجة</p>
                    <p class="text-3xl font-black text-yellow-600 mt-1">{{ $pendingOrders }}</p>
                </div>
                <div class="w-14 h-14 bg-yellow-100 rounded-2xl flex items-center justify-center text-2xl">⏳</div>
            </div>
        </div>

        {{-- Delivered Orders --}}
        <div
            class="bg-white rounded-2xl p-6 shadow-sm border border-brand-100 hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-brand-500 font-medium">تم التوصيل</p>
                    <p class="text-3xl font-black text-emerald-600 mt-1">{{ $deliveredOrders }}</p>
                </div>
                <div class="w-14 h-14 bg-emerald-100 rounded-2xl flex items-center justify-center text-2xl">✅</div>
            </div>
        </div>
    </div>

    {{-- Recent Orders --}}
    <div class="bg-white rounded-2xl shadow-sm border border-brand-100 overflow-hidden">
        <div class="p-6 border-b border-brand-100">
            <h3 class="text-lg font-bold text-brand-800">أحدث الطلبات</h3>
        </div>
        @if($recentOrders->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-brand-50">
                        <tr>
                            <th class="text-right px-6 py-3 text-sm font-semibold text-brand-600">#</th>
                            <th class="text-right px-6 py-3 text-sm font-semibold text-brand-600">العميل</th>
                            <th class="text-right px-6 py-3 text-sm font-semibold text-brand-600">المنتج</th>
                            <th class="text-right px-6 py-3 text-sm font-semibold text-brand-600">الحالة</th>
                            <th class="text-right px-6 py-3 text-sm font-semibold text-brand-600">التاريخ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-brand-100">
                        @foreach($recentOrders as $order)
                            <tr class="hover:bg-brand-50/50 transition-colors">
                                <td class="px-6 py-4 text-sm text-brand-700">{{ $order->id }}</td>
                                <td class="px-6 py-4 text-sm font-semibold text-brand-800">{{ $order->name }}</td>
                                <td class="px-6 py-4 text-sm text-brand-600">{{ $order->product->name ?? 'محذوف' }}</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold
                                                {{ $order->status === 'قيد المعالجة' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                                {{ $order->status === 'تم التأكيد' ? 'bg-blue-100 text-blue-700' : '' }}
                                                {{ $order->status === 'تم التوصيل' ? 'bg-emerald-100 text-emerald-700' : '' }}">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-brand-500">{{ $order->created_at->diffForHumans() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-12 text-center text-brand-400">
                <span class="text-4xl mb-4 block">📭</span>
                <p class="text-lg">لا توجد طلبات بعد</p>
            </div>
        @endif
    </div>
</div>