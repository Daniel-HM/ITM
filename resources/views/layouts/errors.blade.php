@isset($notFound)
    <div class="col">
        <div class="alert alert-danger" role="alert">
            {{ $notFound }}
        </div>
    </div>
@endif