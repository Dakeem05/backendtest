<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Review Transaction') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-auto">
                        <table class="min-w-full bg-gray-200 dark:bg-gray-700 border border-gray-400">
                            <thead>
                                <tr class="bg-gray-300 dark:bg-gray-600 text-gray-900 dark:text-gray-100 font-bold">
                                    <th class="border border-gray-400 px-4 py-2">Amount</th>
                                    <th class="border border-gray-400 px-4 py-2">Type</th>
                                    <th class="border border-gray-400 px-4 py-2">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-white dark:bg-gray-800">
                                    <td class="border border-gray-400 px-4 py-2">{{ $transaction->amount }}</td>
                                    <td class="border border-gray-400 px-4 py-2">{{ $transaction->type }}</td>
                                    <td class="border border-gray-400 px-4 py-2">{{ $transaction->description }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <form method="POST" action="{{ route('transaction.review', ['transaction' => $transaction->id]) }}" class="mt-6">
                        @csrf

                        <div class="mb-4">
                            <label for="decision" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Decision') }}</label>
                            <select id="decision" name="status" class="mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:focus:ring-indigo-600 dark:focus:border-indigo-600 sm:text-sm" required>
                                @foreach($decisions as $decision)
                                    <option value="{{ $decision }}" {{ old('decision') === $decision ? 'selected' : '' }}>
                                        {{ ucfirst($decision) }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('decision')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <label for="note" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Note') }}</label>
                            <textarea id="note" name="note" rows="4" class="mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:focus:ring-indigo-600 dark:focus:border-indigo-600 sm:text-sm">{{ old('note') }}</textarea>
                            <x-input-error :messages="$errors->get('note')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end">
                            <x-primary-button class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded-md shadow-sm">
                                {{ __('Review Transaction') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
