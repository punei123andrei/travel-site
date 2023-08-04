<?php

/**
 * Encode a string to URL-safe base64
 * @param string $value
 * @return string
 */
function encodeBase64UrlSafe(string $value): string
{
    return str_replace(['+', '/'], ['-', '_'], base64_encode($value));
}

/**
 * Decode a string from URL-safe base64
 * @param string $value
 * @return string
 */
function decodeBase64UrlSafe(string $value): string
{
    return base64_decode(str_replace(['-', '_'], ['+', '/'], $value));
}

/**
 * Check if string has html
 * @param string $string
 * @return bool
 */
function isHtml(string $string): bool
{
    if ($string != strip_tags($string)) {
        return true;
    }

    return false;
}

/**
 * @param string $string
 * @param array $array
 * @return int
 */
function containsAnyInString(string $string, array $array): int
{
    $count = 0;
    foreach($array as $value) {
        if (false !== stripos($string,$value)) {
            ++$count;
        }
    }
    return $count;
}

/**
 * Gets a block name
 *
 * @param string $name
 * @return string
 */
function getBlockName(string $name): string
{
    return explode('/', $name)[1];
}

/**
 * Returns a trimmed string to a specific char length
 * @param int $charlength String charlength
 * @param string $string
 * @param string $delimiter Special delimited at the end of the trimmed string
 * @return string
 */
function getTrimmedStringToLength(int $charlength, string $string, string $delimiter = '...'): string
{

    if ($string == '') {
        return '';
    }

    $output = '';

    if (mb_strlen($string) > $charlength) {

        $subex   = mb_strimwidth($string, 0, $charlength);
        $exwords = explode(' ', $subex);

        $output .= strip_tags($subex . $delimiter);

    } else {
        $output .= strip_tags($string);
    }

    return $output;
}

/**
 * Translate strings
 *
 * @param  string $string    String to be translated
 * @param  array  $args      Arguments
 */
function translateString(string $string, array $args = []): string
{
    // if we have arguments
    if ($args) {
        return sprintf(__($string, 'the-theme-name-text-domain'), ...$args);
    }

    return __($string, 'the-theme-name-text-domain');
}

/**
 * Get formatted date for an event
 *
 * @param string $startDate Starting event date
 * @param string $format Accepted format of the date
 * @return string
 */
function getEventFormattedDate(string $startDate, string $format = 'd M Y | H:i'): string
{
    // bail if no start date
    if (empty($startDate)) {
        return '';
    }

    // if time is not set change date format
    if (!timeExists($startDate)) {
        $format = 'd M Y';
    }

    return wp_date($format, strtotime($startDate));

}

/**
 * Check if time is not 00:00
 *
 * @param string $date Date string
 * @param string $format [description]
 * @return bool
 */
function timeExists(string $date, string $format = 'd M Y H:i'): bool
{
    $splitDate = date_parse_from_format($format, $date);

    if (0 === $splitDate['hour'] && 0 === $splitDate['minute']) {
        return false;
    }

    return true;
}

/**
 * Sets and array for image data
 *
 * @param string $url Url
 * @param string $width Width
 * @param string $height Height
 * @return array
 */
function setPreviewImageData(string $url, string $width = '100%', string $height = 'auto'): array
{
    return [
        'url'       => $url,
        'width'     => $width,
        'height'    => $height,
    ];
}

/**
 * Convert hex to rgba and return rgb(a) string
 *
 * @param string $color Hex color
 * @param string $opacity Color opacity
 * @return string
 */
function hex2rgba(string $color, string $opacity = '1'): string
{

    $default = 'rgb(0,0,0)';

    // Return default if no color provided
    if(empty($color)) {
        return $default;
    }

    // Sanitize $color if "#" is provided
    if ($color[0] == '#' ) {
        $color = substr($color, 1);
    }

    // Check if color has 6 or 3 characters and get values
    if (strlen($color) == 6) {
        $hex = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
    } elseif (strlen($color) == 3) {
        $hex = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
    } else {
        return $default;
    }

    // Convert hexadec to rgb
    $rgb = array_map('hexdec', $hex);

    $output = 'rgb('.implode(',',$rgb).')';

    // Check if opacity is set(rgba or rgb)
    if ($opacity) {
        if (abs($opacity) > 1) {
            $opacity = 1.0;
        }

        $output = 'rgba('.implode(',',$rgb).','.$opacity.')';
    }

    // Return rgb(a) color string
    return $output;
}

