<?php
	
//get current user
	$current_user = wp_get_current_user();
	$cuid = get_current_user_id();
// change currency
	if (isset($_POST)&&isset($_POST['currencydefault'])){

		update_user_meta( $cuid, "user_currency", $_POST['currencydefault'] );
	}
// add new wallet	
	$alertaddwallet="";
	if (isset($_POST)&&isset($_POST['addwallet'])){
		$namewallet = trim($_POST['walletname']);
		$publicaddress = trim($_POST['publicaddress']);
		$currency = $_POST['walletcurrency'];
		$curarray = array("btc","eth","ltc","xrp","doge","uro","bcy");
		if (in_array($currency, $curarray)){
			$res = cry_addwallet($namewallet,$publicaddress,$currency);			
			if ($res!=0&&$res!=2){
				$alertaddwallet = "Add new wallet successfully";
			}
			else if ($res==2){
				$alertaddwallet = "This address already added ! Please try another.";
			}
			else {
				$alertaddwallet="Can not get information from this address ! Please try again.";
			}
		}
		else $alertaddwallet="Wrong currency input ! Please try again.";
	}
// update wallet	
	if (isset($_POST)&&isset($_POST['updatewallet'])){
		$wid = $_POST['wid'];
		$currency = $_POST['currency'];
		$namewallet = $_POST['updatewalletname'];
		$publicaddress = $_POST['updatepublicaddress'];
		$res = cry_updatewallet($wid,$currency,$namewallet,$publicaddress);			
		if ($res!=0&&$res!=2){
			$alertaddwallet = "Update wallet successfully";
		}
		else if ($res==2){
			$alertaddwallet = "This address already added ! Please try another.";
		}
		else {
			$alertaddwallet="Can not get information from this address ! Please try again.";
		}
	}
// delete wallet
	if (isset($_POST)&&isset($_POST['deletewallet'])){
		$wid = $_POST['wid'];
		cry_deletewallet($wid);		
		$alertaddwallet = "Delete wallet successfully";
	}
// get current currency
	$cur_currency = get_user_meta( $cuid, "user_currency", TRUE );
// get current date
	$datethis = Date("YMd");
	//print_r(getcheckdate());
	//print_r(ReturnAddressval('eth','1E2YSYLumyh1168ua5Qg7obvTTZFGGYrCm'));
	//print_r( GetFullAddressval('btc','1GbVUSW5WJmRCpaCJ4hanUny77oDaWW4to',50));

	//print_r(test());

