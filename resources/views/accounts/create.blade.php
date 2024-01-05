<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Account') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col gap-2">
            <div>
                <h1 class="text-xl font-bold">Create Account</h1>
                <p class="text-s font-light text-gray-500">Fill out this form</p>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('accounts.store') }}" class="flex flex-col gap-2">
                        @csrf

                        <div class="flex flex-col">
                            <label for="balance">Initial Balance</label>
                            <input type="number" id="balance" name="balance" class="rounded-md">
                        </div>


                        <div class="flex flex-col">
                            <label for="currency">Currency</label>
                            <select id="currency" name="currency" class="rounded-md">
                                <option value="USD">USD</option>
                                <option value="EUR">EUR</option>
                                <option value="RUB">RUB</option>
                                <option value="GBP">GBP</option>
                            </select>
                        </div>

                        <button type="submit"
                                class="flex items-center justify-center font-semibold w-[6rem] h-[2rem] bg-sky-500 text-white rounded-md p-2">
                            Create
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
