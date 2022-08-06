<?php

namespace App\Http\Controllers;

use App\ChallanProduct;
use App\FinancialYear;
use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ImageController extends Controller
{
    private $pageType;

    public function __construct()
    {

        $this->pageType = 'Image';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($challan_product_id,Request $request)
    {
        $request->session()->put('challan_product_id',$challan_product_id);
        $challan_id = DB::table('challan_item_master')->select('challan_id')->where('challan_product_id','=',$challan_product_id)->first();
        $productDetail = DB::table('challan_item_master')
            ->select('topland.product_master.product_name', 'challan_item_master.*')
            ->leftjoin('topland.product_master', 'topland.product_master.product_id', '=', 'challan_item_master.product_id')
            ->leftJoin('challan', 'challan.challan_id', '=', 'challan_item_master.challan_id')
            ->where('challan_item_master.challan_id', '=', $challan_id->challan_id)
            ->get();

        $imageDetail = DB::table('challan_image')
            ->select('topland.product_master.product_name', 'challan_image.image_name','challan_image.*')
            ->leftjoin('challan_item_master', 'challan_item_master.challan_id', '=', 'challan_image.challan_id')
            ->leftjoin('topland.product_master', 'topland.product_master.product_id', '=', 'challan_item_master.product_id')
            ->leftjoin('challan', 'challan.challan_id', '=', 'challan_image.challan_id')
            ->where('challan_image.challan_product_id', '=', $challan_product_id)
            ->get();
        return view('challan.image')->with('action', 'INSERT')->with(compact('challan_id', 'productDetail', 'imageDetail', 'challan_product_id'));

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

    public function multifileupload()
    {

    }

    public function saveFile(Request $request)
    {
        $challan_id = $request->session()->get('challan_id');
        $challan_product_id = $request->session()->get('challan_product_id');

        if (isset($challan_product_id)) {
            $image = $request->file('file');
            $imageName = $image->getClientOriginalName();
            $upload_success = $image->move(public_path('images/challan/'), $imageName);

            $financialYear =FinancialYear::where('is_active','Y')->first();

            $imageUpload = new Image();
            $imageUpload->financial_id = $financialYear->financial_id;
            $imageUpload->challan_id = $challan_id;
            $imageUpload->challan_product_id = $challan_product_id;
            $imageUpload->image_name = $imageName;
            $imageUpload->created_id = Auth::user()->user_id;
            $imageUpload->branch_id = Auth::user()->branch_id;
            $imageUpload->save();
            return response()->json(['success' => 'Image uploaded successfully'], 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $challan_product_id = $request->session()->get('challan_product_id');
        if ($request->ajax()) {
            $request->session()->put('challan_id', $request->input('challan_id'));
            return response()->json(['success' => 'Session created'], 200);
        } else {
            $request->session()->flash('challan_id');
            $request->session()->flash('create-status', 'Image uploaded successfully.');
            return redirect('challan-image/'.$challan_product_id);
        }
    }

    public function removeFile(Request $request)
    {
        $challan_id = $request->session()->get('challan_id');
        $challan_product_id = $request->session()->get('challan_product_id');

        if (isset($challan_product_id)) {
//            if (@unlink(public_path('images/challan/' . $request->post('image_name')))) {
                DB::table('challan_image')->where('challan_id', $challan_id)->where('image_name', $request->post('image_name'))->delete();
                return response()->json(['success' => 'Image deleted successfully'], 200);
//            } else {

//            }
            return response()->json(['error' => 'Select Product first'], 401);

        } else {
            return response()->json(['error' => 'Select Product first'], 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Image $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Image $image
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Image $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Image $image
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $challan_product_id = $request->session()->get('challan_product_id');
        $image = Image::all()->find($id);

//        if (@unlink(public_path('images/challan/' . $image->image_name))) {
            Image::destroy($id);
//        }
        $request->session()->flash('delete-status', 'Image Deleted successfully.');
        return redirect('challan-image/'.$challan_product_id);
    }
}
