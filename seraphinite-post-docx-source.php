<?php
/*
Plugin Name: Seraphinite Post .DOCX Source
Plugin URI: http://wordpress.org/plugins/seraphinite-post-docx-source
Description: Allows using marked up .DOCX documents as a source for SEO oriented web content instead of manual copy.
Version: 1.1.4
Author: Seraphinite Solutions
Author URI: https://s-sols.com/
License: GPLv2 or later
*/

add_action( 'add_meta_boxes',         'sersoft_pds_add_post_meta_box' );
add_action( 'admin_footer',           'sersoft_pds_load_javascript' );
add_action( 'admin_enqueue_scripts',  'sersoft_pds_admin_style' );

function sersoft_pds_add_post_meta_box()
{
    $post_types = get_post_types();
    
    foreach( $post_types as $post_type )
    {
        if( post_type_supports( $post_type, 'editor' ) )
        {
            add_meta_box(
                'sersoft_pds_add_post',
                __( '.DOCX Source' ),
                'sersoft_pds_render_editor_box',
                $post_type,
                'normal',
                'high'
            );
        }
    }
}

function sersoft_pds_admin_style()
{
    wp_enqueue_style( 'sersoft-pds-style', plugins_url( 'seraphinite-post-docx-source/style.css' ) );
}

function sersoft_pds_get_post_images_url( $postFrom )
{
    $site_url = site_url();

    if( has_post_thumbnail( $postFrom -> ID ) )
    {
        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $postFrom -> ID ), 'single-post-thumbnail' );
        $post_img_dir = dirname( $image[ 0 ] );
    }
    else
    {
	      global $post, $post_id;

        $post_prev = $post; $post = null;
        $post_id_prev = $post_id; $post_id = $postFrom -> ID;

        $file = array(
            'name' => "dummy.jpg",
		        'ext'  => "jpg",
		        'type' => "jpg" );
        $file = apply_filters( 'wp_handle_upload_prefilter', $file );
  
        $wp_upload_dir_res = wp_upload_dir( null, false );
        $post_img_dir = $wp_upload_dir_res[ 'url' ];

        $fileinfo = array(
            'file' => $file[ 'name' ],
		        'url'  => $post_img_dir . "/" . $file[ 'name' ],
		        'type' => $file[ 'type' ] );
        $fileinfo = apply_filters( 'wp_handle_upload', $fileinfo, 'upload' );

        $post = $post_prev;
        $post_id = $post_id_prev;
    }
  
    if( strpos( $post_img_dir, $site_url ) === 0 )
        $post_img_dir = substr( $post_img_dir, strlen( $site_url ), strlen( $post_img_dir ) - strlen( $site_url ) );

    return $post_img_dir;
}

function sersoft_pds_post_is_new( $post )
{
  return empty( $post -> post_title );
}

