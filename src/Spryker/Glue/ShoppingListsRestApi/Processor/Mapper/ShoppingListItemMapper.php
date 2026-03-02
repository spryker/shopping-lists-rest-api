<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\ShoppingListsRestApi\Processor\Mapper;

use Generated\Shared\Transfer\RestShoppingListItemsAttributesTransfer;
use Generated\Shared\Transfer\ShoppingListItemRequestTransfer;
use Generated\Shared\Transfer\ShoppingListItemTransfer;

class ShoppingListItemMapper implements ShoppingListItemMapperInterface
{
    /**
     * @var array<\Spryker\Glue\ShoppingListsRestApiExtension\Dependency\Plugin\RestShoppingListItemsAttributesMapperPluginInterface>
     */
    protected array $restShoppingListItemsAttributesMapperPlugins;

    /**
     * @var array<\Spryker\Glue\ShoppingListsRestApiExtension\Dependency\Plugin\ShoppingListItemRequestMapperPluginInterface>
     */
    protected array $shoppingListItemRequestMapperPlugins;

    /**
     * @param array<\Spryker\Glue\ShoppingListsRestApiExtension\Dependency\Plugin\RestShoppingListItemsAttributesMapperPluginInterface> $restShoppingListItemsAttributesMapperPlugins
     * @param array<\Spryker\Glue\ShoppingListsRestApiExtension\Dependency\Plugin\ShoppingListItemRequestMapperPluginInterface> $shoppingListItemRequestMapperPlugins
     */
    public function __construct(
        array $restShoppingListItemsAttributesMapperPlugins,
        array $shoppingListItemRequestMapperPlugins
    ) {
        $this->restShoppingListItemsAttributesMapperPlugins = $restShoppingListItemsAttributesMapperPlugins;
        $this->shoppingListItemRequestMapperPlugins = $shoppingListItemRequestMapperPlugins;
    }

    public function mapShoppingListItemTransferToRestShoppingListItemsAttributesTransfer(
        ShoppingListItemTransfer $shoppingListItemTransfer,
        RestShoppingListItemsAttributesTransfer $restShoppingListItemsAttributesTransfer
    ): RestShoppingListItemsAttributesTransfer {
        $restShoppingListItemsAttributesTransfer->fromArray(
            $shoppingListItemTransfer->toArray(),
            true,
        );

        return $this->executeRestShoppingListItemsAttributesMapperPlugis(
            $shoppingListItemTransfer,
            $restShoppingListItemsAttributesTransfer,
        );
    }

    public function mapRestShoppingListItemsAttributesTransferToShoppingListItemRequestTransfer(
        RestShoppingListItemsAttributesTransfer $restShoppingListItemsAttributesTransfer,
        ShoppingListItemRequestTransfer $shoppingListItemRequestTransfer
    ): ShoppingListItemRequestTransfer {
        $shoppingListItemRequestTransfer->getShoppingListItem()->fromArray(
            $restShoppingListItemsAttributesTransfer->modifiedToArray(),
            true,
        );

        return $this->executeShoppingListItemRequestMapperPlugins(
            $restShoppingListItemsAttributesTransfer,
            $shoppingListItemRequestTransfer,
        );
    }

    protected function executeRestShoppingListItemsAttributesMapperPlugis(
        ShoppingListItemTransfer $shoppingListItemTransfer,
        RestShoppingListItemsAttributesTransfer $restShoppingListItemsAttributesTransfer
    ): RestShoppingListItemsAttributesTransfer {
        foreach ($this->restShoppingListItemsAttributesMapperPlugins as $restShoppingListItemsAttributesMapperPlugin) {
            $restShoppingListItemsAttributesTransfer = $restShoppingListItemsAttributesMapperPlugin->map(
                $shoppingListItemTransfer,
                $restShoppingListItemsAttributesTransfer,
            );
        }

        return $restShoppingListItemsAttributesTransfer;
    }

    protected function executeShoppingListItemRequestMapperPlugins(
        RestShoppingListItemsAttributesTransfer $restShoppingListItemsAttributesTransfer,
        ShoppingListItemRequestTransfer $shoppingListItemRequestTransfer
    ): ShoppingListItemRequestTransfer {
        foreach ($this->shoppingListItemRequestMapperPlugins as $shoppingListItemRequestMapperPlugin) {
            $shoppingListItemRequestTransfer = $shoppingListItemRequestMapperPlugin->map(
                $restShoppingListItemsAttributesTransfer,
                $shoppingListItemRequestTransfer,
            );
        }

        return $shoppingListItemRequestTransfer;
    }
}
