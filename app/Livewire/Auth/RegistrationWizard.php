<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class RegistrationWizard extends Component
{
    public $currentStep = 1;

    // Step 1: Account
    public $email;
    public $password;
    public $password_confirmation;

    // Step 2: Profile
    public $full_name;
    public $phone;
    public $gender;
    public $address;

    // Step 3: Path
    public $learning_path = 'mandarin'; // Default

    // Step 4: Verification
    public $captcha = null;


    protected $rules = [
        1 => [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
        ],
        2 => [
            'full_name' => 'required|string|min:3',
            'phone' => 'required|numeric',
            'gender' => 'required|in:male,female,other',
        ],
        3 => [
            'learning_path' => 'required|in:mandarin,indonesia',
        ],
        4 => [
            // 'g-recaptcha-response' => 'required|captcha' // Assuming package installed
        ]
    ];

    public function nextStep()
    {
        $this->validate($this->rules[$this->currentStep]);
        $this->currentStep++;
    }

    public function previousStep()
    {
        $this->currentStep--;
    }

    public function register()
    {
        // Final Validation if needed
        // $this->validate($this->rules[4]);

        DB::transaction(function () {
            // Create User
            $user = User::create([
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'learning_path' => $this->learning_path,
            ]);

            // Create Profile
            Profile::create([
                'user_id' => $user->id,
                'full_name' => $this->full_name,
                'phone' => $this->phone,
                'gender' => $this->gender,
                'address' => $this->address ?? '',
            ]);

            // Login
            auth()->login($user);
        });

        // Redirect based on Path
        if ($this->learning_path === 'mandarin') {
            return redirect()->route('dashboard.mandarin'); // Dashboard A
        } else {
            return redirect()->route('dashboard.indonesia'); // Dashboard B
        }
    }

    public function render()
    {
        return view('livewire.auth.registration-wizard');
    }
}
