# Phan tich dung website Jcreation theo Flatsome UX Builder

Ngay lap: 2026-07-07

## 1. Muc tieu

Dung website Jcreation ban tieng Viet truoc, sau do dung plugin dich tu dong sang Anh, Nhat, Han. Website can bam theo tinh than giao dien Jcreation hien tai va HAMECO, uu tien hinh anh cong nghiep/co khi, bo cuc ro rang, de quan tri bang UI/UX Builder cua Flatsome.

Yeu cau quan trong:

- Moi menu la 1 trang rieng trong WordPress.
- Noi dung can chinh sua duoc bang UI Builder theo tung block.
- Khong viet shortcode thu cong de dung layout. Tat ca section/page phai duoc tao bang thao tac keo-tha trong Flatsome UX Builder.
- Bai viet/tin tuc/san pham can theo huong SEO: title ro, slug ro, heading hop ly, anh co alt text.
- Khong style lai CSS cua theme Flatsome.
- Khong viet CSS de font-size, animation/effect neu Flatsome da co option san.
- Khong dung `!important`.
- Han che code tuy bien; uu tien Flatsome Theme Options, UX Builder elements, UX Blocks, WP menus, widgets/footer builder.

## 2. Tai lieu tham khao

Nguon nguoi dung cung cap:

- Home Jcreation Nhat: https://jcreation.co.kr/ja/home/
- Home Jcreation Han: https://jcreation.co.kr/ko/home_main/
- Mau mau sac san pham: https://jcreation.co.kr/ko/product_1/
- Company/Greetings: https://jcreation.co.kr/en/greetings/
- Partner: https://jcreation.co.kr/en/partner/
- Customer consultation: https://jcreation.co.kr/en/customer-consultation/
- HAMECO: https://hameco.com.vn/

Ghi chu truy cap: cac trang Jcreation co the bi chan/trong thai loi khi truy cap tu cong cu tu dong, nen phan tich nay dua tren screenshot, yeu cau chi tiet cua khach va cau truc site da mo ta. Trang HAMECO cho thay nhom menu nganh co khi/cong nghiep gom overview, product, partner, contact va co vung quick support.

## 3. Dinh huong giao dien

Phong cach nen dung:

- Cong nghiep, co khi, san xuat, robot, jig, fixture, automation.
- Nen trang/ghi sang, cac khoi noi dung rong rai nhu Jcreation.
- Mau chu dao: xanh theo logo Jcreation, thay cho cac mang xanh mac dinh neu khac mau logo.
- Mau phu: den/ghi dam cho footer, ghi nhat cho duong ke va nen phu.
- Button/link: dung style button cua Flatsome, uu tien mau primary da cau hinh trong Theme Options.

Khong nen lam:

- Khong chen CSS rieng de ep typography, spacing, hover, animation.
- Khong viet inline style phuc tap trong shortcode neu UX Builder da co tuy chon.
- Khong sua truc tiep file theme Flatsome cha.
- Khong dung effect ngoai/JS rieng cho slider, gallery, carousel neu Flatsome co Slider/Row/Logo element.

## 4. Cau truc ngon ngu

Ban goc nen la tieng Viet.

Ngon ngu can co:

- Tieng Viet
- English
- Japanese
- Korean

Huong plugin:

- Neu can dich tu dong nhanh: GTranslate hoac TranslatePress ban co automatic translation.
- Neu can SEO tot hon tren tung ngon ngu: TranslatePress/Polylang/WPML tuy ngan sach, moi ngon ngu co URL rieng va metadata rieng.
- Vi khach noi "dung plugin dich la duoc", giai doan dau co the dung ban tieng Viet lam source, plugin tu dich cac ngon ngu con lai.

Luu y SEO:

- Neu dung dich tu dong mien phi kieu widget JS, SEO da ngon ngu co the kem.
- Neu can SEO quoc te that su, nen chon plugin tao URL/index rieng cho tung ngon ngu.

## 5. Sitemap de xuat

Menu chinh:

1. Trang chu
   - Slug: `/`
   - Template: Page + UX Builder

2. Ve chung toi
   - Slug: `/ve-chung-toi/`
   - Tham khao: Company/Greetings cua Jcreation
   - Template: Page + UX Builder

3. San pham
   - Slug: `/san-pham/`
   - Template: Page tong san pham + danh sach bai/product items

4. Doi tac thuong mai
   - Slug: `/doi-tac/`
   - Tham khao: Partner cua Jcreation
   - Template: Page + logo/grid doi tac

5. Dich vu khach hang
   - Slug: `/dich-vu-khach-hang/`
   - Tham khao: Customer consultation cua Jcreation
   - Template: Page + form lien he/tu van

Trang phu nen co:

- Tin tuc: `/tin-tuc/`
- Chi tiet tin tuc: post detail
- Chi tiet san pham: neu co nhieu san pham, nen dung post category hoac custom post type/product.
- Lien he: co the la section trong Dich vu KH hoac page rieng neu khach can.

