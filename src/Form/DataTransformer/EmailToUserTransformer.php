<?php

namespace App\Form\DataTransformer;

use App\Repository\UserRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;



class EmailToUserTransformer implements DataTransformerInterface
{
    //

    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository){
        $this->userRepository = $userRepository;
    }


    public function transform($value): mixed
{
    if(null=== $value){
            return '';
    }

       

    if(!$value instanceof User){
            throw new \LogicException('The UserSelectTextType can only be used with User objects');
    }

        return $value->getEmail();
}

    public function reverseTransform($value):mixed
    {
        $user =$this->userRepository->findOneBy([ 'email' => $value ]);

        if(!$user){
            throw new TransformationFailedException(
                sprintf('No user found with email "%s"', $value)
            );
        }
        return $user;
    }
}