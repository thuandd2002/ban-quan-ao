<?php

namespace App\Http\Controllers;

use App\Http\Requests\danh_mucRequest;
use App\Models\Cart;
use App\Models\san_pham;
use Illuminate\Http\Request;
use App\Models\danh_mucs;
use Illuminate\Support\Facades\Session;
use phpDocumentor\Reflection\DocBlock\Description;
use phpDocumentor\Reflection\Element;

class AdminController extends Controller
{
    //
    private $v;
    public function __construct()
    {
        $this->v = [];
    }
    public function index()
    {
        $Category = new danh_mucs();
        $itemCate = $Category->loadListWithPager();
        $this->v['itemCate'] = $itemCate;
        //product
        $resPro = new san_pham();
        $product = $resPro->loadListWithPager();
        $this->v['product'] = $product;
        //
        $this->v['tieude'] = "Admin";
        $hoten = "Đinh Đức Thuận";
        $this->v['hoten'] = $hoten;
        return view('templates.index', $this->v);
    }

    //     public function loadList()
    //     {
    //         $this->v['title'] = "Danh sách danh mục";
    //         $danhmuc = new danh_mucs();
    //         $this->v['danhsachdanhmuc'] = $danhmuc->loadListWithPager();

    //         return view('admin.index', $this->v);
    //     }
    //     public function add(danh_mucRequest $request)
    //     {
    //         $this->v['_title'] = "Thêm danh mục";
    //         $method_route = 'route_BackEnd_danh_mucs_Add';
    //         if ($request->isMethod('POST')) {
    //             $param = [];
    //             $param['cols'] = $request->post();
    //             unset($param['cols']['_token']);
    //             //            dd($param['cols']);
    //             $modelAdd = new danh_mucs();
    //             $res = $modelAdd->saveNew($param);
    //             if ($res == null) {
    //                 return redirect()->route($method_route);
    //             } elseif ($res > 0) {
    //                 Session::flash('success', 'Thêm mới Danh mục thành công');
    //                 return redirect()->route($method_route);
    //             } else {
    //                 Session::flash('error', 'Thêm mới danh mục thất bại');
    //                 return redirect()->route($method_route);
    //             }
    //         }
    //         return view("admin.danh-muc.add", $this->v);
    //     }
    //     public function detail($id)
    //     {
    //         $this->v['_title'] = "Cập nhật danh mục";
    //         $item = new danh_mucs();
    //         $objItem = $item->loadOne($id);
    //         // dd($objItem);
    //         $this->v['objItem'] = $objItem;
    //         return view("admin.danh-muc.update", $this->v);
    //     }
    //     public function update($id, Request $request)
    //     {
    //         $method_route = "route_BackEnd_danh_mucs_Detail";
    //         $route_danhmuc = 'route_BackEnd_danh_mucs';
    //         $params = [];
    //         $params['cols'] = $request->post();
    //         unset($params['cols']['_token']);
    //         $detail = new danh_mucs();
    //         $objDetail = $detail->loadOne($id);
    //         $params['cols']['id'] = $id;
    //         $res = $detail->saveUpdate($params);
    //         if ($res == null) {
    //             return redirect()->route($method_route, ['id' => $id]);
    //         } elseif ($res == 1) {
    //             Session::flash('success', 'Cập nhật bản ghi ' . $objDetail->id . ' thành công');
    //             return redirect()->route($route_danhmuc);
    //         } else {
    //             Session::flash('error', 'Cập nhật bản ghi ' . $objDetail->id . ' thất bại');
    //             return redirect()->route($method_route, ['id' => $id]);
    //         }
    //     }
    //     public function delete($id){
    //         $data = danh_mucs::find($id);
    //         $data->delete();
    // //        dd($data);
    //         return redirect()->route('route_BackEnd_danh_mucs');

    //     }

    public function shop()
    {
        $Category = new danh_mucs();
        $itemCate = $Category->loadListWithPager();
        $this->v['itemCate'] = $itemCate;
        //
        $resPro = new san_pham();
        $product = $resPro->loadListWithPager();
        $this->v['product'] = $product;
        $this->v['tieude'] = "Admin";
        $hoten = "Đinh Đức Thuận";
        $this->v['hoten'] = $hoten;
        return view('templates.shop', $this->v);
    }
    public function detailCl()
    {
        $Category = new danh_mucs();
        $itemCate = $Category->loadListWithPager();
        $this->v['itemCate'] = $itemCate;
        $this->v['tieude'] = "Admin";
        $hoten = "Đinh Đức Thuận";
        $this->v['hoten'] = $hoten;
        return view('templates.detail', $this->v);
    }
    public function contact()
    {
        $Category = new danh_mucs();
        $itemCate = $Category->loadListWithPager();
        $this->v['itemCate'] = $itemCate;
        $this->v['tieude'] = "Admin";
        $hoten = "Đinh Đức Thuận";
        $this->v['hoten'] = $hoten;
        return view('templates.contact', $this->v);
    }
    public function checkout()
    {
        $Category = new danh_mucs();
        $itemCate = $Category->loadListWithPager();
        $this->v['itemCate'] = $itemCate;
        $this->v['tieude'] = "Admin";
        $hoten = "Đinh Đức Thuận";
        $this->v['hoten'] = $hoten;
        return view('templates.checkout', $this->v);
    }
    public function cart()
    {
        $Category = new danh_mucs();
        $itemCate = $Category->loadListWithPager();
        $this->v['itemCate'] = $itemCate;
        //
        $this->v['tieude'] = "Admin";
        $hoten = "Đinh Đức Thuận";
        $this->v['hoten'] = $hoten;
        return view('templates.cart', $this->v);
    }
    public function addtocart(Request $request ,$id){
        $Category = new danh_mucs();
        $itemCate = $Category->loadListWithPager();
        $this->v['itemCate'] = $itemCate;
        $itemCart = new san_pham();
        $item = $itemCart->loadOne($id);
        if ($item != null){
            $oldcart = Session('cart') ? Session('cart'):null;
            $newcart = new Cart($oldcart);
            $newcart ->addCart($item,$id);
            $request ->session()->put('cart', $newcart);

            $this->v['newcart'] = $newcart;
        }

        return view('templates.cart', $this -> v) ;
    }
}
