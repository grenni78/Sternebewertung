<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use \App\Models\Message;
use \App\Models\User;
use \App\Notifications\WebPushNotification;

class MessagesController extends Controller
{
    /**
     * gets the conversation view
     *
     * @param int $contact  id of the other user (optional)
     */
    public function index($contact = null)
    {
        return Inertia::render('Messages', [
            'contact' => $contact,
        ]);
    }

    /**
     * --------------- API part --------------------------------------
     */

    /**
     * returns a single message
     *
     * @param id
     */
    public function api_get_message($id)
    {
        $msg = Message::find($id);

        if ($msg->count() == 0) {
            return response()->status(404);
        }

        return response()->json($msg);
    }
    /**
     * returns the messages from or to the current user
     *
     */
    public function api_get_messages()
    {
        $id = Auth::user()->id;

        return response()->json(Message::where('recipient_id', $id)->orWhere('sender_id', $id)->get());
    }
    /**
     * post a new message
     */
    public function api_post_message(Request $request)
    {
        $posted = $request->json()->all();

        // missing parameters
        if (!(array_key_exists('message', $posted) && array_key_exists('sender', $posted) && array_key_exists('recipient', $posted))) {

            return response()->json("wrong call", 400);

        }

        $sender = Auth::user();
        $recipient = \App\Models\User::find($posted["recipient"]);

        // sending user has a different ID than the logged in user
        if ($posted['sender'] != $sender->id) {

            return response()->json("can not send a message for a different then the current user.", 400);

        }

        // targeted user is unknown in the database
        if (!$recipient->count()) {

            return response()->json("Recipient with ID {$posted['recipient']} could not be found.", 400);

        }

        // clean with https: //opensourcelibs.com/lib/purifier

        $clean_html = clean($posted['message']);

        // create and insert message

        $message = new Message();
        $message->content = $clean_html;
        $message->sender_id = $sender->id;
        $message->recipient_id = $recipient->id;
        $message->pinned = false;
        $message->unread = true;

        $message->save();

        $recipient->notify(new WebPushNotification(
            'NewMessage',
            "Neue Nachricht von {$sender->name}",
            "Es liegt eine neue Nachrich von {$sender->name} für Sie vor.",
            [
                "sender_id" => $sender->id,
                "recipient_id" => $recipient->id,
                "message_id" => $message->id,
            ],
            "Zum Nachrichtencenter",
            "/messages/" . $sender->id
        ));

        return response()->json(Message::find($message->id));

    }
    /**
     * marks a message as read
     *
     * only available for the recieving user (recipient). Notification is sent to the sending user (sender)
     */
    public function api_mark_read(Request $request)
    {
        $posted = $request->json()->all();

        if (!(isset($posted['id']) && isset($posted['read']) && isset($posted['userId']))) {
            return response()->json("wrong call", 400);
        }

        $message = Message::find($posted["id"]);

        if (!$message->count()) {
            return response()->json("no such message found", 404);
        }

        $recipient = $message->recipient;

        if (($posted['userId'] != $recipient->id) && ($posted["userId"] != $message->recipient_id)) {

            return response()->json("can not modify a message for a different then the current user.", 400);

        }

        $sender = $message->sender;

        $message->unread = !$posted["read"];

        $message->save();

        $sender->user->notify(new WebPushNotification(
            "MessageRead",
            "Nachricht wurde gelesen",
            "Ihre Nanchricht an {$recipient->user->name} wurde gelesen.",
            [
                "sender_id" => $sender->id,
                "recipient_id" => $recipient->id,
                "message_id" => $message->id,
            ],
            "Zum Nachrichtencenter",
            "/messages/" . $message->id
        ));

        return response()->json("ok");

    }
    /**
     * returns pseudo-data
     */
    public function pseudo()
    {
        return response()->json(Message::get_pseudo_data());
    }
}
