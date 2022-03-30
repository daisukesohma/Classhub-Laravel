<div class='modal-header'>
    <h5 class='modal-title' id='exampleModalLabel'>{{ $lesson->name }}</h5>
    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
    </button>
</div>
<div class='modal-body'>
    <div class='form-group m-form__group'>
        <label style='color: #58595B;'>
            <strong>Host:</strong>
        </label>
        <p class='form-control-static'>
            {{ $lesson->user->name }}
        </p>
    </div>
    <div class='form-group m-form__group'>
        <label style='color: #58595B;'>
            <strong>Date Added:</strong>
        </label>
        <p class='form-control-static'>
            {{  \Carbon\Carbon::parse($lesson->created_at)->format('d/m/Y') }}
        </p>
    </div>
    <div class='form-group m-form__group'>
        <label style='color: #58595B;'>
            <strong>Price:</strong>
        </label>
        <p class='form-control-static'>
            {{ $lesson->display_price." ".$lesson->lesson_type_price_text }}
        </p>
    </div>
    <div class='form-group m-form__group' id='category'>
        <label style='color: #58595B;'>
            <strong>Category:</strong>
        </label>
        {!! Form::select('category_id', \App\Helpers\ClassHubHelper::categoryDropdown(), $lesson->category_id,
            ['placeholder' => 'Choose Category', 'class' => 'form-control m-input', 'required' => 'required']) !!}
    </div>
    <div class='form-group m-form__group'>
        <label style='color: #58595B;'>
            <strong>Description:</strong>
            <p class='form-control-static'>{{ $lesson->description }}</p>
        </label>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal">
        Close
    </button>
    <button type="button" class="btn btn-success update-lesson"
            data-route="{{ route('lesson.update.category', $lesson->id) }}">
        Save Changes
    </button>
</div>
