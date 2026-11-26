<?php

require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();
use Cloudinary\Configuration\Configuration;

Configuration::instance($_ENV['CLOUDINARY_URL']);


use Cloudinary\Api\Upload\UploadApi;

function uploadImage($filePath) {
    // Upload to Cloudinary
    $result = (new UploadApi())->upload($filePath);
    return [
        'image_url' => $result['secure_url'],
        'public_id' => $result['public_id']
    ];
}


function deletePhoto($publicId) {
    $result = (new UploadApi())->destroy($publicId);
    return $result['result'] === 'ok';
}