<?php

declare(strict_types=1);

namespace Test;

/**
 * Example complex type.
 *
 * This class is used for type reflection testing.
 */
class Type
{
    /**
     * @var string bar property description
     */
    public $bar;

    /**
     * @var string
     */
    public $baz;

    // @phpstan-ignore missingType.property (purposefully untyped for DocumentedProperty tests)
    public $xuz;

    /**
     * @var \Test\Type next property description
     */
    public $next;

    /**
     * @var \Test\AnotherType another property description
     */
    public $another;
}
