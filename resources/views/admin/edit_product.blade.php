@extends('admin_layout')
@section('admin_content')
<div class="form-w3layouts">
        <!-- page start-->
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Cập nhật sản phẩm
                        </header>
                        <?php
                            $mes = Session::get('message');
                            if ($mes) {
                                echo $mes;
                                Session::put('message', null);
                            }
                        ?>
                        <div class="panel-body">
                            @foreach($edit_product as $key => $edit_pro)
                            <div class="position-center">
                                <form role="form" action="{{URL::to('/update-product/'.$edit_pro->product_id)}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên sản phẩm</label>
                                    <input type="text" value="{{$edit_pro->product_name}}" name="product_name" class="form-control" id="exampleInputEmail1">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Hình ảnh sản phẩm</label>
                                    <input type="file" name="product_image" class="form-control" id="exampleInputEmail1">
                                    <img height="100" width="100" src="{{URL::to('public/uploads/product/'.$edit_pro->product_image)}}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Giá sản phẩm</label>
                                    <input type="text" value="{{$edit_pro->product_price}}" name="product_price" class="form-control" id="exampleInputEmail1">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả sản phẩm</label>
                                    <textarea style="resize: none;" rows="5" name="product_desc" class="form-control" id="exampleInputPassword1" >{{$edit_pro->product_desc}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Nội dung sản phẩm</label>
                                    <textarea style="resize: none;" rows="5" name="product_content" class="form-control" id="exampleInputPassword1">{{$edit_pro->product_content}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Hiển thị</label>
                                   <select name="product_status" class="form-control input-sm m-bot15">
                                        <option <?php if($edit_pro->product_status == 0){echo "selected";} ?> value="0">Ẩn</option>
                                        <option <?php if($edit_pro->product_status == 1){echo "selected";} ?> value="1">Hiện</option>
                                    </select> 
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Danh mục sản phẩm</label>
                                   <select name="product_category_id" class="form-control input-sm m-bot15">
                                        @foreach($product_category as $key => $cate)
                                        @if($cate->category_id == $edit_pro->category_id)
                                        <option selected value="{{$cate->category_id}}">{{$cate->category_name}}</option>
                                        @else
                                        <option value="{{$cate->category_id}}">{{$cate->category_name}}</option>
                                        @endif
                                        @endforeach
                                    </select> 
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Thương hiệu sản phẩm</label>
                                   <select name="product_brand_id" class="form-control input-sm m-bot15">
                                    @foreach($product_brand as $key => $brand)
                                    @if($brand->brand_id == $edit_pro->brand_id)
                                        <option selected value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
                                    @else
                                        <option value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
                                    @endif
                                    @endforeach
                                    </select> 
                                </div>
                               
                                <button type="submit" name="sbm" class="btn btn-info">Cập nhật sản phẩm</button>
                            </form>
                            </div>
                            @endforeach
                        </div>
                    </section>

            </div>
    </div>
</div>
@endsection