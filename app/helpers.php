<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

// Helpers here.
if (!function_exists('faker_image_path')) {
    function faker_image_path(string $resourceName): string
    {
        $cacheName = 'faker_image_folder_' . $resourceName;

        $files = Cache::remember($cacheName, 3000, function () use ($resourceName) {
            return Storage::disk('generate')->files($resourceName);
        });

        $image = $files[rand(0, count($files) - 1)];

        return Storage::disk('generate')->url($image);
    }
}
