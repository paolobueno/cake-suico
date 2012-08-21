<?php

/**
* Model para Users
*/
class User extends AppModel
{
  // Array que configura relação entre User e outros modelos
  public $hasMany = array(
    'Posts',
    'ResetTokens' => array(
      // aqui estipulamos a condição de normalmente trazermos
      // somente ResetTokens que não estão gastos
      'conditions' => array('spent' => 0)
    )
  );

  public $validate = array(
    'username' => array(
      'required' => array(
        'rule' => array('notEmpty'),
        'message' => 'O campo não pode estar vazio!'
      )
    ),
    'password' => array(
      'required' => array(
        'rule' => array('notEmpty'),
        'message' => 'O campo não pode estar vazio!'
      )
    ),
    'role' => array(
      'rule' => array('inList', array('admin', 'author')),
      'message' => 'Por favor entre com uma função válida',
      'allowEmpty' => false
    ),
    'email' => array(
      'rule' => 'email'
    )
  );

  /**
   * Função herdada de Model, chamada pela framework
   * antes do modelo ser salvo.
   *
   * Estamos o utilizando para substituir o campo password
   * que inicia como texto plano por sua versão encriptografada
   */
  public function beforeSave($options = array())
  {
    if (isset($this->data[$this->alias]['password'])) {
      $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
    }
  }
}

?>