<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="flex flex-col max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        <h1 class="font-bold text-xl pb-2">Services</h1>
        <div class="flex flex-row items-center gap-5 w-full">
            <div class="flex flex-col gap-2 bg-white shadow-sm sm:rounded-lg w-2/5">
                <h2 class="text-lg">Accounts</h2>
                <p>Please open up account here, so we wouldn't go out of business.</p>
                <button>Check it out</button>
            </div>
            <div class="flex flex-col gap-2 bg-white shadow-sm sm:rounded-lg w-2/5">
                <h2 class="text-lg">Crypto Investments</h2>
                <p>Please open up account here, so we wouldn't go out of.</p>
                <button>Check it out</button>
            </div>
            <div class="flex flex-col gap-2 bg-white shadow-sm sm:rounded-lg w-2/5">
                <h2 class="text-lg">Crypto Investments</h2>
                <p>Please open up account here, so we wouldn't go out of.</p>
                <a href=" {{route('investments')}} ">Check it out</a>
            </div>
        </div>
    </div>

    {{--    <div class="flex flex-col gap-1 px-12">--}}
    {{--        <h1>--}}
    {{--            Services--}}
    {{--        </h1>--}}

    {{--        <div class="flex gap-2 max-w-7xl bg-white mx-auto sm:px-4 lg:px-8">--}}
    {{--            <div>--}}
    {{--                <h2>Accounts</h2>--}}
    {{--                <p>--}}
    {{--                    Open up an account on our 100% secure bank. We won't ever steal money from you.--}}
    {{--                </p>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
</x-app-layout>
