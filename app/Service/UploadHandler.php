<?php
/**
 * @author Dodi Priyanto<dodi.priyanto76@gmail.com>
 */
declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Console\Application;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class UploadHandler
{
    private $fileLocator;

    public function __construct(FileUploadLocator $fileLocator)
    {
        $this->fileLocator = $fileLocator;
    }

    public function handle(UploadedFile $uploadedFile, $directory = null): string
    {
        $fileName = sprintf('%s.%s', $this->fileLocator->createUniqueFileName(), $uploadedFile->guessExtension() ?: Application::APP_UNIQUE_NAME);
        $uploadDir = $this->fileLocator->getUploadDir($directory);

        $fileSystem = new Filesystem();
        if (!$fileSystem->exists($uploadDir)) {
//            $fileSystem->mkdir($uploadDir);
        }

        $uploadedFile->move($uploadDir, $fileName);

        return $fileName;
    }
}
