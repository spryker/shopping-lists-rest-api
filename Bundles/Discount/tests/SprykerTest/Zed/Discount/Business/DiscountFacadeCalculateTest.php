<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\Discount\Business;

use Codeception\TestCase\Test;
use DateTime;
use Generated\Shared\Transfer\DiscountTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Orm\Zed\Discount\Persistence\SpyDiscount;
use Orm\Zed\Discount\Persistence\SpyDiscountQuery;
use Orm\Zed\Discount\Persistence\SpyDiscountVoucher;
use Orm\Zed\Discount\Persistence\SpyDiscountVoucherPool;
use Propel\Runtime\Propel;
use SprykerTest\Shared\Testify\Helper\LocatorHelperTrait;
use Spryker\Shared\Discount\DiscountConstants;
use Spryker\Zed\Discount\Business\QueryString\ComparatorOperators;
use Spryker\Zed\Discount\DiscountDependencyProvider;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Zed
 * @group Discount
 * @group Business
 * @group Facade
 * @group DiscountFacadeCalculateTest
 * Add your own group annotations below this line
 */
class DiscountFacadeCalculateTest extends Test
{

    use LocatorHelperTrait;

    /**
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();

        $discounts = SpyDiscountQuery::create()->find();
        foreach ($discounts as $discountEntity) {
            $discountEntity->setIsActive(false);
            $discountEntity->save();
        }
    }

    /**
     * @return void
     */
    public function testCalculateWhenQueryStringMatchesAllItemsIncludeAllProvidedDiscounts()
    {
        $discountEntity = $this->createDiscountEntity(
            '(sku = "123" or sku = "431")',
            'sku = "123" or sku is in "123' . ComparatorOperators::LIST_DELIMITER . '431"'
        );

        $quoteTransfer = $this->createQuoteTransfer();

        $discountFacade = $this->getFacade();
        $quoteTransfer = $discountFacade->calculateDiscounts($quoteTransfer);

        $cartRuleDiscounts = $quoteTransfer->getCartRuleDiscounts();

        $this->assertCount(1, $cartRuleDiscounts);

        $discountTransfer = $cartRuleDiscounts[0];
        $this->assertEquals($discountEntity->getAmount(), $discountTransfer->getAmount());
    }

    /**
     * @return void
     */
    public function testCalculateWithEmptyDecisionRuleShouldIncludeDiscount()
    {
        $discountEntity = $this->createDiscountEntity(
            '',
            'sku = "123" or sku is in "123' . ComparatorOperators::LIST_DELIMITER . '431"'
        );

        $quoteTransfer = $this->createQuoteTransfer();

        $discountFacade = $this->getFacade();
        $quoteTransfer = $discountFacade->calculateDiscounts($quoteTransfer);

        $cartRuleDiscounts = $quoteTransfer->getCartRuleDiscounts();

        $this->assertCount(1, $cartRuleDiscounts);

        $discountTransfer = $cartRuleDiscounts[0];
        $this->assertEquals($discountEntity->getAmount(), $discountTransfer->getAmount());
    }

    /**
     * @return void
     */
    public function testCalculateWithIncorrectDecisionRuleShouldSkipDiscount()
    {
        $this->createDiscountEntity(
            'alskdhas jkashdj asjkdhjashdjs ahjdhas1293820',
            'sku = "123" or sku is in "123' . ComparatorOperators::LIST_DELIMITER . '431"'
        );

        $quoteTransfer = $this->createQuoteTransfer();

        $discountFacade = $this->getFacade();
        $quoteTransfer = $discountFacade->calculateDiscounts($quoteTransfer);

        $cartRuleDiscounts = $quoteTransfer->getCartRuleDiscounts();

        $this->assertCount(0, $cartRuleDiscounts);
    }

