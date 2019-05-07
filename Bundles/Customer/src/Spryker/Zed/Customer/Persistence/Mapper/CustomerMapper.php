<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Customer\Persistence\Mapper;

use Generated\Shared\Transfer\AddressTransfer;
use Generated\Shared\Transfer\CountryTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Orm\Zed\Customer\Persistence\SpyCustomerAddress;

class CustomerMapper implements CustomerMapperInterface
{
    /**
     * @param array $customer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function mapCustomerEntityToCustomer(array $customer): CustomerTransfer
    {
        $customerTransfer = (new CustomerTransfer())
            ->fromArray(
                $customer,
                true
            );

        return $customerTransfer;
    }

    /**
     * @param \Orm\Zed\Customer\Persistence\SpyCustomerAddress $customerAddressEntity
     *
     * @return \Generated\Shared\Transfer\AddressTransfer
     */
    public function mapCustomerAddressEntityToTransfer(SpyCustomerAddress $customerAddressEntity): AddressTransfer
    {
        $addressTransfer = (new AddressTransfer())->fromArray($customerAddressEntity->toArray(), true);

        $countryEntity = $customerAddressEntity->getCountry();
        if ($countryEntity !== null) {
            $countryTransfer = (new CountryTransfer())->fromArray($countryEntity->toArray(), true);
            $addressTransfer->setCountry($countryTransfer);
            $addressTransfer->setIso2Code($countryTransfer->getIso2Code());
        }

        return $addressTransfer;
    }
}
