<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace Spryker\Glue\ShoppingListsRestApi\Api\Storefront\Provider;

use Generated\Api\Storefront\ShoppingListsStorefrontResource;
use Generated\Shared\Transfer\ShoppingListConditionsTransfer;
use Generated\Shared\Transfer\ShoppingListCriteriaTransfer;
use Generated\Shared\Transfer\ShoppingListTransfer;
use Spryker\ApiPlatform\State\Provider\AbstractStorefrontProvider;
use Spryker\Client\ShoppingList\ShoppingListClientInterface;
use Spryker\Glue\ShoppingListsRestApi\Api\Storefront\Exception\ShoppingListsExceptionFactory;
use Spryker\Glue\ShoppingListsRestApi\Api\Storefront\Mapper\ShoppingListsResourceMapperInterface;
use Spryker\Service\Serializer\SerializerServiceInterface;

class ShoppingListsStorefrontProvider extends AbstractStorefrontProvider
{
    protected const string URI_VARIABLE_UUID = 'uuid';

    public function __construct(
        protected ShoppingListClientInterface $shoppingListClient,
        protected ShoppingListsExceptionFactory $exceptionFactory,
        protected ShoppingListsResourceMapperInterface $shoppingListsResourceMapper,
        protected SerializerServiceInterface $serializer,
    ) {
    }

    /**
     * @return array<\Generated\Api\Storefront\ShoppingListsStorefrontResource>
     */
    protected function provideCollection(): array
    {
        $customer = $this->getCustomer();

        $shoppingListConditionsTransfer = (new ShoppingListConditionsTransfer())
            ->addCustomerReference($customer->getCustomerReferenceOrFail())
            ->setWithExcludedBlacklistedShoppingLists(true)
            ->setWithCustomerSharedShoppingLists(true)
            ->setWithBusinessUnitSharedShoppingLists(true)
            ->setWithShoppingListItems(true);

        $companyUserTransfer = $customer->getCompanyUserTransfer();

        if ($companyUserTransfer && $companyUserTransfer->getIdCompanyUser()) {
            $shoppingListConditionsTransfer
                ->addIdCompanyUser($companyUserTransfer->getIdCompanyUser())
                ->addIdBlacklistCompanyUser($companyUserTransfer->getIdCompanyUser())
                ->addIdCompanyBusinessUnit($companyUserTransfer->getFkCompanyBusinessUnit());
        }

        $shoppingListCriteriaTransfer = (new ShoppingListCriteriaTransfer())
            ->setShoppingListConditions($shoppingListConditionsTransfer);

        $shoppingListCollectionTransfer = $this->shoppingListClient->getShoppingListCollection($shoppingListCriteriaTransfer);

        $resources = [];

        foreach ($shoppingListCollectionTransfer->getShoppingLists() as $shoppingListTransfer) {
            $resources[] = $this->mapShoppingListTransferToResource($shoppingListTransfer);
        }

        return $resources;
    }

    /**
     * @throws \Spryker\ApiPlatform\Exception\GlueApiException
     *
     * @return \Generated\Api\Storefront\ShoppingListsStorefrontResource|null
     */
    protected function provideItem(): ?object
    {
        $uuid = $this->getUriVariable(static::URI_VARIABLE_UUID);

        if (!is_string($uuid) || $uuid === '') {
            throw $this->exceptionFactory->createMissingShoppingListIdException();
        }

        $customer = $this->getCustomer();

        $shoppingListTransfer = (new ShoppingListTransfer())
            ->setUuid($uuid)
            ->setCustomerReference($customer->getCustomerReferenceOrFail())
            ->setIdCompanyUser($customer->getCompanyUserTransfer()?->getIdCompanyUser());

        $shoppingListResponseTransfer = $this->shoppingListClient->findShoppingListByUuid($shoppingListTransfer);

        if (!$shoppingListResponseTransfer->getIsSuccess()) {
            throw $this->exceptionFactory->createShoppingListNotFoundException();
        }

        return $this->mapShoppingListTransferToResource($shoppingListResponseTransfer->getShoppingListOrFail());
    }

    protected function mapShoppingListTransferToResource(ShoppingListTransfer $shoppingListTransfer): ShoppingListsStorefrontResource
    {
        return $this->serializer->denormalize(
            $this->shoppingListsResourceMapper->mapShoppingListTransferToResourceData($shoppingListTransfer),
            ShoppingListsStorefrontResource::class,
        );
    }
}
