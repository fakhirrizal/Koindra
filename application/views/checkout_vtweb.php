<html>
	<head>
		<title>Checkout</title>
	</head>
	<body>

		<h1>Checkout</h1>
		<form action="<?php echo site_url()?>vtweb/vtweb_checkout" method="POST" id="payment-form">
			<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
			<button class="submit-button" type="submit">Submit Payment</button>
		</form>

	</body>
</html>