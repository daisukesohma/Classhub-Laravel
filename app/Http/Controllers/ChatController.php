<?php

namespace App\Http\Controllers;

use App\Chat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class ChatController extends Controller
{
    
    public function inbox()
    {
        return Chat::where('initiator_id', Auth::user()->id)
            ->orWhere('participant_id', Auth::user()->id)->get();
    }
    
    public function messages(Request $request, $chatId)
    {
        try {
            
            $activeChat = Chat::findOrFail($chatId);
            
            $messages = $activeChat ? $activeChat->messages->sortBy('created_at')
                ->groupBy(function ($item) {
                    return Carbon::parse($item->created_at)->format('d-m-Y');
                }) : collect();
            
            $mobile =
            
            $messagesHtml = View::make('common.chat-messages', compact('messages', 'activeChat'))->render();
            
            return response()->json([
                'status' => true,
                'messages' => $messagesHtml
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage()
            ]);
        }
    }
}
