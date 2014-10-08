<?php use_stylesheet('jobs.css') ?>
<h1>Jobeet jobs List</h1>
<div id="jobs">
  <?php foreach ($categories as $category): ?>
    <div class="category_<?php echo $category->getName() ?>">
      <div class="category">
        <div class="feed">
          <a href="">Feed</a>
        </div>
        <h1><?php echo $category ?></h1>
      </div>
 
      <?php include_partial('job/list', array('jobs' => $category->getActiveJobs(sfConfig::get('app_max_jobs_on_homepage')))); ?>

      <?php if (($count = $category->countActiveJobs() - sfConfig::get('app_max_jobs_on_homepage')) > 0): ?>
        <div class="more_jobs">
          <?php echo __('and %count% more...', array('%count%' => link_to($count, 'category', $category))) ?>
        </div>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>
</div>