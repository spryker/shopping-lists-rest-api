<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace Spryker\Glue\ShoppingListsRestApi\Api\Storefront\Exception;

use Generated\Shared\Transfer\RestErrorMessageTransfer;
use Spryker\ApiPlatform\Exception\GlueApiException;
use Spryker\Glue\ShoppingListsRestApi\ShoppingListsRestApiConfig;
use Symfony\Component\HttpFoundation\Response;

class ShoppingListsExceptionFactory
{
    public function createMissingShoppingListIdException(): GlueApiException
    {
        return new GlueApiException(
            Response::HTTP_BAD_REQUEST,
            ShoppingListsRestApiConfig::RESPONSE_CODE_SHOPPING_LIST_ID_NOT_SPECIFIED,
            ShoppingListsRestApiConfig::RESPONSE_DETAIL_SHOPPING_LIST_ID_NOT_SPECIFIED,
        );
    }

    public function createMissingShoppingListItemIdException(): GlueApiException
    {
        return new GlueApiException(
            Response::HTTP_BAD_REQUEST,
            ShoppingListsRestApiConfig::RESPONSE_CODE_SHOPPING_LIST_ITEM_ID_NOT_SPECIFIED,
            ShoppingListsRestApiConfig::RESPONSE_DETAIL_SHOPPING_LIST_ITEM_ID_NOT_SPECIFIED,
        );
    }

    public function createShoppingListNotFoundException(): GlueApiException
    {
        return new GlueApiException(
            Response::HTTP_NOT_FOUND,
            ShoppingListsRestApiConfig::RESPONSE_CODE_SHOPPING_LIST_NOT_FOUND,
            ShoppingListsRestApiConfig::RESPONSE_DETAIL_SHOPPING_LIST_NOT_FOUND,
        );
    }

    public function createShoppingListItemNotFoundException(): GlueApiException
    {
        return new GlueApiException(
            Response::HTTP_NOT_FOUND,
            ShoppingListsRestApiConfig::RESPONSE_CODE_SHOPPING_LIST_ITEM_NOT_FOUND,
            ShoppingListsRestApiConfig::RESPONSE_DETAIL_SHOPPING_LIST_ITEM_NOT_FOUND,
        );
    }

    public function createExceptionFromErrorIdentifier(
        ?string $errorIdentifier,
        int $fallbackStatus = Response::HTTP_UNPROCESSABLE_ENTITY,
        string $fallbackCode = ShoppingListsRestApiConfig::RESPONSE_CODE_VALIDATION,
        string $fallbackDetail = 'Shopping list operation failed.',
    ): GlueApiException {
        if ($errorIdentifier === null) {
            return new GlueApiException($fallbackStatus, $fallbackCode, $fallbackDetail);
        }

        $mapping = ShoppingListsRestApiConfig::getErrorIdentifierToRestErrorMapping();

        if (!isset($mapping[$errorIdentifier])) {
            return new GlueApiException($fallbackStatus, $fallbackCode, $fallbackDetail);
        }

        $entry = $mapping[$errorIdentifier];

        return new GlueApiException(
            (int)$entry[RestErrorMessageTransfer::STATUS],
            (string)$entry[RestErrorMessageTransfer::CODE],
            (string)$entry[RestErrorMessageTransfer::DETAIL],
        );
    }
}
