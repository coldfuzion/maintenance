<a href="{{ route('maintenance.inventory.destroy', array($item->id)) }}"
   data-method="DELETE"
   data-title="Are you sure?"
   data-message="Are you sure you want to delete this item? This will be archived. No data will be lost, however you will not be able to restore it without manager/supervisor
    permission."
   class="btn btn-app no-print"
        >
    <i class="fa fa-trash-o"></i> Delete Item
</a>