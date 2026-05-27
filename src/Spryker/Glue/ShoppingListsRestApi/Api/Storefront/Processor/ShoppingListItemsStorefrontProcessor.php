<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace Spryker\Glue\ShoppingListsRestApi\Api\Storefront\Processor;

use Generated\Api\Storefront\ShoppingListItemsStorefrontResource;
use Generated\Shared\Transfer\RestShoppingListItemsAttributesTransfer;
use Generated\Shared\Transfer\ShoppingListItemRequestTransfer;
use Generated\Shared\Transfer\ShoppingListItemTransfer;
use Spryker\ApiPlatform\State\Processor\AbstractStorefrontProcessor;
use Spryker\Client\ShoppingListsRestApi\ShoppingListsRestApiClientInterface;
use Spryker\Glue\ShoppingListsRestApi\Api\Storefront\Exception\ShoppingListsExceptionFactory;
use Spryker\Glue\ShoppingListsRestApi\Api\Storefront\Mapper\ShoppingListsResourceMapperInterface;
use Spryker\Service\Container\Attributes\Plugins;
use Spryker\Service\Serializer\SerializerServiceInterface;

class ShoppingListItemsStorefrontProcessor extends AbstractStorefrontProcessor
{
    protected const string URI_VARIABLE_SHOPPING_LIST_UUID = 'shoppingListUuid';

    protected const string URI_VARIABLE_UUID = 'uuid';

    /**
     * @param array<\Spryker\Glue\ShoppingListsRestApiExtension\Dependency\Plugin\ShoppingListItemRequestMapperPluginInterface> $shoppingListItemRequestMapperPlugins
     */
    public function __construct(
        protected ShoppingListsRestApiClientInterface $shoppingListsRestApiClient,
        protected ShoppingListsExceptionFactory $exceptionFactory,
        protected ShoppingListsResourceMapperInterface $shoppingListsResourceMapper,
        protected SerializerServiceInterface $serializer,
        #[Plugins(dependencyProviderMethod: 'getShoppingListItemRequestMapperPlugins')]
        protected array $shoppingListItemRequestMapperPlugins = [],
    ) {
    }

    /**
     * @param \Generated\Api\Storefront\ShoppingListItemsStorefrontResource $data
     *
     * @throws \Spryker\ApiPlatform\Exception\GlueApiException
     */
    protected function processPost(mixed $data): mixed
    {
        $shoppingListUuid = $this->resolveShoppingListUuid();

        $shoppingListItemTransfer = $this->buildBaseShoppingListItemTransfer()
            ->setSku($data->sku)
            ->setQuantity($data->quantity);

        $shoppingListItemRequestTransfer = (new ShoppingListItemRequestTransfer())
            ->setShoppingListUuid($shoppingListUuid)
            ->setShoppingListItem($shoppingListItemTransfer);

        $shoppingListItemRequestTransfer = $this->mapRawAttributesToShoppingListItemRequest(
            $this->getRawAttributes(),
            $shoppingListItemRequestTransfer,
        );

        $shoppingListItemResponseTransfer = $this->shoppingListsRestApiClient->addShoppingListItem($shoppingListItemRequestTransfer);

        if (!$shoppingListItemResponseTransfer->getIsSuccess()) {
            throw $this->exceptionFactory->createExceptionFromErrorIdentifier($shoppingListItemResponseTransfer->getErrors()[0] ?? null);
        }

        return $this->mapShoppingListItemTransferToResource($shoppingListItemResponseTransfer->getShoppingListItemOrFail(), $shoppingListUuid);
    }

    /**
     * @param \Generated\Api\Storefront\ShoppingListItemsStorefrontResource $data
     *
     * @throws \Spryker\ApiPlatform\Exception\GlueApiException
     */
    protected function processPatch(mixed $data): mixed
    {
        $shoppingListUuid = $this->resolveShoppingListUuid();
        $uuid = $this->getUriVariable(static::URI_VARIABLE_UUID);

        if (!is_string($uuid) || $uuid === '') {
            throw $this->exceptionFactory->createMissingShoppingListItemIdException();
        }

        $shoppingListItemTransfer = $this->buildBaseShoppingListItemTransfer()
            ->setUuid($uuid)
            ->setQuantity($data->quantity);

        $shoppingListItemRequestTransfer = (new ShoppingListItemRequestTransfer())
            ->setShoppingListUuid($shoppingListUuid)
            ->setShoppingListItem($shoppingListItemTransfer);

        $shoppingListItemRequestTransfer = $this->mapRawAttributesToShoppingListItemRequest(
            $this->getRawAttributes(),
            $shoppingListItemRequestTransfer,
        );

        $shoppingListItemResponseTransfer = $this->shoppingListsRestApiClient->updateShoppingListItem($shoppingListItemRequestTransfer);

        if (!$shoppingListItemResponseTransfer->getIsSuccess()) {
            throw $this->exceptionFactory->createExceptionFromErrorIdentifier($shoppingListItemResponseTransfer->getErrors()[0] ?? null);
        }

        return $this->mapShoppingListItemTransferToResource($shoppingListItemResponseTransfer->getShoppingListItemOrFail(), $shoppingListUuid);
    }

