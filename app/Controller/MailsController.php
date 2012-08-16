<?php
/**
* Classe para Fale conosco
*/
class MailsController extends AppController
{
  public $helpers = array('Html', 'Form');

  /**
   * Método em branco, renderiza formulário estático de contato
   */
  public function index()
  {
    if ($this->request->is('post')) {
      $this->Mail->set($this->request->data);

      if ($this->Mail->validates())
        if ($this->Mail->send())
          $this->Session->setFlash('Mensagem enviada com sucesso!');
    }
  }
}
?>