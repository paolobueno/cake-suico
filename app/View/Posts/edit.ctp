<?php
echo $this->Form->create('Post');
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->input('title');
echo $this->Form->input('category_id');
echo $this->Form->input('body', array('rows' => 3));
echo $this->Form->end('Atualizar post');
?>