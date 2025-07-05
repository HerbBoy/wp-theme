<?php get_header(); ?>

<main class="single-post-content">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <article class="post-article">
                <header class="post-header">
                    <h1 class="post-title glow-text"><?php the_title(); ?></h1>
                    <div class="post-meta">
                        <span class="post-date"><?php the_date(); ?></span>
                        <span class="post-author">By <?php the_author(); ?></span>
                    </div>
                </header>
                
                <div class="post-content">
                    <?php the_content(); ?>
                </div>
                
                <footer class="post-footer">
                    <?php the_tags('<div class="post-tags">Tags: ', ', ', '</div>'); ?>
                </footer>
            </article>
        <?php endwhile; ?>
    <?php endif; ?>
</main>

<?php get_footer(); ?>