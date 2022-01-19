<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class RaffleController extends Controller
{
    public function index() {


        $getMembers = \DB::table('members')->select('id', 'name', 'address', 'iswinner')->get();
        $firstNumber = $getMembers->first()->id;
        $lastNumber = $getMembers->last()->id;


        return view('draw', compact('getMembers', 'firstNumber', 'lastNumber'));
    }

    public function markAsWinner(Request $request){
        $winner = Member::where('id', $request->id)->first();
        $winner->iswinner = 'Y';
        $winner->save();
    }

    public function winners() {
        $winners = \DB::table('members')->select('id','name', 'address')->where('iswinner', 'Y')->orderBy('updated_at', 'desc')->get();
        return response()->json(['winners' => $winners], 200);
    }

}
