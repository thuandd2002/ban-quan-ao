<?php

namespace App\Http\Controllers;

use App\Http\Requests\SanPhamRequest;
use App\Models\Banner;
use App\Models\danh_mucs;
use App\Models\san_pham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BannerController extends Controller
{
    private $v;
    public function __construct()
    {
        $this->v = [];
    }
    public function loadList(){
        $this->v['title'] = "Danh sách banner";
        $item = new Banner();
        $listBanner = $item->loadListWithPager();
        $this->v['listbanner'] = $listBanner;
        return view('admin.banner.index', $this->v);
    }
    public function add(Request $request)
    {


        $this->v['_title'] = "Thêm sản banner";
        $method_route = 'route_BackEnd_banner_Add';
        if ($request->isMethod('POST')) {
            $param = [];
            $param['cols'] = $request->post();
            unset($param['cols']['_token']);

            if ($request->hasFile('cmt_mat_truoc') && $request->file('cmt_mat_truoc')->isValid()) {
                $param['cols']['image'] = $this->uploadFile($request->file('cmt_mat_truoc'));
            }
            $modelAdd = new Banner();
            $res = $modelAdd->saveNew($param);
            if ($res == null) {
                return redirect()->route($method_route);
            } elseif ($res > 0) {
                Session::flash('success', 'Thêm mới Sản phẩm thành công');
                return redirect()->route($method_route);
            } else {
                Session::flash('error', 'Thêm mới sản phẩm thất bại');
                return redirect()->route($method_route);
            }
        }
        return view("admin.banner.add", $this->v);
    }
    public function uploadFile($files)
    {
        $filesName = time() . '-' . $files->getClientOriginalName();
        return $files->storeAs('imgProduct', $filesName, 'public');
    }
    public function detail($id)
    {
        $this->v['_title'] = "Cập nhật banner";
        $item = new Banner();
        $objItem = $item->loadOne($id);
        // dd($objItem);
        $this->v['objItem'] = $objItem;
        return view("admin.banner.update", $this->v);
    }
    public function update($id, Request $request)
    {

        $method_route = "route_BackEnd_banner_Detail";
        $route_sanpham = 'route_BackEnd_banner';
        $params = [];
        $params['cols'] = $request->post();
        unset($params['cols']['_token']);
        if ($request->hasFile('cmt_mat_truoc') && $request->file('cmt_mat_truoc')->isValid()) {
            $params['cols']['image'] = $this->uploadFile($request->file('cmt_mat_truoc'));
        }
        $detail = new Banner();
        $objDetail = $detail->loadOne($id);
        $params['cols']['id'] = $id;
        $res = $detail->saveUpdate($params);
        if ($res == null) {
            return redirect()->route($method_route, ['id' => $id]);
        } elseif ($res == 1) {
            Session::flash('success', 'Cập nhật bản ghi ' . $objDetail->id . ' thành công');
            return redirect()->route($route_sanpham);
        } else {
            Session::flash('error', 'Cập nhật bản ghi ' . $objDetail->id . ' thất bại');
            return redirect()->route($method_route, ['id' => $id]);
        }
    }
    public function delete($id)
    {
        $data = Banner::find($id);
        $data->delete();
        //        dd($data);
        return redirect()->route('route_BackEnd_banner');
    }
}
