<?php

namespace App\Http\Controllers;

use App\Iframes\UserIframe;
use App\Models\User;
use App\Rules\AlphaNumOneSpaceBetween;
use App\Rules\AlphaOneSpaceBetween;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.users.index', [
            'users' => User::notAdmin()
                ->filter($request->only(['last_name', 'first_name', 'email']))
                ->with(['city:id,country_id,name', 'city.country:id,name'])
                ->simplePaginate(10, ['id', 'city_id', 'first_name', 'last_name', 'email', 'phone_number', 'address', 'is_active']),
        ]);
    }

    public function get(Request $request)
    {
        if ($request->has('email')) {
            return User::notAdmin()
                ->filter(['email' => $request->validate(['email' => 'required|string'])['email']])
                ->limit(10)
                ->get(['id', 'last_name', 'first_name', 'email']);
        }
        if ($request->has('last_name')) {
            return User::notAdmin()->filter($request->validate([
                'last_name' => 'required|string',
                'first_name' => 'nullable|string',
            ]))->limit(10)->get(['id', 'last_name', 'first_name', 'email']);
        }
        return null;
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $user = User::create($this->validateUser($request));

        event(new Registered($user));

        return UserIframe::iframeCUClose() . '<br>' . UserIframe::reloadParent();
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', [
            'user' => $user,
        ]);
    }

    public function update(Request $request, User $user)
    {
        $user->update($this->validateUser($request, $user));

        if ($user->wasChanged('email')) {
            $user->email_verified_at = null;
            $user->save();

            event(new Registered($user));
        }

        return UserIframe::iframeCUClose() . '<br>' . UserIframe::reloadParent();
    }

    public function updateIsActive(Request $request)
    {
        $user = User::whereId($request->validate(['user_id' => 'required|int'])['user_id'])->whereIsAdmin(false)->firstOrFail();
        $user->update(['is_active' => !$user->is_active]);
        return json_encode($user->is_active);
    }

    protected function validateUser(Request $request, User $user = null)
    {
        $attributes = $request->validate([
            'city' => 'required|exists:cities,id',
            'last_name' => ['required', new AlphaOneSpaceBetween],
            'first_name' => ['required', new AlphaOneSpaceBetween],
            'email' => [
                'required',
                'email:rfc,dns',
                Rule::unique('users')->ignore($user->email ?? '', 'email'),
            ],
            'phone_number' => 'required|numeric',
            'address' => ['required', new AlphaNumOneSpaceBetween],
        ]);

        if (!isset($user)) {
            $attributes['password'] = Str::random();
        }

        $attributes['city_id'] = $attributes['city'];

        return $attributes;
    }
}
