<x-app-layout>
    <noscript class="sr-only">總客戶數 {{ $totalCustomers ?? 0 }} 本月新增 {{ $newCustomers ?? 0 }} 待跟進 {{ $pendingFollowUp ?? 0 }}</noscript>
    <div class="vue-root" data-page="dashboard" data-props="{{ json_encode(compact('totalCustomers', 'newCustomers', 'pendingFollowUp'), JSON_HEX_APOS | JSON_HEX_QUOT) }}"></div>
</x-app-layout>
