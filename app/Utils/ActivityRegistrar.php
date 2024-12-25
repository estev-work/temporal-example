<?php

declare(strict_types=1);

namespace App\Utils;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ReflectionClass;
use Temporal\Activity\ActivityInterface;

final class ActivityRegistrar
{
    /**
     * @throws \ReflectionException
     */
    public static function registerActivities(string $namespace, string $directory): array
    {
        $files = self::getPhpFiles($directory);
        $classes = [];
        foreach ($files as $file) {
            $relativePath = str_replace([$directory, '/', '.php'], ['', '\\', ''], $file);
            $className = $namespace . $relativePath;
            $reflection = new ReflectionClass($className);
            $attributes = $reflection->getAttributes(ActivityInterface::class);
            if (!empty($attributes)) {
                $classes[] = str_replace('Interface', '', $className);
            }
        }
        return $classes;
    }

    private static function getPhpFiles(string $directory): array
    {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($directory),
        );

        $files = [];
        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $files[] = $file->getPathname();
            }
        }

        return $files;
    }
}
