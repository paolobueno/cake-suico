<?php
App::uses('CakeEmail', 'Network/Email');

/**
* Classe para Controller de tokens de reset de senha
*/
class ResetTokensController extends AppController
{
  /**
   * Função para permitir acesso ao método reset() por todos
   */
  public function beforeFilter($value='')
  {
    $this->Auth->allow('reset');
    parent::beforeFilter();
  }

  /**
   * Temos que declarar que utilizamos um model além do
   * ResetToken, que é vinculado pelas convenções de
   * nomenclatura.
   *
   * Aqui utilizaremos User para procurar um usuário que
   * possui o email informado no formulário
   */
  public $uses = array('User', 'ResetToken', 'ResetTokenDisplay');

  public function index() {
    $this->ResetTokenDisplay->set($this->request->data);
    if ($this->request->is('post') && $this->ResetTokenDisplay->validates()) {

      // $this->User->email = $this->request->data['ResetToken']['email'];
      // gerar token somente se usuário com aquele email foi
      // encontrado
      $this->User->recursive = 0; // Não trazer outras tabelas na consulta
      $user = $this->User->find('first',
        array('conditions' => array(
          'email' => $this->request->data['ResetTokenDisplay']['email']
          )));
      if ($user) {
        // tendo certeza que há usuário definido,
        // podemos criar o token

        // este comando prepara nosso Model para criar um novo registro
        // com campo id inicialmente nulo
        // deixar de chamar create(), principalmente num loop para criar vários registros,
        // nos faria sobrescrever dados
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

  public function reset($id)
  {
    // Este método deve aceitar somente GET,
    // com o id do token disponibilizado pelo link no email
    if (!$this->request->is('get')) {
      throw new MethodNotAllowedException();
    }

    // A seguir procuramos o token correspondente no banco
    // aplicando regras para filtrarmos somente os ainda válidos

    // Vamos explicitar o nome da tabela pois queremos
    // trazer o registro User correspondente ('recursive' => 1)
    // e portanto pode haver problemas de ambiguidade entre os
    // campos das duas tabelas
    $token = $this->ResetToken->find('first', array(
      'conditions' => array(
        'ResetToken.id' => $id,
        'ResetToken.created >=' => date('Y-m-d', strtotime('-1 day')), // Procurar somente tokens com < 24h de vida (tempo limite)
        'ResetToken.spent' => 0 // E não gastos
      )
    ));

    if ($token) {
      // Token encontrado, devemos resetar senha do usuário
      // por simplicidade vamos estipular uma senha padrão única

      // em outra situação, poderíamos gerar uma string aleatória simples
      // ou até mesmo disponibilizar um formulário para o usuário escolher
      // sua nova senha

      // O método de encriptação ainda chamado por User#beforeSave()
      // portanto devemos armazenar a nova senha como texto puro
      $token['User']['password'] = 'Senai115';

      // Colocamos o campo 'spent' do ResetToken como 1 (verdadeiro)
      // para indicar que o token já foi utilizado
      $token['ResetToken']['spent'] = 1;

      if($this->User->save($token['User']) && $this->ResetToken->save($token['ResetToken'])){
        $this->Session->setFlash('Senha resetada com sucesso para o usuário ' .
          $token['User']['username'] . '! Sua nova senha é Senai115');
        $this->redirect(array('controller' => 'Posts'));
      }

    } else {
      $this->Session->setFlash('Token não encontrado ou já expirado!');
      $this->redirect(array('action' => 'index'));
    }
  }
}
?>