<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ShoppingListsRestApi\Business\ShoppingList;

use Generated\Shared\Transfer\ShoppingListResponseTransfer;
use Generated\Shared\Transfer\ShoppingListTransfer;
use Spryker\Shared\ShoppingListsRestApi\ShoppingListsRestApiConfig;
use Spryker\Zed\ShoppingListsRestApi\Business\ShoppingList\Mapper\ShoppingListMapperInterface;
use Spryker\Zed\ShoppingListsRestApi\Dependency\Facade\ShoppingListsRestApiToShoppingListFacadeInterface;

class ShoppingListDeleter implements ShoppingListDeleterInterface
{
    /**
     * @var \Spryker\Zed\ShoppingListsRestApi\Dependency\Facade\ShoppingListsRestApiToShoppingListFacadeInterface
     */
    protected $shoppingListFacade;

    /**
     * @var \Spryker\Zed\ShoppingListsRestApi\Business\ShoppingList\Mapper\ShoppingListMapperInterface
     */
    protected $shoppingListMapper;

    public function __construct(
        ShoppingListsRestApiToShoppingListFacadeInterface $shoppingListFacade,
        ShoppingListMapperInterface $shoppingListMapper
    ) {
        $this->shoppingListFacade = $shoppingListFacade;
        $this->shoppingListMapper = $shoppingListMapper;
    }

    public function deleteShoppingList(ShoppingListTransfer $shoppingListTransfer): ShoppingListResponseTransfer
    {
        $shoppingListResponseTransferByUuid = $this->shoppingListFacade->findShoppingListByUuid($shoppingListTransfer);

        if ($shoppingListResponseTransferByUuid->getIsSuccess() === false) {
            return $shoppingListResponseTransferByUuid->setErrors([ShoppingListsRestApiConfig::ERROR_IDENTIFIER_SHOPPING_LIST_NOT_FOUND]);
        }

        $shoppingListTransfer = $this->shoppingListMapper->mapShoppingListResponseTransferToShoppingListTransfer(
            $shoppingListResponseTransferByUuid,
            $shoppingListTransfer,
        );

        $shoppingListResponseTransfer = $this->shoppingListFacade->removeShoppingList($shoppingListTransfer);

        if ($shoppingListResponseTransfer->getIsSuccess() === false) {
            return $this->shoppingListMapper->mapShoppingListResponseErrorsToRestCodes(
                $shoppingListResponseTransfer,
            );
        }

        return $shoppingListResponseTransfer;
    }
}
