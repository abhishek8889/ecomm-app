<?php 
    $subtotal = 0;
    $total = 0;
    $shipping = 0;
    $tax = 0;
    if(session()->has('cart')){
        $cartDetails = session()->get('cart');
        foreach ($cartDetails as $cart) {
            $product = \App\Models\Product::with('media')->find($cart['product_id']);     
            $subtotal += $product->price * $cart['qty'];
            $total += $product->price * $cart['qty'];
        }
    }
?>
<div class="row justify-content-end pt-5">
    <div class="col-12 col-md-7 col-lg-6 col-xl-5">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Cart Totals</h3>
                <table class="cart__totals">
                    <thead class="cart__totals-header">
                        <tr>
                            <th>Subtotal</th>
                            <td>${{ number_format($subtotal,2) }}</td>
                        </tr>
                    </thead>
                    <tbody class="cart__totals-body">
                        <tr>
                            <th>Shipping</th>
                            <td>
                                ${{ number_format($shipping,2) }}
                            </td>
                        </tr>
                        <tr>
                            <th>Tax</th>
                            <td>${{ number_format($tax,2) }}</td>
                        </tr>
                    </tbody>
                    <tfoot class="cart__totals-footer">
                        <tr>
                            <th>Total</th>
                            <td>${{ number_format($total,2) }}</td>
                        </tr>
                    </tfoot>
                </table>
                <a class="btn btn-primary btn-xl btn-block cart__checkout-button" href="javascript:void(0)">Proceed to checkout</a>
            </div>
        </div>
    </div>
</div>