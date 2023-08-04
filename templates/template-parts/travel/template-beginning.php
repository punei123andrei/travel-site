<?php 
$our_star = get_field('our_star');
$our_star_hi_dpi = get_field('our_star_hi_dpi');
$our_star_portrait = get_field('our_star_portrait');
$our_star_portrait_hi_dpi = get_field('our_star_portrait_hi_dpi');
$our_star_landscape = get_field('our_star_landscape');
$our_star_landscape_hi_dpi = get_field('our_star_landscape_hi_dpi');
?>


<div id="our-beginning" class="page-section" data-matching-link="#our-beginning-link">
      <div class="wrapper">
        <h2 class="headline headline--centered headline--light headline--b-margin-small">The first trip we planned <strong>was our own.</strong></h2>
        <h3 class="headline headline--centered headline--orange headline--small headline--narrow headline--light headline--b-margin-large">Ever since, we&rsquo;ve been working to make travel <strong>better for everyone.</strong></h3>
        <div class="wrapper wrapper--medium wrapper--b-margin"><img loading="lazy" sizes="(min-width: 970px) 976px, 100vw" srcset="imgaes/first-trip-low-res.jpg 565w, imgaes/first-trip.jpg 976w, imgaes/first-trip-hi-dpi.jpg 1952w" alt="Couple walking down a street." /></div>
        <div class="row row--gutters">
          <div class="row__medium-4 row__medium-4--larger row__b-margin-until-medium">
            <picture
              ><source sizes="404px" srcset="<?php echo esc_url($our_star); ?> 404w, <?php echo esc_url($our_star_hi_dpi); ?> .jpg 808w" media="(min-width: 1020px)" />
              <source sizes="320px" srcset="<?php echo esc_url($our_star_portrait); ?> 382w, <?php echo esc_url($our_star_portrait_hi_dpi); ?> 764w" media="(min-width: 800px)" />
              <img loading="lazy" srcset="<?php echo esc_url($our_star_landscape); ?> 800w, <?php echo esc_url($our_star_landscape_hi_dpi); ?> 1600w" alt="Our founder, Jane Doe"
            /></picture>
          </div>
          <div class="row__medium-8 row__medium-8--smaller">
            <div class="generic-content-container">
              <h2 class="headline headline--no-t-margin">Here&rsquo;s how we got started&hellip;</h2>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, <a href="#">quis nostrud exercitation</a> ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
              <p>Duis aute irure dolor in <strong>reprehenderit in</strong> voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
              <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum velit esse cillum <strong>dolore eu fugiat.</strong></p>
            </div>
          </div>
        </div>
      </div>
    </div>