<?php namespace Stevebauman\Maintenance\Validators;

use Stevebauman\Maintenance\Services\WorkOrder\WorkOrderService;
use Illuminate\Support\Facades\Route;

class WorkOrderReportUniqueValidator {
    
    public function __construct(WorkOrderService $workOrder)
    {
        $this->workOrder = $workOrder;
    }
    
    public function validateUniqueReport($attribute, $location_id, $parameters)
    {
        $work_order_id = Route::getCurrentRoute()->getParameter('work_orders');
         
        if($workOrder = $this->workOrder->find($work_order_id)) {
            
            if($workOrder->report){
                /*
                 * Report exists already
                 */
                return false;
            } else{
                /*
                 * No report exists, must be unique
                 */
                return true;
            }
            
        } 
        
        return false;
        
     }
}