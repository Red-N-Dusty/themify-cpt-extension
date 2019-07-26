<?php
if (class_exists('Themify')) {
    class ThemifyCPT extends Themify{

        /** Default sidebar layout
         *
         * @var string
         */
        public $cpt;
        private $cptPrefix;
        private $cpt_archive;

        function __construct($cpt=null) {

            parent::__construct();

            ///////////////////////////////////////////
            //Global options setup
            ///////////////////////////////////////////

            $this->cptPrefix = '_'.$cpt;
            $this->cpt = $cpt;
            if (is_archive()){
                $this->cpt_archive = '_archive';
            }
            
            $this->layout = themify_get( 'setting-default'.$this->cpt_archive.$this->cptPrefix.'_layout', 'sidebar1' );
            $this->post_layout = themify_get( 'setting-default'.$this->cpt_archive.$this->cptPrefix.'_post_layout', 'list-post' );
            
            if (is_archive()){
            		
                $this->page_title = themify_get( 'setting-hide_page_title' );
                $this->hide_title = themify_get( 'setting-default'.$this->cpt_archive.$this->cptPrefix.'_post_title' );
                $this->unlink_title = themify_get( 'setting-default'.$this->cpt_archive.$this->cptPrefix.'_unlink_post_title' );
                $this->media_position = themify_get( 'setting-default'.$this->cpt_archive.$this->cptPrefix.'_media_position', 'above' );
                $this->hide_image = themify_get( 'setting-default'.$this->cpt_archive.$this->cptPrefix.'_post_image' );
                $this->unlink_image = themify_get( 'setting-default'.$this->cpt_archive.$this->cptPrefix.'_unlink_post_image' );
                $this->auto_featured_image = ! themify_check( 'setting-auto_featured_image' ) ? 'field_name=post_image, image, wp_thumb&' : '';
                $this->hide_page_image = themify_get( 'setting-hide_page_image' ) == 'yes' ? 'yes' : 'no';
                $this->image_page_single_width = themify_get( 'setting-page_featured_image_width', $this->page_image_width );
                $this->image_page_single_height = themify_get( 'setting-page_featured_image_height', 0 );

                $this->hide_meta = themify_get( 'setting-default'.$this->cpt_archive.$this->cptPrefix.'_post_meta' );
                $this->hide_meta_author = themify_get( 'setting-default'.$this->cpt_archive.$this->cptPrefix.'_post_meta_author' );
                $this->hide_meta_category = themify_get( 'setting-default'.$this->cpt_archive.$this->cptPrefix.'_post_meta_category' );
                $this->hide_meta_comment = themify_get( 'setting-default'.$this->cpt_archive.$this->cptPrefix.'_post_meta_comment' );
                $this->hide_meta_tag = themify_get( 'setting-default'.$this->cpt_archive.$this->cptPrefix.'_post_meta_tag' );

                $this->hide_date = themify_get( 'setting-default'.$this->cpt_archive.$this->cptPrefix.'_post_date' );
                $this->inline_date = $this->hide_date == 'yes' ? false : themify_get( 'setting-default'.$this->cptPrefix.'_page_display_date_inline' );

                // Set Order & Order By parameters for post sorting

                $this->query_post_type = $cpt;
                $this->query_category = '';
                $this->query_taxonomy = '';

                $this->display_content = themify_get( 'setting-default'.$this->cpt_archive.$this->cpt.'_layout_display', 'none' );
                $this->excerpt_length = themify_get( 'setting-default'.$this->cpt_archive.$this->cpt.'_excerpt_length' );
                $this->avatar_size = apply_filters( 'themify_author_box_avatar_size', $this->avatar_size );
                
            }elseif(is_single()){
                $this->cpt_archive = '';
                
                //$this->post_layout_type = themify_get( 'setting-default'.$this->cptPrefix.'_post_layout_type' );
                $this->post_layout_type = themify_get('post_layout');
                if (!$this->post_layout_type || $this->post_layout_type === 'default') {
                    $this->post_layout_type = themify_get( 'setting-default'.$this->cptPrefix.'_post_layout_type' );
                }
                $this->hide_title = ( themify_get( 'hide_post_title' ) != 'default' && themify_check( 'hide_post_title' ) ) ? themify_get( 'hide_post_title' ) : themify_get( 'setting-default'.$this->cpt_archive.$this->cptPrefix.'_post_title' );
                $this->unlink_title = ( themify_get( 'unlink_post_title' ) != 'default' && themify_check( 'unlink_post_title' ) ) ? themify_get( 'unlink_post_title' ) : themify_get( 'setting-default'.$this->cpt_archive.$this->cptPrefix.'_unlink_post_title' );
                $this->hide_date = ( themify_get( 'hide_post_date' ) != 'default' && themify_check( 'hide_post_date' ) ) ? themify_get( 'hide_post_date' ) : themify_get( 'setting-default'.$this->cpt_archive.$this->cptPrefix.'_post_date' );
                if($this->hide_date!='yes'){
                    $this->inline_date = themify_get( 'setting-default'.$this->cptPrefix.'_page_display_date_inline' );
                }
                $this->hide_image = ( themify_get( 'hide_post_image' ) != 'default' && themify_check( 'hide_post_image' ) ) ? themify_get( 'hide_post_image' ) : themify_get( 'setting-default'.$this->cpt_archive.$this->cptPrefix.'_post_image' );
                $this->unlink_image = ( themify_get( 'unlink_post_image' ) != 'default' && themify_check( 'unlink_post_image' ) ) ? themify_get( 'unlink_post_image' ) : themify_get( 'setting-default'.$this->cpt_archive.$this->cptPrefix.'_unlink_post_image' );
                $this->media_position = themify_get( 'setting-default'.$this->cpt_archive.$this->cptPrefix.'_media_position', 'above' );
                // Post Meta Values ///////////////////////
                $post_meta_keys = array(
                    '_author'   => 'post_meta_author',
                    '_category' => 'post_meta_category',
                    '_comment'  => 'post_meta_comment',
                    '_tag'      => 'post_meta_tag'
                );

                $post_meta_key = 'setting-default'.$this->cpt_archive.$this->cptPrefix.'_';
                $this->hide_meta = themify_check( 'hide_meta_all' ) ? themify_get( 'hide_meta_all' ) : themify_get( $post_meta_key . 'post_meta' );
                foreach ( $post_meta_keys as $k => $v ) {
                    $this->{'hide_meta' . $k} = themify_check( 'hide_meta' . $k ) ? themify_get( 'hide_meta' . $k ) : themify_get( $post_meta_key . $v );
                }
                if($this->post_layout_type !== 'split'){
                    $sidebar_mode = array('sidebar-none', 'sidebar1','sidebar1 sidebar-left', 'sidebar2', 'sidebar2 content-left', 'sidebar2 content-right');
                    $this->layout = in_array( themify_get( 'layout' ), $sidebar_mode )  ? themify_get( 'layout' ) : themify_get( 'setting-default'.$this->cptPrefix.'_post_layout' );
                    // set default layout
                    if ( $this->layout == '' ) {
                        $this->layout = 'sidebar1';
                    }
                }elseif($this->post_layout_type === 'split'){
                    $this->layout = 'sidebar-none';
                }
            }

            //$this->posts_per_page = get_option( 'posts_per_page' );

        }
    }
}