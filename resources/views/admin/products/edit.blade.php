@extends('admin.layouts.layout')
@section('content')
<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">Cập nhập sản phẩm</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    @if (session('message'))
    <div class="custom_message {{session('class')}}" ><h5 class="text-message">{{session('message')}}</h5></div>
    @endif
    <form method="post" enctype="multipart/form-data" id="form-edit-products" >
      @foreach ($products as $item)
          
      
      @csrf
      <div class="card-body">

        <div class="row">
            <div class="col col-ms-6">
                <div class="form-group">
                  <label for="products_name">Tên sản phẩm</label>
                  <input type="text" class="form-control" name="title" id="products_name" value="{{$item->title}}" placeholder="Tên sản phẩm...">
                  <span class="form-message"></span>
                </div>
            </div>
           <div class="col col-ms-6">
                <div class="form-group">
                  <label >Danh mục</label>
                  <select name="category" class="form-control" id="categorys" >
                    <option value="">--Danh mục--</option>
                    @foreach ($categorys as $category)
                      <option value="{{$category->id}}" {{ $item->category_id == $category->id ? 'selected' : '' }} >
                        {{str_repeat('--', $category->level ).$category->name}}
                      </option>
                    @endforeach
                  </select>
                  <span class="form-message"></span>

                </div>
           </div>
        </div>
        <div class="row">
            <div class="col col-ms-4">
                <div class="form-group">
                  <label for="Products_price">Giá sản phẩm</label>
                  <input type="text" name="price" class="form-control" value="{{$item->price}}" id="Products_price" placeholder="Giá sản phẩm...">
                  <span class="form-message"></span>
                </div>
            </div>
           <div class="col col-ms-4">
                <div class="form-group">
                  <label for="products_quantity">Số lượng sản phẩm</label>
                  <input type="text" class="form-control" name="quantity" id="products_quantity" value="{{$item->quantity}}" placeholder="Số lượng sản phẩm...">
                  <span class="form-message"></span>
                </div>
           </div>
           <div class="col col-ms-4">
               <div class="form-group">
                 <label >Trạng thái</label>
                 <select name="status" class="form-control" id="">
                   <option {{ $item->status == 'pending' ? 'selected' : '' }} value="pending">Pending</option>
                   <option {{ $item->status == 'approve' ? 'selected' : '' }} value="approve">Approve</option>
                   <option {{ $item->status == 'reject' ? 'selected' : '' }} value="reject">Reject</option>
                 </select>
               </div>
        </div>
    </div>
    <div class="form-group">
     <label for="products_desc">Chi tiết sản phẩm</label>
     <input type="text" class="form-control" name="description" value="{{$item->description}}" id="products_desc" placeholder="Chi tiết sản phẩm...">
   </div>
        <div class="form-group">
          <label for="products_file">File input</label>
          <div class="input-group">
            <div class="custom-file">
              <input type="file" class="custom-file-input"  name="img_link" id="products_file" accept=".png,.jpeg,.jpg,.gif">
              <label class="custom-file-label" for="products_file">Choose file</label>
            </div>
            <div class="input-group-append">
              <span class="input-group-text">Upload</span>
            </div>
          </div>
          <span class="form-message"></span>
          <a href="{{asset('storage/Uploads/'.$item->thumb)}}" target="_blank">
            <img class="custom-img" src="{{asset('storage/Uploads/'.$item->thumb)}}" alt="">
          </a>
        </div>
        
      </div>
      <!-- /.card-body -->

      <div class="card-footer">
        <button type="submit" class="btn btn-primary">Cập nhập sản phẩm</button>
      </div>
      @endforeach
    </form>
  </div>  
@endsection