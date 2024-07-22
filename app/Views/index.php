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
								<div class="form-group">
									<div class="form-checkbox">
										<label for="one-way">
											<input type="radio" id="one-way" name="trip-type" value="one-way" checked>
											<span></span>One Way
										</label>
										<label for="roundtrip">
											<input type="radio" id="roundtrip" name="trip-type" value="round">
											<span></span>Round Trip
										</label>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<span class="form-label">Departure</span>
											<select class="form-control" name="departure">
												<?php foreach ($departCountries as $departCountry) {
													echo "<option>" . $departCountry->from_country . "</option>";
												} ?>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<span class="form-label">Destination</span>
											<select class="form-control" name="destination">
												<?php foreach ($arriveCountries as $arriveCountry) {
													echo "<option>" . $arriveCountry->dest_country . "</option>";
												} ?>
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<span class="form-label">Departure</span>
											<input class="form-control" type="date" name="departure-date" required>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<span class="form-label">Return</span>
											<input class="form-control" type="date" name="return-date" required disabled>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<span class="form-label">Minimum Budget</span>
											<input class="form-control" type="number" min="1" name="min-budget">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<span class="form-label">Maximum Budget</span>
											<input class="form-control" type="number" name="max-budget">
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="form-checkbox">
										<label for="connecting-flight">
											<input type="radio" id="connecting-flight" name="flight-type" value="connecting-flight" checked>
											<span></span>Connecting Flights
										</label>
										<label for="direct-flight">
											<input type="radio" id="direct-flight" name="flight-type" value="direct-flight">
											<span></span>Direct Flight
										</label>
									</div>
								</div>
								<div class="form-btn">
									<button type="submit" class="submit-btn">Search flights <span class="d-none ml-2 spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="flights-data" class="container">
	</div>
</body>

