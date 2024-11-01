<?php
error_reporting(E_ERROR);

/**
 * @package wp-youtube-playlist-widget
*/

/**
Plugin Name: Wordpress Youtube Playlist Widget
Description: This plugin loads the list of videos from a given public youtube playlist ID using google API. To get started: 1) Click the "Activate" link to the left of this description, 2) <a href="https://console.developers.google.com/project">Create your Google API key</a>, and 3) Go to https://www.youtube.com/ page, and get any public playlist that you like to show on the website sidebar and save to the widget configuration box.
Author: Srikanth Lavudia, DevsMind
License: GPLv2 or later
Version: 2.0
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
*/

/**
 * Load the JQuery-UI Dialog library that ships with wordpress by default.
*/
wp_enqueue_script("jquery-ui-core", array('jquery'));
wp_enqueue_script("jquery-ui-dialog", array('jquery'));
wp_enqueue_style( 'wp-jquery-ui-dialog' );

/**
 * Load the custom JS script & CSS files related with 
 * this plugin
*/
wp_enqueue_script('custom', plugin_dir_url(__FILE__) . '/js/custom.js', array('jquery'));
wp_enqueue_style('custom-css', plugin_dir_url(__FILE__) .'/css/custom.css');

class WordpressYoutubePlaylistWidget extends WP_Widget
{
  function WordpressYoutubePlaylistWidget()
  {
    $widget_ops = array('classname' => 'WordpressYoutubePlaylistWidget', 'description' => 'Displays a list of videos from youtube playlist using Google API.' );
    $this->WP_Widget('WordpressYoutubePlaylistWidget', 'Wordpress Youtube Playlist Videos', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
    $title = $instance['title'];
    $api_key = $instance['api_key'];
    $playlist_id = $instance['playlist_id'];
    $show_max = $instance['show_max'];
    $layout = $instance['layout'];
?>
  <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>

  <p><label for="<?php echo $this->get_field_id('api_key'); ?>">Google API Key: <input class="widefat" id="<?php echo $this->get_field_id('api_key'); ?>" name="<?php echo $this->get_field_name('api_key'); ?>" type="text" value="<?php echo attribute_escape($api_key); ?>" /></label></p>

  <p><label for="<?php echo $this->get_field_id('playlist_id'); ?>">Youtube Playlist ID: <input class="widefat" id="<?php echo $this->get_field_id('playlist_id'); ?>" name="<?php echo $this->get_field_name('playlist_id'); ?>" type="text" value="<?php echo attribute_escape($playlist_id); ?>" /></label></p>

  <p><label for="<?php echo $this->get_field_id('show_max'); ?>">Show Max Videos: <input class="widefat" id="<?php echo $this->get_field_id('show_max'); ?>" name="<?php echo $this->get_field_name('show_max'); ?>" type="text" value="<?php echo attribute_escape($show_max); ?>" /></label></p>
  
  <p><label for="<?php echo $this->get_field_id('text'); ?>">Layout: <select class='widefat' id="<?php echo $this->get_field_id('layout'); ?>" name="<?php echo $this->get_field_name('layout'); ?>" type="text"><option value=''<?php echo ($layout==null)?'selected':''; ?>>-- Select --</option><option value='v'<?php echo ($layout=='v')?'selected':''; ?>>Vertical</option><option value='h'<?php echo ($layout=='h')?'selected':''; ?>>Horizontal</option></select></label></p>
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    $instance['api_key'] = $new_instance['api_key'];
    $instance['playlist_id'] = $new_instance['playlist_id'];
    $instance['show_max'] = $new_instance['show_max'];
	  $instance['layout'] = $new_instance['layout'];
    return $instance;
  }
 
  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
 
    echo $before_widget;
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
 
    if (!empty($title))
      echo $before_title . $title . $after_title;;

      $apiKey = $instance['api_key'];
  
      $playListId = $instance['playlist_id'];

      $videoCount = (int)$instance['show_max'];
    
      $format = $instance['layout'];
 
    /**
     * Call the function to process the playlist code for widget
    */
    self::processPlaylist($apiKey, $playListId, $videoCount, 50, $format);    
  }

