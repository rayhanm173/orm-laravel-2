
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Sender</th>
                            <th>Receiver</th>
                            <th>Message</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($filteredChats as $chat)
                        <tr>
                            <td>{{ $chat->sender->name }}</td>
                            <td>{{ $chat->receiver->name }}</td>
                            <td>{{ $chat->message }}</td>
                            <td>{{ $chat->created_at }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

