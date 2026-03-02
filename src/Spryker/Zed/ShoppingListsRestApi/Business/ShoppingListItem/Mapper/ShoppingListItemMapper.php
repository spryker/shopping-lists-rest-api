<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ShoppingListsRestApi\Business\ShoppingListItem\Mapper;

use Generated\Shared\Transfer\ShoppingListItemRequestTransfer;
use Generated\Shared\Transfer\ShoppingListItemResponseTransfer;
use Generated\Shared\Transfer\ShoppingListResponseTransfer;
use Generated\Shared\Transfer\ShoppingListTransfer;
use Spryker\Shared\ShoppingListsRestApi\ShoppingListsRestApiConfig as SharedShoppingListsRestApiConfig;
use Spryker\Zed\ShoppingListsRestApi\ShoppingListsRestApiConfig;

class ShoppingListItemMapper implements ShoppingListItemMapperInterface
{
    public function mapShoppingListItemRequestTransferToShoppingListTransfer(
        ShoppingListItemRequestTransfer $shoppingListItemRequestTransfer,
        ShoppingListTransfer $shoppingListTransfer
    ): ShoppingListTransfer {
        return $shoppingListTransfer
            ->setUuid($shoppingListItemRequestTransfer->getShoppingListUuid())
            ->setIdCompanyUser($shoppingListItemRequestTransfer->getShoppingListItem()->getIdCompanyUser())
            ->setCustomerReference($shoppingListItemRequestTransfer->getShoppingListItem()->getCustomerReference());
    }

    public function mapShoppingListResponseErrorsToShoppingListItemResponseErrors(
        ShoppingListResponseTransfer $shoppingListResponseTransfer,
        ShoppingListItemResponseTransfer $shoppingListItemResponseTransfer
    ): ShoppingListItemResponseTransfer {
        if (count($shoppingListResponseTransfer->getErrors()) > 0) {
            return $shoppingListItemResponseTransfer->setIsSuccess(false)
                ->setErrors($shoppingListResponseTransfer->getErrors());
        }

        return $shoppingListItemResponseTransfer->setIsSuccess(false)
            ->addError(SharedShoppingListsRestApiConfig::ERROR_IDENTIFIER_SHOPPING_LIST_NOT_FOUND);
    }

    public function mapShoppingListResponseErrorsToRestCodes(
        ShoppingListItemResponseTransfer $shoppingListItemResponseTransfer
    ): ShoppingListItemResponseTransfer {
        $errorIdentifiers = [];
        foreach ($shoppingListItemResponseTransfer->getErrors() as $error) {
            $errorIdentifiers[] = ShoppingListsRestApiConfig::getResponseErrorMapping()[$error] ?? $error;
        }

        $shoppingListItemResponseTransfer->setErrors($errorIdentifiers);

        return $shoppingListItemResponseTransfer;
    }
}
