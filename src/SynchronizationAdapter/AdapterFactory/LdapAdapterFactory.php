<?php declare(strict_types=1);

namespace LinkORB\OrgSync\SynchronizationAdapter\AdapterFactory;

use LinkORB\OrgSync\DTO\Target;
use LinkORB\OrgSync\SynchronizationAdapter\GroupPush\GroupPushInterface;
use LinkORB\OrgSync\SynchronizationAdapter\OrganizationPull\OrganizationPullInterface;
use LinkORB\OrgSync\SynchronizationAdapter\OrganizationPush\OrganizationPushInterface;
use LinkORB\OrgSync\SynchronizationAdapter\SetPassword\SetPasswordInterface;
use LinkORB\OrgSync\SynchronizationAdapter\UserPush\UserPushInterface;

class LdapAdapterFactory implements AdapterFactoryInterface
{
    public const ADAPTER_KEY = 'ldap';

    public function createOrganizationPullAdapter(): OrganizationPullInterface
    {
        // TODO: Implement createOrganizationPullAdapter() method.
    }

    public function createGroupPushAdapter(): GroupPushInterface
    {
        // TODO: Implement createGroupPushAdapter() method.
    }

    public function createUserPushAdapter(): UserPushInterface
    {
        // TODO: Implement createUserPushAdapter() method.
    }

    public function createSetPasswordAdapter(): SetPasswordInterface
    {
        // TODO: Implement createSetPasswordAdapter() method.
    }

    public function createOrganizationPushAdapter(): OrganizationPushInterface
    {
        // TODO: Implement createOrganizationPushAdapter() method.
    }

    public function setTarget(Target $target): AdapterFactoryInterface
    {
        // TODO: Implement setTarget() method.
    }
}
