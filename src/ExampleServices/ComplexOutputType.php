<?php

declare(strict_types=1);

namespace ExampleServices;

/**
 * Example complex output type.
 */
class ComplexOutputType
{
    /**
     * @var string baz property description
     */
    public $baz;

    /**
     * @var string xuz property description
     */
    public $xuz;

    /**
     * @var \ExampleServices\AnotherComplexType another property description
     */
    public $another;
}
