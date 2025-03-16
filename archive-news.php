<?php get_header(); ?>

<section class="container mx-auto py-12 px-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">News Archive</h1>
    
    <div class="flex flex-wrap -mx-4">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <div class="w-full md:w-1/2 lg:w-1/3 px-4 mb-8">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="h-64 bg-cover bg-center" 
                                 style="background-image: url('<?php the_post_thumbnail_url('medium'); ?>')">
                            </div>
                        <?php endif; ?>
                        
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-4">
                                <a href="<?php the_permalink(); ?>" class="hover:text-blue-600">
                                    <?php the_title(); ?>
                                </a>
                            </h3>
                            <div class="text-gray-600 mb-4">
                                <?php the_excerpt(); ?>
                            </div>
                            <a href="<?php the_permalink(); ?>" 
                               class="text-blue-600 hover:text-blue-800 font-medium flex items-center">
                                Read More
                                <svg class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else : ?>
            <p>No news posts found</p>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>