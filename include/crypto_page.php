<?php

//get current user
	$current_user = wp_get_current_user();
	$cuid = get_current_user_id();
// change currency
	if (isset($_POST)&&isset($_POST['currency'])){

		update_user_meta( $cuid, "user_currency", $_POST['currency'] );
	}
// add new wallet	
	$alertaddwallet="";
	if (isset($_POST)&&isset($_POST['addwallet'])){
		$namewallet = $_POST['walletname'];
		$publicaddress = $_POST['publicaddress'];
		$currency = $_POST['walletcurrency'];
		$curarray = array("btc","eth","ltc","xrp","doge","uro","bcy");
		if (in_array($currency, $curarray)){
			$res = addwallet($namewallet,$publicaddress,$currency);			
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
// get current currency
	$cur_currency = get_user_meta( $cuid, "user_currency", TRUE );
// get current date
	$datethis = Date("YMd");
	
	//$address = ReturnAddressval('btc','3QMMChS6t7VQcf4LhHfbXjsfkRmkb55sTv');
	

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
				<p><?=$current_user->display_name?> - <?=$datethis?></p>
				<h3>DASHBOARD</h3>
				<p>- <a data-toggle="modal" href="#settingmodal" data-backdrop="false">SETTING</a> -<span class="pull-right"><?=$alertaddwallet?></span></p>
			</div>
			<div class="th-header-right">
				<p>Total</p>
				<span class="th-total">1234 <?php if ($cur_currency!=''){if ($cur_currency=="usd") {echo '$';}else  echo '€'; }else echo '$'; ?></span>
			</div>
		</div>
		<div style="margin-bottom: 20px;">
			<div id="chart_div" style="width: 100%; height: 500px;"></div>
			<div class="th-text-chart">
				<p>(Dates saved by user clicking below)</p>
				<span class="date_check">
					<span>Click <a data-toggle="modal" data-backdrop="false" href="#checkdate">HERE</a> to insert a new "Date Check" now.</span>
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
						
						<input type="radio" name="currency" value="usd" id="usd" <?php if ($cur_currency!=''){if ($cur_currency=="usd") echo 'checked';}else echo 'checked'; ?>>
						<label for="">EUR</label>
						<input type="radio" name="currency" value="eur" id="eur" <?php if ($cur_currency!=''){if ($cur_currency=="eur") echo 'checked';}?>>
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
		<!-- MODAL CHECK DATE -->
		<div class="modal fade" id="checkdate" role="dialog">
			<div class="modal-dialog">		
			<!-- Modal content-->
			<div class="modal-content">
				<form action="" method="post">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">CHECK DATE</h4>
					</div>
					<div class="modal-body">
					</div>
					<div class="modal-footer">
						<input type="submit" value="Change Currency" class="btn btn-info" data-dismiss="modal" >
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					</div>
				</form>
			</div>			
			</div>
		</div>
		<!-- MODAL CHECKDATE -->
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
					<textarea id="user_note" name="" ><?=urldecode(get_user_meta( get_current_user_id(), 'user_note', true ))?></textarea>
				</div>
			</div>
		</div>
		<div class="col-md-12"  style="background-color:#fff;color:#203764;font-family:futura;padding:20px; font-weight:medium;font-size:17px;  ">
		<div class="col-md-11">
			<table id="userwallet" class="display" cellspacing="0" width="100%">
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
		<div style="padding: 15px;">
			
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
<script>
	$(document).ready(function(){
		$('#userwallet').DataTable({
			"ajax": { 
				"url" : window.location.origin+"/wordpress/wp-admin/admin-ajax.php",
				"data": {
					"action":"getallwallet"	
				}						
			},
            "columnDefs": [ 
					{
                    	"targets": -1,
                        "data":'id',
                        "mRender": function(data, type, full) {
                            return '<a class="btn green mt-ladda-btn ladda-button btn-outline btn-circle btncondel" data-toggle="modal"  onclick="#" href="#details"> + </a>';
                          }
                    } ,
                    
                    {
                        "targets": -2,
                        "data": 'currency'
                    },
                    {
                        "targets": -3,
                        "data": 'address'
                    },
                    {
                        "targets": -4,
                        "data": 'date_create'
                    },
                    {
                        "targets": -5,
                        "data": 'wallet_name'
                    }
            ]

        } );
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
	   })
	})
	// when user change note
	$("#user_note").change(function(){    
		var text=$(this).val();
    	
		jQuery.post(
            window.location.origin+"/wordpress/wp-admin/admin-ajax.php", {
                action: 'save_note',               
                user_note: text
            },
            function(data) {                
                var opponent = JSON.parse(data);
				console.log(opponent);
				$("#user_note").val(opponent);
               
            }
        );
    });
</script>	


</body>
</html>



