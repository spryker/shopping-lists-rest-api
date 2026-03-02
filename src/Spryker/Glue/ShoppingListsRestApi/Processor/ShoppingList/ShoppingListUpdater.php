<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\ShoppingListsRestApi\Processor\ShoppingList;

use Generated\Shared\Transfer\RestShoppingListRequestAttributesTransfer;
use Spryker\Client\ShoppingListsRestApi\ShoppingListsRestApiClientInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Glue\ShoppingListsRestApi\Processor\RestRequest\ShoppingListRestRequestReaderInterface;
use Spryker\Glue\ShoppingListsRestApi\Processor\RestResponseBuilder\ShoppingListRestResponseBuilderInterface;

class ShoppingListUpdater implements ShoppingListUpdaterInterface
{
    /**
     * @var \Spryker\Client\ShoppingListsRestApi\ShoppingListsRestApiClientInterface
     */
    protected $shoppingListsRestApiClient;

    /**
     * @var \Spryker\Glue\ShoppingListsRestApi\Processor\RestRequest\ShoppingListRestRequestReaderInterface
     */
    protected $shoppingListRestRequestReader;

    /**
     * @var \Spryker\Glue\ShoppingListsRestApi\Processor\RestResponseBuilder\ShoppingListRestResponseBuilderInterface
     */
    protected $shoppingListRestResponseBuilder;

    public function __construct(
        ShoppingListsRestApiClientInterface $shoppingListsRestApiClient,
        ShoppingListRestRequestReaderInterface $shoppingListRestRequestReaderInterface,
        ShoppingListRestResponseBuilderInterface $shoppingListRestResponseBuilderInterface
    ) {
        $this->shoppingListsRestApiClient = $shoppingListsRestApiClient;
        $this->shoppingListRestRequestReader = $shoppingListRestRequestReaderInterface;
        $this->shoppingListRestResponseBuilder = $shoppingListRestResponseBuilderInterface;
    }

    public function updateShoppingList(
        RestRequestInterface $restRequest,
        RestShoppingListRequestAttributesTransfer $restShoppingListRequestAttributesTransfer
    ): RestResponseInterface {
        $shoppingListTransfer = $this->shoppingListRestRequestReader->readShoppingListTransferFromRequest(
            $restRequest,
            $restShoppingListRequestAttributesTransfer,
        );

        $shoppingListResponseTransfer = $this->shoppingListsRestApiClient->updateShoppingList($shoppingListTransfer);

        if ($shoppingListResponseTransfer->getIsSuccess() === false) {
            return $this->shoppingListRestResponseBuilder->buildErrorRestResponse(
                $restRequest,
                $shoppingListResponseTransfer->getErrors(),
            );
        }

        return $this->shoppingListRestResponseBuilder->buildShoppingListRestResponse(
            $shoppingListResponseTransfer->getShoppingList(),
        );
    }
}
