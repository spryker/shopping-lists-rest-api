<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\ShoppingListsRestApi\Processor\RestResponseBuilder;

use Generated\Shared\Transfer\RestShoppingListCollectionResponseTransfer;
use Generated\Shared\Transfer\ShoppingListTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;

interface ShoppingListRestResponseBuilderInterface extends RestResponseBuilderInterface
{
    public function buildShoppingListRestResponse(ShoppingListTransfer $shoppingListTransfer): RestResponseInterface;

    public function buildShoppingListCollectionRestResponse(
        RestShoppingListCollectionResponseTransfer $restShoppingListCollectionResponseTransfer
    ): RestResponseInterface;
}
