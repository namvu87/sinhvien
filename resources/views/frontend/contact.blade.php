@extends('layouts.app')

@section('title', 'Liên hệ')

@section('content')
<div class="privacy py-sm-5 py-4">
    <div class="container py-xl-4 py-lg-2">
        <h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">
            Liên hệ
        </h3>
        <div class="row">
            <div class="col-md-6">
                <h4>Thông tin liên hệ</h4>
                <p><i class="fas fa-map-marker"></i> Mỹ Tân, TP Nam Định, Nam Định</p>
                <p><i class="fas fa-phone"></i> 0123456789</p>
                <p><i class="fas fa-envelope"></i> pitustore@gmail.com</p>
            </div>
            <div class="col-md-6">
                <h4>Gửi tin nhắn</h4>
                <form action="#" method="post">
                    @csrf
                    <div class="form-group">
                        <input type="text" class="form-control" name="name" placeholder="Họ tên" required>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="message" rows="5" placeholder="Nội dung" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Gửi tin nhắn</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

