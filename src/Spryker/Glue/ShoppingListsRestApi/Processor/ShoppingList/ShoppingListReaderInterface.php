<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\ShoppingListsRestApi\Processor\ShoppingList;

use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

interface ShoppingListReaderInterface
{
    public function getCustomerShoppingListCollection(RestRequestInterface $restRequest): RestResponseInterface;

    public function getCustomerShoppingList(string $uuidShoppingList, RestRequestInterface $restRequest): RestResponseInterface;
}
