<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace Spryker\Glue\ShoppingListsRestApi\Api\Storefront\Processor;

use Generated\Api\Storefront\ShoppingListsStorefrontResource;
use Generated\Shared\Transfer\ShoppingListTransfer;
use Spryker\ApiPlatform\State\Processor\AbstractStorefrontProcessor;
use Spryker\Client\ShoppingListsRestApi\ShoppingListsRestApiClientInterface;
use Spryker\Glue\ShoppingListsRestApi\Api\Storefront\Exception\ShoppingListsExceptionFactory;
use Spryker\Glue\ShoppingListsRestApi\Api\Storefront\Mapper\ShoppingListsResourceMapperInterface;
use Spryker\Service\Serializer\SerializerServiceInterface;

class ShoppingListsStorefrontProcessor extends AbstractStorefrontProcessor
{
    protected const string URI_VARIABLE_UUID = 'uuid';

    public function __construct(
        protected ShoppingListsRestApiClientInterface $shoppingListsRestApiClient,
        protected ShoppingListsExceptionFactory $exceptionFactory,
        protected ShoppingListsResourceMapperInterface $shoppingListsResourceMapper,
        protected SerializerServiceInterface $serializer,
    ) {
    }

    /**
     * @param \Generated\Api\Storefront\ShoppingListsStorefrontResource $data
     *
     * @throws \Spryker\ApiPlatform\Exception\GlueApiException
     */
    protected function processPost(mixed $data): mixed
    {
        $shoppingListTransfer = $this->buildShoppingListTransfer(name: $data->name);
        $shoppingListResponseTransfer = $this->shoppingListsRestApiClient->createShoppingList($shoppingListTransfer);

        if (!$shoppingListResponseTransfer->getIsSuccess()) {
            throw $this->exceptionFactory->createExceptionFromErrorIdentifier($shoppingListResponseTransfer->getErrors()[0] ?? null);
        }

        return $this->mapShoppingListTransferToResource($shoppingListResponseTransfer->getShoppingListOrFail());
    }

    /**
     * @param \Generated\Api\Storefront\ShoppingListsStorefrontResource $data
     *
     * @throws \Spryker\ApiPlatform\Exception\GlueApiException
     */
    protected function processPatch(mixed $data): mixed
    {
        $uuid = $this->getUriVariable(static::URI_VARIABLE_UUID);

        if (!is_string($uuid) || $uuid === '') {
            throw $this->exceptionFactory->createMissingShoppingListIdException();
        }

        $shoppingListTransfer = $this->buildShoppingListTransfer(uuid: $uuid, name: $data->name);
        $shoppingListResponseTransfer = $this->shoppingListsRestApiClient->updateShoppingList($shoppingListTransfer);

        if (!$shoppingListResponseTransfer->getIsSuccess()) {
            throw $this->exceptionFactory->createExceptionFromErrorIdentifier($shoppingListResponseTransfer->getErrors()[0] ?? null);
        }

        return $this->mapShoppingListTransferToResource($shoppingListResponseTransfer->getShoppingListOrFail());
    }

    protected function processDelete(): mixed
    {
        $uuid = $this->getUriVariable(static::URI_VARIABLE_UUID);

        if (!is_string($uuid) || $uuid === '') {
            throw $this->exceptionFactory->createMissingShoppingListIdException();
        }

        $shoppingListTransfer = $this->buildShoppingListTransfer(uuid: $uuid);
        $shoppingListResponseTransfer = $this->shoppingListsRestApiClient->deleteShoppingList($shoppingListTransfer);

        if (!$shoppingListResponseTransfer->getIsSuccess()) {
            throw $this->exceptionFactory->createExceptionFromErrorIdentifier($shoppingListResponseTransfer->getErrors()[0] ?? null);
        }

        return null;
    }

    protected function buildShoppingListTransfer(?string $uuid = null, ?string $name = null): ShoppingListTransfer
    {
        return (new ShoppingListTransfer())
            ->setUuid($uuid)
            ->setName($name)
            ->setCustomerReference($this->getCustomerReference())
            ->setIdCompanyUser($this->getCustomer()->getCompanyUserTransfer()?->getIdCompanyUser());
    }

    protected function mapShoppingListTransferToResource(ShoppingListTransfer $shoppingListTransfer): ShoppingListsStorefrontResource
    {
        return $this->serializer->denormalize(
            $this->shoppingListsResourceMapper->mapShoppingListTransferToResourceData($shoppingListTransfer),
            ShoppingListsStorefrontResource::class,
        );
    }
}
