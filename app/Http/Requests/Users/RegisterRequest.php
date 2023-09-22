<?php

namespace App\Http\Requests\Users;

use App\Rules\PasswordRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * @var PasswordRule
     */
    private $passwordRule;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->guest();
    }

    /**
     * @return PasswordRule
     */
    public function getPasswordRule(): PasswordRule
    {
        if (!$this->passwordRule instanceof PasswordRule) {
            $this->passwordRule = resolve(PasswordRule::class);
        }

        return $this->passwordRule;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'user_name'  => ['required', 'string', 'unique:users'],
            'full_name'  => ['required', 'string'],
            'first_name' => ['required', 'string'],
            'last_name'  => ['required', 'string'],
            'email'      => ['required', 'string', 'email', 'unique:users'],
            'password'   => ['required', 'string', $this->getPasswordRule()],
            'agree'      => ['required', 'accepted'],
        ];
    }

    /**
     * @return array<mixed>
     */
    public function validated($key = null, $default = null): array
    {
        $data = parent::validated($key, $default);

        // Only allow spaces between characters
        $data['password'] = trim($data['password']);

        return $data;
    }

    /**
     * @return array<string, mixed>
     */
    public function messages(): array
    {
        return [
            'agree.accepted'    => __('validation.required', ['attribute' => 'agree']),
            'password.required' => __('validation.password_field_validation_required'),
        ];
    }
}
