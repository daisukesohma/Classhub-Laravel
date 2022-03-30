<div class="kt-section">
    <div class="kt-section__content">
        <table class="table">
            <thead class="thead">
            <tr>
                <th>Reference Download</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            @if($educator->references[0] || $educator->references[1])
                <tr>
                    <td>
                        <a href="{{ $educator->references[0] ? \App\Helpers\ClassHubHelper::getImagePath(null, $educator->references[0]) : '#' }}"
                           class="btn btn-outline-brand btn-elevate btn-icon" target="_blank"><i
                                class="la la-cloud-download"></i></a>
                    </td>

                    <td>
                        @if($educator->references_approved)
                            <span class="m-badge  m-badge--success m-badge--wide">Approved</span>
                        @else
                            <span class="m-badge  m-badge--info m-badge--wide">--</span>
                        @endif
                    </td>

                </tr>
                <tr>
                    <td>
                        <a href="{{ $educator->references[1] ? \App\Helpers\ClassHubHelper::getImagePath(null, $educator->references[1]) : '#' }}"
                           class="btn btn-outline-brand btn-elevate btn-icon" target="_blank"><i
                                class="la la-cloud-download"></i></a>

                    </td>
                    <td>
                        @if($educator->references_approved)
                            <span class="m-badge  m-badge--success m-badge--wide">Approved</span>
                        @else
                            <span class="m-badge  m-badge--info m-badge--wide">--</span>
                        @endif
                    </td>
                </tr>
            @else
                <tr>
                    <td>No references file uploaded.</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
</div>
<div class="modal-footer">
    @if(!$educator->references_approve && ($educator->references[0] || $educator->references[1]))
        <button type="button" class="btn btn-primary m-btn m-btn--custom m-btn--air accept-references"
                data-route="{{ route('admin.update.educator.references', $educator->user_id) }}">
            Accept
        </button>
    @endif
    <button type="button" class="btn btn-secondary m-btn m-btn--custom m-btn--air" data-dismiss="modal">
        Close
    </button>
</div>
