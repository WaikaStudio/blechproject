<?php	
	defined('_JEXEC') or die;

	$user   = JFactory::getUser();
	$uid 	= $user->id;
	$uname 	= $user->name;
	$umail  = $user->email;
	$ugroup = $user->groups;

	echo "<input type='hidden' id='uid'    value='" . $uid . "'>";
	echo "<input type='hidden' id='uname'  value='" . $uname . "'>";
	echo "<input type='hidden' id='umail'  value='" . $umail . "'>";
	
	if(isset($_GET['OEM'])) {

		echo "<input type='hidden' id='oem' value='" . $_GET['OEM'] . "'>";
	
	}

	if (!$user->guest) {
		echo 'Hi, ' . $user->name;
	}
	else{
		echo 'Login first, please';
		echo "
		<div class='row'>
			<div class='col s6 m6 l6'>
				<form action='/index.php/us/component/users/?task=user.login' method='post' class='form-validate form-horizontal well '>
				  <fieldset>
				    <div class='control-group'>
				      <div class='control-label'>
				        <label id='username-lbl' for='username' class='required invalid'>
				          Username<span class='star'>&nbsp;*</span></label>
				        </div>
				        <div class='controls col s4 m4 l4'>
				        <input type='text' name='username' id='username' value='' class='validate-username required invalid' size='25' required='required' aria-required='true' autofocus='' aria-invalid='true'>
				        </div>
				      </div>
				      <div class='control-group'>
				        <div class='control-label'>
				          <label id='password-lbl' for='password' class='required'>
				            Password<span class='star'>&nbsp;*</span>
				          </label>
				        </div>
				        <div class='controls col s4 m4 l4'>
				          <input type='password' name='password' id='password' value='' class='validate-password required' size='25' maxlength='99' required='required' aria-required='true'>
				        </div>
				        </div>
				        <div class='control-group'>
				          <div class='control-label'><label>Remember me</label></div>
				          <div class='controls'><input id='remember' type='checkbox' name='remember' class='inputbox' value='yes'></div>
				        </div>
				        <div class='control-group'>
				          <div class='controls'>
										<button type='submit' class='btn btn-primary'>
										Log in
										</button>
				          </div>
				        </div>
				        <input type='hidden' name='return' value='aHR0cDovL2xvY2FsaG9zdC91ZW1hcGEvaW5kZXgucGhwL2VuL3N0b3JlL215LWFjY291bnQ='>
				        " . JHtml::_('form.token') . "
				      </div>
				    </div>
				  </fieldset>
				</form>
			</div> 
		</div>

		";

		return true;

	}


$document = JFactory::getDocument();
$document->addScript('components/com_quote/views/quotes/tmpl/js/jquery.js');
$document->addScript('components/com_quote/views/quotes/tmpl/js/materialize/js/materialize.js');

$document->addScript('components/com_quote/views/quotes/tmpl/js/quoteOrder.js');
$document->addScript('components/com_quote/views/quotes/tmpl/js/quoteStatus.js');
$document->addScript('components/com_quote/views/quotes/tmpl/js/registerQuotes.js');

$document->addScript('components/com_quote/views/quotes/tmpl/js/app.js');

?>

