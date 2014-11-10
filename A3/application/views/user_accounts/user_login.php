<?php if (isset($registration_errors)): ?>
	<div class="errors">
		<?= $registration_errors['message'];?>
	</div>
<?php endif; ?>	

<div class="store_form">
	<?php echo form_open('store/login'); ?>
		<input type="text" name="login" placeholder="Username" size="50" required/>

		<input type="password" name="password" placeholder="Password" size="50" required/>

		<div>
			<input class="form_btn" type="submit" value="Login" />
		</div>
	</form>
</div>