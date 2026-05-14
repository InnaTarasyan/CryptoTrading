<?php

namespace App\Http\Requests;

use App\Models\ApiKey;
use App\Policies\ApiKeyPolicy;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class GenerateApiKeyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', ApiKey::class);
    }

    protected function failedAuthorization(): void
    {
        throw new HttpResponseException(
            back()->with(
                'error',
                'You can only have a maximum of '.ApiKeyPolicy::MAX_KEYS_PER_USER.' API keys.'
            )
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'permissions' => 'required|array|min:1',
            'permissions.*' => [
                'string',
                Rule::in(ApiKey::getAvailablePermissions()),
            ],
        ];
    }
}
