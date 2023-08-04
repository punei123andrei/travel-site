<?php

use Genesis\Theme\Theme;

$footerFields = Theme::getFooterFields();

?>

        <footer>
            <div class="site-info"></div>
        </footer>

        <?php wp_footer(); ?>

        <?php
            // display footer scripts
            if (!empty($footerFields['footer_scripts'])) {
                echo $footerFields['footer_scripts'];
            }
        ?>

    </body>
</html>
