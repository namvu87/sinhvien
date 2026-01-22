<style>
    .hero-section {
        display: block;
        text-align: center;
        position: relative;
        font-size: 0;
        line-height: 1;
        margin-top: 4px;
    }
    .hero-background {
        background-image: url('{{ asset('images/hero_bg.jpg') }}');
        height: 194px;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }
    .hero-section .page-title {
        display: inline-block;
        position: absolute;
        top: 29%;
        left: 0;
        right: 0;
        font-size: 40px;
        color: #ffffff;
        font-weight: 500;
        font-family: 'Roboto', sans-serif;
        line-height: 50px;
        margin: 0;
    }
</style>

<div class="hero-section hero-background">
    <h1 class="page-title">{{ $title ?? 'Trái cây hữu cơ' }}</h1>
</div>

