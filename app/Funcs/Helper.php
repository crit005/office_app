<?php

use App\Models\Balance;
use App\Models\TrCash;

// update table balances
if (!function_exists(function: 'updateBalance')) {
    function updateBalance($currencyID, $userID)
    {
        // total last balance with all user
        $userLastBalance = TrCash::where('status', '=', '1')
            ->where('currency_id', '=', $currencyID)
            ->where('created_by', '=', $userID)
            ->sum('amount'); //require function

        Balance::upsert(
            [
                'user_id' => $userID,
                'currency_id' => $currencyID,
                'current_balance' => $userLastBalance
            ],
            ['user_id', 'currency_id'],
            ['current_balance']
        );

        // total last balance for curren user
        $lastBalance = TrCash::where('status', '=', '1')
            ->where('currency_id', '=', $currencyID)
            ->sum('amount');

        Balance::upsert(
            [
                'user_id' => 0,
                'currency_id' => $currencyID,
                'current_balance' => $lastBalance
            ],
            ['user_id', 'currency_id'],
            ['current_balance']
        );
    }
}

if (!function_exists(function: 'getCurrencyBalance')) {
    function getCurrencyBalance($currencyId,$userId=null)
    {
        $currencyBalance = Balance::where('currency_id', '=', $currencyId)
        ->where('user_id', '=', $userId ?? auth()->user()->id)
        ->first();
        if($currencyBalance){
            return $currencyBalance->current_balance;
        }
        return null;
    }
}
