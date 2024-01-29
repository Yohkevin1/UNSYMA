<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class C_User extends Controller
{
    protected $validCreated, $ResponValid, $validUpdate, $validPass;

    public function __construct()
    {
        $this->validCreated = [
            'username' => 'required|string|max:30|unique:users,username',
            'password' => 'required|string|max:30|min:10|unique:users,password|same:passConfirm|regex:/^(?:(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{10,})$/',
            'passConfirm' => 'required',
            'role' => 'required',
        ];

        $this->ResponValid = [
            'username' => [
                'required' => 'Username wajib diisi!',
                'max' => 'Username maksimal 30 karakter!',
                'unique' => 'Username sudah ada!',
            ],
            'password' => [
                'required' => 'Password wajib diisi!',
                'max' => 'Password maksimal 30 karakter!',
                'unique' => 'Password sudah ada!',
                'min' => 'Password minimal 10 karakter',
                'same' => 'Password Confirmation tidak cocok',
                'regex' => 'Password harus mengandung minimal satu huruf besar, satu huruf kecil, satu angka, dan satu karakter khusus',
            ],
            'confirmPassword.required' => 'Password Konfirmasi diperlukan',
            'role.required' => 'Role wajib dipilih',
        ];

        $this->validUpdate = [
            'username' => 'required|string|max:30',
        ];

        $this->validPass = [
            'password' => 'required|string|max:30|min:10|unique:users,password|same:passConfirm|regex:/^(?:(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{10,})$/',
            'passConfirm' => 'required',
        ];
    }

    public function index()
    {
        $User = User::all();
        return view('user.indexUser', compact('User'));
    }

    public function detail($id)
    {
        $id = decrypt($id);
        $User = User::where('id_user', $id)->first();

        return view('user.detailUser', compact('User'));
    }

    public function create()
    {
        return view('user.createUser');
    }

    public function saveUser(Request $request)
    {
        $validator = Validator::make($request->all(), $this->validCreated, $this->ResponValid);
        if ($validator->fails()) {
            $request->session()->flash('message', $validator->errors()->first());
            $request->session()->flash('alert-type', 'error');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        User::insert([
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        $request->session()->flash('message', 'User berhasil ditambahkan');
        $request->session()->flash('alert-type', 'success');
        return redirect()->route('User')->withInput();
    }

    public function update($id)
    {
        $id = decrypt($id);
        $User = User::where('id_user', $id)->first();
        return view('user.updateUser', compact('User'));
    }

    public function updateUser(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            $this->validUpdate,
            $this->ResponValid
        );
        if ($validator->fails()) {
            $request->session()->flash('message', $validator->errors()->first());
            $request->session()->flash('alert-type', 'error');
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $id = decrypt($id);
        User::where('id_user', $id)->update([
            'username' => $request->username,
        ]);
        $request->session()->flash('message', 'Data User berhasil diupdate');
        $request->session()->flash('alert-type', 'success');
        return redirect()->route('User')->withInput();
    }

    public function delete($id, Request $request)
    {
        $id = decrypt($id);

        User::where('id_user', $id)->delete();

        $request->session()->flash('message', 'Data User berhasil didelete');
        $request->session()->flash('alert-type', 'success');
        return redirect()->route('User')->withInput();
    }

    public function changePass($id)
    {
        $id = decrypt($id);
        $User = User::where('id_user', $id)->first();
        return view('user.updatePassUser', compact('User'));
    }

    public function updatePass(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            $this->validPass,
            $this->ResponValid
        );
        if ($validator->fails()) {
            $request->session()->flash('message', $validator->errors()->first());
            $request->session()->flash('alert-type', 'error');
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $id = decrypt($id);
        User::where('id_user', $id)->update([
            'password' => Hash::make($request->password),
        ]);
        $request->session()->flash('message', 'Data User berhasil diupdate');
        $request->session()->flash('alert-type', 'success');
        return redirect()->route('User')->withInput();
    }
}
