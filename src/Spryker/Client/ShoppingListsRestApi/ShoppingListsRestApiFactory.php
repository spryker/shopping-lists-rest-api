<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\ShoppingListsRestApi;

use Spryker\Client\Kernel\AbstractFactory;
use Spryker\Client\ShoppingListsRestApi\Dependency\Client\ShoppingListsRestApiToZedRequestClientInterface;
use Spryker\Client\ShoppingListsRestApi\Zed\ShoppingListsRestApiStub;
use Spryker\Client\ShoppingListsRestApi\Zed\ShoppingListsRestApiStubInterface;

class ShoppingListsRestApiFactory extends AbstractFactory
{
    public function createShoppingListsRestApiStub(): ShoppingListsRestApiStubInterface
    {
        return new ShoppingListsRestApiStub($this->getZedRequestClient());
    }

    public function getZedRequestClient(): ShoppingListsRestApiToZedRequestClientInterface
    {
        return $this->getProvidedDependency(ShoppingListsRestApiDependencyProvider::CLIENT_ZED_REQUEST);
    }
}