function sersoft_pds_render_editor_box( $post )
{
  $post_is_new = sersoft_pds_post_is_new( $post );
    ?>
    <div id="sersoft_pds_docx_source" class="status-empty">
        <input type="hidden" id="sersoft_pds_docx_upload-image-nonce" value="<?php echo wp_create_nonce( "media-form" ); ?>" />
        <input type="hidden" id="sersoft_pds_docx_upload-image-request-url" value="<?php echo get_site_url( null, "wp-admin/async-upload.php", "admin" ); ?>" />
        <input type="hidden" id="sersoft_pds_docx_upload-post-type" value="<?php echo $post -> post_type; ?>" />
            
        <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
            <tbody>
                <tr>
                    <td style="width: 12em;">
                        <div style="margin-right: 2em;">Source file:</div>
                    </td>
                    <td>
                        <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                            <tbody>
                                <tr>
                                    <td style="width: 1px;">
                                        <input style="display: none;" type="file" id="sersoft_pds_docx_upload" onchange="sersoft_pds_docx_filename.value = sersoft_pds_docx_upload.files[ 0 ].name;" />
                                        <input type="button" class="button" style="margin-right: 0.3em;" value="Browse..." onclick="sersoft_pds_docx_upload.click();" />
                                    </td>
                                    <td>
                                        <input style="width: 100%" id="sersoft_pds_docx_filename" type="text" readonly="true" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                
                <tr><td colspan="2"><p></p></td></tr>
                
                <tr>
                    <td style="vertical-align: top;">
                        <div style="margin-right: 2em;">Non-existent internal hyperlinks:</div>
                    </td>
                    <td>
                        <table border="0" cellpadding="0" cellspacing="0"><tbody>
                            <tr>
                                <td style="vertical-align: top;">
                                    <div style="margin-right: 2em;">
                                        <label><input type="radio" name="notexist-internal-links-action" id="sersoft_pds_docx_notexist-internal-links-action-underline" checked="checked"/>Underline</label>
                                        <label><input type="radio" name="notexist-internal-links-action" id="sersoft_pds_docx_notexist-internal-links-action-del"/>Remove</label>
                                    </div>
                                </td>
                                <td style="vertical-align: top;">
                                    <div style="margin-right: 2em;">
                                        <label><input type="radio" name="notexist-internal-links-action" id="sersoft_pds_docx_notexist-internal-links-action-check"/>Check only</label>
                                        <label><input type="radio" name="notexist-internal-links-action" id="sersoft_pds_docx_notexist-internal-links-action-no"/>Don't check</label>
                                    </div>
                                </td>
                            </tr>
                        </tbody></table>
                      </td>
                </tr>

                <tr><td colspan="2"><p></p></td></tr>
              
                <tr>
                    <td style="vertical-align: top;">
                        <div style="margin-right: 2em;">Meta:</div>
                    </td>
                    <td>
                        <table border="0" cellpadding="0" cellspacing="0"><tbody>
                            <tr>
                                <td style="vertical-align: top;" width="33%">
                                    <div style="margin-right: 2em;">
                                        <label><input type="checkbox" id="sersoft_pds_docx_useHeader1AsTitle" checked="checked"/>Use 'Header1' as title</label>
                                        <label><input type="checkbox" id="sersoft_pds_docx_replaceTags" checked="checked"/>Use tags</label>
                                        <label><input type="checkbox" id="sersoft_pds_docx_replaceCategories" checked="checked"/>Use categories</label>
                                    </div>
                                </td>
                                
                                <td style="vertical-align: top;" width="33%">
                                    <div style="margin-right: 2em;">
                                        <label><input type="checkbox" id="sersoft_pds_docx_replaceSeoTitle" checked="checked"/>Use 'Title' as SEO title</label>
                                        <label><input type="checkbox" id="sersoft_pds_docx_replaceSeoDescription" checked="checked"/>Use 'Comments' as <a id="sersoft_pds_docx_replaceSeoDescriptionMode" onclick="sersoftPdsDocxReplaceSeoDescriptionModeUpdateText( true ); return false;"></a></label>
                                        <input style="display: none;" type="checkbox" id="sersoft_pds_docx_replaceSeoDescription_AsExcerpt" <?php if( $post -> post_type === "product" ) echo "checked"; ?> />
                                        <script>
                                            function sersoftPdsDocxReplaceSeoDescriptionModeUpdateText( iterate = false )
                                            {
                                                var ctl = document.getElementById( "sersoft_pds_docx_replaceSeoDescription_AsExcerpt" );
                                                if( iterate )
                                                    ctl.checked = !ctl.checked;
                                                document.getElementById( "sersoft_pds_docx_replaceSeoDescriptionMode" ).text = ctl.checked ? "excerpt" : "SEO description";
                                            }
                                            sersoftPdsDocxReplaceSeoDescriptionModeUpdateText();
                                        </script>
                                    </div>
                                </td>
                                
                                <td style="vertical-align: top;">
                                    <div style="margin-right: 2em;">
                                        <label><input type="checkbox" id="sersoft_pds_docx_useOtherHeader1AsSeparateTextBlocks" checked="checked"/>Use content under other 'Header1's for additional text block(s)</label>
                                    </div>
                                </td>
                            </tr>
                            
                        </tbody></table>
                    </td>
                </tr>
                <tr>
                    <td style="width: auto;">
                    </td>
                    <td>
                        <span class="howto">Document content for additional <span id="sersoft_pds_docx_useOtherHeader1AsSeparateTextBlocksText"></span>text block(s) must begin with bookmarked 'Header1' with the same identificator(s).</span>
                    </td>
                </tr>
                
                <tr><td colspan="2"><p></p></td></tr>
              
                <tr>
                    <td style="vertical-align: top;">
                        <div style="margin-right: 2em;">Media:</div>
                    </td>
                    <td>
                        <label><input type="checkbox" id="sersoft_pds_docx_upload-media" <?php if( !$post_is_new ) echo "checked"; ?> />Upload</label>
                        <label><input type="checkbox" id="sersoft_pds_docx_upload-image-check-url" <?php if( !$post_is_new ) echo "checked"; ?> />Check final URLs</label>
                    </td>
                </tr>

              	<?php if( $post_is_new ) : ?>
                <tr>
                    <td style="width: auto;">
                    </td>
                    <td>
                        <span class="howto"><strong>Warning!</strong> To preserve post's media final URLs in a right way we don't recommend to upload any images until save new post at first time.</span>
                    </td>
                </tr>
              	<?php endif; ?>
              
                <tr style="display: none;">
                    <td style="width: auto;">
                        <div style="margin-right: 2em;">External media files:</div>
                    </td>
                    <td>
                        <input type="file" id="sersoft_pds_docx_upload-external-media-files-helper" multiple></input>
                    </td>
                </tr>
                <tr>
                    <td style="width: auto;">
                        <div style="margin-right: 2em;">Media URL base:</div>
                    </td>
                    <td>
                        <input id="sersoft_pds_docx_post-media-url" type="text" value="<?php echo sersoft_pds_get_post_images_url( $post ); ?>" />
                    </td>
                </tr>
                <tr>
                    <td style="width: auto;">
                    </td>
                    <td>
                        <span class="howto">URLs of not uploaded medias will be generated according to 'Media URL base'. Only embeded document's media can be uploaded due to browser's security limitations.</span>
                    </td>
                </tr>
            </tbody>
        </table>
                
        <p>
            <input type="button" class="button" id="sersoft_pds_docx_reload" value="Update" />
            <span id="sersoft_pds_docx_loading" class="spinner"></span>
        </p>

        <div>
            <strong>Log:</strong>
            <textarea id="sersoft_pds_docx_messages" readonly="true"></textarea>
        </div>
    </div>
<?php
}

function sersoft_pds_load_javascript()
{
    sersoft_pds_load_script( 'editor' );
}

function sersoft_pds_load_script( $name )
{
    $url = plugins_url( 'seraphinite-post-docx-source/' . $name . '.js' );
    echo '<script src="'. $url . '"></script>';
}
