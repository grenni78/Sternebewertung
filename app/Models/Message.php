<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Models\UserDetails;
use \App\Models\Attachment;

class Message extends Model
{
    use HasFactory;

    protected $table = "message";

    protected $with = ['sender', 'recipient', 'attachments'];

    protected $attributes = [
        'pinned' => false,
        'unread' => true,
        'reply_to' => null,
        'sender_id' => 0,
        'recipient_id' => 0
    ];

    protected $cast = [
        'pinned' => 'boolean',
        'unread' => 'boolean',
        'reply_to' => 'integer',
        'sender_id' => 'integer',
        'recipient_id' => 'integer'
    ];

    protected $fillable = [
        'content',
        'reply_to',
    ];

    // returns the User model of the messages's sender
    public function sender()
    {
        return $this->belongsTo(UserDetails::class, 'sender_id');
    }

    // returns the user model of the recieving user
    public function recipient()
    {
        return $this->belongsTo(UserDetails::class, 'recipient_id');
    }

    // return attachments if present
    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    // gets pseudo data
    public static function get_pseudo_data()
    {
        return [
            [
                "id" => 1,
                "firstname" => "Leslie",
                "lastname" => "Abbott",
                "name" => "L.Abbott",
                "role" => "Co-Founder / CEO",
                "imageUrl" =>
                "https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80",
            ],
            [
                "id" => 2,
                "firstname" => "Hector",
                "lastname" => "Adams",
                "name" => "H.Adams",
                "role" => "VP, Marketing",
                "imageUrl" =>
                "https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80",
            ],
            [
                "id" => 3,
                "firstname" => "Blake",
                "lastname" => "Alexander",
                "name" => "B.Alexander",
                "role" => "Account Coordinator",
                "imageUrl" =>
                "https://images.unsplash.com/photo-1520785643438-5bf77931f493?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80",
            ],
            [
                "id" => 4,
                "firstname" => "Fabricio",
                "lastname" => "Andrews",
                "name" => "F.Andrews",
                "role" => "Senior Art Director",
                "imageUrl" =>
                "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80",
            ],
            [
                "id" => 5,
                "firstname" => "Angela",
                "lastname" => "Beaver",
                "name" => "A.Beaver",
                "role" => "Chief Strategy Officer",
                "imageUrl" =>
                "https://images.unsplash.com/photo-1501031170107-cfd33f0cbdcc?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80",
            ],
            [
                "id" => 6,
                "firstname" => "Yvette",
                "lastname" => "Blanchard",
                "name" => "Y.Blanchard",
                "role" => "Studio Artist",
                "imageUrl" =>
                "https://images.unsplash.com/photo-1506980595904-70325b7fdd90?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80",
            ],
            [
                "id" => 7,
                "firstname" => "Lawrence",
                "lastname" => "Brooks",
                "name" => "L.Brooks",
                "role" => "Content Specialist",
                "imageUrl" =>
                "https://images.unsplash.com/photo-1513910367299-bce8d8a0ebf6?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80",
            ],
            [
                "id" => 8,
                "firstname" => "Jeffrey",
                "lastname" => "Clark",
                "name" => "J.Clark",
                "role" => "Senior Art Director",
                "imageUrl" =>
                "https://images.unsplash.com/photo-1517070208541-6ddc4d3efbcb?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80",
            ],
            [
                "id" => 9,
                "firstname" => "Kathryn",
                "lastname" => "Cooper",
                "name" => "K.Cooper",
                "role" => "Associate Creative Director",
                "imageUrl" =>
                "https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80",
            ],
            [
                "id" => 10,
                "firstname" => "Alicia",
                "lastname" => "Edwards",
                "name" => "A.Edwards",
                "role" => "Junior Copywriter",
                "imageUrl" =>
                "https://images.unsplash.com/photo-1509783236416-c9ad59bae472?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80",
            ],
            [
                "id" => 11,
                "firstname" => "Benjamin",
                "lastname" => "Emerson",
                "name" => "B.Emerson",
                "role" => "Director, Print Operations",
                "imageUrl" =>
                "https://images.unsplash.com/photo-1531427186611-ecfd6d936c79?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80",
            ],
            [
                "id" => 12,
                "firstname" => "Jillian",
                "lastname" => "Erics",
                "name" => "J.Erics",
                "role" => "Designer",
                "imageUrl" =>
                "https://images.unsplash.com/photo-1504703395950-b89145a5425b?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80",
            ],
            [
                "id" => 13,
                "firstname" => "Chelsea",
                "lastname" => "Evans",
                "name" => "C.Evans",
                "role" => "Human Resources Manager",
                "imageUrl" =>
                "https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80",
            ],
            [
                "id" => 14,
                "firstname" => "Michael",
                "lastname" => "Gillard",
                "name" => "M.Gillard",
                "role" => "Co-Founder / CTO",
                "imageUrl" =>
                "https://images.unsplash.com/photo-1519244703995-f4e0f30006d5?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80",
            ],
            [
                "id" => 15,
                "firstname" => "Dries",
                "lastname" => "Giuessepe",
                "name" => "D.Giuessepe",
                "role" => "Manager, Business Relations",
                "imageUrl" =>
                "https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80",
            ],
            [
                "id" => 16,
                "firstname" => "Jenny",
                "lastname" => "Harrison",
                "name" => "J.Harrison",
                "role" => "Studio Artist",
                "imageUrl" =>
                "https://images.unsplash.com/photo-1507101105822-7472b28e22ac?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80",
            ],
            [
                "id" => 17,
                "firstname" => "Lindsay",
                "lastname" => "Hatley",
                "name" => "L.Hatley",
                "role" => "Front-end Developer",
                "imageUrl" =>
                "https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80",
            ],
            [
                "id" => 18,
                "firstname" => "Anna",
                "lastname" => "Hill",
                "name" => "A.Hill",
                "role" => "Partner, Creative",
                "imageUrl" =>
                "https://images.unsplash.com/photo-1534528741775-53994a69daeb?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80",
            ],
            [
                "id" => 19,
                "firstname" => "Courtney",
                "lastname" => "Samuels",
                "name" => "C.Samuels",
                "role" => "Designer",
                "imageUrl" =>
                "https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80",
            ],
            [
                "id" => 20,
                "firstname" => "Tom",
                "lastname" => "Simpson",
                "name" => "T.Simpson",
                "role" => "Director, Product Development",
                "imageUrl" =>
                "https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80",
            ],
            [
                "id" => 21,
                "firstname" => "Floyd",
                "lastname" => "Thompson",
                "name" => "F.Thompson",
                "role" => "Principal Designer",
                "imageUrl" =>
                "https://images.unsplash.com/photo-1463453091185-61582044d556?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80",
            ],
            [
                "id" => 22,
                "firstname" => "Leonard",
                "lastname" => "Timmons",
                "name" => "L.Timmons",
                "role" => "Senior Designer",
                "imageUrl" =>
                "https://images.unsplash.com/photo-1519345182560-3f2917c472ef?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80",
            ],
            [
                "id" => 23,
                "firstname" => "Whitney",
                "lastname" => "Trudeau",
                "name" => "W.Trudeau",
                "role" => "Copywriter",
                "imageUrl" =>
                "https://images.unsplash.com/photo-1517365830460-955ce3ccd263?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80",
            ],
            [
                "id" => 24,
                "firstname" => "Kristin",
                "lastname" => "Watson",
                "name" => "K.Watson",
                "role" => "VP, Human Resources",
                "imageUrl" =>
                "https://images.unsplash.com/photo-1500917293891-ef795e70e1f6?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80",
            ],
            [
                "id" => 25,
                "firstname" => "Emily",
                "lastname" => "Wilson",
                "name" => "E.Wilson",
                "role" => "VP, User Experience",
                "imageUrl" =>
                "https://images.unsplash.com/photo-1502685104226-ee32379fefbe?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80",
            ],
            [
                "id" => 26,
                "firstname" => "Emma",
                "lastname" => "Young",
                "name" => "E.Young",
                "role" => "Senior Front-end Developer",
                "imageUrl" =>
                "https://images.unsplash.com/photo-1505840717430-882ce147ef2d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80",
            ],
        ];
    }
}
