<?php

namespace Stevebauman\Maintenance\Http\Apis\v1\WorkOrder;

use Stevebauman\Maintenance\Models\Priority;
use Stevebauman\Maintenance\Repositories\WorkOrder\PriorityRepository;
use Stevebauman\Maintenance\Http\Apis\v1\Controller as BaseController;

class PriorityController extends BaseController
{
    /**
     * @var PriorityRepository
     */
    protected $priority;

    /**
     * @param PriorityRepository $priority
     */
    public function __construct(PriorityRepository $priority)
    {
        $this->priority = $priority;
    }

    /**
     * Returns a new work order status grid.
     *
     * @return \Cartalyst\DataGrid\DataGrid
     */
    public function grid()
    {
        $columns = [
            'id',
            'created_at',
            'user_id',
            'name',
            'color',
        ];

        $settings = [
            'sort' => 'created_at',
            'direction' => 'desc',
            'threshold' => 10,
            'throttle' => 10,
        ];

        $transformer = function(Priority $priority)
        {
            return [
                'id' => $priority->id,
                'created_at' => $priority->created_at,
                'created_by' => ($priority->user ? $priority->user->full_name : 'None'),
                'name' => $priority->name,
                'color' => $priority->color,
                'view_url' => ''
            ];
        };

        return $this->priority->grid($columns, $settings, $transformer);
    }
}