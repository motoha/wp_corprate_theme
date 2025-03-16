<?php get_header(); ?>

<main class="container mx-auto py-12 px-4 md:px-8">
    <div class="flex flex-col md:flex-row gap-6">
        <!-- Sidebar -->
        <aside class="md:w-1/4 ">
            <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold mb-6">Services</h2>
            <?php get_sidebar('custom'); ?>
            </div>
        </aside>

        <!-- Main Content -->
        <section class="flex-1 bg-white p-6 rounded-lg shadow-lg">
            <?php if (have_posts()) : the_post(); ?>
                <div class="max-w-3xl mx-auto">
                    <h1 class="text-4xl font-bold text-gray-800 mb-6"><?php the_title(); ?></h1>
                    
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="mb-8">
                            <?php the_post_thumbnail('large', ['class' => 'rounded-lg shadow-md w-full h-auto']); ?>
                        </div>
                    <?php endif; ?>

                    <div class="content text-gray-700 prose lg:prose-xl">
                        <?php the_content(); ?>
                    </div>

                    <div class="mt-8">
                        <a href="<?php echo get_post_type_archive_link('news'); ?>" 
                           class="text-blue-600 hover:text-blue-800 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Back to Service
                        </a>
                    </div>
                </div>
            <?php else : ?>
                <p class="text-red-600 font-semibold"><?php _e('News post not found', 'text_domain'); ?></p>
            <?php endif; ?>
        </section>
    </div>
</main>

<?php get_footer(); ?>
