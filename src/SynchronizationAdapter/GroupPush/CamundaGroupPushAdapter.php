<?php declare(strict_types=1);

namespace LinkORB\OrgSync\SynchronizationAdapter\GroupPush;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use LinkORB\OrgSync\DTO\Group;
use LinkORB\OrgSync\DTO\User;
use LinkORB\OrgSync\Exception\SyncHttpException;
use LinkORB\OrgSync\Services\Camunda\ResponseChecker;
use Throwable;

final class CamundaGroupPushAdapter implements GroupPushInterface
{
    public const CAMUNDA_GROUP_TYPE = 'camunda_group_type';

    /** @var Client */
    private $httpClient;

    /** @var ResponseChecker */
    private $responseChecker;

    public function __construct(Client $httpClient, ResponseChecker $responseChecker)
    {
        $this->httpClient = $httpClient;
        $this->responseChecker = $responseChecker;
    }

    public function pushGroup(Group $group): GroupPushInterface
    {
        $method = $this->exists($group) ? 'put' : 'post';

        try {
            $response = $this->httpClient->$method(
                sprintf('group/%s', $method === 'put' ? $group->getName() : 'create'),
                [
                    RequestOptions::JSON => [
                        'id' => $group->getName(),
                        'name' => $group->getDisplayName(),
                        'type' => $group->getProperties()[static::CAMUNDA_GROUP_TYPE] ?? null,
                    ],
                ]
            );
        } catch (Throwable $exception) {
            throw new SyncHttpException($exception);
        }

        $this->responseChecker->assertResponse($response);

        // TODO: remove old members
        foreach ($group->getMembers() as $member) {
            $this->addMember($group->getName(), $member);
        }

        return $this;
    }

    protected function exists(Group $group): bool
    {
        try {
            $response = $this->httpClient->get(sprintf('group/%s', $group->getName()));
        } catch (Throwable $exception) {
            throw new SyncHttpException($exception);
        }

        return $response->getStatusCode() === 200;
    }

    private function addMember(string $groupName, User $member): void
    {
        try {
            $this->httpClient->put(
                sprintf('group/%s/members/%s', $groupName, $member->getUsername())
            );
        } catch (Throwable $exception) {
            throw new SyncHttpException($exception);
        }
    }
}
