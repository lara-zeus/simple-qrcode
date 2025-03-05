<?php

use LaraZeus\QrCode\DataTypes\BTC;

beforeEach(function () {
    $this->btc = new BTC;
});
test('it generates a valid btc qrcode with an address and amount', function () {
    $this->btc->create(['btcaddress', 0.0034]);

    $properFormat = 'bitcoin:btcaddress?amount=0.0034';

    expect((string) $this->btc)->toEqual($properFormat);
});
test('it generates a valid btc qrcode with an address amount and label', function () {
    $this->btc->create(['btcaddress', 0.0034, ['label' => 'label']]);

    $properFormat = 'bitcoin:btcaddress?amount=0.0034&label=label';

    expect((string) $this->btc)->toEqual($properFormat);
});
test('it generates a valid btc qrcode with an address amount label message and return address', function () {
    $this->btc->create([
        'btcaddress',
        0.0034,
        [
            'label' => 'label',
            'message' => 'message',
            'returnAddress' => 'https://www.returnaddress.com',
        ],
    ]);

    $properFormat = 'bitcoin:btcaddress?amount=0.0034&label=label&message=message&r=' . urlencode('https://www.returnaddress.com');

    expect((string) $this->btc)->toEqual($properFormat);
});
