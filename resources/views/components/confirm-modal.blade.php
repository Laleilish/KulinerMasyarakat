<div
    x-data="{
        show: false,
        title: '',
        message: '',
        variant: 'confirm',
        confirmText: 'Ya, Lanjutkan',
        cancelText: 'Kembali',
        formId: null,
        onConfirm: null,

        open(detail) {
            this.title = detail.title || 'Konfirmasi';
            this.message = detail.message || '';
            this.variant = detail.variant || 'confirm';
            this.confirmText = detail.confirmText || 'Ya, Lanjutkan';
            this.cancelText = detail.cancelText || 'Kembali';
            this.formId = detail.formId || null;
            this.onConfirm = detail.onConfirm || null;
            this.show = true;
            document.body.classList.add('overflow-hidden');
        },

        close() {
            this.show = false;
            document.body.classList.remove('overflow-hidden');
        },

        submit() {
            if (this.onConfirm && typeof this.onConfirm === 'function') {
                this.onConfirm();
            } else if (this.formId) {
                const form = document.getElementById(this.formId);
                if (form) form.submit();
            }
            this.close();
        }
    }"
    @confirm-modal.window="open($event.detail)"
    @keydown.escape.window="if (show) close()"
    x-show="show"
    x-cloak
    class="fixed inset-0 z-[9999] flex items-center justify-center px-4"
    style="display: none;"
>
    {{-- Backdrop --}}
    <div
        x-show="show"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="close()"
        class="absolute inset-0 bg-black/60"
    ></div>

    {{-- Modal Card --}}
    <div
        x-show="show"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-90 translate-y-4"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-90 translate-y-4"
        class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden"
    >
        {{-- Content --}}
        <div class="px-7 pt-8 pb-6 text-center">
            <h3
                class="text-lg font-extrabold text-gray-900 leading-snug"
                x-text="title"
            ></h3>
            <p
                class="mt-3 text-sm text-gray-500 leading-relaxed"
                x-text="message"
                x-show="message"
            ></p>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-between gap-3 px-7 pb-7">
            {{-- Cancel Button --}}
            <button
                @click="close()"
                type="button"
                class="flex-1 py-3 px-4 text-sm font-bold text-gray-700 bg-transparent border-none rounded-xl cursor-pointer hover:bg-gray-100 transition-all"
                x-text="cancelText"
            ></button>

            {{-- Confirm Button --}}
            <button
                @click="submit()"
                type="button"
                class="flex-1 py-3 px-4 text-sm font-bold text-white border-none rounded-xl cursor-pointer transition-all shadow-sm hover:shadow"
                :class="variant === 'danger'
                    ? 'bg-rose-500 hover:bg-rose-600'
                    : 'bg-emerald-500 hover:bg-emerald-600'"
                x-text="confirmText"
            ></button>
        </div>
    </div>
</div>
