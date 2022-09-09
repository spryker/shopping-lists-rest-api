<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\ShoppingListsRestApi;

use Spryker\Glue\Kernel\AbstractFactory;
use Spryker\Glue\ShoppingListsRestApi\Dependency\Client\ShoppingListsRestApiToGlossaryStorageClientInterface;
use Spryker\Glue\ShoppingListsRestApi\Dependency\Client\ShoppingListsRestApiToShoppingListClientInterface;
use Spryker\Glue\ShoppingListsRestApi\Processor\Expander\ShoppingListItemExpander;
use Spryker\Glue\ShoppingListsRestApi\Processor\Expander\ShoppingListItemExpanderInterface;
use Spryker\Glue\ShoppingListsRestApi\Processor\Mapper\CustomerMapper;
use Spryker\Glue\ShoppingListsRestApi\Processor\Mapper\CustomerMapperInterface;
use Spryker\Glue\ShoppingListsRestApi\Processor\Mapper\ShoppingListItemMapper;
use Spryker\Glue\ShoppingListsRestApi\Processor\Mapper\ShoppingListItemMapperInterface;
use Spryker\Glue\ShoppingListsRestApi\Processor\Mapper\ShoppingListMapper;
use Spryker\Glue\ShoppingListsRestApi\Processor\Mapper\ShoppingListMapperInterface;
use Spryker\Glue\ShoppingListsRestApi\Processor\RestRequest\ShoppingListItemRestRequestReader;
use Spryker\Glue\ShoppingListsRestApi\Processor\RestRequest\ShoppingListItemRestRequestReaderInterface;
use Spryker\Glue\ShoppingListsRestApi\Processor\RestRequest\ShoppingListRestRequestReader;
use Spryker\Glue\ShoppingListsRestApi\Processor\RestRequest\ShoppingListRestRequestReaderInterface;
use Spryker\Glue\ShoppingListsRestApi\Processor\RestResponseBuilder\ShoppingListItemRestResponseBuilder;
use Spryker\Glue\ShoppingListsRestApi\Processor\RestResponseBuilder\ShoppingListItemRestResponseBuilderInterface;
use Spryker\Glue\ShoppingListsRestApi\Processor\RestResponseBuilder\ShoppingListRestResponseBuilder;
use Spryker\Glue\ShoppingListsRestApi\Processor\RestResponseBuilder\ShoppingListRestResponseBuilderInterface;
use Spryker\Glue\ShoppingListsRestApi\Processor\ShoppingList\ShoppingListCreator;
use Spryker\Glue\ShoppingListsRestApi\Processor\ShoppingList\ShoppingListCreatorInterface;
use Spryker\Glue\ShoppingListsRestApi\Processor\ShoppingList\ShoppingListDeleter;
use Spryker\Glue\ShoppingListsRestApi\Processor\ShoppingList\ShoppingListDeleterInterface;
use Spryker\Glue\ShoppingListsRestApi\Processor\ShoppingList\ShoppingListReader;
use Spryker\Glue\ShoppingListsRestApi\Processor\ShoppingList\ShoppingListReaderInterface;
use Spryker\Glue\ShoppingListsRestApi\Processor\ShoppingList\ShoppingListUpdater;
use Spryker\Glue\ShoppingListsRestApi\Processor\ShoppingList\ShoppingListUpdaterInterface;
use Spryker\Glue\ShoppingListsRestApi\Processor\ShoppingListItem\ShoppingListItemAdder;
use Spryker\Glue\ShoppingListsRestApi\Processor\ShoppingListItem\ShoppingListItemAdderInterface;
use Spryker\Glue\ShoppingListsRestApi\Processor\ShoppingListItem\ShoppingListItemDeleter;
use Spryker\Glue\ShoppingListsRestApi\Processor\ShoppingListItem\ShoppingListItemDeleterInterface;
use Spryker\Glue\ShoppingListsRestApi\Processor\ShoppingListItem\ShoppingListItemUpdater;
use Spryker\Glue\ShoppingListsRestApi\Processor\ShoppingListItem\ShoppingListItemUpdaterInterface;

