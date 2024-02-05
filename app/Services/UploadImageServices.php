<?php

namespace App\Services;

use Faker\Provider\Image;
use Illuminate\Support\Facades\File;

class UploadImageServices
{
    public string $imageNameWithExtension;

    public $image;
    public $endFolderName;
    public string $imagePath;

    public function __construct($image, $imagePath, $endFolderName)
    {
        $this->image = $image;
        $this->imagePath = $imagePath;
        $this->endFolderName = $endFolderName;
        $this->imageNameWithExtension = $endFolderName . "." . $this->image->getClientOriginalExtension();
    }

    public function saveOriginal(): void
    {
        $sourceImagePath = $this->image->getRealPath();
        $targetImagePath = storage_path('app/public/' . $this->imagePath. '/'.$this->endFolderName . '/' . $this->imageNameWithExtension);
        File::copy($sourceImagePath, $targetImagePath);
    }

    protected function save($width, $innerPath = null, $quality = 100): void
    {
        $tmpNotResizedImage = Image::make($this->image->getRealPath());

        $path = 'app/public/' . $this->imagePath .'/'.$this->endFolderName. ($innerPath ? ('/' . $innerPath) : '');

        if (!File::exists(storage_path($path)))
            File::makeDirectory(storage_path($path), 0755, true, true);

        $tmpNotResizedImage->resize($width, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save(storage_path($path . '/' . $this->imageNameWithExtension), $quality);
    }
}
