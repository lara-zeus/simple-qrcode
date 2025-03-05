<?php

namespace LaraZeus\QrCode\DataTypes;

use BaconQrCode\Exception\InvalidArgumentException;

class Email implements DataTypeInterface
{
    /**
     * The prefix of the QrCode.
     */
    protected string $prefix = 'mailto:';

    /**
     * The email address.
     */
    protected string $email = '';

    /**
     * The subject of the email.
     */
    protected string $subject;

    /**
     * The body of an email.
     */
    protected ?string $body = null;

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
        return $this->buildEmailString();
    }

    /*
     * Builds the email string.
     *
     * @return string
     */
    protected function buildEmailString(): string
    {
        $email = $this->prefix . $this->email;

        if (isset($this->subject) || isset($this->body)) {
            $data = [
                'subject' => $this->subject,
                'body' => $this->body,
            ];
            $email .= '?' . http_build_query($data);
        }

        return $email;
    }

    /**
     * Sets the objects properties.
     */
    protected function setProperties(array $arguments): void
    {
        if (isset($arguments[0])) {
            $this->setEmail($arguments[0]);
        }
        if (isset($arguments[1])) {
            $this->subject = $arguments[1];
        }
        if (isset($arguments[2])) {
            $this->body = $arguments[2];
        }
    }

    /**
     * Sets the email property.
     */
    protected function setEmail($email): void
    {
        if ($this->isValidEmail($email)) {
            $this->email = $email;
        }
    }

    /**
     * Ensures an email is valid.
     *
     * @param  string  $email
     */
    protected function isValidEmail($email): bool
    {
        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid email provided');
        }

        return true;
    }
}
