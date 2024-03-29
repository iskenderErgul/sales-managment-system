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

}
