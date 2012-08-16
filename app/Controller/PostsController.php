<?php
/**
 * Controller for Posts
 */
class PostsController extends AppController
{

  public function isAuthorized($user)
  {
    if ($this->action === 'add') {
      return true;
    }

    if (in_array($this->action, array('edit', 'delete'))) {
      $postId = $this->request->params['pass'][0];
      if ($this->Post->isOwnedBy($postId, $user['id'])) {
        return true;
      }
    }

    return parent::isAuthorized($user);
  }

  public function index()
  {
    $this->set('posts', $this->Post->find('all'));
  }

  public function view($id = null)
  {
    $this->Post->id = $id;
    $this->set('post', $this->Post->read());
  }

  public function add($id = null)
  {
    if ($this->request->is('post')) {
      $this->request->data['Post']['user_id'] = $this->Auth->user('id');
      if ($this->Post->save($this->request->data)) {
        $this->Session->setFlash("Post salvo com sucesso!");
        $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash("Erro no salvamento de seu Post");
      }
    }
  }

  public function edit($id = null)
  {
    $this->Post->id = $id;
    if($this->request->is('get')){
      $this->request->data = $this->Post->read();
    } else {
      if ($this->Post->save($this->request->data)) {
        $this->Session->setFlash("Post com id $id editado com sucesso!");
        $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash("Não foi possivel editar o Post");
      }
    }
  }

  public function delete($id)
  {
    if ($this->request->is('get')) {
      throw new MethodNotAllowedException();
    }
    if ($this->Post->delete($id)) {
      $this->Session->setFlash("Post com id $id apagado com sucesso!");
      $this->redirect(array('action' => 'index'));
    }
  }
}