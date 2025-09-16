<?php

namespace App\Services;

use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Configuration\Configuration;
use Cloudinary\Cloudinary;
use Exception;
use Illuminate\Http\UploadedFile;

class CloudinaryService
{
    protected $cloudinary;
    protected $uploadApi;

    public function __construct()
    {
        Configuration::instance([
            'cloud' => [
                'cloud_name' => config('cloudinary.cloud_name'),
                'api_key' => config('cloudinary.api_key'),
                'api_secret' => config('cloudinary.api_secret'),
            ],
            'url' => [
                'secure' => true,
            ],
        ]);

        $this->cloudinary = new Cloudinary();
        $this->uploadApi = new UploadApi();
    }

    /**
     * Upload an image to Cloudinary
     *
     * @param UploadedFile $file
     * @param string $folder
     * @param array $options
     * @return array
     * @throws Exception
     */
    public function uploadImage(UploadedFile $file, string $folder = 'general', array $options = []): array
    {
        try {
            $defaultOptions = [
                'folder' => config("cloudinary.folders.{$folder}", "pharmacy/{$folder}"),
                'resource_type' => 'image',
                'quality' => 'auto',
                'fetch_format' => 'auto',
            ];

            $uploadOptions = array_merge($defaultOptions, $options);

            $result = $this->uploadApi->upload($file->getRealPath(), $uploadOptions);

            return [
                'success' => true,
                'public_id' => $result['public_id'],
                'secure_url' => $result['secure_url'],
                'url' => $result['url'],
                'width' => $result['width'],
                'height' => $result['height'],
                'format' => $result['format'],
                'bytes' => $result['bytes'],
                'created_at' => $result['created_at'],
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Delete an image from Cloudinary
     *
     * @param string $publicId
     * @return array
     */
    public function deleteImage(string $publicId): array
    {
        try {
            $result = $this->uploadApi->destroy($publicId);

            return [
                'success' => true,
                'result' => $result['result'] ?? 'ok',
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Generate a transformed image URL
     *
     * @param string $publicId
     * @param array $transformations
     * @return string
     */
    public function getTransformedUrl(string $publicId, array $transformations = []): string
    {
        $imageTag = $this->cloudinary->image($publicId);

        if (!empty($transformations)) {
            $width = $transformations['width'] ?? null;
            $height = $transformations['height'] ?? null;
            $crop = $transformations['crop'] ?? 'fill';

            if ($width && $height) {
                $imageTag->resize(\Cloudinary\Transformation\Resize::fill($width, $height));
            } elseif ($width) {
                $imageTag->resize(\Cloudinary\Transformation\Resize::scale($width));
            }
        }

        return $imageTag->toUrl();
    }

    /**
     * Get category image URLs with different sizes
     *
     * @param string $publicId
     * @return array
     */
    public function getCategoryImageUrls(string $publicId): array
    {
        $transformations = config('cloudinary.transformations.category');

        return [
            'original' => $this->cloudinary->image($publicId)->toUrl(),
            'thumbnail' => $this->getTransformedUrl($publicId, $transformations['thumbnail']),
            'medium' => $this->getTransformedUrl($publicId, $transformations['medium']),
            'large' => $this->getTransformedUrl($publicId, $transformations['large']),
        ];
    }

    /**
     * Get product image URLs with different sizes
     *
     * @param string $publicId
     * @return array
     */
    public function getProductImageUrls(string $publicId): array
    {
        $transformations = config('cloudinary.transformations.product');

        return [
            'original' => $this->cloudinary->image($publicId)->toUrl(),
            'thumbnail' => $this->getTransformedUrl($publicId, $transformations['thumbnail']),
            'medium' => $this->getTransformedUrl($publicId, $transformations['medium']),
            'large' => $this->getTransformedUrl($publicId, $transformations['large']),
        ];
    }

    /**
     * Validate image file
     *
     * @param UploadedFile $file
     * @return array
     */
    public function validateImage(UploadedFile $file): array
    {
        $allowedMimeTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        $maxSize = 5 * 1024 * 1024; // 5MB

        if (!in_array($file->getMimeType(), $allowedMimeTypes)) {
            return [
                'valid' => false,
                'error' => 'Invalid file type. Only JPEG, PNG, GIF, and WebP images are allowed.',
            ];
        }

        if ($file->getSize() > $maxSize) {
            return [
                'valid' => false,
                'error' => 'File size too large. Maximum size allowed is 5MB.',
            ];
        }

        return ['valid' => true];
    }
}