/**
 * @method \Spryker\Client\ShoppingListsRestApi\ShoppingListsRestApiClientInterface getClient()
 */
class ShoppingListsRestApiFactory extends AbstractFactory
{
    /**
     * @return \Spryker\Glue\ShoppingListsRestApi\Processor\ShoppingList\ShoppingListReaderInterface
     */
    public function createShoppingListReader(): ShoppingListReaderInterface
    {
        return new ShoppingListReader(
            $this->createCustomerMapper(),
            $this->getClient(),
            $this->getShoppingListClient(),
            $this->createShoppingListRestRequestReader(),
            $this->createShoppingListRestResponseBuilder(),
        );
    }

    /**
     * @return \Spryker\Glue\ShoppingListsRestApi\Processor\ShoppingList\ShoppingListCreatorInterface
     */
    public function createShoppingListCreator(): ShoppingListCreatorInterface
    {
        return new ShoppingListCreator(
            $this->getClient(),
            $this->createShoppingListRestRequestReader(),
            $this->createShoppingListRestResponseBuilder(),
        );
    }

    /**
     * @return \Spryker\Glue\ShoppingListsRestApi\Processor\ShoppingList\ShoppingListUpdaterInterface
     */
    public function createShoppingListUpdater(): ShoppingListUpdaterInterface
    {
        return new ShoppingListUpdater(
            $this->getClient(),
            $this->createShoppingListRestRequestReader(),
            $this->createShoppingListRestResponseBuilder(),
        );
    }

    /**
     * @return \Spryker\Glue\ShoppingListsRestApi\Processor\ShoppingList\ShoppingListDeleterInterface
     */
    public function createShoppingListDeleter(): ShoppingListDeleterInterface
    {
        return new ShoppingListDeleter(
            $this->getClient(),
            $this->createShoppingListRestRequestReader(),
            $this->createShoppingListRestResponseBuilder(),
        );
    }

    /**
     * @return \Spryker\Glue\ShoppingListsRestApi\Processor\ShoppingListItem\ShoppingListItemAdderInterface
     */
    public function createShoppingListItemAdder(): ShoppingListItemAdderInterface
    {
        return new ShoppingListItemAdder(
            $this->getClient(),
            $this->createShoppingListItemMapper(),
            $this->createShoppingListItemRestRequestReader(),
            $this->createShoppingListItemRestResponseBuilder(),
        );
    }

    /**
     * @return \Spryker\Glue\ShoppingListsRestApi\Processor\ShoppingListItem\ShoppingListItemUpdaterInterface
     */
    public function createShoppingListItemUpdater(): ShoppingListItemUpdaterInterface
    {
        return new ShoppingListItemUpdater(
            $this->getClient(),
            $this->createShoppingListItemMapper(),
            $this->createShoppingListItemRestRequestReader(),
            $this->createShoppingListItemRestResponseBuilder(),
        );
    }

    /**
     * @return \Spryker\Glue\ShoppingListsRestApi\Processor\ShoppingListItem\ShoppingListItemDeleterInterface
     */
    public function createShoppingListItemDeleter(): ShoppingListItemDeleterInterface
    {
        return new ShoppingListItemDeleter(
            $this->getClient(),
            $this->createShoppingListItemRestRequestReader(),
            $this->createShoppingListItemRestResponseBuilder(),
        );
    }

    /**
     * @return \Spryker\Glue\ShoppingListsRestApi\Processor\Expander\ShoppingListItemExpanderInterface
     */
    public function createShoppingListItemExpander(): ShoppingListItemExpanderInterface
    {
        return new ShoppingListItemExpander($this->createShoppingListItemRestResponseBuilder());
    }

    /**
     * @return \Spryker\Glue\ShoppingListsRestApi\Processor\Mapper\ShoppingListMapperInterface
     */
    public function createShoppingListMapper(): ShoppingListMapperInterface
    {
        return new ShoppingListMapper();
    }

