<ul class="menu">
  <li><?php echo $this->Html->link('Fale conosco', array('controller' => 'mails', 'action' => 'index')); ?></li>
  <li><?php echo $this->Html->link('Esqueceu sua senha?', array('controller' => 'reset_tokens', 'action' => 'index')); ?></li>
</ul>


<h1>Todos os Posts</h1>

<table>
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
          array('confirm' => "Tem certeza que deseja apagar o post #$postid?")
        ); ?>
      <?php echo $this->Html->link('Editar', array('controller' => 'Posts', 'action' => 'edit', $postid)); ?>
    </td>
    <td><?php echo $post['Post']['created']; ?></td>
  </tr>
  <?php endforeach; ?>
</table>