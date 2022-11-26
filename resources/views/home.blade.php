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
                <div class="alert alert-danger d-none" id="showErr"></div>
                <div class="card" id="chat2">
                    <div class="card-header d-flex justify-content-center align-items-center p-3">
                        <h5 class="mb-0">Chat</h5>
                    </div>
                    <div class="card-body overflow-auto" data-mdb-perfect-scrollbar="true"
                         style="position: relative; height: 400px" id="card-body">
                        @if($messages->count() != 0)
                            @foreach($messages as $message)
                                @if($message->user_id == auth()->user()->id)
                                    <div class="d-flex flex-row justify-content-end mb-4 pt-1">
                                        <div class="text-white">
                                            <p class="small p-2 me-3 mb-1 rounded-3 bg-primary"
                                               style="max-width: 250px">{{ $message->message }}</p>
                                            <p class="small me-3 mb-3 rounded-3 text-muted d-flex justify-content-end">{{ \Carbon\Carbon::parse($message->created_at)->format('h:i') }}</p>
                                        </div>
                                        <p class="small"><small>{{ $message->user->name }}</small></p>
                                    </div>
                                @else
                                    <div class="d-flex flex-row justify-content-start">
                                        <p class="small"><small>{{ $message->user->name }}</small></p>
                                        <div class="text-light">
                                            <p class="small p-2 ms-3 mb-1 rounded-3 bg-dark"
                                               style="max-width: 250px">{{ $message->message }}</p>
                                            <p class="small ms-3 mb-3 rounded-3 text-muted">{{ \Carbon\Carbon::parse($message->created_at)->format('h:i') }}</p>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @else
                            <div class="w-100 h-100 d-flex justify-content-center align-items-center" id="noMessage">
                                <div class="alert alert-primary text-center">
                                    <h6 class="alert-heading">There are no messages yet...</h6>
                                    <small>Send first message</small>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="card-footer text-muted d-flex justify-content-start align-items-center p-3">
                        <input type="text" class="form-control" id="Send"
                               placeholder="Type message and press enter" autofocus>
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
        const card = $('#card-body')
        const noMessage = $('#noMessage')

        card.animate({
            scrollTop: card.prop("scrollHeight")
        }, 500);
        window.Echo.channel('chat')
            .listen('MessageSent', (data) => {
                card.append({{ auth()->user()->id }} === data.user_id ? userMessage(data.message, data.message_create_at, data.user_name) : othersMessage(data.message, data.message_create_at, data.user_name));
                card.animate({
                    scrollTop: card.prop("scrollHeight")
                }, 500);

                if (!noMessage.hasClass('d-none'))
                    noMessage.addClass('d-none')
            });

        function userMessage(message, time, userName) {
            return `<div class="d-flex flex-row justify-content-end mb-4 pt-1">
                        <div class="text-white">
                            <p class="small p-2 me-3 mb-1 rounded-3 bg-primary" style="max-width: 250px">${message}</p>
                            <p class="small me-3 mb-3 rounded-3 text-muted d-flex justify-content-end">${time}</p>
                        </div>
                        <p class="small"><small>${userName}</small></p>
                    </div>`
        }

        function othersMessage(message, time, userName) {
            return `<div class="d-flex flex-row justify-content-start">
                        <p class="small"><small>${userName}</small></p>
                        <div class="text-light">
                            <p class="small p-2 ms-3 mb-1 rounded-3 bg-dark" style="max-width: 250px">${message}</p>
                            <p class="small ms-3 mb-3 rounded-3 text-muted">${time}</p>
                        </div>
                    </div>`
        }
    </script>
@endsection
