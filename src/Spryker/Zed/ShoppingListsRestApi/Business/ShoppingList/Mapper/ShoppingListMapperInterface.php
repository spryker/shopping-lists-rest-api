<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ShoppingListsRestApi\Business\ShoppingList\Mapper;

use Generated\Shared\Transfer\ShoppingListResponseTransfer;
use Generated\Shared\Transfer\ShoppingListTransfer;

interface ShoppingListMapperInterface
{
    public function mapShoppingListResponseTransferToShoppingListTransfer(
        ShoppingListResponseTransfer $shoppingListResponseTransfer,
        ShoppingListTransfer $shoppingListTransfer
    ): ShoppingListTransfer;

    public function mapShoppingListResponseErrorsToRestCodes(
        ShoppingListResponseTransfer $shoppingListResponseTransfer
    ): ShoppingListResponseTransfer;
}
