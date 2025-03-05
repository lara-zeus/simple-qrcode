<?php

namespace LaraZeus\QrCode;

use GdImage;

class Image
{
    /**
     * Holds the image resource.
     */
    protected GdImage | false $image;

    /**
     * Creates a new Image object.
     *
     * @param  string  $image  An image string
     */
    public function __construct(string $image)
    {
        $this->image = imagecreatefromstring($image);
    }

    /*
     * Returns the width of an image
     *
     * @return int
    */
    public function getWidth(): false | int
    {
        return imagesx($this->image);
    }

    /*
     * Returns the height of an image
     *
     * @return int
     */
    public function getHeight(): false | int
    {
        return imagesy($this->image);
    }

    /**
     * Returns the image string.
     */
    public function getImageResource(): GdImage | false
    {
        return $this->image;
    }

    /**
     * Sets the image string.
     */
    public function setImageResource($image): void
    {
        $this->image = $image;
    }
}
