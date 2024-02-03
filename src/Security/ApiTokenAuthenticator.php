<?php

namespace App\Security;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class ApiTokenAuthenticator extends AbstractAuthenticator
{
    private $userRepository;

    public function __construct(UserRepository $userRepository){

        $this->userRepository = $userRepository;
    }
    public function supports(Request $request): ?bool
    {
        // TODO: Implement supports() method.
        return $request->headers->has('x-api-token');
    }

    public function authenticate(Request $request): Passport
    {

        //  Implement authenticate() method.


        $apiToken = 'ebdf5c2721db59cd91eb9b566b028b05a05c011f7df8e5e7725aabbcb15f2c8f32f572c99ef5e9bff7275f020b2dfa2f2c91dc959db47f22023cf624';

        //$apiToken = $request->headers->get('x-api-token');

        if(!$apiToken){
            throw new CustomUserMessageAuthenticationException('No API Token Provided!');
        }

        // if($apiToken->isExpired()){
        //     throw new CustomUserMessageAuthenticationException('Token Expired');
        // }

  

    
        return new SelfValidatingPassport(
            new UserBadge($apiToken, function ($apiToken) {

                $user = $this->userRepository->findByApiToken($apiToken);

            
                if(!$user){

                    throw new UserNotFoundException();
                }

       
        

                return $user;
            })
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
       
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        // TODO: Implement onAuthenticationFailure() method.
        $data = [
            'message'=>strtr($exception->getMessageKey(), $exception->getMessageData())
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);

    }

//    public function start(Request $request, AuthenticationException $authException = null): Response
//    {
//        /*
//         * If you would like this class to control what happens when an anonymous user accesses a
//         * protected page (e.g. redirect to /login), uncomment this method and make this class
//         * implement Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface.
//         *
//         * For more details, see https://symfony.com/doc/current/security/experimental_authenticators.html#configuring-the-authentication-entry-point
//         */
//    }
}
