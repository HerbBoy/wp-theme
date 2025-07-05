<?php get_header(); ?>

<main class="front-page-content">
    <!-- Hero Section -->
    <section class="hero-section" id="hero">
        <div class="hero-background">
            <div class="hero-video-container">
                <video autoplay muted loop class="hero-video">
                    <source src="<?php echo get_template_directory_uri(); ?>/assets/videos/construction-hero.mp4" type="video/mp4">
                </video>
            </div>
            <div class="hero-overlay"></div>
        </div>
        
        <div class="hero-content">
            <div class="hero-text">
                <h1 class="hero-title animate-on-scroll">
                    <span class="title-line">Building the</span>
                    <span class="title-line glow-text">Future</span>
                    <span class="title-line">Today</span>
                </h1>
                <p class="hero-subtitle animate-on-scroll">Revolutionary construction solutions that transform your vision into reality with cutting-edge technology and unmatched craftsmanship.</p>
                <div class="hero-buttons animate-on-scroll">
                    <a href="#projects" class="hero-btn primary-btn neon-button">
                        <span>Explore Projects</span>
                        <div class="btn-glow"></div>
                    </a>
                    <a href="#contact" class="hero-btn secondary-btn glass-button">
                        <span>Get Quote</span>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="hero-scroll-indicator">
            <div class="scroll-indicator-line"></div>
            <div class="scroll-indicator-text">Scroll to explore</div>
        </div>
    </section>
    
    <!-- Services Section -->
    <section class="services-section" id="services">
        <div class="container">
            <h2 class="section-title animate-on-scroll">Our Services</h2>
            <div class="services-grid">
                <div class="service-card glass-card animate-on-scroll">
                    <div class="service-icon">🏠</div>
                    <h3>Smart Home Construction</h3>
                    <p>Integrate cutting-edge technology into every aspect of your home</p>
                </div>
                <div class="service-card glass-card animate-on-scroll">
                    <div class="service-icon">🔧</div>
                    <h3>Eco-Friendly Renovations</h3>
                    <p>Sustainable solutions that reduce your carbon footprint</p>
                </div>
                <div class="service-card glass-card animate-on-scroll">
                    <div class="service-icon">✨</div>
                    <h3>Luxury Finishing</h3>
                    <p>Premium materials and craftsmanship for extraordinary results</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Projects Section -->
    <section class="projects-section" id="projects">
        <div class="container">
            <h2 class="section-title animate-on-scroll">Featured Projects</h2>
            <div class="projects-grid" id="projects-grid">
                <?php
                $projects = new WP_Query(array(
                    'post_type' => 'projects',
                    'posts_per_page' => 6,
                ));
                
                if ($projects->have_posts()) :
                    while ($projects->have_posts()) : $projects->the_post();
                        get_template_part('template-parts/project-card');
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
            <button class="load-more-btn glass-button" id="load-more-projects">
                <span>Load More Projects</span>
            </button>
        </div>
    </section>
</main>

<?php get_footer(); ?>