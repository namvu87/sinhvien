@extends('layouts.app')

@section('title', 'Đơn mua')

@section('content')
@include('frontend.hero-bg', ['title' => 'Cảm ơn quý khách đã mua hàng'])

<div class="services-breadcrumb">
    <div class="agile_inner_breadcrumb">
        <div class="container">
            <ul class="w3_short">
                <li>
                    <a class="text-dark" href="{{ route('frontend.home') }}">Trang chủ</a>
                    <i>|</i>
                </li>
                <li class="text-danger">Đơn mua</li>
            </ul>
        </div>
    </div>
</div>

<div class="privacy py-sm-5 py-4">
    <div class="container py-xl-4 py-lg-2">
        <h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">
            Đơn hàng của bạn
        </h3>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Ngày đặt</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td>{{ $order->order_code }}</td>
                        <td>{{ $order->product->name ?? 'N/A' }}</td>
                        <td>{{ $order->quantity }}</td>
                        <td>{{ number_format($order->total_revenue) }}đ</td>
                        <td>
                            @if($order->status == 0)
                                <span class="badge badge-warning">Chưa xác nhận</span>
                            @elseif($order->status == 1)
                                <span class="badge badge-success">Đã xác nhận</span>
                            @else
                                <span class="badge badge-danger">Đã hủy</span>
                            @endif
                        </td>
                        <td>{{ $order->order_date->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('frontend.order-detail', $order->id) }}" class="btn btn-sm btn-info">Chi tiết</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <p class="text-muted">Bạn chưa có đơn hàng nào.</p>
                            <a href="{{ route('frontend.home') }}" class="btn btn-primary">Tiếp tục mua sắm</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

