[![Build Status][build-badge]][build-url]

[build-badge]: https://travis-ci.org/pawel-slowik/slim-soap-server.svg?branch=master
[build-url]: https://travis-ci.org/pawel-slowik/slim-soap-server

A proof of concept [SOAP](https://en.wikipedia.org/wiki/SOAP) server based on
the [Slim Framework](http://www.slimframework.com/). Features automated WSDL
generation and integrated service documentation.

## Installation

	composer install

## Usage

Start the application with:

	php -S localhost:8080 -t public public/index.php
