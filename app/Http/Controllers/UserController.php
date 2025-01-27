<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $query = User::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        if ($request->has('order_count')) {
            if ($request->order_count == 'no_orders') {
                $query->doesntHave('orders');
            } elseif ($request->order_count == 'one') {
                $query->has('orders', '=', 1);
            } elseif ($request->order_count == 'greater_than_one') {
                $query->has('orders', '>', 1);
            }
        }
        
        $users = $query->paginate(5);


        return view('frontend.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required', 
            'email'=>'required|email',
            'password'=>'required|min:5',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        try {
            $user->save();
            return response()->json(['success'=>'User created successfully.']);

        } catch (\Throwable $th) {
            return response()->json(['error'=>$th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'name'=>'required', 
            'email'=>'required|email',
            'password'=>'nullable|min:5',
        ]);

        $user = User::find($request->id);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->edit_password);
        }

        try {
            $user->save();
            return response()->json(['success' => 'User updated successfully.']);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $user = User::find($id);
        try {
            $user->delete();
            $this->alert('Success','User deleted successfully.','success');
        } catch (\Throwable $th) {
            $this->alert('Error','Something went wrong.','error');
        }
        return redirect()->back();
    }
}
