/* Add your plugin JavaScript here */
jQuery( document ).ready( function( $ ) {

    // Generate content on form submit
    $( '#chatgpt-form' ).on( 'submit', function( event ) {
        event.preventDefault();

        var content = $( '#chatgpt-content' ).val();

        $.ajax( {
            url: chatgpt_ajax_object.ajax_url,
            type: 'post',
            dataType: 'json',
            data: {
                action: 'chatgpt_generate_content',
                content: content,
                nonce: chatgpt_ajax_object.nonce
            },
            beforeSend: function() {
                $( '#chatgpt-output' ).html( '<p>Generating content...</p>' );
            },
            success: function( data ) {
                if ( data.success ) {
                    $( '#chatgpt-output' ).html( '<p>' + data.content + '</p>' );
                } else {
                    $( '#chatgpt-output' ).html( '<p>' + data.error + '</p>' );
                }
            },
            error: function( jqXHR, textStatus, errorThrown ) {
                $( '#chatgpt-output' ).html( '<p>' + errorThrown + '</p>' );
            }
        } );
    } );

} );