  /**
   * Function to process the playlist
   * 
   * @param string $key        Google API Key
   * @param string $listId     Youtube Playlist ID
   * @param int    $userVidCnt User defined video count
   * @param int    $maxCnt     Maximum count allowed by youtube
   * @param string $pageLayout Playlist layout to show
  */
  function processPlaylist($key, $listId, $userVidCnt, $maxCnt, $pageLayout){

    $currClsObj = new WordpressYoutubePlaylistWidget;

    $videosList = $currClsObj->getVideos($userVidCnt, $listId, $key, false, '');

    if($userVidCnt <= $maxCnt){
        $videosList = $currClsObj->getVideos($userVidCnt, $listId, $key, false, '');
        $currClsObj->displayVideoList($videosList, $pageLayout);
    } else {
        $counter = 0;
        while($userVidCnt > 0){
          if($counter == 0){
              $videosList = $currClsObj->getVideos($userVidCnt, $listId, $key, false, '');
              $currClsObj->displayVideoList($videosList, $pageLayout);
          } else {
              if($userVidCnt > $maxCnt){
                  $videosList = $currClsObj->getVideos($maxCnt, $listId, $key, true, $nextToken);
              } else {
                  $videosList = $currClsObj->getVideos($userVidCnt, $listId, $key, true, $nextToken);
              }
              $currClsObj->displayVideoList($videosList, $pageLayout);
          }
          $counter++;
          $videoCount = $videoCount - $maxCnt;
          $nextToken = $videosList['nextPageToken'];
      }
    }
  }
  /**
   * function to get videos for the said playlist ID
   * 
   * @param int    $maxVideos  Maximum number of videos to fetch
   * @param string $playListId Public youtube playlist ID
   * @param string $apiKey     Google API Key
   *
   * @return array List of youtube videos data
  */
  function getVideos($maxVideos, $playListId, $apiKey, $isNext, $nextToken){
    // Open CURL connection.
    $ch = curl_init();
    
    if ($isNext){
        $url = 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults='.$maxVideos.'&playlistId='.$playListId.'&key='.$apiKey.'&pageToken='.$nextToken;
    } else {
        $url = 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults='.$maxVideos.'&playlistId='.$playListId.'&key='.$apiKey;
    }
    
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, 'Content-Type: application/json');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    // Execute request
    $result = curl_exec($ch);

    // Close connection
    curl_close($ch);

    // get the result and parse to JSON
    $result_arr = json_decode($result, true);
    return $result_arr;
  }
  
  /**
   * Function to display list of youtube videos
   *
   * @param array $collection Parsed data from youtube
   *
   * @return null
  */
  function displayVideoList($collection, $pageFormat){
        $layoutClass = '';
        if ($pageFormat == 'h'){
            $layoutClass = 'horizontal';
        }
  
        if (isset($collection['error'])){
            echo '<p style="color:red;font-weight:bold;">An error occurred:</p>';
            echo '<p style="color:red; font-size:12px;">'.$collection['error']['message'].'</p>';
        } else {
            echo '<ul class="youtube-playlist '.$layoutClass.'">';
            foreach($collection['items'] as $i => $listItems){
                $vIds = $listItems['snippet']['resourceId']['videoId'];
                $vTitle = $listItems['snippet']['title'];
                $videoThumb = $listItems['snippet']['thumbnails']['medium']['url'];
                $videoURL = 'https://www.youtube.com/watch?v='.$vIds;
                echo '<li><img src="'.$videoThumb.'" /><a class="play" data-video_id="'.$vIds.'" target="_blank" href="'.$videoURL.'" title="'.$vTitle.'">Watch</a><span>'.$vTitle.'</span></li>';
            }
            echo '</ul>';
        }
        echo $after_widget;
  }
}

/**
 * Function to process the shotcode for the youtube playlist
 * that can be used on any page or post
 *
 * @param array $atts Collection of shortcorde attributes to process the youtube playlist
 *
 * @return null
*/
function process_playlist_shortcode($atts){
  $atts = shortcode_atts(
    array(
      'api_key' => '',
      'playlist_id' => '',
      'show_max' => 50,
      'layout' => ''
    ), $atts
  );
  $newCls = new WordpressYoutubePlaylistWidget;
  $newCls->processPlaylist($atts['api_key'], $atts['playlist_id'], $atts['show_max'], 50, $atts['layout']); 
}
  add_shortcode('youtube-playlist', 'process_playlist_shortcode');
  add_action( 'widgets_init', create_function('', 'return register_widget("WordpressYoutubePlaylistWidget");') );
?>