@extends('welcome')
@section('content')
<section id="cart_items">
    <div style="width: 100%; margin-left: -20px;" class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
              <li><a href="{{ URL::to('/') }}">Home</a></li>
              <li class="active">Thanh toán giỏ hàng</li>
            </ol>
        </div><!--/breadcrums-->
        <div class="review-payment">
            <h2>Cảm ơn bạn đã mua hàng của chúng tôi..!</h2>
        </div>
    </div>
</section> <!--/#cart_items-->
@endsection