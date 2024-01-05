<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Crypto;
use App\Models\Investment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InvestmentController extends Controller
{
    public function view(): View
    {
        $investmentAccount = Account::where('user_id', auth()->id())
            ->where('type', 'investment')
            ->first();

        $investments = Investment::where('user_id', auth()->id())
            ->where('status', 'Active')
            ->get();

        $cryptoRates = Crypto::whereIn('crypto_symbol', $investments->pluck('crypto_symbol'))->get()->keyBy('crypto_symbol');

        foreach ($investments as $investment) {
            $currentRate = $cryptoRates[$investment->crypto_symbol]->EUR;
            $investment->currentValue = $investment->quantity * $currentRate;
            $investment->purchaseValue = $investment->quantity * $investment->purchase_rate;
            $investment->percentageChange = (($investment->currentValue - $investment->purchaseValue) / $investment->purchaseValue) * 100;
        }

        return view('investments.index', compact('investments', 'investmentAccount'));
    }

    public function create()
    {
        $cryptoRates = Crypto::whereIn('crypto_symbol', ['BTC', 'ETH', 'BNB', 'USDT'])->get();

        return view('investments.create', compact('cryptoRates'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'cryptoSymbol' => 'required',
            'amount' => 'required|integer',
        ]);

        $cryptoRate = Crypto::where('crypto_symbol', $request->cryptoSymbol)->first();
        if (!$cryptoRate) {
            return back()->withErrors(['message' => 'Crypto rate not found']);
        }

        $currentRate = $cryptoRate->EUR;
        $amount = $request->amount * $currentRate;

        $account = Account::where('user_id', auth()->id())
            ->where('type', 'investment')
            ->first();
        if (!$account) {
            return back();
        }

        if ($account->balance < round($amount * 100)) {
            return redirect()->route('investments')->with('error', 'Insufficient funds.');
        }

        $account->balance -= round($amount * 100);
        $account->save();

        $data = [
            'user_id' => auth()->id(),
            'crypto_symbol' => $request->cryptoSymbol,
            'quantity' => $request->amount,
            'purchase_rate' => $currentRate,
            'status' => 'Active',
        ];

        Investment::create($data);

        return redirect()->route('investments')->with('success', 'You made a new investment!');
    }

    public function sell(Request $request): RedirectResponse
    {
        $request->validate([
            'investmentId' => 'required|integer',
        ]);

        $investment = Investment::where('id', $request->investmentId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $cryptoRate = Crypto::where('crypto_symbol', $investment->crypto_symbol)->first();
        if (!$cryptoRate) {
            return back()->withErrors(['msg' => 'Crypto rate not found']);
        }

        $currentRate = $cryptoRate->EUR;
        $amount = $investment->quantity * $currentRate;

        $account = Account::where('user_id', auth()->id())
            ->where('type', 'investment')
            ->first();
        if (!$account) {
            return back();
        }

        $account->balance += round($amount * 100);
        $account->save();

        $investment->status = 'sold';
        $investment->sale_value = round($amount * 100);
        $investment->save();

        return redirect()->route('investments')->with('success', 'You just sold your investment!');
    }
}
