<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use App\Models\Reservation;
use App\Models\ReviewShop;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function shopDetail(Request $request, $shop_id)
    {
        $shop_detail = Shop::find($shop_id);
        $shop_review = ReviewShop::where('shop_id', $shop_detail->id)->where('user_id', Auth::id())->first();
        return view('shop_detail', compact('shop_detail', 'shop_id', 'shop_review'));
    }

    public function reservation(ReservationRequest $request)
    {
        $reservation_info = $request->all();
        $user_id = Auth::id();
        $reservation = Reservation::create([
            'user_id' => $user_id,
            'shop_id' => $request->shop_id,
            'reservation_date' => $request->reservation_date,
            'reservation_time' => $request->reservation_time,
            'reservation_number' => $request->reservation_number,
        ]);

        return view('done');
    }

    public function updateView(Request $request)
    {
        $reservation = Reservation::where('user_id', $request->user_id)->where('shop_id', $request->shop_id)->where('reservation_date', $request->reservation_date)->where('reservation_time', $request->reservation_time)->first();

        return view('reservation_update', compact('reservation'));
    }

    public function update(Request $request)
    {
        $update_info = $request->all();
        unset($update_info['_token']);
        Reservation::find($request->id)->update($update_info);

        return view('update_done');
    }

    public function remove(Request $request)
    {
        $reservation = Reservation::where('user_id', $request->user_id)->where('shop_id', $request->shop_id)->where('reservation_date', $request->reservation_date)->where('reservation_time', $request->reservation_time)->first()->delete();

        return redirect('/mypage');
    }
}
