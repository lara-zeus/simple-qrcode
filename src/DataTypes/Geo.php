<?php

namespace LaraZeus\QrCode\DataTypes;

class Geo implements DataTypeInterface
{
    /**
     * The prefix of the QrCode.
     */
    protected string $prefix = 'geo:';

    /**
     * The separator between the variables.
     */
    protected string $separator = ',';

    /**
     * The latitude.
     */
    protected string $latitude;

    /**
     * The longitude.
     */
    protected string $longitude;

    /**
     * Generates the DataType Object and sets all of its properties.
     */
    public function create(array $arguments): void
    {
        $this->latitude = $arguments[0];
        $this->longitude = $arguments[1];
    }

    /**
     * Returns the correct QrCode format.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->prefix . $this->latitude . $this->separator . $this->longitude;
    }
}