<script>

    $("#booking-form").on("submit", function(event) {
    event.preventDefault();

        $.ajax("/flights", {
            type: "GET",
            data: $(this).serialize(),
            beforeSend: function() {
                $("#booking-form button").addClass("disabled");
                $("#booking-form button span").removeClass("d-none");
            },
            complete: function() {
                $("#booking-form button").removeClass("disabled");
                $("#booking-form button span").addClass("d-none");
            },
            success: function(res) {
                res = JSON.parse(res);

                $("#flights-data").html("");

                const {
                    departureFlights,
                    returnFlights
                } = res;

                let flights = -1;

                if (returnFlights) {
                    if (departureFlights.length > returnFlights.length && returnFlights.length != 0) {
                        flights = returnFlights.length;
                    } else if (returnFlights.length > departureFlights.length && departureFlights.length != 0) {
                        flights = departureFlights.length;
                    } else if (departureFlights.length == 0 || returnFlights.length == 0) {
                        flights = (departureFlights.length > returnFlights.length) ? departureFlights.length : returnFlights.length;
                    } else {
                        flights = departureFlights.length;
                    }
                } else {
                    flights = departureFlights.length;
                }


                for (let i = 0; i < flights; i++) {
                    let departureTemplate;
                    if (departureFlights.length == 0) {
                        departureTemplate = "<p class='text-center text-muted'>No flight available for <b>departure</b> on selected date. Please try another date.</p>";
                    } else {
                        departureTemplate = `<div class="row">
                            <div class="row col-md-10">
                                <div class="col-md-5">
                                    <p class="m-0 text-muted" style="font-size: 12px;">DEPARTURE</p>
                                    <h3>${departureFlights[i].from_airport_code}</h3>
                                    <p>${departureFlights[i].from_country}</p>
                                    <hr>
                                    <p class="m-0">${moment(departureFlights[i].departure_time).format('DD MMM YYYY')} - <b>${moment(departureFlights[i].departure_time).format('h:mm a')}</b></p>
                                </div>
                                <div class="col-md-2 d-flex flex-column align-items-center justify-content-center">
                                    <img class="img-fluid" src="/img/flying.png" style="transform: rotate(15deg);">
                                    <div class="duration">${timeConvert(departureFlights[i].duration)}</div>
                                    <div class="stop">${(departureFlights[i].stops) == 0 ? "Direct Flight" : departureFlights[i].stops + " Stop(s)"}</div>
                                </div>
                                <div class="col-md-5">
                                    <p class="m-0 text-muted" style="font-size: 12px;">ARRIVAL</p>
                                    <h3>${departureFlights[i].dest_airport_code}</h3>
                                    <p>${departureFlights[i].dest_country}</p>
                                    <hr>
                                    <p class="m-0">${moment(departureFlights[i].arrival_time).format('DD MMM YYYY')} - <b>${moment(departureFlights[i].arrival_time).format('h:mm a')}</b></p>
                                </div>
                            </div>
                            <div class="col-md-2 d-flex flex-column align-items-center justify-content-center lead">
                                <h3><b>$${departureFlights[i].price}</b></h3>
                                <a href="/booking/${departureFlights[i].id}" class="btn btn-primary">Book Now</a>
                            </div>
                        </div>`;
                    }


                    let returnTemplate = '';
                    if (returnFlights) {
                        if (returnFlights.length == 0) {
                            returnTemplate = "<hr><p class='text-center'>No flight available for <b>return</b> on selected date. Please try another date.</p>";
                        } else {
                            returnTemplate = `<hr>
                            <div class="row">
                                <div class="row col-md-10">
                                    <div class="col-md-5">
                                        <p class="m-0 text-muted" style="font-size: 12px;">DEPARTURE</p>
                                        <h3>${returnFlights[i].from_airport_code}</h3>
                                        <p>${returnFlights[i].from_country}</p>
                                        <hr>
                                        <p class="m-0">${moment(returnFlights[i].departure_time).format('DD MMM YYYY')} - <b>${moment(returnFlights[i].departure_time).format('h:mm a')}</b></p>
                                    </div>
                                    <div class="col-md-2 d-flex flex-column align-items-center justify-content-center">
                                        <img class="img-fluid" src="/img/flying.png" style="transform: rotate(15deg);">
                                        <div class="duration">${timeConvert(returnFlights[i].duration)}</div>
                                        <div class="stop">${(returnFlights[i].stops) == 0 ? "Direct Flight" : returnFlights[i].stops + " Stop(s)"}</div>
                                    </div>
                                    <div class="col-md-5">
                                        <p class="m-0 text-muted" style="font-size: 12px;">ARRIVAL</p>
                                        <h3>${returnFlights[i].dest_airport_code}</h3>
                                        <p>${returnFlights[i].dest_country}</p>
                                        <hr>
                                        <p class="m-0">${moment(returnFlights[i].arrival_time).format('DD MMM YYYY')} - <b>${moment(returnFlights[i].arrival_time).format('h:mm a')}</b></p>
                                    </div>
                                </div>
                                <div class="col-md-2 d-flex flex-column align-items-center justify-content-center lead">
                                    <h3><b>$${returnFlights[i].price}</b></h3>
                                    <a href="/booking/${returnFlights[i].id}" class="btn btn-primary">Book Now</a>
                                </div>
                            </div>`;
                        }

                        if (departureFlights.length == 0 && returnFlights.length == 0) {
                            departureTemplate = "<p class='text-center'>No flight available on selected dates. Please try other dates.</p>";
                        }
                    }


                    let template = `<div class="col-md-10 offset-md-1 py-2 px-4 my-4 border border-info rounded bg-light text-center">
                        ${departureTemplate}
                        ${returnTemplate}
                    </div>`;

                    $("#flights-data").append(template);
                }

                if (departureFlights.length == 0) {
                    flightTemplate = "<p class='text-center mt-3'>No flight available. Please try other dates.</p>";

                    let template = `<div class="col-md-10 offset-md-1 py-2 px-4 my-4 border border-info rounded bg-light text-center">
                        ${flightTemplate}
                    </div>`;

                    $("#flights-data").append(template);
                }

                window.scrollTo({
                    top: window.innerHeight,
                    behavior: "smooth"
                });
            }
        })
    });

	function timeConvert(n) {
		let num = n;
		let hours = (num / 60);
		let rhours = Math.floor(hours);
		let minutes = (hours - rhours) * 60;
		let rminutes = Math.round(minutes);
		return rhours + "h " + rminutes + "m";
	}

	$("[name='trip-type']").on("change", function() {
		if ($(this).attr("id") == "roundtrip") {
			$("[name='return-date']").attr('disabled', false)
		} else {
			$("[name='return-date']").attr('disabled', true)
		}
	});
</script>

</html>