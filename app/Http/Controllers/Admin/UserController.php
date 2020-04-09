<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class UserController extends Controller
{

    static function routes()
    {
        Route::domain('admin.'.Str::after(config('app.url'),'//'))->namespace('Admin')->group(function () {
            Route::get('users', 'UserController@index');
            Route::get('users/search', 'UserController@search');
            Route::get('users/{user}', 'UserController@show');
            Route::get('users/{user}/delete', 'UserController@destroy');
        });
    }

    public function __construct()
    {
        $this->middleware(['auth:web']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'DESC')->simplePaginate(20);

        return view('admin.users.list', [
            'users' => $users, 
            'list' => 'all', 
            'stats' => $this->stats(),
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->q;
        $users = User::where('name', 'LIKE', '%'.$query.'%')
            ->orWhere('email', 'LIKE', '%'.$query.'%')
            ->orderBy('created_at', 'DESC')->paginate(20)
            ->appends(['q' => $query]);

        return view('admin.users.list', [
            'users' => $users, 
            'list' => 'search', 
            'query' => $query,
            'stats' => [
                'all' => User::count(),
                'search' => $users->total(),
            ],
        ]);
    }

    public function show(User $user)
    {
        return view('admin.users.show', ['user' => $user]);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect('/users');
    }

    protected function stats()
    {
        return [
            'all' => User::count(),
        ];
    }
}
