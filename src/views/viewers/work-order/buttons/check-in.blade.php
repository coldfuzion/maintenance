@if($workOrder->userCheckedIn())

    <a href="{{ route('maintenance.work-orders.session.end', array($workOrder->id, $workOrder->getCurrentSession()->id)) }}"
       data-method="post"
       data-title="Check out?"
       data-message="Are you sure you want to check <b>out</b> this work order?"
       class="btn btn-app"
            >
        <i class="fa fa-clock-o"></i> Check Out
    </a>

@else

    <a href="{{ route('maintenance.work-orders.session.start', array($workOrder->id)) }}"
       data-method="post"
       data-title="Check in?"
       data-message="Are you sure you want to check <b>into</b> this work order?"
       class="btn btn-app"
            >
        <i class="fa fa-clock-o"></i> Check In
    </a>

@endif