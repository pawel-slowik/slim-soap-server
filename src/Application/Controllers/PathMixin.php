<?php

declare(strict_types=1);

namespace Application\Controllers;

use Psr\Http\Message\UriInterface;

trait PathMixin
{
    protected static function urlForPath(UriInterface $baseUri, string $path): string
    {
        $uri = $baseUri->withPath($path)->withQuery('')->withFragment('');
        return (string) $uri;
    }
}
