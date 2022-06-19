<?php
namespace App\Repositorys\Mysqls;
use Illuminate\Support\Facades\DB;

class ProductMysql{
   function getAll($request){
        $result= DB::table('products')->orderBy('id','DESC');
        if(!is_null($request->input('status'))){
            
             $result->where('status','=',$request->input('status'));
             
        }
        if(!is_null($request->input('search'))){
           
            $result->where('title','like','%'.$request->input('search').'%');
        }
        return $result->simplePaginate(10);
    }
    function status_sum(){
        return DB::table('products')->select(DB::raw(' status,count(status) as total'))
                                    ->groupBy('status')
                                    ->get();
    }
    function create($request){
        try {
            DB::beginTransaction();
            $last_id=DB::table('products')
                        ->insertGetId([
                            'title'=>$request->input('title'),
                            'price'=>$request->input('price'),
                            'category_id'=>$request->input('category'),
                            'quantity'=>$request->input('quantity'),
                            'description'=>$request->input('description'),
                            'status'=>$request->input('status'),
                            'created_at'=>date('Y-m-d H:i:s')
                        ]);
            DB::commit();
         

        } catch (\Exception $err) {
            DB::rollBack();
              return null;
        }
       return $last_id;
    }

    function getId($id){
        return DB::table('products')
                        ->join("images","products.id","=","images.product_id")
                        ->where('products.id',$id)
                        ->select('products.*','images.thumb')
                        ->get();
    }
    function getShow($id){
            return DB::table('products')
            ->join("categorys","products.category_id","=","categorys.id")
            ->where('products.id',$id)
            ->select('products.*','categorys.name')
            ->get();
    }
    function update($request,$id){
        try {
            DB::beginTransaction();
            DB::table('products')->where('id',$id)->update([
                'title'=>$request->input('title'),
                'price'=>$request->input('price'),
                'category_id'=>$request->input('category'),
                'quantity'=>$request->input('quantity'),
                'description'=>$request->input('description'),
                'status'=>$request->input('status'),
                'updated_at'=>date('Y-m-d H:i:s')
            ]);
          DB::commit();
        } catch (\Exception $err) {
            DB::rollBack();
            return false;
        }
        return true;
    }
    function delete($id){
        try {
            DB::beginTransaction();
            DB::table('products')->where('id',$id)->delete();
            DB::table('images')->where('product_id',$id)->delete();
            DB::commit();
        } catch (\Exception $err) {
            DB::rollBack();
            return false;
    
        }
        return true;
    }


}