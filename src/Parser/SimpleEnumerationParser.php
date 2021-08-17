<?php

declare(strict_types=1);

namespace AndreyRed\Enum\Parser;

use AndreyRed\Enum\Annotation\EnumOption;
use AndreyRed\Enum\EnumerationException;
use AndreyRed\Enum\IntegerEnumeration;
use AndreyRed\Enum\StringEnumeration;
use Doctrine\Common\Annotations\AnnotationReader;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use ReflectionNamedType;

/**
 * @internal
 */
class SimpleEnumerationParser implements EnumerationParser
{
    private const VALID_PARENTS = [
        IntegerEnumeration::class,
        StringEnumeration::class,
    ];

    private const ENUM_METHOD_MODIFIERS =
        ReflectionMethod::IS_PUBLIC |
        ReflectionMethod::IS_STATIC;

    /**
     * @param class-string $enumClassName
     *
     * @return OptionsCollection<mixed>
     * @throws EnumerationException
     */
    public function parse(string $enumClassName): OptionsCollection
    {
        try {
            $methods = (new ReflectionClass($enumClassName))->getMethods(self::ENUM_METHOD_MODIFIERS);
        } catch (ReflectionException $e) {
            throw EnumerationException::classNotExists($enumClassName);
        }

        $valueValidator = $this->getValueValidator($enumClassName);
        $annotationReader = new AnnotationReader();

        $enumOptions = [];
        foreach ($methods as $method) {
            /** @var null|EnumOption $enumOptionAnnotation */
            $enumOptionAnnotation = $annotationReader->getMethodAnnotation($method, EnumOption::class);
            if ($enumOptionAnnotation === null) {
                continue;
            }

            if (! $this->isLookLikeAnOptionMethod($enumClassName, $method)) {
                throw EnumerationException::wrongMethodSignature($enumClassName, $method->name);
            }

            $value = $enumOptionAnnotation->value ?? $method->name;
            $valueValidator($method->name, $value);

            $enumOptions[$method->name] = new Option(
                $value,
                $enumOptionAnnotation->name ?? (string)$value
            );
        }

        if (count($enumOptions) === 0) {
            throw EnumerationException::noOptions($enumClassName);
        }

        return new OptionsCollection($enumClassName, $enumOptions);
    }

    /**
     * @param class-string $enumClassName
     *
     * @throws EnumerationException
     */
    private function getValueValidator(string $enumClassName): callable
    {
        switch (get_parent_class($enumClassName)) {
            case IntegerEnumeration::class:
                return static function (string $methodName, $value) use ($enumClassName) {
                    if (is_int($value)) {
                        return;
                    }

                    throw EnumerationException::wrongValueType(
                        $enumClassName,
                        $methodName,
                        'an integer',
                        $value
                    );
                };

            case StringEnumeration::class:
                return static function (string $methodName, $value) use ($enumClassName) {
                    if (is_string($value) && $value !== '') {
                        return;
                    }

                    throw EnumerationException::wrongValueType(
                        $enumClassName,
                        $methodName,
                        'non-empty string',
                        $value
                    );
                };
                
            default:
                throw EnumerationException::wrongClass($enumClassName, self::VALID_PARENTS);
        }
    }

    private function isLookLikeAnOptionMethod(
        string $className,
        ReflectionMethod $method
    ): bool {
        if ($method->class !== $className) {
            // not inherited methods only
            return false;
        }

        // enum factory method must return 'self' or 'static'
        $returnType = $method->getReturnType();
        if ($returnType === null || $returnType->allowsNull()) {
            return false;
        }
        if ($returnType instanceof ReflectionNamedType && !in_array($returnType->getName(), ['self', 'static'])) {
            return false;
        }

        // method must be 'public' and 'static'
        if (($method->getModifiers() & self::ENUM_METHOD_MODIFIERS) === self::ENUM_METHOD_MODIFIERS) {
            return true;
        }

        return false;
    }
}
