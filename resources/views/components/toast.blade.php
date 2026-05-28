<div
    x-data="{
        toasts: [],
        add(toast) {
            toast.id = 'toast-' + Date.now();
            this.toasts.push(toast);
            setTimeout(() => this.remove(toast.id), 4500);
        },
        remove(id) {
            this.toasts = this.toasts.filter(t => t.id !== id);
        }
    }"
    @toast.window="add($event.detail)"
    class="fixed top-4 right-4 z-[9999] flex flex-col gap-3 w-full max-w-sm pointer-events-none"
    x-cloak
>

    {{-- Auto-trigger session --}}
    @if(session('success'))
        <div x-init="$nextTick(() => $dispatch('toast', {
            type: 'success',
            title: 'Berhasil!',
            message: '{{ addslashes(session('success')) }}'
        }))"></div>
    @endif

    @if(session('error'))
        <div x-init="$nextTick(() => $dispatch('toast', {
            type: 'error',
            title: 'Terjadi Kesalahan!',
            message: '{{ addslashes(session('error')) }}'
        }))"></div>
    @endif

    @if(session('status') === 'profile-updated')
        <div x-init="$nextTick(() => $dispatch('toast', {
            type: 'success',
            title: 'Profil Diperbarui',
            message: 'Data profil kamu berhasil disimpan.'
        }))"></div>
    @endif

    @if(session('status') === 'password-updated')
        <div x-init="$nextTick(() => $dispatch('toast', {
            type: 'success',
            title: 'Password Diperbarui',
            message: 'Password kamu berhasil diganti.'
        }))"></div>
    @endif

    {{-- Toast Items --}}
    <template x-for="toast in toasts" :key="toast.id">
        <div
            x-show="true"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-x-8 scale-95"
            x-transition:enter-end="opacity-100 translate-x-0 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-x-0 scale-100"
            x-transition:leave-end="opacity-0 translate-x-8 scale-95"
            class="pointer-events-auto flex items-start gap-3 w-full bg-white rounded-2xl shadow-card border border-gray-100 p-4"
        >
            {{-- Icon --}}
            <div class="shrink-0 mt-0.5">
                {{-- Success --}}
                <div x-show="toast.type === 'success'" class="w-9 h-9 rounded-full bg-green-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                {{-- Error --}}
                <div x-show="toast.type === 'error'" class="w-9 h-9 rounded-full bg-red-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
                {{-- Info --}}
                <div x-show="toast.type === 'info'" class="w-9 h-9 rounded-full bg-blue-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20A10 10 0 0012 2z"/>
                    </svg>
                </div>
            </div>

            {{-- Text --}}
            <div class="flex-1 min-w-0">
                <p class="text-sm font-bold text-dark" x-text="toast.title"></p>
                <p class="text-xs text-muted mt-0.5 leading-snug" x-text="toast.message" x-show="toast.message"></p>
            </div>

            {{-- Close Button --}}
            <button
                @click="remove(toast.id)"
                class="shrink-0 text-muted hover:text-dark transition-colors bg-transparent border-none cursor-pointer p-1 -mt-0.5"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </template>
</div>
