<div class="modal fade" id="roleAccess" tabindex="-1" role="dialog" aria-labelledby="outletTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered w-100" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="outletTitle"><b>Edit outlet</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="far fa-times-square"></i>
                </button>
            </div>
            <div class="modal-body">
                <ul class="list-disc">
                    @foreach ($roles as $role)
                        <li><a href="{{ route('menu.access', ['role' => $role->id]) }}" target="_blank">{{ $role->user_role }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
