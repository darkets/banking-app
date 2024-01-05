<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Investments') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col gap-2">
            @if (session('success'))
                <div class="mb-4 text-sm text-green-600">
                    {{ session('success') }}
                </div>
            @endif

            <h1 class="text-xl font-bold">Account</h1>
            @if(false === isset($investmentAccount))
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200 flex flex-col h-full">
                        <h1 class="font-bold">You Don't Have an Investments Account Open</h1>
                        <p>Create an account by pressing the button below</p>
                    </div>
                </div>
                <a href="{{ route('accounts.createInvestment') }}" class="w-[15rem] h-10">
                    <button class="bg-sky-500 text-white rounded-md w-full h-full font-semibold">
                        Create Investment Account
                    </button>
                </a>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200 flex justify-between h-full">
                        <div>
                            <h1 class="font-semibold text-xl">{{$investmentAccount->identifier}}</h1>
                            <h1 class="font-semibold text-green-600 text-bl">
                                Balance: {{ number_format($investmentAccount->balance / 100, 2) }}{{ $investmentAccount->currency  }}</h1>
                        </div>
                    </div>
                </div>

                <h1 class="text-xl font-bold mt-5">Investments</h1>
                @if($investments->isEmpty())
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200 flex flex-col h-full">
                            <h1 class="font-bold">You Don't Have any Active Investments</h1>
                            <p>Start investing by pressing the button below</p>
                        </div>
                    </div>
                @else
                    @foreach($investments as $investment)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 bg-white border-b border-gray-200 flex items-center justify-between h-full">
                                <div class="flex flex-col gap-2 items-center">
                                    <p class="font-semibold">Symbol</p>
                                    <p>{{ $investment->crypto_symbol }}</p>
                                </div>
                                <div class="flex flex-col gap-2 items-center">
                                    <p class="font-semibold">Bought At</p>
                                    <p>{{ $investment->purchaseValue }} USD</p>
                                </div>
                                <div class="flex flex-col gap-2 items-center">
                                    <p class="font-semibold">Current Value</p>
                                    <p>{{ $investment->currentValue }} USD</p>
                                </div>
                                <div class="flex flex-col gap-2 items-center">
                                    <p class="font-semibold">Percentage</p>
                                    <p
                                        class="{{ $investment->percentageChange >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ round($investment->percentageChange, 2) }}%
                                    </p>
                                </div>
                                <form action="{{ route('investments.sell', ['investmentId' => $investment->id]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="text-indigo-600 hover:text-indigo-900">Sell</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @endif
                <a href="{{ route('investments.create') }}" class="w-[10rem] h-10">
                    <button class="bg-sky-500 text-white rounded-md w-full h-full font-semibold">
                        Invest
                    </button>
                </a>
            @endif
        </div>
    </div>

</x-app-layout>
