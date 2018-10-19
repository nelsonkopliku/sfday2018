<?php

declare(strict_types=1);

namespace App\Util;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class OperationTypeGuesser
 * @package App\Util
 */
class OperationInfoExtractor
{

    private const COLLECTION_OPERATION = '_api_collection_operation_name';

    private const ITEM_OPERATION       = '_api_item_operation_name';

    private const RESOURCE_CLASS       = '_api_resource_class';

    /**
     * @param Request $request
     * @return bool
     */
    public function isCollectionOperation(Request $request) : bool
    {
        return $request->attributes->has(static::COLLECTION_OPERATION);
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function isItemOperation(Request $request) : bool
    {
        return $request->attributes->has(static::ITEM_OPERATION);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getResourceClass(Request $request) : ?string
    {
        return $request->attributes->get(static::RESOURCE_CLASS);
    }

    /**
     * @param Request $request
     * @param string $resourceClass
     * @return bool
     */
    public function requestIsForResource(Request $request, string $resourceClass) : bool
    {
        return is_a($resourceClass, $this->getResourceClass($request), true);
    }

    /**
     * @param Request $request
     * @param string $resourceClass
     * @return bool
     */
    public function isItemOperationForResource(Request $request, string $resourceClass) : bool
    {
        return $this->isItemOperation($request) && $this->requestIsForResource($request, $resourceClass);
    }

    /**
     * @param Request $request
     * @param string $resourceClass
     * @return bool
     */
    public function isCollectionOperationForResource(Request $request, string $resourceClass) : bool
    {
        return $this->isCollectionOperation($request) && $this->requestIsForResource($request, $resourceClass);
    }

}