<?php

use BaconQrCode\Renderer\Eye\SimpleCircleEye;
use BaconQrCode\Renderer\Eye\SquareEye;
use BaconQrCode\Renderer\Image\EpsImageBackEnd;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\Module\DotsModule;
use BaconQrCode\Renderer\Module\RoundnessModule;
use BaconQrCode\Renderer\Module\SquareModule;
use BaconQrCode\Renderer\RendererStyle\Gradient;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use Illuminate\Support\HtmlString;
use LaraZeus\QrCode\Generator;

test('chaining is possible', function () {
    expect((new Generator)->size(100))->toBeInstanceOf(Generator::class)
        ->and((new Generator)->format('eps'))->toBeInstanceOf(Generator::class)
        ->and((new Generator)->color(255, 255, 255))->toBeInstanceOf(Generator::class)
        ->and((new Generator)->backgroundColor(255, 255, 255))->toBeInstanceOf(Generator::class)
        ->and((new Generator)->eyeColor(0, 255, 255, 255, 0, 0, 0))->toBeInstanceOf(Generator::class)
        ->and((new Generator)->gradient(255, 255, 255, 0, 0, 0, 'vertical'))->toBeInstanceOf(Generator::class)
        ->and((new Generator)->eye('circle'))->toBeInstanceOf(Generator::class)
        ->and((new Generator)->style('round'))->toBeInstanceOf(Generator::class)
        ->and((new Generator)->encoding('UTF-8'))->toBeInstanceOf(Generator::class)
        ->and((new Generator)->errorCorrection('H'))->toBeInstanceOf(Generator::class)
        ->and((new Generator)->margin(2))->toBeInstanceOf(Generator::class);
});
test('size is passed to the renderer', function () {
    $generator = (new Generator)->size(100);

    expect($generator->getRendererStyle()->getSize())->toEqual(100);
});
test('format sets the image format', function () {
    // Disabled until GitHub actions config can be updated to pull in imagick
    // $generator = (new Generator)->format('png');
    // $this->assertInstanceOf(ImagickImageBackEnd::class, $generator->getFormatter());
    $generator = (new Generator)->format('svg');
    expect($generator->getFormatter())->toBeInstanceOf(SvgImageBackEnd::class);

    $generator = (new Generator)->format('eps');
    expect($generator->getFormatter())->toBeInstanceOf(EpsImageBackEnd::class);
});
test('an exception is thrown if an unsupported format is used', function () {
    $this->expectException(InvalidArgumentException::class);

    (new Generator)->format('foo');
});
test('color is set', function () {
    $generator = (new Generator)->color(50, 75, 100);
    expect($generator->getFill()->getForegroundColor()->toRgb()->getRed())->toEqual(50)
        ->and($generator->getFill()->getForegroundColor()->toRgb()->getGreen())->toEqual(75)
        ->and($generator->getFill()->getForegroundColor()->toRgb()->getBlue())->toEqual(100);

    $generator = (new Generator)->color(50, 75, 100, 25);
    expect($generator->getFill()->getForegroundColor()->getAlpha())->toEqual(25)
        ->and($generator->getFill()->getForegroundColor()->toRgb()->getRed())->toEqual(50)
        ->and($generator->getFill()->getForegroundColor()->toRgb()->getGreen())->toEqual(75)
        ->and($generator->getFill()->getForegroundColor()->toRgb()->getBlue())->toEqual(100);

    $generator = (new Generator)->color(50, 75, 100, 0);
    expect($generator->getFill()->getForegroundColor()->getAlpha())->toEqual(0)
        ->and($generator->getFill()->getForegroundColor()->toRgb()->getRed())->toEqual(50)
        ->and($generator->getFill()->getForegroundColor()->toRgb()->getGreen())->toEqual(75)
        ->and($generator->getFill()->getForegroundColor()->toRgb()->getBlue())->toEqual(100);
});
test('background color is set', function () {
    $generator = (new Generator)->backgroundColor(50, 75, 100);
    expect($generator->getFill()->getBackgroundColor()->toRgb()->getRed())->toEqual(50)
        ->and($generator->getFill()->getBackgroundColor()->toRgb()->getGreen())->toEqual(75)
        ->and($generator->getFill()->getBackgroundColor()->toRgb()->getBlue())->toEqual(100);

    $generator = (new Generator)->backgroundColor(50, 75, 100, 25);
    expect($generator->getFill()->getBackgroundColor()->getAlpha())->toEqual(25)
        ->and($generator->getFill()->getBackgroundColor()->toRgb()->getRed())->toEqual(50)
        ->and($generator->getFill()->getBackgroundColor()->toRgb()->getGreen())->toEqual(75)
        ->and($generator->getFill()->getBackgroundColor()->toRgb()->getBlue())->toEqual(100);
});
test('eye color is set', function () {
    $generator = (new Generator)->eyeColor(0, 0, 0, 0, 255, 255, 255);
    $generator = $generator->eyeColor(1, 0, 0, 0, 255, 255, 255);
    $generator = $generator->eyeColor(2, 0, 0, 0, 255, 255, 255);

    expect($generator->getFill()->getTopLeftEyeFill()->getExternalColor()->getRed())->toEqual(0)
        ->and($generator->getFill()->getTopLeftEyeFill()->getExternalColor()->getGreen())->toEqual(0)
        ->and($generator->getFill()->getTopLeftEyeFill()->getExternalColor()->getBlue())->toEqual(0)
        ->and($generator->getFill()->getTopLeftEyeFill()->getInternalColor()->getRed())->toEqual(255)
        ->and($generator->getFill()->getTopLeftEyeFill()->getInternalColor()->getGreen())->toEqual(255)
        ->and($generator->getFill()->getTopLeftEyeFill()->getInternalColor()->getBlue())->toEqual(255)
        ->and($generator->getFill()->getTopRightEyeFill()->getExternalColor()->getRed())->toEqual(0)
        ->and($generator->getFill()->getTopRightEyeFill()->getExternalColor()->getGreen())->toEqual(0)
        ->and($generator->getFill()->getTopRightEyeFill()->getExternalColor()->getBlue())->toEqual(0)
        ->and($generator->getFill()->getTopRightEyeFill()->getInternalColor()->getRed())->toEqual(255)
        ->and($generator->getFill()->getTopRightEyeFill()->getInternalColor()->getGreen())->toEqual(255)
        ->and($generator->getFill()->getTopRightEyeFill()->getInternalColor()->getBlue())->toEqual(255);

    $generator = (new Generator)->eyeColor(2, 0, 0, 0, 255, 255, 255);
    expect($generator->getFill()->getBottomLeftEyeFill()->getExternalColor()->getRed())->toEqual(0)
        ->and($generator->getFill()->getBottomLeftEyeFill()->getExternalColor()->getGreen())->toEqual(0)
        ->and($generator->getFill()->getBottomLeftEyeFill()->getExternalColor()->getBlue())->toEqual(0)
        ->and($generator->getFill()->getBottomLeftEyeFill()->getInternalColor()->getRed())->toEqual(255)
        ->and($generator->getFill()->getBottomLeftEyeFill()->getInternalColor()->getGreen())->toEqual(255)
        ->and($generator->getFill()->getBottomLeftEyeFill()->getInternalColor()->getBlue())->toEqual(255);
});
test('eye color throws exception with number greater than 2', function () {
    $this->expectException(InvalidArgumentException::class);
    (new Generator)->eyeColor(3, 0, 0, 0, 255, 255, 255);
});
test('eye color throws exception with negative number', function () {
    $this->expectException(InvalidArgumentException::class);
    (new Generator)->eyeColor(-1, 0, 0, 0, 255, 255, 255);
});
test('grandient is set', function () {
    $generator = (new Generator)->gradient(0, 0, 0, 255, 255, 255, 'vertical');
    expect($generator->getFill()->getForegroundGradient())->toBeInstanceOf(Gradient::class);
});
test('eye style is set', function () {
    $generator = (new Generator)->eye('circle');
    expect($generator->getEye())->toBeInstanceOf(SimpleCircleEye::class);

    $generator = (new Generator)->eye('square');
    expect($generator->getEye())->toBeInstanceOf(SquareEye::class);
});
test('invalid eye throws an exception', function () {
    $this->expectException(InvalidArgumentException::class);
    (new Generator)->eye('foo');
});
test('style is set', function () {
    $generator = (new Generator)->style('square');
    expect($generator->getModule())->toBeInstanceOf(SquareModule::class);

    $generator = (new Generator)->style('dot', .1);
    expect($generator->getModule())->toBeInstanceOf(DotsModule::class);

    $generator = (new Generator)->style('round', .3);
    expect($generator->getModule())->toBeInstanceOf(RoundnessModule::class);
});
test('an exception is thrown for an invalid style', function () {
    $this->expectException(InvalidArgumentException::class);
    (new Generator)->style('foo');
});
test('an exception is thrown for a number over 1', function () {
    $this->expectException(InvalidArgumentException::class);
    (new Generator)->style('round', 1.1);
});
test('an exception is thrown for a number under 0', function () {
    $this->expectException(InvalidArgumentException::class);
    (new Generator)->style('round', -.1);
});
test('an exception is thrown for 1', function () {
    $this->expectException(InvalidArgumentException::class);
    (new Generator)->style('round', 1);
});
test('get renderer returns renderer', function () {
    expect((new Generator)->getRendererStyle())->toBeInstanceOf(RendererStyle::class);
});
test('it throws an exception if datatype is not found', function () {
    $this->expectException(BadMethodCallException::class);
    (new Generator)->notReal('fooBar');
});
test('generator can return illuminate support htmlstring', function () {
    $this->getMockBuilder(HtmlString::class)->getMock();
    expect((new Generator)->generate('fooBar'))->toBeInstanceOf(HtmlString::class);
});
