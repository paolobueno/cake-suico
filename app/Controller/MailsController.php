<?php
/**
* Classe para Fale conosco
*/
class MailsController extends AppController
{
  public $helpers = array('Html', 'Form');

  /**
   * Quando get, renderiza formulário estático de contato,
   * em post, envia mensagem do fale conosco
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