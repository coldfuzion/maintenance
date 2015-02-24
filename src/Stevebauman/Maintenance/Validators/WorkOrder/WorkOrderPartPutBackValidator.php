<?php

namespace Stevebauman\Maintenance\Validators;

/**
 * Class WorkOrderPartPutBackValidator
 * @package Stevebauman\Maintenance\Validators
 */
class WorkOrderPartPutBackValidator extends BaseValidator
{
    
    protected $rules = array(
        'quantity' => 'required|positive|greater_than:0'
    );
    
}