<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{

    public function index()
    {
        $messages = ContactMessage::latest()->get();

        return response()->json([
            'status' => true,
            'count'  => $messages->count(), 
            'data'   => $messages
        ], 200);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'phone'        => 'required|string|max:20', 
            'area'         => 'required|string|max:255',
            'service_type' => 'required|string|max:255',
            'message'      => 'required|string',
        ]);

        
        $contactMessage = ContactMessage::create([
            'name'         => $request->name,
            'phone'        => $request->phone,
            'area'         => $request->area,
            'service_type' => $request->service_type,
            'message'      => $request->message,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Data is sent',
            'data'    => $contactMessage
        ], 201);
    }

    public function destroy($id)
    {
        $message = ContactMessage::find($id);

         if (!$message) {
            return response()->json([
                'status'  => false,
                'message' => 'this message is not found'
            ], 404);
        }

        // تنفيذ الحذف
        $message->delete();

        return response()->json([
            'status'  => true,
            'message' => 'deleted successfully'
        ], 200);
    }
}
