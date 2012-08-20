<?php
/**
* Model utilizado somente para a validação do formulário
* de criação de ResetTokens
*/
class ResetTokenDisplay extends AppModel
{
  // expomos a variável a seguir para indicar que nosso
  // Model não utiliza uma tabela no banco de dados
  public $useTable = false;

  // este modelo tem somente uma simples validação do e-mail
  // para o formulário em app/View/ResetToken/index.ctp
  public $validate = array(
      'email' => array(
        'rule' => 'email',
        'required' => true,
        'message' => 'E-mail Inválido'
      )
  );
}