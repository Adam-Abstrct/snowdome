<!DOCTYPE html>
<html>
<head>

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="./assets/css/style.css">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">
	<title>Snowdome Dashboard </title>

	<script src="https://use.typekit.net/cua7pjh.js"></script>
	<script>try{Typekit.load({ async: true });}catch(e){}</script>
 
</head>
<body>

	<header>
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-6 col-sm-offset-1">
					<div class="logo__snowdome">
						<img src="/assets/imgs/logo.png">
					</div>
				</div>
				<div class="col-sm-2">
					<img class="logo__lightsource" src="/assets/imgs/logo-white.png">
				</div>
				<div class="col-sm-2">
					<div class="green"> Green Energy Production <span id="green"></span></div>
				</div>
			</div>
		</div>
	</header>

	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1">
				<!-- Main Graph -->
					<div class="chart__main" style="width:100%;"></div>
			</div>				
		</div>
		<div class="row">

			<div class="col-sm-2 col-sm-offset-1">
				<div class="module module__co2">
					<h3 class="module__header">C02 SAVED</h3>
					<div class="module__content">
						<div class="col-sm-6">
							<img class="module__image" src="/assets/imgs/c02.png">
						</div>
						<div class="col-sm-6">
							<div class="module__info" id="cO2"><p></p></div>
						</div>		
					</div>
				</div>
			</div>

			<div class="col-sm-2">
				<div class="module module__trees">
					<h3 class="module__header">TREES PLANTED </h3>
					<div class="module__content">
						<div class="col-sm-6">
							<img class="module__image" src="/assets/imgs/tree.png">
						</div>
						<div class="col-sm-6">
							<div class="module__info" id="trees"><p></p></div>	
						</div>
					</div>
				</div>
			</div>

			<div class="col-sm-2">
				<div class="module module__houses">
					<h3 class="module__header">HOUSES POWERED </h3>
					<div class="module__content">
						<div class="col-sm-6">
							<img class="module__image" src="/assets/imgs/houses.png">
						</div>
						<div class="col-sm-6">
							<div class="module__info" id="houses"><p></p></div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-sm-2">
				<div class="module">
					<div class="module__content">
					<table class="table">
							<tr>
								<td class="table__key"> Installed capacity </td>
								<td class="table__value"> 00000 </td>
							</tr>
							<tr>
								<td class="table__key"> Connection Date </td>
								<td class="table__value"> 00000 </td>
							</tr>
							<tr>
								<td class="table__key"> Number of panels </td>
								<td class="table__value"> 00000 </td>
							</tr>
						</table>
					</div>
				</div>
			</div>

			<div class="col-sm-2"> 
				<div class="module">
					<div class="module__content">
						<table class="table">
							<tr>
								<td class="table__key"> Installed capacity </td>
								<td class="table__value"> 00000 </td>
							</tr>
							<tr>
								<td class="table__key"> Installed capacity </td>
								<td class="table__value"> 00000 </td>
							</tr>
							<tr>
								<td class="table__key"> Installed capacity </td>
								<td class="table__value"> 00000 </td>
							</tr>
						</table>
					</div>
				</div>
			</div>

		</div>
	</div>

	<footer>
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-10 col-sm-offset-1 footer__cont">
					<div class="col-sm-8">
						<div class="tips">
							<div style="float:left; width:20%">
								<div class="tips__title">
									<p><i class="fa fa-info-circle tips__icon" aria-hidden="true"></i> Solar Energy Tips - </p>
								</div>
							</div>
							<div style="float:left; width:80%;">
								<div class="tips__container">
									<p>jdiojidjsfiojsd fiojsiodfjdiosfsd</p>
									<p>hpojkophkjoptkjo pktjopktopjkhopjkohpgkjhopgkjophg </p>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
									</p>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
									</p>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
									</p>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="social">
							<ul class="social__nav">
								<li class="social__item"><i class="fa fa-twitter social__icon" aria-hidden="true"></i>@SnowDomeTam</li>		
								<li class="social__item"><i class="fa fa-twitter social__icon" aria-hidden="true"></i>@LightsourceEE</li>		
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</footer>

	<script src="https://code.jquery.com/jquery-3.1.0.min.js"   integrity="sha256-cCueBR6CsyA4/9szpPfrX3s49M9vUU5BgtiJj06wt/s="   crossorigin="anonymous"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/data.js"></script>
	<script type="text/javascript" src="./assets/js/main.min.js"></script>
	

</body>
</html>