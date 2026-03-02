<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ShoppingListsRestApi\Dependency\Facade;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\ShoppingListCollectionTransfer;
use Generated\Shared\Transfer\ShoppingListItemResponseTransfer;
use Generated\Shared\Transfer\ShoppingListItemTransfer;
use Generated\Shared\Transfer\ShoppingListResponseTransfer;
use Generated\Shared\Transfer\ShoppingListTransfer;

class ShoppingListsRestApiToShoppingListFacadeBridge implements ShoppingListsRestApiToShoppingListFacadeInterface
{
    /**
     * @var \Spryker\Zed\ShoppingList\Business\ShoppingListFacadeInterface
     */
    protected $shoppingListFacade;

    /**
     * @param \Spryker\Zed\ShoppingList\Business\ShoppingListFacadeInterface $shoppingListFacade
     */
    public function __construct($shoppingListFacade)
    {
        $this->shoppingListFacade = $shoppingListFacade;
    }

    public function findShoppingListByUuid(ShoppingListTransfer $shoppingListTransfer): ShoppingListResponseTransfer
    {
        return $this->shoppingListFacade->findShoppingListByUuid($shoppingListTransfer);
    }

    public function getCustomerShoppingListCollection(CustomerTransfer $customerTransfer): ShoppingListCollectionTransfer
    {
        return $this->shoppingListFacade->getCustomerShoppingListCollection($customerTransfer);
    }

    public function createShoppingList(ShoppingListTransfer $shoppingListTransfer): ShoppingListResponseTransfer
    {
        return $this->shoppingListFacade->createShoppingList($shoppingListTransfer);
    }

    public function updateShoppingList(ShoppingListTransfer $shoppingListTransfer): ShoppingListResponseTransfer
    {
        return $this->shoppingListFacade->updateShoppingList($shoppingListTransfer);
    }

    public function removeShoppingList(ShoppingListTransfer $shoppingListTransfer): ShoppingListResponseTransfer
    {
        return $this->shoppingListFacade->removeShoppingList($shoppingListTransfer);
    }

    public function addShoppingListItem(ShoppingListItemTransfer $shoppingListItemTransfer): ShoppingListItemResponseTransfer
    {
        return $this->shoppingListFacade->addShoppingListItem($shoppingListItemTransfer);
    }

    public function removeItemById(ShoppingListItemTransfer $shoppingListItemTransfer): ShoppingListItemResponseTransfer
    {
        return $this->shoppingListFacade->removeItemById($shoppingListItemTransfer);
    }

    public function updateShoppingListItemById(ShoppingListItemTransfer $shoppingListItemTransfer): ShoppingListItemResponseTransfer
    {
        return $this->shoppingListFacade->updateShoppingListItemById($shoppingListItemTransfer);
    }
}
