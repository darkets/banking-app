<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Currency;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function create(Request $request): View
    {
        $identifier = $request->get('identifier');
        return view('transaction.create', ['identifier' => $identifier]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $this->validateTransferRequest($request);

        $sourceAccount = $this->getAccountByIdentifier($validatedData['fromAccount']);
        $destinationAccount = $this->getAccountByIdentifier($validatedData['toAccount']);

        if (!$sourceAccount || !$destinationAccount) {
            return back()->withErrors(['message' => 'One or both of the accounts were not found.']);
        }

        $transferAmountInCents = $validatedData['amount'] * 100;

        if ($sourceAccount->balance < $transferAmountInCents) {
            return back()->withErrors(['message' => 'Insufficient funds.']);
        }

        $this->executeTransfer($sourceAccount, $destinationAccount, $transferAmountInCents, $validatedData);

        return redirect()->route('accounts')->with('success', 'Transfer completed successfully');
    }

    protected function validateTransferRequest(Request $request): array
    {
        return $request->validate([
            'fromAccount' => 'required',
            'toAccount' => 'required',
            'amount' => 'required|numeric|min:0.01',
            'note' => 'required',
        ]);
    }

    protected function getAccountByIdentifier($identifier): ?Account
    {
        return Account::where('identifier', $identifier)->first();
    }

    protected function executeTransfer($sourceAccount, $destinationAccount, $transferAmountInCents, $validatedData): void
    {
        DB::transaction(function () use ($sourceAccount, $destinationAccount, $transferAmountInCents, $validatedData) {
            $sourceAccount->balance -= $transferAmountInCents;
            $sourceAccount->save();

            $adjustedAmount = $this->adjustAmountForCurrency($sourceAccount, $destinationAccount, $transferAmountInCents);

            $destinationAccount->balance += $adjustedAmount;
            $destinationAccount->save();

            $this->recordTransaction($sourceAccount, $destinationAccount, $transferAmountInCents, $adjustedAmount, $validatedData['note']);
        });
    }

    protected function adjustAmountForCurrency($sourceAccount, $destinationAccount, $amount): int
    {
        if ($sourceAccount->currency != $destinationAccount->currency) {
            $sourceCurrencyRate = $this->getCurrencyRate($sourceAccount->currency);
            $destinationCurrencyRate = $this->getCurrencyRate($destinationAccount->currency);

            $amountInBaseCurrency = $amount / $sourceCurrencyRate;
            return $amountInBaseCurrency * $destinationCurrencyRate;
        }

        return $amount;
    }

    protected function getCurrencyRate($currency): float
    {
        return $currency == 'EUR' ? 1 : Currency::where('symbol', $currency)->first()->rate;
    }

    protected function recordTransaction($sourceAccount, $destinationAccount, $sentAmount, $receivedAmount, $note): void
    {
        Transaction::create([
            'from_account' => $sourceAccount->identifier,
            'to_account' => $destinationAccount->identifier,
            'sent_amount' => $sentAmount,
            'received_amount' => $receivedAmount,
            'sent_currency' => $sourceAccount->currency,
            'received_currency' => $destinationAccount->currency,
            'payment_note' => $note
        ]);
    }
}
