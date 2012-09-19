<?php
/**
* Controller para Categorias
*/
class CategoryController extends AppController
{
  public $scaffold;

  public function getAll()
  {
    if ($this->request->is('requested')) {
      return $this->Category->find('all');
    } else {
      throw new MethodNotAllowedException();
    }
  }
}
?>