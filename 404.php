<?php

get_header();

// vars here

?>
    <main id="page-404" class="mb-72">
        <div class="container">
            <div class="row">
                <div class="col-12 col-xl-8 offset-xl-2 text-center">

                    <?php get_template_part('templates/parts/components/heading', null, [
                        'text'  => __('404 - Page was not found', 'the-theme-name-text-domain'),
                        'class' => 'page-404__heading mt-0',
                    ]); ?>

                    <?php get_template_part('templates/parts/components/text', null, [
                        'text'  => __('It seems that you have reached a page lost in a maze of numbers and economic formulas. Don\'t worry, you have many other pages to visit on the the-theme-name-text-domain website.', 'the-theme-name-text-domain'),
                        'class' => 'page-404__text mb-24',
                    ]); ?>

                    <?php get_template_part('templates/parts/components/button', null, [
                        'url'           => home_url('/'),
                        'text'          => __('Back to the first page', 'the-theme-name-text-domain'),
                        'class'         => 'bttn-rounded bttn-blue',
                    ]); ?>

                </div>
            </div>
        </div>
    </main><!-- #main -->
<?php
get_footer();
