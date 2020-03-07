<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

use Doctrine\ORM\EntityManagerInterface;

use App\Repository\ApiTokenRepository;
use App\Repository\UserRepository;
use App\Entity\ApiToken;

// https://symfonycasts.com/screencast/symfony-security/api-token-authenticator
// https://symfonycasts.com/screencast/symfony-security/api-token-authenticator#codeblock-905aa7a8f6
// https://symfony.com/doc/4.3/security/guard_authentication.html
// https://symfony.com/doc/4.3/security/guard_authentication.html#guard-auth-methods
// https://symfony.com/doc/4.3/security.html#c-encoding-passwords





// jos käytetäänkin Auth0.com:ia:

    // https://github.com/Wolfmatrix/symfony4-auth0-authorization
// https://wolfmatrix.com/all/how-to-authorize-auth0-user-in-symfony-4/
https://auth0.com/blog/authenticating-your-first-react-app/#Configuring-Our-Auth0-Account

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{
    /**
     * @var ApiTokenRepository
     */
    protected $apiTokens;

    /**
     * @var UserRepository
     */
    protected $users;

    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @var CsrfTokenManagerInterface
     */
    protected $csrfTokenManager;
    /**
     * @var UserPasswordEncoderInterface
     */
    protected $passwordEncoder;

    public function __construct(
        ApiTokenRepository $apiTokens,
        UserRepository $users,
        EntityManagerInterface $em,
        RouterInterface $router,
        CsrfTokenManagerInterface $csrfTokenManager,
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        $this->apiTokens = $apiTokens;
        $this->users = $users;
        $this->em = $em;
        $this->router = $router;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function supports(Request $request)
    {
        // do your work when we're POSTing to the login page
        return $request->attributes->get('_route') === 'api_login'
            && $request->isMethod('POST');
    }


    public function getCredentials(Request $request)
    {
        $credentials = [
            'username' => $request->request->get('username'),
            'password' => $request->request->get('password'),
        ];

        return $credentials;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        return $this->users->findOneBy(['username' => $credentials['username']]);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        // this actually works! :)
        // use jme / ag... as password in client app
        // use an incorrect username/password combination to see the difference
        return $this->passwordEncoder->isPasswordValid($user, $credentials['password']);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // create new apiToken (save to db)
        // return apiToken in the response
        // the apiToken will be used for authenticating the user's next requests
        $apiToken = new ApiToken($token->getUser());

        $this->em->persist($apiToken);
        $this->em->flush();

        // store this token in the client (session, or memory, NOT localstorage)
        return new JsonResponse(
            [
                'token' => $apiToken->getToken(),
            ],
            200,
            [
                'Access-Control-Allow-Origin' => '*',
                'Access-Control-Allow-Credentials' => 'true'
            ]

        );

    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $data = [
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())

            // or to translate this message
            // $this->translator->trans($exception->getMessageKey(), $exception->getMessageData())
        ];

        return new JsonResponse($data, Response::HTTP_FORBIDDEN,             [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Credentials' => true
        ]);
    }

    protected function getLoginUrl()
    {
        return $this->router->generate('api_login');
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        $url = $this->getLoginUrl();

        return new RedirectResponse($url, 302,[
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Credentials' => true
        ]);
    }
}
