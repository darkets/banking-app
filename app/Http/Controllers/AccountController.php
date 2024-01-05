<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Investment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function view(): View
    {
        $checkingAccounts = Account::where('user_id', auth()->id())
            ->where('type', 'checking')
            ->get();
        $investmentAccounts = Account::where('user_id', auth()->id())
            ->where('type', 'investment')
            ->get();

        return view('accounts.index', compact('checkingAccounts', 'investmentAccounts'));
    }

    public function create(): View
    {
        return view('accounts.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'balance' => 'required|numeric|min:0',
            'currency' => 'required|in:USD,EUR,RUB,GBP',
        ]);

        $data['type'] = $data['type'] ?? 'checking';

        $data['user_id'] = auth()->id();
        $data['balance'] = (int)($data['balance'] * 100);

        Account::create($data);

        return redirect()->route('accounts')->with('success', 'New account created!');
    }

    public function createInvestmentAccount(): RedirectResponse
    {
        $data = [
            'user_id' => auth()->id(),
            'balance' => 0,
            'currency' => 'USD',
            'type' => 'investment'
        ];

        Account::create($data);

        return redirect()->route('accounts')->with('success', 'New investment account created!');
    }

    public function delete(Request $request): RedirectResponse
    {
        $account = Account::where('identifier', $request->identifier)->first();

        if (!$account) {
            return back()->withErrors(['message' => 'Account not found.']);
        }


        if ($account->balance > 0) {
            return back()->withErrors(['message' => 'You cannot delete an account which has funds in it.']);
        }

        if ($account['type'] === 'investment') {
            $activeInvestments = Investment::where('user_id', auth()->id())
                ->where('status', 'active')
                ->exists();

            if ($activeInvestments) {
                return back()->withErrors(['msg' => 'You can\'t delete this account because you have active investments on it.']);
            }
        }

        $account->delete();

        return redirect()->route('accounts')->with('success', 'Account deleted successfully.');
    }
}

