<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Validator;

class PasswordRule implements ValidationRule
{
    /**
     * Uppercase character pattern for strong password.
     */
    public const UPPERCASE_CHARACTER_PATTERN = '/[A-Z]/';

    /**
     * Lower character pattern for strong password.
     */
    public const LOWERCASE_CHARACTER_PATTERN = '/[a-z]/';

    /**
     * Number pattern for strong password.
     */
    public const NUMBER_PATTERN = '/[0-9]/';

    /**
     * Special character pattern for strong password.
     */
    public const SPECIAL_CHARACTER_PATTERN = '/[!"#$%&\'()*+,\-.\/:;<=>?@[\]^_`{|}~]/';

    /**
     * Min length for password.
     */
    public const MIN_LENGTH_CHARACTER_PATTERN = '/\S{1,}.{4,}\S{1,}/';

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return __('validation.' .
            ($this->isStrongPassword()
                ? 'password_field_validation_strong'
                : 'password_field_validation_description'), [
            'minLength' => 6,
        ]);
    }

    /**
     * @return string[]
     */
    public function getStrongPasswordValidationParameters(): array
    {
        return [
            'regex:' . self::UPPERCASE_CHARACTER_PATTERN,
            'regex:' . self::LOWERCASE_CHARACTER_PATTERN,
            'regex:' . self::NUMBER_PATTERN,
            'regex:' . self::SPECIAL_CHARACTER_PATTERN,
        ];
    }

    /**
     * @todo app setting.
     *
     * @return bool
     */
    public function isStrongPassword(): bool
    {
        return false;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $passwordParams = [
            'regex:' . self::MIN_LENGTH_CHARACTER_PATTERN,
        ];

        if ($this->isStrongPassword()) {
            $passwordParams = array_merge($passwordParams,
                $this->getStrongPasswordValidationParameters());
        }

        $validator = Validator::make(['password' => $value], [
            'password' => $passwordParams,
        ]);

        if (!$validator->passes()) {
            $messages = $validator->getMessageBag()->getMessages();
            $fail($messages['password'][0]);
        }
    }
}
