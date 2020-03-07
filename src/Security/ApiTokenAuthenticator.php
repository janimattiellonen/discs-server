<?php

namespace App\Security;

use App\Repository\ApiTokenRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class ApiTokenAuthenticator extends AbstractGuardAuthenticator
{
    /**
     * @var ApiTokenRepository
     */
    private $apiTokenRepo;

    public function __construct(ApiTokenRepository $apiTokens)
    {
        $this->apiTokenRepo = $apiTokens;
    }

    public function supports(Request $request)
    {
        $value = $request->headers->get('Cookie');

        $posA = strpos($value, 'Authorization=Bearer');
        $posB = strpos($value, ';');

        //die("it is: " . substr($value, strlen('Authorization=Bearer%3A%'), $posB));

//echo "it is: " . ($request->headers->has('Cookie')
//    && 0 === strpos($request->headers->get('Cookie'), 'Authorization=Bearer') ). "<br>";


        //die($value);
        // look for header "Authorization: Bearer <token>"
        return $request->headers->has('Cookie')
            && 0 === strpos($request->headers->get('Cookie'), 'Authorization=Bearer');
    }

    public function getCredentials(Request $request)
    {
        $value = $request->headers->get('Cookie');
        die($value);

        //die('value2: ' . $value);
        //echo strlen('2042413f152e6471e9e69436b8ab8c50a1edd68338cedc549ab00d3854c3a95bb24ad23d767fa0bc0c9b166f5ffcb87d98a49badecf9558c8ffc03628d');die;
        //echo $posB;

        //die('sss');
        //$authorizationHeader = $request->headers->get('Authorization');

        $value = substr($value, strlen('Authorization=Bearer%3A%20'));
        $posB = strpos($value, ';');
//die('foo2: ' . substr($value, 0, $posB));
        // skip beyond "Bearer "
        return substr($value, 0, $posB);
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        die($credentials);
        $token = $this->apiTokenRepo->findOneBy([
            'token' => $credentials
        ]);

        if (!$token) {
            throw new CustomUserMessageAuthenticationException(
                'Invalid API Token'
            );
        }

        if ($token->isExpired()) {
            throw new CustomUserMessageAuthenticationException(
                'Token expired'
            );
        }

        return $token->getUser();
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new JsonResponse([
            'message' => $exception->getMessageKey()
        ], 401);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // allow the authentication to continue
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        throw new \Exception('Not used: entry_point from other authentication is used');
    }

    public function supportsRememberMe()
    {
        return false;
    }
}
