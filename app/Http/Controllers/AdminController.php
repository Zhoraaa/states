<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    //
    protected function onlyAdmin()
    {
        if (Auth::user()->role > 1) {
            return redirect()->route('home')->with('error', 'Отказано в доступе');
        }
    }

    public function usrRedaction()
    {
        $result = $this->onlyAdmin();
        if ($result instanceof \Illuminate\Http\RedirectResponse) {
            return $result;
        }

        $data['users'] = User::join('roles', 'users.role', '=', 'roles.id')
            ->select('users.*', 'roles.name as role')
            ->paginate(5);

        $data['roles'] = DB::table('roles')
            ->where('id', '<', 1)
            ->get();

        // dd($data);        

        return view('admin.allUsers', compact('data'));
    }

    public function doMod(Request $request)
    {
        $result = $this->onlyAdmin();
        if ($result instanceof \Illuminate\Http\RedirectResponse) {
            return $result;
        }

        User::where('id', $request->id)
            ->update([
                'role' => 2
            ]);
        return redirect()->back();
    }
    public function undoMod(Request $request)
    {
        $result = $this->onlyAdmin();
        if ($result instanceof \Illuminate\Http\RedirectResponse) {
            return $result;
        }

        User::where('id', $request->id)
            ->update([
                'role' => 3
            ]);
        return redirect()->back();
    }
    public function ban(Request $request)
    {
        $result = $this->onlyAdmin();
        if ($result instanceof \Illuminate\Http\RedirectResponse) {
            return $result;
        }

        User::where('id', $request->id)
            ->update([
                'banned' => 1
            ]);
        return redirect()->back();
    }
    public function unban(Request $request)
    {
        $result = $this->onlyAdmin();
        if ($result instanceof \Illuminate\Http\RedirectResponse) {
            return $result;
        }

        User::where('id', $request->id)
            ->update([
                'banned' => 0
            ]);
        return redirect()->back();
    }
}
