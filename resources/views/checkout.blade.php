@extends('layouts.app')
@section('title', 'Checkout')
@section('content')

<!-- start page content -->
<div class="container">
    <div class="row">
        <div class="col-md-5 offset-md-1">
            <hr>
            <h1 class="lead" style="font-size: 1.5em">Checkout</h1>
            <hr>
            <h3 class="lead" style="font-size: 1.2em; margin-bottom: 1.6em;">Billing details</h3>
            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf()
                <div class="form-group">
                    <label for="email" class="light-text">Email Address</label>
                    @guest
                        <input type="text" name="email" class="form-control my-input" required>
                    @else
                        <input type="text" name="email" class="form-control my-input" value="{{ auth()->user()->email }}" readonly required>
                    @endguest
                </div>
                <div class="form-group">
                    <label for="name" class="light-text">Name</label>
                    <input type="text" name="name" class="form-control my-input" required>
                </div>
                <div class="form-group">
                    <label for="address" class="light-text">Address</label>
                    <input type="text" name="address" class="form-control my-input" required>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="city" class="light-text">City</label>
                            <input type="text" name="city" class="form-control my-input" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="province" class="light-text">Province</label>
                        <input type="text" name="province" class="form-control my-input" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="postal_code" class="light-text">Postal Code</label>
                            <input type="text" name="postal_code" class="form-control my-input" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="phone" class="light-text">Phone</label>
                        <input type="text" name="phone" class="form-control my-input" required>
                    </div>
                </div>
                <h2 style="margin-top:1em; margin-bottom:1em;">Payment Method</h2>
                
                <!-- Payment Method Selection -->
                <div class="form-group">
                    <label class="light-text">Select Payment Method</label>
                    <div class="payment-method-selector">
                        <div class="custom-control custom-radio" style="margin-bottom: 1em;">
                            <input type="radio" class="custom-control-input" id="payment_esewa" name="payment_method" value="esewa" checked>
                            <label class="custom-control-label" for="payment_esewa">
                                <img src="https://esewa.com.np/static/assets/favicon.png" style="height: 20px; margin-right: 10px;" alt="eSewa"> eSewa
                            </label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" id="payment_card" name="payment_method" value="card">
                            <label class="custom-control-label" for="payment_card">
                                💳 Credit Card
                            </label>
                        </div>
                    </div>
                </div>

                <!-- eSewa Payment Form -->
                <div id="esewa-payment-section" class="payment-section">
                    <div class="esewa-container" style="background: #f8f9fa; border-radius: 8px; padding: 20px; margin-top: 1.5em;">
                        <h3 style="color: #239a3b; text-align: center; margin-bottom: 20px; font-weight: 600;">eSewa Payment</h3>
                        
                        <div class="form-group">
                            <label for="esewa_id" class="light-text">
                                <strong>eSewa ID (Merchant)</strong>
                            </label>
                            <div style="position: relative;">
                                <span style="position: absolute; left: 12px; top: 10px; color: #239a3b; font-weight: 500;">Rs.</span>
                                <input type="text" name="esewa_id" id="esewa_id" class="form-control my-input" placeholder="Enter Merchant eSewa ID" style="padding-left: 35px;" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="esewa_amount" class="light-text">
                                <strong>Amount</strong>
                            </label>
                            <input type="text" name="esewa_amount" id="esewa_amount" class="form-control my-input" value="${{ format($total) }}" readonly style="background-color: #e9ecef;">
                        </div>

                        <div class="form-group">
                            <label for="esewa_purpose" class="light-text">
                                <strong>Purpose</strong>
                            </label>
                            <select name="esewa_purpose" id="esewa_purpose" class="form-control my-input" required>
                                <option value="">Select Purpose</option>
                                <option value="product_purchase">Product Purchase</option>
                                <option value="online_shopping">Online Shopping</option>
                                <option value="merchandise">Merchandise</option>
                                <option value="utility">Utility Payment</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="esewa_details" class="light-text">
                                <strong>Details</strong>
                            </label>
                            <textarea name="esewa_details" id="esewa_details" class="form-control my-input" rows="3" placeholder="Add order details..."></textarea>
                        </div>

                        <button type="submit" class="btn btn-block" style="background-color: #239a3b; color: white; border: none; padding: 12px; font-weight: 600; border-radius: 4px; font-size: 16px;">
                            Proceed to eSewa
                        </button>
                    </div>
                </div>

                <!-- Credit Card Payment Form -->
                <div id="card-payment-section" class="payment-section" style="display: none;">
                    <div class="card-container" style="background: #f8f9fa; border-radius: 8px; padding: 20px; margin-top: 1.5em;">
                        <h3 style="color: #007bff; text-align: center; margin-bottom: 20px; font-weight: 600;">Credit Card Payment</h3>
                        
                        <div class="form-group">
                            <label for="name_on_card" class="light-text">
                                <strong>Name on Card</strong>
                            </label>
                            <input type="text" name="name_on_card" id="name_on_card" class="form-control my-input" placeholder="Full name as shown on card">
                        </div>

                        <div class="form-group">
                            <label for="credit_card" class="light-text">
                                <strong>Credit Card Number</strong>
                            </label>
                            <input type="text" name="credit_card" id="credit_card" class="form-control my-input" placeholder="1234 5678 9012 3456">
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="card_expiry" class="light-text">
                                        <strong>Expiry Date</strong>
                                    </label>
                                    <input type="text" name="card_expiry" id="card_expiry" class="form-control my-input" placeholder="MM/YY">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="card_cvv" class="light-text">
                                        <strong>CVV</strong>
                                    </label>
                                    <input type="text" name="card_cvv" id="card_cvv" class="form-control my-input" placeholder="123">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success custom-border-success btn-block">
                            Complete Order
                        </button>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const esewaRadio = document.getElementById('payment_esewa');
                        const cardRadio = document.getElementById('payment_card');
                        const esewaSection = document.getElementById('esewa-payment-section');
                        const cardSection = document.getElementById('card-payment-section');

                        function updatePaymentDisplay() {
                            if (esewaRadio.checked) {
                                esewaSection.style.display = 'block';
                                cardSection.style.display = 'none';
                                document.getElementById('esewa_id').required = true;
                                document.getElementById('esewa_purpose').required = true;
                                document.getElementById('name_on_card').required = false;
                                document.getElementById('credit_card').required = false;
                            } else {
                                esewaSection.style.display = 'none';
                                cardSection.style.display = 'block';
                                document.getElementById('esewa_id').required = false;
                                document.getElementById('esewa_purpose').required = false;
                                document.getElementById('name_on_card').required = true;
                                document.getElementById('credit_card').required = true;
                            }
                        }

                        esewaRadio.addEventListener('change', updatePaymentDisplay);
                        cardRadio.addEventListener('change', updatePaymentDisplay);
                        
                        // Initialize on page load
                        updatePaymentDisplay();
                    });
                </script>
            </form>
        </div>
        <div class="col-md-5 offset-md-1">
            <hr>
            <h3>Your Order</h3>
            <hr>
            <table class="table table-borderless table-responsive">
                <tbody>
                    @foreach (Cart::instance('default')->content() as $item)
                        <tr>
                            <td>
                                <a href="{{ route('shop.show', $item->model->slug) }}">
                                    <img src="{{ productImage($item->model->image) }}" height="100px" width="100px"></td>
                                </a>
                            <td>
                            <td>
                                <a href="{{ route('shop.show', $item->model->slug) }}" class="text-decoration-none">
                                    <h3 class="lead light-text">{{ $item->model->name }}</h3>
                                    <p class="light-text">{{ $item->model->details }}</p>
                                    <h3 class="light-text lead text-small">${{ $item->model->price }}</h3>
                                </a>
                            </td>
                            <td>
                                <span class="quantity-square">{{ $item->qty }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <hr>
            <div class="row">
                <div class="col-md-4">
                    <span class="light-text">Subtotal</span>
                </div>
                <div class="col-md-4 offset-md-4">
                    <span class="light-text" style="display: inline-block">${{ format($subtotal) }}</span>
                </div>
            </div>
            @if (session()->has('coupon'))
                <div class="row">
                    <div class="col-md-4">
                        <span class="light-text inline">Discount({{ session('coupon')['code'] }})</span>
                    </div>
                    <div class="col-md-4">
                        <form class="form-inline" action="{{ route('coupon.destroy') }}" method="POST" style="display:inline">
                            @csrf()
                            @method('DELETE')
                            <button class="inline-form-button" type="submit">Remove</button>
                        </form>
                    </div>
                    <div class="col-md-4">
                        <span class="light-text" style="display: inline">- ${{ format($discount) }}</span>
                    </div>
                </div><hr>
                <div class="row">
                    <div class="col-md-4">
                        <span class="light-text">New Subtotal</span>
                    </div>
                    <div class="col-md-4 offset-md-4">
                        <span class="light-text" style="display: inline-block">${{ format($newSubtotal) }}</span>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-md-4">
                    <span class="light-text">Tax(21%)</span>
                </div>
                <div class="col-md-4 offset-md-4">
                    <span class="light-text" style="display: inline-block">${{ format($tax) }}</span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <span>Total</span>
                </div>
                <div class="col-md-4 offset-md-4">
                    <span class="text-right" style="display: inline-block">${{ format($total) }}</span>
                </div>
            </div>
            <hr>
            @if (!session()->has('coupon'))
                <form action="{{ route('coupon.store') }}" method="POST">
                    @csrf()
                    <label for="coupon_code">Have a coupon ?</label>
                    <input type="text" name="coupon_code" id="coupon" class="form-control my-input" placeholder="123456" required>
                    <button type="submit" class="btn btn-success custom-border-success btn-block">Apply Coupon</button>
                </form>
            @endif
        </div>
    </div>
</div>
<!-- end page content -->

@endsection