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
	$getfield = '?screen_name=@BorisJohnson&count=15&tweet_mode=extended';
	// $getfield = '?screen_name=BorisJohnson&count=1'; // for 140 char
	
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

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="styles.css">
	<title>Latest Tweets</title>
</head>
<body>
	<div class="wrapper">
		<h1>Latest Tweet</h1>

		<div class="tweet_tiles">
			<?php foreach ( $tweets as $tweet ) : ?>
				
			<!-- <?php $userlink = "https://twitter.com/" . $tweet['user']['screen_name'];?> -->

			<div class="single_tile" id="single_tile">

				<div class="profile_picture">
					<img src="<?php echo $tweet['user']['profile_image_url']; ?>" />
					<a href="https://twitter.com/<?php echo $tweet['user']['screen_name']; ?>" target="_blank">
					<b>@<?php echo $tweet['user']['screen_name']; ?></b>
				</div>

				</a>
				<br/>
				<!-- For 140 char <?php echo $tweet['text']; ?> -->
				<?php echo $tweet['full_text']; ?>
				<br/>
				<br/>

				<div class="single_tile_date">
					Tweeted on 
					<?php 
						$date = date_create($tweet['created_at']);
						echo date_format($date, "d/m/Y H:i:s");
					?>
				</div>
				<br/>

				<div id="myModal" class="modal">
					<div class="modal-content">		
						<div class="modal-header">
							<span class="close">&times;</span>
							<h2>Tweet</h2>
						</div>

						<div class="modal-body">
							<?php echo $tweet['full_text']; ?>
						</div>
					</div>
				</div>

			</div>

			<?php endforeach; ?>
		</div>
	</div>

<script src="events.js"></script>

</body>
</html>