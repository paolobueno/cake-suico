<?php
/**
* Model utilizado somente para a validação do formulário
* de criação de ResetTokens
*/
class ResetTokenDisplay extends AppModel
{
  public $useTable = false;
  public $validate = array(
      'email' => array(
        'rule' => 'email',
        'required' => true,
        'message' => 'E-mail Inválido'
      )
  );
}