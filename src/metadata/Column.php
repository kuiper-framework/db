<?php

/*
 * This file is part of the Kuiper package.
 *
 * (c) Ye Wenbin <wenbinye@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace kuiper\db\metadata;

use kuiper\db\annotation\CreationTimestamp;
use kuiper\db\annotation\GeneratedValue;
use kuiper\db\annotation\Id;
use kuiper\db\annotation\NaturalId;
use kuiper\db\annotation\UpdateTimestamp;
use kuiper\db\converter\AttributeConverterInterface;
use kuiper\reflection\ReflectionTypeInterface;

class Column implements ColumnInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var MetaModelProperty
     */
    private $property;

    /**
     * @var AttributeConverterInterface
     */
    private $converter;

    /**
     * @var bool
     */
    private $id;

    /**
     * @var string|null
     */
    private $generateStrategy;

    /**
     * @var bool
     */
    private $naturalId;

    /**
     * @var bool
     */
    private $creationTimestamp;

    /**
     * @var bool
     */
    private $updateTimestamp;

    public function __construct(string $name, MetaModelProperty $property, AttributeConverterInterface $converter)
    {
        $this->name = $name;
        $this->property = $property;
        $this->converter = $converter;
        $this->id = $property->hasAnnotation(Id::class);
        $this->naturalId = $property->hasAnnotation(NaturalId::class);
        $this->creationTimestamp = $property->hasAnnotation(CreationTimestamp::class);
        $this->updateTimestamp = $property->hasAnnotation(UpdateTimestamp::class);
        /** @var GeneratedValue|null $generatedValue */
        $generatedValue = $property->getAnnotation(GeneratedValue::class);
        if (null !== $generatedValue) {
            $this->generateStrategy = $generatedValue->value;
        }
    }

    public function getProperty(): MetaModelProperty
    {
        return $this->property;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPropertyPath(): string
    {
        return $this->property->getPath();
    }

    /**
     * @return mixed
     */
    public function getValue(object $entity)
    {
        $value = $this->property->getValue($entity);
        if ($this->isNull($value)) {
            return $value;
        }

        return $this->converter->convertToDatabaseColumn($value, $this);
    }

    /**
     * @param mixed $value
     */
    public function setValue(object $entity, $value): void
    {
        $attributeValue = isset($value) ? $this->converter->convertToEntityAttribute($value, $this) : null;
        $this->property->setValue($entity, $attributeValue);
    }

    public function getConverter(): AttributeConverterInterface
    {
        return $this->converter;
    }

    public function getType(): ReflectionTypeInterface
    {
        return $this->property->getType();
    }

    public function isId(): bool
    {
        return $this->id;
    }

    public function isGeneratedValue(): bool
    {
        return isset($this->generateStrategy);
    }

    public function isNaturalId(): bool
    {
        return $this->naturalId;
    }

    public function isCreationTimestamp(): bool
    {
        return $this->creationTimestamp;
    }

    public function isUpdateTimestamp(): bool
    {
        return $this->updateTimestamp;
    }

    /**
     * @param mixed $value
     */
    private function isNull($value): bool
    {
        return !isset($value) || $value instanceof NullValue;
    }
}
