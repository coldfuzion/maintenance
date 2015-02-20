<?php

namespace Stevebauman\Maintenance\Controllers\WorkOrder;

use Stevebauman\Maintenance\Validators\WorkOrderValidator;
use Stevebauman\Maintenance\Services\WorkOrder\WorkOrderService;
use Stevebauman\Maintenance\Controllers\BaseController;

/**
 * Class WorkOrderController
 * @package Stevebauman\Maintenance\Controllers\WorkOrder
 */
class WorkOrderController extends BaseController
{

    /**
     * @var WorkOrderService
     */
    protected $workOrder;

    /**
     * @var WorkOrderValidator
     */
    protected $workOrderValidator;

    /**
     * @param WorkOrderService $workOrder
     * @param WorkOrderValidator $workOrderValidator
     */
    public function __construct(WorkOrderService $workOrder, WorkOrderValidator $workOrderValidator)
    {
        $this->workOrder = $workOrder;
        $this->workOrderValidator = $workOrderValidator;
    }

    /**
     * Displays all work orders (paginated with search functionality)
     *
     * @return mixed
     */
    public function index()
    {
        $workOrders = $this->workOrder->setInput($this->inputAll())->getByPageWithFilter();

        return view('maintenance::work-orders.index', array(
            'title' => _t('Work Orders'),
            'workOrders' => $workOrders
        ));
    }

    /**
     * Displays the form to create a work order
     *
     * @return mixed
     */
    public function create()
    {
        return view('maintenance::work-orders.create', array(
            'title' => _t('Create a Work Order'),
        ));
    }

    /**
     * Stores a new work order
     *
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function store()
    {
        if ($this->workOrderValidator->passes()) {
            $workOrder = $this->workOrder->setInput($this->inputAll())->create();

            $this->redirect = route('maintenance.work-orders.index');
            $this->message = sprintf('Successfully created work order. %s', link_to_route('maintenance.work-orders.show', 'Show', array($workOrder->id)));
            $this->messageType = 'success';
        } else {
            $this->redirect = route('maintenance.work-orders.create');
            $this->errors = $this->workOrderValidator->getErrors();
        }

        return $this->response();
    }

    /**
     * Displays the specified work order
     *
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $workOrder = $this->workOrder->find($id);

        return view('maintenance::work-orders.show', array(
            'title' => 'Viewing Work Order: ' . $workOrder->subject,
            'workOrder' => $workOrder
        ));
    }

    /**
     * Displays the edit form for the specified work order
     *
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $workOrder = $this->workOrder->find($id);

        return view('maintenance::work-orders.edit', array(
            'title' => 'Editing Work Order: ' . $workOrder->subject,
            'workOrder' => $workOrder,
        ));

    }

    /**
     * Update the specified work order
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function update($id)
    {
        if ($this->workOrderValidator->passes()) {

            $record = $this->workOrder->setInput($this->inputAll())->update($id);

            $this->redirect = route('maintenance.work-orders.show', array($id));
            $this->message = sprintf('Successfully edited work order. %s', link_to_route('maintenance.work-orders.show', 'Show', array($record->id)));
            $this->messageType = 'success';


        } else {
            $this->redirect = route('maintenance.work-orders.edit', array($id));
            $this->errors = $this->workOrderValidator->getErrors();
        }

        return $this->response();
    }

    /**
     * Removes the work order
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function destroy($id)
    {
        if ($this->workOrder->destroy($id)) {
            $this->message = 'Successfully deleted work order';
            $this->messageType = 'success';
            $this->redirect = route('maintenance.work-orders.index');
        } else {
            $this->message = 'There was an error deleting the work order. Please try again';
            $this->messageType = 'danger';
            $this->redirect = route('maintenance.work-orders.show', array($id));
        }

        return $this->response();
    }

}
