<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\UpdateProfileRequest;
use Validator;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\Admin\User;
use function view;
use App\Models\Admin\Role;

class ProfileController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit()
    {
        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0");

        $user = Auth::user();
        $user->load('roles');
        $roles = Role::getSelectOptions();

        $labels = User::getAttrsTrans();

        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0");

        return view('admin.profile.edit', ['user' => $user, 'roles' => $roles, 'labels' => $labels]);
    }

    /**
     * @param UpdateProfileRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateProfileRequest $request)
    {
        $user = Auth::user();

        $data = $request->validated();

        $user->update($data);

        $user->revisionableUpdateManyToMany($data);

        if(Auth::user()->can('assign_roles', User::class)) {
            $user->roles()->sync($data['roles']);
        }

        return redirect()->route('admin.profile.edit')
            ->with('success', __('Profile updated successfully!'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setLocale()
    {
        $validator = Validator::make(request()->all(), [
            'locale' => 'required'
        ]);

        if(!$validator->fails()) {
            Auth::user()->update(['locale' => request('locale')]);
        }

        return redirect()->back();
    }

    public function postAvatar(User $user = null)
    {
        if(!$user) {
            $user = Auth::user();
        }
        request()->validate([
            'image' => 'required',
        ]);

        try {
            $image = request('image');
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imagePath = storage_path() . '/tmp/' . time() . '.'.'png';

            if (!file_exists(storage_path() . '/tmp')) {
                mkdir(storage_path() . '/tmp', 0775, true);
            }

            file_put_contents($imagePath, base64_decode($image));
        }catch (Exception $exception) {
            return response()->json(['error' => true, 500]);
        }

        $user->clearMediaCollection('profile-image');
        $user->addMedia($imagePath)->toMediaCollection('profile-image');

        if(request()->has('image')) {
            return response()->json(['success' => $user->getMedia('profile-image')[0]->getFullUrl(), 201]);
        }else {
            return response()->json(['success' => 'no file', 201]);
        }
    }

    public function postDashboardOrder()
    {
        if(request()->wantsJson() || request()->ajax()) {

            request()->validate([
                'widgets' => 'required',
            ]);

            Auth::user()->update([
                'settings->dashboard->widgets' => request('widgets'),
            ]);

            return response()->json(['success' => true, 201]);
        }

        abort(404);
    }
}
