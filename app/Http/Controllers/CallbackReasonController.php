<?php

namespace App\Http\Controllers;

use App\ReplacementExpense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CallbackReasonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($expense_id,Request $request)
    {
        $request->session()->put('expense_id',$expense_id);
        $callback = ReplacementExpense::where('expense_id', $expense_id)->first();
        return view('replacementexpense.callback_reason')->with('action', 'INSERT')->with(compact('expense_id', 'callback'));
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $expense_id = $request->session()->get('expense_id');
        $callback = ReplacementExpense::find($expense_id);
        $callback->reason_for_callback = $request->input('reason_for_callback');
        $callback->remark = $request->input('remark');
        if (!empty($callback->reason_for_callback)) {
            DB::table('replacement_expense')->where('expense_id', '=', $expense_id)->update(['status' => 'send to service station']);
        } else {
            DB::table('replacement_expense')->where('expense_id', '=', $expense_id)->update(['status' => 'solve']);
        }
        $callback->save();
        $request->session()->flash('create-status', 'Callback Reason  Successfully Add...');
        return redirect('callback-reason/' . $expense_id);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
