<?php

namespace LaraZeus\QrCode\DataTypes;

use InvalidArgumentException;

class SMS implements DataTypeInterface
{
    /**
     * The prefix of the QrCode.
     */
    protected string $prefix = 'sms:';

    /**
     * The separator between the variables.
     */
    protected string $separator = '&body=';

    /**
     * The phone number.
     */
    protected string $phoneNumber = '';

    /**
     * The SMS message.
     */
    protected string $message;

    /**
     * Generates the DataType Object and sets all of its properties.
     */
    public function create(array $arguments): void
    {
        $this->setProperties($arguments);
    }

    /**
     * Returns the correct QrCode format.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->buildSMSString();
    }

    /**
     * Sets the phone number, message, and optional format for an SMS message.
     */
    protected function setProperties(array $arguments): void
    {
        if (isset($arguments[0])) {
            $this->phoneNumber = $arguments[0];
        }
        if (isset($arguments[1])) {
            $this->message = $arguments[1];
        }
        if (isset($arguments[2])) {
            $this->setFormat($arguments[2]);
        }
    }

    /**
     * Sets the prefix and separator based on the requested SMS format.
     */
    protected function setFormat(string $format): void
    {
        $normalized = strtolower(rtrim($format, ':'));

        match ($normalized) {
            'sms' => [$this->prefix, $this->separator] = ['sms:', '&body='],
            'smsto' => [$this->prefix, $this->separator] = ['smsto:', ':'],
            'rfc' => [$this->prefix, $this->separator] = ['sms:', '?body='],
            default => throw new InvalidArgumentException("Invalid SMS format: {$format}. Supported formats are: sms, smsto, rfc."),
        };
    }

    /**
     * Builds a SMS string.
     */
    protected function buildSMSString(): string
    {
        $sms = $this->prefix . $this->phoneNumber;

        if (isset($this->message)) {
            $sms .= $this->separator . $this->message;
        }

        return $sms;
    }
}
