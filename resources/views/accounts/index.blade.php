<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Accounts') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col gap-2">
            @if (session('success'))
                <div class="mb-4 text-sm text-green-600">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4">
                    <div class="font-medium text-red-600">
                        {{ __('Whoops! Something went wrong.') }}
                    </div>

                    <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <h1 class="text-xl font-bold">Checking Accounts</h1>
            @if($checkingAccounts->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200 flex flex-col h-full">
                        <h1 class="font-bold">You Currently Have No Open Accounts</h1>
                        <p>Create an account by pressing the button below</p>
                    </div>
                </div>
            @else
                @foreach ($checkingAccounts as $account)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200 flex justify-between h-full">
                            <div>
                                <h1 class="font-semibold text-xl">{{$account->identifier}}</h1>
                                <h1 class="font-semibold text-green-600 text-bl">
                                    Balance: {{ number_format($account->balance / 100, 2) }} {{ $account->currency  }}</h1>
                            </div>
                            <div class="flex gap-2 h-full items-center">
                                <a href="{{ route('transactions.create', ['identifier' => $account->identifier]) }}"
                                   class="w-30 h-1">
                                    <button class="bg-sky-500 text-white rounded-md p-2">Transfer Funds</button>
                                </a>

                                <form
                                    action="{{ route('accounts.delete', ['identifier' => $account->identifier]) }}"
                                    method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this account?')"
                                    class="w-30 h-1"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-white bg-red-500 rounded-md p-2">Delete Account
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

            <a href="{{ route('accounts.create') }}" class="w-40 h-10">
                <button class="bg-sky-500 text-white rounded-md w-full h-full font-semibold">Create Account</button>
            </a>

            <h1 class="text-xl font-bold mt-5">Investment Account</h1>
            @if($investmentAccounts->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200 flex flex-col h-full">
                        <h1 class="font-bold">You Currently Don't Have an Investment Account open</h1>
                        <p>Create one by pressing the button below</p>
                    </div>
                </div>
                <a href="{{ route('accounts.createInvestment') }}" class="w-[15rem] h-10">
                    <button class="bg-sky-500 text-white rounded-md w-full h-full font-semibold">
                        Create Investment Account
                    </button>
                </a>
            @endif
            @foreach($investmentAccounts as $account)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200 flex justify-between h-full">
                            <div>
                                <h1 class="font-semibold text-xl">{{$account->identifier}}</h1>
                                <h1 class="font-semibold text-green-600 text-bl">
                                    Balance: {{ number_format($account->balance / 100, 2) }}{{ $account->currency  }}</h1>
                            </div>
                            <div class="flex gap-2 h-full items-center">
                                <a href="{{ route('transactions.create', ['identifier' => $account->identifier]) }}"
                                   class="w-30 h-1">
                                    <button class="bg-sky-500 text-white rounded-md p-2">Transfer Funds</button>
                                </a>

                                <form
                                    action="{{ route('accounts.delete', ['identifier' => $account->identifier]) }}"
                                    method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this account?')"
                                    class="w-30 h-1"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-white bg-red-500 rounded-md p-2">Delete Account
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
