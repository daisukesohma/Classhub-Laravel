@extends('frontend.layouts.master')

@section('title')
    Classhub | Twilio
@endsection


@section('content')

    <div class="container terms privacy">

        <div class="box shadow-v4">

            <div class="jumbotron">
                <div class="container-fluid">
                    <h1 class="display-3">Welcome to Twilio Video Quickstart</h1>
                    <p class="lead">For more examples click <a href="/examples">here</a></p>
                </div>
            </div>
            <div id="remote-media"></div>
            <div id="controls" class="container-fluid">
                <div id="preview">
                    <p class="instructions">Hello Beautiful</p>
                    <div>
                        <div id="local-media"></div>
                        <button id="button-preview" class="btn btn-primary btn-block">
                            <image
                                id="button-preview-image"
                                src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+Cjxzdmcgd2lkdGg9IjE3cHgiIGhlaWdodD0iMTJweCIgdmlld0JveD0iMCAwIDE3IDEyIiB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHhtbG5zOnNrZXRjaD0iaHR0cDovL3d3dy5ib2hlbWlhbmNvZGluZy5jb20vc2tldGNoL25zIj4KICAgIDwhLS0gR2VuZXJhdG9yOiBTa2V0Y2ggMy4zLjEgKDEyMDAyKSAtIGh0dHA6Ly93d3cuYm9oZW1pYW5jb2RpbmcuY29tL3NrZXRjaCAtLT4KICAgIDx0aXRsZT5GaWxsIDM0PC90aXRsZT4KICAgIDxkZXNjPkNyZWF0ZWQgd2l0aCBTa2V0Y2guPC9kZXNjPgogICAgPGRlZnM+PC9kZWZzPgogICAgPGcgaWQ9IlBhZ2UtMSIgc3Ryb2tlPSJub25lIiBzdHJva2Utd2lkdGg9IjEiIGZpbGw9Im5vbmUiIGZpbGwtcnVsZT0iZXZlbm9kZCIgc2tldGNoOnR5cGU9Ik1TUGFnZSI+CiAgICAgICAgPGcgaWQ9ImN1bW1hY2siIHNrZXRjaDp0eXBlPSJNU0xheWVyR3JvdXAiIHRyYW5zZm9ybT0idHJhbnNsYXRlKC0xMjUuMDAwMDAwLCAtMTkwOS4wMDAwMDApIiBmaWxsPSIjMEEwQjA5Ij4KICAgICAgICAgICAgPHBhdGggZD0iTTEzNi40NzEsMTkxOS44NyBMMTM2LjQ3MSwxOTE5LjYyIEwxMjUuNzY3LDE5MTkuNjIgTDEyNS43NjcsMTkxMC4wOCBMMTM2LjIyMSwxOTEwLjA4IEwxMzYuMjIxLDE5MTQuMTUgTDE0MC43ODUsMTkxMS4yNyBMMTQwLjc4NSwxOTE4LjQyIEwxMzYuMjIxLDE5MTUuNTUgTDEzNi4yMjEsMTkxOS44NyBMMTM2LjQ3MSwxOTE5Ljg3IEwxMzYuNDcxLDE5MTkuNjIgTDEzNi40NzEsMTkxOS44NyBMMTM2LjcyMSwxOTE5Ljg3IEwxMzYuNzIxLDE5MTYuNDUgTDE0MS4yODUsMTkxOS4zMyBMMTQxLjI4NSwxOTEwLjM3IEwxMzYuNzIxLDE5MTMuMjQgTDEzNi43MjEsMTkwOS41OCBMMTI1LjI2NywxOTA5LjU4IEwxMjUuMjY3LDE5MjAuMTIgTDEzNi43MjEsMTkyMC4xMiBMMTM2LjcyMSwxOTE5Ljg3IEwxMzYuNDcxLDE5MTkuODciIGlkPSJGaWxsLTM0IiBza2V0Y2g6dHlwZT0iTVNTaGFwZUdyb3VwIj48L3BhdGg+CiAgICAgICAgPC9nPgogICAgPC9nPgo8L3N2Zz4="
                            ></image>
                            Preview My Camera
                        </button>
                    </div>
                </div>
                <div id="room-controls">
                    <p class="instructions">Room Name</p>
                    <input id="room-name" type="text" placeholder="Enter a room name" />
                    <button
                        id="button-join"
                        type="submit"
                        class="btn btn-primary btn-block"
                    >
                        Join Room
                    </button>
                    <button
                        id="button-leave"
                        type="submit"
                        class="btn btn-primary btn-block"
                    >
                        Leave Room
                    </button>
                </div>
                <div id="log"></div>
            </div>

        </div>

    </div>

@endsection

@section('page_scripts')

    <script type="text/javascript">
        var token =  '{{ $token }}';

    </script>
    <script src="{{ asset('twilio/index.js') }}"></script>



@endsection
