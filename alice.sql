-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2025-01-06 03:30:19
-- 伺服器版本： 10.4.32-MariaDB
-- PHP 版本： 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `alice`
--

-- --------------------------------------------------------

--
-- 資料表結構 `manager`
--

CREATE TABLE `manager` (
  `managerAccount` varchar(32) NOT NULL COMMENT '管理者帳號',
  `managerPassword` varchar(32) NOT NULL COMMENT '管理者密碼',
  `managerName` varchar(32) NOT NULL COMMENT '管理者名稱',
  `lastLoginTime` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '最後登入時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `manager`
--

INSERT INTO `manager` (`managerAccount`, `managerPassword`, `managerName`, `lastLoginTime`) VALUES
('Alice', '5566', 'Oppa', '2025-01-04 10:05:23');

-- --------------------------------------------------------

--
-- 資料表結構 `members`
--

CREATE TABLE `members` (
  `MemberID` int(8) NOT NULL,
  `MemberAccount` varchar(32) NOT NULL COMMENT '會員帳號',
  `MemberPassword` varchar(128) NOT NULL COMMENT '會員密碼',
  `MemberName` varchar(32) NOT NULL COMMENT '會員名稱',
  `MemberTel` varchar(32) NOT NULL COMMENT '會員電話',
  `MemberEmail` varchar(32) NOT NULL COMMENT '會員信箱',
  `CreatedTime` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '註冊時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `members`
--

INSERT INTO `members` (`MemberID`, `MemberAccount`, `MemberPassword`, `MemberName`, `MemberTel`, `MemberEmail`, `CreatedTime`) VALUES
(1, 'champion', '5566', '大佑池玖', '0978777888', '123@gmail.com', '2024-11-27 15:15:01'),
(2, '002', '1234', '多啦A夢', '0955123123', '555@hotmail.com', '2024-12-27 15:33:57'),
(3, '003', '1234', '兩津勘吉', '0987888777', '321@mail.com', '2024-12-27 15:49:54'),
(4, '005', '1234', 'Alice', '0977888888', '123@gmail.com', '2024-12-28 04:32:33'),
(10, '006', '$2y$10$Wevh/qUbd9kpCXv4HgthYeFh7nHF9U3WtTplPJTn2vLg3.pLAMTdq', 'Abby', '0922999888', 'test@gmail.com', '2025-01-04 12:27:42'),
(11, '003', '$2y$10$qYc7Q2d2GUKDT1Q8PWjau.ZU46QvuXdIN7Ih062.WIFVkB2Fk9pw2', 'Bob', '0933333333', 'test2@gmail.com', '2025-01-04 12:36:29'),
(12, '004', '$2y$10$e.hxIioW7wxk7i0fM6fAo.nH4shIxfY/39RlVtCKO99PXtYurutf.', 'Bob', '0933333333', 'test2@gmail.com', '2025-01-04 12:38:01'),
(13, 'test8888', '$2y$10$CEAxKsAte2t0age8qHGdQOOU8AJO3ZSfBoMdy.6LW7GacYt.NeT22', 'yukistar', '0988777888', 'test@gmail.com', '2025-01-04 16:39:57'),
(14, 'test9999', '$2y$10$d2PsiCxsUxjv4axo25tknuy4LY4vNnDLZUk5mmYmOwJkSTk7cbUHq', '武騰遊戲EX', '0977555666', 'test1@gmail.com', '2025-01-04 16:44:08'),
(15, 'test7777', '$2y$10$/AqdPZV8D7y0QHtxHjZnGOysExMxaB8zsTv2RoUZsu3CogqHipXWi', '禿頭披風俠', '0966999666', 'test2@gmail.com', '2025-01-04 16:59:36'),
(16, 'test6666', '$2y$10$4oNQWmxuHXkCEeFCx63hiOQWV/EjEs07x0zzwuxQsR3an/TZRQfpK', '聽說這裡有人妻', '0999666999', 'test3@gmail.com', '2025-01-04 17:06:19'),
(17, 'test5555', '$2y$10$8jT8kNo64wRQFakziwU87euBQBwOPP2CTudfROMRMhzNXM5mtlP6K', '我不叫塔矢亮', '0955333444', 'test4@gmail.com', '2025-01-04 17:09:23'),
(18, 'test1111', '$2y$10$bA5PJgPxmiMoSKFHYFgEZu9ymajvImhNNAa1nLynB/ANbZwMQbJpy', '我二弟天下無敵', '0911222333', 'test5@gmail.com', '2025-01-04 17:43:02');

-- --------------------------------------------------------

--
-- 資料表結構 `products`
--

CREATE TABLE `products` (
  `ProductID` int(8) NOT NULL,
  `ProductName` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '產品名稱',
  `ItemID` int(8) NOT NULL COMMENT '品名編號',
  `ProductType` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '產品類型	',
  `ProductCategory` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '產品口味',
  `ProductPrice` int(8) NOT NULL COMMENT '產品價格',
  `ProductQuantity` int(8) NOT NULL COMMENT '產品數量',
  `CreatedTime` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '新增時間'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- 傾印資料表的資料 `products`
--

INSERT INTO `products` (`ProductID`, `ProductName`, `ItemID`, `ProductType`, `ProductCategory`, `ProductPrice`, `ProductQuantity`, `CreatedTime`) VALUES
(1, 'LaPetz 樂倍-黑酵母 超低敏蟲蛋白狗糧', 1, 'dryDogFood', '原味', 980, 20, '2024-12-11 04:03:18'),
(2, 'HALO 嘿囉-成犬 無榖低脂 火雞肉配方 (3.5磅/10磅)', 2, 'dryDogFood', '原味', 1140, 25, '2024-12-11 04:03:18'),
(3, 'Pets Corner 沛克樂-頂級天然糧 羊肉低敏 大顆粒', 3, 'dryDogFood', '原味', 360, 39, '2024-12-21 14:12:49'),
(4, 'SEEDS 惜時-YOYO愛犬機能餐罐(五種口味)', 4, 'cannedDogFood', '牛肉醬佐雞肉起司', 35, 20, '2024-12-21 16:50:25'),
(5, 'SEEDS 惜時-YOYO愛犬機能餐罐(五種口味)', 4, 'cannedDogFood', '牛肉醬佐雞肉野菜', 40, 20, '2024-12-22 09:35:09'),
(6, 'SEEDS 惜時-YOYO愛犬機能餐罐(五種口味)', 4, 'cannedDogFood', '羊肉醬佐雞肉野菜', 45, 20, '2024-12-22 09:35:09'),
(7, 'SEEDS 惜時-YOYO愛犬機能餐罐(五種口味)', 4, 'cannedDogFood', '羊肉醬佐雞肉雞肝', 50, 20, '2024-12-22 09:36:28'),
(8, 'SEEDS 惜時-YOYO愛犬機能餐罐(五種口味)', 4, 'cannedDogFood', '雞肉醬佐嫩雞起司', 55, 20, '2024-12-22 09:36:28'),
(9, '奧地利Kent 肯特-犬罐 (6種口味)', 5, 'cannedDogFood', '雞肉', 35, 30, '2024-12-28 18:35:41'),
(10, '奧地利Kent 肯特-犬罐 (6種口味)', 5, 'cannedDogFood', '雞肉+蔬菜', 43, 25, '2024-12-28 18:51:35'),
(11, '奧地利Kent 肯特-犬罐 (6種口味)', 5, 'cannedDogFood', '火雞肉', 55, 30, '2024-12-29 12:31:37'),
(12, '奧地利Kent 肯特-犬罐 (6種口味)', 5, 'cannedDogFood', '火雞肉+蔬菜', 60, 100, '2025-01-03 15:26:05'),
(13, '奧地利Kent 肯特-犬罐 (6種口味)', 5, 'cannedDogFood', '鴨肉', 55, 30, '2025-01-03 15:35:51'),
(14, '奧地利Kent 肯特-犬罐 (6種口味)', 5, 'cannedDogFood', '羊肉', 57, 50, '2025-01-03 15:50:09');

-- --------------------------------------------------------

--
-- 資料表結構 `product_introduction`
--

CREATE TABLE `product_introduction` (
  `ItemID` int(8) NOT NULL COMMENT '品名編號',
  `ProductName` varchar(64) NOT NULL COMMENT '產品名稱',
  `ProductIntroduction` varchar(2048) NOT NULL COMMENT '產品介紹',
  `CreateTime` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '新增時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `product_introduction`
--

INSERT INTO `product_introduction` (`ItemID`, `ProductName`, `ProductIntroduction`, `CreateTime`) VALUES
(1, 'LaPetz 樂倍-黑酵母 超低敏蟲蛋白狗糧', '★台灣首創昆蟲寵物糧★\r\n●採用安全可追朔性之溫室飼養安全無毒的黑水虻蟲體\r\n以優質蛋白取代傳統肉類，提高產品可消化代謝率，減少寵物過敏風險。\r\n●以保護地球、永續環保為理念\r\n具體落實在產品設計上，大幅減少碳排放量及其他肉類之耗能，達到友善環境的目標。\r\n●黑水虻蛋白質別稱完美蛋白\r\n具有高蛋白及抗菌肽的營養價值，來源符合有機循環的生物處理標準，為接受嚴格檢驗的再生原料，做到循環永續，節能減碳的終極目標。\r\n●黑酵母專有技術(The Black-lmmunity)\r\n含有高單位β-葡聚醣，能調整免疫系統。\r\n●黑酵母專有技術(The Black-Anti-inflammatory)\r\n可舒緩寵物過敏發炎的生理現象。\r\n●黑酵母專有技術(The Black-Anti-Oxidant)\r\n能抑制細胞自由基產生，減少有害物質侵患。\r\n●榮獲中華民國新型專利字號M620272及M561415。\r\n●本產品黑酵母葡聚醣之菌株開發為農科院(ATRI)技術轉移。\r\n●本產品符合TAF實驗室微生物與有害健康物質之檢驗標準。\r\n●適用患有皮膚敏感、脫毛、消化功能紊亂及體質過敏的寵物。', '2024-12-22 09:26:48'),
(2, 'HALO 嘿囉-成犬 無榖低脂 火雞肉配方 (3.5磅/10磅)', '◆ 專注營養與消化 維持免疫力\r\n◆ 更多鮮肉蛋白質，移除易敏大豆成分\r\n◆ 對毛皮更好，足量Omega3&6，黃金比例1:9\r\n◆ 更容易消化，加倍益生菌添加益生質，後生元維持腸道健康\r\n◆ 包裝升級，更好保鮮夾鏈袋設計，使用可回收材質', '2024-12-22 09:26:48'),
(3, 'Pets Corner 沛克樂-頂級天然糧 羊肉低敏 大顆粒', '低過敏的蛋白質來源\r\n特別添加亞麻籽亮毛配方\r\n搭配獨家除臭配方\r\n豐富的維他命群\r\n新鮮的蔬果添加', '2024-12-22 09:27:44'),
(4, 'SEEDS 惜時-YOYO愛犬機能餐罐(五種口味)', '豐富蛋白質能幫助愛犬成長發育，\r\n含有愛犬所需的維生素、礦物質等微量元素是愛犬的最愛\r\n---------------------------------------\r\n5種口味:\r\n牛肉醬佐雞肉起司、牛肉醬佐雞肉野菜、\r\n羊肉醬佐雞肉野菜、羊肉醬佐雞肉雞肝、雞肉醬佐嫩雞起司', '2024-12-22 09:27:44'),
(5, '奧地利Kent 肯特-犬罐 (6種口味)', '100%歐洲奧地利製造\r\n看得到的美味多汁大肉塊，肉質緊實，口感香醇\r\n以蒸煮方式製作，可減少油脂\r\n添加豐富維生素和礦物質\r\n符合FEDIAF的規格，無添加防腐劑、人工色素\r\n---------------------------------------\r\n6種口味:\r\n雞肉、雞肉+蔬菜、火雞肉、火雞肉+蔬菜、鴨肉、羊肉', '2024-12-28 18:35:41');

-- --------------------------------------------------------

--
-- 資料表結構 `product_type`
--

CREATE TABLE `product_type` (
  `TypeID` int(8) NOT NULL,
  `ProductType` varchar(32) NOT NULL COMMENT '產品種類',
  `Chinese` varchar(32) NOT NULL COMMENT '中文名稱'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `product_type`
--

INSERT INTO `product_type` (`TypeID`, `ProductType`, `Chinese`) VALUES
(1, 'dryDogFood', '乾狗糧'),
(2, 'cannedDogFood', '狗罐頭');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `manager`
--
ALTER TABLE `manager`
  ADD PRIMARY KEY (`managerAccount`);

--
-- 資料表索引 `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`MemberID`);

--
-- 資料表索引 `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ProductID`);

--
-- 資料表索引 `product_introduction`
--
ALTER TABLE `product_introduction`
  ADD PRIMARY KEY (`ItemID`);

--
-- 資料表索引 `product_type`
--
ALTER TABLE `product_type`
  ADD PRIMARY KEY (`TypeID`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `members`
--
ALTER TABLE `members`
  MODIFY `MemberID` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `products`
--
ALTER TABLE `products`
  MODIFY `ProductID` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `product_introduction`
--
ALTER TABLE `product_introduction`
  MODIFY `ItemID` int(8) NOT NULL AUTO_INCREMENT COMMENT '品名編號', AUTO_INCREMENT=14;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `product_type`
--
ALTER TABLE `product_type`
  MODIFY `TypeID` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
