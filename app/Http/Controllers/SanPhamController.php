<?php

namespace App\Http\Controllers;

use App\Http\Requests\SanPhamRequest;
use Illuminate\Http\Request;
use App\Models\danh_mucs;
use App\Models\san_pham;
use Illuminate\Support\Facades\Session;
use phpDocumentor\Reflection\DocBlock\Description;
use phpDocumentor\Reflection\Element;

class SanPhamController extends Controller
{
    //
    private $v;
    public function __construct()
    {
        $this->v = [];
    }
    public function index()
    {
        $this->v['tieude'] = "Admin";
        $hoten = "Đinh Đức Thuận";
        $this->v['hoten'] = $hoten;
        return view('templates.index', $this->v);
    }

    public function loadList()
    {
        $this->v['title'] = "Danh sách sản phẩm";
        $sanpham = new san_pham();
        $this->v['danhsachsanpham'] = $sanpham->loadListWithPager();

        return view('admin.san-pham.index', $this->v);
    }
    public function add(SanPhamRequest $request)
    {
        $danhmuc = new danh_mucs();
        $listdm = $danhmuc->loadListWithPager();
        $this->v['listdm'] = $listdm;
        $this->v['_title'] = "Thêm sản phẩm";
        $method_route = 'route_BackEnd_san_pham_Add';
        if ($request->isMethod('POST')) {
            $param = [];
            $param['cols'] = $request->post();
            unset($param['cols']['_token']);
            //            dd($param['cols']);
            if ($request->hasFile('cmt_mat_truoc') && $request->file('cmt_mat_truoc')->isValid()) {
                $param['cols']['image'] = $this->uploadFile($request->file('cmt_mat_truoc'));
            }
            // dd($param['cols']);
            $modelAdd = new san_pham();
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
        return view("admin.san-pham.add", $this->v);
    }
    public function detail($id)
    {
        $this->v['_title'] = "Cập nhật danh mục";
        $item = new san_pham();
        $objItem = $item->loadOne($id);
        // dd($objItem);
        $this->v['objItem'] = $objItem;
        return view("admin.san-pham.update", $this->v);
    }
    public function update($id, Request $request)
    {
        $method_route = "route_BackEnd_san_pham_Detail";
        $route_sanpham = 'route_BackEnd_san_pham';
        $params = [];
        $params['cols'] = $request->post();
        unset($params['cols']['_token']);
        $detail = new san_pham();
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
        $data = san_pham::find($id);
        $data->delete();
        //        dd($data);
        return redirect()->route('route_BackEnd_san_pham');
    }
    public function uploadFile($files)
    {
        $filesName = time() . '-' . $files->getClientOriginalName();
        return $files->storeAs('imgProduct', $filesName, 'public');
    }
}
