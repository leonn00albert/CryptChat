<?php

declare(strict_types=1);

namespace App\Utils;

use Exception;

/**
 * Class Upload
 *
 * This class handles uploading image files in PHP.
 *
 * @package App\Utils
 */
class Upload
{
    /**
     * Allowed image file types.
     *
     * @var array<string>
     */
    private array $allowedImageTypes = ['jpg'];

    /**
     * Target directory where uploaded images will be stored.
     */
    private string $targetDir = __DIR__ . '/../../public/images/';

    /**
     * Maximum file size allowed for the uploaded image (in bytes).
     */
    private int $maxFileSize = 5000000; // 5MB

    /**
     * The full path to the target file.
     */
    private string $targetFile;

    /**
     * Upload constructor.
     *
     * Sets the target file path based on the username stored in the session.
     */
    public function __construct()
    {
        $imageFileType = strtolower(pathinfo($_FILES['profileImage']['name'], PATHINFO_EXTENSION));
        $this->targetFile = $this->targetDir . basename($_SESSION['username']) . '.' . $imageFileType;
    }

    /**
     * Uploads the image to the target directory.
     *
     * @throws Exception If there is an error uploading the image or if validation fails.
     */
    public function upload(): void
    {
        $imageFileType = strtolower(pathinfo($_FILES['profileImage']['name'], PATHINFO_EXTENSION));
        //$this->isValidFileType($imageFileType);
        $this->isValidSize();

        if (move_uploaded_file($_FILES['profileImage']['tmp_name'], $this->targetFile)) {
            echo 'The image ' . basename($_FILES['profileImage']['name']) . ' has been uploaded.';
        } else {
            throw new Exception('There was an error uploading your image.');
        }
    }

    /**
     * Validates if the given image file type is allowed.
     *
     * @param  string $imageFileType The file type of the image to be checked.
     *
     * @throws Exception If the image file type is not allowed.
     */
    protected function isValidFileType(string $imageFileType): void
    {
        if (! in_array($imageFileType, $this->allowedImageTypes)) {
            throw new Exception('Wrong file type, only JPG, JPEG, PNG, and GIF images are allowed.');
        }
    }

    /**
     * Validates if the size of the uploaded image is within the allowed limit.
     *
     * @throws Exception If the image size exceeds the maximum allowed size.
     */
    protected function isValidSize(): void
    {
        if ($_FILES['profileImage']['size'] > $this->maxFileSize) {
            throw new Exception('Your image is too large, max size: ' . (string) ($this->maxFileSize / 1000000) . ' MB');
        }
    }
}
