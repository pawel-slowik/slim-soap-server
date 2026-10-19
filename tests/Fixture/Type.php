<?php

declare(strict_types=1);

namespace Test\Fixture;

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
     * @var \Test\Fixture\Type next property description
     */
    public $next;

    /**
     * @var \Test\Fixture\AnotherType another property description
     */
    public $another;
}
