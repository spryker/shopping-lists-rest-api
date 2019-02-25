<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Translator\Business;

use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Spryker\Zed\Translator\Business\TranslatorBusinessFactory getFactory()
 */
class TranslatorFacade extends AbstractFacade implements TranslatorFacadeInterface
{
    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @return void
     */
    public function generateTranslationCache(): void
    {
        $this->getFactory()->createTranslationCacheGenerator()->generateTranslationCache();
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @return void
     */
    public function cleanTranslationCache(): void
    {
        $this->getFactory()->createTranslationCacheCleaner()->cleanTranslationCache();
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @deprecated Will be removed without replacement.
     *
     * @return void
     */
    public function prepareTranslatorService(): void
    {
        $this->getFactory()->createTranslatorPreparator()->prepareTranslatorService();
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param string $id
     * @param array $parameters
     * @param string|null $domain
     * @param string|null $locale
     *
     * @return string
     */
    public function trans($id, array $parameters = [], $domain = null, $locale = null): string
    {
        return $this->getFactory()->createTranslator()->trans($id, $parameters, $domain, $locale);
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param string $id
     * @param int $number
     * @param array $parameters
     * @param string|null $domain
     * @param string|null $locale
     *
     * @return string
     */
    public function transChoice($id, $number, array $parameters = [], $domain = null, $locale = null): string
    {
        return $this->getFactory()->createTranslator()->transChoice($id, $number, $parameters, $domain, $locale);
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param string $locale
     *
     * @@return void
     */
    public function setLocale($locale): void
    {
        $this->getFactory()->createTranslator()->setLocale($locale);
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @return string The locale
     */
    public function getLocale(): string
    {
        return $this->getFactory()->createTranslator()->getLocale();
    }
}
