<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace Spryker\Glue\ShoppingListsRestApi\Api\Storefront\Provider;

use Generated\Api\Storefront\ShoppingListItemsStorefrontResource;
use Generated\Shared\Transfer\ShoppingListItemTransfer;
use Generated\Shared\Transfer\ShoppingListTransfer;
use Spryker\ApiPlatform\State\Provider\AbstractStorefrontProvider;
use Spryker\Client\ShoppingList\ShoppingListClientInterface;
use Spryker\Glue\ShoppingListsRestApi\Api\Storefront\Exception\ShoppingListsExceptionFactory;
use Spryker\Glue\ShoppingListsRestApi\Api\Storefront\Mapper\ShoppingListsResourceMapperInterface;
use Spryker\Service\Serializer\SerializerServiceInterface;

class ShoppingListItemsStorefrontProvider extends AbstractStorefrontProvider
{
    protected const string URI_VARIABLE_SHOPPING_LIST_UUID = 'shoppingListUuid';

    protected const string URI_VARIABLE_UUID = 'uuid';

    public function __construct(
        protected ShoppingListClientInterface $shoppingListClient,
        protected ShoppingListsExceptionFactory $exceptionFactory,
        protected ShoppingListsResourceMapperInterface $shoppingListsResourceMapper,
        protected SerializerServiceInterface $serializer,
    ) {
    }

    /**
     * Provides a single shopping list item by UUID.
     *
     * The Get operation at /shopping-lists/{shoppingListUuid}/shopping-list-items/{uuid} exists
     * solely to give API Platform an item-level URI template for self-link generation — replicating
     * the explicit URL construction that the legacy
     * ShoppingListItemRestResponseBuilder::createSelfLinkForShoppingListItem() performed via
     * sprintf('/shopping-lists/%s/shopping-list-items/%s', $shoppingListUuid, $itemUuid).
     *
     * @throws \Spryker\ApiPlatform\Exception\GlueApiException
     *
     * @return \Generated\Api\Storefront\ShoppingListItemsStorefrontResource|null
     */
    protected function provideItem(): ?object
    {
        $shoppingListUuid = $this->getUriVariable(static::URI_VARIABLE_SHOPPING_LIST_UUID);
        $uuid = $this->getUriVariable(static::URI_VARIABLE_UUID);

        if (!is_string($shoppingListUuid) || $shoppingListUuid === '') {
            throw $this->exceptionFactory->createMissingShoppingListIdException();
        }

        if (!is_string($uuid) || $uuid === '') {
            throw $this->exceptionFactory->createMissingShoppingListItemIdException();
        }

        $customer = $this->getCustomer();

        $shoppingListTransfer = (new ShoppingListTransfer())
            ->setUuid($shoppingListUuid)
            ->setCustomerReference($customer->getCustomerReferenceOrFail())
            ->setIdCompanyUser($customer->getCompanyUserTransfer()?->getIdCompanyUser());

        $shoppingListResponseTransfer = $this->shoppingListClient->findShoppingListByUuid($shoppingListTransfer);

        if (!$shoppingListResponseTransfer->getIsSuccess()) {
            throw $this->exceptionFactory->createShoppingListNotFoundException();
        }

        foreach ($shoppingListResponseTransfer->getShoppingListOrFail()->getItems() as $shoppingListItemTransfer) {
            if ($shoppingListItemTransfer->getUuid() === $uuid) {
                return $this->mapShoppingListItemTransferToResource($shoppingListItemTransfer, $shoppingListUuid);
            }
        }

        throw $this->exceptionFactory->createShoppingListItemNotFoundException();
    }

    /**
     * @throws \Spryker\ApiPlatform\Exception\GlueApiException
     *
     * @return array<\Generated\Api\Storefront\ShoppingListItemsStorefrontResource>
     */
    protected function provideCollection(): array
    {
        $shoppingListUuid = $this->getUriVariable(static::URI_VARIABLE_SHOPPING_LIST_UUID);

        if (!is_string($shoppingListUuid) || $shoppingListUuid === '') {
            throw $this->exceptionFactory->createMissingShoppingListIdException();
        }

        $customer = $this->getCustomer();

        $shoppingListTransfer = (new ShoppingListTransfer())
            ->setUuid($shoppingListUuid)
            ->setCustomerReference($customer->getCustomerReferenceOrFail())
            ->setIdCompanyUser($customer->getCompanyUserTransfer()?->getIdCompanyUser());

        $shoppingListResponseTransfer = $this->shoppingListClient->findShoppingListByUuid($shoppingListTransfer);

        if (!$shoppingListResponseTransfer->getIsSuccess()) {
            throw $this->exceptionFactory->createShoppingListNotFoundException();
        }

        $resources = [];

        foreach ($this->deduplicateItems($shoppingListResponseTransfer->getShoppingListOrFail()->getItems()) as $shoppingListItemTransfer) {
            $resources[] = $this->mapShoppingListItemTransferToResource($shoppingListItemTransfer, $shoppingListUuid);
        }

        return $resources;
    }

    /**
     * @param iterable<\Generated\Shared\Transfer\ShoppingListItemTransfer> $items
     *
     * @return array<\Generated\Shared\Transfer\ShoppingListItemTransfer>
     *
     * ShoppingListFacade::findShoppingListByUuid() calls mapShoppingListTransfer() twice on the same
     * transfer object — once in ShoppingListRepository::findShoppingListByUuid() and again inside
     * ShoppingListReader::getShoppingList() → getShoppingListTransferWithCompanyData() →
     * ShoppingListRepository::findShoppingListById(). The mapper uses addItem() (not setItems()),
     * so each item in the list is appended twice to the same transfer.
     * See: Spryker\Zed\ShoppingList\Business\Model\ShoppingListReader::findShoppingListByUuid()
     *      Spryker\Zed\ShoppingList\Persistence\ShoppingListMapper::mapShoppingListItemCollectionTransferToShoppingListTransfer()
     */
    protected function deduplicateItems(iterable $items): array
    {
        $existingItem = [];
        $result = [];

        foreach ($items as $item) {
            $uuid = $item->getUuid();

            if ($uuid === null || isset($existingItem[$uuid])) {
                continue;
            }

            $existingItem[$uuid] = true;
            $result[] = $item;
        }

        return $result;
    }

    protected function mapShoppingListItemTransferToResource(
        ShoppingListItemTransfer $shoppingListItemTransfer,
        string $shoppingListUuid,
    ): ShoppingListItemsStorefrontResource {
        $resource = $this->serializer->denormalize(
            $this->shoppingListsResourceMapper->mapShoppingListItemTransferToResourceData($shoppingListItemTransfer),
            ShoppingListItemsStorefrontResource::class,
        );
        $resource->shoppingListUuid = $shoppingListUuid;

        return $resource;
    }
}
