<?php

// [make_rss title="Makerspace", feed="https://makezine.com/tag/makerspaces/feed/", moreLink="http://makezine.com/tag/makerspaces/", number=4]
function make_rss_func($atts) {
    $a = shortcode_atts(array(
        'title' => '',
        'feed' => 'https://makezine.com/feed/',
        'moreLink' => "",
        'number' => 6
            ), $atts);
    $return = '    
    <div class="container makerspace-news">
        <h2>' . $a['title'] . ' News from <img class="logo" src="https://make.co/wp-content/themes/memberships/img/make_logo.svg" /> magazine</h2>
        <div class="row posts-feeds-wrapper">';


    $rss = fetch_feed($a['feed']);
    if (!is_wp_error($rss)) {
        $maxitems = $rss->get_item_quantity($a['number']); //gets latest x items, this can be changed to suit your requirements
        $rss_items = $rss->get_items(0, $maxitems);
    }

    if ($maxitems == 0) {
        $return .= '<li>No items.</li>';
    } else {
        foreach ($rss_items as $item) {
            $return .= '
                    <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                        <div class="post-feed">
                            <a class="full-link" href="' . esc_url($item->get_permalink()) . '" target="_blank">
                                <div class="title">
                                    <p class="p-title">' . esc_html($item->get_title()) . '</p>
                                    <img src="' . get_first_image_url($item->get_content()) . '" alt="' . esc_html($item->get_title()) . ' featured image">                                    
                                    <p>' . shorten(get_summary($item->get_content()), 120) . '</p>
                                </div>
                            </a>
                        </div>
                    </div>';
        }
    }
    if ($a['moreLink'] != '') {
        $return .= '
                <div class="col-xs-12">
                    <a class="btn universal-btn btn-more-articles" href="' . $a['moreLink'] . '" target="_blank">See more articles</a>
                </div>';
    }
    $return .= '    
        </div>

    </div>';
    return $return;
}

add_shortcode('make_rss', 'make_rss_func');

function make_tint_func($atts) {
    $a = shortcode_atts(array(
        'personalization_id' => '',
        'title' => '',
        'hashtags' => ""
            ), $atts);

    $args = [
        'personalization_id' => $a['personalization_id'],
        'title' => $a['title'],
        'hashtags' => $a['hashtags']
    ];
    require_once 'MF-Social-Block.php';
    return do_social_block($args);    
}

add_shortcode('make_tint', 'make_tint_func');

function login_form_shortcode() {
	if ( is_user_logged_in() )
		return '<div style="padding: 35px 30px 0px;">
		        <h2 style="color:#fff;margin-top:0px;font-weight: 300;">Welcome, '.bp_core_get_user_displayname( bp_loggedin_user_id() ).'</h2>
		        <p><a href="'.bp_loggedin_user_domain().'" class="btn universal-btn-reversed" style="width:100%;">My Profile</a></p>
		        <p><a href="/groups" class="btn universal-btn-reversed" style="width:100%;">Browse Groups</a></p>
				  <p><a href="/members" class="btn universal-btn-reversed" style="width:100%;">Member Directory</a></p>
				  <p><a href="/activity" class="btn universal-btn-reversed" style="width:100%;">Newsfeed</a></p>
				  <p><a href="/digital-library" class="btn universal-btn-reversed" style="width:100%;">View Digital Magazine</a></p>
				  </div>';
	$return = '<style type="text/css">
	            #login-shortcode {
						width: 320px;
						padding: 10px 0 ;
						background: #fff;
						margin: 30px auto;
						border-radius: 5px;
						box-shadow: 5px 5px 5px rgba(0,0,0,.13);
						position: relative;
					}
					#login-shortcode h1 a { display: none; }
					#login-shortcode:before {
						content: "Login";
						font-size: 2.3em;
						margin-left: 24px;
					}
					#login-shortcode form#loginform{
						border-top: 7px solid #33b5e5;
						margin-top: 10px;
						margin-left: 0;
						padding: 26px 24px 9px;
						font-weight: 400;
						overflow: hidden;
						background: #fff;
					}
					#login-shortcode form#loginform input[type=text], #login-shortcode form#loginform input[type=password] {
						width: 100%;
						border: 1px solid rgba(0, 0, 0, 0.1);
						border-radius: 2px;
						color: #2b2b2b;
						padding: 8px 10px 7px;
						background-color: #fafafa;
						margin-bottom: 7px;
						height: auto !important;
						font-size: 14px;
						font-weight: 300;
						background-color: #edf0f5;
						box-shadow: 2px 0px 30px rgba(0,0,0,0);
						-webkit-box-shadow: 0px 0px 9px rgba(0,0,0,0);
						-moz-box-shadow: 2px 0px 30px rgba(0,0,0,0);
						-webkit-transition: all 0.3s linear 0s;
						-moz-transition: all 0.3s linear 0s;
						-ms-transition: all 0.3s linear 0s;
						-o-transition: all 0.3s linear 0s;
					}
					#login-shortcode form#loginform input[type=submit] {
					   width: 50%;
						margin-left: 50%;
					}
					#login-shortcode .register {
					    border-radius: 0px;
						 position: absolute;
						 bottom: 29px;
						 left: 25px;
						 width: 39%;
						 text-transform: capitalize;
						 height: 46px;
						 background: #1987C7;
						 border-color: #1987C7;
					}
					#login-shortcode .register:hover {
					    background: #fff;
						 color: #1987C7;
					}
				  </style>';
	$return .= '<div id="login-shortcode">';
	$return .= wp_login_form( array( 'echo' => false ) );
	$return .= '<a href="/join" class="btn universal-btn register">Join Now</a></div>';
	return $return;
}
add_shortcode('login_form', 'login_form_shortcode');
