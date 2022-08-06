<?php

namespace App\Http\Controllers;

use App\Branch;
use App\CompanyMaster;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_detail = DB::table('users')
            ->select('company_name','branch_master.branch_name','role_name','name','users.*')
            ->leftJoin('branch_master','branch_master.branch_id','=','users.branch_id')
            ->leftJoin('company_master','company_master.company_id','=','branch_master.company_id')
            ->leftJoin('role','role.role_id','=','users.role_id')
            ->orderByDesc('user_id')
            ->get();
        return view('users.index')->with(compact('user_detail'));
    }

    public function getData()
    {
        include app_path('Http/Controllers/SSP.php');

        /** DB table to use */
        $table = 'user_master_view';

        /** Table's primary key */
        $primaryKey = 'user_id';

        /** Array of database columns which should be read and sent back to DataTables.
         * The `db` parameter represents the column name in the database, while the `dt`
         * parameter represents the DataTables column identifier. In this case simple
         * indexes */
        if (in_array(Auth::user()->role_id, [1])) {
            $columns = array(
                array('db' => 'company_name', 'dt' => 0),
                array('db' => 'branch_name', 'dt' => 1),
                array('db' => 'user_type', 'dt' => 2),
                array('db' => 'user_name', 'dt' => 3),
                array('db' => 'email', 'dt' => 4),
                array('db' => 'edit', 'dt' => 5),
                array('db' => 'delete', 'dt' => 6),
            );
        } elseif (in_array(Auth::user()->role_id, [2])) {
            $columns = array(
                array('db' => 'company_name', 'dt' => 0),
                array('db' => 'branch_name', 'dt' => 1),
                array('db' => 'user_type', 'dt' => 2),
                array('db' => 'user_name', 'dt' => 3),
                array('db' => 'email', 'dt' => 4),
                array('db' => 'edit', 'dt' => 5),
            );
        }

        /** SQL server connection information */
        $sql_details = array(
            'user' => env('DB_USERNAME', 'root@localhost'),
            'pass' => env('DB_PASSWORD', ''),
            'db' => env('DB_DATABASE', 'helpdesk'),
            'host' => env('DB_HOST', '172.16.14.121')
        );

        /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
         * If you just want to use the basic configuration for DataTables with PHP
         * server-side, there is no need to edit below this line.
         */

        $dataRows = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns);
        echo json_encode($dataRows);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companyList = CompanyMaster::get();
        $roleList = Role::get();
        return view('users.create')->with('action', 'INSERT')->with(compact('companyList', 'roleList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'company_id.required' => 'Please Select Company Name',
            'branch_id.required' => 'Please Select Branch Name',
            'role_id.required' => 'Please Select Role Name',
        ];
        $rules = [
            'company_id' => 'required',
            'branch_id' => 'required',
            'role_id' => 'required',
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ];
        Validator::make($request->all(), $rules, $messages)->validate();
        $users = new User();
        $users->company_id = $request->input('company_id');
        $users->branch_id = $request->input('branch_id');
        $users->role_id = $request->input('role_id');
        $users->name = $request->input('name');
        $users->email = $request->input('email');
        $users->password = Hash::make($request->input('password'));
        $users->save();
        $request->session()->flash('create-status', 'User Successful Created...');
        return redirect('users');
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
        $companyList = CompanyMaster::get();
        $roleList = Role::get();
        $users = User::find($id);
        return view('users.create')->with('action', 'UPDATE')->with(compact('companyList', 'roleList', 'users'));
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
        $messages = [
            'company_id.required' => 'Please Select Company Name',
            'branch_id.required' => 'Please Select Branch Name',
            'role_id.required' => 'Please Select Role Name',
        ];
        $rules = [
            'company_id' => 'required',
            'branch_id' => 'required',
            'role_id' => 'required',
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ];
        Validator::make($request->all(), $rules, $messages)->validate();

        $users = User::find($id);
        $users->branch_id = $request->input('branch_id');
        $users->role_id = $request->input('role_id');
        $users->name = $request->input('name');
        $users->email = $request->input('email');
        $users->save();
        $request->session()->flash('update-status', 'User Successful Updated...');
        return redirect('users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        User::destroy($id);
        $request->session()->flash('delete-status', 'User Successful Deleted...');
        return redirect('users');
    }

    public function getBranch()
    {
        $company_id = request()->input('company_id');
        $companyList = DB::table('branch_master')
            ->select(DB::raw('company_master.company_id as id'),
                DB::raw('branch_master.branch_name as text'))
            ->leftJoin('company_master', 'company_master.company_id', '=', 'branch_master.company_id')
            ->where('company_master.company_id', '=', $company_id)
            ->get();

        $options = '<option value="">Select Branch Name</option>';
        foreach ($companyList as $item) {
            $options .= '<option value="' . $item->id . '">' . $item->text . '</option>';
        }
        return response($options);
    }
}
