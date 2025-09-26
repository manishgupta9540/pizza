<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizza Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">

        <h1 class="text-center mb-4">Pizza Order</h1>

        <form id="orderForm">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            
            <!-- Customer Details -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Customer Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="customer_name" class="form-control" placeholder="Full Name" required>
                        </div>
                        <div class="col-md-4">
                            <input type="email" name="customer_email" class="form-control" placeholder="Email" required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pizza Items -->
            <div id="pizzasContainer">
                <div class="pizza-item card mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Pizza 1</h5>
                        <button type="button" class="btn btn-danger btn-sm remove-pizza" style="display: none;">Remove</button>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-4">
                                <label>Pizza Type</label>
                                <select name="pizzas[0][pizza_id]" class="form-control pizza-select" required>
                                    <option value="">Select Pizza</option>
                                    @foreach($pizzas as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label>Size</label>
                                <select name="pizzas[0][size]" class="form-control size-select" required>
                                    <option value="">Select Size</option>
                                    <option value="small">Small</option>
                                    <option value="medium">Medium</option>
                                    <option value="large">Large</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label>Price</label>
                                <div class="price-display">₹0.00</div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <label>Toppings</label>
                                <div class="toppings-container">
                                    @foreach($toppings as $top)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input topping-checkbox" 
                                                   type="checkbox" 
                                                   name="pizzas[0][toppings][]" 
                                                   value="{{ $top->id }}" 
                                                   data-price-small="{{ $top->getPriceBySize('small') }}" 
                                                   data-price-medium="{{ $top->getPriceBySize('medium') }}" 
                                                   data-price-large="{{ $top->getPriceBySize('large') }}">
                                            <label class="form-check-label">
                                                {{ $top->name }} (₹<span class="topping-price">{{ $top->getPriceBySize('small') }}</span>)
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" id="addPizza" class="btn btn-secondary mb-4">Add Another Pizza</button>

            <!-- Order Summary -->
            <div class="card">
                <div class="card-header">
                    <h5>Order Summary</h5>
                </div>
                <div class="card-body">
                    <div id="orderSummary">
                        <p>Total Amount: <strong id="totalAmount">₹0.00</strong></p>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg">Place Order</button>
                </div>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        let pizzaIndex = 1;

        // ek aur pizza add karna
        $('#addPizza').on('click', function () {
            const idx = pizzaIndex;
            const pizzaHtml = `
                <div class="pizza-item card mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Pizza ${idx + 1}</h5>
                        <button type="button" class="btn btn-danger btn-sm remove-pizza">Remove</button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Pizza Type</label>
                                <select name="pizzas[${idx}][pizza_id]" class="form-control pizza-select" required>
                                    <option value="">Select Pizza</option>
                                    @foreach($pizzas as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Size</label>
                                <select name="pizzas[${idx}][size]" class="form-control size-select" required>
                                    <option value="">Select Size</option>
                                    <option value="small">Small</option>
                                    <option value="medium">Medium</option>
                                    <option value="large">Large</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Price</label>
                                <div class="price-display">₹0.00</div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <label>Toppings</label>
                                <div class="toppings-container">
                                    @foreach($toppings as $top)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input topping-checkbox" 
                                                   type="checkbox" 
                                                   name="pizzas[${idx}][toppings][]" 
                                                   value="{{ $top->id }}" 
                                                   data-price-small="{{ $top->getPriceBySize('small') }}" 
                                                   data-price-medium="{{ $top->getPriceBySize('medium') }}" 
                                                   data-price-large="{{ $top->getPriceBySize('large') }}">
                                            <label class="form-check-label">
                                                {{ $top->name }} (₹<span class="topping-price">{{ $top->getPriceBySize('small') }}</span>)
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;
            $('#pizzasContainer').append(pizzaHtml);
            pizzaIndex++;
            toggleRemoveButtons();
        });

        // pizza remove karna
        $(document).on('click', '.remove-pizza', function () {
            if ($('.pizza-item').length > 1) {
                $(this).closest('.pizza-item').remove();
                renumberPizzas();
                updateOrderTotal();
            }
        });

        // numbering update
        function renumberPizzas() {
            $('.pizza-item').each(function (i) {
                $(this).find('.card-header h5').text('Pizza #' + (i + 1));
            });
        }

        // remove button visibility
        function toggleRemoveButtons() {
            $('.remove-pizza').show();
            if ($('.pizza-item').length === 1) {
                $('.remove-pizza').hide();
            }
        }

        // price calculate karna
        $(document).on('change', '.pizza-select, .size-select, .topping-checkbox', function () {
            updatePizzaPrice($(this).closest('.pizza-item'));
        });

        function updatePizzaPrice(item) {
            const pizzaId = item.find('.pizza-select').val();
            const size = item.find('.size-select').val();

            if (!pizzaId || !size) {
                item.find('.price-display').text('₹0.00');
                updateOrderTotal();
                return;
            }

            // toppings collect karna
            const toppings = [];
            item.find('.topping-checkbox:checked').each(function () {
                toppings.push($(this).val());
            });

            // topping prices update according to size
            item.find('.topping-price').each(function () {
                const chk = $(this).closest('.form-check').find('.topping-checkbox');
                const price = chk.data('price-' + size);
                $(this).text(price);
            });

            $.ajax({
                url: "{{ route('amountcalculate') }}",
                type: "post",
                data: {
                    _token: '{{ csrf_token() }}',
                    pizza_id: pizzaId,
                    size: size,
                    toppings: toppings
                }
            }).done(function (res) {
                item.find('.price-display').text('₹' + res.total_price.toFixed(2));
                updateOrderTotal();
            });
        }

        // total update
        function updateOrderTotal() {
            let total = 0;
            $('.price-display').each(function () {
                const price = parseFloat($(this).text().replace('₹', '')) || 0;
                total += price;
            });
            $('#totalAmount').text('₹' + total.toFixed(2));
        }

        // form submit
        $('#orderForm').on('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            const pizzas = [];

            $('.pizza-item').each(function (i) {
                const obj = {
                    pizza_id: $(this).find('.pizza-select').val(),
                    size: $(this).find('.size-select').val(),
                    toppings: []
                };
                $(this).find('.topping-checkbox:checked').each(function () {
                    obj.toppings.push($(this).val());
                });
                pizzas.push(obj);
            });

            formData.delete('pizzas');
            pizzas.forEach((p, i) => {
                formData.append(`pizzas[${i}][pizza_id]`, p.pizza_id);
                formData.append(`pizzas[${i}][size]`, p.size);
                p.toppings.forEach(t => formData.append(`pizzas[${i}][toppings][]`, t));
            });

            $.ajax({
                url: "{{ route('pizza-order') }}",
                type: "post",
                data: formData,
                processData: false,
                contentType: false
            }).done(function (response) {
                if (response.success) {
                    alert("Your order has been confirmed!");
                    $('#orderForm')[0].reset();
                    $('#totalAmount').text('₹0.00');
                    $('.price-display').text('₹0.00');
                }
            }).fail(function () {
                alert("Something went wrong. Please try again.");
            });
        });

        // initialize
        toggleRemoveButtons();
    </script>
</body>
</html>
