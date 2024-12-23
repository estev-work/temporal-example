<?php

declare(strict_types=1);

namespace App\Utils;

use ReflectionClass;
use Temporal\Activity\ActivityInterface;

final class ActivityRegistrar
{
    /**
     * Автоматическая регистрация Activity с атрибутом #[ActivityInterface].
     *
     * @param string $namespace
     * @param string $directory
     * @return array
     */
    public static function registerActivities(string $namespace, string $directory): array
    {
        $files = glob($directory . '/*.php');
        $classes = [];
        foreach ($files as $file) {
            $className = $namespace . '\\' . basename($file, '.php');

            if (!class_exists($className)) {
                continue;
            }

            $reflection = new ReflectionClass($className);
            $attributes = $reflection->getAttributes(ActivityInterface::class);

            if (!empty($attributes)) {
                $classes[] = $className;
            }
        }
        return $classes;
    }
}