    /**
     * @return \Spryker\Glue\ShoppingListsRestApi\Processor\Mapper\ShoppingListItemMapperInterface
     */
    public function createShoppingListItemMapper(): ShoppingListItemMapperInterface
    {
        return new ShoppingListItemMapper(
            $this->getRestShoppingListItemsAttributesMapperPlugins(),
            $this->getShoppingListItemRequestMapperPlugins(),
        );
    }

    /**
     * @return \Spryker\Glue\ShoppingListsRestApi\Processor\Mapper\CustomerMapperInterface
     */
    public function createCustomerMapper(): CustomerMapperInterface
    {
        return new CustomerMapper();
    }

    /**
     * @return \Spryker\Glue\ShoppingListsRestApi\Processor\RestRequest\ShoppingListRestRequestReaderInterface
     */
    public function createShoppingListRestRequestReader(): ShoppingListRestRequestReaderInterface
    {
        return new ShoppingListRestRequestReader(
            $this->createShoppingListMapper(),
        );
    }

    /**
     * @return \Spryker\Glue\ShoppingListsRestApi\Processor\RestRequest\ShoppingListItemRestRequestReaderInterface
     */
    public function createShoppingListItemRestRequestReader(): ShoppingListItemRestRequestReaderInterface
    {
        return new ShoppingListItemRestRequestReader();
    }

    /**
     * @return \Spryker\Glue\ShoppingListsRestApi\Processor\RestResponseBuilder\ShoppingListRestResponseBuilderInterface
     */
    public function createShoppingListRestResponseBuilder(): ShoppingListRestResponseBuilderInterface
    {
        return new ShoppingListRestResponseBuilder(
            $this->getResourceBuilder(),
            $this->createShoppingListMapper(),
            $this->createShoppingListItemRestResponseBuilder(),
            $this->getGlossaryStorageClient(),
        );
    }

    /**
     * @return \Spryker\Glue\ShoppingListsRestApi\Processor\RestResponseBuilder\ShoppingListItemRestResponseBuilderInterface
     */
    public function createShoppingListItemRestResponseBuilder(): ShoppingListItemRestResponseBuilderInterface
    {
        return new ShoppingListItemRestResponseBuilder(
            $this->getResourceBuilder(),
            $this->createShoppingListItemMapper(),
            $this->getGlossaryStorageClient(),
        );
    }

    /**
     * @return \Spryker\Glue\ShoppingListsRestApi\Dependency\Client\ShoppingListsRestApiToShoppingListClientInterface
     */
    public function getShoppingListClient(): ShoppingListsRestApiToShoppingListClientInterface
    {
        return $this->getProvidedDependency(ShoppingListsRestApiDependencyProvider::CLIENT_SHOPPING_LIST);
    }

    /**
     * @return \Spryker\Glue\ShoppingListsRestApi\Dependency\Client\ShoppingListsRestApiToGlossaryStorageClientInterface
     */
    public function getGlossaryStorageClient(): ShoppingListsRestApiToGlossaryStorageClientInterface
    {
        return $this->getProvidedDependency(ShoppingListsRestApiDependencyProvider::CLIENT_GLOSSARY_STORAGE);
    }

    /**
     * @return array<\Spryker\Glue\ShoppingListsRestApiExtension\Dependency\Plugin\RestShoppingListItemsAttributesMapperPluginInterface>
     */
    public function getRestShoppingListItemsAttributesMapperPlugins(): array
    {
        return $this->getProvidedDependency(ShoppingListsRestApiDependencyProvider::PLUGINS_REST_SHOPPING_LIST_ITEMS_ATTRIBUTES_MAPPER);
    }

    /**
     * @return array<\Spryker\Glue\ShoppingListsRestApiExtension\Dependency\Plugin\ShoppingListItemRequestMapperPluginInterface>
     */
    public function getShoppingListItemRequestMapperPlugins(): array
    {
        return $this->getProvidedDependency(ShoppingListsRestApiDependencyProvider::PLUGINS_SHOPPING_LIST_ITEM_REQUEST_MAPPER);
    }
}
