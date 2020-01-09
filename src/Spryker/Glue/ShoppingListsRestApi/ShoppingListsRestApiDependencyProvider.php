<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\ShoppingListsRestApi;

use Spryker\Glue\Kernel\AbstractBundleDependencyProvider;
use Spryker\Glue\Kernel\Container;
use Spryker\Glue\ShoppingListsRestApi\Dependency\Client\ShoppingListsRestApiToShoppingListClientBridge;

/**
 * @method \Spryker\Glue\ShoppingListsRestApi\ShoppingListsRestApiConfig getConfig()
 */
class ShoppingListsRestApiDependencyProvider extends AbstractBundleDependencyProvider
{
    public const CLIENT_SHOPPING_LIST = 'CLIENT_SHOPPING_LIST';

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = parent::provideDependencies($container);
        $container = $this->addShoppingListClient($container);

        return $container;
    }

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    protected function addShoppingListClient(Container $container): Container
    {
        $container->set(static::CLIENT_SHOPPING_LIST, function (Container $container) {
            return new ShoppingListsRestApiToShoppingListClientBridge(
                $container->getLocator()->shoppingList()->client()
            );
        });

        return $container;
    }
}
