<?php
use Intervention\Image\ImageManager;
$manager = new ImageManager(array('driver' => 'imagick'));

return [

    /*
    |--------------------------------------------------------------------------
    | Image Driver
    |--------------------------------------------------------------------------
    |
    | Intervention Image supports "GD Library" and "Imagick" to process images
    | internally. You may choose one of them according to your PHP
    | configuration. By default PHP's "GD Library" implementation is used.
    |
    | Supported: "gd", "imagick"
    |
    */


    'driver' => 'gd',
//        Image::configure(array('driver' => 'imagick'))


];

