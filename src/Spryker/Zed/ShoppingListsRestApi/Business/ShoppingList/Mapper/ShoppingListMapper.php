<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ShoppingListsRestApi\Business\ShoppingList\Mapper;

use Generated\Shared\Transfer\ShoppingListResponseTransfer;
use Generated\Shared\Transfer\ShoppingListTransfer;
use Spryker\Zed\ShoppingListsRestApi\ShoppingListsRestApiConfig;

class ShoppingListMapper implements ShoppingListMapperInterface
{
    public function mapShoppingListResponseTransferToShoppingListTransfer(
        ShoppingListResponseTransfer $shoppingListResponseTransfer,
        ShoppingListTransfer $shoppingListTransfer
    ): ShoppingListTransfer {
        $shoppingListTransfer
            ->setIdShoppingList($shoppingListResponseTransfer->getShoppingList()->getIdShoppingList());

        return $shoppingListTransfer;
    }

    public function mapShoppingListResponseErrorsToRestCodes(
        ShoppingListResponseTransfer $shoppingListResponseTransfer
    ): ShoppingListResponseTransfer {
        $errorIdentifiers = [];
        foreach ($shoppingListResponseTransfer->getErrors() as $error) {
            $errorIdentifiers[] = ShoppingListsRestApiConfig::getResponseErrorMapping()[$error] ?? $error;
        }

        $shoppingListResponseTransfer->setErrors($errorIdentifiers);

        return $shoppingListResponseTransfer;
    }
}
