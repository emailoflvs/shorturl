<?php
/*
 * YOURLS API
 *
 * Note about translation : this file should NOT be translation ready
 * API messages and returns are supposed to be programmatically tested, so default English is expected
 *
 */

$shortUrl = isset($_POST['shortUrl']) ? $_POST['shortUrl'] : "";
?>
    <form name="shortUrlForm" method="post">
        Короткая ссылка: <input type="text" name="shortUrl"
                                value="<?= $shortUrl ?>">
        <input type="submit" name="makeShortUrl" value="получить длинную ссылку">
    </form>

<?php

if ($shortUrl) {
//    echo "<br>Короткая сслыка: ".$shortUrl;
    echo "<br>Короткая ссылка: <a href=" . $shortUrl . ">" . $shortUrl . "</a>";

    $api_url = 'http://shorturl/yourls-api.php';

// Init the CURL session
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_HEADER, 0);            // No header in the result
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return, do not echo result
    curl_setopt($ch, CURLOPT_POST, 1);              // This is a POST request
    curl_setopt($ch, CURLOPT_POSTFIELDS, array(     // Data to POST
//        'shorturl' => 'ozh',
        'shorturl' => $shortUrl,
        'format' => 'json',
        'action' => 'expand',
        'signature' => '9b218da50d'
//        'username' => $username,
//        'password' => $password
    ));

// Fetch and return content
    $data = curl_exec($ch);
    curl_close($ch);

// Do something with the result. Here, we echo the long URL
    $data = json_decode($data);

//    echo "<br>Длинная ссылка: ".$data->longurl;
    echo "<br>Длинная ссылка: <a href=" . $data->longurl . ">" . $data->longurl . "</a>";
}
//define( 'YOURLS_API', true );
//require_once( dirname( __FILE__ ) . '/includes/load-yourls.php' );
//yourls_maybe_require_auth();
//
//$action = ( isset( $_REQUEST['action'] ) ? $_REQUEST['action'] : null );
//
//yourls_do_action( 'api', $action );
//
//// Define standard API actions
//$api_actions = array(
//	'shorturl'  => 'yourls_api_action_shorturl',
//	'stats'     => 'yourls_api_action_stats',
//	'db-stats'  => 'yourls_api_action_db_stats',
//	'url-stats' => 'yourls_api_action_url_stats',
//	'expand'    => 'yourls_api_action_expand',
//	'version'   => 'yourls_api_action_version',
//);
//$api_actions = yourls_apply_filter( 'api_actions', $api_actions );
//
//// Register API actions
//foreach( (array) $api_actions as $_action => $_callback ) {
//	yourls_add_filter( 'api_action_' . $_action, $_callback, 99 );
//}
//
//// Try requested API method. Properly registered actions should return an array.
//$return = yourls_apply_filter( 'api_action_' . $action, false );
//if ( false === $return ) {
//	$return = array(
//		'errorCode' => 400,
//		'message'   => 'Unknown or missing "action" parameter',
//		'simple'    => 'Unknown or missing "action" parameter',
//	);
//}
//
//if( isset( $_REQUEST['callback'] ) )
//	$return['callback'] = $_REQUEST['callback'];
//elseif ( isset( $_REQUEST['jsonp'] ) )
//	$return['callback'] = $_REQUEST['jsonp'];
//
//$format = ( isset( $_REQUEST['format'] ) ? $_REQUEST['format'] : 'xml' );
//
//yourls_api_output( $format, $return );
//
//die();