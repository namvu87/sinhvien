@extends('layouts.app')

@section('title', 'Quên mật khẩu')

@section('content')
@include('frontend.hero-bg', ['title' => 'Quên mật khẩu'])

<div class="services-breadcrumb">
    <div class="agile_inner_breadcrumb">
        <div class="container">
            <ul class="w3_short">
                <li>
                    <a class="text-dark" href="{{ route('frontend.home') }}">Trang chủ</a>
                    <i>|</i>
                </li>
                <li class="text-danger">Quên mật khẩu</li>
            </ul>
        </div>
    </div>
</div>

<div class="privacy py-sm-5 py-4">
    <div class="container py-xl-4 py-lg-2">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">
                    Khôi phục mật khẩu
                </h3>
                
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                <div class="card">
                    <div class="card-body">
                        <p class="text-muted mb-4">
                            Nhập email đã đăng ký của bạn. Chúng tôi sẽ gửi link khôi phục mật khẩu đến email của bạn.
                        </p>

                        <form action="{{ route('frontend.password.email') }}" method="POST">
                            @csrf
                            
                            <div class="form-group">
                                <label for="email">Email <span class="text-danger">*</span></label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       placeholder="Nhập email của bạn"
                                       required 
                                       autofocus>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary btn-lg btn-block">
                                    <i class="fas fa-paper-plane"></i> Gửi link khôi phục
                                </button>
                            </div>
                        </form>

                        <hr>

                        <div class="text-center">
                            <p class="mb-0">
                                <a href="{{ route('login') }}">Quay lại đăng nhập</a>
                            </p>
                            <p class="mb-0 mt-2">
                                Chưa có tài khoản? 
                                <a href="#" data-toggle="modal" data-target="#registerModal">Đăng ký ngay</a>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info mt-4">
                    <h6><i class="fas fa-info-circle"></i> Lưu ý:</h6>
                    <ul class="mb-0">
                        <li>Link khôi phục mật khẩu sẽ được gửi đến email của bạn</li>
                        <li>Link có hiệu lực trong 60 phút</li>
                        <li>Nếu không nhận được email, vui lòng kiểm tra thư mục spam</li>
                        <li>Liên hệ với chúng tôi nếu bạn gặp vấn đề</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
