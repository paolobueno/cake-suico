<div class="users form">
  <?php echo $this->Session->flash('auth'); ?>
  <?php echo $this->Form->create('User'); ?>
    <fieldset>
      <legend><?php echo 'Por favor entre com seu usuário e senha'; ?></legend>

      <?php
        echo $this->Form->input('username');
        echo $this->Form->input('password');
      ?>
    </fieldset>
    <?php echo $this->Form->end('Login') ?>
</div>