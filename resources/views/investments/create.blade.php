<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Invest') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col gap-2">
            <div>
                <h1 class="text-xl font-bold">Available Investments</h1>
            </div>
            <div class="flex flex-col gap-2">
                @foreach($cryptoRates as $rate)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200 flex justify-between h-full">
                            <div>
                                <h1 class="font-semibold text-xl">{{$rate->crypto_symbol}}</h1>
                                <h1 class="font-semibold text-green-600 text-bl">
                                    Price: {{ $rate->USD }} USD</h1>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-5 flex flex-col gap-2">
                <div>
                    <h1 class="text-xl font-bold">Complete your Investment</h1>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200 flex justify-between h-full">
                        <form class="flex flex-col gap-2" action="{{ route('investments.store') }}" method="POST">
                            @csrf
                            <div class="flex flex-col">
                                <label for="cryptoSymbol" class="font-semibold text-lg">Crypto</label>
                                <select id="cryptoSymbol" name="cryptoSymbol" class="rounded-md">
                                    @foreach($cryptoRates as $rate)
                                        <option value="{{ $rate->crypto_symbol }}"
                                                data-rate="{{ $rate->USD }}">{{ $rate->crypto_symbol }}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="flex flex-col">
                                <label for="amount" class="text-lg font-semibold">Amount</label>
                                <input type="number" name="amount" id="amount" value="1" min="1" class="rounded-md"/>
                            </div>
                            <p class="font-semibold text-lg">Total:
                                <span class="text-green-600" id="total">500 USD</span>
                            </p>

                            <button type="submit"
                                    class="flex items-center justify-center font-semibold w-[7rem] h-[40px] bg-sky-500 text-white rounded-md p-2">
                                Invest
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const amountInput = document.getElementById('amount');
        const cryptoSelect = document.getElementById('cryptoSymbol');
        const totalSpan = document.getElementById('total');

        const updateTotal = () => {
            const rate = cryptoSelect.options[cryptoSelect.selectedIndex].getAttribute('data-rate');
            const amount = amountInput.value;
            const total = (rate * amount).toFixed(4); // Adjusted for more precision
            totalSpan.textContent = `${total} USD`;
        };

        amountInput.addEventListener('input', updateTotal);
        cryptoSelect.addEventListener('change', updateTotal);

        updateTotal(); // Initial update on page load
    });
</script>

