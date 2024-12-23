<?php

declare(strict_types=1);

namespace Modules\Shared\Domain;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use JsonException;
use Modules\Shared\Domain\ValueObject\CurrencyEnum;
use Modules\Shared\Domain\ValueObject\MoneyValue;
use ReflectionClass;
use ReflectionProperty;

abstract class Aggregate implements \Serializable, AggregateInterface
{
    protected ?string $createdAt = null;
    protected ?string $updatedAt = null;

    /**
     * @throws JsonException
     */
    public function __toString(): string
    {
        return json_encode($this->toArray(), JSON_THROW_ON_ERROR);
    }

    public function toArray(): array
    {
        $reflection = new ReflectionClass($this);
        $properties = $reflection->getProperties(ReflectionProperty::IS_PRIVATE | ReflectionProperty::IS_PROTECTED);

        $data = [];
        foreach ($properties as $property) {
            $vo = $property->getValue($this);
            if ($vo instanceof MoneyValue) {
                $value = $vo->getValue();
                $data['price'] = $value;
                $data['currency'] = $vo->getCurrency()->value;
            }
            if ($vo instanceof VO) {
                $value = $vo->getValue();
                if ($value instanceof \BackedEnum) {
                    $data[$property->getName()] = $value->value;
                } else {
                    $data[$property->getName()] = $value;
                }
            } else {
                $data[$property->getName()] = $vo;
            }
        }
        Log::debug('data', $data);
        return $data;
    }

    public function __serialize(): array
    {
        return $this->toArray();
    }

    public function serialize(): string
    {
        return json_encode($this->toArray());
    }

    public function unserialize(string $data): void
    {
        $arrayData = json_decode($data, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \InvalidArgumentException('Invalid JSON string for unserialization.');
        }

        $this->__unserialize($arrayData);
    }

    public function __unserialize(array $data): void
    {
        $reflection = new ReflectionClass($this);

        foreach ($data as $propertyName => $value) {
            if (!$reflection->hasProperty($propertyName)) {
                continue;
            }

            $property = $reflection->getProperty($propertyName);

            $propertyType = $property->getType();

            if ($propertyType && !$propertyType->isBuiltin()) {
                $typeName = $propertyType->getName();

                if (is_subclass_of($typeName, VO::class)) {
                    $valueObject = new $typeName($value);
                    $property->setValue($this, $valueObject);
                    continue;
                }

                if ($typeName === MoneyValue::class) {
                    $moneyValue = new MoneyValue($value['price'], CurrencyEnum::from($value['currency']));
                    $property->setValue($this, $moneyValue);
                    continue;
                }

                if (enum_exists($typeName)) {
                    $enumValue = $typeName::from($value);
                    $property->setValue($this, $enumValue);
                    continue;
                }
            }
            $property->setValue($this, $value);
        }
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    protected function updated(): void
    {
        $this->updatedAt = Carbon::now()->toISOString();
    }
}
