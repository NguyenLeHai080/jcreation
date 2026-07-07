# Checklist dung Jcreation bang Flatsome UX Builder

Ngay lap: 2026-07-07

Tai lieu nay dung de build truc tiep trong WordPress Admin bang thao tac keo-tha cua Flatsome UX Builder. Khong viet shortcode thu cong, khong them CSS rieng, khong dung `!important`.

## Nguyen tac bat buoc

- Tao moi layout bang UX Builder UI: Section, Row, Column, Banner, Image, Text, Button, Blog Posts, Portfolio/Grid, Logo/Slider.
- Khong dan shortcode vao Classic Editor/Text editor.
- Khong sua CSS cua theme Flatsome va khong sua theme cha.
- Font size, spacing, color, hover, animation chi dung option co san trong UX Builder/Theme Options.
- Moi menu la 1 WordPress Page rieng.
- Moi page co H1 duy nhat, slug khong dau, meta title/meta description ro rang.
- Ban goc tieng Viet; ngon ngu Anh/Nhat/Han dung plugin dich sau.

## Buoc 1: Tao pages

Tao cac Pages sau trong WordPress:

| Page | Slug | Ghi chu SEO |
| --- | --- | --- |
| Trang chu | `/` | Dat lam Homepage trong Settings > Reading |
| Ve chung toi | `/ve-chung-toi/` | Gioi thieu cong ty, nang luc, tam nhin |
| San pham | `/san-pham/` | Trang tong quan cac nhom san pham |
| Doi tac thuong mai | `/doi-tac/` | Logo va thong tin doi tac |
| Dich vu khach hang | `/dich-vu-khach-hang/` | Form tu van/lien he |
| Tin tuc | `/tin-tuc/` | Trang archive/blog neu can |

## Buoc 2: Tao menu

Vao Appearance > Menus:

1. Tao menu `Main Menu`.
2. Them 5 page chinh:
   - Trang chu
   - Ve chung toi
   - San pham
   - Doi tac thuong mai
   - Dich vu khach hang
3. Gan menu vao vi tri Primary/Menu chinh cua Flatsome.
4. Neu can ngon ngu, dat language switcher cua plugin dich o khu vuc header theo option plugin/theme.

## Buoc 3: Cau hinh theme khong dung CSS

Vao Flatsome > Theme Options:

| Khu vuc | Thao tac |
| --- | --- |
| Style > Colors | Dat Primary color theo mau xanh logo Jcreation |
| Header | Cau hinh logo, menu ngang, top bar neu can |
| Typography | Dung font/theme default, chi doi trong Theme Options neu khach yeu cau |
| Footer | Dung Footer Builder/Widgets, khong code footer rieng |
| Blog | Hien featured image, excerpt, category phu hop SEO |

## Buoc 4: Trang chu

Mo page `Trang chu` bang UX Builder, tao cac section theo dung thu tu sau.

### Section 1: Hero Banner

Element:

- Section hoac Slider/Banner cua Flatsome.
- Image/background: anh nha may, robot han, jig, automation.
- Text Box trong Banner.
- Button primary: `Xem san pham`.
- Button outline/secondary: `Lien he tu van`.

Noi dung goi y:

- H1: `Jcreation Viet Nam`
- Subheading: `Giai phap Jig, Automation va co khi chinh xac cho san xuat cong nghiep`
- CTA 1 link den `/san-pham/`
- CTA 2 link den `/dich-vu-khach-hang/`

Thiet lap:

- Dung overlay/darken option co san cua Banner neu can doc chu tren anh.
- Khong them CSS overlay rieng.

### Section 2: Gioi thieu ngan

Element:

- Section.
- Row 2 columns.
- Column anh: Image.
- Column noi dung: Text + Button.

Noi dung goi y:

- H2: `Ve Jcreation`
- Text: `Jcreation cung cap giai phap thiet ke va san xuat jig, thiet bi tu dong hoa va cac cum chi tiet phuc vu day chuyen san xuat. Chung toi tap trung vao do chinh xac, tinh on dinh va kha nang dong hanh lau dai cung khach hang.`
- Button: `Tim hieu them` link `/ve-chung-toi/`

### Section 3: Con so noi bat

Element:

- Section nen sang hoac primary nhe theo Theme Options.
- Row 4 columns.
- Icon Box hoac Text Box.

Noi dung:

| So | Label |
| --- | --- |
| 5+ | Nam kinh nghiem |
| 100+ | Doi tac |
| 1000+ | Khach hang |
| 500+ | Du an |

Thiet lap:

- Neu Flatsome co Counter element thi dung Counter.
- Khong viet JS count-up rieng.

### Section 4: San pham noi bat

Element:

- Section.
- Heading + Text.
- Row/Grid 3 columns hoac Portfolio/Product boxes neu da co data.

Card goi y:

1. `Jig va Fixture`
2. `Thiet bi tu dong hoa`
3. `Cum chi tiet co khi chinh xac`
4. `He thong kiem tra va lap rap`

Moi card:

- Image.
- H3 ten nhom san pham.
- Mo ta ngan 1-2 cau.
- Button/link `Xem chi tiet`.

### Section 5: Logo doi tac

Element:

- Section.
- Heading: `Doi tac thuong mai`
- Logo slider hoac Image gallery/grid cua Flatsome.

Thiet lap:

- Dung slider/gallery co san.
- Khi chua co logo that, de placeholder trong Media Library va thay sau.

### Section 6: Tin tuc moi nhat

Element:

- Blog Posts cua Flatsome.

Thiet lap:

- Category: `tin-tuc`.
- So luong: 3 bai.
- Hien featured image + excerpt.
- Link xem them den `/tin-tuc/`.

