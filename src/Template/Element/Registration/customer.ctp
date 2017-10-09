<div class="form-group">
    <?= $this->Form->input('first_name', ['class' => 'form-transparent', 'label' => false, 'placeholder' => 'First Name']) ?>
</div>
<div class="form-group">
    <?= $this->Form->input('email', ['class' => 'form-transparent', 'label' => false, 'placeholder' => 'Email']) ?>
</div>
<div class="form-group">
    <?= $this->Form->input('phone', ['class' => 'form-transparent', 'label' => false, 'placeholder' => 'Mobile Number']) ?>
</div>
<div class="form-group">
    <?= $this->Form->input('password', ['class' => 'form-transparent', 'label' => false, 'placeholder' => 'Password']) ?>
</div>
<div class="form-group">
    <?= $this->Form->input('password_confirm', ['class' => 'form-transparent', 'label' => false, 'placeholder' => 'Confirm Password', 'type' => 'password']) ?>
</div>



<div class="form-group">
	<div class="input text">
		<?= $this->Form->select('gender', $options_gender, ['class' => 'custom-dropdown', 'label' => false]); ?>
	</div>
</div>
<div class="form-group">
    <?= $this->Form->input('date_of_birth', ['id'=>'datetimepicker8','class' => 'form-transparent', 'label' => false, 'placeholder' => 'Date of Birth']) ?>
</div>
<div class="form-group">
    <?= $this->Form->input('post_code', ['class' => 'form-transparent', 'label' => false, 'placeholder' => 'Post Code']) ?>
</div>