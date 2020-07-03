<?php
	// include config and twitter api files
	require_once( 'config.php' );
	require_once( 'TwitterAPIExchange.php' );

	// settings for twitter api connection via the credentials from config.php
	$settings = array(
		'oauth_access_token' => TWITTER_ACCESS_TOKEN, 
		'oauth_access_token_secret' => TWITTER_ACCESS_TOKEN_SECRET, 
		'consumer_key' => TWITTER_CONSUMER_KEY, 
		'consumer_secret' => TWITTER_CONSUMER_SECRET
	);

	// twitter api endpoint from specific user
	$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
	
	// twitter api endpoint for retrieval request
	$requestMethod = 'GET';

	// twitter api endpoint data (account name and amount of tweets to GET)
	$getfield = '?screen_name=BorisJohnson&count=15';

	// make api call to twitter
	$twitter = new TwitterAPIExchange( $settings );
	$twitter->setGetfield( $getfield );
	$twitter->buildOauth( $url, $requestMethod );
	$response = $twitter->performRequest( true, array( CURLOPT_SSL_VERIFYHOST => 0, CURLOPT_SSL_VERIFYPEER => 0 ) );
	// convert response data to JSON
	$tweets = json_decode( $response, true );
	
    /* display all info retrieved from twitter
     * echo '<pre>';
     * print_r( $tweets );
	 */
?>

<!-- -->
<html>
<head>
<style> 
	table, td {
	border: 2px solid black;
	}

	#myTABLE {
	width: 100%;
	}
</style>
</head>
<body>

<div>
	<h1 style="text-align:center">Latest Tweet</h1>
<div>

<table id="myTABLE">

	<?php 
		$counter = 0; 
		foreach ( $tweets as $tweet ) : 
	?>

	<td>	
		<?php $counter++; ?>

		<img src="<?php echo $tweet['user']['profile_image_url']; ?>" />
			<a href="https://twitter.com/<?php echo $tweet['user']['screen_name']; ?>" target="_blank">
				<b>@<?php echo $tweet['user']['screen_name']; ?></b>
			</a> tweeted:
			<br />
			<br />
			<?php echo $tweet['text']; ?>
			<br />
			<br />
				Tweeted on <?php echo $tweet['created_at']; ?>
			<br />
			<hr />

		<?php
			if ($counter == 3) {
			$counter = 0;
		?>
		
		<tr></tr>
		
		<?php } ?>
	</td>	

	<?php endforeach; ?>
</table>

<script>
	function myFunction() {
	document.getElementById("myTABLE").style.tableLayout = "fixed";
	}
</script>

</body>
</html>