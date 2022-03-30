@if($errors->count())
    <div class="alert alert-danger alert-dismissible">
        <div class=""><strong>Errors:</strong></div>
        @foreach($errors->all() as $error)
            <span style="display: inline-block;width: 100%;"> {{ $error }} </span>
        @endforeach
    </div>
@endif


