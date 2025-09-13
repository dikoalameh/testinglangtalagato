<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class RegisteredUserController extends Controller
{
    //Display the registration view.
    public function create(): View
    {
        return view('auth.register');
    }
    public function index(Request $request){
            $users = User::all();

        if ($request->wantsJson()) {
        return response()->json([
            'status' => 'success',
            'count' => $users->count(),
            'data' => $users
        ]);
        }

        return view('superadmin.permission-control', compact(('users')));
    }
    /**
     * Handle an incoming registration request.
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validate = $request->validate([
        'user_Fname' => ['required', 'string', 'max:255'],
        'user_Lname' => ['required', 'string', 'max:255'],
        'user_MI' => ['nullable', 'string', 'max:2'], 
        'user_Password' => [
            'required',
            'string',
            'min:8',
            'confirmed',
            ],
        'user_Email' => 'required|email|unique:tbl_users,user_Email',
        //'Co_Investigators' => ['string', 'max:255'],
        //'pi_title' => ['string', 'max:255','required'],
        //'pi_program' => ['required','string','max:255'],
        //'pi_school' => ['nullable', 'string', 'max:255'], //testing lang
        'user_Access' => ['nullable'],
        //'pi_LetterOfIntent' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $user = new User();
        $user_Access = $request->input('user_Access', 'Principal Investigator');
        if (empty($user_Access)) {
            $user_Access = 'Principal Investigator';
        }
        $user->user_Access = $user_Access;
        $user->user_Lname = $validate['user_Lname'];
        $user->user_Fname = $validate['user_Fname'];
        $user->user_MI = $validate['user_MI'] ?? null; // optional: fallback if null
        $user->user_Password = Hash::make($validate['user_Password']);
        $user->user_Email = $validate['user_Email'];
        $user->save();

        event(new Registered($user));

        //Auth::login($user);

        //Temporary route, depende sa file name ni ben
        return redirect()->route('auth.research.create', ['user_id' => $user->user_ID]);
    }
    public function addUser(Request $request)
    {
        $validate = $request->validate([
        'user_Fname' => ['required', 'string', 'max:255'],
        'user_Lname' => ['required', 'string', 'max:255'],
        'user_MI' => ['nullable', 'string', 'max:2'], 
        'user_Password' => [
            'required',
            'string',
            'min:8',
            'confirmed',
            ],
        'user_Email' => 'required|email|unique:tbl_users,user_Email',
        //'Co_Investigators' => ['string', 'max:255'],
        //'pi_title' => ['string', 'max:255','required'],
        //'pi_program' => ['required','string','max:255'],
        //'pi_school' => ['nullable', 'string', 'max:255'], //testing lang
        'user_Access' => ['nullable'],
        //'pi_LetterOfIntent' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $user = new User();
        
        $user_Access = $request->input('user_Access', 'Principal Investigator');
        if (empty($user_Access)) {
            $user_Access = 'Principal Investigator';
        }
        $user->user_Access = $user_Access;
        $user->user_ID = $this->generateCustomID($user_Access);
        $user->user_Lname = $validate['user_Lname'];
        $user->user_Fname = $validate['user_Fname'];
        $user->user_MI = $validate['user_MI'] ?? null; // optional: fallback if null
        $user->user_Password = Hash::make($validate['user_Password']);
        $user->user_Email = $validate['user_Email'];
        //$user->Co_Investigators = $validate['Co_Investigators'];
        //$user->pi_program = $validate['pi_program'];
        //$user->pi_title = $validate['pi_title'];
        $user->save();

        if ($request->wantsJson()) {
        return response()->json([
            'status'  => 'success',
            'message' => 'New user added successfully.',
            'data'    => $user
        ], 201);
    }

    return redirect()->route('permission-control')
                     ->with('success', 'New user added successfully.');
        /*
        // Create user folder
        $folderPath = 'piFolder/' . $user->pi_ID;
        Storage::makeDirectory($folderPath);

        if ($request->hasFile('pi_LetterOfIntent')) {
            $file = $request->file('pi_LetterOfIntent');
            $filename = $user->pi_ID . '_' . time() . '.' . $file->getClientOriginalExtension(); // optional: unique filename
            $path = $file->storeAs($folderPath, $filename, 'public');

            // Save only the file path in DB
            $user->pi_LetterOfIntent = $path;
            $user->save();
        }
        */

        //$plainPassword = $validate['pi_Password']; // store plain password before hashing
        //Mail::to($user->pi_Email)->send(new UserCredentialMail($user, $plainPassword));
        /*
        $request->validate([
            'userLname' => ['required', 'string', 'max:255'],
            'pi_fname' => ['required', 'string', 'max:255'],
            'userMI' => ['nullable|string|max:4'],
            //'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            //'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            //'email' => $request->email,
            //'password' => Hash::make($request->password),
        ]); */
    }
    private function generateCustomID(?string $user_Access): string
    {
        $user_Access = $user_Access ?: 'Principal Investigator';

        $prefixMap = [
            'Reviewer' => 'r',
            'IACUC Admin' => 'i',
            'ERB Admin' => 'e',
            'Superadmin' => 's',
            'Principal Investigator' => 'p'
        ];

        $prefix = $prefixMap[$user_Access] ?? 'x';

        $latest = User::where('user_Access', $user_Access)
            ->where('user_ID', 'like', $prefix . '%')
            ->orderByDesc('user_ID')
            ->first();

        if (!$latest) {
            return $prefix . '000001';
        }

    // ✅ use user_ID instead of user_Access
        $number = (int) substr($latest->user_ID, 1);
        $next = $number + 1;

        return $prefix . str_pad($next, 6, '0', STR_PAD_LEFT);
    }
}
