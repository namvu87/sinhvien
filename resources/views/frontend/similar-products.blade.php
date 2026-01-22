@if($category)
<style>
    .text-roboto {
        font-family: 'Roboto', sans-serif;
    }
</style>

<h2 class="h2-text text-center text-dark">Sản phẩm tương tự</h2>
<div class="container d-flex justify-content-center mt-50 mb-50">
    <div class="row col-12 text-roboto">
        @foreach($category->products()->where('id', '!=', $productId)->where('status', 'active')->limit(4)->get() as $product)
        <div class="col-md-3 col-sm-12 mt-2">
            <div class="card text-center">
                <div class="card-body">
                    <a href="{{ route('frontend.product-detail', $product->id) }}" class="card-img-actions">
                        <img src="{{ $product->featured_image ? asset('images/' . $product->featured_image) : asset('images/products/default.jpg') }}" 
                             class="card-img img-fluid" 
                             width="96" 
                             height="350" 
                             alt="{{ $product->name }}"
                             onerror="this.src='{{ asset('images/products/default.jpg') }}'; this.onerror=null;">
                    </a>
                </div>
                <div class="card-body bg-light text-center">
                    <div class="item-info-product mb-2">
                        <h4 class="pt-1">
                            <a href="{{ route('frontend.product-detail', $product->id) }}" class="card-img-actions">
                                {{ $product->name }}
                            </a>
                        </h4>
                    </div>
                    <div class="info-product-price my-2">
                        <span class="item_price">{{ number_format($product->sale_price ?? $product->price) }}.đ</span>
                        @if($product->sale_price)
                        <del>{{ number_format($product->price) }}.đ</del>
                        @endif
                    </div>
                    <form action="{{ route('frontend.cart.add') }}" method="post">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}" />
                        <input type="hidden" name="quantity" value="1" />
                        <button type="submit" class="btn bg-cart">
                            <i class="fa fa-cart-plus mr-2"></i> Thêm vào giỏ
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

