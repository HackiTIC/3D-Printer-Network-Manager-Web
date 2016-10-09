<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Storage;
use Laralum;
use File;
use Auth;
use App\Order;
use App\Queue;

class UsersController extends Controller
{
    public function showUpload()
    {
        return view('users.upload');
    }

    public function upload(Request $request)
    {

        $file = $request->file('file');

        $file_name = $file->getClientOriginalName();
        Storage::put($file_name, File::get($file));


        $order = new Order;
        $order->user_id = Auth::user()->id;
        $order->filename = $file_name;
        $order->price = null;
        $order->quality = $request->input('quality');
        $order->save();

        $queue = new Queue;
        $queue->order_id = $order->id;
        $queue->printer_id = null;
        $queue->state = 0;
        $queue->fails = 0;
        $queue->save();

        return redirect()->route('orders');
    }

    public function orders()
    {
        $orders = Auth::user()->orders;

        return view('users.orders', ['orders' => $orders]);
    }


}