/**
 * Get color and convert it to rgb integer
 *
 * @param  string $color  Color to convert
 */
function htmlToRgb(string $color): int
{
    if ($color[0] == '#') {
        $color = substr($color, 1);
    }

    if (strlen($color) == 3) {
        $color = $color[0] . $color[0] . $color[1] . $color[1] . $color[2] . $color[2];
    }

    $rChannel = hexdec($color[0] . $color[1]);
    $gChannel = hexdec($color[2] . $color[3]);
    $bChannel = hexdec($color[4] . $color[5]);

    return $bChannel + ($gChannel << 0x8) + ($rChannel << 0x10);
}

function rgbToHsl(int $rgb): object
{
    $channelFactor = 255.0;

    $rChannel = 0xFF & ($rgb >> 0x10);
    $gChannel = 0xFF & ($rgb >> 0x8);
    $bChannel = 0xFF & $rgb;

    $rChannel = ((float) $rChannel) / $channelFactor;
    $gChannel = ((float) $gChannel) / $channelFactor;
    $bChannel = ((float) $bChannel) / $channelFactor;

    $maxC = max($rChannel, $gChannel, $bChannel);
    $minC = min($rChannel, $gChannel, $bChannel);

    $lightness = ($maxC + $minC) / 2.0;

    if ($maxC == $minC) {
        $saturation = 0;
        $hue = 0;
    } else {
        if ($lightness < .5) {
            $saturation = ($maxC - $minC) / ($maxC + $minC);
        } else {
            $saturation = ($maxC - $minC) / (2.0 - $maxC - $minC);
        }

        if ($rChannel == $maxC) {
            $hue = calculateChannel($gChannel, $bChannel, $maxC, $minC);
        }

        if ($gChannel == $maxC) {
            $hue = 2.0 + calculateChannel($bChannel, $rChannel, $maxC, $minC);
        }

        if ($bChannel == $maxC) {
            $hue = 4.0 + calculateChannel($rChannel, $gChannel, $maxC, $minC);
        }

        $hue = $hue / 6.0;
    }

    $hue = calculateRoundedChannel($channelFactor, $hue);
    $saturation = calculateRoundedChannel($channelFactor, $saturation);
    $lightness = calculateRoundedChannel($channelFactor, $lightness);

    return (object) Array(
        'hue'           => $hue,
        'saturation'    => $saturation,
        'lightness'     => $lightness,
    );
}

function calculateRoundedChannel($factor, $value): int
{
    return round($factor * $value);
}

function calculateChannel($channel1, $channel2, $max, $min)
{
    return ($channel1 - $channel2) / ($max - $min);
}

/**
 * Returns a theme color dark or light
 *
 * @param  string  $backgroundColor      Color to check against
 * @param  integer $threshold            A threshold from where should theme change to dark or light
 */
function getThemeColor(string $backgroundColor, int $threshold = 200): string
{
    // backgroundColor
    if ($backgroundColor) {

        // transform backgroundColor to hsl
        $hsl = rgbToHsl(htmlToRgb($backgroundColor));

        // set text style class text-light or text-dark
        return $hsl && $hsl->lightness > intval($threshold) ? ' text-dark' : ' text-light';
    }

    return '';
}

/**
 * Gets link attributes by field name
 *
 * @param  string   $fieldName   Acf field name
 */
function getLinkAttributes(string $fieldName, bool $subfield = false, int $id = 0): array
{
    if (empty($fieldName)) {
        return [];
    }

    $link = $subfield ? (get_sub_field($fieldName) ?: []) : (get_field($fieldName) ?: []);

    if ($id) {
        $link = $subfield ? (get_sub_field($fieldName, $id) ?: []) : (get_field($fieldName, $id) ?: []);
    }

    return [
        'url'       => $link && isset($link['url']) ? $link['url'] : '',
        'title'     => $link && isset($link['title']) ? $link['title'] : '',
        'target'    => $link && isset($link['target']) ? $link['target'] : '',
    ];
}

/**
 * Display a numbered pagination
 *
 * @param  object $query     Query to get pagination from
 * @param  string $current   Current page
 */
