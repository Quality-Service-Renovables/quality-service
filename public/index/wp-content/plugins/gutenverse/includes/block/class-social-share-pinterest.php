<?php
/**
 * Social Share Block class
 *
 * @author Jegstudio
 * @since 1.0.0
 * @package gutenverse\block
 */

namespace Gutenverse\Block;

/**
 * Class Social Share Block
 *
 * @package gutenverse\block
 */
class Social_Share_Pinterest extends Block_Abstract {
	/**
	 * $attributes, $content
	 *
	 * @return string
	 */
	public function render_content() {
		$text       = esc_html( $this->attributes['text'] );
		$share_text = $this->attributes['showText'] ? "<div class='gutenverse-share-text'>{$text}</div>" : '';

		return "<div class='gutenverse-share-icon'>
				<i class='fab fa-pinterest'></i>
			</div>{$share_text}";
	}

	/**
	 * Render view in editor
	 */
	public function render_gutenberg() {
		$content = $this->render_content();

		return "<div class='gutenverse-share-pinterest gutenverse-share-item' id='{$this->get_element_id()}'>
			<a href='#'>
				{$content}
			</a>
		</div>";
	}

	/**
	 * Render view in frontend
	 */
	public function render_frontend() {
		$post_id          = get_the_ID();
		$title            = get_the_title( $post_id );
		$encoded_post_url = gutenverse_encode_url( $post_id );
		$image            = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' );
		$image_url        = $image ? $image[0] : '';
		$share_url        = esc_url( 'https://www.pinterest.com/pin/create/bookmarklet/?pinFave=1&url=' . $encoded_post_url . '&media=' . $image_url . '&description=' . $title );
		$content          = $this->render_content();

		return "<div class='gutenverse-share-pinterest gutenverse-share-item' id='{$this->get_element_id()}'>
			<a target='_blank' href='{$share_url}'>
				{$content}
			</a>
		</div>";
	}
}
