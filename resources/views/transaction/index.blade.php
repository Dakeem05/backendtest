<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ ucfirst($user->role) . __('\'s Transactions') }}
            </h2>
            <div>
                <x-nav-link :href="route('transaction.create')" class="bg-indigo-500 text-white py-2 px-4 rounded-lg hover:bg-indigo-600">
                    {{ __('Create') }}
                </x-nav-link>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-center text-[2rem]">
                        {{ __('Transactions ') }}
                        {{ $user->role === $checker ? 'pending ' . count($transactions->where('status', 'pending')) : 'made (' . count($user->transactions) . ')'}}
                    </h1>
                </div>

                <div class="px-6 py-2 text-white">
                    @if(auth()->user()->role === "checker")
                        @if ($transactions->isNotEmpty())
                        
                            <table class="w-full table-auto border-collapse border border-slate-600">
                                <thead class="bg-gray-700 text-white">
                                    <tr>
                                        <th class="border border-slate-300 p-2">Amount</th>
                                        <th class="border border-slate-300 p-2">Type</th>
                                        <th class="border border-slate-300 p-2">Description</th>
                                        <th class="border border-slate-300 p-2">Status</th>
                                        <th class="border border-slate-300 p-2">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transactions as $transaction)
                                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <td class="border border-slate-300 p-2">{{ $transaction->amount }}</td>
                                            <td class="border border-slate-300 p-2">{{ ucfirst($transaction->type) }}</td>
                                            <td class="border border-slate-300 p-2">{{ Str::ucfirst($transaction->description) }}</td>
                                            <td class="border border-slate-300 p-2">{{ ucfirst($transaction->status) }}</td>
                                            <td class="border border-slate-300 p-2">
                                                @if($user->role === $maker)
                                                    <a class="py-1 px-3 rounded bg-gray-500 hover:bg-gray-700 {{ $transaction->status === $rejected ? 'bg-red-900' : '' }}" href="{{ route('transaction.edit', ['transaction' => $transaction->id]) }}">
                                                        Edit
                                                    </a>
                                                @endif
                                                @if($user->role === $checker)
                                                    <a class="py-1 px-3 rounded bg-gray-500 hover:bg-gray-700 {{ $transaction->status === $pending ? 'bg-red-800' : '' }}" href="{{ route('transaction.review', ['transaction' => $transaction->id]) }}">
                                                        Review
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="text-center py-4">
                                {{ __('There are no transactions') }}
                            </div>
                        @endif
                    @else
                        @if ($user->transactions->isNotEmpty())
                            <table class="w-full table-auto border-collapse border border-slate-600">
                                <thead class="bg-gray-700 text-white">
                                    <tr>
                                        <th class="border border-slate-300 p-2">Amount</th>
                                        <th class="border border-slate-300 p-2">Type</th>
                                        <th class="border border-slate-300 p-2">Description</th>
                                        <th class="border border-slate-300 p-2">Status</th>
                                        <th class="border border-slate-300 p-2">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user->transactions as $transaction)
                                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <td class="border border-slate-300 p-2">{{ $transaction->amount }}</td>
                                            <td class="border border-slate-300 p-2">{{ ucfirst($transaction->type) }}</td>
                                            <td class="border border-slate-300 p-2">{{ Str::ucfirst($transaction->description) }}</td>
                                            <td class="border border-slate-300 p-2">{{ ucfirst($transaction->status) }}</td>
                                            <td class="border border-slate-300 p-2">
                                                @if($user->role === $maker)
                                                    <a class="py-1 px-3 rounded bg-gray-500 hover:bg-gray-700 {{ $transaction->status === $rejected ? 'bg-red-900' : '' }}" href="{{ route('transaction.edit', ['transaction' => $transaction->id]) }}">
                                                        Edit
                                                    </a>
                                                @endif
                                                @if($user->role === $checker)
                                                    <a class="py-1 px-3 rounded bg-gray-500 hover:bg-gray-700 {{ $transaction->status === $pending ? 'bg-red-900' : '' }}" href="{{ route('transaction.review', ['transaction' => $transaction->id]) }}">
                                                        Review
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="text-center py-4">
                                {{ __('You have made no transactions') }}
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
