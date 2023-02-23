<?php

declare(strict_types=1);

use App\Validation\PaymentRequestValidator;
use PHPUnit\Framework\TestCase;

class PaymentRequestValidatorTest extends TestCase
{
    /**
     * @dataProvider additionProvider
     */
    public function testValidate(array $request, array $expected): void
    {
        $validator = new PaymentRequestValidator();

        $actual = $validator->validate($request);

        $this->assertSame($expected, $actual);

    }

    public function additionProvider(): array
    {
        return [
            'All correct data'  => [
                [
                    'name' => 'Kanye West',
                    'cardNumber' => '123456789012',
                    'expiration' => '01/22',
                    'cvv' => '012',
                ], [

                ]
            ],
            'All incorrect data'  => [
                [
                    'name' => 'K West',
                    'cardNumber' => '12345678901234567890',
                    'expiration' => '13/22',
                    'cvv' => '2',
                ], [
                    'name' => 'Имя не может быть меньше 2 символов!',
                    'cardNumber' => 'Номер карты должен состоять из 12 цифр!',
                    'expiration' => 'Срок действия карты не коректен!',
                    'cvv' => 'cvv карты не коректен!'
                ]
            ],
            'All empty data'  => [
                [
                    'name' => '',
                    'cardNumber' => '',
                    'expiration' => '',
                    'cvv' => '',
                ], [
                    'name' => 'Параметр "name" не должно быть пустым',
                    'cardNumber' => 'Параметр "cardNumber" не должно быть пустым',
                    'expiration' => 'Параметр "expiration" не должно быть пустым',
                    'cvv' => 'Параметр "cvv" не должно быть пустым'
                ]
            ],
            'Cvv empty data'  => [
                [
                    'name' => 'Kanye West',
                    'cardNumber' => '123456789012',
                    'expiration' => '01/22',
                    'cvv' => '',
                ], [
                    'cvv' => 'Параметр "cvv" не должно быть пустым'
                ]
            ],
            'Name not string data'  => [
                [
                    'name' => 23344,
                    'cardNumber' => '123456789012',
                    'expiration' => '01/22',
                    'cvv' => '012',
                ], [
                    'name' => 'Имя должен быть строкой!'
                ]
            ],
            'Name 3 words data'  => [
                [
                    'name' => 'Kanye West Omari',
                    'cardNumber' => '123456789012',
                    'expiration' => '01/22',
                    'cvv' => '012',
                ], [
                    'name' => 'Имя должен состоять из 2 слов!'
                ]
            ],
            'Name one char data'  => [
                [
                    'name' => 'K West',
                    'cardNumber' => '123456789012',
                    'expiration' => '01/22',
                    'cvv' => '012',
                ], [
                    'name' => 'Имя не может быть меньше 2 символов!'
                ]
            ],
            'Card number incorrect data'  => [
                [
                    'name' => 'Kanye West',
                    'cardNumber' => '1234567890123456789',
                    'expiration' => '01/22',
                    'cvv' => '012',
                ], [
                    'cardNumber' => 'Номер карты должен состоять из 12 цифр!'
                ]
            ],
            'Expiration incorrect data'  => [
                [
                    'name' => 'Kanye West',
                    'cardNumber' => '123456789012',
                    'expiration' => '01/12',
                    'cvv' => '012',
                ], [
                    'expiration' => 'Срок действия карты не коректен!'
                ]
            ],
            'Cvv incorrect data'  => [
                [
                    'name' => 'Kanye West',
                    'cardNumber' => '123456789012',
                    'expiration' => '01/22',
                    'cvv' => '102',
                ], [
                    'cvv' => 'cvv карты не коректен!'
                ]
            ],
        ];
    }
}