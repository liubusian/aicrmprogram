<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Customers') }}
            </h2>
            <a href="{{ route('customers.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-500">
                新增客戶
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 rounded-md bg-green-100 border border-green-200 text-green-800 px-4 py-3">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="GET" action="{{ route('customers.index') }}" class="mb-6 flex flex-col gap-3 md:flex-row md:items-end">
                        <div class="flex-1">
                            <label for="search" class="block text-sm font-medium text-gray-700">搜尋</label>
                            <input id="search" type="text" name="search" value="{{ $search ?? '' }}" placeholder="姓名 / 公司 / Email / 電話" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div class="md:w-48">
                            <label for="status" class="block text-sm font-medium text-gray-700">狀態</label>
                            <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">全部</option>
                                <option value="new" {{ ($status ?? '') === 'new' ? 'selected' : '' }}>New</option>
                                <option value="contacted" {{ ($status ?? '') === 'contacted' ? 'selected' : '' }}>Contacted</option>
                                <option value="qualified" {{ ($status ?? '') === 'qualified' ? 'selected' : '' }}>Qualified</option>
                            </select>
                        </div>

                        <div class="flex gap-2">
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-500">篩選</button>
                            <a href="{{ route('customers.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">重置</a>
                        </div>
                    </form>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="text-left text-sm text-gray-600">
                                    <th class="py-3 px-4">姓名</th>
                                    <th class="py-3 px-4">公司</th>
                                    <th class="py-3 px-4">Email</th>
                                    <th class="py-3 px-4">來源</th>
                                    <th class="py-3 px-4">狀態</th>
                                    <th class="py-3 px-4">操作</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($customers as $customer)
                                    <tr class="text-sm text-gray-700">
                                        <td class="py-3 px-4">{{ $customer->name }}</td>
                                        <td class="py-3 px-4">{{ $customer->company ?? '-' }}</td>
                                        <td class="py-3 px-4">{{ $customer->email ?? '-' }}</td>
                                        <td class="py-3 px-4">{{ $customer->source ?? '-' }}</td>
                                        <td class="py-3 px-4">
                                            @php
                                                $statusClass = match ($customer->status ?? 'new') {
                                                    'new' => 'bg-sky-100 text-sky-800',
                                                    'contacted' => 'bg-amber-100 text-amber-800',
                                                    'qualified' => 'bg-emerald-100 text-emerald-800',
                                                    default => 'bg-gray-100 text-gray-800',
                                                };
                                            @endphp
                                            <span class="inline-flex rounded-full px-2 py-1 text-xs font-medium {{ $statusClass }}">
                                                {{ $customer->status ?? 'new' }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-4 space-x-2">
                                            <a href="{{ route('customers.show', $customer) }}" class="text-indigo-600 hover:text-indigo-900">查看</a>
                                            <a href="{{ route('customers.edit', $customer) }}" class="text-yellow-600 hover:text-yellow-800">編輯</a>
                                            <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('確定刪除這位客戶？')">刪除</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-8 px-4 text-center text-gray-500">
                                            目前沒有客戶資料。
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($customers->hasPages())
                        <div class="mt-6 flex justify-center">
                            {{ $customers->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