    /**
     * @return void
     */
    public function testWhenMultipleVouchersFromSamePoolUsedShouldUseOnlyOnce()
    {
        Propel::disableInstancePooling();

        $discountEntity = $this->createDiscountEntity(
            '',
            'sku = "*"',
            DiscountConstants::TYPE_VOUCHER
        );

        $code1 = 'code1';
        $code2 = 'code2';

        $this->createVoucherCode($code1, $discountEntity);
        $this->createVoucherCode($code2, $discountEntity);

        $quoteTransfer = $this->createQuoteTransfer();

        $discountTransfer = new DiscountTransfer();
        $discountTransfer->setVoucherCode($code1);
        $quoteTransfer->addVoucherDiscount($discountTransfer);

        $discountTransfer = new DiscountTransfer();
        $discountTransfer->setVoucherCode($code2);
        $quoteTransfer->addVoucherDiscount($discountTransfer);

        $discountFacade = $this->getFacade();
        $quoteTransfer = $discountFacade->calculateDiscounts($quoteTransfer);

        $discountTransfer = $quoteTransfer->getVoucherDiscounts()[0];

        $this->assertCount(1, $quoteTransfer->getVoucherDiscounts());
        $this->assertEquals($code1, $discountTransfer->getVoucherCode());
    }

    /**
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    protected function createQuoteTransfer()
    {
        $quoteTransfer = new QuoteTransfer();

        $itemTransfer = new ItemTransfer();
        $itemTransfer->setAbstractSku('123');
        $itemTransfer->setSku('123');
        $itemTransfer->setUnitGrossPrice(15000);

        $quoteTransfer->addItem($itemTransfer);

        $itemTransfer = new ItemTransfer();
        $itemTransfer->setAbstractSku('321');
        $itemTransfer->setSku('431');
        $itemTransfer->setUnitGrossPrice(1000);

        $quoteTransfer->addItem($itemTransfer);

        return $quoteTransfer;
    }

    /**
     * @param string $decisionRuleQueryString
     * @param string $collectorQueryString
     * @param string $discountType
     *
     * @return \Orm\Zed\Discount\Persistence\SpyDiscount
     */
    protected function createDiscountEntity(
        $decisionRuleQueryString,
        $collectorQueryString,
        $discountType = DiscountConstants::TYPE_CART_RULE
    ) {
        $discountVoucherPool = new SpyDiscountVoucherPool();
        $discountVoucherPool->setIsActive(true);
        $discountVoucherPool->setName('test');
        $discountVoucherPool->save();

        $discountEntity = new SpyDiscount();
        $discountEntity->setAmount(100);
        $discountEntity->setFkDiscountVoucherPool($discountVoucherPool->getIdDiscountVoucherPool());
        $discountEntity->setDecisionRuleQueryString($decisionRuleQueryString);
        $discountEntity->setCollectorQueryString($collectorQueryString);

        $discountEntity->setDisplayName('display name');
        $discountEntity->setCalculatorPlugin(DiscountDependencyProvider::PLUGIN_CALCULATOR_FIXED);
        $discountEntity->setDiscountType($discountType);
        $discountEntity->setIsActive(1);
        $discountEntity->setValidFrom(new DateTime('yesterday'));
        $discountEntity->setValidTo(new DateTime('tomorrow'));
        $discountEntity->save();

        return $discountEntity;
    }

    /**
     * @param string $voucherCode
     * @param \Orm\Zed\Discount\Persistence\SpyDiscount $discountEntity
     *
     * @return \Orm\Zed\Discount\Persistence\SpyDiscountVoucher
     */
    protected function createVoucherCode($voucherCode, SpyDiscount $discountEntity)
    {
        $voucherEntity = new SpyDiscountVoucher();
        $voucherEntity->setFkDiscountVoucherPool($discountEntity->getFkDiscountVoucherPool());
        $voucherEntity->setCode($voucherCode);
        $voucherEntity->setIsActive(true);
        $voucherEntity->save();

        return $voucherEntity;
    }

    /**
     * @return \Spryker\Zed\Discount\Business\DiscountFacadeInterface
     */
    protected function getFacade()
    {
        return $this->getLocator()->discount()->facade();
    }

}