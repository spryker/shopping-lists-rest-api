<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\ShoppingListsRestApi\Processor\Mapper;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestUserTransfer;

interface CustomerMapperInterface
{
    public function mapRestUserTransferToCustomerTransfer(
        RestUserTransfer $restUserTransfer,
        CustomerTransfer $customerTransfer
    ): CustomerTransfer;
}
