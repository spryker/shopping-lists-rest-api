<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Permission\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\Permission\Business\PermissionExecutor\PermissionExecutor;
use Spryker\Zed\Permission\Business\PermissionFinder\PermissionFinder;
use Spryker\Zed\Permission\PermissionDependencyProvider;

/**
 * @method \Spryker\Zed\Permission\Persistence\PermissionQueryContainerInterface getQueryContainer()
 */
class PermissionBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \Spryker\Zed\Permission\Communication\Plugin\PermissionStoragePluginInterface
     */
    public function getPermissionStoragePlugin()
    {
        return $this->getProvidedDependency(PermissionDependencyProvider::PLUGIN_PERMISSION_STORAGE);
    }

    /**
     * @return \Spryker\Zed\Permission\Business\PermissionExecutor\PermissionExecutorInterface
     */
    public function createPermissionExecutor()
    {
        return new PermissionExecutor(
            $this->getPermissionStoragePlugin(),
            $this->createPermissionFinder()
        );
    }

    /**
     * @return \Spryker\Zed\Permission\Business\PermissionFinder\PermissionFinderInterface
     */
    public function createPermissionFinder()
    {
        return new PermissionFinder(
            $this->getPermissionPlugins()
        );
    }

    /**
     * @return \Spryker\Zed\Permission\Communication\Plugin\PermissionPluginInterface[]
     */
    public function getPermissionPlugins()
    {
        return $this->getProvidedDependency(PermissionDependencyProvider::PLUGINS_PERMISSION);
    }
}