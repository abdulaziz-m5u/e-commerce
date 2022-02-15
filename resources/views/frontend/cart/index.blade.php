@extends('layouts.app')
@section('title', 'Cart')
@section('content')
    <div class="breadcrumb-area pt-20 pb-20" style="background-image: url('{{ asset('frontend/img/bg/16.jpg') }}')">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <h2 class="text-dark">Cart</h2>
                <ul>
                    <li><a href="{{ route('home') }}" class="text-secondary">home</a></li>
                    <li class="text-dark"> cart</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="cart-main-area pt-5 mb-5">
        <div class="container">
            <!-- cart item area -->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <form action="#">
                        <div class="table-content table-responsive">
                            <table>
                                <thead>
                                <tr>
                                    <th>images</th>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                 item component
                                    <tr>
                                        <td class="pl-0 border-light" colspan="5">
                                            <p class="text-center">No items found.</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>

            <!-- cart total -->
            <div class="row">
                cart total component
            </div>
            <div class="row">
                <div class="col-md-4 ">
                    <a href="{{route('shop.index')}}"
                       class="btn btn-link text-decoration-none text-dark">
                        <i class="fas fa-long-arrow-alt-left mr-1"></i>
                        Continue to shopping
                    </a>
                </div>
                    <div class="col-md-4 ">
                        button component
                    </div>
            </div>
        </div>
    </div>
@endsection