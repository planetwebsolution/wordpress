

<div class="wrap">
<h2> All Transactions</h2>

<?php
include_once 'wepay_api.php';


$account_id = 471568071;
$client_id = 167371;
$client_secret = "798f5f4b8a";
$access_token = "STAGE_5dcc267978e11dfb927d91a5dd5f7ed1972484f30f59a64b3f30760ee7faf897";


Wepay::useStaging($client_id, $client_secret);
$wepay = new WePay($access_token);



/**************************************************/
if(isset($_REQUEST['refund_btn'])){
	
	 $chechout_id = $_REQUEST['refund_btn'];
	
	 $refundtype = $_REQUEST['refundtype_'.$chechout_id];
	
	 $refund_amount = $_REQUEST['refund_amount_'.$chechout_id];
	
	 $refund_description = $_REQUEST['refund_description_'.$chechout_id];
	
	
	
	
	
	$refund_arg = array(
			'checkout_id' => $chechout_id,
			'refund_reason' =>$refund_description,
			
	);
		
	if($refundtype=='partial'){
		$refund_arg['amount']=$refund_amount;
	}
	
	//print_r($refund_arg);
	
	
	try {
		$refund_trs = $wepay->request('/checkout/refund', $refund_arg	);
		//echo "<pre>";
	//	print_r($refund_trs);
		
		if($refund_trs->state=="refunded" || $refund_trs->state=="captured")
		{
			
			?>
			<div class="updated"><p><strong>Transaction Refunded Successfully</p></strong></div>
			<?php
			
		}
	} catch (WePayException $em) {
		// Something went wrong - normally you would log
		// this and give your user a more informative message
		// $em->getMessage();
		
			?>
			<div class="error"><p><strong><?php echo $em->getMessage();?></p></strong></div>
			<?php
	}
}


/*************************************************/


?>


<div class="srchfroms">
<form name="serchtrans" id="serchtrans" method="get">
<input type="hidden" name="page" value="wepay_refund/wepay.php">
<input type="hidden" name="serchdtr" value="1">
		<table class="widefat page" cellspacing="0">
			
			
			<tbody>
			<tr>
				
			</tr>
				<tr>
				   <td><strong>From:</strong> <input type="text" id="start_from" name="start_from" value="<?php echo $_GET['start_from']; ?>" autocomplete="off"></td>
				    <td><strong>To:</strong> <input type="text" id="start_to" name="start_to" value="<?php echo $_GET['start_to']; ?>" autocomplete="off"></td>
				    <td><strong>Reference Id:</strong> <input type="text" id="reference_id" name="reference_id" value="<?php echo $_GET['reference_id']; ?>"></td>
				
				
					<td style="width:20%;"><input type="submit" name="start_serch" id="start_serch" value="Search" class="button button-primary" ></td>
				</tr>
			</tbody>
		</table>
</form>

</div>

<?php


