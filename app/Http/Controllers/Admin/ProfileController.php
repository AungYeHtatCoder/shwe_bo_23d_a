<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
    {
        if (auth()->user()->hasRole('Admin')) {
            $user = User::find(Auth::user()->id);
            return view('admin.profile.admin_profile', compact('user'));

    } else {
            $user = User::find(Auth::user()->id);
            return view('admin.profile.user_profile', compact('user'));
    }
        //return view('admin.profile.index');
    }
    //UserProfile
    public function UserProfile()
    {
        if (auth()->user()->hasRole('Admin')) {
            $user = User::find(Auth::user()->id);
            return view('admin.profile.admin_profile', compact('user'));

    } else {
            $user = User::find(Auth::user()->id);
            return view('user_profile', compact('user'));
    }
        //return view('admin.profile.index');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }


    public function update(UserRequest $request, User $profile)
    {
    $data = $request->validated();

    // Check if a new profile image has been uploaded
    $newImage = $request->file('profile');

    if ($newImage) {
       // $main_folder = 'profile_images/';
        $main_folder = 'profile_image/' . Str::random();
        $filename = $newImage->getClientOriginalName();

        // Store the new image with specified visibility settings
        $path = Storage::putFileAs('public/'.
            $main_folder,
            $newImage,
            $filename,
            [
                'visibility' => 'public',
                'directory_visibility' => 'public'
            ]
        );

        $data['profile'] = URL::to(Storage::url($path));
        $data['profile_mime'] = $newImage->getClientMimeType();
        $data['profile_size'] = $newImage->getSize();

        // If there is an old image, delete it
        if ($profile->profile) {
            $oldImagePath = str_replace(URL::to('/'), '', $profile->profile);
            Storage::delete($oldImagePath);
        }
    }

    $profile->update($data);

    return redirect()->back()->with('success', 'Profile updated successfully');
}
// new password change function
    public function newPassword(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'password' => 'required|min:8',

        ]);

        $user = User::find(Auth::user()->id);

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->back()->with('toast_success', "Customer Password has been Updated.");

    }
    // AdminUpdateBalance 
    public function AdminUpdateBalance(Request $request)
{
    //dd($request->all());
    $request->validate([
        'balance' => 'required|numeric',
    ]);

    $user = User::find(Auth::user()->id);
    // updateAdminBalance
    $this->authorize('updateAdminBalance', $user);
    $user->update([
        'balance' => $user->balance + $request->balance,
    ]);

    return redirect()->back()->with('toast_success', "Admin Balance has been Updated.");
}

    public function editInfo(Request $request)
    {
        $request->validate([
            "name" => "required",
            "email" => "nullable",
            "phone" => ['nullable', 'string', 'min:11'],
            "address" => "nullable"
        ]);

        $user = User::find(Auth::id());

        if ($request->email !== $user->email || $request->phone !== $user->phone) {
            $existingEmail = User::where("email", $request->email)->first();
            $existingPhone = User::where("phone", $request->phone)->first();

            if ($existingEmail && $existingEmail->id !== $user->id) {
                return redirect()->back()->with("error", "The email has already been taken.");
            }
            if ($existingPhone && $existingPhone->id !== $user->id) {
                return redirect()->back()->with("error", "The phone has already been taken.");
            }
        }

        $user->update([
            "name" => $request->name,
            "email" => $request->email ?? $user->email,
            "phone" => $request->phone ?? $user->phone,
            "address" => $request->address ?? $user->address
        ]);

        return redirect()->back()->with("success", "User info updated successfully.");
    }


    // password change function
    public function changePassword(Request $request)
    {
        //dd($request->all());
        $request->validate([
            //'old_password' => 'required',
            'password' => 'required|min:6',

        ]);

        $user = User::find(Auth::user()->id);

        if (Hash::check($request->old_password, $user->password)) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);

            if (auth()->user()->hasRole('Admin')) {
                return redirect()->back()->with('success', "Admin Password has been  Updated.");
            } else {
                return redirect()->back()->with('success', "Customer Password has been Updated.");
            }
        } else {
            return redirect()->back()->with('error', "Old password does not match!");
        }
    }

    public function PasswordReset(Request $request, $id)
{
    // Validate the request to ensure the password meets the required criteria
    $validator = Validator::make($request->all(), [
        'password' => 'required|min:6|confirmed', // Add confirmed rule to ensure matching passwords
    ]);

    // If validation fails, return back with error messages
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Find the user by ID
    $user = User::findOrFail($id);

    // Update the user's password securely
    $user->password = Hash::make($request->input('password'));
    $user->save();

    // Return a success message after successful password reset
    return redirect()->back()->with('success', 'Password has been updated successfully.');
}
    public function PhoneAddressChange(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'address' => 'required',

        ]);

        $user = User::find(Auth::user()->id);

        $user->update([
            'name' => $request->name, // 'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address
        ]);

        if (auth()->user()->hasRole('Admin')) {
            return redirect()->back()->with('toast_success', "Admin Profile has been  Updated.");
        } else {
            return redirect()->back()->with('toast_success', "Customer Profile has been Updated.");
        }
    }

    public function KpayNoChange(Request $request)
    {

        $user = User::find(Auth::user()->id);

        $user->update([
            'kpay_no' => $request->kpay_no,
            'cbpay_no' => $request->cbpay_no,
            'wavepay_no' => $request->wavepay_no,
            'ayapay_no' => $request->ayapay_no,
        ]);

        if (auth()->user()->hasRole('Admin')) {
            return redirect()->back()->with('toast_success', "Admin Profile has been  Updated.");
        } else {
            return redirect()->back()->with('toast_success', "Customer Profile has been Updated.");
        }
    }

        public function JoinDate(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'join_date' => 'required',
        ]);
            $formattedJoinDate = Carbon::createFromFormat('m/d/Y', $request->input('join_date'))->format('Y-m-d');

        $user = User::find(Auth::user()->id);

        $user->update([
            'join_date' => $formattedJoinDate,
        ]);

        if (auth()->user()->hasRole('Admin')) {
            return redirect()->back()->with('toast_success', "Admin Profile has been  Updated.");
        } else {
            return redirect()->back()->with('toast_success', "Customer Profile has been Updated.");
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function saveImage(UploadedFile $image)
    {
        $path = 'profile_image/' . Str::random();
        //$path = 'images/product_image';

        if (!Storage::exists($path)) {
            Storage::makeDirectory($path, 0755, true);
        }
        if (!Storage::putFileAS('public/' . $path, $image, $image->getClientOriginalName())) {
            throw new \Exception("Unable to save file \"{$image->getClientOriginalName()}\"");
        }

        return $path . '/' . $image->getClientOriginalName();
    }

    public function fillmoney()
    {
        return view('admin.profile.fill_money');
    }


    public function update2DCommission(Request $request, $id)
    {
        $cor = $request->input('cor'); // The new status

        // Find the result by ID
        $result = User::findOrFail($id);

        // Update the status
        $result->cor = $cor;
        $result->save();

        // Return a response (like a JSON object)
        return redirect()->back()->with('success', 'Result number updated successfully.'); // Redirect back with success message
    }


    public function update3DCommission(Request $request, $id)
    {
        $cor3 = $request->input('cor3'); // The new status

        // Find the result by ID
        $result = User::findOrFail($id);

        // Update the status
        $result->cor3 = $cor3;
        $result->save();

        // Return a response (like a JSON object)
        return redirect()->back()->with('success', 'Result number updated successfully.'); // Redirect back with success message
    }


    public function update2DLimit(Request $request, $id)
    {
        $limit = $request->input('limit'); // The new status

        // Find the result by ID
        $result = User::findOrFail($id);

        // Update the status
        $result->limit = $limit;
        $result->save();

        // Return a response (like a JSON object)
        return redirect()->back()->with('success', 'Result number updated successfully.'); // Redirect back with success message
    }
    public function update3DLimit(Request $request, $id)
    {
        $limit3 = $request->input('limit3'); // The new status

        // Find the result by ID
        $result = User::findOrFail($id);

        // Update the status
        $result->limit3 = $limit3;
        $result->save();

        // Return a response (like a JSON object)
        return redirect()->back()->with('success', 'Result number updated successfully.'); // Redirect back with success message
    }



}