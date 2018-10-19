<?php

declare(strict_types=1);

namespace App\Swagger;

use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Class ControllerSwaggerDecorator
 * @package App\Swagger
 */
final class ControllerSwaggerDecorator implements NormalizerInterface
{
    private $decorated;

    private $router;

    public function __construct(
        NormalizerInterface $decorated,
        RouterInterface $router
    ) {
        $this->decorated = $decorated;
        $this->router = $router;
    }

    public function normalize($object, $format = null, array $context = [])
    {
        $docs = $this->decorated->normalize($object, $format, $context);
        $mimeTypes = $object->getMimeTypes();
        foreach ($this->router->getRouteCollection()->all() as $route) {
            $swaggerContext = $route->getDefault('_api_swagger_context');
            if (!$swaggerContext) {
                // No swagger_context set, continue
                continue;
            }

            $methods = $route->getMethods();
            $uri = $route->getPath();

            foreach ($methods as $method) {
                // Add available mimesTypes
                $swaggerContext['produces'] ?? $swaggerContext['produces'] = $mimeTypes;

                $docs['paths'][$uri][\strtolower($method)] = $swaggerContext;
            }
        }

        return $docs;
    }

    public function supportsNormalization($data, $format = null)
    {
        return $this->decorated->supportsNormalization($data, $format);
    }
}