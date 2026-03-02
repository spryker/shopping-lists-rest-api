<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ShoppingListsRestApi\Communication\Controller;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\ShoppingListCollectionTransfer;
use Generated\Shared\Transfer\ShoppingListItemRequestTransfer;
use Generated\Shared\Transfer\ShoppingListItemResponseTransfer;
use Generated\Shared\Transfer\ShoppingListResponseTransfer;
use Generated\Shared\Transfer\ShoppingListTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractGatewayController;

/**
 * @method \Spryker\Zed\ShoppingListsRestApi\Business\ShoppingListsRestApiFacadeInterface getFacade()
 */
class GatewayController extends AbstractGatewayController
{
    public function getCustomerShoppingListCollectionAction(
        CustomerTransfer $customerTransfer
    ): ShoppingListCollectionTransfer {
        return $this->getFacade()->getCustomerShoppingListCollection($customerTransfer);
    }

    public function createShoppingListAction(ShoppingListTransfer $shoppingListTransfer): ShoppingListResponseTransfer
    {
        return $this->getFacade()->createShoppingList($shoppingListTransfer);
    }

    public function updateShoppingListAction(ShoppingListTransfer $shoppingListTransfer): ShoppingListResponseTransfer
    {
        return $this->getFacade()->updateShoppingList($shoppingListTransfer);
    }

    public function deleteShoppingListAction(ShoppingListTransfer $shoppingListTransfer): ShoppingListResponseTransfer
    {
        return $this->getFacade()->deleteShoppingList($shoppingListTransfer);
    }

    public function addShoppingListItemAction(
        ShoppingListItemRequestTransfer $shoppingListItemRequestTransfer
    ): ShoppingListItemResponseTransfer {
        return $this->getFacade()->addShoppingListItem($shoppingListItemRequestTransfer);
    }

    public function deleteShoppingListItemAction(
        ShoppingListItemRequestTransfer $shoppingListItemRequestTransfer
    ): ShoppingListItemResponseTransfer {
        return $this->getFacade()->deleteShoppingListItem($shoppingListItemRequestTransfer);
    }

    public function updateShoppingListItemAction(
        ShoppingListItemRequestTransfer $shoppingListItemRequestTransfer
    ): ShoppingListItemResponseTransfer {
        return $this->getFacade()->updateShoppingListItem($shoppingListItemRequestTransfer);
    }
}
