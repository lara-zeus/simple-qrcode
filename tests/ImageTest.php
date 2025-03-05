<?php

use LaraZeus\QrCode\Image;

beforeEach(function () {
    $this->imagePath = file_get_contents(__DIR__ . '/Images/simplesoftware-icon-grey-blue.png');
    $this->image = new Image($this->imagePath);

    $this->testImageSaveLocation = __DIR__ . '/testImage.png';
    $this->compareTestSaveLocation = __DIR__ . '/compareImage.png';
});
afterEach(function () {
    // @unlink($this->testImageSaveLocation);
    // @unlink($this->compareTestSaveLocation);
});
test('it loads an image string into a resource', function () {
    imagepng(imagecreatefromstring($this->imagePath), $this->compareTestSaveLocation);
    imagepng($this->image->getImageResource(), $this->testImageSaveLocation);

    $correctImage = file_get_contents($this->compareTestSaveLocation);
    $testImage = file_get_contents($this->testImageSaveLocation);

    expect($testImage)->toEqual($correctImage);
});
test('it gets the correct height', function () {
    $correctHeight = 512;

    $testHeight = $this->image->getHeight();

    expect($testHeight)->toEqual($correctHeight);
});
test('it gets the correct width', function () {
    $correctWidth = 512;

    $testWidth = $this->image->getWidth();

    expect($testWidth)->toEqual($correctWidth);
});
