<?php

namespace App\Http\Controllers;

use App\CaseSolution;
use App\Support;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\DocBlock\Tags\InvalidTag;

class CaseSolutionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($faq_id)
    {

        $case_solution = DB::table('case_solution')
            ->leftJoin('support', 'support.faq_id', '=', 'case_solution.faq_id')
            ->where('case_solution.faq_id', '=', $faq_id)
            ->groupBy('case_solution.case')
            ->get();

        return view('support.casesolution')->with('action', 'INSERT')->with(compact( 'case_solution'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $faq_id = $request->session()->get('faq_id');
        $case_solution = new CaseSolution();
        $case_solution->faq_id = $faq_id;
        $case_solution->case = $request->input('case');
        $case_solution->solution = $request->input('solution');
        $case_solution->parts = $request->input('parts');
        $case_solution->save();
        return redirect('solution/' . $faq_id);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\CaseSolution $caseSolution
     * @return \Illuminate\Http\Response
     */
    public function show(CaseSolution $caseSolution)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\CaseSolution $caseSolution
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $faq_id = $request->session()->get('faq_id');
        $case_solution = CaseSolution::leftJoin('support', 'support.faq_id', '=', 'case_solution.faq_id')
            ->where('case_solution.faq_id', '=', $faq_id)
            ->get();;
        $questions = DB::table('support')
            ->leftJoin('case_solution', 'case_solution.faq_id', '=', 'support.faq_id')
            ->where('case_solution.faq_id', '=', $faq_id)
            ->get();
//print_r($case_solution);die();
        return view('support.casesolution')->with('action', 'UPDATE')->with('questions', $questions)->with('case_solution', $case_solution);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\CaseSolution $caseSolution
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $faq_id = $request->session()->get('faq_id');
        $case_solution = CaseSolution::find($id);
        $case_solution->case = $request->input('case');
        $case_solution->solution = $request->input('solution');
        $case_solution->save();
        return redirect('case-solution/' . $faq_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\CaseSolution $caseSolution
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        CaseSolution::destroy($id);
        return redirect('case-solution/create');
    }
}
