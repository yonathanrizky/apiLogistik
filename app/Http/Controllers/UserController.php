<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at','desc')->paginate(10);
        return response()->json(['status'=>'success','data' => $users]);
    }

    public function store(Request $request)
    {
        $filename = null;

        if($request->hasFile('photo'))
        {
            $filename = Str::random(5).$request->email.'.jpg';
            $file = $request->file('photo');
            $file->move(base_path('public/images'),$filename);
        }

        User::create([
            'name' => $request->name,
            'identity_id' => $request->identity_id,
            'gender' => $request->gender,
            'address' => $request->address,
            'photo' => $filename,
            'email' => $request->email,
            'password' => app('hash')->make($request->password),
            'phone_number' => $request->phone_number,
            'role' => $request->role,
            'status' => $request->status
        ]);

        return response()->json(['status' => 'success']);
    }

    public function edit($id)
    {
        $users = User::find($id);
        return response()->json(['status' => 'success','data' => $users]);
    }

    public function update(Request $request, $id)
    {
        
        $user = User::find($id);

        $password = $request->password != '' ? app('hash')->make($request->password):$user->password;

        $filename = $user->photo;

        if($request->hasFile('photo'))
        {
            $filename = Str::random(5).$user->email.'.jpg';
            $file = $request->file('photo');
            $file->move(base_path('public/images'), $filename);
            unlink(base_path('public/images/'.$user->photo));
        }

        $user->update([
            'name' => $request->name,
            'identity_id' => $request->identity_id,
            'gender' => $request->gender,
            'address' => $request->address,
            'photo' => $filename,
            'password' => $password,
            'phone_number' => $request->phone_number,
            'role' => $request->role,
            'status' => $request->status
        ]);

        return response()->json(['status' => 'success']);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        unlink(base_path('public/images/'.$user->photo));
        $user->delete();
        return response()->json(['status' => 'success']);
    }
}