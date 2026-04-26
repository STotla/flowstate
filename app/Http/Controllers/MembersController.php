<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class MembersController extends Controller
{
     use AuthorizesRequests;
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Company $company)
    {
        $this->authorize('viewAny', [User::class, $company]);
        return view('company.members.index', [
            'company' => $company,
            'users' => $company->users()->paginate(10),
        ]);
    }
}