## 6. De xuat cau truc noi dung tung trang

### 6.1. Trang chu

Dung Page + UX Builder, chia thanh cac section/block rieng:

1. Hero banner
   - Element: Flatsome Slider/Banner.
   - Anh nen: nha may, robot han, jig, thiet bi san xuat.
   - Text ngan: Jcreation Viet Nam/J&C, linh vuc jig, automation, co khi chinh xac.
   - Khong viet CSS overlay rieng; dung overlay/darken option cua Banner/Slider.

2. Gioi thieu ngan
   - Element: Row 2 cot.
   - Cot trai/phai: 1 ben anh, 1 ben text.
   - CTA: "Xem them" tro ve Ve chung toi.

3. Con so noi bat
   - Element: Row 4 cot hoac Featured Box/Icon Box.
   - Noi dung:
     - 5 nam kinh nghiem
     - 100 doi tac
     - 1000 khach hang
     - 500 du an
   - Neu Flatsome co count-up/counter element thi dung option san, khong viet JS rieng.

4. San pham noi bat
   - Element: Portfolio/Product boxes/Grid.
   - Dung category san pham neu co nhieu nhom.
   - Noi dung ban dau co the la cac card co anh, ten san pham, mo ta ngan.

5. Logo doi tac
   - Element: Logo slider/UX Slider hoac Row gallery.
   - Chay ngang neu dung duoc element san cua Flatsome.

6. Tin tuc
   - Element: Blog posts.
   - Lay tu category `tin-tuc`.
   - Hien 3 bai moi nhat.

7. Footer
   - Dung Footer Builder/Widgets cua Flatsome.
   - Gom logo, dia chi, hotline/email, menu nhanh, copyright.

### 6.2. Ve chung toi

Theo phan Company/Greetings cua Jcreation:

1. Banner tieu de trang
   - Anh nha may/van phong/cong nghe.
   - Heading: "Ve chung toi".

2. Loi chao/gioi thieu cong ty
   - Row 2 cot: anh dai dien + noi dung loi chao.
   - Noi dung tieng Viet de bien tap sau.

3. Tam nhin - Su menh - Gia tri cot loi
   - 3 cot, dung Icon Box cua Flatsome.

4. Nang luc/su khac biet
   - Cac bullet ngan: thiet ke jig, san xuat thiet bi, automation, quan ly chat luong.

5. Lich su/cong ty profile
   - Dung table hoac accordion Flatsome.
   - Khong custom table CSS; dung class/element san cua theme.

### 6.3. San pham

Trang san pham co ban:

1. Banner tieu de.
2. Mo ta ngan ve nang luc san pham.
3. Grid san pham/danh muc san pham.
4. Moi san pham nen co:
   - Ten san pham
   - Anh dai dien
   - Mo ta ngan
   - Ung dung
   - Thong so/chuc nang neu co
   - CTA lien he tu van

Cach quan tri:

- Neu khong ban hang online: co the dung Post category `san-pham` hoac Portfolio cua Flatsome.
- Neu tuong lai can bao gia/gio hang: dung WooCommerce product nhung tat gia/gio hang neu chua ban online.

### 6.4. Doi tac thuong mai

Theo trang Partner cua Jcreation:

1. Banner tieu de.
2. Gioi thieu ngan ve mang luoi doi tac.
3. Logo partner dang grid/slider.
4. Co the chia nhom:
   - Doi tac cong nghe
   - Doi tac san xuat
   - Khach hang/du an tieu bieu
5. CTA lien he hop tac.

### 6.5. Dich vu khach hang

Theo trang Customer Consultation cua Jcreation:

1. Banner tieu de.
2. Gioi thieu quy trinh tu van.
3. Form lien he:
   - Ho ten
   - Cong ty
   - Email
   - Dien thoai
   - Noi dung yeu cau
   - File dinh kem neu can
4. Thong tin lien he nhanh:
   - Hotline
   - Email
   - Dia chi
   - Gio lam viec
5. FAQ/co cau hoi thuong gap neu khach co noi dung.

Plugin form de xuat:

- Contact Form 7 neu can nhe va pho bien.
- WPForms/Fluent Forms neu can UI de quan tri hon.

## 7. Cau truc SEO

Trang:

- Moi menu la 1 Page rieng, co H1 duy nhat.
- Slug tieng Viet khong dau.
- Meta title/meta description cau hinh bang Rank Math hoac Yoast.
- Anh co alt text mo ta dung noi dung.

Bai viet:

- Dung category `tin-tuc`.
- Moi bai co title, excerpt, featured image.
- Noi dung co H2/H3 ro rang.
- Khong copy nguyen van tu website mau.

San pham:

- Moi san pham la 1 bai rieng neu can SEO san pham.
- Slug theo ten san pham.
- Co schema san pham neu dung plugin SEO ho tro.

## 8. Cach dung bang Flatsome UX Builder

Nen tao cac UX Blocks dung lai:

