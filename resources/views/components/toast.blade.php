{{--
    Toast Notification
    -------------------
    Taruh <x-toast /> SEKALI saja di layouts/app.blade.php (sudah otomatis).

    Cara pakai dari controller (paling umum):
        return redirect()->back()->with('status', 'Data berhasil disimpan.');
        return redirect()->back()->with('error', 'Gagal menghapus data.');

    Cara pakai dari JS/Alpine di halaman mana saja:
        window.dispatchEvent(new CustomEvent('toast', {
            detail: { type: 'success', message: 'Berhasil disimpan!' }
        }));
--}}
<div
    x-data="{
        toasts: [],
        add(type, message) {
            const id = Date.now() + Math.random();
            this.toasts.push({ id, type, message });
            setTimeout(() => this.remove(id), 4000);
        },
        remove(id) {
            this.toasts = this.toasts.filter(t => t.id !== id);
        },
    }"
    @toast.window="add($event.detail.type ?? 'info', $event.detail.message)"
    x-init="
        @if (session('status')) add('success', @js(session('status'))); @endif
        @if (session('error')) add('danger', @js(session('error'))); @endif
        @if ($errors->any()) add('danger', @js($errors->first())); @endif
    "
    class="fixed top-4 right-4 z-[9999] flex flex-col gap-2 w-[calc(100%-2rem)] max-w-sm"
>
    <template x-for="toast in toasts" :key="toast.id">
        <div
            x-show="true"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="toast-enter flex items-start gap-3 rounded-xl shadow-lg border px-4 py-3 text-sm bg-white"
            :class="{
                'border-success/30': toast.type === 'success',
                'border-danger/30': toast.type === 'danger',
                'border-warning/30': toast.type === 'warning',
                'border-info/30': toast.type === 'info',
            }"
        >
            <span class="mt-0.5 shrink-0 w-5 h-5 rounded-full flex items-center justify-center text-white text-xs"
                  :class="{
                      'bg-success': toast.type === 'success',
                      'bg-danger': toast.type === 'danger',
                      'bg-warning': toast.type === 'warning',
                      'bg-info': toast.type === 'info',
                  }">
                <svg x-show="toast.type === 'success'" class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                <svg x-show="toast.type === 'danger'" class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                <svg x-show="toast.type === 'warning' || toast.type === 'info'" class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 8v4m0 4h.01"/></svg>
            </span>
            <p class="flex-1 text-gray-700" x-text="toast.message"></p>
            <button @click="remove(toast.id)" class="text-gray-300 hover:text-gray-500 shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </template>
</div>
