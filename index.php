<?php get_header(); ?>

<main class="main-content">
    <?php if (have_posts()) : ?>
        <div class="posts-container">
            <?php while (have_posts()) : the_post(); ?>
                <article class="post-card glass-morphism">
                    <div class="post-content">
                        <h2 class="post-title"><?php the_title(); ?></h2>
                        <div class="post-excerpt"><?php the_excerpt(); ?></div>
                        <a href="<?php the_permalink(); ?>" class="read-more-btn neon-button">Read More</a>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>
        
        <div class="pagination-container">
            <?php the_posts_pagination(); ?>
        </div>
    <?php else : ?>
        <div class="no-posts">
            <h2>No posts found</h2>
            <p>Nothing here yet, but check back soon!</p>
        </div>
    <?php endif; ?>
</main>

<?php get_footer(); ?>