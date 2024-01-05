<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transfer Funds') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col gap-2">
            @if ($errors->any())
                <div class="mb-4">
                    <div class="font-bold text-red-600">
                        {{ __('Something went terribly wrong!') }}
                    </div>

                    <ul class="text-sm text-red-600 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div>
                <h1 class="font-bold text-xl">Transfer Funds</h1>
                <p class="text-s">Fill out this form</p>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form class="flex flex-col gap-2" method="POST" action="{{ route('transactions.store') }}"
                          class="flex flex-col">
                        @csrf

                        <div class="flex flex-col">
                            <label for="fromAccountDisplay">From</label>
                            <input type="text" id="fromAccountDisplay" name="fromAccountDisplay" disabled
                                   value="{{ $identifier }}" class="text-gray-500 rounded-md">
                            <input type="hidden" id="fromAccount" name="fromAccount" value="{{ $identifier }}">
                        </div>

                        <div class="flex flex-col">
                            <label for="toAccount">To</label>
                            <input type="text" id="toAccount" name="toAccount" class="rounded-md">
                        </div>

                        <div class="flex flex-col">
                            <label for="amount">Amount</label>
                            <input type="number" id="amount" name="amount" class="rounded-md" step="0.01">
                        </div>

                        <div class="flex flex-col">
                            <label for="note">Note for Receiver</label>
                            <input type="text" id="note" name="note" class="rounded-md">
                        </div>

                        <button type="submit"
                                class="flex items-center justify-center font-semibold w-[6rem] h-[2rem] bg-sky-500 text-white rounded-md p-2">
                            Send
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
