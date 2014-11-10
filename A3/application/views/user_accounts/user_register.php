<?php if (isset($registration_errors)): ?>
	<div class="errors">
		<?= $registration_errors['message'];?>
	</div>
<?php endif; ?>	

<div class="store_form">
	<?php echo form_open('store/register'); ?>

		<input type="text" name="first" placeholder="First Name" size="50" required/>

		<input type="text" name="last" placeholder="Last Name" size="50" required/>

		<input type="text" name="login" placeholder="Username" size="50" required/>

		<input type="password" name="password" placeholder="Password" size="50" required/>

		<input type="text" name="email" placeholder="Email" size="50" required/>

		<div>
			<input class="form_btn" type="submit" value="Register" />
		</div>
	</form>
</div>