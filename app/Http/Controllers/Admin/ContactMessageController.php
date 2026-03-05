<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContactMessageResource;
use App\Models\ContactMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ContactMessageController extends Controller
{
    /**
     * List all messages, newest first, paginated.
     */
    public function index(): AnonymousResourceCollection
    {
        return ContactMessageResource::collection(
            ContactMessage::latest()->paginate(20)
        );
    }

    /**
     * Show a single message.
     */
    public function show(int $id): ContactMessageResource
    {
        return new ContactMessageResource(ContactMessage::findOrFail($id));
    }

    /**
     * Mark a message as read.
     */
    public function markRead(int $id): ContactMessageResource
    {
        $message = ContactMessage::findOrFail($id);
        $message->update(['is_read' => true]);

        return new ContactMessageResource($message);
    }

    /**
     * Delete a message.
     */
    public function destroy(int $id): JsonResponse
    {
        $message = ContactMessage::findOrFail($id);
        $message->delete();

        return response()->json(null, 204);
    }
}