- `block-home-hero`
- `block-home-intro`
- `block-home-stats`
- `block-home-products`
- `block-partner-logo-slider`
- `block-news-latest`
- `block-footer-company-info`
- `block-page-banner`
- `block-contact-form`

Moi page se lap ghep tu cac UX Blocks nay. Cach nay giup:

- Quan tri vien sua tung block bang UI.
- Dung lai block tren nhieu page.
- Han che sua PHP/CSS.
- Giu dung chuan Flatsome.

Luu y bat buoc:

- Khong tao page/block bang cach dan shortcode vao editor.
- Khong seed layout bang plugin/PHP neu noi dung dau ra la shortcode.
- Chi tao Section, Row, Column, Banner, Image, Text, Button, Blog Posts, Portfolio/Product/Grid, Logo/Slider bang UX Builder.
- Neu Flatsome luu noi dung noi bo thanh shortcode trong database thi do la co che cua theme; dev khong duoc viet shortcode thu cong.

## 9. Rang buoc ky thuat trong theme

Repo hien co:

- Theme cha: `code/wp-content/themes/flatsome`
- Child theme: `code/wp-content/themes/flatsome-child`
- `style.css` child theme gan nhu trong.
- `functions.php` child theme dang enqueue Font Awesome va tat block editor.

Khuyen nghi:

- Khong them CSS tong quat vao `style.css` tru khi that su bat buoc.
- Neu can mau logo, cau hinh trong Flatsome Theme Options thay vi viet CSS.
- Header/menu/footer nen dung Flatsome Header Builder/Footer settings.
- Neu phai them CSS cuc bo, chi viet class rieng cho block rieng, khong override selector cua Flatsome, khong dung `!important`.
- Khong sua file trong theme cha `flatsome`.

## 10. Mau sac

Can lay mau xanh chuan tu logo Jcreation. Tam thoi de xuat:

- Primary: xanh logo Jcreation.
- Secondary: ghi dam/den cho heading/footer.
- Background phu: ghi rat nhat.
- Accent nho: do/xanh phu neu logo co, chi dung cho chi tiet nho.

Vie c ap mau:

- Cau hinh trong Flatsome Theme Options > Style > Colors.
- Button, link, menu active, icon box dung primary color cua theme.
- Khong viet CSS rieng de doi mau tung component neu UI Builder/Theme Options lam duoc.

## 11. Noi dung can khach cung cap

Can lay tu khach:

- Logo file goc.
- Anh banner/anh nha may/anh san pham chat luong cao.
- Danh sach san pham va mo ta.
- Danh sach doi tac/logo doi tac.
- Thong tin cong ty: dia chi, MST neu co, hotline, email, ban do.
- Noi dung loi chao/company profile.
- Thong tin form se gui ve email nao.
- Plugin dich mong muon/ngan sach neu can SEO da ngon ngu.

## 12. Thu tu trien khai de xuat

1. Tao branch lam viec theo Gitflow: `feat/jcreation-site-structure` tu `dev`.
2. Cau hinh WordPress:
   - Kich hoat Flatsome Child.
   - Cau hinh mau logo trong Theme Options.
   - Tao menu chinh.
3. Tao Pages:
   - Trang chu
   - Ve chung toi
   - San pham
   - Doi tac thuong mai
   - Dich vu khach hang
   - Tin tuc neu can
4. Tao UX Blocks dung lai.
5. Dung noi dung tieng Viet bang UX Builder bang thao tac keo-tha, khong dan shortcode thu cong.
6. Cai plugin SEO va form.
7. Cai plugin dich.
8. Kiem tra responsive desktop/tablet/mobile.
9. Kiem tra khong co CSS override/`!important`.
10. Tao PR `feat/jcreation-site-structure` vao `dev`, review, merge.
11. Merge `dev` sang `staging` de QA/demo.
12. Sau khi khach duyet, merge sang `prod`.

## 13. Rủi ro va luu y

- Neu chi dung plugin dich tu dong dang JS/widget, SEO da ngon ngu co the khong tot.
- Neu thieu anh san pham that, giao dien se kho giong site mau vi site mau dung nhieu anh nha may/thiet bi.
- Neu can giong gan nhu 1:1 site Jcreation, can duoc phep dung hinh anh/noi dung va can tai san media goc.
- Flatsome UI Builder co the lam duoc phan lon layout, nen khong nen viet template PHP rieng o giai doan dau.
- Cac section khong co trong mau thi lam dang co ban, dung component san cua Flatsome, mau xanh theo logo.

## 14. Ket luan

Huong dung phu hop nhat la tao site bang WordPress Pages + Flatsome UX Builder + UX Blocks, noi dung goc tieng Viet, sau do cai plugin dich. Khong nen code giao dien rieng hoac override CSS cua Flatsome. Toan bo bo cuc nen duoc chia thanh block de quan tri vien sua tren UI, dong thoi moi trang/san pham/tin tuc van dam bao cau truc SEO co ban.
