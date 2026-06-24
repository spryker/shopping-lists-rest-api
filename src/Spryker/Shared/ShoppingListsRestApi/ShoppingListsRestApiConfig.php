<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Shared\ShoppingListsRestApi;

use Spryker\Shared\Kernel\AbstractBundleConfig;

class ShoppingListsRestApiConfig extends AbstractBundleConfig
{
    /**
     * @api
     *
     * @var string
     */
    public const ERROR_IDENTIFIER_SHOPPING_LIST_ID_NOT_SPECIFIED = 'ERROR_IDENTIFIER_SHOPPING_LIST_ID_NOT_SPECIFIED';

    /**
     * @api
     *
     * @var string
     */
    public const ERROR_IDENTIFIER_SHOPPING_LIST_ITEM_ID_NOT_SPECIFIED = 'ERROR_IDENTIFIER_SHOPPING_LIST_ITEM_ID_NOT_SPECIFIED';

    /**
     * @api
     *
     * @var string
     */
    public const ERROR_IDENTIFIER_SHOPPING_LIST_NOT_FOUND = 'ERROR_IDENTIFIER_SHOPPING_LIST_NOT_FOUND';

    /**
     * @api
     *
     * @var string
     */
    public const ERROR_IDENTIFIER_SHOPPING_LIST_ITEM_NOT_FOUND = 'ERROR_IDENTIFIER_SHOPPING_LIST_ITEM_NOT_FOUND';

    /**
     * @api
     *
     * @var string
     */
    public const ERROR_IDENTIFIER_SHOPPING_LIST_WRITE_PERMISSION_REQUIRED = 'ERROR_IDENTIFIER_SHOPPING_LIST_WRITE_PERMISSION_REQUIRED';

    /**
     * @api
     *
     * @var string
     */
    public const ERROR_IDENTIFIER_SHOPPING_LIST_DUPLICATE_NAME = 'ERROR_IDENTIFIER_SHOPPING_LIST_DUPLICATE_NAME';

    /**
     * @api
     *
     * @var string
     */
    public const ERROR_IDENTIFIER_SHOPPING_LIST_WRONG_QUANTITY = 'ERROR_IDENTIFIER_SHOPPING_LIST_WRONG_QUANTITY';

    /**
     * @api
     *
     * @var string
     */
    public const ERROR_IDENTIFIER_SHOPPING_LIST_PRODUCT_NOT_FOUND = 'ERROR_IDENTIFIER_SHOPPING_LIST_PRODUCT_NOT_FOUND';

    /**
     * @api
     *
     * @var string
     */
    public const ERROR_IDENTIFIER_SHOPPING_LIST_ITEM_PRODUCT_NOT_ACTIVE = 'ERROR_IDENTIFIER_SHOPPING_LIST_ITEM_PRODUCT_NOT_ACTIVE';

    /**
     * @api
     *
     * @var string
     */
    public const ERROR_IDENTIFIER_SHOPPING_LIST_PRE_ADD_CHECK_PRODUCT_DISCONTINUED = 'ERROR_IDENTIFIER_SHOPPING_LIST_PRE_ADD_CHECK_PRODUCT_DISCONTINUED';

    /**
     * @api
     *
     * @var string
     */
    public const ERROR_IDENTIFIER_SHOPPING_LIST_PRE_ADD_CHECK_PRODUCT_MERCHANT_INACTIVE = 'ERROR_IDENTIFIER_SHOPPING_LIST_PRE_ADD_CHECK_PRODUCT_MERCHANT_INACTIVE';

    /**
     * @api
     *
     * @var string
     */
    public const ERROR_IDENTIFIER_SHOPPING_LIST_PRE_ADD_CHECK_PRODUCT_MERCHANT_NOT_APPROVED = 'ERROR_IDENTIFIER_SHOPPING_LIST_PRE_ADD_CHECK_PRODUCT_MERCHANT_NOT_APPROVED';

    /**
     * @api
     *
     * @var string
     */
    public const ERROR_IDENTIFIER_SHOPPING_LIST_PRE_ADD_CHECK_PRODUCT_OFFER_MERCHANT_INACTIVE = 'ERROR_IDENTIFIER_SHOPPING_LIST_PRE_ADD_CHECK_PRODUCT_OFFER_MERCHANT_INACTIVE';

    /**
     * @api
     *
     * @var string
     */
    public const ERROR_IDENTIFIER_SHOPPING_LIST_PRE_ADD_CHECK_PRODUCT_OFFER_MERCHANT_NOT_APPROVED = 'ERROR_IDENTIFIER_SHOPPING_LIST_PRE_ADD_CHECK_PRODUCT_OFFER_MERCHANT_NOT_APPROVED';

    /**
     * @api
     *
     * @var string
     */
    public const ERROR_IDENTIFIER_SHOPPING_LIST_PRE_ADD_CHECK_PRODUCT_OFFER_NOT_APPROVED = 'ERROR_IDENTIFIER_SHOPPING_LIST_PRE_ADD_CHECK_PRODUCT_OFFER_NOT_APPROVED';

    /**
     * @api
     *
     * @var string
     */
    public const ERROR_IDENTIFIER_SHOPPING_LIST_PRE_ADD_CHECK_PRODUCT_OFFER_NOT_ACTIVE = 'ERROR_IDENTIFIER_SHOPPING_LIST_PRE_ADD_CHECK_PRODUCT_OFFER_NOT_ACTIVE';

    /**
     * @api
     *
     * @var string
     */
    public const ERROR_IDENTIFIER_SHOPPING_LIST_PRE_ADD_CHECK_PRODUCT_NOT_APPROVED = 'ERROR_IDENTIFIER_SHOPPING_LIST_PRE_ADD_CHECK_PRODUCT_NOT_APPROVED';

    /**
     * @api
     *
     * @var string
     */
    public const ERROR_IDENTIFIER_SHOPPING_LIST_PRE_ADD_CHECK_PRODUCT_NOT_ACTIVE = 'ERROR_IDENTIFIER_SHOPPING_LIST_PRE_ADD_CHECK_PRODUCT_NOT_ACTIVE';

    /**
     * @api
     *
     * @var string
     */
    public const ERROR_IDENTIFIER_SHOPPING_LIST_PRE_ADD_CHECK_PRODUCT_OFFER_NOT_FOUND = 'ERROR_IDENTIFIER_SHOPPING_LIST_PRE_ADD_CHECK_PRODUCT_OFFER_NOT_FOUND';

    /**
     * @api
     *
     * @var string
     */
    public const ERROR_IDENTIFIER_SHOPPING_LIST_PRE_ADD_CHECK_PRODUCT_STORE_INVALID = 'ERROR_IDENTIFIER_SHOPPING_LIST_PRE_ADD_CHECK_PRODUCT_STORE_INVALID';

    /**
     * @api
     *
     * @var string
     */
    public const ERROR_IDENTIFIER_SHOPPING_LIST_PRE_ADD_CHECK_PRODUCT_OFFER_STORE_INVALID = 'ERROR_IDENTIFIER_SHOPPING_LIST_PRE_ADD_CHECK_PRODUCT_OFFER_STORE_INVALID';
}
