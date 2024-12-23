<?php

declare(strict_types=1);

namespace App\Utils;

use ReflectionClass;

final class WorkflowRegistrar
{
    /**
     * Автоматическая регистрация Workflow с атрибутом #[WorkflowInterface].
     *
     * @param string $namespace
     * @param string $directory
     * @return array
     */
    public static function registerWorkflows(string $namespace, string $directory): array
    {
        $files = glob($directory . '/*.php');
        $classes = [];
        foreach ($files as $file) {
            $className = $namespace . '\\' . basename($file, '.php');

            if (!class_exists($className)) {
                continue;
            }

            $reflection = new ReflectionClass($className);
            $attributes = $reflection->getAttributes(\Temporal\Workflow\WorkflowInterface::class);

            if (!empty($attributes)) {
                $classes[] = $className;
            }
        }
        return $classes;
    }
}
