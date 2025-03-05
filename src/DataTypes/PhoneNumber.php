<?php

namespace LaraZeus\QrCode\DataTypes;

class PhoneNumber implements DataTypeInterface
{
    /**
     * The prefix of the QrCode.
     */
    protected string $prefix = 'tel:';

    /**
     * The phone number.
     */
    protected string $phoneNumber;

    /**
     * Generates the DataType Object and sets all of its properties.
     */
    public function create(array $arguments): void
    {
        $this->phoneNumber = $arguments[0];
    }

    /**
     * Returns the correct QrCode format.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->prefix . $this->phoneNumber;
    }
}
