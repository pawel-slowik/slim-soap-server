![Build Status][build-badge]
[![Coverage][coverage-badge]][coverage-url]

[build-badge]: https://github.com/pawel-slowik/slim-soap-server/workflows/tests/badge.svg
[coverage-badge]: https://codecov.io/gh/pawel-slowik/slim-soap-server/branch/master/graph/badge.svg
[coverage-url]: https://codecov.io/gh/pawel-slowik/slim-soap-server

A proof of concept [SOAP](https://en.wikipedia.org/wiki/SOAP) server based on
the [Slim Framework](http://www.slimframework.com/). Features automated WSDL
generation and integrated service documentation.

## Installation

	composer install

## Usage

Start the application with:

	php -S localhost:8080 -t public public/index.php
