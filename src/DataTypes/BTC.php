<?php

namespace LaraZeus\QrCode\DataTypes;

class BTC implements DataTypeInterface
{
    /**
     * The prefix of the QrCode.
     */
    protected string $prefix = 'bitcoin:';

    /**
     * The BitCoin address.
     */
    protected string $address;

    /**
     * The amount to send.
     */
    protected float $amount;

    /**
     * The BitCoin transaction label.
     */
    protected ?string $label = null;

    /**
     * The BitCoin message to send.
     */
    protected ?string $message = null;

    /**
     * The BitCoin return URL.
     */
    protected ?string $returnAddress = null;

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
        return $this->buildBitCoinString();
    }

    /**
     * Sets the BitCoin arguments.
     */
    protected function setProperties(array $arguments): void
    {
        if (isset($arguments[0])) {
            $this->address = $arguments[0];
        }

        if (isset($arguments[1])) {
            $this->amount = $arguments[1];
        }

        if (isset($arguments[2])) {
            $this->setOptions($arguments[2]);
        }
    }

    /**
     * Sets the optional BitCoin options.
     */
    protected function setOptions(array $options): void
    {
        if (isset($options['label'])) {
            $this->label = $options['label'];
        }

        if (isset($options['message'])) {
            $this->message = $options['message'];
        }

        if (isset($options['returnAddress'])) {
            $this->returnAddress = $options['returnAddress'];
        }
    }

    /**
     * Builds a BitCoin string.
     */
    protected function buildBitCoinString(): string
    {
        $query = http_build_query([
            'amount' => $this->amount,
            'label' => $this->label,
            'message' => $this->message,
            'r' => $this->returnAddress,
        ]);

        return $this->prefix . $this->address . '?' . $query;
    }
}
