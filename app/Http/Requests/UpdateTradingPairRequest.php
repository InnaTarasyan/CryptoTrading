<?php

namespace App\Http\Requests;

use App\Models\TradingPair;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTradingPairRequest extends FormRequest
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
        /** @var TradingPair $tradingPair */
        $tradingPair = $this->route('tradingPair');

        return [
            'coin' => [
                'required',
                'integer',
                'exists:live_coin_histories,id',
                Rule::unique('trading_pairs', 'coin')->ignore($tradingPair->id),
            ],
            'trading_pair' => 'required|string|max:255',
        ];
    }
}
