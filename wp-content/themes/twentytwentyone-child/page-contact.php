<?php
/**
 * Template Name: Page Contact
 */
?>

<?php get_header(); ?>

<section class = "inner-page-wrapper">
    <section class = "container">
        <section class = "row content">
            <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <h1><?php the_title(); ?></h1>
                    <article class="entry-content">

                        <form method="POST" name="form" id="form" enctype="multipart/form-data">

                            <div class="input-field">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" required>
                            </div>
                            <div class="input-field">
                                <label for="surname">Surname</label>
                                <input type="text" name="surname" id="surname">
                            </div>
                            <div class="input-field">
                                <label for="phone">Phone</label>
                                <input type="text" name="phone" id="phone" required>
                            </div>
                            <div class="input-field">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email">
                            </div>
                            <div class="images">
                                <p>Photos (max 4)</p>
                                <div class="pic">
                                    Add image
                                </div>
                            </div>

                            <div class="button-row">
                                <button>Submit</button>
                            </div>


                        </form>


                    </article>
                </article>
            <?php endwhile; ?>
        </section>
    </section>
</section>

<?php get_footer(); ?>
