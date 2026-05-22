<?php

require __DIR__.'/vendor/autoload.php';
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

$manager = new ImageManager(new Driver);
$image = $manager->decodePath('public/favicon.ico');
print_r(get_class_methods($image));
