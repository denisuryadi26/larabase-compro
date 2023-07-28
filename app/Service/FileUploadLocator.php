<?php
/**
 * @author Dodi Priyanto<dodi.priyanto76@gmail.com>
 */
declare(strict_types=1);

namespace App\Service;

use App\Service\SettingService;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class FileUploadLocator
{
    private $setting;

    private $kernel;

    public function __construct(SettingService $setting, KernelInterface $kernel = null)
    {
        $this->setting = $setting;
        $this->kernel = $kernel;
    }

    public function getRealPath(string $file): string
    {
        return sprintf('%s/%s', 'upload', $file);
    }

    public function getFile(string $path): string
    {
        $fileSystem = new Filesystem();
        if ($fileSystem->exists($path)) {
            return (string) file_get_contents($path);
        }

        throw new FileNotFoundException();
    }

    public function getUploadDir($directory = null): string
    {
        return sprintf('%s/%s', 'upload', $directory);
    }

    public function createUniqueFileName(): string
    {
        return md5(Uuid::getFactory()->uuid4()->toString());
    }
}
