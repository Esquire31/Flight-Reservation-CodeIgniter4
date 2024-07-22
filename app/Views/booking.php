<html lang="en">

<?= $this->include("Partials/_head"); ?>

<body>
	<div id="booking" class="section">
		<div class="section-center">
			<div class="container">
				<div class="row">
					<div class="col-md-5">
						<div class="booking-cta">
							<h1>Book your flight today</h1>
						</div>
					</div>
					<div class="col-md-7">
						<div class="booking-form">
							<form id="booking-form" name="booking-form">
								<input type="hidden" name="flight-id" id="flight-id" value="<?= $flight->id ?>">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<span class="form-label">First Name</span>
											<input type="text" name="first-name" id="first-name" class="form-control" required>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<span class="form-label">Last Name</span>
											<input type="text" name="last-name" id="last-name" class="form-control" required>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<span class="form-label">Gender</span>
											<select class="form-control" name="gender" id="gender">
												<option value="male">Male</option>
												<option value="female">Female</option>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<span class="form-label">Date of Birth</span>
											<input type="date" name="date-of-birth" id="date-of-birth" class="form-control" required>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<span class="form-label">Email</span>
											<input type="email" name="email" id="email" class="form-control" required>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<span class="form-label">Phone</span>
											<input type="tel" name="contact" id="contact" class="form-control" required>
										</div>
									</div>
								</div>

								<div class="d-flex justify-content-center mt-4">
									<div id="paypal-button"></div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>

<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script>
     paypal.Button.render({
        // Configure environment
        env: 'sandbox',
        client: {
            sandbox: 'demo_sandbox_client_id',
            production: 'demo_production_client_id'
        },
        // Customize button (optional)
        locale: 'en_US',
        style: {
            size: 'large',
            color: 'gold',
            shape: 'pill',
        },

        // Enable Pay Now checkout flow (optional)
        commit: true,

        // Set up a payment
        payment: function(data, actions) {
            return actions.payment.create({
                transactions: [{
                    amount: {
                        total: '<?= $flight->price ?>',
                        currency: 'USD'
                    }
                }]
            });
        },

        // Initiate onAuthorize event
        onAuthorize: function(data, actions) {
            return actions.payment.execute().then(function() {

                $.ajax("/booking", {
                    type: "POST",
                    data: $("#booking-form").serialize(),
                    success: function(res) {
                        res = JSON.parse(res);

                        swal({
                            title: "Booking Successful",
                            text: "Your booking id is " + res.booking_id,
                            icon: "success",
                            button: "OK",
                        }).then(function() {
                            window.location.href = "/";
                        });
                    }
                })
            });
        }
        
    }, '#paypal-button');

</script>

</html>