function pagination(object $query, string $current): void
{
	if ($query->max_num_pages <= 1) {
        return;
    }

	echo '<div class="pagination">';

		echo paginate_links([
			'current' 		=> max(1, $current),
			'total' 		=> $query->max_num_pages,
            'show_all'      => false,
			'end_size'		=> 0,
			'mid_size'		=> 1,
			'prev_text' 	=> '<i class="bi bi-arrow-left-circle-fill"></i>',
			'next_text' 	=> '<i class="bi bi-arrow-right-circle-fill"></i>'
		]);

	echo '</div>';
}

/**
 * Get allowed file extensions
 */
function getAllowedExtensions(): array
{
    // allowed file types
    return [
        'xls',
        'xlsx',
        'doc',
        'docx',
        'pdf',
        'ppt',
        'pptx',
        'mp4',
        'avi',
        'mkv'
    ];
}
/**
 * Get file extension from url
 *
 * @param  string $url  Url to check
 *
 */
function getFileExtensionFromUrl(string $url)
{
    // explode url
    $url = explode('/', $url);

    // get last url part
    $url = end($url);

    // get allowed extensions
    $extensions = getAllowedExtensions();

    foreach ($extensions as $extension) {

        // there is a match return extension
        if(preg_match('/\b' . $extension . '\b/i', $url)) {
            return $extension;
        }
    }
}

/**
 * Wrap content in bootstrap container -> row -> col-12
 *
 * @param  string $content    A string content to be wrapped
 */
function outputBootstrapWrapped(string $content): string
{
    $html = '';
    $html .= '<div class="container">' . "\n";
        $html .= '<div class="row">' . "\n";
            $html .= '<div class="col-12">' . "\n";
                $html .= $content;
            $html .= '</div>' . "\n";
        $html .= '</div>' . "\n";
    $html .= '</div>' . "\n";

    return $html;
}

/**
 * Returns an empty-block class if in admin
 */
function setEmptyClass(): string
{
    return is_admin() ? ' empty-block' : '';
}

/**
 * Dequeue contact form scripts
 */
function dequeueContactScripts(): void
{
    wp_dequeue_script('contact-form-7');
    wp_dequeue_script('google-recaptcha');
    wp_dequeue_script('wpcf7-recaptcha');
    wp_dequeue_style('contact-form-7');
}

/**
 * Change search url by current language
 *
 * @param  string $url                    Current search url to translate
 * @param  string $langCode               Language code (en, ro, etc)
 *
 */
function changeSearchUrlByLang(string $url, string $langCode, string $textDomain): string
{

    // param to search for
    $searchFor = 's=';

    // param position
    $paramPosition = strpos($url, $searchFor);

    $newUrl = '';

    // if our s query var found we have a search
    if ($paramPosition !== false) {

        // check the lang to replace with specific string
        $replaceWith = apply_filters('wpml_translate_single_string', 'search', $textDomain, 'search', $langCode);

        // change url with custom search string
        $newUrl = substr_replace($url, $replaceWith . '=', $paramPosition, strlen($searchFor));
    }

    return $newUrl;
}

/**
 * Get current url
 *
 */
function getCurrentUrl(): string
{
    global $wp;

    // home url
    $homeUrl = home_url($wp->request);

    // important to add this to the url
    $trailingslashitHomeUrl = trailingslashit($homeUrl);

    return add_query_arg($_SERVER['QUERY_STRING'], '', $trailingslashitHomeUrl);
}

/**
 * Get archive page id by a post type
 *
 * @param  string $postType      Post type, optional, default to post
 *
 */
function getArchivePageIdByPostType(string $postType = 'post'): string
{
    return get_field($postType . '_archive_page', 'options') ?? '';
}

/**
 * Get post parent by a post id
 * @param integer $postId Post id for which to retrieve parents
 * @param integer $count Count variable, optional
 * @param array $object Object array, optional
 * @return array
 */
function getPostParentsByPostId(int $postId, int $count = 0, array $object = []): array
{
    // bail early
    if (!$postId) {
        return [];
    }

    // get post data
    $post = get_post($postId);

    $id = $post->ID;
    $url = get_the_permalink($id);
    $title = get_the_title($id);


    // first we set id, url and text for the current postId
    $object[$count]['id'] = $id;
    $object[$count]['url'] = $url;
    $object[$count]['text'] = $title;

    // current post has no parent
    if (0 == $post->post_parent) {

        $object[$count]['id'] = $id;
        $object[$count]['url'] = $url;
        $object[$count]['text'] = $title;

        return $object;
    } else {

        // increment this
        $count++;

        // continue
        return getPostParentsByPostId($post->post_parent, $count, $object);
    }
}
