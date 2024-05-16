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
                    <a href="#">{{ __('Shoping cart') }}</a> 
                </li>
            </ol>
            </nav>
        </div>
    </div>
</div>
<div class="cart block">
    <div class="container">
        <form  id="cart-form">
        <table class="cart__table cart-table">
            <thead class="cart-table__head">
                <tr class="cart-table__row">
                    <th class="cart-table__column cart-table__column--image">Image</th>
                    <th class="cart-table__column cart-table__column--product">Product</th>
                    <th class="cart-table__column cart-table__column--price">Price</th>
                    <th class="cart-table__column cart-table__column--quantity">Quantity</th>
                    <th class="cart-table__column cart-table__column--total">Total</th>
                    <th class="cart-table__column cart-table__column--remove"></th>
                </tr>
            </thead>
            <tbody class="cart-table__body">
                
                @forelse($cartDetails as $cart)

                @php 
                // dd($cart);
                    $product = \App\Models\Product::with('media')->find($cart['product_id']);
                    $media = $product->media;
                @endphp
                <tr class="cart-table__row cart-row-{{$cart['product_id']}}">
                    <td class="cart-table__column cart-table__column--image">
                        <a href="{{ route('product.detail',['slug'=>$product->slug]) }}">
                            @foreach($media as $m)
                            @if($loop->iteration == 1)
                            <img src="{{ asset(Storage::url("$m->image_url")) }}" alt="{{ $m->name ?? '' }}">
                            @endif
                            @endforeach
                        </a>
                    </td>
                    <td class="cart-table__column cart-table__column--product">
                        <a href="{{ route('product.detail',['slug'=>$product->slug]) }}" class="cart-table__product-name">{{ $product->name ?? '' }} </a>
                    </td>
                    <td class="cart-table__column cart-table__column--price" data-title="Price">${{ number_format($product->price,2) }}</td>
                    <td class="cart-table__column cart-table__column--quantity" data-title="Quantity">
                        <div class="input-number">
                            <input class="form-control input-number__input " name="{{ $cart['product_id'] }}"  type="number" min="1" value="{{ $cart['qty'] }}">
                            <div class="input-number__add"></div>
                            <div class="input-number__sub"></div>
                        </div>
                    </td>
                    <td class="cart-table__column cart-table__column--total" data-title="Total">
                        ${{ number_format((int)$product->price * (int)$cart['qty'],2)}}
                    </td>
                    <td class="cart-table__column cart-table__column--remove">
                        <button type="button" class="btn btn-light btn-sm btn-svg-icon remove-from-cart" id="{{ $cart['product_id'] }}">X</button></td>
                </tr>
                @empty
                <tr class="cart-table__row">
                    <td class="cart-table__column cart-table__column--image"></td>
                    <td class="cart-table__column cart-table__column--product">
                        <p>{{ __('Your cart is empty') }}</p>
                    </td>
                    <td class="cart-table__column cart-table__column--price" data-title="Price"></td>
                    <td class="cart-table__column cart-table__column--quantity" data-title="Quantity"></td>
                    <td class="cart-table__column cart-table__column--total" data-title="Total"></td>
                    <td class="cart-table__column cart-table__column--remove"></td>
                </tr>
                @endforelse
                
            </tbody>
        </table>
        <div class="cart__actions">
            <div class="cart__coupon-form">
            </div>
            <div class="cart__buttons">
                <a href="{{ url('/') }}" class="btn btn-light">Continue Shopping</a>
                {{-- <a href="javascript:void(0)" class="btn btn-primary cart__update-button update-cart">Update Cart</a> --}}
                <button type="submit" class="btn btn-primary cart__update-button update-cart">Update Cart</button>
            </div>
        </div>
        </form>
        {{-- Cart Total --}}
        <div id="cart-total">
            @include('user._partials.cart_total')
        </div>
        {{--  --}}
    </div>
</div>
@endsection