    protected function processDelete(): mixed
    {
        $shoppingListUuid = $this->resolveShoppingListUuid();
        $uuid = $this->getUriVariable(static::URI_VARIABLE_UUID);

        if (!is_string($uuid) || $uuid === '') {
            throw $this->exceptionFactory->createMissingShoppingListItemIdException();
        }

        $shoppingListItemTransfer = $this->buildBaseShoppingListItemTransfer()
            ->setUuid($uuid);

        $shoppingListItemRequestTransfer = (new ShoppingListItemRequestTransfer())
            ->setShoppingListUuid($shoppingListUuid)
            ->setShoppingListItem($shoppingListItemTransfer);

        $shoppingListItemResponseTransfer = $this->shoppingListsRestApiClient->deleteShoppingListItem($shoppingListItemRequestTransfer);

        if (!$shoppingListItemResponseTransfer->getIsSuccess()) {
            throw $this->exceptionFactory->createExceptionFromErrorIdentifier($shoppingListItemResponseTransfer->getErrors()[0] ?? null);
        }

        return null;
    }

    protected function buildBaseShoppingListItemTransfer(): ShoppingListItemTransfer
    {
        return (new ShoppingListItemTransfer())
            ->setCustomerReference($this->getCustomerReference())
            ->setIdCompanyUser($this->getCustomer()->getCompanyUserTransfer()?->getIdCompanyUser());
    }

    protected function resolveShoppingListUuid(): string
    {
        $shoppingListUuid = $this->getUriVariable(static::URI_VARIABLE_SHOPPING_LIST_UUID);

        if (!is_string($shoppingListUuid) || $shoppingListUuid === '') {
            throw $this->exceptionFactory->createShoppingListNotFoundException();
        }

        return $shoppingListUuid;
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

    /**
     * @param array<string, mixed> $rawAttributes
     */
    protected function mapRawAttributesToShoppingListItemRequest(
        array $rawAttributes,
        ShoppingListItemRequestTransfer $shoppingListItemRequestTransfer,
    ): ShoppingListItemRequestTransfer {
        $restShoppingListItemsAttributesTransfer = (new RestShoppingListItemsAttributesTransfer())
            ->fromArray($rawAttributes, true);

        // Propagate explicitly-modified attributes (including explicit nulls) directly to the item transfer,
        // matching the legacy ShoppingListItemMapper behaviour. This ensures that e.g. productConfigurationInstance: null
        // in the request body reaches the backend as an explicit null, so the backend can clear it.
        $shoppingListItemRequestTransfer->getShoppingListItemOrFail()->fromArray(
            $restShoppingListItemsAttributesTransfer->modifiedToArray(),
            true,
        );

        foreach ($this->shoppingListItemRequestMapperPlugins as $plugin) {
            $shoppingListItemRequestTransfer = $plugin->map(
                $restShoppingListItemsAttributesTransfer,
                $shoppingListItemRequestTransfer,
            );
        }

        return $shoppingListItemRequestTransfer;
    }

    /**
     * Reads `data.attributes` from the raw JSON:API request body so composed properties
     * (e.g. productConfigurationInstance) contributed by other modules reach the mapper
     * plugin chain.
     *
     * @return array<string, mixed>
     */
    protected function getRawAttributes(): array
    {
        $content = (string)$this->getRequest()->getContent();

        if ($content === '') {
            return [];
        }

        $decoded = json_decode($content, true);

        if (!is_array($decoded)) {
            return [];
        }

        $attributes = $decoded['data']['attributes'] ?? [];

        return is_array($attributes) ? $attributes : [];
    }
}
