<?php

namespace App\Http\Controllers\dashboard;

use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{



    public function __construct(){
        $this->middleware(['permission:users-read'])->only('index');
        $this->middleware(['permission:users-create'])->only('create');
        $this->middleware(['permission:users-update'])->only('edit');
        $this->middleware(['permission:users-delete'])->only('destroy');
    }


   
    public function index(Request $request){
        // if ($request->search) {
        //     $users = User::where('first_name' , 'like' , '%' . $request->search . '%')->orWhere('last_name' , 'like' , '%' . $request->search . '%')->get(); 
        // }else{
        //     $users = User::whereHasRole('admin')->get();
        // }

            $users = User::whereHasRole('admin')->where(function($q) use ($request) {

                return $q->when($request->search , function($query) use ($request){
                    return $query->where('first_name' , 'like' , '%' . $request->search . '%')
                    ->orWhere('last_name', 'like' , '%' . $request->search . '%');
                });


            })->paginate(5);

        return view('dashboard.users.index' , compact("users"));
    }



    public function create(){
        $permissions = Permission::all();
        return view('dashboard.users.create' , compact("permissions"));
    }



    public function store(Request $request){
        // dd($request->permissions);


        $request->validate([
            "first_name" => 'required',
            "last_name" => 'required',
            "email" => 'required|unique:users,email',
            "password" => 'required|confirmed',
            "image" => 'image',
            "permissions" => 'required'
            // "password_confirmation" => 'required',
        ]);


        // $editUserPermission = Permission::where('name', $request->permissions )->first();


        $request_data = $request->except(['password' , 'password_confirmation' , 'permissions' , 'image']);

        $request_data['password'] = bcrypt($request->password);

        if ($request->image) {
            Image::make($request->image)
            ->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->save(public_path('uploads/user_images/' . $request->image->hashName()));
            $request_data['image'] = $request->image->hashName();
        }

        $user = User::create($request_data);
        // $user = User::latest()->first();

        $user->addRole('admin');
        foreach($request->permissions as $permission)
        {
            $user->givePermission($permission);
        }
        
        session()->flash('success' , __('site.added_successfully'));

        return redirect()->route('dashboard.users.index');

    }


   
    public function edit(User $user){
        return view('dashboard.users.edit' , compact('user'));
    }



    public function update(Request $request ,User $user){

        $request->validate([
            "first_name" => 'required',
            "last_name" => 'required',
            "email" => 'required',
            "image" => 'image',
            "permissions" => 'required'
        ]);

        $request_data = $request->except(['permissions' , 'image']);

        if ($request->image) {
            if($user->image != 'default.png'){

                unlink('uploads/user_images/' . $user->image);

            }

            Image::make($request->image)
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(public_path('uploads/user_images/' . $request->image->hashName()));
                $request_data['image'] = $request->image->hashName();

        }

        // $user = User::FindOrFail($id);

        $user->update($request_data);

        // foreach($request->permissions as $permission)
        // {
            $user->syncPermissions($request->permissions);
        // }

        session()->flash('success' , __('site.updated_successfully'));

        return redirect()->route('dashboard.users.index');
        
    }

    
    public function destroy(User $user){

        if ($user->image != 'default.png') {

            // Storage::delete('uploads/user_images/' . $user->image);
            unlink('uploads/user_images/' . $user->image);

        }//end of if         
        

        $user->delete();

        session()->flash('success' , __('site.deleted_successfully'));

        return redirect()->route('dashboard.users.index');

    }
}
