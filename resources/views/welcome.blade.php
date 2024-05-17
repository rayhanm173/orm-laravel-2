@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mt-4 mb-3">Filtered Chat History</h1>
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Filter Options</h5>
            <form id="filterForm">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h6 class="card-title">All Keywords</h6>
                                @foreach($keywords as $keyword)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="keywords[]" id="keyword{{$loop->index + 1}}" value="{{ $keyword['name'] }}">
                                    <label class="form-check-label" for="keyword{{$loop->index + 1}}">{{$keyword['name']}} ({{$keyword['count']}} times found)</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h6 class="card-title">All Users</h6>
                                @foreach($users as $user)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="users[]" id="user{{$loop->index + 1}}" value="{{ $user->id }}">
                                    <label class="form-check-label" for="user{{$loop->index + 1}}">{{$user->name}}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h6 class="card-title">Time Range</h6>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="yesterday" id="yesterday">
                                    <label class="form-check-label" for="yesterday">See data from yesterday</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="lastWeek" id="lastWeek">
                                    <label class="form-check-label" for="lastWeek">See data from last week</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="lastMonth" id="lastMonth">
                                    <label class="form-check-label" for="lastMonth">See data from last month</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">Select Date</h6>
                                <div class="form-group">
                                    <label for="startDate">Enter start date:</label>
                                    <input type="date" class="form-control" id="startDate" name="start_date">
                                </div>
                                <div class="form-group">
                                    <label for="endDate">Enter end date:</label>
                                    <input type="date" class="form-control" id="endDate" name="end_date">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Filter Chats</button>
            </form>

        </div>
    </div>

    <!-- Display Filtered Results Here -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Filtered Chat Messages</h5>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Sender</th>
                            <th>Receiver</th>
                            <th>Message</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody id="filteredChatMessages">
                        <!-- Filtered Chat Messages will be populated here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add this script tag at the end of your Blade view -->
<script>
    // Function to handle form submission
    document.getElementById('filterForm').addEventListener('submit', function(event) {
        // Prevent the default form submission
        event.preventDefault();

        // Get the form data
        var formData = new FormData(this);

        // Make an AJAX request to the server
        fetch("{{ route('chats.filter') }}", {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            // Update the HTML with the filtered chat messages
            document.getElementById('filteredChatMessages').innerHTML = data;
        })
        .catch(error => console.error('Error:', error));
    });
</script>
@endsection
