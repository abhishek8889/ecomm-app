@extends('user_layout.master')

@section('content')
<div class="block-slideshow block-slideshow--layout--with-departments block">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="block-slideshow__body">
                    <div class="owl-carousel">
                        <a class="block-slideshow__slide" href="#">
                            <div class="block-slideshow__slide-image block-slideshow__slide-image--desktop"
                                style="background-image: url({{ asset('assets/images/slides/slide-1.jpg')}})"></div>
                            <div class="block-slideshow__slide-image block-slideshow__slide-image--mobile"
                                style="background-image: url({{ asset('assets/images/slides/slide-1-mobile.jpg')}})"></div>
                            <div class="block-slideshow__slide-content">
                                <div class="block-slideshow__slide-title">Big choice of<br>Plumbing products
                                </div>
                                <div class="block-slideshow__slide-text">Lorem ipsum dolor sit amet,
                                    consectetur adipiscing elit.<br>Etiam pharetra laoreet dui quis
                                    molestie.</div>
                                <div class="block-slideshow__slide-button"><span
                                        class="btn btn-primary btn-lg">Shop Now</span></div>
                            </div>
                        </a>
                        <a class="block-slideshow__slide" href="#">
                            <div class="block-slideshow__slide-image block-slideshow__slide-image--desktop"
                                style="background-image: url({{ asset('assets/images/slides/slide-2.jpg') }})"></div>
                            <div class="block-slideshow__slide-image block-slideshow__slide-image--mobile"
                                style="background-image: url({{ asset('assets/images/slides/slide-2-mobile.jpg')}})"></div>
                            <div class="block-slideshow__slide-content">
                                <div class="block-slideshow__slide-title">Screwdrivers<br>Professional Tools
                                </div>
                                <div class="block-slideshow__slide-text">Lorem ipsum dolor sit amet,
                                    consectetur adipiscing elit.<br>Etiam pharetra laoreet dui quis
                                    molestie.</div>
                                <div class="block-slideshow__slide-button">
                                    <span class="btn btn-primary btn-lg">Shop Now</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- .block-slideshow / end -->
<div class="block block-features block-features--layout--classic">
    <div class="container">
        <div class="block-features__list">
            <div class="block-features__item">
                <div class="block-features__icon"></div>
                <div class="block-features__content">
                    <div class="block-features__title">Free Shipping</div>
                    <div class="block-features__subtitle">For orders from $50</div>
                </div>
            </div>
            <div class="block-features__divider"></div>
            <div class="block-features__item">
                <div class="block-features__icon"></div>
                <div class="block-features__content">
                    <div class="block-features__title">Support 24/7</div>
                    <div class="block-features__subtitle">Call us anytime</div>
                </div>
            </div>
            <div class="block-features__divider"></div>
            <div class="block-features__item">
                <div class="block-features__icon"></div>
                <div class="block-features__content">
                    <div class="block-features__title">100% Safety</div>
                    <div class="block-features__subtitle">Only secure payments</div>
                </div>
            </div>
            <div class="block-features__divider"></div>
            <div class="block-features__item">
                <div class="block-features__icon"></div>
                <div class="block-features__content">
                    <div class="block-features__title">Hot Offers</div>
                    <div class="block-features__subtitle">Discounts up to 90%</div>
                </div>
            </div>
        </div>
    </div>
</div><!-- .block-features / end --><!-- .block-products-carousel -->
<div class="block block-products-carousel" data-layout="grid-4">
    <div class="container">
        <div class="block-header">
            <h3 class="block-header__title">Featured Products</h3>
            <div class="block-header__divider"></div>
            <ul class="block-header__groups-list">
                <li>
                    <button type="button" class="block-header__group block-header__group--active">All</button>
                </li>
            </ul>
            <div class="block-header__arrows-list">
                <button class="block-header__arrow block-header__arrow--left" type="button">
                    <
                </button> 
                <button class="block-header__arrow block-header__arrow--right" type="button">
                    >
                </button>
            </div>
        </div>
        <div class="block-products-carousel__slider">
            <div class="block-products-carousel__preloader"></div>
            <div class="owl-carousel">
                @forelse($products as $product)
                <div class="block-products-carousel__column">
                    <div class="block-products-carousel__cell">
                        <div class="product-card">
                            <div class="product-card__badges-list">
                                <div class="product-card__badge product-card__badge--new">New</div>
                            </div>
                            <div class="product-card__image">
                                <a href="{{ route('product.detail',[$product->slug]) }}">
                                    @foreach($product->media as $media)
                                        @if($loop->index == 0)
                                            <img src="{{ asset(Storage::url("$media->image_url")) }}" alt="p">
                                        @endif
                                    @endforeach
                                </a>
                            </div>
                            <div class="product-card__info">
                                <div class="product-card__name">
                                    <a href="{{ route('product.detail',[$product->slug]) }}">{{ $product->name ?? '' }}</a>
                                </div>
                                <div class="product-card__actions">
                                    <div class="product-card__prices">${{ $product->price ?? '' }}</div>
                                    <div class="product-card__buttons">
                                        <button class="btn btn-primary product-card__addtocart add-to-cart-btn" targetId="{{ $product->id ?? '' }}" type="button">
                                            Add To Cart
                                        </button> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                    <p>No Products are added</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection