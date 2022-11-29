<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class UserProfileController extends \Laravel\Jetstream\Http\Controllers\Inertia\UserProfileController
{
    //
    public function show(Request $request)
    {

        return parent::show($request);

    }
}
