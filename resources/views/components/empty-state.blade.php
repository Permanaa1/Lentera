@props(['message' => 'Belum ada data.'])
<div class="text-center py-10 px-4">
    <svg class="w-10 h-10 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
              d="M9 13h6m-6 4h6M5 7h14M7 3h10a2 2 0 012 2v14a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"/>
    </svg>
    <p class="text-sm text-gray-400">{{ $message }}</p>
    @if (isset($action))
        <div class="mt-3">{{ $action }}</div>
    @endif
</div>
