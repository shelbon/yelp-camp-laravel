<?php

namespace App\Cognito;

use Aws\CognitoIdentityProvider\CognitoIdentityProviderClient;
use Aws\CognitoIdentityProvider\Exception\CognitoIdentityProviderException;
use Aws\Result;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class CognitoClient
{
    const NEW_PASSWORD_CHALLENGE = 'NEW_PASSWORD_REQUIRED';
    const FORCE_PASSWORD_STATUS = 'FORCE_CHANGE_PASSWORD';
    const RESET_REQUIRED = 'PasswordResetRequiredException';
    const USER_NOT_FOUND = 'UserNotFoundException';
    const USERNAME_EXISTS = 'UsernameExistsException';
    const INVALID_PASSWORD = 'InvalidPasswordException';
    const CODE_MISMATCH = 'CodeMismatchException';
    const EXPIRED_CODE = 'ExpiredCodeException';
    const NOT_AUTHORIZED_EXCEPTION = "NotAuthorizedException";
    const USER_NOT_CONFIRMED_EXCEPTION = "UserNotConfirmedException";
    const CODE_DELIVERY_FAILURE_EXCEPTION = "CodeDeliveryFailureException";
    protected CognitoIdentityProviderClient $client;


    protected string $clientId;


    protected string $clientSecret;

    protected string $poolId;


    public function __construct(
        CognitoIdentityProviderClient $client,
        string                        $clientId,
        string                        $clientSecret,
        string                        $poolId
    )
    {
        $this->client = $client;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->poolId = $poolId;
    }

    /**
     * Checks if credentials of a user are valid
     *
     * @see http://docs.aws.amazon.com/cognito-user-identity-pools/latest/APIReference/API_AdminInitiateAuth.html
     * @param string $email
     * @param string $password
     * @return Result|bool
     */
    public function authenticate(string $email, string $password): Result|bool
    {
        $response = null;
        try {
            $secret = env("AWS_COGNITO_CLIENT_SECRET");
            $response = $this->client->adminInitiateAuth([
                'AuthFlow' => 'ADMIN_NO_SRP_AUTH',
                'AuthParameters' => [
                    'USERNAME' => $email,
                    'PASSWORD' => $password,
                    'SECRET_HASH' => $this->cognitoSecretHash($email)
                ],
                'ClientId' => $this->clientId,
                'UserPoolId' => $this->poolId
            ]);
        } catch (CognitoIdentityProviderException $exception) {
            if ($exception->getAwsErrorCode() === self::RESET_REQUIRED ||
                $exception->getAwsErrorCode() === self::USER_NOT_FOUND) {
                return false;
            }
            if ($exception->getAwsErrorCode() === self::NOT_AUTHORIZED_EXCEPTION) {
                throw   ValidationException::withMessages([
                    "email" => trans('auth.failed'),
                ]);
            }
            if ($exception->getAwsErrorCode() === self::USER_NOT_CONFIRMED_EXCEPTION) {
                throw   ValidationException::withMessages([
                    self::USER_NOT_CONFIRMED_EXCEPTION => trans('auth.account_not_confirmed'),
                ]);
            }

        }

        return $response;
    }

    /**
     * Creates the Cognito secret hash
     * @param string $username
     * @return string
     */
    protected function cognitoSecretHash(string $username): string
    {
        return $this->hash($username . $this->clientId);
    }

    /**
     * Creates a HMAC from a string
     *
     * @param string $message
     * @return string
     */
    protected function hash(string $message): string
    {
        $hash = hash_hmac(
            'sha256',
            $message,
            $this->clientSecret,
            true
        );

        return base64_encode($hash);
    }

    # HELPER FUNCTIONS

    /**
     * Registers a user in the given user pool
     *
     * @param $email
     * @param $password
     * @param array $attributes
     * @return bool
     */
    public function register($email, $password, array $attributes = []): bool
    {
        $attributes['email'] = $email;

        try {
            $response = $this->client->signUp([
                'ClientId' => $this->clientId,
                'Password' => $password,
                'SecretHash' => $this->cognitoSecretHash($email),
                'Attributes' => $this->formatAttributes($attributes),
                'Username' => $email
            ]);
        } catch (CognitoIdentityProviderException $e) {
            if ($e->getAwsErrorCode() === self::USERNAME_EXISTS) {
                return false;
            }
            if ($e->getAwsErrorCode() === self::CODE_DELIVERY_FAILURE_EXCEPTION) {
                throw   ValidationException::withMessages([
                    self::CODE_DELIVERY_FAILURE_EXCEPTION => trans('auth.account_send_verification_code_failure'),
                ]);
            }
        }

        $this->setUserAttributes($email, ['email_verified' => 'true']);
        return isset($response) && (bool)$response['UserConfirmed'];
    }

    /**
     * Format attributes in Name/Value array
     *
     * @param array $attributes
     * @return array
     */
    protected function formatAttributes(array $attributes): array
    {
        $userAttributes = [];

        foreach ($attributes as $key => $value) {
            $userAttributes[] = [
                'Name' => $key,
                'Value' => $value,
            ];
        }

        return $userAttributes;
    }

    /**
     * Set a users attributes.
     * http://docs.aws.amazon.com/cognito-user-identity-pools/latest/APIReference/API_AdminUpdateUserAttributes.html
     *
     * @param string $username
     * @param array $attributes
     * @return bool
     */
    public function setUserAttributes(string $username, array $attributes): bool
    {
        $this->client->AdminUpdateUserAttributes([
            'Username' => $username,
            'UserPoolId' => $this->poolId,
            'UserAttributes' => $this->formatAttributes($attributes),
        ]);

        return true;
    }

    /**
     * Send a password reset code to a user.
     * @see http://docs.aws.amazon.com/cognito-user-identity-pools/latest/APIReference/API_ForgotPassword.html
     *
     * @param string $username
     * @return string
     */
    public function sendResetLink(string $username): string
    {
        try {
            $result = $this->client->forgotPassword([
                'ClientId' => $this->clientId,
                'SecretHash' => $this->cognitoSecretHash($username),
                'Username' => $username,
            ]);
        } catch (CognitoIdentityProviderException $e) {
            if ($e->getAwsErrorCode() === self::USER_NOT_FOUND) {
                return Password::INVALID_USER;
            }

            throw $e;
        }

        return Password::RESET_LINK_SENT;
    }

    /**
     * Get user details.
     * http://docs.aws.amazon.com/cognito-user-identity-pools/latest/APIReference/API_GetUser.html
     *
     * @param string $username
     * @return mixed
     */
    public function getUser(string $username): mixed
    {
        try {
            $user = $this->client->AdminGetUser([
                'Username' => $username,
                'UserPoolId' => $this->poolId,
            ]);
        } catch (CognitoIdentityProviderException $e) {
            return false;
        }

        return $user;
    }

    public function confirmUserSignUp($username, $confirmationCode)
    {
        try {
            $this->client->confirmSignUp([
                'ClientId' => $this->clientId,
                'SecretHash' => $this->cognitoSecretHash($username),
                'Username' => $username,
                'ConfirmationCode' => $confirmationCode,
            ]);
        } catch (CognitoIdentityProviderException $e) {
            if ($e->getAwsErrorCode() === self::USER_NOT_FOUND) {
                return 'validation.invalid_user';
            } //End if

            if ($e->getAwsErrorCode() === self::CODE_MISMATCH || $e->getAwsErrorCode() === self::EXPIRED_CODE) {
                return 'validation.invalid_token';
            } //End if

            if ($e->getAwsErrorCode() === 'NotAuthorizedException' and $e->getAwsErrorMessage() === 'User cannot be confirmed. Current status is CONFIRMED') {
                return 'validation.confirmed';
            } //End if

            if ($e->getAwsErrorCode() === 'LimitExceededException') {
                return 'validation.exceeded';
            } //End if

            throw $e;
        } //Try-catch ends
    }

    public function confirmSignUp($username)
    {
        $this->client->adminConfirmSignUp([
            'UserPoolId' => $this->poolId,
            'Username' => $username,
        ]);
    } //Function ends

    public function resendToken($username)
    {
        try {
            $this->client->resendConfirmationCode([
                'ClientId' => $this->clientId,
                'SecretHash' => $this->cognitoSecretHash($username),
                'Username' => $username
            ]);
        } catch (CognitoIdentityProviderException $e) {

            if ($e->getAwsErrorCode() === self::USER_NOT_FOUND) {
                return 'validation.invalid_user';
            }

            if ($e->getAwsErrorCode() === 'LimitExceededException') {
                return 'validation.exceeded';
            }

            if ($e->getAwsErrorCode() === 'InvalidParameterException') {
                return 'validation.confirmed';
            }

            throw $e;
        }
    }
}
