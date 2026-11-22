<?php

use LaraZeus\QrCode\DataTypes\SMS;

beforeEach(function () {
    $this->sms = new SMS;
});
test('it generates a proper format with a phone number', function () {
    $this->sms->create(['555-555-5555']);

    $properFormat = 'sms:555-555-5555';

    expect((string) $this->sms)->toEqual($properFormat);
});
test('it generate a proper format with a message', function () {
    $this->sms->create([null, 'foo']);

    $properFormat = 'sms:&body=foo';

    expect((string) $this->sms)->toEqual($properFormat);
});
test('it generates a proper format with a phone number and message', function () {
    $this->sms->create(['555-555-5555', 'foo']);

    $properFormat = 'sms:555-555-5555&body=foo';

    expect((string) $this->sms)->toEqual($properFormat);
});

test('it generates smsto format with a phone number', function () {
    $this->sms->create(['555-555-5555', null, 'smsto']);

    expect((string) $this->sms)->toEqual('smsto:555-555-5555');
});

test('it generates smsto format with a message', function () {
    $this->sms->create([null, 'foo', 'smsto']);

    expect((string) $this->sms)->toEqual('smsto::foo');
});

test('it generates smsto format with a phone number and message', function () {
    $this->sms->create(['555-555-5555', 'foo', 'smsto']);

    expect((string) $this->sms)->toEqual('smsto:555-555-5555:foo');
});

test('it normalizes smsto format with trailing colon or uppercase', function () {
    $this->sms->create(['555-555-5555', 'foo', 'SMSTO:']);

    expect((string) $this->sms)->toEqual('smsto:555-555-5555:foo');
});

test('it generates rfc format with a phone number and message', function () {
    $this->sms->create(['555-555-5555', 'foo', 'rfc']);

    expect((string) $this->sms)->toEqual('sms:555-555-5555?body=foo');
});

test('it throws an exception for an invalid sms format', function () {
    $this->sms->create(['555-555-5555', 'foo', 'invalid']);
})->throws(InvalidArgumentException::class);
