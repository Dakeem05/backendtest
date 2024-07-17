<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ Str::ucfirst($user->role) . __('\'s Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white relative dark:bg-gray-800 w-full shadow-sm flex sm:rounded-lg overflow-hidden">
                <div class="p-6 w-[50%] text-gray-900 dark:text-gray-100">
                    <h1 class="text-7xl font-semibold">{{__('Dear ') . $user->name}}</h1>
                </div>
                
                <div class="p-6 text-gray-900 dark:text-gray-100 flex items-center justify-end bg-[red]">
                    <h1 class="text-[4rem] font-bold">Balance ${{ $user->wallet->balance }}</h1>
                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>
