@extends('user_layout.master')
@section('content')
<div class="page-header">
    <div class="page-header__container container">
        <div class="page-header__breadcrumb">
            <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                <a href="{{ url('/') }}">Home</a> >
                </li>
                <li class="breadcrumb-item">
                <a href="#">Search</a> >
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $query ?? '' }}
                </li>
            </ol>
            </nav>
        </div>
    </div>
</div>
{{--  --}}
<div class="shop-layout__content container">
    <div class="block">
        <div class="products-view">
            <div class="products-view__list products-list" data-layout="grid-3-sidebar" data-with-features="false">
                {{-- product-list_body --}}
                <div class="products-list__body">
                    @forelse($products as $product)
                        <div class="products-list__item">
                            <div class="product-card">
                                <div class="product-card__badges-list">
                                    <div class="product-card__badge product-card__badge--new">New</div>
                                </div>
                                <div class="product-card__image">
                                    <a href="{{ route('product.detail',['slug' => $product->slug]) }}">
                                        @forelse($product->media as $media)
                                        @if($loop->iteration == 1)
                                            <img src="{{ asset(Storage::url("$media->image_url")) }}" alt="{{ $media->name }}">
                                        @endif
                                        @empty
                                            <img src="https://img.freepik.com/premium-vector/default-image-icon-vector-missing-picture-page-website-design-mobile-app-no-photo-available_87543-11093.jpg?w=1060" alt="">
                                        @endforelse
                                    </a>
                                </div>
                                <div class="product-card__info">
                                    <div class="product-card__name">
                                        <a href="{{ route('product.detail',['slug' => $product->slug]) }}">{{ $product->name ?? '' }}</a>
                                    </div>
                                </div>
                                <div class="product-card__actions">
                                    <div class="product-card__prices">${{ number_format($product->price ,2) }}</div>
                                    <div class="product-card__buttons"><button class="btn btn-primary product-card__addtocart add-to-cart-btn"  targetId="{{ $product->id ?? '' }}" type="button">Add To Cart</button> 
                                        <button class="btn btn-secondary product-card__addtocart product-card__addtocart--list" type="button">Add To Cart</button> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                    <p>No Data found</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection