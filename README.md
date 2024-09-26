![Build Status][build-badge]
[![Coverage][coverage-badge]][coverage-url]

[build-badge]: https://github.com/pawel-slowik/slim-soap-server/workflows/tests/badge.svg
[coverage-badge]: https://codecov.io/gh/pawel-slowik/slim-soap-server/branch/master/graph/badge.svg
[coverage-url]: https://codecov.io/gh/pawel-slowik/slim-soap-server

A proof of concept [SOAP](https://en.wikipedia.org/wiki/SOAP) server based on
the [Slim Framework](http://www.slimframework.com/). Features automated WSDL
generation and integrated service documentation.

## Installation

	docker-compose build
	docker-compose run --rm php-fpm composer install

## Usage

Start the application with:

	docker-compose up -d

## Limitations

The classes that are being exposed as SOAP services or types need to have
complete PHPDoc docblocks (native PHP typehints are not enough). This is
required for the WSDL generation to work correctly. For details, see
[Class autodiscovery](https://docs.laminas.dev/laminas-soap/auto-discovery/#class-autodiscovery)
and [Adding complex type information](https://docs.laminas.dev/laminas-soap/wsdl/#adding-complex-type-information).

## Tests

Run tests with:

	docker-compose run --rm php-fpm composer test
