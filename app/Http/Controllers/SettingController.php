<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Set;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $setOfDraws = Set::orderBy('order')
            ->get()
            ->map(function($item, $key) {
                $item->winnerCount = Member::where('set_id', $item->id)->count();
                return $item;
            });

        return view('settings', compact('setOfDraws'));
    }

    public function addset(Request $request) {

        $checkIfOrderAlreadySet = Set::where('order', $request->order)->first();
        if($checkIfOrderAlreadySet) {
            return response()->json(['msg' => 'Order Already Set'], 422);
        }

        $saveSet = new Set();
        $saveSet->set_name = $request->set_name;
        $saveSet->winners = $request->winner;
        $saveSet->order = $request->order;
        $saveSet->save();

        return response()->json(['msg' => 'Data save successfully!', 200]);

    }
}
