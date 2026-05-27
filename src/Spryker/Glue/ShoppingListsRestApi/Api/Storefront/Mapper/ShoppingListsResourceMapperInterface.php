<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace Spryker\Glue\ShoppingListsRestApi\Api\Storefront\Mapper;

use Generated\Shared\Transfer\ShoppingListItemTransfer;
use Generated\Shared\Transfer\ShoppingListTransfer;

interface ShoppingListsResourceMapperInterface
{
    /**
     * @return array<string, mixed>
     */
    public function mapShoppingListTransferToResourceData(ShoppingListTransfer $shoppingListTransfer): array;

    /**
     * @return array<string, mixed>
     */
    public function mapShoppingListItemTransferToResourceData(ShoppingListItemTransfer $shoppingListItemTransfer): array;
}
