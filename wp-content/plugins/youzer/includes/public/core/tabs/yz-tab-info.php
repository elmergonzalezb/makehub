<?php

class YZ_Info_Tab {

    /**
     * Constructor
     */
    function __construct() {
    }

    /**
     * # Tab.
     */
    function tab() {

        // Get User Profile Widgets
        $this->get_user_infos();

        do_action( 'youzer_after_infos_widgets' );
    }

    /**
     * # Get Custom Widgets functions.
     */
    function get_user_infos() {
        
        if ( ! bp_is_active( 'xprofile' ) ) {
            return false;
        }

        do_action( 'bp_before_profile_loop_content' );
        
        if ( bp_has_profile() ) : while ( bp_profile_groups() ) : bp_the_profile_group();
                
            if ( bp_profile_group_has_fields() ) :
                    
                $group_id = bp_get_the_profile_group_id();

                // Custom infos Widget Arguments
                $custom_infos_args = array(
                    'widget_icon'       => yz_get_xprofile_group_icon( $group_id ),
                    'widget_title'      => bp_get_the_profile_group_name(),
                    'widget_name'       => 'custom_infos',
                );

                youzer()->widgets->yz_widget_core( $custom_infos_args );

        endif; endwhile;
        
        endif;

        do_action( 'bp_after_profile_loop_content' );
		 
		  if(bp_is_my_profile() == true) {
		  		$return = '<div class="yz-widget yz-custom_infos yz_effect yz-white-bg yz-wg-title-icon-bg fadeIn">
				             <div class="yz-widget-main-content">
									<a href="'.bp_loggedin_user_domain().'widgets" class="yz-widget-head">
									  <h2 class="yz-widget-title">
									     <i class="fas fa-id-card"></i>Add Profile Widgets
									  </h2>
									  <i class="far fa-edit yz-edit-widget"></i>
									</a>
								 </div>
							  </div>';
			   echo $return;
		  }
		  // Get Overview Widgets and add them to the bottom of the info page
		  $profile_widgets = yz_options( 'yz_profile_main_widgets' );
		  // Filter 
		  $profile_widgets = apply_filters( 'yz_profile_main_widgets', $profile_widgets );
		  // Get Widget Content.
		  youzer()->widgets->get_widget_content( $profile_widgets );	
    }

}