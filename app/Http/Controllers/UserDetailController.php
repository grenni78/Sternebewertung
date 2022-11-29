<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use \App\Models\UserDetails;
use \App\Rules\Telefone;

class UserDetailController extends Controller
{
    /**
     * Index Controller
     */
    public function index(Request $request)
    {

        Inertia::share('redirect', 'dashboard');
        return Inertia::render('Profile/ShowDetailsOnly');

    }

    /**
     * Änderungen speichern und Validierung
     */
    public function update(Request $request)
    {
        $arch = null;

        if ($request->get('is_commercial', false)) {
            // für Firmenkunden
            $arch = [
                "is_commercial" => "boolean|required",
                "company" => "required|string|min:3|max:254",
                "firstname" => "string|min:3|max:254|required",
                "lastname" => "string|min:3|max:254|required",
                "street" => "string|min:3|max:254|required",
                "street_number" => "string|min:1|max:254|required",
                "zip" => "string|size:5|required",
                "city" => "string|min:3|max:254|required",
                "industry" => "string|max:254|required",
                "homepage" => "string|max:254|nullable",
                "tax_id" => "string|max:254|nullable",
                "company_about" => "string|required",
                "searchwords" => "string|max:254|nullable",
                "tel" => [new Telefone, 'max:254', 'required'],
                "gmaps_user" => "string|max:254|required",
                "gmaps_url" => "string|max:254|required",
                "paypal_user" => "email|max:254|required",
            ];
        } else {
            // für privat
            $arch = [
                "is_commercial" => "boolean|required",
                "company" => "nullable|string|min:3|max:254",
                "firstname" => "string|min:3|max:254|required",
                "lastname" => "string|min:3|max:254|required",
                "street" => "string|min:3|max:254|required",
                "street_number" => "string|min:1|max:254|required",
                "zip" => "string|size:5|required",
                "city" => "string|min:3|max:254|required",
                "industry" => "string|max:254|nullable",
                "homepage" => "string|max:254|nullable",
                "tax_id" => "string|max:254|nullable",
                "company_about" => "string|nullable",
                "searchwords" => "string|max:254|nullable",
                "tel" => [new Telefone, 'max:254', 'required'],
                "gmaps_user" => "string|max:254|nullable",
                "gmaps_url" => "string|max:254|nullable",
                "paypal_user" => "email|max:254|nullable",
            ];
        }

        $validated = $request->validateWithBag('updateUserDetail', $arch);

        if ($request->user()->details == null) {
            $details = new UserDetails;
        } else {
            $details = UserDetails::find($request->user()->id);
        }

        $validated["id"] = $request->user()->id;

        $details->fill($validated);

        $details->save();

        if ($target = $request->get('redirect')) {

            return redirect()->route($target);

        } else {
            return back(303)->with('status', 'userdetails-updated');

        }

    }
}
