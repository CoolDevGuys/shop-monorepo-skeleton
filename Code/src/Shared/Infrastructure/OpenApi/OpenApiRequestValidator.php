<?php

declare(strict_types=1);

namespace CoolDevGuys\Shared\Infrastructure\OpenApi;

use CoolDevGuys\Shared\Domain\Errors\ValidationError;
use CoolDevGuys\Shared\Domain\Request\RequestValidator;
use League\OpenAPIValidation\PSR7\Exception\NoPath;
use League\OpenAPIValidation\PSR7\Exception\ValidationFailed;
use League\OpenAPIValidation\PSR7\OperationAddress;
use League\OpenAPIValidation\PSR7\RoutedServerRequestValidator;
use League\OpenAPIValidation\PSR7\ValidatorBuilder;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Symfony\Component\Cache\Adapter\ApcuAdapter;
use Symfony\Component\HttpFoundation\Request;


final class OpenApiRequestValidator implements RequestValidator
{
    private const YAML_API_FILE = __DIR__ . '/../../../../etc/docs/swagger.yaml';

    private RoutedServerRequestValidator $validator;

    public function __construct()
    {
        $cachePool = new ApcuAdapter('validation', 300);
        $validatorBuilder = new ValidatorBuilder();
        $this->validator = $validatorBuilder->fromYamlFile(self::YAML_API_FILE)
                                            ->setCache($cachePool)
                                            ->getRoutedRequestValidator();
    }

    public function validate(Request $request): void
    {
        $operationAddress = new OperationAddress($this->removeVersionFromPath($request->getPathInfo()),
            strtolower($request->getMethod()));
        try {
            $this->validator->validate($operationAddress, $this->convertRequestToPsr7($request));
        } catch (ValidationFailed $e) {
            if ($e instanceof NoPath) {
                return;
            }
            throw new ValidationError($e->getMessage());
        }
    }

    private function convertRequestToPsr7(Request $request): ServerRequestInterface
    {
        $psr17Factory = new Psr17Factory();
        $psrHttpFactory = new PsrHttpFactory($psr17Factory, $psr17Factory, $psr17Factory, $psr17Factory);
        return $psrHttpFactory->createRequest($request);
    }

    private function removeVersionFromPath(string $path): string
    {
        $re = '/(\/v[0-9]*)/m';
        return (string)preg_replace($re, '', $path);
    }
}
