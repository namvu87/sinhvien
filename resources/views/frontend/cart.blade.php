@extends('layouts.app')

@section('title', 'Giỏ hàng')

@section('content')
<style>
    .table-container {
        max-height: 600px;
        overflow-y: auto;
        position: relative;
    }
    .timetable_sub thead {
        position: sticky;
        top: 0;
        background-color: #f5f5f5;
    }
    .timetable_sub tfoot {
        position: sticky;
        bottom: 0;
        background-color: #f5f5f5;
    }
</style>

<div class="privacy py-sm-5 py-4">
    <div class="container py-xl-4 py-lg-2">
        <h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">
            Giỏ hàng của bạn
        </h3>
        <div class="checkout-right">
            <form action="{{ route('frontend.cart.update') }}" method="POST">
                @csrf
                <div class="table-container">
                    <table class="timetable_sub">
                        <thead>
                            <tr>
                                <th>Thứ tự</th>
                                <th>Sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Tên sản phẩm</th>
                                <th>Giá</th>
                                <th>Tổng tiền</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="scrollable-body">
                            @php
                                $total = 0;
                                $i = 0;
                            @endphp
                            @forelse($cartItems as $item)
                            @php
                                $totalMoney = $item->product_quantity * $item->product_price;
                                $total += $totalMoney;
                                $i++;
                            @endphp
                            <tr class="rem1">
                                <td class="invert">{{ $i }}</td>
                                <td class="invert-image">
                                    <a href="{{ route('frontend.product-detail', $item->product_id) }}">
                                        <img src="{{ asset('images/' . $item->product_image) }}" alt=" " class="img-responsive">
                                    </a>
                                </td>
                                <td class="invert">
                                    <input style="width: 40px;" type="number" name="quantities[{{ $item->id }}]" min="1" required value="{{ $item->product_quantity }}">
                                </td>
                                <td class="invert">{{ $item->product_name }}</td>
                                <td class="invert">{{ number_format($item->product_price) }}đ</td>
                                <td class="invert">{{ number_format($totalMoney) }}đ</td>
                                <td class="invert">
                                    <a href="{{ route('frontend.cart.remove', $item->id) }}" class="btn btn-danger">Xóa</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <p class="text-muted">Giỏ hàng của bạn đang trống.</p>
                                    <a href="{{ route('frontend.home') }}" class="btn btn-primary">Tiếp tục mua sắm</a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        @if($cartItems->count() > 0)
                        <tfoot>
                            <tr>
                                <td colspan="7" style="font-size: 20px;">
                                    Tổng tiền cần thanh toán: <span style="color: red;">{{ number_format($total) }}đ</span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7">
                                    <input type="submit" class="btn btn-success" value="Cập nhập giỏ hàng">
                                    @auth
                                    <a href="{{ route('frontend.checkout') }}" class="btn btn-danger ml-1">Thanh toán</a>
                                    @else
                                    <a href="#" data-toggle="modal" data-target="#loginModal" class="btn btn-danger ml-1">Thanh toán</a>
                                    @endauth
                                </td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

