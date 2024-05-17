<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        // Fetch all chats
        $chats = Chat::all();

        return view('chat.index', compact('chats'));
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required',
        ]);
        $data =  $request->all();
        $data['sender_id'] = auth()->user()->id;
        Chat::create($data);

        return redirect()->back()->with('success', 'Chat message sent successfully.');
    }

    public function filterChats(Request $request)
    {
        // Retrieve selected filters from the request
        $keywords = $request->input('keywords', []); // Assuming keywords are sent as an array of keyword IDs
        $users = $request->input('users', []); // Assuming users are sent as an array of user IDs
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Query chat messages based on selected filters
        $chatsQuery = Chat::query();

        // Apply keyword filter
        if (!empty($keywords)) {
            $chatsQuery->whereIn('message', $keywords);
        }

        // Apply user filter
        if (!empty($users)) {
            $chatsQuery->whereIn('sender_id', $users);
        }

        // Apply date range filter
        if (!empty($startDate) && !empty($endDate)) {
            $chatsQuery->whereBetween('created_at', [$startDate, $endDate]);
        }

        // Fetch filtered chat messages
        $filteredChats = $chatsQuery->get();

        // Return the filtered chat messages as HTML
        return view('filtered', compact('filteredChats'));
    }
}
