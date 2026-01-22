@extends('layouts.app')

@section('title', 'Chi tiết đơn hàng #' . $order->order_code)

@section('content')
@include('frontend.hero-bg', ['title' => 'Chi tiết đơn hàng'])

<div class="services-breadcrumb">
    <div class="agile_inner_breadcrumb">
        <div class="container">
            <ul class="w3_short">
                <li>
                    <a class="text-dark" href="{{ route('frontend.home') }}">Trang chủ</a>
                    <i>|</i>
                </li>
                <li>
                    <a class="text-dark" href="{{ route('frontend.orders') }}">Đơn mua</a>
                    <i>|</i>
                </li>
                <li class="text-danger">Chi tiết đơn hàng</li>
            </ul>
        </div>
    </div>
</div>

<div class="privacy py-sm-5 py-4">
    <div class="container py-xl-4 py-lg-2">
        <h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">
            Chi tiết đơn hàng #{{ $order->order_code }}
        </h3>
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5>Thông tin đơn hàng</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th>Mã đơn hàng:</th>
                                <td>{{ $order->order_code }}</td>
                            </tr>
                            <tr>
                                <th>Sản phẩm:</th>
                                <td>{{ $order->product->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Số lượng:</th>
                                <td>{{ $order->quantity }}</td>
                            </tr>
                            <tr>
                                <th>Tổng tiền:</th>
                                <td class="text-danger font-weight-bold">{{ number_format($order->total_revenue) }}đ</td>
                            </tr>
                            <tr>
                                <th>Trạng thái:</th>
                                <td>
                                    @if($order->status == 0)
                                        <span class="badge badge-warning">Chưa xác nhận</span>
                                    @elseif($order->status == 1)
                                        <span class="badge badge-success">Đã xác nhận</span>
                                    @else
                                        <span class="badge badge-danger">Đã hủy</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Ngày đặt:</th>
                                <td>{{ $order->order_date->format('d/m/Y') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Thông tin khách hàng</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Tên:</strong> {{ $order->customer->customer_name ?? 'N/A' }}</p>
                        <p><strong>Email:</strong> {{ $order->customer->customer_email ?? 'N/A' }}</p>
                        <p><strong>Điện thoại:</strong> {{ $order->customer->customer_phone ?? 'N/A' }}</p>
                        <p><strong>Địa chỉ:</strong> {{ $order->customer->customer_address ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('frontend.orders') }}" class="btn btn-secondary">Quay lại</a>
        </div>
    </div>
</div>
@endsection

