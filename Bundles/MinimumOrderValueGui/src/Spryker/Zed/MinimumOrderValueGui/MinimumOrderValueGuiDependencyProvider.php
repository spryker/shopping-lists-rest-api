<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MinimumOrderValueGui;

use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\MinimumOrderValueGui\Dependency\Facade\MinimumOrderValueGuiToCurrencyFacadeBridge;
use Spryker\Zed\MinimumOrderValueGui\Dependency\Facade\MinimumOrderValueGuiToMinimumOrderValueFacadeBridge;
use Spryker\Zed\MinimumOrderValueGui\Dependency\Facade\MinimumOrderValueGuiToMoneyFacadeBridge;

class MinimumOrderValueGuiDependencyProvider extends AbstractBundleDependencyProvider
{
    public const FACADE_CURRENCY = 'FACADE_CURRENCY';
    public const FACADE_MINIMUM_ORDER_VALUE = 'FACADE_MINIMUM_ORDER_VALUE';
    public const FACADE_MONEY = 'FACADE_MONEY';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = parent::provideCommunicationLayerDependencies($container);

        $container = $this->addCurrencyFacade($container);
        $container = $this->addMinimumOrderValueFacade($container);
        $container = $this->addMoneyFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCurrencyFacade(Container $container): Container
    {
        $container[static::FACADE_CURRENCY] = function (Container $container) {
            return new MinimumOrderValueGuiToCurrencyFacadeBridge($container->getLocator()->currency()->facade());
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addMinimumOrderValueFacade(Container $container): Container
    {
        $container[static::FACADE_MINIMUM_ORDER_VALUE] = function (Container $container) {
            return new MinimumOrderValueGuiToMinimumOrderValueFacadeBridge($container->getLocator()->minimumOrderValue()->facade());
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addMoneyFacade(Container $container): Container
    {
        $container[static::FACADE_MONEY] = function (Container $container) {
            return new MinimumOrderValueGuiToMoneyFacadeBridge($container->getLocator()->money()->facade());
        };

        return $container;
    }
}
