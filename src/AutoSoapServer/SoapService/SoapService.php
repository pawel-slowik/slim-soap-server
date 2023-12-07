<?php

declare(strict_types=1);

namespace AutoSoapServer\SoapService;

use DOMDocument;
use Laminas\Code\Reflection\ClassReflection;
use Laminas\Soap\AutoDiscover;
use Laminas\Soap\Server as SoapServer;
use Laminas\Soap\Wsdl;
use Laminas\Soap\Wsdl\ComplexTypeStrategy\DefaultComplexType;

class SoapService
{
    private object $implementation;

    public function __construct(object $implementation)
    {
        $this->implementation = $implementation;
    }

    public function getName(): string
    {
        return $this->implementation::class;
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
        [$wsdl, $classMap] = $this->autodiscover($endpointUri);
        $wsdlDocument = $wsdl->toDomDocument();
        $wsdlDataUri = $this->createDataUri($wsdlDocument);
        $server = new SoapServer($wsdlDataUri);
        $server->setUri($wsdlUri);
        $server->setReturnResponse(true);
        $server->setObject($this->implementation);
        $server->setClassmap($classMap);
        return $server->handle($message);
    }

    public function createWsdlDocument(string $endpointUri): WsdlDocument
    {
        [$wsdl] = $this->autodiscover($endpointUri);
        $xmlDocument = $wsdl->toDomDocument();
        $xmlContent = $xmlDocument->saveXML();
        if ($xmlContent === false) {
            throw new WsdlCreateFailedException();
        }
        return new WsdlDocument(
            $xmlContent,
            $xmlDocument->encoding,
        );
    }

    /**
     * @return class-string[]
     */
    public function discoverComplexTypes(): array
    {
        $spy = new ComplexTypeStrategySpy(new DefaultComplexType());
        $autodiscover = new AutoDiscover($spy);
        $autodiscover->setClass($this->implementation::class);
        $autodiscover->setUri("dummy");
        $autodiscover->generate();
        return array_keys($spy->getTypeMap());
    }

    /**
     * @return array{0: Wsdl, 1: array<string, string>}
     */
    private function autodiscover(string $endpointUri): array
    {
        $spy = new ComplexTypeStrategySpy(new DefaultComplexType());
        $autodiscover = new AutoDiscover($spy);
        $autodiscover->setClass($this->implementation::class);
        $autodiscover->setServiceName($this->getName());
        $autodiscover->setUri($endpointUri);
        $wsdl = $autodiscover->generate();
        return [$wsdl, $spy->getClassMap()];
    }

    private static function createDataUri(DOMDocument $document): string
    {
        return "data://text/plain;base64," . base64_encode($document->saveXML());
    }
}
