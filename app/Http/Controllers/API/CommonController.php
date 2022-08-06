<?php

namespace App\Http\Controllers\API;

use App\Clients;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommonController extends Controller
{
    public function getClient()
    {
        $searchTerm = request()->input('searchTerm');
        $products = DB::table('topland.client_master')->select(DB::raw('client_id as id'), DB::raw("concat(client_name,' (',city_name,')') as text"))->join('topland.city_master', 'city_master.city_id', 'client_master.city_id')->whereRaw("(client_name like '%$searchTerm%') AND client_master.is_delete = 'N'")->orderBy('client_name', 'ASC')->limit(10)->get()->toArray();
        return response()->json($products);
    }

    public function getOnlyClient()
    {
        $searchTerm = request()->input('searchTerm');
        $extraSearch = request()->input('extraSearch');
        $string = '';
        if (!empty($extraSearch)) {
            $string = "AND parent_distributor = '$extraSearch'";
        }
        $products = DB::table('topland.client_master')->select(DB::raw('client_id as id'), DB::raw("concat(client_name,' (',city_name,')') as text"))->join('topland.city_master', 'city_master.city_id', 'client_master.city_id')->whereRaw("(client_name like '%$searchTerm%') AND client_master.is_delete = 'N' AND client_master.c_type = 'DEALER' $string")->orderBy('client_name', 'ASC')->limit(10)->get()->toArray();
        return response()->json($products);
    }

    public function getOnlyDistributor()
    {
        $searchTerm = request()->input('searchTerm');
        $products = DB::table('topland.client_master')->select(DB::raw('client_id as id'), DB::raw("concat(client_name,' (',city_name,')') as text"))->join('topland.city_master', 'city_master.city_id', 'client_master.city_id')->whereRaw("(client_name like '%$searchTerm%') AND client_master.is_delete = 'N' AND client_master.c_type = 'DISTRIBUTOR'")->orderBy('client_name', 'ASC')->limit(10)->get()->toArray();
        array_unshift($products, ['id' => '0', 'text' => 'Select Distributor']);
        return response()->json($products);
    }

    public function getTransport()
    {
        $searchTerm = request()->input('searchTerm');
        $products = DB::table('topland.transport_master')
            ->select(DB::raw('transport_id as id'), DB::raw("transport_name as text"))
            ->whereRaw("(transport_name like '%$searchTerm%') AND transport_master.is_delete = 'N'")
            ->orderBy('transport_name', 'ASC')->limit(10)->get()->toArray();
        return response()->json($products);
    }

    public function getCity()
    {
        $searchTerm = request()->input('searchTerm');
        $products = DB::table('topland.city_master')->select(DB::raw('city_id as id'), DB::raw("city_name as text"))->whereRaw("(city_name like '%$searchTerm%') AND city_master.is_delete = 'N'")->orderBy('city_name', 'ASC')->limit(10)->get()->toArray();
        return response()->json($products);
    }

    public function getSpareProduct()
    {
        $searchTerm = request()->input('searchTerm');
        $products = DB::table('topland.product_master')->select(DB::raw('product_id as id'), DB::raw("concat(product_name,' ',part_code) as text"))
            ->whereRaw("(product_name like '%$searchTerm%' OR part_code like '%$searchTerm%') AND product_master.is_delete = 'N'")
            ->orderBy('product_master.product_id', 'ASC')
            ->limit(30)->get()->toArray();
        return response()->json($products);
    }

    public function getSpareProductModel()
    {
        $searchTerm = request()->input('searchTerm');
        $products = DB::table('topland.product_master')->select(DB::raw('product_id as id'), DB::raw("concat(product_name,' ',part_code) as text"))
            ->whereRaw("(product_name like '%$searchTerm%' OR part_code like '%$searchTerm%') AND product_master.is_delete = 'N'")
            ->orderBy('product_master.product_id', 'ASC')->get()->toArray();
        return response()->json($products);
    }

    public function getDashBoardData()
    {
        $searchTerm = request()->input('type');
        if ($searchTerm == 'Client') {
            $clientlist = Clients::with('getCity')->where('is_delete', 'N')->get();
            ?>

            <table class="table table-striped- table-bordered table-hover table-checkable table-sm"
                   id="popUp-table">
                <thead>
                <tr>
                    <th>Client Name</th>
                    <th>City Name</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $i = 1;
                foreach ($clientlist as $row) { ?>
                    <tr>
                        <td align="center"><?php echo $row->client_name ?></td>
                        <td align="center"><?php echo $row->client_name ?></td>
                    </tr>
                <?php } ?>

                </tbody>
            </table>
            <?php
        }
    }

    public function getCategory()
    {
        $searchTerm = request()->input('searchTerm');
        $categoryList = DB::table('topland.category_master')
            ->select(DB::raw('category_id as id'), DB::raw("category_name as text"))
            ->whereRaw("(category_name like '%$searchTerm%') ")
            ->orderBy('category_name', 'ASC')->limit(30)->get()->toArray();
        return response()->json($categoryList);
    }

    public function getProductname()
    {
        $searchTerm = request()->input('searchTerm');
        $productList = DB::table('topland.product_master')
            ->select(DB::raw('product_id as id'), DB::raw("product_name as text"))
            ->whereRaw("(product_name like '%$searchTerm%') ")->limit(100)->get()->toArray();
        return response()->json($productList);
    }

    public function getClientName()
    {
        $searchTerm = request()->input('searchTerm');
        $client_name = DB::table('topland.client_master')
            ->select(DB::raw('client_id as id'), DB::raw("client_name as text"))
            ->whereRaw("(client_name like '%$searchTerm%') ")
            ->orderBy('client_name', 'ASC')->limit(50)->get()->toArray();
        return response()->json($client_name);
    }

    public function getComplainList()
    {
        $searchTerm = request()->input('searchTerm');
        $productList = DB::table('complain_item_details')
            ->select(DB::raw('complain as id'), DB::raw("complain as text"))
            ->whereRaw("(complain like '%$searchTerm%') ")->groupBy('complain')->limit(50)->get()->toArray();
        return response()->json($productList);
    }
}
