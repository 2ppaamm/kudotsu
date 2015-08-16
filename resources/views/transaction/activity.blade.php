<tr style="padding-bottom: 5px;">
    <td>
        {{$transaction->user->name}}
    </td>
    <td>
        {{$transaction->bank_account->account_number}}
    </td>
    <td>
        {{$transaction->currency->ISO_symbol}}
    </td>
    <td>
        {{$transaction->amount_in_txn_currency}}
    </td>
</tr>