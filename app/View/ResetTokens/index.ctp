<h1>Recuperação de senha</h1>
<p>Digite seu email para receber um link para o reset de sua senha</p>
<?php
  echo $this->Form->create('ResetTokenDisplay');
  echo $this->Form->input('email');
  echo $this->Form->end('Enviar');
?>