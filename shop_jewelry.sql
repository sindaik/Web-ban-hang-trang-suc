-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 29, 2025 at 01:02 PM
-- Server version: 5.6.51
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop_jewelry`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `total` decimal(12,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `fullname`, `email`, `phone`, `address`, `total`, `created_at`) VALUES
(1, 'ngoc dai', 'ngocdai@gmail.com', '0336532136', 'thanh binh - xuan lam - thuan thanh- bac ninh', '1500000.00', '2025-09-27 05:24:37'),
(2, 'ngoc dai', 'ngocdai@gmail.com', '0876503766', 'bac ninh', '1500000.00', '2025-09-28 04:49:52'),
(3, 'ngoc dai', 'ngocdai@gmail.com', '0876503766', 'bac ninh', '1500000.00', '2025-09-28 10:11:09'),
(4, 'ngoc dai', 'ngocdai@gmail.com', '0876503766', 'bac ninh', '1772000.00', '2025-09-28 13:13:09'),
(5, 'ngoc dai', 'ngocdai@gmail.com', '0876503766', 'bac ninh', '560000.00', '2025-09-28 13:49:52'),
(6, 'Ngọc Đại', 'ngocdai@gmail.com', '0876503766', 'thanh binh - xuan lam - thuan thanh - bac ninh', '4602000.00', '2025-09-29 05:39:44'),
(7, 'Ngọc Đại', 'ngocdai@gmail.com', '0876503766', 'thanh binh xuan lam thuan thanh bac ninh', '2301000.00', '2025-09-29 05:45:20'),
(8, 'Ngọc Đại', 'ngocdai@gmail.com', '0876503766', 'bac ninh', '955000.00', '2025-09-29 05:49:56'),
(9, 'Ngọc Đại', 'ngocdai@gmail.com', '0876503766', 'bac ninh', '1660000.00', '2025-09-29 05:55:33'),
(10, 'Ngọc Đại', 'ngocdai8668@gmail.com', '1234567980', 'Thanh Bình - Xuân lâm - Thuận Thành - Bắc Ninh', '4168000.00', '2025-09-29 06:55:21');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `qty`, `price`) VALUES
(1, 1, NULL, 1, '1500000.00'),
(2, 2, NULL, 1, '1500000.00'),
(3, 3, NULL, 1, '1500000.00'),
(4, 4, 53, 1, '1772000.00'),
(5, 5, 54, 1, '560000.00'),
(6, 6, 55, 2, '2301000.00'),
(7, 7, 55, 1, '2301000.00'),
(8, 8, 8, 1, '955000.00'),
(9, 9, 45, 1, '1660000.00'),
(10, 10, 50, 1, '2417000.00'),
(11, 10, 44, 1, '1751000.00');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discount` int(11) NOT NULL DEFAULT '0',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `description`, `price`, `discount`, `image`, `created_at`) VALUES
(1, 'Lắc tay bạc nữ mạ bạch kim đính đá CZ cỏ 4 lá', 'Vòng - Lắc', 'Chiếc lắc được làm từ bạc 925 mạ bạch kim đính 2 viên đá Cubic Zirconia được chế tác tỉ mỉ. Với thiết kế hình cỏ bốn lá thống nhất khoe trọn vẻ đẹp nữ tính, rạng rỡ của người đeo nên thường được phái mạnh sử dụng làm món quà bất ngờ và vô cùng ý nghĩa cho nàng như lời gửi gắm, truyền tải những tâm tư và tình cảm chân thành dành cho nàng.', '1022000.00', 0, '1759058921_anh1.png', '2025-09-28 11:27:12'),
(2, 'Lắc tay bạc cặp đôi tình yêu Forever Love', 'Vòng - Lắc', 'Lấy cảm hứng từ vòng tròn vô cực, tượng trưng cho vẻ đẹp bền chặt vĩnh cửu của tình yêu đôi lứa, lắc bạc LILI_986852 được thiết kế một cách tinh xảo, với chất liệu bạc S925 cao cấp, sang trọng. Món trang sức không chỉ giúp bạn trông thật thanh lịch và duyên dáng, mà còn như như một tín hiệu của tình yêu và hạnh phúc. Chúc bạn luôn hạnh phúc bên gia đình và người thương !!', '1565000.00', 0, '1759058907_anh2.png', '2025-09-28 11:28:27'),
(3, 'Lắc tay bạc nữ đính pha lê Swarovski trái tim của biển', 'Vòng - Lắc', 'Sản phẩm được làm từ bạc 925 cao cấp được đính kèm viên pha lê của hãng đá quý nổi tiếng thế giới Swarovski đến từ nước Áo. Là một trong những mẫu lắc tay đẹp nhất, với thiết kế là lựa chọn hoàn hảo cho bạn trong những trang phục dự tiệc trang trọng. Bạn có muốn cùng nó hóa trang thành nàng công chúa lộng lẫy không nào?', '1139000.00', 0, '1759058968_anh3.png', '2025-09-28 11:29:28'),
(4, 'Lắc tay bạc nam mắt xích đơn giản ngầu Cuban Saint Laurent Paris', 'Vòng - Lắc', 'Một thiết kế đơn giản mà thanh lịch, mang đến cho bạn sự tinh tế mà cá tính. Lắc tay bạc LILI_746785 được làm từ bạc 92.5% nguyên chất với thiết kế dạng mắt xích, là một trong những mẫu lắc tay cho nam đẹp nhất hiện nay, được chế tác tỉ mỉ và công phu bởi những nghệ nhân lành nghề. Bạn sẽ cool hơn với em nó đấy !!', '5299000.00', 0, '1759059017_anh4.png', '2025-09-28 11:30:17'),
(5, 'Lắc tay bạc Ta S999 nữ cỏ 4 lá cách điệu đẹp', 'Vòng - Lắc', 'Chiếc lắc tay được làm từ bạc Ta S999 với điểm nhấn là thiết kế hình cỏ 4 lá cách điệu. Lá đầu tiên đại diện cho niềm tin, lá thứ hai là sự hy vọng, lá thứ ba đại diện cho tình yêu và lá thứ tư là sự may mắn. Điểm khác biệt so với các sản phẩm khác đó là ngôn ngữ thiết kế của sản phẩm được khai thác tinh tế hơn với vị trí xuất hiện đầy khéo léo. Chiếc lắc tay xinh xắn này chắc chắn sẽ mang đến vẻ đẹp, sức hút tuyệt vời cho chủ nhân của nó.', '1187000.00', 0, '1759059123_lac3.jpg', '2025-09-28 11:32:03'),
(6, 'Vòng tay bạc đặc cặp đôi tình yêu mạ vàng Love Sunshine', 'Vòng - Lắc', 'Sản phẩm được làm từ bạc S990 dạng đặc với thiết kế mang đến vẻ đẹp đơn giản nhưng không đơn điệu, trưởng thành nhưng lại rất trẻ, mang đến làn gió tươi mới cho các cô nàng – chàng trai ưa thích sự giản dị. Món trang sức không chỉ giúp bạn trông thật thanh lịch và duyên dáng, mà còn như như một tín hiệu của tình yêu và hạnh phúc đó!', '4001000.00', 0, '1759059177_lac2.jpg', '2025-09-28 11:32:57'),
(7, 'Vòng tay bạc nữ dạng kiềng đính kim cương Moissanite tròn Farah', 'Vòng - Lắc', 'Chiếc vòng được làm từ bạc S925, với phong cách thiết kế nhấn nhá, nhỏ xinh, vừa dịu dàng vừa thu hút được chế tác tinh xảo từ đường nét mảnh mai, tao nhã đến viên kim cương Moissanite cao cấp 0,5 carat được đính khéo léo giúp tô điểm cho phái đẹp. Chắc chắn em nó sẽ là 1 trong những items xứng đáng nhất của bạn đó!', '1609000.00', 0, '1759059253_lac5.jpg', '2025-09-28 11:34:13'),
(8, 'Lắc tay bạc nữ đẹp dạng chuỗi hình ngôi sao 5 cánh', 'Vòng - Lắc', 'Lắc tay được chế tác kiểu mắt xích kết hợp cùng những ngôi sao 5 cánh gắn kết với nhau mang đến vẻ đẹp riêng, giúp bạn nổi bật cùng với những bộ trang phục khác lạ và phối với nhiều kiểu trang sức phụ kiện đính đá khác. Đồng thời sản phẩm còn được làm từ chất liệu bạc 92.5 cao cấp cùng với công nghệ tiên tiến nhất giúp cho sản phẩm luôn có độ sáng bóng bền lâu hơn và an toàn cho da của bạn. Đừng ngạc nhiên khi nhiều ánh mắt hướng về bạn vì sự tinh tế này nhé !!', '955000.00', 0, '1759059411_lac8.jpg', '2025-09-28 11:36:51'),
(9, 'Nhẫn bạc nữ đính đá CZ hoa bướm', 'Nhẫn', 'Chiếc nhẫn bạc S925 được trang trí, tạo điểm nhấn bằng nhiều viên đá Cubic Zirconia vô cùng sang trọng. Dù bạn dùng em nó để đi dự tiệc, đi chơi hay đi làm, thì bạn sẽ luôn toát lên vẻ kiều diễm, duyên dáng và thanh lịch. Chắc chắn đây sẽ là 1 trong những items xứng đáng nhất trong tủ trang sức của bạn đó!', '753000.00', 0, '1759059548_n1.jpg', '2025-09-28 11:39:08'),
(10, 'Nhẫn đôi bạc đính đá CZ All Of Love', 'Nhẫn', 'Hẳn là người ấy và bạn sẽ đều rất vui và hạnh phúc khi cùng sở hữu kỷ vật tình yêu rất đẹp và ý nghĩa này, mà nhất là khi nó lại có thể đi cùng các bạn qua thời gian. Nhẫn đôi bạc All Of Love được làm từ bạc S925 cao cấp, điểm nhấn bởi viên đá Cubic Zirconia sang trọng và được chế tác hết sức tỉ mỉ bởi những nghệ nhân lành nghề. Chúc cặp đôi luôn hạnh phúc và sánh bước bên nhau cùng kỷ vật này nhé !!', '1078000.00', 0, '1759059609_n2.jpg', '2025-09-28 11:40:09'),
(11, 'Nhẫn bạc nữ đính đá CZ hình bông hoa đào', 'Nhẫn', 'Chiếc nhẫn bạc S925 đính đá Cubic Zirconia với thiết kế hình bông hoa đào thống nhất khoe trọn vẻ đẹp nữ tính, rạng rỡ của người đeo nên thường được phái mạnh sử dụng làm món quà bất ngờ và vô cùng ý nghĩa cho nàng như lời gửi gắm, truyền tải những tâm tư và tình cảm chân thành dành cho nàng.', '769000.00', 0, '1759059651_n3.jpg', '2025-09-28 11:40:51'),
(12, 'Nhẫn bạc nữ mạ vàng 18k đính đá CZ hình trái tim', 'Nhẫn', 'Chiếc nhẫn được làm từ bạc 925 mạ vàng 18k với điểm nhấn là viên đá Cubic Zirconia hình trái tim. Được lấy cảm hứng từ những trái tim lãng mạn, e thẹn và ngọt ngào. Những trái tim nho nhỏ đính những viên đá Cubic Zirconia nổi bật đeo ở ngón tay bạn như được nhắc nhở rằng mình vẫn đang được yêu thương dù có đang cô đơn thế nào đi nữa. Đây là cách ghi nhớ thông điệp tình yêu rất duyên dáng, ý nhị, mà vẫn rất tươi sáng và trẻ trung.', '726000.00', 0, '1759059807_n4.jpg', '2025-09-28 11:43:27'),
(13, 'Nhẫn bạc nữ đính kim cương Moissanite Elfleda', 'Nhẫn', 'Chiếc nhẫn cao cấp được làm từ bạc S925 đính viên kim cương Moissanite 1 carat. Nó sẽ mang đến cho bạn sự sang trọng và quý phái. Dù trong hoàn cảnh nào: đi làm, đi dự tiệc hay đi chơi với bạn bè, đôi tay của bạn sẽ cực kỳ nổi bật đấy.', '1371000.00', 0, '1759059845_n5.jpg', '2025-09-28 11:44:05'),
(14, 'Nhẫn cặp đôi bạc đính kim cương Moissanite Layla', 'Nhẫn', 'Cặp nhẫn được làm từ bạc S925 đính viên kim cương Moissanite 0,5 carat sở hữu vẻ đẹp vừa quý phái lại vừa hiện đại, mang hơi hướng của sự phóng khoáng, là món phụ kiện không thể thiếu đối với mỗi cô gái, chàng trai, rất phù hợp khi làm quà tặng, cầu hôn, đính hôn, nhẫn cưới,… Chiếc nhẫn là món trang sức với kiểu dáng, thiết kế, màu sắc tinh tế và là đại diện cho mỗi phong cách khác nhau giúp chàng và nàng tự tin xuống phố, hội họp bạn bè hay dự một buổi tiệc tùng nào đó.', '1829000.00', 0, '1759059885_n6.jpg', '2025-09-28 11:44:45'),
(15, 'Nhẫn đôi bạc free size đính đá CZ hiệp sĩ và công chúa', 'Nhẫn', 'Hẳn là người ấy và bạn sẽ đều rất vui và hạnh phúc khi cùng sở hữu kỷ vật tình yêu rất đẹp và ý nghĩa này, mà nhất là khi nó lại có thể đi cùng các bạn qua thời gian. Nhẫn đôi bạc hiệp sĩ và công chúa đính đá CZ LILI_819229 được làm từ bạc S925 cao cấp, điểm nhấn bởi viên đá Cubic Zirconia sang trọng và được chế tác hết sức tỉ mỉ bởi những nghệ nhân lành nghề. Chúc cặp đôi luôn hạnh phúc và sánh bước bên nhau cùng kỷ vật này nhé !!', '1560000.00', 0, '1759059922_n7.jpg', '2025-09-28 11:45:22'),
(16, 'Nhẫn bạc nữ mạ bạch kim đính đá CZ cỏ 4 lá', 'Nhẫn', 'Bạn sẽ thêm phần cá tính và có gu hơn với chiếc nhẫn nữ cỏ 4 lá may mắn này đó. Lá đầu tiên đại diện cho niềm tin, lá thứ hai là sự hy vọng, lá thứ ba đại diện cho tình yêu và lá thứ tư là sự may mắn. Chắc chắn, chiếc nhẫn xinh xắn này sẽ mang đến vẻ đẹp, sức hút tuyệt vời cho chủ nhân của nó.', '825000.00', 0, '1759059966_n8.jpg', '2025-09-28 11:46:06'),
(17, 'Dây chuyền bạc nữ đính kim cương Moissanite tròn cách điệu', 'Dây chuyền', 'Một thiết kế đầy sang trọng đến từ trang sức LiLi, hãy tưởng tượng thiết kế dây chuyền bạc hình tròn cách điệu xinh xắn này ở trên cổ bạn, khi đi làm, đi chơi hay hẹn hò, sẽ thật tuyệt vời phải không nào. Món trang sức bạc này sẽ giúp bạn thêm phần đáng yêu và thu hút đó. Em nó được làm từ bạc 92.5% nguyên chất đính kim cương Moissanite 1 carat cao cấp. Cùng em nó ra ngoài và tỏa sáng thôi nào !!', '1619000.00', 0, '1759061217_d1.jpg', '2025-09-28 12:06:57'),
(18, 'Dây chuyền bạc nữ đẹp đính pha lê Aurora trái tim hoa lá', 'Dây chuyền', 'Bạn sẽ không chỉ thêm phần xinh xắn và thanh lịch khi diện em mặt dây chuyền trái tim hoa lá pha lê Aurora này, mà còn thể hiện gu thẩm mỹ sang trọng và rất riêng đấy nhé. Một người với trái tim đầy ắp yêu thương. Hãy tưởng tượng bạn sẽ duyên dáng và thu hút làm sao khi bạn diện chiếc vòng cổ này đi làm, đi hẹn hò hay đi chơi với bạn bè. Dây chuyền bạc nữ trái tim hoa lá đính pha lê Aurora LILI_866671 được làm từ bạc 925 chuyên dụng, điểm nhấn bởi viên pha lê Aurora  cao cấp và được chế tác hết sức tỉ mỉ bởi những nghệ nhân lành nghề. Cùng em nó ra ngoài và tỏa sáng thôi nào !!', '901000.00', 0, '1759061262_d2.jpg', '2025-09-28 12:07:42'),
(19, 'Dây chuyền đôi bạc cặp đính đá CZ công chúa hiệp sĩ', 'Dây chuyền', 'Bạn có đang tìm kiếm một món trang sức tinh tế, sang trọng và đặc biệt để dành cho cho cặp đôi? Dây chuyền đôi bạc cặp công chúa hiệp sĩ LILI_741969 được thiết kế nhằm thỏa mãn yêu cầu đó. Sản phẩm được làm từ bạc 92.5% nguyên chất, điểm nhấn bởi những viên đá Cubic Zirconia cao cấp và được chế tác tỉ mỉ và công phu bởi những nghệ nhân lành nghề, là một trong những mẫu dây chuyền đôi thuộc seri sản phẩm phi hành gia. Đây hứa hẹn sẽ không chỉ là món trang sức tuyệt vời cho cả hai mà còn là vật kỷ niệm dấu ấn tình cảm đó !!', '1930000.00', 0, '1759061335_d3.jpg', '2025-09-28 12:08:55'),
(20, 'Dây chuyền bạc nữ đính pha lê Swarovski trái tim đại dương', 'Dây chuyền', 'Dây chuyền bạc mặt pha lê Swarovski trái tim đại dương LILI_295787 là một thiết kế vô cùng sang trọng và hấp dẫn đến từ trang sức LiLi. Hãy tưởng tượng viên pha lê đính trên dây chuyền bạc này sáng lấp lánh trên khuôn cổ của bạn, sẽ thật tuyệt vời đúng không nào. Món trang sức này sẽ giúp bạn thêm đáng yêu và thu hút đó. Em nó được làm từ bạc 92.5% nguyên chất, mặt pha lê Swarovski cao cấp nhập khẩu với các tùy chọn màu sắc khác nhau. Cùng em nó ra ngoài và tỏa sáng thôi nào !!', '979000.00', 0, '1759061371_d4.jpg', '2025-09-28 12:09:31'),
(21, 'Dây chuyền bạc nữ 2 tầng đẹp và độc hình đôi bướm Hot Trend', 'Dây chuyền', 'Sản phẩm làm bằng bạc S925 đính đá Cubic Zirconia được thiết kế ấn tượng độc đáo 2 tầng với hình đôi bướm xinh xắn. Cách thiết kế này giúp chiếc dây chuyền trở nên nữ tính hơn, rất phù hợp cho các cô nàng công sở đeo thường ngày. Bạn sẽ trở nên hấp dẫn hơn nhiều khi đeo nó đấy!', '1076000.00', 0, '1759061409_d5.jpg', '2025-09-28 12:10:09'),
(22, 'Dây chuyền đôi bạc đính đá CZ gắn nam châm Heart to Heart', 'Dây chuyền', 'Nếu bạn đang tìm kiếm một mẫu trang sức trang sức đẹp, tinh tế cho cặp đôi thì dây chuyền đôi bạc Heart to Heart LILI_558997 hoàn toàn thỏa mãn điều đó. Dây chuyền làm từ bạc đính đá Cubic Zirconia cao cấp, chia làm hai nửa trái tim của đôi trai gái, được gắn kết với nhau bằng cặp nam châm trái cực, với hy vọng tình yêu đôi lứa sẽ luôn đẹp, mãi bền chặt, đi cùng nhau đến cuối con đường. Chúc các bạn hạnh phúc nhé !!', '1839000.00', 0, '1759061449_d6.jpg', '2025-09-28 12:10:49'),
(23, 'Dây chuyền bạc nữ đính đá CZ cỏ 4 lá', 'Dây chuyền', 'Sản phẩm được làm từ bạc S999 với điểm nhấn là thiết kế hình cỏ 4 lá đính đá Cubic Zirconia cao cấp. Lá đầu tiên đại diện cho niềm tin, lá thứ hai là sự hy vọng, lá thứ ba đại diện cho tình yêu và lá thứ tư là sự may mắn. Điểm khác biệt so với các sản phẩm khác đó là ngôn ngữ thiết kế của sản phẩm được khai thác tinh tế hơn với vị trí xuất hiện đầy khéo léo. Chiếc dây chuyền xinh xắn này chắc chắn sẽ mang đến vẻ đẹp, sức hút tuyệt vời cho bạn đó!', '979000.00', 0, '1759061484_d7.jpg', '2025-09-28 12:11:24'),
(24, 'Dây chuyền bạc nữ đính đá CZ trái tim vương miện Marilyn', 'Dây chuyền', 'Chiếc dây chuyền được làm bằng bạc S925 đính đá Cubic Zirconia với thiết kế hình trái tim kết hợp vương miện khoe trọn vẻ đẹp nữ tính, rạng rỡ của người đeo nên thường được phái mạnh sử dụng làm món quà bất ngờ và vô cùng ý nghĩa cho nàng như lời gửi gắm, truyền tải những tâm tư và tình cảm chân thành dành cho nàng.', '962000.00', 0, '1759061509_d8.jpg', '2025-09-28 12:11:49'),
(25, 'Bông tai bạc Ý S925 nữ mạ bạch kim đính đá CZ hình trái tim', 'Bông tai', 'Chiếc bông tai được làm từ bạc S925 đính đá Cubic Zirconia cao cấp hình trái tim với thiết kế là lựa chọn hoàn hảo cho bạn trong những trang phục dự tiệc trang trọng và là một chiếc khuyên không thể thiếu cho những bạn đã bấm khuyên tai. Bạn có muốn cùng em nó hóa trang thành nàng công chúa lộng lẫy không nào?', '823000.00', 0, '1759061766_b1.jpg', '2025-09-28 12:16:06'),
(26, 'Bông tai bạc nữ tròn đính đá CZ Isadora', 'Bông tai', 'Chiếc bông tai được chế tác bằng bạc S925 đính đá Cubic Zirconia cao cấp, được thiết kế tỉ mỉ, chi tiết trong từng đường nét không những tôn vinh vẻ đẹp cho các nàng mà còn mang ý nghĩa đặc biệt. Đó là một vòng tròn khép kín tượng trưng cho sự tròn đầy, hạnh phúc viên mãn, đó cũng chính là mong ước bền chặt không có khởi đầu cũng không có kết thúc trong tình yêu. Chắc chắn chiếc bông tai này sẽ là một trong những items xứng đáng nhất trong tủ trang sức của bạn đó.', '824000.00', 0, '1759061824_b2.jpg', '2025-09-28 12:17:04'),
(27, 'Bông tai bạc nữ đính đá CZ cỏ 4 lá', 'Bông tai', 'Bông tai được làm bằng bạc S999 cao cấp đính đá Cubic Zirconia với thiết kế hình cỏ 4 lá mang đến sự may mắn, cuốn hút toát lên vẻ sang chảnh và nổi bật cho bạn. Chắc chắn chiếc bông tai này sẽ là một trong những items xứng đáng nhất trong tủ trang sức của bạn đó!', '759000.00', 0, '1759061857_b3.jpg', '2025-09-28 12:17:37'),
(28, 'Bông tai bạc nữ đính đá CZ, ngọc trai Fidelma', 'Bông tai', 'Chiếc bông tai được làm bằng bạc S925 đính đá Cubic Zirconia, ngọc trai cao cấp. Khoác lên mình thiết kế bất đối xứng độc đáo, mang đến vẻ đẹp kiêu kỳ, cá tính và sự trẻ trung cho cô nàng sở hữu. Đây cũng là món quà ý nghĩa mà phái mạnh có thể dành cho phái đẹp như thể hiện sự nâng niu, trân trọng, và bảo vệ người phụ nữ mình yêu.', '695000.00', 0, '1759061926_b10.jpg', '2025-09-28 12:18:46'),
(29, 'Bông tai bạc nữ đính kim cương Moissanite hình bông hoa tuyết', 'Bông tai', 'Chiếc bông tai được chế tác bằng bạc S925, đính kim cương Moissanite 0,5 carat được thiết kế tỉ mỉ, chi tiết trong từng đường nét tôn vinh vẻ đẹp cho các nàng. Chắc chắn chiếc bông tai này sẽ là một trong những items xứng đáng nhất trong tủ trang sức của bạn đó.', '1204000.00', 0, '1759061958_b5.jpg', '2025-09-28 12:19:18'),
(30, 'Bông tai bạc nữ đính đá Swarovski trái tim của biển', 'Bông tai', 'Chiếc hoa tai được làm từ bạc 925 đính kèm viên pha lê của hãng đá quý nổi tiếng thế giới Swarovski đến từ nước Áo, là một trong những chiếc hoa tai đẹp nhất hiện nay. Khoác lên mình thiết kế độc đáo với những mắt đá hình tròn tinh tế, mang đến vẻ đẹp kiêu kỳ, cá tính và sự trẻ trung cho cô nàng sở hữu. Đây cũng là món quà ý nghĩa mà phái mạnh có thể dành cho phái đẹp như thể hiện sự nâng niu, trân trọng, và bảo vệ người phụ nữ mình yêu.', '769000.00', 0, '1759061983_b6.jpg', '2025-09-28 12:19:43'),
(31, 'Bông tai bạc nữ đính đá CZ hình tròn cách điệu Fergus', 'Bông tai', 'Chiếc bông tai được làm bằng bạc S925 đính đá Cubic Zirconia với thiết kế hình tròn cách điệu xinh xắn tượng trưng cho sự nữ tính, thanh lịch. Chắc hẳn bạn cũng như bất cứ cô gái nào cũng muốn mình trở thành chủ nhân của một chiếc khuyên tai hàng hiệu sành điệu và sang trọng này để nâng tầm đẳng cấp của mình và khiến bao người ngưỡng mộ.', '599000.00', 0, '1759062015_b7.jpg', '2025-09-28 12:20:15'),
(32, 'Bông tai bạc nữ đính đá CZ hình thỏ ngắm trăng', 'Bông tai', 'Chiếc bông tai được làm bằng bạc S925 đính đá Cubic Zirconia với thiết kế hình thỏ ngắm trăng xinh xắn tượng trưng cho sự nữ tính, thanh lịch. Chắc hẳn bạn cũng như bất cứ cô gái nào cũng muốn mình trở thành chủ nhân của một chiếc khuyên tai hàng hiệu sành điệu và sang trọng này để nâng tầm đẳng cấp của mình và khiến bao người ngưỡng mộ.', '999000.00', 0, '1759062051_b9.jpg', '2025-09-28 12:20:51'),
(33, 'Khuyên tai bạc nam ngầu chất hình trái tim Polaris đính đá CZ đen', 'Bông tai', 'Bạn đang tìm kiếm chiếc bông tai cho nam, đẹp, tinh tế và cá tính? Bông tai trái tim Polaris LILI_634747 đính đá Cubic Zirconia được thiết kế nhằm thỏa mãn yêu cầu đó. Chiếc bông tai vừa mang đến cho bạn phong cách vừa khá dễ phối đồ. Sản phẩm được làm từ bạc 92.5% nguyên chất, được chế tác tỉ mỉ và công phu bởi những nghệ nhân lành nghề, là một chiếc khuyên không thể thiếu cho những bạn đã bấm khuyên tai. Bạn sẽ thêm phần điển trai với em nó đấy !!', '899000.00', 0, '1759062085_b11.jpg', '2025-09-28 12:21:25'),
(34, 'Khuyên rốn bụng bạc nữ hình đính đá CZ cánh bướm', 'Khuyên xỏ', 'Hãy tưởng tượng khi bạn đeo em khuyên rốn đi chơi, đi cafe, hay hẹn hò… bạn sẽ không chỉ thêm phần nữ tính, đáng yêu mà còn thu hút rất rất nhiều ánh nhìn đó. Khuyên rốn bạc nữ hình cánh bướm LILI_865578 được làm từ bạc 925, mạ vàng trắng cao cấp, chế tác tỉ mỉ bởi các nghệ nhân lành nghề, là một trong những mẫu khuyên rốn đẹp nhất hiện nay. Cùng ra ngoài và tỏa sáng với em nó nhé !!', '930000.00', 0, '1759062369_xo1.jpg', '2025-09-28 12:26:09'),
(35, 'Khuyên xỏ bạc nữ/nam dùng cho mũi, môi, tai helix lobe conch...', 'Khuyên xỏ', 'Chiếc khuyên xỏ là unisex nên dù bạn là nữ hay nam dùng em nó đều okila nhé. Em nó sẽ giúp các bạn nữ thêm phần đáng yêu và cá tính đó, còn các bạn nam sẽ thêm phần điển trai và cool ngầu nha. Khuyên xỏ bạc nữ/nam dùng cho tai, mũi, môi LILI_965964 được làm từ bạc 925 mạ Rhodium, đính đá Cubic Zirconia cao cấp, chế tác tỉ mỉ bởi các nghệ nhân lành nghề, là một trong những mẫu khuyên mũi, môi, tai helix lobe conch… đẹp nhất hiện nay. Cùng ra ngoài và tỏa sáng với em nó nhé !!', '583000.00', 0, '1759062425_xo2.jpg', '2025-09-28 12:27:05'),
(36, 'Khuyên rốn bụng bạc nữ đính đá CZ vương miện nữ hoàng', 'Khuyên xỏ', 'Hãy tưởng tượng khi bạn đeo em khuyên rốn đi chơi, đi cafe, hay hẹn hò… bạn sẽ không chỉ thêm phần nữ tính, đáng yêu mà còn thu hút rất rất nhiều ánh nhìn đó. Khuyên rốn bạc nữ đính đá Cubic Zirconia LILI_693489 hình chiếc vương miện nữ hoàng được làm từ bạc 925, mạ Rhodium cao cấp, chế tác tỉ mỉ bởi các nghệ nhân lành nghề. Cùng ra ngoài và tỏa sáng với em nó nhé !!', '841000.00', 0, '1759062460_xo3.jpg', '2025-09-28 12:27:40'),
(37, 'Nhẫn đôi bạc đính đá CZ All Of Love', 'Trang sức đôi', 'Hẳn là người ấy và bạn sẽ đều rất vui và hạnh phúc khi cùng sở hữu kỷ vật tình yêu rất đẹp và ý nghĩa này, mà nhất là khi nó lại có thể đi cùng các bạn qua thời gian. Nhẫn đôi bạc All Of Love được làm từ bạc S925 cao cấp, điểm nhấn bởi viên đá Cubic Zirconia sang trọng và được chế tác hết sức tỉ mỉ bởi những nghệ nhân lành nghề. Chúc cặp đôi luôn hạnh phúc và sánh bước bên nhau cùng kỷ vật này nhé !!', '1087000.00', 0, '1759062546_doi1.jpg', '2025-09-28 12:29:06'),
(38, 'Lắc tay bạc cặp đôi tình yêu Forever Love', 'Trang sức đôi', 'Lấy cảm hứng từ vòng tròn vô cực, tượng trưng cho vẻ đẹp bền chặt vĩnh cửu của tình yêu đôi lứa, lắc bạc LILI_986852 được thiết kế một cách tinh xảo, với chất liệu bạc S925 cao cấp, sang trọng. Món trang sức không chỉ giúp bạn trông thật thanh lịch và duyên dáng, mà còn như như một tín hiệu của tình yêu và hạnh phúc. Chúc bạn luôn hạnh phúc bên gia đình và người thương !!', '1565000.00', 0, '1759062577_doi2.jpg', '2025-09-28 12:29:37'),
(39, 'Dây chuyền đôi bạc tình yêu tình bạn thân BFF đính đá CZ Forever Love', 'Trang sức đôi', 'Một trong số những thiết kế trang sức đôi tuyệt vời của trang sức LiLi, dây chuyền cặp đôi LILI_528145 được làm từ bạc 92.5% nguyên chất đính đá Cubic Zirconia cao cấp. Với thiết kế lấy cảm hứng từ biển cả, tượng trưng cho một tình yêu vĩnh cửu, dây chuyền đôi này là sự lựa chọn tuyệt vời cho những cặp đôi đang yêu nhau như một món kỷ vật theo các bạn đi cùng năm tháng, cùng tình yêu dài lâu. Em nó cũng có thể là món quà tuyệt vời mà chàng hay nàng dành cho nhau. Các bạn trông sẽ thật hạnh phúc và tỏa sáng đó !!', '2089000.00', 0, '1759062617_doi3.jpg', '2025-09-28 12:30:17'),
(40, 'Dây chuyền bạc đôi đính đá mã não rồng và phượng Walter', 'Trang sức đôi', 'Cặp dây chuyền được làm bằng bạc S925 đính đá mã não với thiết kế hình rồng và phượng mang đến cho bạn và người ấy sự trang nhã và thanh lịch. Hai bạn đã sẵn sàng để tỏa sáng và thu hút mọi ánh nhìn cùng em nó chưa nào !!', '1795000.00', 0, '1759062654_doi4.jpg', '2025-09-28 12:30:54'),
(41, 'Nhẫn đôi bạc đính đá CZ 2 nửa trái tim Forever Love', 'Khuyên xỏ', 'Hẳn là người ấy và bạn sẽ đều rất vui và hạnh phúc khi cùng sở hữu kỷ vật tình yêu rất đẹp và ý nghĩa này, mà nhất là khi nó lại có thể đi cùng các bạn qua thời gian. Nhẫn đôi bạc 2 nửa trái tim Forever Love LILI_834822 được làm từ bạc S925 cao cấp, điểm nhấn bởi viên đá Cubic Zirconia sang trọng và được chế tác hết sức tỉ mỉ bởi những nghệ nhân lành nghề. Chúc cặp đôi luôn hạnh phúc và sánh bước bên nhau cùng kỷ vật này nhé !!', '1055000.00', 0, '1759062702_doi5.jpg', '2025-09-28 12:31:42'),
(42, 'Nhẫn cặp đôi bạc đính kim cương Moissanite Layla', 'Trang sức đôi', 'Cặp nhẫn được làm từ bạc S925 đính viên kim cương Moissanite 0,5 carat sở hữu vẻ đẹp vừa quý phái lại vừa hiện đại, mang hơi hướng của sự phóng khoáng, là món phụ kiện không thể thiếu đối với mỗi cô gái, chàng trai, rất phù hợp khi làm quà tặng, cầu hôn, đính hôn, nhẫn cưới,… Chiếc nhẫn là món trang sức với kiểu dáng, thiết kế, màu sắc tinh tế và là đại diện cho mỗi phong cách khác nhau giúp chàng và nàng tự tin xuống phố, hội họp bạn bè hay dự một buổi tiệc tùng nào đó.', '1829000.00', 0, '1759062727_doi6.jpg', '2025-09-28 12:32:07'),
(43, 'Nhẫn đôi bạc free size đính đá CZ hiệp sĩ và công chúa', 'Trang sức đôi', 'Hẳn là người ấy và bạn sẽ đều rất vui và hạnh phúc khi cùng sở hữu kỷ vật tình yêu rất đẹp và ý nghĩa này, mà nhất là khi nó lại có thể đi cùng các bạn qua thời gian. Nhẫn đôi bạc hiệp sĩ và công chúa đính đá CZ LILI_819229 được làm từ bạc S925 cao cấp, điểm nhấn bởi viên đá Cubic Zirconia sang trọng và được chế tác hết sức tỉ mỉ bởi những nghệ nhân lành nghề. Chúc cặp đôi luôn hạnh phúc và sánh bước bên nhau cùng kỷ vật này nhé !!', '1560000.00', 0, '1759062773_doi8.jpg', '2025-09-28 12:32:53'),
(44, 'Nhẫn cặp đôi bạc đính kim cương Moissanite Theophilus', 'Trang sức đôi', 'Cặp nhẫn được làm từ bạc S925 đính viên kim cương Moissanite 1 carat sở hữu vẻ đẹp vừa quý phái lại vừa hiện đại, mang hơi hướng của sự phóng khoáng, là món phụ kiện không thể thiếu đối với mỗi cô gái, chàng trai, rất phù hợp khi làm quà tặng, cầu hôn, đính hôn, nhẫn cưới,… Chiếc nhẫn là món trang sức với kiểu dáng, thiết kế, màu sắc tinh tế và là đại diện cho mỗi phong cách khác nhau giúp chàng và nàng tự tin xuống phố, hội họp bạn bè hay dự một buổi tiệc tùng nào đó.', '1751000.00', 0, '1759062816_doi10.jpg', '2025-09-28 12:33:36'),
(45, 'Dây chuyền đôi bạc đính đá CZ hình sóng và gió Mabel', 'Trang sức đôi', 'Bạn có đang tìm kiếm một món trang sức tinh tế, sang trọng và đặc biệt để dành cho cho cặp đôi? Dây chuyền đôi bạc hình sóng và gió được thiết kế nhằm thỏa mãn yêu cầu đó. Sản phẩm được làm từ bạc 92.5% nguyên chất đính đá Cubic Zirconia được chế tác tỉ mỉ và công phu bởi những nghệ nhân lành nghề, là một trong những mẫu dây chuyền đôi đẹp nhất hiện nay. Đây hứa hẹn sẽ không chỉ là món trang sức tuyệt vời cho cả hai mà còn là vật kỷ niệm dấu ấn tình cảm đó !!', '1660000.00', 0, '1759062874_doi11.jpg', '2025-09-28 12:34:34'),
(46, 'Bộ trang sức bạc nữ đính đá pha lê hình trái tim', 'Trang sức bộ', 'Bộ trang sức được làm từ bạc 925 cao cấp được tô điểm bằng những viên pha lê hình trái tim bao quanh. Sản phẩm mang đến sự cuốn hút toát lên vẻ sang chảnh và nổi bật cho bạn. Chắc chắn bộ trang sức này sẽ là một trong những items xứng đáng nhất trong tủ trang sức của bạn', '1534000.00', 0, '1759062914_bo1.jpg', '2025-09-28 12:35:14'),
(47, 'Bộ trang sức bạc nữ đính đá Garnet, CZ hoa hồng tình yêu', 'Trang sức bộ', 'Bộ trang sức hình hoa hồng tình yêu được làm từ bạc S925 đính đá Garnet kết hợp Cubic Zirconia cao cấp. Sản phẩm được lấy cảm hứng thiết kế từ bông hoa hồng thanh lịch, mỗi đường nét của sản phẩm đều thể hiện sự chăm chút tỉ mỉ đến từ đôi tay người thợ lành nghề, vừa mềm mại, vừa chắc chắn. Nó chắc hẳn sẽ đem đến vẻ độc đáo, cá tính dành cho riêng bạn trong các dịp đi chơi, đi làm. Dù bạn kết hợp bộ trang sức xinh xắn này với trang phục nào đi nữa thì đây cũng là dấu ấn thật sự tuyệt vời cho bạn đó!', '1356000.00', 0, '1759062962_bo2.jpg', '2025-09-28 12:36:02'),
(48, 'Bộ trang sức bạc nữ hoa cúc họa mi', 'Trang sức bộ', 'Bạn có đang tìm kiếm món trang sức tinh tế và sang trọng? Bộ trang sức bạc cúc họa mi LILI_765251 được thiết kế nhằm thỏa mãn yêu cầu đó. Thử tưởng tượng bạn diện em nó ra ngoài đi chơi, đi làm hay đi hẹn hò, đảm bảo bạn sẽ thêm phần xinh đẹp và thu hút đó. Sản phẩm được làm từ bạc 92.5% nguyên chất, được chế tác tỉ mỉ và công phu bởi những nghệ nhân lành nghề. Sẽ không bất ngờ khi sự xinh xắn, đáng yêu của bạn thu hút mọi người xung quanh đâu nhé !!', '922000.00', 0, '1759062993_bo3.jpg', '2025-09-28 12:36:33'),
(49, 'Bộ trang sức bạc nữ đính đá Spinel, CZ hình bông tuyết', 'Trang sức bộ', 'Bạn sẽ không chỉ thêm phần xinh xắn và thanh lịch khi diện em mặt dây chuyền bông tuyết Spinel này, mà còn thể hiện gu thẩm mỹ sang trọng và rất riêng đấy nhé. Hãy tưởng tượng bạn sẽ duyên dáng và thu hút làm sao khi bạn diện bộ trang sức này đi làm, đi hẹn hò hay đi chơi với bạn bè. Bộ trang sức được làm từ bạc 925 chuyên dụng, điểm nhấn bởi viên đá Spinel và Cubic Zirconia cao cấp và được chế tác hết sức tỉ mỉ bởi những nghệ nhân lành nghề. Cùng em nó ra ngoài và tỏa sáng thôi nào!!', '1431000.00', 0, '1759063030_bo4.jpg', '2025-09-28 12:37:10'),
(50, 'Bộ trang sức bạc nữ mạ vàng đính đá CZ cây ô liu', 'Trang sức bộ', 'Nếu bạn đang tìm kiếm một sản phẩm vừa đẹp, tinh tế về thẩm mỹ, vừa mang ý nghĩa mang lại may mắn, nhất là về tiền tài thì thiết kế bộ trang sức bạc mạ vàng đính đá Cubic Zirconia Cây ô liu LILI_561446 là dành cho bạn đó. Em nó được làm từ bạc 92.5% nguyên chất, mạ vàng cao cấp, được các nghệ nhân chế tác một cách tỉ mỉ, tinh sảo. Món trang sức bạc này sẽ giúp bạn thêm phần đáng yêu và thu hút đó. Hãy tỏa sáng cùng em nó nhé !!', '2417000.00', 0, '1759063060_bo5.jpg', '2025-09-28 12:37:40'),
(51, 'Bộ trang sức bạc nữ mạ vàng đính đá CZ, Opal hình quả trứng thời trang', 'Trang sức bộ', '0', '1718000.00', 0, '1759063089_bo6.jpg', '2025-09-28 12:38:09'),
(52, 'Bộ trang sức bạc nữ mạ vàng đính đá Citrine hình chú ong vàng', 'Trang sức bộ', '0', '2074000.00', 0, '1759063121_bo7.jpg', '2025-09-28 12:38:41'),
(53, 'Bộ trang sức bạc nữ mạ vàng đính đá Citrine hình giọt nước', 'Trang sức bộ', '0', '1772000.00', 0, '1759063161_bo8.jpg', '2025-09-28 12:39:21'),
(54, 'Vòng tay thạch anh dâu tây nữ', 'Phong thuỷ', 'Sản phẩm được làm từ đá thạch anh dâu tây dạng chuỗi hạt. Một phong cách thiết kế tượng trưng cho sự nữ tính, thanh lịch. Chắc hẳn bất cứ cô gái nào cũng muốn mình trở thành chủ nhân của một chiếc vòng hàng hiệu sành điệu và sang trọng để nâng tầm đẳng cấp của mình và khiến bao người ngưỡng mộ', '560000.00', 0, '1759063263_pt1.jpg', '2025-09-28 12:41:03'),
(55, 'Vòng tay đá Garnet 7A nữ/nam', 'Phong thuỷ', 'Trong phong thủy, đá Garnet (Ngọc hồng lựu) mang đến sự bình tĩnh, can đảm cho chủ nhân. Nó rất hữu ích với những người đang trong giai đoạn khủng hoảng và tuyệt vọng vì giúp chuyển đổi năng lượng tiêu cực thành tích cực. Giúp chủ nhân vượt qua khủng hoảng, có niềm tin trong cuộc sống. Chắc chắn chiếc vòng này sẽ là một trong những items xứng đáng nhất trong tủ trang sức của bạn đó.', '2301000.00', 0, '1759063302_pt2.jpg', '2025-09-28 12:41:42'),
(56, 'Dây chuyền bạc nữ đính đá CZ lá thư tình yêu Giselle', 'Sản phẩm mới', 'Chiếc dây chuyền được làm bằng bạc S925 đính đá Cubic Zirconia với thiết kế lá thư tình yêu khoe trọn vẻ đẹp nữ tính, rạng rỡ của người đeo nên thường được phái mạnh sử dụng làm món quà bất ngờ và vô cùng ý nghĩa cho nàng như lời gửi gắm, truyền tải những tâm tư và tình cảm chân thành dành cho nàng.', '1058000.00', 0, '1759063362_spm1.jpg', '2025-09-28 12:42:42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`) VALUES
(1, 'Ngọc Đại', 'ngocdai@gmail.com', '$2y$10$GMd/TwsBTTxKBgUezds9EOaCUWX3zu/MvN35pjmJ.iGALiGVOPbdW', '2025-09-27 05:23:36'),
(2, 'Ngọc Đại', 'ngocdai8668@gmail.com', '$2y$10$uA.Juz9pynmwxSZVIxhW..b/7uXuZOwJdQ4eMlRjE.V.zJu63eX9S', '2025-09-29 06:54:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
