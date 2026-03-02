<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\ShoppingListsRestApi\Processor\Mapper;

use Generated\Shared\Transfer\RestShoppingListItemsAttributesTransfer;
use Generated\Shared\Transfer\ShoppingListItemRequestTransfer;
use Generated\Shared\Transfer\ShoppingListItemTransfer;

interface ShoppingListItemMapperInterface
{
    public function mapShoppingListItemTransferToRestShoppingListItemsAttributesTransfer(
        ShoppingListItemTransfer $shoppingListItemTransfer,
        RestShoppingListItemsAttributesTransfer $restShoppingListItemsAttributesTransfer
    ): RestShoppingListItemsAttributesTransfer;

    public function mapRestShoppingListItemsAttributesTransferToShoppingListItemRequestTransfer(
        RestShoppingListItemsAttributesTransfer $restShoppingListItemsAttributesTransfer,
        ShoppingListItemRequestTransfer $shoppingListItemRequestTransfer
    ): ShoppingListItemRequestTransfer;
}
