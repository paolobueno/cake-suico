<ul class="nav">
  <?php foreach ($categories as $category) { ?>
  <li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" role="button" id="category-<?php echo $category['Category']['id'] ?>" href="#">
      <?php echo $category['Category']['name']; ?>
    </a>
    <ul class="dropdown-menu" role="menu" aria-labelledby="category-<?php echo $category['Category']['id'] ?>">
      <?php foreach ($category['Posts'] as $post) { ?>
      <li><?php echo $this->Html->link($post['title'],array('controller' => 'posts', 'action' => 'view', $post['id'])); ?></li>
      <?php } ?>
    </ul>
  </li>
  <?php } ?>
</ul>
