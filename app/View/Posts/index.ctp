<h1>Todos os Posts</h1>

<table class="table table-striped table-bordered">
  <thead>
    <td>Id</td>
    <td>Titulo</td>
    <td>Ações</td>
    <td>Criado em</td>
  </thead>
  <?php foreach ($posts as $post):?>
  <?php $postid = $post['Post']['id']; ?>
  <tr>
    <td><?php echo $post['Post']['id']; ?></td>
    <td><?php echo $this->Html->link($post['Post']['title'],
      array('controller' => 'posts', 'action' => 'view', $postid)); ?></td>
    <td class="acoes">
      <?php echo $this->Form->postLink(
          'Apagar',
          array('action' => 'delete', $post['Post']['id']),
          array(
            'confirm' => "Tem certeza que deseja apagar o post #$postid?",
            'class' => 'btn btn-danger'
          )
        ); ?>
      <?php echo $this->Html->link('Editar', array('controller' => 'Posts', 'action' => 'edit', $postid),
        array('class' => 'btn')); ?>
    </td>
    <td><?php echo $post['Post']['created']; ?></td>
  </tr>
  <?php endforeach; ?>
</table>