@extends('admin_layout')
@section('admin_content')
<div class="form-w3layouts">
        <!-- page start-->
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Cập nhật thương hiệu sản phẩm
                        </header>
                        <?php
                            $mes = Session::get('message');
                            if ($mes) {
                                echo $mes;
                                Session::put('message', null);
                            }
                        ?>
                        @foreach($edit_brand_product as $key => $value_edit)
                        <div class="panel-body">
                            <div class="position-center">
                                <form role="form" action="{{URL::to('/update-brand-product/'.$value_edit->brand_id)}}" method="post">
                                    @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên thương hiệu</label>
                                    <input type="text" value="{{$value_edit->brand_name}}" name="brand_product_name" class="form-control" id="exampleInputEmail1" placeholder="Tên danh mục">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Chi tiết thương hiệu</label>
                                    <textarea style="resize: none;" rows="8" name="brand_product_desc" class="form-control" id="exampleInputPassword1" placeholder="Chi tiết danh mục sản phẩm">{{$value_edit->brand_desc}}</textarea>
                                </div>
                                <button type="submit" name="sbm" class="btn btn-info">Cập nhật thương hiệu</button>
                            </form>
                            </div>
                        @endforeach
                        </div>
                    </section>

            </div>
    </div>
</div>
@endsection