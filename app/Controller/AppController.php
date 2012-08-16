<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
  public $helpers = array('Html', 'Form', 'Session');
  public $components = array(

    // Declara e configura a utilização do componente de autenticação
    // AuthComponent no nível do nosso AppController, que por sua vez
    // fará com que essa configuração seja herdada por todos os outros
    // controllers
    'Auth' => array(
      'loginRedirect' => array('controller' => 'posts', 'action' => 'index'),
      'logoutRedirect' => array('controller' => 'posts', 'action' => 'index'),
      'authorize' => array('Controller')
    ),

    // Declarando o SessionComponent aqui, tiramos a necessidade de
    // repetir isso nos Controllers
    'Session'
  );

  /**
   * Método pai para checagem de permissão dos usuários
   * Implementações específicas devem ser escritas para os
   * controles filhos, caso requeiram regras adicionais de
   * permissionamento
   *
   * @return true se o usuário estiver autorizado a realizar
   * determinada ação
   */
  public function isAuthorized($user)
  {
    if (isset($user['role']) && $user['role'] === 'admin') {
      return true;
    }

    return false;
  }

  /**
   * Método herdado da classe Controller que é chamado
   * antes do método de ação do Controller (index(), view(),
   * add(), etc.)
   *
   * Neste caso estamos informando que as ações de nome 'index'
   * e 'view' de todos os nossos controles devem estar disponíveis
   * para todos os usuários
   *
   * allow = permitir
   */
  public function beforeFilter()
  {
    $this->Auth->allow('index', 'view');
  }
}
