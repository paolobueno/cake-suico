<?php
/**
* Model para categorias
*/
class Category extends AppModel
{
  public $hasMany = array('Posts');
}
?>