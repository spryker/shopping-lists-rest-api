<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\ShoppingListsRestApi\Processor\RestResponseBuilder;

use Generated\Shared\Transfer\ShoppingListItemTransfer;
use Generated\Shared\Transfer\ShoppingListTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;

interface ShoppingListItemRestResponseBuilderInterface extends RestResponseBuilderInterface
{
    /**
     * @param \Generated\Shared\Transfer\ShoppingListTransfer $shoppingListTransfer
     *
     * @return array<\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface>
     */
    public function createShoppingListItemRestResourcesFromShoppingListTransfer(ShoppingListTransfer $shoppingListTransfer): array;

    public function buildShoppingListItemRestResponse(
        ShoppingListItemTransfer $shoppingListItemTransfer,
        string $idShoppingList
    ): RestResponseInterface;
}
