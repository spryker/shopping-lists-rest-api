<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\ShoppingListsRestApi\Processor\Mapper;

use Generated\Shared\Transfer\RestShoppingListRequestAttributesTransfer;
use Generated\Shared\Transfer\RestShoppingListsAttributesTransfer;
use Generated\Shared\Transfer\ShoppingListTransfer;

class ShoppingListMapper implements ShoppingListMapperInterface
{
    public function mapShoppingListTransferToRestShoppingListsAttributesTransfer(
        ShoppingListTransfer $shoppingListTransfer,
        RestShoppingListsAttributesTransfer $restShoppingListsAttributesTransfer
    ): RestShoppingListsAttributesTransfer {
        return $restShoppingListsAttributesTransfer->fromArray($shoppingListTransfer->toArray(), true);
    }

    public function mapRestShoppingListsAttributesTransferToShoppingListTransfer(
        RestShoppingListRequestAttributesTransfer $restShoppingListRequestAttributesTransfer,
        ShoppingListTransfer $shoppingListTransfer
    ): ShoppingListTransfer {
        return $shoppingListTransfer->fromArray($restShoppingListRequestAttributesTransfer->modifiedToArray(), true);
    }
}
