<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositorys\Mysqls\ProductMysql;
use App\Repositorys\Mysqls\CategoryMysql;
use App\Repositorys\Mysqls\ImageMysql;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    protected $productsMysql;
    protected $categorysMysql;
    protected $imagesMysql;
    public function __construct(ProductMysql $productsMysql,
                                CategoryMysql $categorysMysql,
                                ImageMysql $imagesMysql   ){
        $this->productsMysql=$productsMysql;
        $this->categorysMysql=$categorysMysql;
        $this->imagesMysql=$imagesMysql;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products=$this->productsMysql->getAll($request);
        $status_sum=$this->productsMysql->status_sum();
        return view('admin.products.list',compact('products','status_sum'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $result=$this->categorysMysql->getAll();    
       $categorys=$this->categorysMysql->cate_tree($result);
        return view('admin.products.add',compact('categorys'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
           
            $result_products=$this->productsMysql->create($request);
            if(!is_null($result_products)){
                $result=$this->isCheckFile($request,$result_products,$action='create');
                if(!$result){
                    
                    return back()->with([
                        'message'=>'Có lỗi,Thêm không thành công',
                        'class'=>'message-error'
                    ]);
                }else{
                   
                    return redirect()->route('products.list')->with([
                        'message'=>'Thêm thành công',
                        'class'=>'message-success'
            ]);
                }
            }else{
                
                return back()->with([
                    'message'=>'Có lỗi,Thêm không thành công',
                    'class'=>'message-error'
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
        $products=$this->productsMysql->getShow($id);
        $images=$this->imagesMysql->getId($id);
        return view('admin.products.show',compact('products','images'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $products=$this->productsMysql->getId($id);
        $result=$this->categorysMysql->getAll();    
       $categorys=$this->categorysMysql->cate_tree($result);
       
        return view('admin.products.edit',compact('categorys','products'));
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
        if($request->hasFile('img_link')){
            $result_products=$this->productsMysql->update($request,$id);
            if($result_products){
                $result=$this->isCheckFile($request,$id,$action='update');
                if(!$result){
        
                    return back()->with([
                        'message'=>'Có lỗi,Cập nhập không thành công',
                        'class'=>'message-error'
                    ]);
                }else{
                  
                    return redirect()->route('products.list')->with([
                        'message'=>'Cập nhập thành công',
                        'class'=>'message-success'
            ]);
                }
            }else{
                
                return back()->with([
                    'message'=>'Có lỗi,Cập nhập không thành công',
                    'class'=>'message-error'
                ]);
            }
        }else{
            $result_products=$this->productsMysql->update($request,$id);
            if(!$result_products){
                
                return back()->with([
                    'message'=>'Có lỗi,Cập nhập không thành công',
                    'class'=>'message-error'
                ]);
            }else{
                
                return redirect()->route('products.list')->with([
                    'message'=>'Cập nhập thành công',
                    'class'=>'message-success'
            ]);
        }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   $isCheck=$this->productsMysql->getId($id);
        if(!is_null($isCheck)){
            $result=$this->productsMysql->delete($id);
            
            if($result){
                $this->unlink($id);
                return redirect()->route('products.list')->with([
                    'message'=>'Xóa thành công',
                    'class'=>'message-success'
                ]);
            }
        }
        return redirect()->route('products.list')->with([
            'message'=>'Xóa không thành công',
            'class'=>'message-error'
         ]);

    }
    public function isCheckFile($request,$id_product,$action){
        
        $file_extension=['png','jpg','jpeg','gif'];
        if($request->hasFile('img_link')){
            //check exr file
            $file_item=$request->img_link;
           
           // foreach( $request->img_link as $file_item){ 
                $ext=$file_item->getClientOriginalExtension();
                if(!in_array($ext,$file_extension)){
                    return false;
                }
                if($action == 'create'){
                    $result=$this->imagesMysql->create($file_item->getClientOriginalName(),$id_product);
                    $file_item->storeAs('public/uploads',$file_item->getClientOriginalName());
                }elseif($action == 'update'){
                    $name_file=$this->imagesMysql->getId($id_product);
                    if(!is_null($name_file[0]->thumb)){
                        unlink('storage/uploads/'.$name_file[0]->thumb);
                    }
                    
                    $result=$this->imagesMysql->update($file_item->getClientOriginalName(),$id_product);
                    $file_item->storeAs('public/uploads',$file_item->getClientOriginalName());
                }
                if(!$result){
                    return false;
              }
                    
            //}
          
           
           return true;
            
        }else{
            return false;
        }
    }
    function unlink($id){
        $result=$this->imagesMysql->getId($id);
        if(!is_null($result)){
            $result_destroy= unlink('storage/uploads/'.$result[0]->thumb);
            if($result_destroy){
                return true;
            }
        }
        return false;
    }
  
}
