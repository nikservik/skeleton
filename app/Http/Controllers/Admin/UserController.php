<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserCreateRequest;
use App\Http\Requests\Admin\UserEditRequest;
use App\Mail\VerifyEmail;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class UserController extends Controller
{

    static function routes()
    {
        Route::domain('admin.'.Str::after(config('app.url'),'//'))->namespace('Admin')->group(function () {
            Route::get('users/search', 'UserController@search')->middleware('can:viewAny,App\User');
            Route::resource('users', 'UserController');
        });
    }

    public function __construct()
    {
        $this->middleware(['auth:web', 'isAdmin']);
        $this->authorizeResource(User::class, 'user');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'DESC')->simplePaginate(10);

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
            ->orderBy('created_at', 'DESC')->paginate(10)
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

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(UserCreateRequest $request)
    {
        $request->merge(['password' => Hash::make($request->password)]);
        
        $user = User::create($request->all());

        if ($request->has('dontVerify')) {
            $user->email_verified_at = Carbon::now();
            $user->save();
        } else {
            Mail::to($user->email)->queue(new VerifyEmail($user));
        }

        return redirect('/users');
    }

    public function show(User $user)
    {
        return view('admin.users.show', ['user' => $user]);
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', ['user' => $user]);
    }

    public function update(UserEditRequest $request, User $user)
    {
        $user->fill($request->except('password'));
        if ($request->password)
            $user->password = Hash::make($request->password);

        $user->save();

        return redirect('/users/'.$user->id);
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
