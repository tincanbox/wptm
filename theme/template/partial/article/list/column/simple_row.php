<a
  class="article link list-group-item list-type-simple_row <?php echo implode(' ', get_post_class()); ?>"
  href="<?php the_permalink(); ?>">
  <?php if($opt_post_show_time){ ?>
    <?php the_date(); ?> <?php the_time(); ?>&nbsp;&raquo;&nbsp;<?php the_title(); ?>
  <?php } ?>
</a>