### Section 7: CTA tu van

Element:

- Section.
- Row 2 columns hoac centered.
- Text + Button.

Noi dung:

- H2: `Can tu van giai phap san xuat?`
- Text: `Gui yeu cau de doi ngu Jcreation lien he va de xuat giai phap phu hop.`
- Button: `Gui yeu cau` link `/dich-vu-khach-hang/`

## Buoc 5: Ve chung toi

Mo page `Ve chung toi` bang UX Builder.

### Section 1: Page Banner

- Banner/Section.
- H1: `Ve chung toi`
- Text ngan: `Nang luc cong nghe va san xuat cua Jcreation`

### Section 2: Loi chao cong ty

- Row 2 columns.
- Image dai dien cong ty.
- Text:
  - H2: `Loi chao tu Jcreation`
  - Noi dung gioi thieu cong ty bang tieng Viet.

### Section 3: Tam nhin - Su menh - Gia tri

- Row 3 columns.
- Icon Box:
  - `Tam nhin`
  - `Su menh`
  - `Gia tri cot loi`

### Section 4: Nang luc

- Row 2 columns hoac 4 cards.
- Cac muc:
  - Thiet ke jig/fixture.
  - Gia cong co khi chinh xac.
  - Tu dong hoa day chuyen.
  - Kiem tra chat luong.

### Section 5: Company Profile

- Dung Table/Accordion co san neu phu hop.
- Noi dung can khach cung cap:
  - Ten cong ty.
  - Dia chi.
  - Linh vuc hoat dong.
  - Nam thanh lap.
  - Thong tin lien he.

## Buoc 6: San pham

Mo page `San pham` bang UX Builder.

### Section 1: Page Banner

- H1: `San pham`
- Text: `Giai phap jig, automation va co khi chinh xac cho san xuat`

### Section 2: Mo ta tong quan

- Row 1 column hoac 2 columns.
- Text gioi thieu nang luc san pham.

### Section 3: Danh muc san pham

- Grid 3 hoac 4 columns.
- Moi item dung Image Box/Card co san.

Danh muc goi y:

- Jig & Fixture
- Automation Equipment
- Precision Parts
- Inspection & Assembly System

### Section 4: Quy trinh lam viec

- Row 4 columns/Icon Box:
  - Tiep nhan yeu cau
  - Thiet ke giai phap
  - San xuat/lap rap
  - Kiem tra/ban giao

### Section 5: CTA

- Button link den `/dich-vu-khach-hang/`.

## Buoc 7: Doi tac thuong mai

Mo page `Doi tac thuong mai` bang UX Builder.

### Section 1: Page Banner

- H1: `Doi tac thuong mai`
- Text: `Mang luoi hop tac cong nghe, san xuat va du an`

### Section 2: Gioi thieu doi tac

- Row 2 columns.
- Image + Text.

### Section 3: Logo doi tac

- Logo slider hoac Image gallery.
- Chia nhom neu co:
  - Doi tac cong nghe
  - Doi tac san xuat
  - Khach hang/du an

### Section 4: CTA hop tac

- Button link den `/dich-vu-khach-hang/`.

## Buoc 8: Dich vu khach hang

Mo page `Dich vu khach hang` bang UX Builder.

### Section 1: Page Banner

- H1: `Dich vu khach hang`
- Text: `Lien he Jcreation de duoc tu van giai phap phu hop`

### Section 2: Quy trinh tu van

- Row 4 columns/Icon Box:
  - Gui yeu cau
  - Phan tich nhu cau
  - De xuat giai phap
  - Bao gia/trien khai

### Section 3: Form lien he

- Neu dung Contact Form 7/WPForms/Fluent Forms:
  - Chen form bang element/widget/form block cua plugin trong UI.
  - Neu plugin chi ho tro shortcode va khong co element UI, khong dung plugin do cho giai doan build nay.

Truong form:

- Ho ten
- Cong ty
- Email
- Dien thoai
- Noi dung yeu cau
- File dinh kem neu can

### Section 4: Thong tin lien he

- Row 3 columns/Icon Box:
  - Hotline
  - Email
  - Dia chi

### Section 5: FAQ

- Accordion cua Flatsome.
- Cau hoi goi y:
  - Jcreation co nhan thiet ke jig theo yeu cau khong?
  - Thoi gian tu van va bao gia la bao lau?
  - Co ho tro du an automation tron goi khong?

## Buoc 9: Tin tuc va SEO post

Tao Category:

- `tin-tuc`
- `san-pham` neu dung post cho san pham

Moi bai viet can co:

- Title ro rang.
- Slug khong dau.
- Featured image.
- Excerpt.
- H2/H3 trong noi dung.
- Alt text cho anh.
- Meta title/meta description neu co plugin SEO.

## Buoc 10: Kiem tra truoc khi demo

Checklist:

- Da co 5 page menu chinh.
- Trang chu da dat lam Homepage.
- Header dung logo/menu.
- Footer co thong tin cong ty.
- Tat ca section tao bang UX Builder UI.
- Khong them CSS vao `style.css` child theme.
- Khong co `!important` trong code custom.
- Khong dan shortcode layout thu cong.
- Responsive desktop/tablet/mobile da xem qua.
- Cac anh placeholder da duoc ghi chu de thay bang anh that.
- Plugin dich da san sang de dich tu ban tieng Viet.

## Ghi chu cho nguoi build

Flatsome co the luu noi dung do UX Builder tao ra thanh shortcode trong database. Dieu nay la co che noi bo cua theme. Yeu cau cua du an la dev khong viet shortcode thu cong va khong dung shortcode lam cach build layout.
