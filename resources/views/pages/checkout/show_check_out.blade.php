@extends('welcome')
@section('content')
<section id="cart_items">
    <div style="width: 100%; margin-left: -20px;" class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
              <li><a href="{{ URL::to('/') }}">Home</a></li>
              <li class="active">Check out</li>
            </ol>
        </div><!--/breadcrums-->

    

        <div class="register-req">
            <p>Please use Register And Checkout to easily get access to your order history, or use Checkout as Guest</p>
        </div><!--/register-req-->
        <div class="shopper-informations">
            <div class="row">
                <div class="col-sm-12">
                    <div class="shopper-info">
                        <p>Shopper Information</p>
                        <form action="{{ URL::to('/save-checkout-customer') }}" method="POST">
                            @csrf
                            <input type="text" name="shipping_Name" placeholder="Name">
                            <input type="email" name="shipping_Email" placeholder="Email">
                            <input type="text" name="shipping_Address" placeholder="Address">
                            <input type="text" name="shipping_Phone" placeholder="Phone">
                            <textarea name="shipping_Note"  placeholder="Notes about your order, Special Notes for Delivery" rows="10"></textarea>
                            <input style="height: 40px; margin-bottom: 0px" type="submit" name="sbm" value="Gửi" class="btn  btn-primary btn-sm">
                        </form>
                    </div>
                </div>					
            </div>
        </div>
        <div class="review-payment">
            <h2>Review & Payment</h2>
        </div>

        <div class="table-responsive cart_info">
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td class="image">Hình ảnh</td>
                        <td class="description">Mô tả</td>
                        <td class="price">Giá</td>
                        <td class="quantity">Số lượng</td>
                        <td class="total">Tổng tiền</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $content = Cart::content();
                        // echo "<pre>";
                        // print_r($content);
                    ?>
                    @foreach($content as $v_content)
                    <tr>
                        <td class="cart_product">
                            <a href=""><img src="{{URL::to('public/uploads/product/'.$v_content->options->image)}}" width="70" alt=""></a>
                        </td>
                        <td class="cart_description">
                            <h4><a href="">{{$v_content->name}}</a></h4>
                            <p>Web ID: {{$v_content->id}}</p>
                        </td>
                        <td class="cart_price">
                            <p>{{number_format($v_content->price).' '.'vnd'}}</p>
                        </td>
                        <td class="cart_quantity">
                            <div class="cart_quantity_button">
                                <form action="{{URL::to('/update-cart')}}" method="post">
                                    @csrf
                                <input class="cart_quantity_input" type="text" name="cart_quantity" value="{{$v_content->qty}}" autocomplete="off" size="2">
                                <input type="hidden" value="{{$v_content->rowId}}" name="cart_id">
                                <input style="height: 28px; margin-bottom: 0px;" type="submit" name="sbm" value="Update" class="btn btn-default btn-sm">
                                </form>
                            </div>
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price">
                                <?php
                                    $total_price = $v_content->price * $v_content->qty;
                                    echo number_format($total_price).' '.'vnd';	
                                ?>
                            </p>
                        </td>
                        <td class="cart_delete">
                            <a class="cart_quantity_delete" href="{{URL::to('/delete-to-cart/'.$v_content->rowId)}}"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="payment-options">
                <span>
                    <label><input name="payment_option" value="1" type="checkbox"> Nhận bằng thẻ ATM</label>
                </span>
                <span>
                    <label><input name="payment_option" value="2" type="checkbox"> Nhận tiền mặt</label>
                </span>
                {{-- <span>
                    <label><input type="checkbox"> Trả góp</label>
                </span> --}}
            </div>
    </div>
</section> <!--/#cart_items-->
@endsection