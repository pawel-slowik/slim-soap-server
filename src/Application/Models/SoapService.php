<?php

declare(strict_types=1);

namespace Application\Models;

use Zend\Code\Reflection\ClassReflection;
use Zend\Soap\AutoDiscover;
use Zend\Soap\Server as SoapServer;

class SoapService
{
    protected $implementation;

    public function __construct(object $implementation)
    {
        $this->implementation = $implementation;
    }

    public function getName(): string
    {
        return get_class($this->implementation);
    }

    public function getImplementation(): object
    {
        return $this->implementation;
    }

    public function getDescription(): ?string
    {
        $reflectedClass = new ClassReflection($this->implementation);
        $reflectedDocBlock = $reflectedClass->getDocBlock();
        if (!$reflectedDocBlock) {
            return null;
        }
        return $reflectedDocBlock->getShortDescription();
    }

    public function handleSoapMessage(string $wsdlUri, string $endpointUri, string $message): string
    {
        $server = new SoapServer($this->createWsdlDataUri($endpointUri));
        $server->setUri($wsdlUri);
        $server->setReturnResponse(true);
        $server->setObject($this->implementation);
        return $server->handle($message);
    }

    public function createWsdlDocument(string $endpointUri): \DOMDocument
    {
        $autodiscover = new AutoDiscover();
        $autodiscover->setClass(get_class($this->implementation));
        $autodiscover->setServiceName($this->getName());
        $autodiscover->setUri($endpointUri);
        $wsdl = $autodiscover->generate();
        return $wsdl->toDomDocument();
    }

    protected function createWsdlDataUri(string $endpointUri): string
    {
        $wsdlDocument = $this->createWsdlDocument($endpointUri);
        $wsdlXml = $wsdlDocument->saveXML();
        $wsdlDataUri = "data://text/plain;base64," . base64_encode($wsdlXml);
        return $wsdlDataUri;
    }
}
