<? $errors = $this->validationErrors; ?>
<? if (!empty($errors)): ?>
<div class="error-message">
	<h5>Please correct the following errors:</h5>
	<ul>
		<? foreach ($errors as $model): ?>
			<? foreach ($model as $field => $error): ?>
			<li><?= $error; ?></li>
			<? endforeach; ?>
		<? endforeach; ?>
	</ul>
</div>
<? endif; ?>