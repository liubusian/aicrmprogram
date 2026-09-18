<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="text-sm text-gray-500">總客戶數</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $totalCustomers ?? 0 }}</div>
                </div>
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="text-sm text-gray-500">本月新增</div>
                    <div class="mt-2 text-3xl font-bold text-emerald-600">{{ $newCustomers ?? 0 }}</div>
                </div>
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="text-sm text-gray-500">待跟進</div>
                    <div class="mt-2 text-3xl font-bold text-amber-600">{{ $pendingFollowUp ?? 0 }}</div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">快速入口</h3>
                        <a href="{{ route('customers.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-500">
                            查看客戶列表
                        </a>
                    </div>
                    <p>{{ __('You\'re logged in!') }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
