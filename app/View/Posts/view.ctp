<div class="hero-unit">
  <h1><?php echo h($post['Post']['title']); ?></h1>

  <p><?php echo h($post['Post']['body']); ?></p>
  <p><small>criado em: <?php echo $post['Post']['created']; ?></small></p>
</div>