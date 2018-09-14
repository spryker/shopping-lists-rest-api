<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\CompanyRole\Permission;

use ArrayObject;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\PermissionCollectionTransfer;
use Generated\Shared\Transfer\PermissionTransfer;
use Spryker\Client\CompanyRole\Dependency\Client\CompanyRoleToPermissionClientInterface;
use Spryker\Client\CompanyRole\Zed\CompanyRoleStubInterface;

class CompanyRolePermissionsHandler implements CompanyRolePermissionsHandlerInterface
{
    protected const PERMISSION_KEY_GLOSSARY_PREFIX = 'permission.name.';

    /**
     * @var \Spryker\Client\CompanyRole\Dependency\Client\CompanyRoleToPermissionClientInterface
     */
    protected $permissionClient;

    /**
     * @var \Spryker\Client\CompanyRole\Zed\CompanyRoleStubInterface
     */
    protected $companyRoleStub;

    /**
     * @param \Spryker\Client\CompanyRole\Dependency\Client\CompanyRoleToPermissionClientInterface $permissionClient
     * @param \Spryker\Client\CompanyRole\Zed\CompanyRoleStubInterface $companyRoleStub
     */
    public function __construct(
        CompanyRoleToPermissionClientInterface $permissionClient,
        CompanyRoleStubInterface $companyRoleStub
    ) {
        $this->permissionClient = $permissionClient;
        $this->companyRoleStub = $companyRoleStub;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyRoleTransfer $companyRoleTransfer
     *
     * @return \Generated\Shared\Transfer\PermissionCollectionTransfer
     */
    public function findFilteredCompanyRolePermissionsByIdCompanyRole(
        CompanyRoleTransfer $companyRoleTransfer
    ): PermissionCollectionTransfer {
        $preparedPermissions = new ArrayObject();

        $availablePermissions = $this->permissionClient->getRegisteredNonInfrastructuralPermissions()->getPermissions();
        $companyRolePermissions = $this->companyRoleStub->findCompanyRolePermissions($companyRoleTransfer)
            ->getPermissions();

        $filteredPermissions = $this->getAvailableCompanyRolePermissionKeyIndexes(
            $availablePermissions,
            $companyRolePermissions
        );

        foreach ($filteredPermissions as $filteredPermissionTransfer) {
            $permissionData = $this->transformPermissionTransferToArray(
                $companyRoleTransfer->getIdCompanyRole(),
                $filteredPermissions[$filteredPermissionTransfer->getKey()]
            );

            $preparedPermissions->append($permissionData);
        }

        return (new PermissionCollectionTransfer())
            ->setPermissions($preparedPermissions);
    }

    /**
     * @param int $idCompanyRole
     * @param \Generated\Shared\Transfer\PermissionTransfer $storedPermissionTransfer
     *
     * @return array
     */
    protected function transformPermissionTransferToArray(
        int $idCompanyRole,
        PermissionTransfer $storedPermissionTransfer
    ): array {
        $permissionData = $storedPermissionTransfer->toArray(false, true);

        $permissionGlossaryKeyName = static::PERMISSION_KEY_GLOSSARY_PREFIX . $permissionData[PermissionTransfer::KEY];
        $permissionData[PermissionTransfer::KEY] = $permissionGlossaryKeyName;
        $permissionData[CompanyRoleTransfer::ID_COMPANY_ROLE] = $idCompanyRole;

        return $permissionData;
    }

    /**
     * @param \ArrayObject|\Generated\Shared\Transfer\PermissionTransfer[] $availablePermissions
     * @param \ArrayObject|\Generated\Shared\Transfer\PermissionTransfer[] $companyRolePermissions
     *
     * @return \Generated\Shared\Transfer\PermissionTransfer[] Keys are permission keys
     */
    protected function getAvailableCompanyRolePermissionKeyIndexes(
        ArrayObject $availablePermissions,
        ArrayObject $companyRolePermissions
    ): array {
        $availableCompanyRolePermissions = [];

        foreach ($companyRolePermissions as $companyRolePermission) {
            $availableCompanyRolePermission = $this->findAvailableCompanyRolePermission(
                $companyRolePermission,
                $availablePermissions
            );

            if ($availableCompanyRolePermission) {
                $availableCompanyRolePermissions[$companyRolePermission->getKey()] = $availableCompanyRolePermission;
            }
        }

        return $availableCompanyRolePermissions;
    }

    /**
     * @param \Generated\Shared\Transfer\PermissionTransfer $companyRolePermission
     * @param \ArrayObject|\Generated\Shared\Transfer\PermissionTransfer[] $availablePermissions
     *
     * @return \Generated\Shared\Transfer\PermissionTransfer|null
     */
    protected function findAvailableCompanyRolePermission(
        PermissionTransfer $companyRolePermission,
        ArrayObject $availablePermissions
    ): ?PermissionTransfer {
        foreach ($availablePermissions as $availablePermission) {
            if ($availablePermission->getKey() === $companyRolePermission->getKey()) {
                return $availablePermission;
            }
        }

        return null;
    }
}
