<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\City;
use App\User;
use Hash;

class Login extends Component
{
    public $users,$email,$password;
    public $cities;

    public function render()
    {
        return view('livewire.login');
    }

    public function mount()
    {

    }
    public function login()
    {
        $validatedDate = $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (\Auth::attempt(array('email' => $this->email, 'password' => $this->password))) {
            return redirect()->to('/');
        } else {
            session()->flash('error', 'Email and password are wrong.');
        }
    }


}
