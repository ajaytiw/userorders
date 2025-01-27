<?php

namespace App\Http\Controllers;

use App\Models\{Order,User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users_id = $request->user_id;
        $query = Order::query();

        if ($request->has('search')) {
            $query->where('order_name', 'like', '%' . $request->search . '%');
        }

        if ($users_id) {
            $query->where('user_id', $users_id);
        }

        $orders = $query->paginate(5); 
        $users = User::all();

        return view('frontend.orders.index', compact('orders','users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return view('frontend.orders.create',compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {      
        // $request->validate([
        //     'name'=>'required', 
        //     'assigned_to'=>'required',
        // ]);

        $validation = Validator::make($request->all(),[ 
            'name'=>'required', 
            'assigned_to'=>'required',
        ]);

        if($validation->fails()){
            return response()->json(['success'=>'false', 'data'=> $validation->errors()->toArray()]);
        }else{
            $order = new Order();
            $order->order_name = $request->name;
            $order->user_id = $request->assigned_to;

            try {
                $order->save();
                return response()->json(['success'=>'true','message' => 'Order created successfully!']);
            } catch (\Throwable $th) {
                return response()->json(['success'=>'false']);
                
            }
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {

        // $request->validate([
        //     'name' => 'required|string|max:255',  
        //     'assigned_to' => 'required',
        // ]);
        $validation = Validator::make($request->all(),[ 
            'name' => 'required|string|max:255',  
            'assigned_to' => 'required',
       ]);

        if($validation->fails()){
            return response()->json(['success'=>'false', 'data'=> $validation->errors()->toArray()]);
        }else{

            $order = Order::find($request->id);
            $order->order_name = $request->name;
            $order->user_id = $request->assigned_to;  
            try {
                $order->save();
                return response()->json(['success'=>'true','message' => 'Order Updated successfully!']);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        try {
            $order->delete();
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
        $this->alert('Success','Order deleted successfully','success');
        return redirect()->route('orders.index');
    }
}
