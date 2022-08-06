<?php

namespace App\Http\Controllers;

use App\CaseSolution;
use App\Category;
use App\Support;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SupportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $support = DB::table('support')
            ->select('topland.category_master.category_name', 'support.*', 'support.faq_id')
            ->leftJoin('topland.category_master', 'topland.category_master.category_id', '=', 'support.category_id')
            ->get();
        return view('support.index')->with(compact('support'));
    }

    public function getData()
    {
        include app_path('Http/Controllers/SSP.php');

        /** DB table to use */
        $table = 'faq_view';

        /** Table's primary key */
        $primaryKey = 'faq_id';

        /** Array of database columns which should be read and sent back to DataTables.
         * The `db` parameter represents the column name in the database, while the `dt`
         * parameter represents the DataTables column identifier. In this case simple
         * indexes */
        $columns = array(
            array('db' => 'category_name', 'dt' => 0),
            array('db' => 'questions', 'dt' => 1),
            array('db' => 'solution', 'dt' => 2),
            array('db' => 'edit', 'dt' => 3),
            array('db' => 'delete', 'dt' => 4),
        );

        /** SQL server connection information */
        $sql_details = array(
            'user' => env('DB_USERNAME', 'root@localhost'),
            'pass' => env('DB_PASSWORD', ''),
            'db' => env('DB_DATABASE', 'helpdesk'),
            'host' => env('DB_HOST', '172.16.6.50')
        );

        /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
         * If you just want to use the basic configuration for DataTables with PHP
         * server-side, there is no need to edit below this line.
         */

        $dataRows = SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "");
        echo json_encode($dataRows);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::get();
        return view('support.create')->with('action', 'INSERT')->with('category', $category);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $support = new Support();
        $support->category_id = $request->input('category_id');
        $support->questions = $request->input('questions');
        $support->branch_id = Auth::user()->branch_id;
        $support->save();
        $request->session()->put('faq_id', $support->faq_id);
        return redirect('support-menu');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Support $support
     * @return \Illuminate\Http\Response
     */
    public function show(Support $support)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Support $support
     * @return \Illuminate\Http\Response
     */
    public function edit($faq_id)
    {
        $category = Category::get();
//        print_r($category);die();
        $support = Support::find($faq_id);
        return view('support.create')->with('action', 'UPDATE')->with('category', $category)->with('support', $support);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Support $support
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $support = Support::find($id);
        $support->category_id = $request->input('category_id');
        $support->questions = $request->input('questions');
        $support->branch_id = Auth::user()->branch_id;
        $support->save();
        $request->session()->put('faq_id', $support->faq_id);
        return redirect('support-menu');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Support $support
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Support::destroy($id);
        return redirect('support-menu');
    }

    public function question($category_id = 0)
    {

        $categories = Category::orderBy('category_name')
            ->get();
        $selectedCategory = empty($category_id) ? $categories[0]->category_id : $category_id;
        $question = DB::table('support')
            ->where('category_id', '=', $selectedCategory)
            ->get();
        $case = Support::with('getCase')->where('category_id', '=', $selectedCategory)
            ->get();
//        print_r($case);die();
        return view('support.question')->with(compact('categories', 'selectedCategory', 'question', 'case'));
    }

    public function searchForHelp()
    {
        $query = \request()->input('query');
        $resultItems = DB::table('case_solution')
            ->join('support', 'support.faq_id', 'case_solution.faq_id')
            ->select(['case_solution.case', 'case_solution.solution', 'support.questions'])
            ->whereRaw("`case` like '%$query%'")
//            ->whereRaw('"MATCH(case) AGAINST(? IN BOOLEAN MODE)"', $query)->orderBy('support.questions', 'ASC')
            ->get();
        $result = '<div class="quick-search-result">';
        if (empty($resultItems)) {
            $result .= '  <div class="text-muted d-none">No record found</div>';
        } else {
            $question = $resultItems[0]->questions;
            $result .= ' <div class="font-size-sm text-primary font-weight-bolder text-uppercase mb-2">' . $question . '</div><div class="mb-10">';
            foreach ($resultItems as $resultItem) {
                if ($resultItem->questions != $question) {
                    $question = $resultItem->questions;
                    $result .= '</div><div class="font-size-sm text-primary font-weight-bolder text-uppercase mb-2">' . $question . '</div><div class="mb-10">';
                }
                $result .= '<div class="d-flex align-items-center flex-grow-1 mb-2">
            <div class="symbol symbol-30  flex-shrink-0">
                <div class="symbol-label"
                     style="background-image:url(' . asset('metronic/assets/media/svg/files/doc.svg') . ')"></div>
            </div>
            <div class="d-flex flex-column ml-3 mt-2 mb-2">
                <a href="#" class="font-weight-bold text-dark text-hover-primary">
                   ' . $resultItem->case . '
                </a>
                <span class="font-size-sm font-weight-bold text-muted">
                ' . $resultItem->solution . '
                </span>
            </div>
        </div>';
            }
            $result .= '</div>';
        }

        $result .= '</div>';
        return response($result);
    }
}

