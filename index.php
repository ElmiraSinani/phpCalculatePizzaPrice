<?php 
	require_once("PizzaClass.php");
	
	$message = "";
	if(isset($_POST['calculate'])){	
		extract($_POST);		
		$pizza = new Pizza($crust, $sauceArr, $toppingArr, $cheeseArr);
		$price = $pizza->getPrice();	
		$message = $pizza->getMessage();
	} 
	
	/** Check Validation Messages **/
	//$pizza = new Pizza("thin"); //A crust and at least one additional component is required for each pizza.
	//$pizza = new Pizza("", ['type'=>['tomato']]); //Crust is required for pizza
	//$pizza = new Pizza("thin", ['type'=>['tomato-garlic']], [], ['type'=>['mozzarella']]); //Mozzarella cannot be used with tomato-garlic sauce.
	
	/*** OUTCOME ***/
	/* 1. Tomato, meatball with american */
	$pizza1 = new Pizza("thin", ['type'=>['tomato']], ['type'=>['meatball']], ['type'=>['american']]);
	$price1 = $pizza1->getPrice();	
	$message1 = $pizza1->getMessage();
	
	/* 2. Thin crust, double tomato, mushroom and pepper with triple mozzarella */
	$pizza2 = new Pizza("thin", ['type'=>['tomato'], 'size'=>'double'], ['type'=>['pepper','mushroom']], ['type'=>['mozzarella'], 'size'=>'triple']);
	$price2 = $pizza2->getPrice();	
	$message2 = $pizza2->getMessage();
	
	/* 3. Thick crust, tomato-basil, double pepper with swiss */
	$pizza3 = new Pizza("thick", ['type'=>['tomato-basil']], ['type'=>['pepper'], 'size'=>'double'], ['type'=>['swiss']]);
	$price3 = $pizza3->getPrice();	
	$message3 = $pizza3->getMessage();
	
	/* 4. Thin crust, tomato, half pepper, half olive, with american */
	$pizza4 = new Pizza("thin", ['type'=>['tomato']], ['type'=>['pepper', 'olive'], 'size'=>'half'], ['type'=>['american']]);
	$price4 = $pizza4->getPrice();	
	$message4 = $pizza4->getMessage();
	
	/* 5. Thick crust, tomato-garlic, double olive with mozzarella */
	$pizza5 = new Pizza("thick", ['type'=>['tomato-garlic']], ['type'=>['olive'], 'size'=>'double'], ['type'=>['mozzarella']]);	
	$price5 = $pizza5->getPrice();	
	$message5 = $pizza5->getMessage();
?>

<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

		<title>Calculate Pizza Price</title>
	</head>
	<body>
		<div class="container">
			
			<div class="row">
				
				<div class="col-md-12 py-5">
					<h3>Calculate Pizza Price.</h3>
				</div>
			
				<div class="col-md-6">
					<h4>Custom Calculation</h4>
					<div class="row">
						<div class="col-md-12">
						<?php if($message!="") { ?>
							<div class="alert alert-secondary" role="alert">
								<?php if($price!=""){ ?>
								  <div class="font-weight-bold">Price: $<?php echo $price; ?></div>
								<?php } ?>
								<?php echo $message; ?>
							</div>
						<?php } ?>
						</div>
					</div>
					<form method="POST" action="">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="Crust">Crust</label>
									<select name="crust" class="form-control" id="Crust">
									  <option selected value="thin">Thin</option>
									  <option value="thick">Thick</option>
									</select>
								</div>
							</div>							
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="Sauce">Sauce</label>
									<select name="sauceArr[type][]" multiple class="form-control" id="Sauce">
									  <option selected value="tomato">Tomato</option>
									  <option value="tomato-basil">Tomato Basil</option>
									  <option value="tomato-garlic">Tomato Garlic</option>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="Size">Size</label>
									<select name="sauceArr[size]" class="form-control" id="Size">
									  <option value="half">Half</option>
									  <option selected value="single">Single</option>
									  <option value="double">Double</option>
									  <option value="triple">Triple</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="Sauce">Topping</label>
									<select name="toppingArr[type][]" multiple class="form-control" id="Sauce">
									  <option value="pepper">Pepper</option>
									  <option value="olive">Olive</option>
									  <option value="mushroom">Mushroom</option>
									  <option value="meatball">Meatball</option>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="Size">Size</label>
									<select name="toppingArr[size]" class="form-control" id="Size">
									  <option value="half">Half</option>
									  <option selected value="single">Single</option>
									  <option value="double">Double</option>
									  <option value="triple">Triple</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="Cheese">Cheese</label>
									<select name="cheeseArr[type][]" multiple class="form-control" id="Cheese">
									  <option value="mozzarella">Mozzarella</option>
									  <option value="american">American</option>
									  <option value="swiss">Swiss </option>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="Size">Size</label>
									<select name="cheeseArr[size]" class="form-control" id="Size">
									  <option value="half">Half</option>
									  <option selected value="single">Single</option>
									  <option value="double">Double</option>
									  <option value="triple">Triple</option>
									</select>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-6 py-2 pb-5">
								<input type="submit" name="calculate" value="Submit" class="btn btn-primary" />
							</div>
						</div>
						
					</form>
				</div>
				
				<div class="col-md-6">
					<h4>Outcome</h4>
					<?php if($message1!="") { ?>
					<div class="alert alert-secondary" role="alert">
						<h6>Pizza 1 </h6>
						<?php echo $message1; ?>
						<?php if($price1!=""){ ?>
						  <div class="font-weight-bold text-right">Price: $<?php echo $price1; ?></div>
						<?php } ?>						
					</div>
					<?php } ?>
					
					<?php if($message1!="") { ?>
					<div class="alert alert-secondary" role="alert">
						<h6>Pizza 2 </h6>
						<?php echo $message2; ?>
						<?php if($price2!=""){ ?>
						  <div class="font-weight-bold text-right">Price: $<?php echo $price2; ?></div>
						<?php } ?>						
					</div>
					<?php } ?>
					
					<?php if($message3!="") { ?>
					<div class="alert alert-secondary" role="alert">
						<h6>Pizza 3 </h6>
						<?php echo $message3; ?>
						<?php if($price3!=""){ ?>
						  <div class="font-weight-bold text-right">Price: $<?php echo $price3; ?></div>
						<?php } ?>						
					</div>
					<?php } ?>
					
					<?php if($message4!="") { ?>
					<div class="alert alert-secondary" role="alert">
						<h6>Pizza 4 </h6>
						<?php echo $message4; ?>
						<?php if($price4!=""){ ?>
						  <div class="font-weight-bold text-right">Price: $<?php echo $price4; ?></div>
						<?php } ?>						
					</div>
					<?php } ?>
					
					<?php if($message5!="") { ?>
					<div class="alert alert-secondary" role="alert">
						<h6>Pizza 5 </h6>
						<?php echo $message5; ?>
						<?php if($price5!=""){ ?>
						  <div class="font-weight-bold text-right">Price: $<?php echo $price5; ?></div>
						<?php } ?>						
					</div>
					<?php } ?>
					
				</div>
				
			</div>
		</div>
	  
	

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>