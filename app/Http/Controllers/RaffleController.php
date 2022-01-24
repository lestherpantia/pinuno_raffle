<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Set;
use Illuminate\Http\Request;

class RaffleController extends Controller
{
    public function index() {


        $getMembers = \DB::table('members')->select('id', 'name', 'address', 'iswinner')->get();
        $firstNumber = $getMembers->first()->id;
        $lastNumber = $getMembers->last()->id;


        $set = Set::orderBy('order')->get();
        $set->map(function($item, $key) use ($set) {

                $getCountOfWinners = Member::where('set_id', $item->id)->count();

                if($getCountOfWinners === $item->winners)
                {
                    $set->forget($key);
                }

                return $item;
            });


        $setInUse = $set->first() ?? Set::orderBy('order')->get();
        return view('draw', compact('getMembers', 'firstNumber', 'lastNumber', 'setInUse'));
    }

    public function markAsWinner(Request $request){
        $winner = Member::where('id', $request->id)->first();
        $winner->iswinner = 'Y';
        $winner->set_id = $request->set_id;
        $winner->save();
    }

    public function winners($setid) {
        $winners = \DB::table('members')->select('id','name', 'address')->where('iswinner', 'Y')->where('set_id', $setid)->orderBy('updated_at', 'desc')->get();
        return response()->json(['winners' => $winners], 200);
    }

}
