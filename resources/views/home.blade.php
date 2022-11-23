@extends('layouts.app')

@section('css')
    <style>
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            border-radius: 10px;
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.5);
        }
    </style>
@endsection

@section('content')
    <div class="container py-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-6">

                <div class="card" id="chat2">
                    <div class="card-header d-flex justify-content-between align-items-center p-3">
                        <h5 class="mb-0">Chat</h5>
                        <button type="button" class="btn btn-primary btn-sm" data-mdb-ripple-color="dark">Let's Chat
                            App
                        </button>
                    </div>
                    <div class="card-body overflow-auto" data-mdb-perfect-scrollbar="true"
                         style="position: relative; height: 400px" id="card-body">

                        @foreach($messages as $message)
                            @if($message->user_id == auth()->user()->id)
                                <div class="d-flex flex-row justify-content-end mb-4 pt-1">
                                    <div class="text-white">
                                        <p class="small p-2 me-3 mb-1 rounded-3 bg-primary">{{ $message->message }}</p>
                                        <p class="small me-3 mb-3 rounded-3 text-muted d-flex justify-content-end">{{ \Carbon\Carbon::parse($message->created_at)->format('h:i') }}</p>
                                    </div>
                                    <p class="small"><small>{{ $message->user->name }}</small></p>
                                </div>
                            @else
                                <div class="d-flex flex-row justify-content-start">
                                    <p class="small"><small>{{ $message->user->name }}</small></p>
                                    <div class="text-light">
                                        <p class="small p-2 ms-3 mb-1 rounded-3 bg-dark">{{ $message->message }}</p>
                                        <p class="small ms-3 mb-3 rounded-3 text-muted">{{ \Carbon\Carbon::parse($message->created_at)->format('h:i') }}</p>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="card-footer text-muted d-flex justify-content-start align-items-center p-3">
                        <input type="text" class="form-control" id="Send"
                               placeholder="Type message and press enter">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        window.laravel_echo_port = '{{ env("LARAVEL_ECHO_PORT") }}';
    </script>
    <script src="//{{ Request::getHost() }}:{{env('LARAVEL_ECHO_PORT')}}/socket.io/socket.io.js"></script>
    <script src="{{ url('js/laravel-echo-setup.js') }}" type="text/javascript"></script>
    <script>
        window.Echo.channel('chat')
            .listen('MessageSent', (data) => {
                $("#card-body").append({{ auth()->user()->id }} === data.user_id ? userMessage(data.message, data.message_create_at, data.user_name) : othersMessage(data.message, data.message_create_at, data.user_name));
            });

        function userMessage(message, time, userName) {
            return `<div class="d-flex flex-row justify-content-end mb-4 pt-1">
                        <div class="text-white">
                            <p class="small p-2 me-3 mb-1 rounded-3 bg-primary">${message}</p>
                            <p class="small me-3 mb-3 rounded-3 text-muted d-flex justify-content-end">${time}</p>
                        </div>
                        <p class="small"><small>${userName}</small></p>
                    </div>`
        }

        function othersMessage(message, time, userName) {
            return `<div class="d-flex flex-row justify-content-start">
                        <p class="small"><small>${userName}</small></p>
                        <div class="text-light">
                            <p class="small p-2 ms-3 mb-1 rounded-3 bg-dark">${message}</p>
                            <p class="small ms-3 mb-3 rounded-3 text-muted">${time}</p>
                        </div>
                    </div>`
        }
    </script>
@endsection
