<?php

declare(strict_types=1);

namespace ExampleServices;

/**
 * Example service with complex types.
 */
class ExampleServiceWithComplexTypes
{
    /**
     * Short description of a method with complex types.
     *
     * Long description of a method with a complex parameter and a complex
     * return type.
     *
     * @param \ExampleServices\ComplexInputType $input complex parameter description
     *
     * @return \ExampleServices\ComplexOutputType complex return value description
     */
    public function doStuff(ComplexInputType $input): ComplexOutputType
    {
        $result = new ComplexOutputType();
        $result->baz = $input->foo . " " . $input->bar;
        $result->xuz = $input->bar . " " . $input->foo;
        return $result;
    }
}
