<?php

namespace Stevebauman\Maintenance\Validators;

/**
 * Class PasswordValidator
 * @package Stevebauman\Maintenance\Validators
 */
class PasswordValidator extends BaseValidator
{
    protected $rules = array(
        'password' => 'required|confirmed|min:8',
        'password_confirmation' => 'required|min:8',
    );
}