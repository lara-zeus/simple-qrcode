<?php

use LaraZeus\QrCode\Image;
use LaraZeus\QrCode\ImageMerge;

beforeEach(function () {
    $this->testImagePath = file_get_contents(__DIR__ . '/Images/simplesoftware-icon-grey-blue.png');
    $this->mergeImagePath = file_get_contents(__DIR__ . '/Images/200x300.png');
    $this->testImage = new ImageMerge(
        new Image($this->testImagePath),
        new Image($this->mergeImagePath)
    );

    $this->testImageSaveLocation = __DIR__ . '/testImage.png';
    $this->compareTestSaveLocation = __DIR__ . '/compareImage.png';
});
afterEach(function () {
    // @unlink($this->testImageSaveLocation);
    // @unlink($this->compareTestSaveLocation);
});
test('it merges two images together and centers it', function () {
    // We know the source image is 512x512 and the merge image is 200x300
    $source = imagecreatefromstring($this->testImagePath);
    $merge = imagecreatefromstring($this->mergeImagePath);

    // Create a PNG and place the image in the middle using 20% of the area.
    imagecopyresampled(
        $source,
        $merge,
        205,
        222,
        0,
        0,
        102,
        67,
        536,
        354
    );
    imagepng($source, $this->compareTestSaveLocation);

    $testImage = $this->testImage->merge(.2);
    file_put_contents($this->testImageSaveLocation, $testImage);

    $this->assertFileEquals($this->compareTestSaveLocation, $this->testImageSaveLocation);
});
test('it throws an exception when percentage is greater than 1', function () {
    $this->expectException(InvalidArgumentException::class);
    $this->testImage->merge(1.1);
});
