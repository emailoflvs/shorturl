<?php
/**
 * Deprecated functions from past YOURLS versions. Don't use them, as they may be
 * removed in a later version. Use the newer alternatives instead.
 *
 * Note to devs: when deprecating a function, move it here. Then check all the places
 * in core that might be using it, including core plugins.
 */

// @codeCoverageIgnoreStart

/**
 * Return word or words if more than one
 *
 */
function yourls_plural($word, $count = 1)
{
    yourls_deprecated_function(__FUNCTION__, '1.6', 'yourls_n');
    return $word . ($count > 1 ? 's' : '');
}

/**
 * Return list of all shorturls associated to the same long URL. Returns NULL or array of keywords.
 *
 */
function yourls_get_duplicate_keywords($longurl)
{
    yourls_deprecated_function(__FUNCTION__, '1.7', 'yourls_get_longurl_keywords');
    if (!yourls_allow_duplicate_longurls())
        return NULL;
    return yourls_apply_filter('get_duplicate_keywords', yourls_get_longurl_keywords($longurl), $longurl);
}

/**
 * Make sure a integer is safe
 *
 * Note: this function is dumb and dumbly named since it does not intval(). DO NOT USE.
 *
 */
function yourls_intval($int)
{
    yourls_deprecated_function(__FUNCTION__, '1.7', 'yourls_sanitize_int');
    return yourls_escape($int);
}

/**
 * Get remote content via a GET request using best transport available
 *
 */
function yourls_get_remote_content($url, $maxlen = 4096, $timeout = 5)
{
    yourls_deprecated_function(__FUNCTION__, '1.7', 'yourls_http_get_body');
    return yourls_http_get_body($url);
}

/**
 * Alias for yourls_apply_filter because I never remember if it's _filter or _filters
 *
 * At first I thought it made semantically more sense but thinking about it, I was wrong. It's one filter.
 * There may be several function hooked into it, but it still the same one filter.
 *
 * @param string $hook the name of the YOURLS element or action
 * @param mixed $value the value of the element before filtering
 * @return mixed
 * @deprecated 1.7.1
 *
 * @since 1.6
 */
function yourls_apply_filters($hook, $value = '')
{
    yourls_deprecated_function(__FUNCTION__, '1.7.1', 'yourls_apply_filter');
    return yourls_apply_filter($hook, $value);
}

/**
 * Check if we'll need interface display function (ie not API or redirection)
 *
 */
function yourls_has_interface()
{
    yourls_deprecated_function(__FUNCTION__, '1.7.1');
    if (yourls_is_API() or yourls_is_GO())
        return false;
    return true;
}

/**
 * Check if a proxy is defined for HTTP requests
 *
 * @return bool true if a proxy is defined, false otherwise
 * @since 1.7
 * @deprecated 1.7.1
 * @uses YOURLS_PROXY
 */
function yourls_http_proxy_is_defined()
{
    yourls_deprecated_function(__FUNCTION__, '1.7.1', 'yourls_http_get_proxy');
    return yourls_apply_filter('http_proxy_is_defined', defined('YOURLS_PROXY'));
}

/**
 * Displays translated string with gettext context
 *
 * This function has been renamed yourls_xe() for consistency with other *e() functions
 *
 * @param string $text Text to translate
 * @param string $context Context information for the translators
 * @param string $domain Optional. Domain to retrieve the translated text
 * @return string Translated context string without pipe
 * @since 1.6
 * @deprecated 1.7.1
 *
 * @see yourls_x()
 */
function yourls_ex($text, $context, $domain = 'default')
{
    yourls_deprecated_function(__FUNCTION__, '1.7.1', 'yourls_xe');
    echo yourls_xe($text, $context, $domain);
}

/**
 * Escape a string or an array of strings before DB usage. ALWAYS escape before using in a SQL query. Thanks.
 *
 * Deprecated in 1.7.3 because we moved onto using PDO and using built-in escaping functions, instead of
 * rolling our own.
 *
 * @param string|array $data string or array of strings to be escaped
 * @return string|array escaped data
 * @deprecated 1.7.3
 */
function yourls_escape($data)
{
    yourls_deprecated_function(__FUNCTION__, '1.7.3', 'PDO');
    if (is_array($data)) {
        foreach ($data as $k => $v) {
            if (is_array($v)) {
                $data[$k] = yourls_escape($v);
            } else {
                $data[$k] = yourls_escape_real($v);
            }
        }
    } else {
        $data = yourls_escape_real($data);
    }

    return $data;
}

/**
 * "Real" escape. This function should NOT be called directly. Use yourls_escape() instead.
 *
 * This function uses a "real" escape if possible, using PDO, MySQL or MySQLi functions,
 * with a fallback to a "simple" addslashes
 * If you're implementing a custom DB engine or a custom cache system, you can define an
 * escape function using filter 'custom_escape_real'
 *
 * @param string $a string to be escaped
 * @return string escaped string
 * @since 1.7
 * @deprecated 1.7.3
 */
function yourls_escape_real($string)
{
    yourls_deprecated_function(__FUNCTION__, '1.7.3', 'PDO');
    global $ydb;
    if (isset($ydb) && ($ydb instanceof \YOURLS\Database\YDB))
        return $ydb->escape($string);

    // YOURLS DB classes have been bypassed by a custom DB engine or a custom cache layer
    return yourls_apply_filter('custom_escape_real', addslashes($string), $string);
}

// @codeCoverageIgnoreEnd
