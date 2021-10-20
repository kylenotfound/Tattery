<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class SearchController extends Controller {
    
    public function returnUserSearch(Request $request) {
        $request->validate([
            'search-term' => 'required|min:3|max:16'
        ]);

        $searchTerm = $request->input('search-term');

        $searchedUser = User::where('display_name', '=', $searchTerm)->first();

        if ($searchedUser == null) {
            return redirect()->back()->withErrors(["user not found" => "There is no user profile with that username!"]);
        }

        return redirect()->route('dash', ['id' => $searchedUser->getDisplayName()]);
    }

}
