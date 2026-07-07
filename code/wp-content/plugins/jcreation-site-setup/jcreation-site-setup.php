<?php
/**
 * Plugin Name: Jcreation Site Setup
 * Description: Creates the Jcreation starter pages, menu, categories, and sample SEO content without custom CSS or layout shortcodes.
 * Version: 1.0.0
 * Author: Codihaus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'JCreation_Site_Setup', false ) ) {
	return;
}

final class JCreation_Site_Setup {
	const VERSION = '1.1.0';

	public static function init() {
		add_action( 'admin_menu', array( __CLASS__, 'register_admin_page' ) );
		add_action( 'admin_post_jcreation_run_site_setup', array( __CLASS__, 'handle_manual_setup' ) );
	}

	public static function activate() {
		self::run();
	}

	public static function register_admin_page() {
		add_management_page(
			'Jcreation Site Setup',
			'Jcreation Site Setup',
			'manage_options',
			'jcreation-site-setup',
			array( __CLASS__, 'render_admin_page' )
		);
	}

	public static function render_admin_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$ran = isset( $_GET['jcreation_setup'] ) && 'done' === $_GET['jcreation_setup'];
		?>
		<div class="wrap">
			<h1>Jcreation Site Setup</h1>
			<?php if ( $ran ) : ?>
				<div class="notice notice-success is-dismissible">
					<p>Jcreation site structure has been created or updated.</p>
				</div>
			<?php endif; ?>
			<p>This setup creates the required pages, menu, categories, sample posts, and front-page settings. It does not add custom CSS and does not create layout shortcodes.</p>
			<p>After running this setup, open each page with Flatsome UX Builder and refine the visual layout by dragging sections/elements according to <code>docs/jcreation-ux-builder-build-checklist.md</code>.</p>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<?php wp_nonce_field( 'jcreation_run_site_setup' ); ?>
				<input type="hidden" name="action" value="jcreation_run_site_setup">
				<?php submit_button( 'Run Jcreation setup' ); ?>
			</form>
		</div>
		<?php
	}

	public static function handle_manual_setup() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have permission to run this setup.', 'jcreation-site-setup' ) );
		}

		check_admin_referer( 'jcreation_run_site_setup' );
		self::run();

		wp_safe_redirect( admin_url( 'tools.php?page=jcreation-site-setup&jcreation_setup=done' ) );
		exit;
	}

	public static function run() {
		$categories = self::create_categories();
		$pages      = self::create_pages();

		self::create_menu( $pages );
		self::create_sample_posts( $categories );
		self::apply_theme_settings( $pages );

		update_option( 'jcreation_site_setup_version', self::VERSION );
	}

	private static function create_categories() {
		$categories = array(
			'tin-tuc'  => 'Tin tức',
			'san-pham' => 'Sản phẩm',
		);

		$ids = array();

		foreach ( $categories as $slug => $name ) {
			$term = term_exists( $slug, 'category' );

			if ( ! $term ) {
				$term = wp_insert_term(
					$name,
					'category',
					array(
						'slug' => $slug,
					)
				);
			}

			if ( ! is_wp_error( $term ) ) {
				$ids[ $slug ] = (int) $term['term_id'];
			}
		}

		return $ids;
	}

	private static function create_pages() {
		$assets = self::import_source_assets();

		$definitions = array(
			'trang-chu'           => array(
				'title'       => 'Trang chủ',
				'menu_order'  => 1,
				'description' => 'Jcreation cung cấp giải pháp JIG & CREATION, sản phẩm sản xuất, catalogue, video, portfolio và R&D.',
				'content'     => self::home_content( $assets ),
			),
			've-chung-toi'        => array(
				'title'       => 'Về chúng tôi',
				'menu_order'  => 2,
				'description' => 'Giới thiệu Jcreation, năng lực công nghệ, tầm nhìn và giá trị trong lĩnh vực sản xuất công nghiệp.',
				'content'     => self::about_content(),
			),
			'san-pham'            => array(
				'title'       => 'Sản phẩm',
				'menu_order'  => 3,
				'description' => 'Danh mục sản phẩm và giải pháp jig, fixture, automation, cơ khí chính xác của Jcreation.',
				'content'     => self::products_content( $assets ),
			),
			'doi-tac'             => array(
				'title'       => 'Đối tác thương mại',
				'menu_order'  => 4,
				'description' => 'Mạng lưới đối tác thương mại, công nghệ, sản xuất và dự án của Jcreation.',
				'content'     => self::partners_content(),
			),
			'dich-vu-khach-hang'  => array(
				'title'       => 'Dịch vụ khách hàng',
				'menu_order'  => 5,
				'description' => 'Liên hệ Jcreation để được tư vấn giải pháp jig, automation và sản xuất công nghiệp.',
				'content'     => self::customer_service_content(),
			),
			'tin-tuc'             => array(
				'title'       => 'Tin tức',
				'menu_order'  => 6,
				'description' => 'Tin tức, cập nhật dự án và kiến thức sản xuất từ Jcreation.',
				'content'     => self::news_page_content(),
			),
		);

		$pages = array();

		foreach ( $definitions as $slug => $definition ) {
			$page_id = self::upsert_page(
				$definition['title'],
				$slug,
				$definition['content'],
				$definition['menu_order'],
				$definition['description']
			);

			if ( $page_id ) {
				$pages[ $slug ] = $page_id;
			}
		}

		return $pages;
	}

	private static function upsert_page( $title, $slug, $content, $menu_order, $description ) {
		$existing = get_page_by_path( $slug, OBJECT, 'page' );
		$args     = array(
			'post_title'   => $title,
			'post_name'    => $slug,
			'post_content' => $content,
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'menu_order'   => $menu_order,
		);

		if ( $existing ) {
			$args['ID'] = $existing->ID;
			$page_id    = wp_update_post( $args, true );
		} else {
			$page_id = wp_insert_post( $args, true );
		}

		if ( is_wp_error( $page_id ) ) {
			return 0;
		}

		update_post_meta( $page_id, '_wp_page_template', 'page-blank.php' );
		update_post_meta( $page_id, '_yoast_wpseo_metadesc', $description );
		update_post_meta( $page_id, 'rank_math_description', $description );

		return (int) $page_id;
	}

	private static function create_menu( $pages ) {
		$menu_name = 'Main Menu';
		$menu      = wp_get_nav_menu_object( $menu_name );

		if ( ! $menu ) {
			$menu_id = wp_create_nav_menu( $menu_name );
		} else {
			$menu_id = $menu->term_id;
		}

		if ( is_wp_error( $menu_id ) ) {
			return;
		}

		$items = wp_get_nav_menu_items( $menu_id );
		if ( $items ) {
			foreach ( $items as $item ) {
				wp_delete_post( $item->ID, true );
			}
		}

		$menu_items = array(
			'trang-chu'          => 'Home',
			've-chung-toi'       => '会社紹介',
			'san-pham'           => '製品紹介',
			'doi-tac'            => '主要取引先',
			'dich-vu-khach-hang' => 'コミュニティ',
		);

		$order = 1;
		foreach ( $menu_items as $slug => $label ) {
			if ( empty( $pages[ $slug ] ) ) {
				continue;
			}

			wp_update_nav_menu_item(
				$menu_id,
				0,
				array(
					'menu-item-object-id' => $pages[ $slug ],
					'menu-item-object'    => 'page',
					'menu-item-type'      => 'post_type',
					'menu-item-title'     => $label,
					'menu-item-status'    => 'publish',
					'menu-item-position'  => $order,
				)
			);

			$order++;
		}

		$locations                    = get_theme_mod( 'nav_menu_locations', array() );
		$locations['primary']         = $menu_id;
		$locations['primary_mobile']  = $menu_id;
		$locations['footer']          = $menu_id;
		set_theme_mod( 'nav_menu_locations', $locations );
	}

	private static function create_sample_posts( $categories ) {
		$news_category    = isset( $categories['tin-tuc'] ) ? $categories['tin-tuc'] : 0;
		$product_category = isset( $categories['san-pham'] ) ? $categories['san-pham'] : 0;

		$posts = array(
			array(
				'title'       => 'Năng lực thiết kế jig và fixture theo yêu cầu',
				'slug'        => 'nang-luc-thiet-ke-jig-va-fixture',
				'category'    => $product_category,
				'excerpt'     => 'Jcreation phát triển jig và fixture theo yêu cầu sản xuất, tối ưu độ ổn định và độ chính xác.',
				'description' => 'Giới thiệu năng lực thiết kế jig và fixture theo yêu cầu của Jcreation.',
				'content'     => self::sample_product_post_content( 'Jig và Fixture' ),
			),
			array(
				'title'       => 'Giải pháp automation cho dây chuyền sản xuất',
				'slug'        => 'giai-phap-automation-cho-day-chuyen-san-xuat',
				'category'    => $product_category,
				'excerpt'     => 'Các giải pháp automation giúp tăng tính ổn định, giảm thao tác thủ công và nâng cao năng suất.',
				'description' => 'Giải pháp automation cho dây chuyền sản xuất công nghiệp.',
				'content'     => self::sample_product_post_content( 'Automation Equipment' ),
			),
			array(
				'title'       => 'Quy trình tiếp nhận và tư vấn dự án tại Jcreation',
				'slug'        => 'quy-trinh-tu-van-du-an-tai-jcreation',
				'category'    => $news_category,
				'excerpt'     => 'Quy trình tư vấn gồm tiếp nhận yêu cầu, phân tích nhu cầu, đề xuất giải pháp và triển khai.',
				'description' => 'Quy trình tư vấn dự án jig, automation và sản xuất công nghiệp tại Jcreation.',
				'content'     => self::sample_news_post_content(),
			),
		);

		foreach ( $posts as $post ) {
			self::upsert_post( $post );
		}
	}

	private static function upsert_post( $definition ) {
		$existing = get_page_by_path( $definition['slug'], OBJECT, 'post' );
		$args     = array(
			'post_title'    => $definition['title'],
			'post_name'     => $definition['slug'],
			'post_content'  => $definition['content'],
			'post_excerpt'  => $definition['excerpt'],
			'post_status'   => 'publish',
			'post_type'     => 'post',
			'post_category' => array_filter( array( (int) $definition['category'] ) ),
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

		update_post_meta( $post_id, '_yoast_wpseo_metadesc', $definition['description'] );
		update_post_meta( $post_id, 'rank_math_description', $definition['description'] );
	}

	private static function apply_theme_settings( $pages ) {
		if ( ! empty( $pages['trang-chu'] ) ) {
			update_option( 'show_on_front', 'page' );
			update_option( 'page_on_front', $pages['trang-chu'] );
		}

		if ( ! empty( $pages['tin-tuc'] ) ) {
			update_option( 'page_for_posts', $pages['tin-tuc'] );
		}

		set_theme_mod( 'color_primary', '#2697d8' );
	}

	private static function import_source_assets() {
		$assets = array(
			'hero_1'      => 'https://jcreation.co.kr/wp-content/uploads/2017/04/jnc_mainslider1.jpg',
			'hero_2'      => 'https://jcreation.co.kr/wp-content/uploads/2017/04/jnc_mainslider2.jpg',
			'hero_3'      => 'https://jcreation.co.kr/wp-content/uploads/2017/04/jnc_mainslider3.jpg',
			'hero_4'      => 'https://jcreation.co.kr/wp-content/uploads/2017/04/jnc_mainslider4.jpg',
			'hero_5'      => 'https://jcreation.co.kr/wp-content/uploads/2017/04/jnc_mainslider5.jpg',
			'catalogue'   => 'https://jcreation.co.kr/wp-content/uploads/2017/02/catalogue.jpg',
			'video'       => 'https://jcreation.co.kr/wp-content/uploads/2017/09/video_hover.jpg',
			'portfolio'   => 'https://jcreation.co.kr/wp-content/uploads/2017/02/popol2.jpg',
			'product_1'   => 'https://jcreation.co.kr/wp-content/uploads/2017/02/product1-1.jpg',
			'product_2'   => 'https://jcreation.co.kr/wp-content/uploads/2017/02/product2-1.jpg',
			'notice'      => 'https://jcreation.co.kr/wp-content/uploads/2017/09/notice_hover.jpg',
			'rnd'         => 'https://jcreation.co.kr/wp-content/uploads/2017/09/RND_hover.jpg',
			'footer_logo' => 'https://jcreation.co.kr/wp-content/uploads/2017/08/footer_logo-1.png',
		);

		$imported = array();

		foreach ( $assets as $key => $url ) {
			$imported[ $key ] = self::import_source_asset( $key, $url );
		}

		return $imported;
	}

	private static function import_source_asset( $key, $url ) {
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

		if ( ! empty( $existing ) ) {
			return wp_get_attachment_url( (int) $existing[0] );
		}

		if ( ! function_exists( 'download_url' ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
		}

		if ( ! function_exists( 'media_handle_sideload' ) ) {
			require_once ABSPATH . 'wp-admin/includes/media.php';
			require_once ABSPATH . 'wp-admin/includes/image.php';
		}

		$tmp = download_url( $url, 30 );
		if ( is_wp_error( $tmp ) ) {
			return $url;
		}

		$file_array = array(
			'name'     => basename( wp_parse_url( $url, PHP_URL_PATH ) ),
			'tmp_name' => $tmp,
		);

		$attachment_id = media_handle_sideload( $file_array, 0, 'Jcreation source asset: ' . $key );

		if ( is_wp_error( $attachment_id ) ) {
			@unlink( $tmp );
			return $url;
		}

		update_post_meta( $attachment_id, '_jcreation_source_asset_key', $key );
		update_post_meta( $attachment_id, '_jcreation_source_asset_url', $url );

		return wp_get_attachment_url( $attachment_id );
	}

	private static function asset_url( $assets, $key ) {
		return isset( $assets[ $key ] ) && $assets[ $key ] ? $assets[ $key ] : '';
	}

	private static function home_content( $assets ) {
		$hero_images = array_filter(
			array(
				self::asset_url( $assets, 'hero_1' ),
				self::asset_url( $assets, 'hero_2' ),
				self::asset_url( $assets, 'hero_3' ),
				self::asset_url( $assets, 'hero_4' ),
				self::asset_url( $assets, 'hero_5' ),
			)
		);

		$hero_html = '';
		foreach ( $hero_images as $index => $image_url ) {
			$hero_html .= sprintf(
				'<figure><img src="%s" alt="%s"></figure>',
				esc_url( $image_url ),
				esc_attr( 'Jcreation main slider ' . ( $index + 1 ) )
			);
		}

		return sprintf(
			<<<'HTML'
<section aria-label="Home top links">
	<p><a href="/">Home</a> <a href="http://gwx.bizmeka.com/LoginC.aspx?compid=jcreation">Group Ware</a></p>
</section>

<section aria-label="Jcreation main visual">
	%1$s
	<h1>Leader of Core Technology<br>JIG &amp; CREATION</h1>
	<p>We are Leader of Car JIG &amp; CREATION Parts. If you need high technology of Jig &amp; Creation, Join us.</p>
</section>

<section aria-label="Quick links">
	<h2>カタログ</h2>
	<h3>Catalogue</h3>
	<figure><img src="%2$s" alt="Catalogue"></figure>
	<p>(株) J&amp;Cに関するカタログ情報です。</p>
	<p><a href="/catalog/">もっと見る</a></p>

	<h2>広報動画</h2>
	<h3>Video</h3>
	<figure><img src="%3$s" alt="Video"></figure>
	<p>(株) J&amp;Cの会社紹介及び自動車車体溶接用ジグの生産設備に関する動画情報です。</p>
	<p><a href="/video/">もっと見る</a></p>

	<h2>生産製品ポートフォリオ</h2>
	<h3>Product Portfolio</h3>
	<figure><img src="%4$s" alt="Product Portfolio"></figure>
	<p>(株) J&amp;Cの生産製品の写真です。</p>
	<p><a href="/san-pham/">もっと見る</a></p>
</section>

<section aria-label="Products">
	<h2>製品紹介</h2>
	<h3>Products</h3>
	<p>(株) J&amp;Cは統合システム能力はもちろん、品質最優先、納期、価格競争力で顧客が満足できるよう最善の努力を尽くしています。</p>
	<ul>
		<li><a href="/san-pham/">生産製品</a></li>
		<li><a href="/san-pham/">生産工程</a></li>
	</ul>
	<figure><img src="%5$s" alt="Products"></figure>
	<figure><img src="%6$s" alt="Production process"></figure>
</section>

<section aria-label="Community">
	<h2>お知らせ事項</h2>
	<figure><img src="%7$s" alt="Notice"></figure>
	<p><a href="/tin-tuc/">もっと見る</a></p>

	<h2>R&amp;D 技術研究所</h2>
	<figure><img src="%8$s" alt="R and D"></figure>
	<p><a href="/ve-chung-toi/">もっと見る</a></p>
</section>

<section aria-label="Footer information">
	<figure><img src="%9$s" alt="J&C CO., LTD."></figure>
	<p>商号: (株) J &amp; C　代表理事: 裵于培</p>
	<p>住所: 韓国 京畿道 華城市 南陽面 善洞山丹2道81</p>
	<p>Tel. +82-31-366-9426 Fax. +82-31-355-9094</p>
	<p>Copyright © J&amp;C All Rights Reserved</p>
</section>
HTML,
			$hero_html,
			esc_url( self::asset_url( $assets, 'catalogue' ) ),
			esc_url( self::asset_url( $assets, 'video' ) ),
			esc_url( self::asset_url( $assets, 'portfolio' ) ),
			esc_url( self::asset_url( $assets, 'product_1' ) ),
			esc_url( self::asset_url( $assets, 'product_2' ) ),
			esc_url( self::asset_url( $assets, 'notice' ) ),
			esc_url( self::asset_url( $assets, 'rnd' ) ),
			esc_url( self::asset_url( $assets, 'footer_logo' ) )
		);
	}

	private static function about_content() {
		return <<<'HTML'
<section aria-label="Page banner">
	<h1>Về chúng tôi</h1>
	<p>Năng lực công nghệ và sản xuất của Jcreation.</p>
</section>

<section aria-label="Lời chào công ty">
	<h2>Lời chào từ Jcreation</h2>
	<p>Jcreation định hướng trở thành đối tác tin cậy trong lĩnh vực jig, fixture, automation và cơ khí chính xác. Chúng tôi đồng hành cùng khách hàng từ bước tiếp nhận yêu cầu, thiết kế giải pháp, sản xuất, kiểm tra đến bàn giao.</p>
</section>

<section aria-label="Tầm nhìn sứ mệnh giá trị">
	<h2>Tầm nhìn - Sứ mệnh - Giá trị cốt lõi</h2>
	<h3>Tầm nhìn</h3>
	<p>Trở thành đơn vị cung cấp giải pháp công nghiệp chính xác, ổn định và đáng tin cậy.</p>
	<h3>Sứ mệnh</h3>
	<p>Tối ưu quy trình sản xuất của khách hàng bằng giải pháp kỹ thuật phù hợp.</p>
	<h3>Giá trị cốt lõi</h3>
	<p>Chính xác, trách nhiệm, cải tiến và hợp tác lâu dài.</p>
</section>

<section aria-label="Năng lực">
	<h2>Năng lực của chúng tôi</h2>
	<ul>
		<li>Thiết kế jig và fixture theo yêu cầu.</li>
		<li>Gia công cơ khí chính xác.</li>
		<li>Tự động hóa dây chuyền sản xuất.</li>
		<li>Kiểm tra chất lượng và bàn giao dự án.</li>
	</ul>
</section>

<section aria-label="Company profile">
	<h2>Company Profile</h2>
	<p>Các thông tin như tên công ty, địa chỉ, năm thành lập, lĩnh vực hoạt động và thông tin liên hệ sẽ được cập nhật sau khi khách hàng cung cấp dữ liệu chính thức.</p>
</section>
HTML;
	}

	private static function products_content( $assets ) {
		return sprintf(
			<<<'HTML'
<section aria-label="Page banner">
	<h1>製品紹介</h1>
	<p>Products</p>
</section>

<section aria-label="Tổng quan sản phẩm">
	<h2>JIG &amp; CREATION Products</h2>
	<p>(株) J&amp;Cは統合システム能力はもちろん、品質最優先、納期、価格競争力で顧客が満足できるよう最善の努力を尽くしています。</p>
	<figure><img src="%1$s" alt="Jcreation products"></figure>
	<figure><img src="%2$s" alt="Jcreation production process"></figure>
</section>

<section aria-label="Danh mục sản phẩm">
	<h2>Product Categories</h2>
	<ul>
		<li>生産製品 / Production products</li>
		<li>生産工程 / Production process</li>
		<li>Jig &amp; Fixture</li>
		<li>Automation Equipment</li>
	</ul>
</section>

<section aria-label="Quy trình làm việc">
	<h2>Process</h2>
	<ol>
		<li>Requirement review</li>
		<li>Design and engineering</li>
		<li>Manufacturing and assembly</li>
		<li>Inspection and delivery</li>
	</ol>
</section>

<section aria-label="Liên hệ sản phẩm">
	<h2>Customer Consultation</h2>
	<p><a href="/dich-vu-khach-hang/">Contact Jcreation</a></p>
</section>
HTML,
			esc_url( self::asset_url( $assets, 'product_1' ) ),
			esc_url( self::asset_url( $assets, 'product_2' ) )
		);
	}

	private static function partners_content() {
		return <<<'HTML'
<section aria-label="Page banner">
	<h1>Đối tác thương mại</h1>
	<p>Mạng lưới hợp tác công nghệ, sản xuất và dự án.</p>
</section>

<section aria-label="Giới thiệu đối tác">
	<h2>Đồng hành cùng đối tác</h2>
	<p>Jcreation hướng đến mạng lưới hợp tác bền vững với các đối tác công nghệ, sản xuất, cung ứng và khách hàng dự án trong lĩnh vực công nghiệp.</p>
</section>

<section aria-label="Logo đối tác">
	<h2>Logo đối tác</h2>
	<p>Khu vực này sẽ được dựng bằng Logo Slider hoặc Image Gallery trong Flatsome UX Builder sau khi có file logo chính thức.</p>
</section>

<section aria-label="Nhóm đối tác">
	<h2>Nhóm đối tác</h2>
	<ul>
		<li>Đối tác công nghệ.</li>
		<li>Đối tác sản xuất.</li>
		<li>Khách hàng và dự án tiêu biểu.</li>
	</ul>
</section>

<section aria-label="Hợp tác">
	<h2>Liên hệ hợp tác</h2>
	<p><a href="/dich-vu-khach-hang/">Gửi thông tin hợp tác</a></p>
</section>
HTML;
	}

	private static function customer_service_content() {
		return <<<'HTML'
<section aria-label="Page banner">
	<h1>Dịch vụ khách hàng</h1>
	<p>Liên hệ Jcreation để được tư vấn giải pháp phù hợp.</p>
</section>

<section aria-label="Quy trình tư vấn">
	<h2>Quy trình tư vấn</h2>
	<ol>
		<li>Gửi yêu cầu.</li>
		<li>Phân tích nhu cầu.</li>
		<li>Đề xuất giải pháp.</li>
		<li>Báo giá và triển khai.</li>
	</ol>
</section>

<section aria-label="Form liên hệ">
	<h2>Form liên hệ</h2>
	<p>Khu vực này sẽ được thay bằng form từ Contact Form 7, WPForms hoặc Fluent Forms trong WordPress Admin.</p>
	<p>Trường thông tin cần có: Họ tên, Công ty, Email, Điện thoại, Nội dung yêu cầu và File đính kèm nếu cần.</p>
</section>

<section aria-label="Thông tin liên hệ">
	<h2>Thông tin liên hệ</h2>
	<p>Hotline, email, địa chỉ và giờ làm việc sẽ được cập nhật theo thông tin chính thức từ khách hàng.</p>
</section>

<section aria-label="FAQ">
	<h2>Câu hỏi thường gặp</h2>
	<h3>Jcreation có nhận thiết kế jig theo yêu cầu không?</h3>
	<p>Có. Jcreation tiếp nhận yêu cầu và đề xuất giải pháp theo đặc thù sản xuất của từng khách hàng.</p>
	<h3>Thời gian tư vấn và báo giá là bao lâu?</h3>
	<p>Thời gian phụ thuộc vào mức độ phức tạp của yêu cầu và dữ liệu kỹ thuật khách hàng cung cấp.</p>
	<h3>Có hỗ trợ dự án automation trọn gói không?</h3>
	<p>Có thể hỗ trợ từ tư vấn, thiết kế đến sản xuất, lắp ráp và bàn giao theo phạm vi dự án.</p>
</section>
HTML;
	}

	private static function news_page_content() {
		return <<<'HTML'
<section aria-label="Tin tức">
	<h1>Tin tức</h1>
	<p>Cập nhật thông tin dự án, sản phẩm và kiến thức sản xuất từ Jcreation.</p>
</section>
HTML;
	}

	private static function sample_product_post_content( $product_name ) {
		return sprintf(
			'<h2>%1$s</h2><p>Nội dung này là khung SEO ban đầu cho nhóm sản phẩm %1$s. Khi có dữ liệu thực tế, cần bổ sung hình ảnh, ứng dụng, thông số kỹ thuật và lợi ích cụ thể.</p><h2>Ứng dụng</h2><p>Phù hợp với dây chuyền sản xuất, lắp ráp, kiểm tra và các công đoạn yêu cầu độ chính xác cao.</p><h2>Thông tin cần cập nhật</h2><ul><li>Ảnh sản phẩm thực tế.</li><li>Mô tả kỹ thuật.</li><li>Ứng dụng trong nhà máy.</li><li>Case study hoặc dự án liên quan.</li></ul>',
			esc_html( $product_name )
		);
	}

	private static function sample_news_post_content() {
		return '<h2>Tiếp nhận yêu cầu</h2><p>Jcreation ghi nhận thông tin dự án, mục tiêu sản xuất và các ràng buộc kỹ thuật.</p><h2>Phân tích nhu cầu</h2><p>Đội ngũ kỹ thuật đánh giá yêu cầu, dữ liệu đầu vào và đề xuất hướng giải pháp phù hợp.</p><h2>Đề xuất giải pháp</h2><p>Giải pháp được trình bày theo phạm vi, tiến độ và yêu cầu chất lượng của dự án.</p>';
	}
}

JCreation_Site_Setup::init();
register_activation_hook( __FILE__, array( 'JCreation_Site_Setup', 'activate' ) );
