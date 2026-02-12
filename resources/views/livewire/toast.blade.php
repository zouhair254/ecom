<div>
    @if($show)
        <div class="fixed top-6 left-1/2 -translate-x-1/2 z-[100] animate-slide-in-right" x-data="{ show: true }"
            x-init="setTimeout(() => { show = false; $wire.dismiss() }, 4000)" x-show="show"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-4">
            <div class="bg-emerald-500 text-white px-8 py-4 rounded-2xl shadow-2xl flex items-center gap-3 min-w-[300px]">
                <span class="text-2xl">✅</span>
                <p class="font-semibold">{{ $message }}</p>
                <button wire:click="dismiss"
                    class="mr-auto text-white/70 hover:text-white transition-colors cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    @endif
</div>