?>
<!DOCTYPE html>
<html>
<head>
<title>Crypto Management</title>
<link rel="icon" type="image/png" href="<?=plugins_url('CryptoManagement/cry_assets/img/currencyexchange.png')?>">
<link rel="stylesheet" href="<?=plugins_url('CryptoManagement/cry_assets/css/bootstrap.min.css')?>">
<link rel="stylesheet" href="<?=plugins_url('CryptoManagement/cry_assets/css/bootstrap-theme.min.css')?>">
<link rel="stylesheet" href="<?=plugins_url('CryptoManagement/cry_assets/css/jquery-ui.css' )?>">
<link rel="stylesheet" href="<?=plugins_url('CryptoManagement/cry_assets/css/dataTables.bootstrap.min.css' )?>">
<link rel="stylesheet" href="<?=plugins_url('CryptoManagement/cry_assets/css/style.css')?>">
</head>
<body>
	<nav class="navbar navbar-light bg-faded">
		<div class="container-fluid">
		    <div class="navbar-header">
		      <a class="navbar-brand" href="<?=home_url();?>"><img src="<?=plugins_url('CryptoManagement/cry_assets/img/currencyexchange.png')?>" width="50" height="50" class="d-inline-block align-top" alt="Home"></a>
		    </div>
		    <ul class="nav navbar-nav navbar-brand">
		      <li class="active"><a href="<?=home_url();?>">Home</a></li>		      
		    </ul>
		    <ul class="nav navbar-nav navbar-right navbar-brand">
		      <li><a href="<?=wp_logout_url() ?>"><span class="glyphicon glyphicon-user"></span> Log Out</a></li>
		      
		    </ul>
		</div>
	  
	  
	</nav>
	
	<div class="container th-container">
		<div style="margin-bottom: 120px;">
			<div class="th-header-left">
				<b><p><?=strtoupper($current_user->display_name)?> - <?=$datethis?></p></b>
				<h3>DASHBOARD</h3>
				<p>- <a data-toggle="modal" href="#settingmodal" data-backdrop="false">SETTING</a> -<span class="pull-right"><?=$alertaddwallet?></span></p>
			</div>
			<div class="th-header-right">
				<p><b>Total</b></p>
				<input type="hidden" name="hidcurr" id="currencytype"  value="<?=($cur_currency=="")?"usd":$cur_currency?>">
				
				<span class="th-total"><span id="totalmoney"></span> <?php if ($cur_currency!=''){if ($cur_currency=="usd") {echo '$';}else  echo '€'; }else echo '$'; ?></span>
			</div>
		</div>
		<div style="margin-bottom: 20px;">
			<div id="chart_div" style="width: 100%; height: 50px; text-align:center;">
				Your data is being processed ...
			</div>
			<div class="th-text-chart">
				<p>(Dates saved by user clicking below)</br><span id="checkdatealert"></span></p>
				<span class="date_check">
					<span><a id="insertcheckdate" href="#checkdate">CLICK HERE to insert a new "Date Check" now. </a> </span>
				</span>
			</div>
		</div>
		<!-- MODAL change currency -->
		<div class="modal fade" id="settingmodal" role="dialog">
			<div class="modal-dialog">		
			<!-- Modal content-->
			<div class="modal-content">
				<form action="" method="post">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Change Default Currency</h4>
					</div>
					<div class="modal-body">
						<label for="">Change your default currency</label></br>
						<label for="">USD</label>
						
						<input type="radio" name="currencydefault" value="usd" id="usd" <?php if ($cur_currency!=''){if ($cur_currency=="usd") echo 'checked';}else echo 'checked'; ?>>
						<label for="">EUR</label>
						<input type="radio" name="currencydefault" value="eur" id="eur" <?php if ($cur_currency!=''){if ($cur_currency=="eur") echo 'checked';}?>>
					</div>
					<div class="modal-footer">
						<input type="submit" value="Change Currency" class="btn btn-info" >
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					</div>
				</form>
			</div>			
			</div>
		</div>
		<!-- MODAL change currency -->
		
		<div id="margin570" >
			<div class="th-float-left">
				<div id="big-piechart" style="width: 100%;   text-align:center;">
				Your data is being processed ...

				</div>
			</div>
			<div class="th-small-chart">
				<div class="th-small-pie-chart">
					<div style="display: inline-grid;">
						<span class="chart" id="firstchart" data-percent="0" >
							<span class="percent" id="firstpercent"></span>
						</span>
						<div id="firstwallet"></div>
					</div>
					<div style="display: inline-grid;">
						<span class="chart2" id="secondchart" data-percent="0">
							<span class="percent" id="secondpercent"></span>
						</span>
						<div id="secondwallet"></div>
					</div>
					<div style="display: inline-grid;">
						<span class="chart3" id="thirdchart" data-percent="0">
							<span class="percent" id="thirdpercent"></span>
						</span>
						<div id="thirdwallet"></div>
					</div>
				</div>
				<div class="th-text-note">
					<textarea id="user_note" name="" ><?=urldecode(get_user_meta( get_current_user_id(), 'user_note', true ))?></textarea>
				</div>
			</div>
		</div>
		<div class="col-md-12"  style="background-color:#fff;color:#203764;font-family:futura;padding:20px; font-weight:medium;font-size:17px;  ">
		<div class="col-md-11">
			<table id="userwallet" class="table table-striped table-bordered display" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>Wallet Name</th>
						<th>Crypto Currency</th>
						<th>Crypto Amount</th>
						<th>EUR</th>
						<th>USD</th>
						<th>More Info</th>
					</tr>
				</thead>
				<tbody>
					
				</tbody>
			</table>
			        
        </div>
		<div class="pull-right col-md-1" style="background-color:#fff;">
			<a data-toggle="modal" href="#addwallet" class="btn btn-lg btn-info btn-outline"  data-toggle="tooltip" title="Add new wallet ...">+</a>
		</div> 
		</div>
		<!-- MODAL add wallet -->
		<div class="modal fade" id="addwallet" role="dialog">
			<div class="modal-dialog">		
			<!-- Modal content-->
			<div class="modal-content">
				<form action="" method="post" id="addwalletform">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">ADD NEW WALLET</h4> <span id="addw-alert" style="color:red;"></span>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="">Wallet Name  : </label></br>
							<input type="text" name="walletname" id="wallet-name" class="form-control" required>
							<label for="">Your Public Address : </label></br>
							<input type="text" name="publicaddress" id="public-address" class="form-control" required>
							<label for="">Wallet Currency  : </label></br>
							<select name="walletcurrency"  class="form-control">
								<option value="btc">BTC</option>
								<option value="eth">ETH</option>
								<option value="xrp">XRP</option>
								<option value="ltc">LTC</option>
								<option value="uro">URO</option>
								<option value="bcy">BCY</option>
								<option value="doge">DOGE</option>
							</select>
							
							
						</div>
					</div>
					<div class="modal-footer">
						<input type="submit" value="Add" name="addwallet" class="btn btn-info" >
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					</div>
				</form>
			</div>			
			</div>
		</div>
		<!-- MODAL add wallet --> 
		<!-- START MODAL more info -->
		<div class="modal fade" id="details-wallet" role="dialog">
				<div class="modal-dialog modal-lg">		
					<!-- Modal content-->
					<div class="modal-content">
						<form action="" method="post" id="updatewalletform">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">MORE INFO</h4> <span id="updatew-alert" style="color:red;"></span>
							</div>
							<div class="modal-body">
								<div class="form-group">
									<label for="">Wallet Name  : </label></br>
									<input type="text" name="updatewalletname" id="wallet-name-update" class="form-control" value="" required>
									<label for="">Your Public Address : </label></br>
									<input type="text" name="updatepublicaddress" id="public-address-update" class="form-control" value="" required></br>
									<input type="hidden" name="wid" value="">
									<input type="hidden" name="currency" value="">
									<label for="">Wallet's Currency : </label></br>
									<select name="currency" id="updatecurrency" class="form-control">
										<option value="btc">BTC</option>
										<option value="eth">ETH</option>
										<option value="xrp">XRP</option>
										<option value="ltc">LTC</option>
										<option value="uro">URO</option>
										<option value="bcy">BCY</option>
										<option value="doge">DOGE</option>
									</select>
									</br>
									<div class="th-btn-update">
										<input type="submit" value="Update" name="updatewallet" class="btn btn-info pull-left">
										<a href="#" class="btn btn-warning pull-right" id="loadmoretrans" >Load All Transaction</a>
										
									</div>

									<table id="wallettransaction" class="table table-striped table-bordered" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th>#</th>
												<th>Transaction</th>
												<th>Amount</th>
												<th>USD</th>
												<th>EUR</th>
											</tr>
										</thead>
										<tbody>
										
										</tbody>
									</table>
								</div>
							</div>
							<div class="modal-footer">
								<!-- <button class="btn btn-danger" data-toggle="collapse" data-toggle="tooltip" title="Delete this wallet" href="#deletewal">Delete</button> -->
								<input type="submit" value="Delete" name="deletewallet" class="btn btn-danger" onclick="return confirm('Are you sure?')">
								<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
							</div>
						</form>
					</div>	
				</div>		
			</div>
			<!-- END MODAL more info -->
		<div style="padding: 15px;">
			
		</div>
	</div>
	
