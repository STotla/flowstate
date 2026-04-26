<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class InvitationController extends Controller
{
    public function invite(Company $company)
    {
        $user = auth()->user();
        if (!$user->hasAnyRole(['Admin', 'SuperAdmin'])) {
            abort(403);
        }
        if ($user->hasRole('Admin') && $user->company_id !== $company->id) {
            abort(403);
        }

        return view('company.invite', compact('company'));
    }

    public function sendInvitation(Company $company, Request $request)
    {

        $user = auth()->user();
        if (!$user->hasAnyRole(['Admin', 'SuperAdmin'])) {
            abort(403);
        }
        if ($user->hasRole('Admin') && $user->company_id !== $company->id) {
            abort(403);
        }
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'role' => 'nullable|in:Admin,Member',
        ]);
        $role = $request->input('role', 'Admin');
        $url = URL::temporarySignedRoute(
            'register',
            now()->addHours(60),
            ['company_id' => $company->id, 'email' => $request->email, 'role' => $role]
        );
        Mail::to($request->email)->queue(new \App\Mail\InvitationMail(url($url), $company->name));
        return redirect()->route('company.invite', $company)->with('success', $url);
    }
}
