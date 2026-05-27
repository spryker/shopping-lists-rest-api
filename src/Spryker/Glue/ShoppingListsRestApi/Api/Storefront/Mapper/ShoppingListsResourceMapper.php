<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace Spryker\Glue\ShoppingListsRestApi\Api\Storefront\Mapper;

use Generated\Shared\Transfer\RestShoppingListItemsAttributesTransfer;
use Generated\Shared\Transfer\ShoppingListItemTransfer;
use Generated\Shared\Transfer\ShoppingListTransfer;
use Spryker\Service\Container\Attributes\Plugins;

class ShoppingListsResourceMapper implements ShoppingListsResourceMapperInterface
{
    /**
     * @param array<\Spryker\Glue\ShoppingListsRestApiExtension\Dependency\Plugin\RestShoppingListItemsAttributesMapperPluginInterface> $restShoppingListItemsAttributesMapperPlugins
     */
    public function __construct(
        #[Plugins(dependencyProviderMethod: 'getRestShoppingListItemsAttributesMapperPlugins')]
        protected array $restShoppingListItemsAttributesMapperPlugins = [],
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function mapShoppingListTransferToResourceData(ShoppingListTransfer $shoppingListTransfer): array
    {
        return [
            'uuid' => $shoppingListTransfer->getUuid(),
            'name' => $shoppingListTransfer->getName(),
            'numberOfItems' => $shoppingListTransfer->getNumberOfItems(),
            'owner' => $shoppingListTransfer->getOwner(),
            'createdAt' => $shoppingListTransfer->getCreatedAt(),
            'updatedAt' => $shoppingListTransfer->getUpdatedAt(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function mapShoppingListItemTransferToResourceData(ShoppingListItemTransfer $shoppingListItemTransfer): array
    {
        $restShoppingListItemsAttributesTransfer = (new RestShoppingListItemsAttributesTransfer())
            ->fromArray($shoppingListItemTransfer->toArray(), true);

        foreach ($this->restShoppingListItemsAttributesMapperPlugins as $plugin) {
            $restShoppingListItemsAttributesTransfer = $plugin->map(
                $shoppingListItemTransfer,
                $restShoppingListItemsAttributesTransfer,
            );
        }

        return array_merge(
            [
                'uuid' => $shoppingListItemTransfer->getUuid(),
                'sku' => $shoppingListItemTransfer->getSku(),
                'quantity' => $shoppingListItemTransfer->getQuantity(),
            ],
            $restShoppingListItemsAttributesTransfer->toArray(true, true),
        );
    }
}
