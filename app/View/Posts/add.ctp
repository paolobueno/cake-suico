<?php
echo $this->Form->create('Post');
echo $this->Form->input('title');
echo $this->Form->input('text', array('rows' => 3));
echo $this->Form->end('Enviar post');
?>