<?php

namespace Stevebauman\Maintenance\Validators;

class PublicWorkOrderValidator extends BaseValidator
{
    protected $rules = [
        'subject'     => 'required|min:5|max:250',
        'description' => 'min:10|max:2000',
    ];
}
