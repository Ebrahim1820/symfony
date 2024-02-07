<?php

namespace App\Form\Model;

class UserRegistrationFormModel
{
    /**
     * Summary of email
     * @Assert\NotBlank(message="Please enter an email")
     * @Assert}Enail()
     *
     */
    public $email;
    public $plainPassword;
    public $agreeTerms;

}