try {
	
	
	
	
	
	

			if($_GET['serchdtr'])
			{
				
				//$arg['start_time']='1431216000'; // May,10 2015
				//$arg['end_time']='1432598400'; // May,26 2015
				
				
				$start_date = strtotime($_GET['start_from']);
				
				
				$end_date = strtotime(date('Y/m/d', strtotime($_GET['start_to'] .' +1 day')));
			}else{
				
					$start_date = strtotime(date('Y/m/d', strtotime("-30 days")));
					$end_date = strtotime(date("Y/m/d"));
				
				
			}
			
			
			$arg = array(
					'account_id' => $account_id,
					'state' =>'captured',
					'start_time'=>$start_date,
					'end_time'=>$end_date,
			);
			
			
			if(!empty($_GET['reference_id'])){
				
				$arg['reference_id']=$_GET['reference_id'];
			}
		
	$checkouts = $wepay->request('/checkout/find', $arg	);
	
	
	/* $checkouts = $wepay->request('/checkout/find', array(
			'account_id' => $account_id,
			'state' =>'captured',
			'start_time'=>'1431216000', // May,10 2015
			'end_time'=>'1432598400', // May,26 2015
				
	)
	); */
	

/*	Smaple result Array 
 * 
[checkout_id] => 1250785754
[account_id] => 471568071
[type] => GOODS
[checkout_uri] => https://stage.wepay.com/api/iframe/1250785754/0f4df9b4/api_checkout?iframe=1
[short_description] => Metabolic Nutrition - Order - 4004
[currency] => USD
[amount] => 49.45
[fee_payer] => payee
[state] => captured
[soft_descriptor] => WPY*Metabolic Nutrition
[redirect_uri] => http://6f8.f9c.myftpupload.com/checkout/order-received/4004?key=wc_order_55638b9cd354a&utm_nooverride=1
[payment_method_type] =>
[payment_method_id] =>
[auto_capture] => 1
[app_fee] => 0
[create_time] => 1432587165
[mode] => iframe
[amount_refunded] => 0
[amount_charged_back] => 0
[gross] => 49.45
[fee] => 1.73
[reference_id] => 4004
[callback_uri] => http://6f8.f9c.myftpupload.com/?wc-api=WC_Gateway_WePay&order_id=4004
[shipping_fee] => 0
[tax] => 0
[payer_email] => nick.saroki@gmail.com
[payer_name] => nick saroki
[dispute_uri] => https://stage.wepay.com/dispute/payer_create/7365279/6902825ce24669a01fa3
	*/
	
	
	
	//echo count($checkouts);
	//echo "<pre>";
	//print_r($checkouts);
	?>
	

  





	
<div class="listtrs">	
	<table class="widefat">
		<thead>
			<tr>
			<th>Payer</th>
			<th>Checkout Id</th>
			<th>Refrence Id</th>
			<th>Date</th>
			<th>Amount</th>
			<th>Balance</th>
			<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
		
	<?php 
	$count=1;
	foreach ($checkouts as $checkout) {
		// Please never blend your views with your business logic like this!
		
				
				
				$checkout_id = $checkout->checkout_id;
				$short_description = $checkout->short_description;
				$amount= $checkout->amount;
				$create_time=$checkout->create_time;
				$amount = $checkout->amount;
				$payer_email= $checkout->payer_email;
				$payer_name= $checkout->payer_name;
				
				$balance=$checkout->amount-$checkout->amount_refunded;
				
				$createdate=date("d/m/Y",$create_time);
			
				
				$reference_id=$checkout->reference_id;
				
				
				?>
				
				<tr>
					<td><?php echo $payer_name;?><br><?php echo $payer_email;?></td>
					<td><?php echo $checkout_id;?></td>
					<td><?php echo $reference_id;?></td>
					<td><?php echo $createdate;?></td>
					<td><?php echo $amount;?></td>
					<td><?php echo $balance;?></td>
					<td>
						<div class="refundsction">		
						<form name="refundform" id="refundform" method="post" action="">
							<div class="sec1">
							<input name="refundtype_<?php echo $checkout_id;?>" type="radio" value="partial" class="refundtype">Partial
							<input name="refundtype_<?php echo $checkout_id;?>" type="radio" value="full" class="refundtype"  checked="checked"'>Full
							</div>
							
							<div class="sec2 showdiv_data" style="display:none;">
							<label>Refund Amount:</label><input type="text" class="refund_amt" name="refund_amount_<?php echo $checkout_id;?>">
								
							</div>
							<div class="sec3">
							<label>Refund Reason:</label><input type="text" class="refund_desc" name="refund_description_<?php echo $checkout_id;?>">
							</div>
							<div class="sec4">
							
							<input type="hidden" class="ref_amt"  name="ref_amt_<?php echo $checkout_id;?>" value="<?php echo $balance;?>">
							
							
							<button type="submit" class="refund_btn button button-primary" name="refund_btn" value="<?php echo $checkout_id;?>">Refund</button>
							</div>
							
							</form>
						</div>			
					</td>
					
					
				
				</tr>
				
				<?php
				$count++;
		
		}
	} catch (WePayException $e) {
	// Something went wrong - normally you would log
		// this and give your user a more informative message
		echo $e->getMessage();
	}
	
?> 
	</tbody>
</table>

</div>

</div>