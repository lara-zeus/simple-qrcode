<?php

namespace LaraZeus\QrCode;

use InvalidArgumentException;

class ImageMerge
{
    /**
     * Holds the QrCode image.
     */
    protected Image $sourceImage;

    /**
     * Holds the merging image.
     */
    protected Image $mergeImage;

    /**
     * The height of the source image.
     */
    protected int $sourceImageHeight;

    /**
     * The width of the source image.
     */
    protected int $sourceImageWidth;

    /**
     * The height of the merge image.
     */
    protected int $mergeImageHeight;

    /**
     * The width of the merge image.
     */
    protected int $mergeImageWidth;

    /**
     * Holds the radio of the merging image.
     */
    protected float $mergeRatio;

    /**
     * The height of the merge image after it is merged.
     */
    protected int $postMergeImageHeight;

    /**
     * The width of the merge image after it is merged.
     */
    protected int $postMergeImageWidth;

    /**
     * The position that the merge image is placed on top of the source image.
     */
    protected int $centerY;

    /**
     * The position that the merge image is placed on top of the source image.
     */
    protected int $centerX;

    /**
     * Creates a new ImageMerge object.
     *
     * @param  $sourceImage  Image The image that will be merged over.
     * @param  $mergeImage  Image The image that will be used to merge with $sourceImage
     */
    public function __construct(Image $sourceImage, Image $mergeImage)
    {
        $this->sourceImage = $sourceImage;
        $this->mergeImage = $mergeImage;
    }

    /**
     * Returns an QrCode that has been merge with another image.
     * This is usually used with logos to imprint a logo into a QrCode.
     *
     * @param  $percentage  float The percentage of size relative to the entire QR of the merged image
     */
    public function merge(float $percentage): string
    {
        $this->setProperties($percentage);

        $img = imagecreatetruecolor($this->sourceImage->getWidth(), $this->sourceImage->getHeight());
        imagealphablending($img, true);
        $transparent = imagecolorallocatealpha($img, 0, 0, 0, 127);
        imagefill($img, 0, 0, $transparent);

        imagecopy(
            $img,
            $this->sourceImage->getImageResource(),
            0,
            0,
            0,
            0,
            $this->sourceImage->getWidth(),
            $this->sourceImage->getHeight()
        );

        imagecopyresampled(
            $img,
            $this->mergeImage->getImageResource(),
            $this->centerX,
            $this->centerY,
            0,
            0,
            $this->postMergeImageWidth,
            $this->postMergeImageHeight,
            $this->mergeImageWidth,
            $this->mergeImageHeight
        );

        $this->sourceImage->setImageResource($img);

        return $this->createImage();
    }

    /**
     * Creates a PNG Image.
     */
    protected function createImage(): string
    {
        ob_start();
        imagepng($this->sourceImage->getImageResource());

        return ob_get_clean();
    }

    /**
     * Sets the objects properties.
     *
     * @param  $percentage  float The percentage that the merge image should take up.
     */
    protected function setProperties($percentage): void
    {
        if ($percentage > 1) {
            throw new InvalidArgumentException('$percentage must be less than 1');
        }

        $this->sourceImageHeight = $this->sourceImage->getHeight();
        $this->sourceImageWidth = $this->sourceImage->getWidth();

        $this->mergeImageHeight = $this->mergeImage->getHeight();
        $this->mergeImageWidth = $this->mergeImage->getWidth();

        $this->calculateOverlap($percentage);
        $this->calculateCenter();
    }

    /**
     * Calculates the center of the source Image using the Merge image.
     */
    protected function calculateCenter(): void
    {
        $this->centerX = (int) (($this->sourceImageWidth / 2) - ($this->postMergeImageWidth / 2));
        $this->centerY = (int) (($this->sourceImageHeight / 2) - ($this->postMergeImageHeight / 2));
    }

    /**
     * Calculates the width of the merge image being placed on the source image.
     *
     * @param  float  $percentage
     */
    protected function calculateOverlap($percentage): void
    {
        $this->mergeRatio = round($this->mergeImageWidth / $this->mergeImageHeight, 2);
        $this->postMergeImageWidth = (int) ($this->sourceImageWidth * $percentage);
        $this->postMergeImageHeight = (int) ($this->postMergeImageWidth / $this->mergeRatio);
    }
}
