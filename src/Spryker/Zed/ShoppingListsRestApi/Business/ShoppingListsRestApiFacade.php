<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ShoppingListsRestApi\Business;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\ShoppingListCollectionTransfer;
use Generated\Shared\Transfer\ShoppingListItemRequestTransfer;
use Generated\Shared\Transfer\ShoppingListItemResponseTransfer;
use Generated\Shared\Transfer\ShoppingListResponseTransfer;
use Generated\Shared\Transfer\ShoppingListTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Spryker\Zed\ShoppingListsRestApi\Business\ShoppingListsRestApiBusinessFactory getFactory()
 */
class ShoppingListsRestApiFacade extends AbstractFacade implements ShoppingListsRestApiFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListCollectionTransfer
     */
    public function getCustomerShoppingListCollection(
        CustomerTransfer $customerTransfer
    ): ShoppingListCollectionTransfer {
        return $this->getFactory()
            ->createShoppingListReader()
            ->getCustomerShoppingListCollection($customerTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ShoppingListTransfer $shoppingListTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListResponseTransfer
     */
    public function createShoppingList(ShoppingListTransfer $shoppingListTransfer): ShoppingListResponseTransfer
    {
        return $this->getFactory()
            ->createShoppingListCreator()
            ->createShoppingList($shoppingListTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ShoppingListTransfer $shoppingListTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListResponseTransfer
     */
    public function updateShoppingList(ShoppingListTransfer $shoppingListTransfer): ShoppingListResponseTransfer
    {
        return $this->getFactory()
            ->createShoppingListUpdater()
            ->updateShoppingList($shoppingListTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ShoppingListTransfer $shoppingListTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListResponseTransfer
     */
    public function deleteShoppingList(ShoppingListTransfer $shoppingListTransfer): ShoppingListResponseTransfer
    {
        return $this->getFactory()
            ->createShoppingListDeleter()
            ->deleteShoppingList($shoppingListTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ShoppingListItemRequestTransfer $shoppingListItemRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListItemResponseTransfer
     */
    public function addShoppingListItem(
        ShoppingListItemRequestTransfer $shoppingListItemRequestTransfer
    ): ShoppingListItemResponseTransfer {
        return $this->getFactory()->createShoppingListItemAdder()->addShoppingListItem($shoppingListItemRequestTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ShoppingListItemRequestTransfer $shoppingListItemRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListItemResponseTransfer
     */
    public function deleteShoppingListItem(
        ShoppingListItemRequestTransfer $shoppingListItemRequestTransfer
    ): ShoppingListItemResponseTransfer {
        return $this->getFactory()->createShoppingListItemDeleter()->deleteItem($shoppingListItemRequestTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ShoppingListItemRequestTransfer $shoppingListItemRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListItemResponseTransfer
     */
    public function updateShoppingListItem(
        ShoppingListItemRequestTransfer $shoppingListItemRequestTransfer
    ): ShoppingListItemResponseTransfer {
        return $this->getFactory()->createShoppingListItemUpdater()->updateShoppingListItem($shoppingListItemRequestTransfer);
    }
}