<script src="<?=plugins_url('CryptoManagement/cry_assets/js/jquery.min.js')?>"></script>
<script src="<?=plugins_url('CryptoManagement/cry_assets/js/jquery-ui.min.js')?>"></script>
<script src="<?=plugins_url('CryptoManagement/cry_assets/js/bootstrap.min.js')?>"></script>
<script src="<?=plugins_url('CryptoManagement/cry_assets/js/jquery.easypiechart.min.js')?>"></script>
<script src="<?=plugins_url('CryptoManagement/cry_assets/js/piechartloader.js')?>"></script>
<script src="<?=plugins_url('CryptoManagement/cry_assets/js/jquery.dataTables.min.js')?>"></script>
<script src="<?=plugins_url('CryptoManagement/cry_assets/js/dataTables.bootstrap.min.js')?>"></script>
<script src="<?=plugins_url('CryptoManagement/cry_assets/js/main.js')?>"></script>
<script>
	$(document).ready(function(){
		// datatable get wallet
		var currencytype = $("input#currencytype").val();
		var allwalletname =[];		
	
		
		getdataarea(function(data){	

			
			var opponent = JSON.parse(data);
			if (opponent.length>0){
			console.log(opponent)
			var datname = [];
			var datdate = [];
			var dataall = [];
			var lg = opponent.length;
			var last = opponent[lg-1];
			var x= [[lg],[last.length]];
			x= zeros(x,function(returnval){
				
			})
			console.log(x);
			
			// get all name
			$.each(opponent[lg-1],function(index,daycheck) {				
				datname[index] = daycheck['wallet_name'];	
			})
			var curdat = [[],[]];
			$.each(opponent,function(index,daycheck) {				
				datdate[index] = daycheck[0]['date_check'];
				var i=0;			
				
				daycheck.forEach(function(element,indexnew) {
					var rate = 'rate'+element['currency']+"_"+currencytype+'';
					
					var indexval="";
					
					switch (rate) {
						case "ratebtc_usd":
							indexval = element["ratebtc_usd"];
							break;
						case "ratebtc_eur":
							indexval = element["ratebtc_eur"];
							break;
						case "rateeth_usd":
							indexval = element["rateeth_usd"];
							break;
						case "rateeth_eur":
							indexval = element["rateeth_eur"];
							break;
						case "rateltc_usd":
							indexval = element["rateltc_usd"];
							break;
						case "rateltc_eur":
							indexval = element["rateltc_eur"];
							break;
						case "ratebcy_usd":
							indexval = element["ratebcy_usd"];
							break;
						case "ratebcy_eur":
							indexval = element["ratebcy_eur"];
							break;
						case "ratexrp_usd":
							indexval = element["ratexrp_usd"];
							break;
						case "ratexrp_eur":
							indexval = element["ratexrp_eur"];
							break;
						case "ratedoge_usd":
							 indexval = element["ratedoge_usd"];
							break;
						case "ratedoge_eur":
							 indexval = element["ratedoge_eur"];
							break;
						default:
							break;
					}
					
					//x[index][i] = parseFloat(element['total'])*parseFloat(indexval);
					x[index][i] = parseFloat(element['total'])*parseFloat(indexval);
					i++;
				}, this);

			})
			
			areachart(datdate,datname,x);
			

		}
		});
		
		$('#userwallet').DataTable({
			"ajax": { 
				"url" : window.location.origin+"/wordpress/wp-admin/admin-ajax.php",
				"data": {
					"action":"cry_getallwallet"	
				}						
			},
            "columnDefs": [ 
					{
                    	"targets": -1,
                        "data":'id',
                        "mRender": function(data, type, full) {
                            return '<a class="btn  btn-md btn-info " data-walletid='+data+' data-toggle="modal" data-toggle="tooltip" title="View more info. wallet" onclick="getwallet('+data+',50)" href="#details-wallet"> > </a>';
                          }
                    } ,
                    
                    {
                        "targets": -2,
                        "data": 'usd'
                    },
                    {
                        "targets": -3,
                        "data": 'eur'
                    },
                    {
                        "targets": -4,
                        "data": 'amount'
                    },
                    {
                        "targets": -5,
                        "data": 'currency'
                    },
                    {
                        "targets": -6,
                        "data": 'name'
                    }
            ],		
        "initComplete":function( settings, json){
			// change total money 
			var sum=0.0;
			var currencytype = $("#currencytype").val();
			var walletamount = [];
			var walletbaseamount = [];
			var walletname = [];
			var walletnamesort = [];
            $.each(json['data'],function(index,element) {
				walletamount[index] = parseFloat(element[currencytype]);
				walletbaseamount[index] = parseFloat(element[currencytype]);
				walletname[index] = element['name']+"-"+element['currency'].toUpperCase();				

				sum+=parseFloat(element[currencytype]);				
			}, this);
			$("#totalmoney").text(sum);
			
			walletnamesort  = sortWithIndeces(walletbaseamount);
			console.log(walletnamesort);
			walletamount.sort(function(a, b){return b-a});
			console.log(walletamount);
			if (walletamount.length>0){
				// START SMALL PIE CHART
				$(".th-small-pie-chart").css("display","block");
				$(".th-small-pie-chart").css("height","210px");
				// chart 1
				$('.chart').easyPieChart({
					delay: 3000,
					barColor: '#69c',
					trackColor: '#ace',
					scaleColor: false,
					lineWidth: 20,
					trackWidth: 16,
					lineCap: 'butt'
					
				});				
				// first small pie chart
				$("#firstpercent").html(Math.round(walletamount[0]/sum*100,1)+"%");
				$('.chart').data('easyPieChart').update(Math.round(walletamount[0]/sum*100));
				$("#firstwallet").html(walletname[walletnamesort[0]]+"</br>"+ Math.round(walletamount[0],1) +" "+currencytype );
				if (walletamount.length>1) {
					$('.chart2').easyPieChart({
						delay: 3000,
						barColor: '#69c',
						trackColor: '#ace',
						scaleColor: false,
						lineWidth: 20,
						trackWidth: 16,
						lineCap: 'butt'
					});
					// second small pie chart
					$('.chart2').data('easyPieChart').update(Math.round(walletamount[1]/sum*100));
					$("#secondpercent").html(Math.round(walletamount[1]/sum*100,1)+"%");
					$("#secondwallet").html(walletname[walletnamesort[1]]+"</br>"+ Math.round(walletamount[1],1)+" " +currencytype );
				}
				if (walletamount.length>2) {
					$('.chart3').easyPieChart({
						delay: 3000,
						barColor: '#69c',
						trackColor: '#ace',
						scaleColor: false,
						lineWidth: 20,
						trackWidth: 16,
						lineCap: 'butt'
					});
					// third small pie chart
					$('.chart3').data('easyPieChart').update(Math.round(walletamount[2]/sum*100));
					$("#thirdpercent").html(Math.round(walletamount[2]/sum*100,1)+"%");
					$("#thirdwallet").html(walletname[walletnamesort[2]]+"</br>"+  Math.round(walletamount[2],1)+" " +currencytype);
				}

				$("#big-piechart").css("height","500px");
				$(".th-text-note textarea").css("height","270px");
				$("#margin570").css("margin-bottomx","570px");

				// START BIG PIE CHART
				google.charts.load('current', {'packages':['corechart']});
				google.charts.setOnLoadCallback(drawPieChart);

				function drawPieChart() {
					var data = new google.visualization.DataTable();
					data.addColumn('string', 'Wallet Name');
					data.addColumn('number', "Amount");

					data.addRows(walletname.length);
					for (var index = 0; index < walletname.length; index++) {
						data.setCell(index, 0, walletname[walletnamesort[index]]);
						
					}
					for (var index = 0; index < walletamount.length; index++) {
						data.setCell(index, 1, walletamount[index]);
						
					}
					

					var options = {
						title: 'My All Wallets',
						legend:{
				          	maxLines:1,
				          	textStyle:{ 
				          		color: 'black',			                    
				            	fontSize: 12
				            }
				          }
					};

					var chart = new google.visualization.PieChart(document.getElementById('big-piechart'));

					chart.draw(data, options);
				} 
				// END BIG PIE CHART
			}
		}
		} 
	);
	
	function zeros(dimensions,callback) {
	    var array = [];

	    for (var i = 0; i < dimensions[0]; ++i) {
	        array.push(dimensions.length == 1 ? 0 : zeros(dimensions.slice(1)));
	    }

	   return array;
	}


	// sort indeces function
	function sortWithIndeces(toSort) {
			for (var i = 0; i < toSort.length; i++) {
				toSort[i] = [toSort[i], i];
			}
			toSort.sort(function(left, right) {
				return left[0] > right[0] ? -1 : 1;
			});
			toSort.sortIndices = [];
			thesortindices=[];
			for (var j = 0; j < toSort.length; j++) {
				thesortindices.push(toSort[j][1]);
				toSort[j] = toSort[j][0];
			}
			return thesortindices;
			}


		// click the load more data
		$("#loadmoretrans").click(function(){
			getwallet($("input[name='wid']").val(),200);
		});
		//click the check date
		$("#insertcheckdate").click(function(e){
			$(this).text("Processing...");
			$(this).css("disabled","disabled");
			e.preventDefault();

			insertcheckdate(function(result){
				$("#insertcheckdate").text('CLICK HERE to insert a new "Date Check" now.');
				$("#checkdatealert").text(result);

			});
			return false;
		})
		
		// form validation
	   $("#addwalletform").submit(function(e){
			var name=$("#wallet-name").val().trim();
			var address=$("#public-address").val().trim();
			if (name==null || name=="",address==null || address=="")
			{
				$("#addw-alert").text("Please Fill All Required Field !");
				e.preventDefault(); // Cancel the submit
				return false;
			}
	   });
	  
	   
	})
	function getwalletname(callback){
					$.ajax({
						url:  window.location.origin+"/wordpress/wp-admin/admin-ajax.php",
						async: true,
						data : {
							action: 'cry_getwalletname'
						}, 
						type:"GET",
						dataType:"text",       		
						success:function(result){				
							callback(result);

						},
						error: function(result) {
							
						}
					});	
	}
	//
	function getdataarea(callback){
					$.ajax({
						url:  window.location.origin+"/wordpress/wp-admin/admin-ajax.php",
						async: true,
						data : {
							action: 'cry_getarechart'
						}, 
						type:"GET",
						dataType:"text",       		
						success:function(result){				
							callback(result);

						},
						error: function(result) {
							
						}
					});	
	}
	// START AREA CHART
	function areachart(datedata,namedata,moneydata){
		if (datedata.length>0&&namedata.length>0&&moneydata.length>0){
			google.charts.load('current', {'packages':['corechart']});
			google.charts.setOnLoadCallback(drawAreaChart);
			$("#chart_div").css("height","500px");
			function drawAreaChart() {
					var data = new google.visualization.DataTable();				
					
					// Declare columns

					data.addColumn('string', 'Check Date');
					namedata.forEach(function(element,index) {
						data.addColumn('number', element);
					}, this);
					
					data.addRows(moneydata.length);
					
					datedata.forEach(function(element,index) {
						data.setCell(index, 0, element.split(" ")[0]+"");
						
					}, this);
					for (var index = 0; index < moneydata.length; index++) {
						for (var indexs = 0; indexs < moneydata[index].length; indexs++) {
							
							data.setCell(index, (indexs+1), moneydata[index][indexs]);
						}
					}
					var options = {
						 isStacked: true,
						title: 'Wallets Evolution',
						hAxis: {title: 'DATE CHECK',  titleTextStyle: {color: '#369',italic: true}},
						vAxis: {minValue: 0},
						tooltip: {trigger: 'selection'}
						//selectionMode: 'multiple'
					};
					
					var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
					chart.draw(data, options);
			}
		}
		
	}
	// insert check date function
	function insertcheckdate(callback){
		$.ajax({
       		url:  window.location.origin+"/wordpress/wp-admin/admin-ajax.php",
			async: true,
			data : {
				action: 'cry_insertcheckdate'
			}, 
       		type:"POST",
       		dataType:"text",       		
       		success:function(result){				
       		   	callback(result);
       		},
       		error: function(result) {
       			
       		}
       	});	
	}

	// get all money function
	function getallmoney(callback){
		$.ajax({
       		url:  window.location.origin+"/wordpress/wp-admin/admin-ajax.php",
			async: true,
			data : {
				action: 'cry_getallmoney'
			}, 
       		type:"GET",
       		dataType:"text",       		
       		success:function(result){				
       		   	callback(result);
       		},
       		error: function(result) {
       			
       		}
       	});	
	}
	// calculate wallet balance ajax
	function returnallbalance(callback){
		$.ajax({
       		url:  window.location.origin+"/wordpress/wp-admin/admin-ajax.php",
			async: true,
			data : {
				action: 'cry_returnallbalance'
			}, 
       		type:"GET",
       		dataType:"text",       		
       		success:function(result){
				//var opponent = JSON.parse(result);
       		   	callback(result);
       		},
       		error: function(result) {
       			
       		}
       	});	
	}
	// get all wallet function ajax
	function getallwallet(callback){
		$.ajax({
       		url:  window.location.origin+"/wordpress/wp-admin/admin-ajax.php",
			async: true,
			data : {
				action: 'cry_getallwallet'
			}, 
       		type:"GET",
       		dataType:"text",       		
       		success:function(result){
				var opponent = JSON.parse(result);
       		   	callback(opponent['data']);
       		},
       		error: function(result) {
       			
       		}
       	});		
	}
	// function get wallet with id
	function getwallet(id,limit){
		$.ajax({
			url:  window.location.origin+"/wordpress/wp-admin/admin-ajax.php",
			async: true,
			data : {
				action: 'cry_getwalletid',
				walletid: id
			}, 
			type:"POST",
			dataType:"text",       		
			success:function(result){
				var opponent = JSON.parse(result);
				console.log(opponent);
				$("#wallet-name-update").val(opponent[0]['wallet_name']);
				$("#public-address-update").val(opponent[0]['address']);				
				$("input[name='wid']").val(opponent[0]['id']);
				$("#updatecurrency").val(opponent[0]['currency']);

				transaction(opponent[0]['address'],opponent[0]['currency'],limit);
				

			},
			error: function(result) {	
			}
		});	
	}
	//function transaction data table

	function transaction(address,currency,limit){
		/* $.ajax({
			url:  window.location.origin+"/wordpress/wp-admin/admin-ajax.php",
			async: true,
			"data": {
				"action":	"gettransaction",
				"currency":	currency,
				"address":	address,
				"limit":limit
			},	 
			type:"POST",
			dataType:"text",       		
			success:function(result){
			
			},
			error: function(result) {	
			}
		}); */
		if ( $.fn.DataTable.isDataTable('#wallettransaction') ) {
		  $('#wallettransaction').DataTable().destroy();
		}	
		 $("#wallettransaction").DataTable({
						
						"ajax": { 
							"url" : window.location.origin+"/wordpress/wp-admin/admin-ajax.php",
							"type":"POST",
							"data": {
								"action":	"cry_gettransaction",
								"currency":	currency,
								"address":	address,
								"limit":limit
							}						
						},
						"columns": [
							{ "data": "id" },
							{ "data": "dateconfirm" },
							{ "data": "amount" },
							{ "data": "usd" },
							{ "data": "eur" }
						],		
					"initComplete":function( settings, json){
					}
				}); 
	}
	// when user change note
	$("#user_note").change(function(){    
		var text=$(this).val();
    	
		jQuery.post(
            window.location.origin+"/wordpress/wp-admin/admin-ajax.php", {
                action: 'cry_save_note',               
                user_note: text
            },
            function(data) {                
                var opponent = JSON.parse(data);				
				$("#user_note").val(opponent);
               
            }
        );
	});
	// when user update wallet
	$("#updatewalletform").submit(function(e){
		var name=$("#wallet-name-update").val().trim();
		var address=$("#public-address-update").val().trim();
		if (name==null || name=="",address==null || address=="")
		{
			$("#updatew-alert").text("Please Fill All Required Field !");
			e.preventDefault(); // Cancel the submit
			return false;
		}
   	});

	$('[data-toggle="tooltip"]').tooltip();
</script>	


</body>
</html>



