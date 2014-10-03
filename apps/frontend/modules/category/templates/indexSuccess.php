<?php use_stylesheet('jobs.css') ?>
<h1>Jobeet categories List</h1>
<div id="jobs">
  <?php foreach ($categories as $category): ?>
    <div class="category_<?php echo $category->getName() ?>">
      <div class="category">
        <div class="feed">
          <a href="">Feed</a>
        </div>
        <h1><?php echo $category ?></h1>
      </div>
    </div>
  <?php endforeach; ?>
</div>