<?php
  /**
  * Modelo para tokens de reset de senha
  */
  class ResetToken extends AppModel
  {
    public $belongsTo = array('User');
    public $validate = array(
      'id' => 'notEmpty',
      'user_id' => 'notEmpty'
    );
  }
?>