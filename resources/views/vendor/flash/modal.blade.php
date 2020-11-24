
<div class="text-center">
    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" style="margin-left: auto;" data-autohide="false">
        <div class="toast-header">
            <svg class="rounded mr-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice"
                 focusable="false" role="img">
                <rect class="toast-{{$title}}"     fill="rgb(99, 138, 182)" width="100%" height="100%" /></svg>
            <strong class="mr-auto">{{$title}}</strong>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body">
            {!! $body !!}
        </div>
    </div>
</div>