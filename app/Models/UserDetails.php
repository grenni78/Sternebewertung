<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    use HasFactory;

    protected $with = ["user"];

    protected $fillable = ['id', 'is_commercial', 'company', 'firstname', 'lastname', 'street', 'street_number', 'zip', 'city', 'industry', 'homepage', 'tax_id', 'company_about', 'searchwords', 'tel', 'gmaps_user', 'gmaps_url', 'paypal_user'];

    /**
     * returns the associated user
     */
    public function user()
    {
        return ($this->belongsTo(\App\Models\User::class, 'id'));
    }

    /**
     * returns the user's image
     */
    public function image()
    {
        $img = \App\Models\User::where('id', $this->id)->select('profile_photo_path')->get();

        if (!$img->count()) {
            return "";
        }

        if (strpos($img, "http") === 0) {
            return $img;
        }

        return "/avatars/$img";

    }
}
