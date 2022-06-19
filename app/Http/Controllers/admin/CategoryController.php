<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositorys\Mysqls\CategoryMysql;

class CategoryController extends Controller
{
    protected $categoryMysql;
    public function __construct(CategoryMysql $categoryMysql ){
        $this->categoryMysql=$categoryMysql;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $button='Thêm';
        $name='';
        $cate_id=0;
        $categorys=$this->categoryMysql->cate_tree($this->categoryMysql->getAll());
        return view('admin.categorys.list',compact('categorys','button','name','cate_id'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result=$this->categoryMysql->create($request);
        if(!$result){
            return back()->with([
                'message'=>'Có lỗi,Thêm không thành công',
                'class'=>'message-error'
            ]);
        }else{
            return redirect()->route('categorys.list')->with([
                'message'=>'Thêm thành công',
                'class'=>'message-success'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $button='Cập nhập';
        $categorys_item=$this->categoryMysql->getId($id);
       
        $name=$categorys_item[0]->name;
        $cate_id=$categorys_item[0]->id_category;
        $categorys=$this->categoryMysql->cate_tree($this->categoryMysql->getAll());
        return view('admin.categorys.list',compact('categorys','name','cate_id','button'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $result=$this->categoryMysql->update($request,$id);
        if(!$result){
            return back()->with([
                'message'=>'Có lỗi,Cập nhập không thành công',
                'class'=>'message-error'
            ]);
        }else{
            return redirect()->route('categorys.list')->with([
                'message'=>'Cập nhập thành công',
                'class'=>'message-success'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categorys_parent=$this->categoryMysql->getIdParent($id);
        if(count($categorys_parent) > 0){
            return back()->with([
                'message'=>'Có lỗi,Xóa không thành công,Danh mục này đang có danh mục con',
                'class'=>'message-error'
            ]);
        }
        $result=$this->categoryMysql->delete($id);
        if(!$result){
            return back()->with([
                'message'=>'Có lỗi,Xóa không thành công',
                'class'=>'message-error'
            ]);
        }else{
            return redirect()->route('categorys.list')->with([
                'message'=>'Xóa thành công',
                'class'=>'message-success'
            ]);
        }
    }
  
}
