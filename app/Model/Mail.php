<?php
// Utilizamos essa linha para informar ao Cake que iremos utilizar
// a classe definida em /lib/Cake/Network/Email/CakeEmail.php
App::uses('CakeEmail', 'Network/Email');


/**
* Model para envio de e-mail, não utiliza tabela
*/
class Mail extends AppModel
{
  // Essa variável é utilizada pelo Cake para determinar
  // que nosso modelo não utiliza uma tabela do banco
  public $useTable = false;

  /**
   * Função de envio de email,
   * ela deve estar presente
   */
  public function send(){
    $mail = new CakeEmail();

    $mail->to('paolohaji@gmail.com')
      ->from($this->data['Mail']['from'])
      ->subject($this->data['Mail']['subject'])
      ->send($this->data['Mail']['content']);

    return true;
  }

  public $validate = array(
    'subject' => array(
      'required' => array(
        'rule' => array('notEmpty'),
        'message' => 'O campo assunto não pode estar vazio!'
      )
    ),
    'content' => array(
      'required' => array(
        'rule' => array('notEmpty'),
        'message' => 'O campo mensagem não pode estar vazio!'
      )
    ),
    'from' => array(
      'required' => array(
        'rule' => array('notEmpty'),
        'message' => 'O campo from não pode estar vazio!'
      ),
      'email' => array(
        'rule' => 'email',
        'message' => 'Formato de email incorreto!'
      )
    )
  );
}
?>