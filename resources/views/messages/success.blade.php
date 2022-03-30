@if(session()->has('success'))
    <div class="alert alert-success ">
        @foreach(session()->get('success') as $message)
            <span style="display: block;">{{ $message }}</span>
        @endforeach
    </div>
@endif


