<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  
	<title>
		SPG Documentation
	</title>

<body>

	<?php
		if (isset($_GET['transactionid'])) {
			echo '<script src="https://spg.qly.site1.sibs.pt/assets/js/widget.js?id=' . $_GET['transactionid'] . '"></script>' . "\n";
		} 
		else 
		{
			echo 'Falta parametro transactionid';
			exit;
		}
	?>

	<?php
		/* <script src="https://spg.qly.site1.sibs.pt/assets/js/widget.js?id=BK7gYRj4JArWK4iK0T8s"></script> */
	?>

	<div class="d-flex flex-column mt-1 w-100" id="form-container">
		<form class="paymentSPG"
			<?php
				if (isset($_GET['spgcontext'])) 
				{
					echo 'spg-context="' . $_GET['spgcontext'] . '"' . "\n";
				} 
				else 
				{
					echo 'Falta parametro spgcontext';
					exit;
				}
			?>

			<?php
				echo 'spg-config="{&quot;paymentMethodList&quot;:[],&quot;amount&quot;:{&quot;value&quot;:2,&quot;currency&quot;:&quot;EUR&quot;},&quot;language&quot;:&quot;pt&quot;,&quot;redirectUrl&quot;:&quot;https://spg.ndavid.cloudns.ph/spggettrxstatus.php?transactionid=' . $_GET['transactionid'] . '&quot;,&quot;customerData&quot;:null}"' . "\n";
			?>

			spg-style="{&quot;layout&quot;:&quot;accordion&quot;,&quot;theme&quot;:&quot;default&quot;,&quot;color&quot;:{&quot;primary&quot;:&quot;&quot;,&quot;secondary&quot;:&quot;&quot;,&quot;border&quot;:&quot;&quot;,&quot;surface&quot;:&quot;#ffffff&quot;,&quot;header&quot;:{&quot;text&quot;:&quot;&quot;,&quot;background&quot;:&quot;&quot;},&quot;body&quot;:{&quot;text&quot;:&quot;&quot;,&quot;background&quot;:&quot;&quot;}},&quot;font&quot;:&quot;Monospace&quot;}">


		</form>
	</div>

</body>
</html>

