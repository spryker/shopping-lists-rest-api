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

interface ShoppingListItemMapperInterface
{
    public function mapShoppingListItemRequestTransferToShoppingListTransfer(
        ShoppingListItemRequestTransfer $shoppingListItemRequestTransfer,
        ShoppingListTransfer $shoppingListTransfer
    ): ShoppingListTransfer;

    public function mapShoppingListResponseErrorsToShoppingListItemResponseErrors(
        ShoppingListResponseTransfer $shoppingListResponseTransfer,
        ShoppingListItemResponseTransfer $shoppingListItemResponseTransfer
    ): ShoppingListItemResponseTransfer;

    public function mapShoppingListResponseErrorsToRestCodes(
        ShoppingListItemResponseTransfer $shoppingListItemResponseTransfer
    ): ShoppingListItemResponseTransfer;
}
