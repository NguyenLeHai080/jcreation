<?php
/**
 * Creates Flatsome UX Blocks for the Jcreation homepage.
 *
 * Flatsome UX Builder stores layouts as shortcode data internally. These
 * templates are generated as UX Builder data, not as hand-authored page copy.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class JCreation_UX_Blocks {
	const CATEGORY = 'Jcreation';

	public static function create( $assets ) {
		self::ensure_category();

		$blocks = array(
			'block-home-top-links' => array(
				'title'   => 'Jcreation - Home Top Links',
				'content' => self::top_links(),
			),
			'block-home-hero' => array(
				'title'   => 'Jcreation - Home Hero Slider',
				'content' => self::hero_slider( $assets ),
			),
			'block-home-quick-links' => array(
				'title'   => 'Jcreation - Catalogue Video Portfolio',
				'content' => self::quick_links(),
			),
			'block-home-products' => array(
				'title'   => 'Jcreation - Products',
				'content' => self::products(),
			),
			'block-home-community' => array(
				'title'   => 'Jcreation - Notice and R&D',
				'content' => self::community(),
			),
			'block-home-footer-info' => array(
				'title'   => 'Jcreation - Footer Information',
				'content' => self::footer_info(),
			),
		);

		foreach ( $blocks as $slug => $block ) {
			self::upsert_block( $slug, $block['title'], $block['content'] );
		}

		return array_keys( $blocks );
	}

	public static function home_page_content( $block_slugs ) {
		$content = '';

		foreach ( $block_slugs as $slug ) {
			$content .= sprintf( '[block id="%s"]', esc_attr( $slug ) ) . "\n\n";
		}

		return trim( $content );
	}

	private static function ensure_category() {
		if ( ! taxonomy_exists( 'block_categories' ) ) {
			return;
		}

		if ( ! term_exists( self::CATEGORY, 'block_categories' ) ) {
			wp_insert_term( self::CATEGORY, 'block_categories', array( 'slug' => 'jcreation' ) );
		}
	}

	private static function upsert_block( $slug, $title, $content ) {
		$content = self::resolve_asset_placeholders( $content );

		$existing = get_page_by_path( $slug, OBJECT, 'blocks' );
		$args     = array(
			'post_title'   => $title,
			'post_name'    => $slug,
			'post_content' => $content,
			'post_status'  => 'publish',
			'post_type'    => 'blocks',
		);

		if ( $existing ) {
			$args['ID'] = $existing->ID;
			$post_id    = wp_update_post( $args, true );
		} else {
			$post_id = wp_insert_post( $args, true );
		}

		if ( is_wp_error( $post_id ) ) {
			return;
		}

		if ( taxonomy_exists( 'block_categories' ) ) {
			wp_set_object_terms( $post_id, 'jcreation', 'block_categories', false );
		}
	}

	private static function resolve_asset_placeholders( $content ) {
		return preg_replace_callback(
			'/jcreation_asset:([a-z0-9_]+)/',
			function ( $matches ) {
				$attachment_id = self::asset_id( $matches[1] );

				return $attachment_id ? (string) $attachment_id : '';
			},
			$content
		);
	}

	private static function asset_id( $key ) {
		$existing = get_posts(
			array(
				'post_type'      => 'attachment',
				'post_status'    => 'inherit',
				'posts_per_page' => 1,
				'meta_key'       => '_jcreation_source_asset_key',
				'meta_value'     => $key,
				'fields'         => 'ids',
			)
		);

		return ! empty( $existing ) ? (int) $existing[0] : 0;
	}

	private static function top_links() {
		return <<<'HTML'
[section label="Top links" class="jcreation-top-links" padding="8px" bg_color="rgb(43, 151, 216)" dark="true"]
	[row h_align="right" style="collapse"]
		[col span="12" span__sm="12" align="right"]
			<p><a href="/">Home</a>&nbsp;&nbsp;&nbsp;<a href="http://gwx.bizmeka.com/LoginC.aspx?compid=jcreation">Group Ware</a></p>
		[/col]
	[/row]
[/section]
HTML;
	}

	private static function hero_slider( $assets ) {
		$slides = '';

		foreach ( array( 'hero_1', 'hero_2', 'hero_3', 'hero_4', 'hero_5' ) as $key ) {
			$slides .= sprintf(
				'[ux_banner label="Main visual" class="jcreation-hero-banner" height="640px" bg="%1$s" bg_overlay="rgba(0, 0, 0, 0.58)" parallax="0" bg_pos="50%% 50%%"]
					[text_box class="jcreation-hero-copy" width="42" width__sm="86" position_x="73" position_y="50" text_align="center" text_color="light" animate="fadeInRight"]
						<h3>Leader of Core Technology</h3>
						<h1><strong><em>JIG &amp; CREATION</em></strong></h1>
						<p>We are Leader of Car JIG &amp; CREATION Parts.<br>If you need high technology of Jig &amp; Creation, Join us.</p>
					[/text_box]
				[/ux_banner]',
				'jcreation_asset:' . $key
			);
		}

		return '[ux_slider label="Jcreation main slider" class="jcreation-main-slider" type="fade" nav_style="simple" nav_color="light" bullets="false" auto_slide="true" timer="4500"]' . $slides . '[/ux_slider]';
	}

	private static function quick_links() {
		return <<<'HTML'
[section label="Catalogue Video Portfolio" class="jcreation-quick-links" padding="50px"]
	[row label="Quick link cards" class="jcreation-quick-links-row" style="large" col_style="divided"]
		[col span="4" span__sm="12"]
			[ux_image_box class="jcreation-quick-card" img="jcreation_asset:catalogue" image_height="42%" image_hover="zoom" link="/catalog/" text_align="left"]
				<h3>カタログ</h3>
				<p><span>Catalogue</span></p>
				<p>(株) J&amp;Cに関するカタログ情報です。</p>
				<p>もっと見る</p>
			[/ux_image_box]
		[/col]
		[col span="4" span__sm="12"]
			[ux_image_box class="jcreation-quick-card" img="jcreation_asset:video" image_height="42%" image_hover="zoom" link="/video/" text_align="left"]
				<h3>広報動画</h3>
				<p><span>Video</span></p>
				<p>(株) J&amp;Cの会社紹介及び自動車車体溶接用ジグの生産設備に関する動画情報です。</p>
				<p>もっと見る</p>
			[/ux_image_box]
		[/col]
		[col span="4" span__sm="12"]
			[ux_image_box class="jcreation-quick-card" img="jcreation_asset:portfolio" image_height="42%" image_hover="zoom" link="/san-pham/" text_align="left"]
				<h3>生産製品ポートフォリオ</h3>
				<p><span>Product Portfolio</span></p>
				<p>(株) J&amp;Cの生産製品の写真です。</p>
				<p>もっと見る</p>
			[/ux_image_box]
		[/col]
	[/row]
[/section]
HTML;
	}

	private static function products() {
		return <<<'HTML'
[section label="Products" class="jcreation-products" padding="30px"]
	[row class="jcreation-products-row" style="large" v_align="middle"]
		[col span="4" span__sm="12"]
			<h2>製品紹介</h2>
			<h3><em>Products</em></h3>
			<p>(株) J&amp;Cは統合システム能力はもちろん、品質最優先、納期、価格競争力で顧客が満足できるよう最善の努力を尽くしています。</p>
			<ul>
				<li><a href="/san-pham/">生産製品</a></li>
				<li><a href="/san-pham/">生産工程</a></li>
			</ul>
		[/col]
		[col span="4" span__sm="12"]
			[ux_image_box class="jcreation-product-overlay" img="jcreation_asset:product_1" style="shade" image_height="124%" image_hover="zoom" text_pos="middle" text_color="light" link="/san-pham/"]
				<h2>生産製品</h2>
				<h3><em>Products</em></h3>
			[/ux_image_box]
		[/col]
		[col span="4" span__sm="12"]
			[ux_image img="jcreation_asset:product_2"]
		[/col]
	[/row]
[/section]
HTML;
	}

	private static function community() {
		return <<<'HTML'
[section label="Notice and R&D" class="jcreation-community" padding="30px 30px 60px 30px"]
	[row class="jcreation-community-row" style="large"]
		[col span="6" span__sm="12"]
			[ux_image_box class="jcreation-bottom-banner" img="jcreation_asset:notice" style="shade" image_height="52%" image_hover="zoom" text_pos="middle" text_color="light" link="/tin-tuc/"]
				<h2>お知らせ事項</h2>
			[/ux_image_box]
		[/col]
		[col span="6" span__sm="12"]
			[ux_image_box class="jcreation-bottom-banner" img="jcreation_asset:rnd" style="shade" image_height="52%" image_hover="zoom" text_pos="middle" text_color="light" link="/ve-chung-toi/"]
				<h2>R&amp;D 技術研究所</h2>
			[/ux_image_box]
		[/col]
	[/row]
[/section]
HTML;
	}

	private static function footer_info() {
		return <<<'HTML'
[section label="Footer information" class="jcreation-footer-info" padding="35px" bg_color="rgb(31, 31, 31)" dark="true"]
	[row class="jcreation-footer-row" v_align="middle"]
		[col span="6" span__sm="12" align="center"]
			[ux_image img="jcreation_asset:footer_logo" image_size="original" width="48"]
		[/col]
		[col span="6" span__sm="12"]
			<p>商号: (株) J &amp; C　代表理事: 裵于培</p>
			<p>住所: 韓国 京畿道 華城市 南陽面 善洞山丹2道81</p>
			<p>Tel. +82-31-366-9426 Fax. +82-31-355-9094</p>
			<p>Copyright © J&amp;C All Rights Reserved</p>
		[/col]
	[/row]
[/section]
HTML;
	}
}
