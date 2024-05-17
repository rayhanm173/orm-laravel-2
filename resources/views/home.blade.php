@extends('layouts.app')

@section('content')
<style>
    .message {
    margin-bottom: 10px;
    padding: 5px 10px;
    border-radius: 5px;
}

.sender {
    background-color: #DCF8C6;
    text-align: left;
}

.receiver {
    background-color: #F0F0F0;
    text-align: right;
}

</style>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <!-- List of Users -->
                <div class="card">
                    <div class="card-header">{{ __('Users') }}</div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach ($users as $userItem)
                                <li
                                    class="list-group-item

                            @if ($user && $user->id == $userItem->id) bg-warning @endif



                            ">
                                    <a href="{{ route('chats.show', ['user' => $userItem->id]) }}">{{ $userItem->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

            </div>
            <div class="col-md-8">
                <!-- Chat Interface -->
                <div class="card">
                    <div class="card-header">{{ __('Chat') }}</div>
                    <div class="card-body">
                        @if($chats)
                            <!-- Chat messages will be displayed here -->
                            <div id="chat-messages">
                                @foreach($chats as $chat)
                                    <div class="message {{ $chat->sender_id === auth()->id() ? 'sender' : 'receiver' }}">
                                        <strong>{{ $chat->sender->name }}:</strong> {{ $chat->message }}
                                    </div>
                                @endforeach
                            </div>
                            <!-- Chat input form -->
                            <form action="{{ route('chats.store') }}" method="post">
                                @csrf
                                <input name="receiver_id" type="hidden" value="{{$user->id}}"></input>
                                <div class="form-group">
                                    <textarea name="message" class="form-control" placeholder="Type your message"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Send</button>
                            </form>
                        @else
                            <p>Select a user for chat.</p>
                        @endif
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection
