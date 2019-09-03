( function( $ ) {

  'use strict';

  $( document ).ready( function() {

    if ( jQuery().emojioneArea ) {

        $.yz_init_wall_textarea_emojionearea = function( element  ) {
            return element.emojioneArea( {
                pickerPosition: 'bottom',
                autocomplete: true,
                events: {
                ready: function () {
                  this.editor.textcomplete([{
                      id: 'yz_mentions',
                      match: /\B@([\-\d\w]*)$/,
                      search: function ( term, callback ) {
                          var mentions = bp.mentions.users;
                          callback( $.map(mentions, function ( mention ) {
                          return mention.ID.indexOf( term ) === 0 || mention.name.indexOf( term ) === 0 ? mention : null;
                      }));
                      },
                      template: function ( mention ) {
                          return '<img src="' + mention.image + '" /><span class="username">@' + mention.ID + '</span><small>' +mention.name+ '</small>';
                      },
                      replace: function ( mention ) {
                          return '@' + mention.ID + '&nbsp;';
                      },
                      cache: true,
                      index: 1
                   }]);
                }     
              }
            }
          );
        }

        // Activate Emojis in Posts.
        if ( Yz_Emoji.posts_visibility == 'on' ) {
          var el = $.yz_init_wall_textarea_emojionearea( $( '.yz-wall-textarea' ) );
        }

            
        // Activate Emojis in Posts Comments.
      if ( Yz_Emoji.comments_visibility == 'on' ) {

        // Init Comments Emoji Function
        $.yz_init_comments_emoji = function() {
          var yz_emoji_textarea = $( '.youzer .ac-form textarea' ).emojioneArea( {
                pickerPosition: 'bottom',
                autocomplete: true,
                events: {
                ready: function () {
                  this.editor.textcomplete([{
                      id: 'yz_mentions',
                      match: /\B@([\-\d\w]*)$/,
                      search: function ( term, callback ) {
                          var mentions = bp.mentions.users;
                          callback( $.map(mentions, function ( mention ) {
                          return mention.ID.indexOf( term ) === 0 || mention.name.indexOf( term ) === 0 ? mention : null;
                      }));
                      },
                      template: function ( mention ) {
                          return '<img src="' + mention.image + '" /><span class="username">@' + mention.ID + '</span><small>' +mention.name+ '</small>';
                      },
                      replace: function ( mention ) {
                          return '@' + mention.ID + '&nbsp;';
                      },
                      cache: true,
                      index: 1
                   }]);
                },
                keypress: function( editor, e ) {
                    if ( e.which == 13 && !e.shiftKey ) {
                        e.preventDefault();
                        this.trigger( 'change' );
                        $( editor ).closest( 'form' ).find( '.yz-send-comment' ).click();
                    }
                }     
              }
            });
          return yz_emoji_textarea;
        }

        // Init Vars.
        var comment_el = $.yz_init_comments_emoji();

          // Reset Reply Form after submit.
          $( 'body' ).on( 'append','.activity-comments ul', function(e){
            if ( e.target.localName == 'li' || e.target.localName == 'ul' ) {
            
              // Clean Textarea.
              if ( $( this ).parent().find( '.ac-form textarea' ).get(0) ) {
                $( this ).parent().find( '.ac-form textarea' ).get(0).emojioneArea.setText( '' );
              }

            }
          });

          // Reload Emoji Comments After Loading More Posts.
          $( document ).ajaxComplete(function() {
            $.yz_init_comments_emoji();
        });

      }

      // Activate Emojis in Messages.
      if ( Yz_Emoji.messages_visibility == 'on' ) {
        // Enable Emoji.
        var message_el = $( '#send-reply textarea,.yzmsg-form-item #message_content' )
        .emojioneArea( { pickerPosition: 'bottom' } );
        // Override Val Function.
        var originalVal = this.originalVal = $.fn.val;
        $.fn.val = function(value) {
            if ( typeof value == 'undefined' ) {
                return originalVal.call( this );
            } else {
                if ( $( this ).attr( 'id' ) == 'message_content' && value == '' ) {
                  $( '#send-reply .emojionearea-editor' ).text( '' );
                }
                return originalVal.call( this, value );
            }
        };
      }


    }



    /**
     * # Modal.
     */
    $( 'div.activity' ).on( 'click', 'a.acomment-reply' , function( e ) {
        var li = $( this ).closest( 'li.activity-item' ), comment_id = li.attr( 'id' ).substr( 9, li.attr( 'id' ).length );
        setTimeout(function(){
            $( '#ac-form-' + comment_id ).find( '.emojionearea-editor' ).focus();
        }, 200);
    });

  });

})( jQuery );