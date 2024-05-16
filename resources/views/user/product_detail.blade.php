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
                <a href="#">Products</a> >
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                {{ $product->name ?? '' }}
                </li>
            </ol>
            </nav>
        </div>
    </div>
</div>
<div class="block">
    <div class="container">
        <div class="product product--layout--standard" data-layout="standard">
            <div class="product__content">
                <div class="product__gallery">
                    <div class="product-gallery">
                        <div class="product-gallery__featured">
                            <div class="owl-carousel" id="product-image">
                                @forelse($product->media as $media)
                                <a href="javascript:void(0)">
                                    <img src="{{ asset(Storage::url($media->image_url)) }}" alt="{{$media->name}}" />
                                </a>
                                @empty
                                @endforelse
                            </div>
                        </div>
                        <div class="product-gallery__carousel">
                            <div class="owl-carousel" id="product-carousel">
                                @forelse($product->media as $media)
                                <a href="javascript:void(0)" class="product-gallery__carousel-item">
                                    <img class="product-gallery__carousel-image"  src="{{asset(Storage::url("$media->image_url"))}}" alt="{{ $media->name ?? '' }}" />
                                </a >
                                @empty
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                <!-- .product__gallery / end --><!-- .product__info -->
                <div class="product__info">
                    <h1 class="product__name">
                        {{ $product->name ?? '' }}
                    </h1>
                    <div class="product__description">
                        {{ substr($product->description,0,200).'...' ?? '' }}
                    </div>
                </div>
                <div class="product__sidebar">
                    <div class="mt-4 ">
                        @if($product->quantity > 0 )
                        <span class="mr-2 text-success">In Stock</span>
                        @else
                        <span class="mr-2 text text-danger">Out of Stock</span>
                        @endif
                        <span class="mr-2 text text-secondary">Brand : {{ $product->brand ?? '' }}</span>
                        <span class="mr-2 text text-secondary">SKU : {{ $product->sku ?? '' }} </span>
                        
                    </div>
                    <div class="product__prices">${{ number_format($product->price,2) }}</div>
                    <div class="form-group product__option">
                        <label class="product__option-label" for="product-quantity" >{{ __('Quantity') }}</label>
                        <div class="product__actions">
                            <div class="product__actions-item">
                                <div class="input-number product__quantity">
                                <input id="product-quantity" class="input-number__input form-control form-control-lg" type="number"  min="1" value="1" />
                                <div class="input-number__add"></div>
                                <div class="input-number__sub"></div>
                                </div>
                            </div>
                            <div class="product__actions-item product__actions-item--addtocart" >
                                <button class="btn btn-primary btn-lg add-to-cart-btn" targetId="{{ $product->id }}">
                                {{ __('Add to cart') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- </form> --}}
                <div class="product__footer">
                    <div class="product__tags tags">
                        <div class="tags__list">
                            {{-- @forelse($product->key_words as $key)
                            <a href="#">Mounts</a> 
                            @empty
                            @endforelse --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-tabs">
            <div class="product-tabs__list">
                <a href="#tab-description"  class="product-tabs__item product-tabs__item--active" >Description</a >
            </div>
            <div class="product-tabs__content">
                <div class="product-tabs__pane product-tabs__pane--active" id="tab-description">
                    <div class="typography">
                        <h3>{{ __('Product Full Description') }}</h3>
                        {{ $product->description ?? '' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection