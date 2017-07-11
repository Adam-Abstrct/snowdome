<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="refresh" content="3600">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<META name="robots" content="noindex, nofollow">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">
	<title>Snowdome Dashboard </title>

	<script src="https://use.typekit.net/cua7pjh.js"></script>
	<script>try{Typekit.load({ async: true });}catch(e){}</script>

</head>
<body>

	<header>
		<div class="container">

			<div class="logo__snowdome">
				<img src="assets/imgs/logo.png">
			</div>

			<div class="green"> Total Green Energy Generation <span id="green"></span></div>
			<img class="logo__lightsource" src="assets/imgs/logo-white.png">

		</div>
	</header>

	<div class="container">
		<!-- Main Graph -->
		<div class="chart__main" style="width:100%;"></div>

		<div class="row">

			<div class="module__wrap">
				<div class="module module__co2">
					<h3 class="module__header">C02 SAVED</h3>
					<div class="module__content">
						<div class="module__icon-wrap">
							<img class="module__image" src="assets/imgs/c02.png">
						</div>
						<div class="module__info" id="cO2"><p></p></div>
					</div>
				</div>
			</div>

			<div class="module__wrap">
				<div class="module module__trees">
					<h3 class="module__header">CARS OFF THE ROAD </h3>
					<div class="module__content">
						<div class="module__icon-wrap">
							<div class="module__icon"><i class="fa fa-car" aria-hidden="true"></i></div>
						</div>
						<div class="module__info" id="cars"><p></p></div>
					</div>
				</div>
			</div>

			<div class="module__wrap">
				<div class="module module__houses">
					<h3 class="module__header">HOUSES POWERED </h3>
					<div class="module__content">
						<div class="module__icon-wrap">
							<img class="module__image" src="assets/imgs/houses.png">
						</div>
						<div class="module__info" id="houses"><p></p></div>
					</div>
				</div>
			</div>

			<div class="module__wrap">
				<div class="module">
					<h3 class="module__header">INSTALLED CAPACITY </h3>
					<div class="module__content">
						<div class="module__icon-wrap">
							<div class="module__icon"><i class="fa fa-bolt" aria-hidden="true"></i></div>
						</div>
						<div class="module__info"><p>250 <span style="font-size:14px;" class="weight--normal"> kWp</span></p></div>
					</div>
				</div>
			</div>

			<div class="module__wrap">
				<div class="module">
					<h3 class="module__header">CONNECTION DATE </h3>
					<div class="module__content">
						<div class="module__icon-wrap">
							<div class="module__icon"><i class="fa fa-calendar" aria-hidden="true"></i></div>
						</div>
						<div class="module__info" id="connection"><p>24-03-2016</p></div>
					</div>
				</div>
			</div>


			<div class="module__wrap">
				<div class="module">
					<h3 class="module__header">NUMER OF PANELS </h3>
					<div class="module__content">
						<div class="module__icon-wrap">
							<div class="module__icon">
								<i class="fa fa-sun-o" aria-hidden="true"></i>
							</div>
						</div>
						<div class="module__info"><p>943 <span style="font-size:14px;" class="weight--normal">panels</span></p></div>
					</div>
				</div>
			</div>




		</div>
	</div>

	<div class="container">
		<footer>
			<div class="tips">
				<div class="tips__title">
					<i class="fa fa-info-circle tips__icon" aria-hidden="true"></i> Solar Energy Facts -
				</div>
				<div class="tips__container">
					<p>Electrical power is measured in watts (W) &#45; 1000W of power is a kilowatt (kW)</p>
					<p>The largest solar power plant in the world is located in the Mojave Desert in California, covering 1000 acres.</p>
					<p>More than 500,000 households have solar PV panels on their roofs in the UK as of the beginning of 2014.</p>
					<!-- <p> The cost of solar panels has fallen approximately 100 times over since 1977, and solar panels today are about half as cheap as they were in 2008!</p> -->
					<p>More than 80% of the British public support solar power &#45; it is the most popular source of energy.</p>
					<p>10% of the UK&#39;s renewable power comes from solar power, or 1.5% of total UK electricity</p>
					<p>The earth receives about 1,366 watts of direct solar radiation per square meter</p>
					<p>It would take only around 0.3 per cent of the world&#39;s land area to supply all of our electricity needs via solar power</p>
					<p>The Earth receives more energy from the sun in an hour than is used in the entire world in one year!</p>
					<p>Manufacturing solar cells produces 90% less pollutants than conventional fossil fuel technologies.</p>
					<p>The first solar cell was constructed by Charles Fritts in the 1880s</p>
					<p>Solar installations from Lightsource offset 600,000 tonnes of carbon every year, which is the equivalent of planting 375 square miles of forest!</p>
					<p>Lightsource generates enough electricity to power 370,000 homes each year</p>
					<p>There are 943 individual solar panels on the roof of the SnowDome!</p>
				</div>
			</div>
			<div class="social">
				<ul class="social__nav">
					<li class="social__item"><i class="fa fa-twitter social__icon" aria-hidden="true"></i>@SnowDomeTam</li>
					<li class="social__item"><i class="fa fa-twitter social__icon" aria-hidden="true"></i>@LightsourceRE</li>
				</ul>
			</div>
		</footer>
	</div>

	<script src="https://code.jquery.com/jquery-3.1.0.min.js"   integrity="sha256-cCueBR6CsyA4/9szpPfrX3s49M9vUU5BgtiJj06wt/s="   crossorigin="anonymous"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/data.js"></script>
	<script type="text/javascript" src="./assets/js/main.min.js"></script>


</body>
</html>
