@if (session('message'))
    <div class="my-0 alert alert-{{ session('message-type') }}">
        {{ session('message') }}
    </div>
@endif