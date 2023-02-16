<?php
namespace App\Cognito\Guard;
use App\Cognito\CognitoClient;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Auth\SessionGuard;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Session\Session;

class CognitoGuard extends SessionGuard implements StatefulGuard
{
    /**
     * @var CognitoClient
     */
    protected $client;

    /**
     * CognitoGuard constructor.
     * @param string $name
     * @param CognitoClient $client
     * @param UserProvider $provider
     * @param Session $session
     * @param null|Request $request
     */
    public function __construct(
        string        $name,
        CognitoClient $client,
        UserProvider  $provider,
        Session       $session,
        ?Request      $request = null
    )
    {
        $this->client = $client;
        parent::__construct($name, $provider, $session, $request);
    }

    /**
     * Attempt to authenticate a user using the given credentials.
     *
     * @param array $credentials
     * @param bool $remember
     * @return bool
     * @throws
     */
    public function attempt(array $credentials = [], $remember = false)
    {
        $this->fireAttemptEvent($credentials, $remember);

        $this->lastAttempted = $user = $this->provider->retrieveByCredentials($credentials);

        if ($this->hasValidCredentials($user, $credentials)) {
            $this->login($user, $remember);
            return true;
        }

        $this->fireFailedEvent($user, $credentials);

        return false;
    }

    /**
     * @param mixed $user
     * @param array $credentials
     * @return bool
     * @throws InvalidUserModelException
     */
    protected function hasValidCredentials($user, $credentials)
    {
        /** @var Result $response */
        $result = $this->client->authenticate($credentials['email'], $credentials['password']);

        if ($result && $user instanceof Authenticatable) {
            return true;
        }

        return false;
    }
}
