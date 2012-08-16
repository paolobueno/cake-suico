<?php
/**
 * Model para Posts
 */
class Post extends AppModel
{
  public $belongsTo = 'User';
  public $validate = array(
    'title' => array('rule' => 'notEmpty'),
    'body' => array('rule' => 'notEmpty')
  );

  public function isOwnedBy($post, $user)
  {
    return $this->field('id', array('id' => $post, 'user_id' => $user)) === $post;
  }
}
?>