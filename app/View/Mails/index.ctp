<?php
echo $this->Form->create('Mail');
echo $this->Form->input('from', array('label' => 'Email'));
echo $this->Form->input('subject', array('label' => 'Assunto'));
echo $this->Form->input('content', array('label' => 'Mensagem', 'type' => 'textarea', 'rows' => 5));
echo $this->Form->end('Enviar');

echo $this->Html->link('Voltar', array('controller' => 'posts', 'action' => 'index'));
?>