<x-app-layout>
    <div class="vue-root" data-page="index" data-props="{{ json_encode(['customers' => $customers, 'search' => $search, 'status' => $status, 'success' => session('success')], JSON_HEX_APOS | JSON_HEX_QUOT) }}"></div>
</x-app-layout>
