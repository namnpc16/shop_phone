@extends('admin_layout')
@section('admin_content')
<div class="form-w3layouts">
        <!-- page start-->
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Thêm thương hiệu sản phẩm
                        </header>
                        <?php
                            $mes = Session::get('message');
                            if ($mes) {
                                echo $mes;
                                Session::put('message', null);
                            }
                        ?>
                        <div class="panel-body">
                            <div class="position-center">
                                <form role="form" action="{{URL::to('/save-brand-product')}}" method="post">
                                    @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên thương hiệu</label>
                                    {{-- validate jquery --}}
                                    <input type="text" data-validation="length" data-validation-length="min3" data-validation-error-msg="Không được nhỏ hơn 3 ký tự" name="brand_product_name" class="form-control" id="exampleInputEmail1" placeholder="Tên danh mục">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Chi tiết thương hiệu</label>
                                    <textarea style="resize: none;" rows="8" name="brand_product_desc" class="form-control" id="id3" placeholder="Chi tiết danh mục sản phẩm"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Hiển thị</label>
                                   <select name="brand_product_status" class="form-control input-sm m-bot15">
                                        <option value="0">Ẩn</option>
                                        <option value="1">Hiện</option>
                                    </select> 
                                </div>
                               
                                <button type="submit" name="sbm" class="btn btn-info">Thêm thương hiệu</button>
                            </form>
                            </div>

                        </div>
                    </section>

            </div>
    </div>
</div>
@endsection