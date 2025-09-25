<!-- resources/views/order.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizza Ordering System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
   
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Pizza Ordering System</h1>
        
        <form id="orderForm">
            @csrf
            
            <!-- Customer Information -->
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
                        <div class="col-md-4">
                            <input type="tel" name="customer_phone" class="form-control" placeholder="Phone" required>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <textarea name="delivery_address" class="form-control" placeholder="Delivery Address" required></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pizza Selection -->
            <div id="pizzasContainer">
                <div class="pizza-item card mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Pizza #1</h5>
                        <button type="button" class="btn btn-danger btn-sm remove-pizza" style="display: none;">Remove</button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Pizza Type</label>
                                <select name="pizzas[0][pizza_id]" class="form-control pizza-select" required>
                                    <option value="">Select Pizza</option>
                                    @foreach($pizzas as $pizza)
                                        <option value="{{ $pizza->id }}">{{ $pizza->name }}</option>
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
                                    @foreach($toppings as $topping)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input topping-checkbox" type="checkbox" 
                                                   name="pizzas[0][toppings][]" value="{{ $topping->id }}"
                                                   data-price-small="{{ $topping->getPriceBySize('small') }}"
                                                   data-price-medium="{{ $topping->getPriceBySize('medium') }}"
                                                   data-price-large="{{ $topping->getPriceBySize('large') }}">
                                            <label class="form-check-label">
                                                {{ $topping->name }} 
                                                (₹<span class="topping-price">{{ $topping->getPriceBySize('small') }}</span>)
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add More Pizza Button -->
            <button type="button" id="addPizza" class="btn btn-secondary mb-4">Add Another Pizza</button>

            <!-- Total Amount -->
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
        let pizzaCount = 1;

        // Add new pizza section
        $('#addPizza').click(function() {
            const newIndex = pizzaCount;
            const newPizzaHtml = `
                <div class="pizza-item card mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Pizza #${newIndex + 1}</h5>
                        <button type="button" class="btn btn-danger btn-sm remove-pizza">Remove</button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Pizza Type</label>
                                <select name="pizzas[${newIndex}][pizza_id]" class="form-control pizza-select" required>
                                    <option value="">Select Pizza</option>
                                    @foreach($pizzas as $pizza)
                                        <option value="{{ $pizza->id }}">{{ $pizza->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Size</label>
                                <select name="pizzas[${newIndex}][size]" class="form-control size-select" required>
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
                                    @foreach($toppings as $topping)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input topping-checkbox" type="checkbox" 
                                                   name="pizzas[${newIndex}][toppings][]" value="{{ $topping->id }}"
                                                   data-price-small="{{ $topping->getPriceBySize('small') }}"
                                                   data-price-medium="{{ $topping->getPriceBySize('medium') }}"
                                                   data-price-large="{{ $topping->getPriceBySize('large') }}">
                                            <label class="form-check-label">
                                                {{ $topping->name }} 
                                                (₹<span class="topping-price">{{ $topping->getPriceBySize('small') }}</span>)
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            $('#pizzasContainer').append(newPizzaHtml);
            pizzaCount++;
            updateRemoveButtons();
        });

        // Remove pizza section
        $(document).on('click', '.remove-pizza', function() {
            if ($('.pizza-item').length > 1) {
                $(this).closest('.pizza-item').remove();
                recalculateAllPrices();
                updatePizzaNumbers();
            }
        });

        // Update pizza numbers
        function updatePizzaNumbers() {
            $('.pizza-item').each(function(index) {
                $(this).find('.card-header h5').text('Pizza #' + (index + 1));
            });
        }

        // Update remove buttons visibility
        function updateRemoveButtons() {
            $('.remove-pizza').show();
            if ($('.pizza-item').length === 1) {
                $('.remove-pizza').hide();
            }
        }

        // Calculate price when pizza or size changes
        $(document).on('change', '.pizza-select, .size-select', function() {
            calculatePizzaPrice($(this).closest('.pizza-item'));
        });

        // Calculate price when toppings change
        $(document).on('change', '.topping-checkbox', function() {
            calculatePizzaPrice($(this).closest('.pizza-item'));
        });

        // Calculate price for a specific pizza
        function calculatePizzaPrice(pizzaItem) {
            const pizzaId = pizzaItem.find('.pizza-select').val();
            const size = pizzaItem.find('.size-select').val();
            
            if (!pizzaId || !size) {
                pizzaItem.find('.price-display').text('₹0.00');
                recalculateTotal();
                return;
            }

            const toppings = [];
            pizzaItem.find('.topping-checkbox:checked').each(function() {
                toppings.push($(this).val());
            });

            // Update topping prices based on size
            pizzaItem.find('.topping-price').each(function() {
                const checkbox = $(this).closest('.form-check').find('.topping-checkbox');
                const price = checkbox.data('price-' + size);
                $(this).text(price);
            });

            $.ajax({
                url: '{{ route("calculate.price") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    pizza_id: pizzaId,
                    size: size,
                    toppings: toppings
                },
                success: function(response) {
                    pizzaItem.find('.price-display').text('₹' + response.total_price.toFixed(2));
                    recalculateTotal();
                }
            });
        }

        // Recalculate total amount
        function recalculateTotal() {
            let total = 0;
            $('.price-display').each(function() {
                const priceText = $(this).text().replace('₹', '');
                total += parseFloat(priceText) || 0;
            });
            $('#totalAmount').text('₹' + total.toFixed(2));
        }

        // Recalculate all pizza prices
        function recalculateAllPrices() {
            $('.pizza-item').each(function() {
                calculatePizzaPrice($(this));
            });
        }

        // Form submission
        $('#orderForm').submit(function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const pizzas = [];
            
            $('.pizza-item').each(function(index) {
                const pizzaData = {
                    pizza_id: $(this).find('.pizza-select').val(),
                    size: $(this).find('.size-select').val(),
                    toppings: []
                };
                
                $(this).find('.topping-checkbox:checked').each(function() {
                    pizzaData.toppings.push($(this).val());
                });
                
                pizzas.push(pizzaData);
            });
            
            // Add pizzas to form data
            formData.delete('pizzas');
            pizzas.forEach((pizza, index) => {
                formData.append(`pizzas[${index}][pizza_id]`, pizza.pizza_id);
                formData.append(`pizzas[${index}][size]`, pizza.size);
                pizza.toppings.forEach(topping => {
                    formData.append(`pizzas[${index}][toppings][]`, topping);
                });
            });

            $.ajax({
                url: '{{ route("order.store") }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        alert('Order placed successfully! Order Number: ' + response.order_number);
                        $('#orderForm')[0].reset();
                        $('#totalAmount').text('₹0.00');
                        $('.price-display').text('₹0.00');
                    }
                },
                error: function(xhr) {
                    alert('Error placing order. Please try again.');
                }
            });
        });

        // Initialize
        updateRemoveButtons();
    </script>
</body>
</html>