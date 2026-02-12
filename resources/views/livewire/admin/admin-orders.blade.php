<div>
    @section('header', 'إدارة الطلبات')

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-brand-800">الطلبات ({{ $orders->count() }})</h2>
    </div>

    {{-- Order Details Modal --}}
    @if($showDetails && $selectedOrder)
        <div class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4" wire:click.self="closeDetails">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-xl max-h-[90vh] overflow-y-auto">
                <div class="p-6 border-b border-brand-100 flex items-center justify-between">
                    <h3 class="text-xl font-bold text-brand-800">تفاصيل الطلب #{{ $selectedOrder->id }}</h3>
                    <button wire:click="closeDetails" class="text-brand-400 hover:text-brand-600 cursor-pointer">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-brand-50 rounded-xl p-4">
                            <p class="text-xs text-brand-400 mb-1">الاسم</p>
                            <p class="font-semibold text-brand-800">{{ $selectedOrder->name }}</p>
                        </div>
                        <div class="bg-brand-50 rounded-xl p-4">
                            <p class="text-xs text-brand-400 mb-1">الهاتف</p>
                            <p class="font-semibold text-brand-800" dir="ltr">{{ $selectedOrder->phone }}</p>
                        </div>
                        <div class="bg-brand-50 rounded-xl p-4">
                            <p class="text-xs text-brand-400 mb-1">المدينة</p>
                            <p class="font-semibold text-brand-800">{{ $selectedOrder->city }}</p>
                        </div>
                        <div class="bg-brand-50 rounded-xl p-4">
                            <p class="text-xs text-brand-400 mb-1">الكمية</p>
                            <p class="font-semibold text-brand-800">{{ $selectedOrder->quantity }}</p>
                        </div>
                    </div>
                    <div class="bg-brand-50 rounded-xl p-4">
                        <p class="text-xs text-brand-400 mb-1">العنوان</p>
                        <p class="font-semibold text-brand-800">{{ $selectedOrder->address }}</p>
                    </div>
                    <div class="bg-brand-50 rounded-xl p-4">
                        <p class="text-xs text-brand-400 mb-1">المنتج</p>
                        <p class="font-semibold text-brand-800">{{ $selectedOrder->product->name ?? 'محذوف' }}</p>
                    </div>

                    {{-- Status Changer --}}
                    <div>
                        <p class="text-sm font-semibold text-brand-700 mb-2">تغيير الحالة:</p>
                        <div class="flex items-center gap-2 flex-wrap">
                            @foreach(\App\Models\Order::statuses() as $status)
                                            <button wire:click="updateStatus({{ $selectedOrder->id }}, '{{ $status }}')" class="px-4 py-2 rounded-xl text-sm font-semibold transition-all cursor-pointer
                                                            {{ $selectedOrder->status === $status
                                ? ($status === 'قيد المعالجة' ? 'bg-yellow-500 text-white' : ($status === 'تم التأكيد' ? 'bg-blue-500 text-white' : 'bg-emerald-500 text-white'))
                                : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                                                {{ $status }}
                                            </button>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex items-center gap-3 pt-4 border-t border-brand-100">
                        <button wire:click="confirmDelete({{ $selectedOrder->id }})"
                            class="btn-danger flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            حذف الطلب
                        </button>
                        <button wire:click="closeDetails" class="btn-secondary">إغلاق</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Delete Confirmation --}}
    @if($confirmingDelete)
        <div class="fixed inset-0 bg-black/50 z-[60] flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-8 text-center">
                <span class="text-5xl mb-4 block">⚠️</span>
                <h3 class="text-xl font-bold text-brand-800 mb-2">تأكيد الحذف</h3>
                <p class="text-brand-500 mb-6">هل أنت متأكد من حذف هذا الطلب؟</p>
                <div class="flex items-center gap-3 justify-center">
                    <button wire:click="deleteOrder" class="btn-danger px-6 py-3">نعم، احذف</button>
                    <button wire:click="cancelDelete" class="btn-secondary px-6 py-3">إلغاء</button>
                </div>
            </div>
        </div>
    @endif

    {{-- Orders Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-brand-100 overflow-hidden">
        @if($orders->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-brand-50">
                        <tr>
                            <th class="text-right px-6 py-4 text-sm font-semibold text-brand-600">#</th>
                            <th class="text-right px-6 py-4 text-sm font-semibold text-brand-600">العميل</th>
                            <th class="text-right px-6 py-4 text-sm font-semibold text-brand-600">الهاتف</th>
                            <th class="text-right px-6 py-4 text-sm font-semibold text-brand-600">المنتج</th>
                            <th class="text-right px-6 py-4 text-sm font-semibold text-brand-600">الكمية</th>
                            <th class="text-right px-6 py-4 text-sm font-semibold text-brand-600">المدينة</th>
                            <th class="text-right px-6 py-4 text-sm font-semibold text-brand-600">الحالة</th>
                            <th class="text-right px-6 py-4 text-sm font-semibold text-brand-600">التاريخ</th>
                            <th class="text-right px-6 py-4 text-sm font-semibold text-brand-600">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-brand-100">
                        @foreach($orders as $order)
                            <tr class="hover:bg-brand-50/50 transition-colors">
                                <td class="px-6 py-4 text-sm text-brand-700">{{ $order->id }}</td>
                                <td class="px-6 py-4 text-sm font-semibold text-brand-800">{{ $order->name }}</td>
                                <td class="px-6 py-4 text-sm text-brand-600" dir="ltr">{{ $order->phone }}</td>
                                <td class="px-6 py-4 text-sm text-brand-600">{{ $order->product->name ?? 'محذوف' }}</td>
                                <td class="px-6 py-4 text-sm text-brand-600">{{ $order->quantity }}</td>
                                <td class="px-6 py-4 text-sm text-brand-600">{{ $order->city }}</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold
                                                {{ $order->status === 'قيد المعالجة' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                                {{ $order->status === 'تم التأكيد' ? 'bg-blue-100 text-blue-700' : '' }}
                                                {{ $order->status === 'تم التوصيل' ? 'bg-emerald-100 text-emerald-700' : '' }}">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-brand-500">{{ $order->created_at->format('Y/m/d') }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <button wire:click="viewOrder({{ $order->id }})"
                                            class="text-brand-500 hover:text-brand-700 transition-colors cursor-pointer"
                                            title="عرض التفاصيل">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                        <button wire:click="confirmDelete({{ $order->id }})"
                                            class="text-red-400 hover:text-red-600 transition-colors cursor-pointer"
                                            title="حذف">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-12 text-center text-brand-400">
                <span class="text-5xl mb-4 block">📭</span>
                <p class="text-lg">لا توجد طلبات بعد</p>
            </div>
        @endif
    </div>
</div>