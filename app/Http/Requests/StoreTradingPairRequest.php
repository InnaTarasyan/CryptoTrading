<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTradingPairRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'coin' => ['required', 'integer', 'exists:live_coin_histories,id', Rule::unique('trading_pairs', 'coin')],
            'trading_pair' => 'required|string|max:255',
        ];
    }
}
