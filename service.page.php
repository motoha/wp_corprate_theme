<?php
/*
Template Name: Page Service
*/

get_header('custom'); ?>


<main class="container mx-auto py-5 flex">
    <aside class="w-1/4 ">
        <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-6">Services</h2>
       
        <?php get_sidebar('custom'); ?>
        </div>
    </aside>
    <section class="w-3/4 bg-white p-8 rounded-lg shadow-lg ml-8">
   
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
         
            <h2 class="text-4xl font-bold mb-6"><?php the_title(); ?></h2>
            
            <?php if (has_post_thumbnail()) : ?>
                <img src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title(); ?>" class="w-full h-64 object-cover rounded-lg mb-6">
            <?php endif; ?>
            
            <p class="mb-6 text-lg leading-relaxed"><?php the_content(); ?></p>
      
    <?php endwhile; endif; ?>
 

</section>
</main>
<?php
get_footer();