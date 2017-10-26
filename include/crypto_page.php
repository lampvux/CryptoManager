<?php
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html>
<head>
<title>Crypto Management</title>
<link rel="stylesheet" href="<?=plugins_url('CryptoManagement/cry_assets/css/bootstrap.min.css')?>">
<link rel="stylesheet" href="<?=plugins_url('CryptoManagement/cry_assets/css/bootstrap-theme.min.css')?>">
<link rel="stylesheet" href="<?=plugins_url('CryptoManagement/cry_assets/css/jquery-ui.css' )?>">
<link rel="stylesheet" href="<?=plugins_url('CryptoManagement/cry_assets/css/dataTables.bootstrap.min.css' )?>">
<link rel="stylesheet" href="<?=plugins_url('CryptoManagement/cry_assets/css/style.css')?>">
</head>
<body>
	<!-- <nav>
		<ul>
			<li><a href="#" title="logout">Logout</a></li>
		</ul>
	</nav> -->
	<div class="container th-container">
		<div style="margin-bottom: 120px;">
			<div class="th-header-left">
				<p>Username - Date</p>
				<p>Dashboard</p>
				<p>- <a href="#">Settings</a> -</p>
			</div>
			<div class="th-header-right">
				<p>Total</p>
				<span class="th-total">1234$</span>
			</div>
		</div>
		<div style="margin-bottom: 20px;">
			<div id="chart_div" style="width: 100%; height: 500px;"></div>
			<div class="th-text-chart">
				<p>(Dates saved by user clicking below)</p>
				<span class="date_check">
					<span>Click <a href="">here</a> to insert a new "Date Check" now.</span>
				</span>
			</div>
		</div>
		<div style="margin-bottom: 570px;">
			<div class="th-float-left">
				<div id="big-piechart" style="width: 100%; height: 500px;"></div>
			</div>
			<div class="th-small-chart">
				<div class="th-small-pie-chart">
					<div>
						<span class="chart" data-percent="30" >
							<span class="percent"></span>
						</span>
					</div>
					<div>
						<span class="chart2" data-percent="44">
							<span class="percent"></span>
						</span>
					</div>
					<div>
						<span class="chart3" data-percent="64">
							<span class="percent"></span>
						</span>
					</div>
				</div>
				<div class="th-text-note">
					<textarea name="">Text</textarea>
				</div>
			</div>
		</div>
		<div style="padding: 15px;">
			<table id="myTable" class="display" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>header</th>
						<th>header</th>
						<th>header</th>
						<th>header</th>
						<th>header</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>data</td>
						<td>data</td>
						<td>data</td>
						<td>data</td>
						<td>data</td>
					</tr>
					<tr>
						<td>data</td>
						<td>data</td>
						<td>data</td>
						<td>data</td>
						<td>data</td>
					</tr>
					<tr>
						<td>data</td>
						<td>data</td>
						<td>data</td>
						<td>data</td>
						<td>data</td>
					</tr>
					<tr>
						<td>data</td>
						<td>data</td>
						<td>data</td>
						<td>data</td>
						<td>data</td>
					</tr>
					<tr>
						<td>data</td>
						<td>data</td>
						<td>data</td>
						<td>data</td>
						<td>data</td>
					</tr>
					<tr>
						<td>data</td>
						<td>data</td>
						<td>data</td>
						<td>data</td>
						<td>data</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
		
<script src="<?=plugins_url('CryptoManagement/cry_assets/js/jquery.min.js')?>"></script>
<script src="<?=plugins_url('CryptoManagement/cry_assets/js/jquery-ui.min.js')?>"></script>
<script src="<?=plugins_url('CryptoManagement/cry_assets/js/bootstrap.min.js')?>"></script>
<script src="<?=plugins_url('CryptoManagement/cry_assets/js/easypiechart.js')?>"></script>
<script src="<?=plugins_url('CryptoManagement/cry_assets/js/piechartloader.js')?>"></script>
<script src="<?=plugins_url('CryptoManagement/cry_assets/js/jquery.dataTables.min.js')?>"></script>
<script src="<?=plugins_url('CryptoManagement/cry_assets/js/dataTables.bootstrap.min.js')?>"></script>
<script src="<?=plugins_url('CryptoManagement/cry_assets/js/main.js')?>"></script>
</body>
</html>



