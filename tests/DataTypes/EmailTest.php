<?php

use LaraZeus\QrCode\DataTypes\Email;

beforeEach(function () {
    $this->email = new Email;
});
test('it generates the proper format when only an email address is supplied', function () {
    $this->email->create(['foo@bar.com']);

    $properFormat = 'mailto:foo@bar.com';

    expect((string) $this->email)->toEqual($properFormat);
});
test('it generates the proper format when an email subject and body are supplied', function () {
    $this->email->create(['foo@bar.com', 'foo', 'bar']);

    $properFormat = 'mailto:foo@bar.com?subject=foo&body=bar';

    expect((string) $this->email)->toEqual($properFormat);
});
test('it generates the proper format when an email and subject are supplied', function () {
    $this->email->create(['foo@bar.com', 'foo']);

    $properFormat = 'mailto:foo@bar.com?subject=foo';

    expect((string) $this->email)->toEqual($properFormat);
});
test('it generates the proper format when only a subject is provided', function () {
    $this->email->create([null, 'foo']);

    $properFormat = 'mailto:?subject=foo';

    expect((string) $this->email)->toEqual($properFormat);
});
test('it throws an exception when an invalid email is given', function () {
    $this->expectException(InvalidArgumentException::class);

    $this->email->create(['foo']);
});
