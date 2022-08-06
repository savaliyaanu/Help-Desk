<?php

namespace App\Http\Controllers;

use App\ServiceStationMaster;
use Illuminate\Http\Request;

class ServiceStationMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ServiceStationMaster::get();
        return view('serviceMaster.index')->with(compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('serviceMaster.create')->with('action', 'INSERT');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $station = new ServiceStationMaster();
        $station->station_name = $request->input('station_name');
        $station->station_address = $request->input('station_address');
        $station->contact_no = $request->input('contact_no');
        $station->email = $request->input('email');
        $station->contact_person_name = $request->input('contact_person_name');
        $station->save();
        return redirect('service-station-detail');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ServiceStationMaster  $serviceStationMaster
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceStationMaster $serviceStationMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ServiceStationMaster  $serviceStationMaster
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $station =ServiceStationMaster::find($id);
        return view('serviceMaster.create')->with('action', 'UPDATE')->with(compact('station'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ServiceStationMaster  $serviceStationMaster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $station = ServiceStationMaster::find($id);
        $station->station_name = $request->input('station_name');
        $station->station_address = $request->input('station_address');
        $station->contact_no = $request->input('contact_no');
        $station->email = $request->input('email');
        $station->contact_person_name = $request->input('contact_person_name');
        $station->save();
        return redirect('service-station-detail');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ServiceStationMaster  $serviceStationMaster
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ServiceStationMaster::destroy($id);
        return redirect('service-station-detail');
    }
}