<jdoc:include type="head"/>
<html>
	<body>
		<div class="row">
			<div class="col s12 m12 l12">
				<ul class="tabs tabs-fixed-width">
					<li class="tab col s2" id="quote1">
						<a class="active" href="#test1">Quote Order</a>
					</li>
					<li class="tab col s2" id="quote2">
						<a href="#test2">My Quotes</a>
					</li>
					<li class="tab col s2" id="quote3">
						<a href="#test3">Quote Request</a>
					</li>
				</ul>
			</div>
		</div>
		<!-- ______________________________First  tab___________________________ -->
		<div class="container1">
			<div class="container">
				
				<!-- The Modal -->
				<div id="myModal" class="modal">
					<span class="close">×</span>
					<img class="modal-content" id="img01">
					<div id="caption"></div>
				</div>
				
				<form class="col s12 m12 l12 form_quote">
					<div class="row">
						<div class="col s6 m6 l3">
							<label for="selectManufacturer">Manufacturer:
								<select class="icons" id="selectManufacturer" style="width: 100%">
									<?php if(isset($_GET['OEM'])) {

										echo "<option data-brandid='67' data-brandname='Caterpillar'>Carterpillar OEM parts</option>";

									}?>
									
									
									<!-- Validate Brand by queryString! W:50 C:67 J:68 -->
									<?php if(isset($_GET['b'])) {
										$b = $_GET['b'];
										switch ($b) {
											case 50: echo "<option data-brandid='{$b}' data-brandname='Wacker Neuson'>Wacker Neuson</option>";
											break;
											case 67: echo "<option data-brandid='{$b}' data-brandname='Caterpillar'>Caterpillar</option>";
											break;
											case 68: echo "<option data-brandid='{$b}' data-brandname='John Deere'>John Deere</option>";
											break;
										}
									} ?>

									<option value="no"> -- Select Brand -- </option>

								</select>
							</label>
						</div>
					</div>
					<div class="row">
						<div class="col s4 m4 l3">
							
							<label for="part"># Part:
								<input id="part" name="part_number" required>
							</label>
						</div>
						<div class="col s2 m2 l1">
							
							<label for="qnty">Quantity:
								<input id="qnty" min="1" name="part_quantity" required>
							</label>
						</div>
						<div class="col s3 m3 l2">
							
							<label for="button">&nbsp;</label>
							<button id="button" class="btnAddRow button-secondary">Add Part</button>
						</div>
					</div>
				</form>
				
				<div id="mSb" style="display:none;">Please select a brand</div>
				<div id="mSp" style="display:none;">Please fill a part number and part quantity</div>
				
				<div class="row">
					<div class="table-responsive col s12 m12 l6 sendTableMail">
						<table class="table table-condensed table-bordered PTable" id="PTable" style="display:none;">
							<thead>
								<tr>
									<th class="center-align">#</th>
									<th class="center-align">Brand</th>
									<th class="center-align">Part</th>
									<th class="center-align">Qnty</th>
									<th class="center-align">Price</th>
									<th class="center-align x">Img</th>
									<th class="center-align x">Doc</th>
									<th class="center-align x">Buy</th>
									<th class="center-align x">x</th>
								</tr>
							</thead>
						<tbody id="TBody"></tbody>
					</table>
				</div>
				<div style="display:none;" class="copyTable"></div>
			</div>
			<button class="btnSend button-secondary" style="display:none;">Send</button>
			<button class="btnToBuy button-secondary" style="display:none;">Add To Cart</button>
			<div id="loading" style="display:none;">Saving...</div>
			<div id="successMessage"></div>
			<div id="successMessageMail"></div>
		</div>
	</div>
	<!-- ______________________________Second tab___________________________ -->
	<div class="container2" style="display:none;">
		<div class="container">
			<div class="row">
				<div class="col s12 m12 l12">
					<div class="flashMssg"></div>
				</div>
			</div>
			<div class="row">
				<div class="table-responsive col s12 m12 l6">
					<table class="table table-condensed table-bordered QTable" id="QTable">
						<thead>
							<tr>
								<th class="center-align">#</th>
								<th class="center-align">Brand</th>
								<th class="center-align">Part</th>
								<th class="center-align">Qnty</th>
								<th class="center-align">Price</th>
								<th class="center-align">Buy</th>
							</tr>
						</thead>
					<tbody id="itemsTabla"></tbody>
				</table>
			</div>
		</div>
	</div>
	<button class="btnAddCart button-secondary">Add To Cart</button>
</div>

<!-- ______________________________Thrid tab___________________________ -->

<div   style="display:none;" class="container3">
	<table class="tabla3">
		<tr>
			<td><label for="name">Full Name:</label></td>
			<td>
				<input type="text" name="name" maxlength="30" id="name_RegOrder">
			</td>
		</tr>
		<tr>
			<td><label for="email">Email:</label></td>
			<td>
				<input type="email" name="email"  id="email_RegOrder">
			</td>
		</tr>
		<tr>
			<td><label for="phone">Phone:</label></td>
			<td>
				<input type="tel" name="phone"  maxlength="11" id="phone_RegOrder">
			</td>
		</tr>
		<tr>
			<td><label for="brand">Brand:</label></td>
			<td>
				<select name="brand" id="brand_RegOrder">
													<!-- Validate Brand by queryString! W:50 C:67 J:68 -->
									<?php if(isset($_GET['b'])) {
										$b = $_GET['b'];
										switch ($b) {
											case 50: echo "<option data-brandid='{$b}' data-brandname='Wacker Neuson'>Wacker Neuson</option>";
											break;
											case 67: echo "<option data-brandid='{$b}' data-brandname='Caterpillar'>Caterpillar</option>";
											break;
											case 68: echo "<option data-brandid='{$b}' data-brandname='John Deere'>John Deere</option>";
											break;
										}
									} ?>

									<option value="no"> -- Select Brand -- </option>
				</select>
			</td>
		</tr>
		<tr>
			<td><label for="model">Model:</label></td>
			<td>
				<input type="text" name="model" id="model_RegOrder">
	    </td>
		</tr>
		<tr>
			<td><label for="serial">Serial:</label></td>
			<td>
				<input type="text" name="serial" id="serial_RegOrder">
	    </td>
		</tr>
		<tr>
			<td><label for="description">Description:</label></td>
			<td>
				<textarea name="description" maxlength="50" placeholder="-------AMPLIAR EL ANCHO------" id="description_RegOrder"></textarea>
	    </td>
		</tr>
		<tr>
			<td><input type="text" name="txtcopia" id="txtcopia" size="10"></td>
			<td id="captcha">
				<canvas id="myCanvas" width="150" height="80" style="border:1px solid #d3d3d3;">
				Your browser does not support the HTML5 canvas tag.
				</canvas>
		  </td>
		</tr>
		<tr>
			<td>
				<input type="submit" class="button-secondary" name="enviar" value="Send" id="btn-RegOrder">
				<input type="reset" class="button-secondary" name="borrar" value="Reset" id="btn-reset">
			</td>
		</tr>
</table>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.16.0/moment.min.js"></script>

</body>
</html>