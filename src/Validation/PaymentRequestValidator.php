<?php

declare(strict_types=1);

namespace App\Validation;

class PaymentRequestValidator
{
    private const NOT_EMPTY_FIELDS = ['name', 'cardNumber', 'expiration', 'cvv'];
    private const MIN_NAME_LENGTH = 2;
    private const MIN_NAME_WORD_NUMBER = 2;

    public function validate(array $request): array
    {
        //  здесь должен быть код валидации запроса
        $errors = $this->validateNotEmpty($request);

        if (!empty($errors)) {
            return $errors;
        }

        return array_merge(
            $this->validateName($request),
            $this->validateCardNumber($request),
            $this->validateExpiration($request),
            $this->validateCvv($request)
        );
    }

    private function validateNotEmpty(array $data): array
    {
        $errors = [];

        foreach (self::NOT_EMPTY_FIELDS as $fieldName) {
            $value = $data[$fieldName] ?? null;

            if (empty($value)) {
                $errors[$fieldName] = 'Параметр "' . $fieldName . '" не должно быть пустым';
            }
        }

        return $errors;
    }

    private function validateName(array $data): array
    {
        if (!is_string($data['name'])) {
            return [
                'name' => 'Имя должен быть строкой!'
            ];
        } else {

            $nameWords = explode(" ", $data['name']);
            $wordNums = count($nameWords);

            if($wordNums!=self::MIN_NAME_WORD_NUMBER) {
                return [
                    'name' => 'Имя должен состоять из ' . self::MIN_NAME_WORD_NUMBER . ' слов!'
                ];
            } else {

                $nameLength = min(strlen($nameWords[1]), strlen($nameWords[0]));

                if ($nameLength < self::MIN_NAME_LENGTH) {
                    return [
                        'name' => 'Имя не может быть меньше ' . self::MIN_NAME_LENGTH . ' символов!'
                    ];
                } else {

                    return [];

                }
            }
        }
    }

    private function validateCardNumber(array $data): array
    {
        if (preg_match('/^[0-9]{12}+$/', $data['cardNumber'])) {

            return [];

        } else {

            return [
                'cardNumber' => 'Номер карты должен состоять из 12 цифр!'
            ];
        }
    }

    private function validateExpiration(array $data): array
    {
        if (preg_match('/^(0[1-9]|1[0-2])\/2[2-5]$/', $data['expiration'])) {

            return [];

        } else {

            return [
                'expiration' => 'Срок действия карты не коректен!'
            ];
        }
    }
    private function validateCvv(array $data): array
    {
        if (preg_match('/^([0-9][1-9][1-9])$/', $data['cvv'])) {

            return [];

        } else {

            return [
                'cvv' => 'cvv карты не коректен!'
            ];
        }
    }
}
