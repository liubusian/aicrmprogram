<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $customer->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm text-gray-700">
                    <div><span class="font-semibold">公司：</span> {{ $customer->company ?? '-' }}</div>
                    <div><span class="font-semibold">Email：</span> {{ $customer->email ?? '-' }}</div>
                    <div><span class="font-semibold">電話：</span> {{ $customer->phone ?? '-' }}</div>
                    <div><span class="font-semibold">來源：</span> {{ $customer->source ?? '-' }}</div>
                    <div><span class="font-semibold">狀態：</span> {{ $customer->status ?? 'new' }}</div>
                    <div><span class="font-semibold">建立時間：</span> {{ $customer->created_at->format('Y-m-d') }}</div>
                </div>

                <div class="mt-6 border-t pt-6">
                    <h3 class="font-semibold text-gray-900 mb-2">備註</h3>
                    <p class="text-gray-700 whitespace-pre-line">{{ $customer->notes ?? '尚無備註。' }}</p>
                </div>

                <div class="mt-6 flex gap-3">
                    <a href="{{ route('customers.edit', $customer) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-400">編輯</a>
                    <a href="{{ route('customers.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">返回列表</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
