<?php
  App::uses('CakeEmail', 'Network/Email');

  /**
  * Classe para Controller de tokens de reset de senha
  */
  class ResetTokensController extends AppController
  {

    // Temos que declarar que utilizamos um model além do
    // ResetToken, que é vinculado pelas convenções de
    // nomenclatura.

    // Aqui utilizaremos User para procurar um usuário que
    // possui o email informado no formulário
    public $uses = array('User', 'ResetToken', 'ResetTokenDisplay');

    public function index() {
      $this->ResetTokenDisplay->set($this->request->data);
      if ($this->request->is('post') && $this->ResetTokenDisplay->validates()) {

        // $this->User->email = $this->request->data['ResetToken']['email'];
        // gerar token somente se usuário com aquele email foi
        // encontrado
        $this->User->recursive = 0;
        $user = $this->User->find('first',
            array('conditions' => array(
              'email' => $this->request->data['ResetTokenDisplay']['email']
            )));
        if ($user) {
          // tendo certeza que há usuário definido,
          // podemos criar o token

          // este comando prepara nosso Model para criar um novo registro
          // com campo id inicialmente nulo
          // principalmente num loop para criar vários registros,
          // deixar de chamar create() nos faria sobrescrever dados
          // dos outros registros recém criados
          $this->ResetToken->create();

          // Vamos colocar os dados do novo token numa variável
          // pois é mais fácil de manipulá-la
          //
          // o método save() dos models do CakePHP precisa que
          // criemos uma array contendo outra array com o nome
          // de nosso model devido às associações que podem existir;
          // esse formato é igual aos retornados pelo método find()
          $token = array('ResetToken' => array());

          // gerar string aleatória para token e link
          $token['ResetToken']['id'] = Security::hash(String::uuid(),'sha1',true);
          $token['ResetToken']['user_id'] = $user['User']['id'];

          // Agora passamos nosso token para o método save() do model
          // ele irá realizar as validações e criar o registro no bd
          if ($this->ResetToken->save($token)) {
            // Token criado com sucesso, agora devemos tentar enviar
            // o email para o usuário

            $textoEmail = 'Olá, para resetar sua senha <a href="'
              . Router::url(array('action' => 'reset'), true)
              . '/' . $token['ResetToken']['id']
              . '">siga este link.</a>';

            $mail = new CakeEmail('default');
            $mail->emailFormat('html');
            $mail->to($user['User']['email'])
              ->from('cakeblog-no-reply@gmail.com')
              ->subject('CakePHP blog - recuperação de senha')
              ->send($textoEmail);

            $this->Session->setFlash('Email enviado com sucesso para ' . $user['User']['email']);
          } else {
            $this->Session->setFlash('Erro no envio de email!');
          }
        } else {
          $this->Session->setFlash('Não existe usuário com o e-mail informado.');
        }
      }

      // chegando aqui, a view Views/ResetToken/index.ctp é renderizada.
    }
  }
  ?>