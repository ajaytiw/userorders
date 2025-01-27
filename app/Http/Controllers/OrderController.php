<?php

namespace App\Http\Controllers;

use App\Models\{Order,User};
use Illuminate\Http\Request;

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

        if ($request->has('search') && $request->search != '') {
            $orders = Order::where('order_name', 'like', '%' . $request->search . '%')
                ->paginate(5);
                $users = User::all();
        }else{
            $orders = Order::paginate(5);
            $users = User::all();
        }

        if ($users_id) {
            $query->whereIn('user_id', (array) $users_id); // Cast to array if needed
        }
        $orders = $query->paginate(5); // Adjust the pagination as needed
    

        return view('frontend.orders.index', compact('orders','users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'assigned_to'=>'required',
        ]);

        $order = new Order();
        $order->order_name = $request->name;
        $order->user_id = $request->assigned_to;

        try {
            $order->save();
            return response()->json(['success'=>'Order created successfully.']);
        } catch (\Throwable $th) {
            return response()->json(['error'=>$th->getMessage()]);
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

        $request->validate([
            'name' => 'required|string|max:255',  
            'assigned_to' => 'required',
        ]);
    
        try {
            $order->order_name = $request->name;
            $order->user_id = $request->assigned_to;  
    
            $order->save();
    
            return response()->json(['success' => 'Order updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
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
