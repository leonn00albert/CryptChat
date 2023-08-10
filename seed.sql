-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 10, 2023 at 12:05 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cryptchat`
--

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `id` int(11) NOT NULL,
  `sharedKey` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `hash` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `conversations`
--

INSERT INTO `conversations` (`id`, `sharedKey`, `created_at`, `updated_at`, `hash`) VALUES
(25, '\"{\\\"sharedKeyA\\\":\\\"7cbfec0ed1f9d808d8a3e642ed81ced2019c99ee5f3ad9cbe4691e9d16df4124a554e8fed3214cf8f58fcd78bbef25bc1784352db8eb70c508b50c57b832ab2a6416e714d37b949dba4f9c6e81e28df1\\\",\\\"sharedKeyB\\\":\\\"5da71a3633088f78d9f0ede632fe70e0b0c0f8b53f1a67645e734341ee3e4f1d1ab696cad0b2b465133f6fda115e50b84a091a036e229e5df5e45ebfd10daa996b6ab6a93eecc1ee206189ef6f84692b\\\"}\"', '2023-08-03 15:09:27', '2023-08-03 15:09:27', '2b8c4a163c2bc6cbd14e2c98aa2c6ff8'),
(26, '\"{\\\"sharedKeyA\\\":\\\"b18decd6ae2b2bfd8c0c07719db4560b50baa18b32fe1d1a3b19bd25ce72501b68a9077695a5215e36844d79bbe44c2a028f668251dba2af77a46381991f52668f3dc1a498bbf51ec70ab68e14c6c5fd\\\",\\\"sharedKeyB\\\":\\\"da76d577773bd2cebb07baec20993b43ee914da84055f998cb014d4a59f1e4668a76526f3a78d8a001f095f671388685e65f0b59f7600418d4eadb91360cca2af185ce5eb36304011858aa1bf13eca36\\\"}\"', '2023-08-03 15:09:35', '2023-08-03 15:09:35', 'ec02956e3c0ee2b05a3cbdcab8d363b7'),
(27, '\"{\\\"sharedKeyA\\\":\\\"1ece6f579b1bbf32d4e77265f14c7bd0c7a7b5eea75f143f42d37326850dd96c6c71cc6215ceabb3afaf659434b0bf1b04629d5bcedb7b96e3f4b66f681bfa426a385b18db5024f881d024dc1c93daed\\\",\\\"sharedKeyB\\\":\\\"7e5ac2d1f08e43389f1cb28c062ddcb88035ea2f64c277bd78b71f2c22ec1d6c913b50bdba72fc76391acc0b639c2f1cfa37decc7d63e466be569764bc8ff4c4f614a4536b0108edc8a66054bc1ddbf9\\\"}\"', '2023-08-03 15:09:44', '2023-08-03 15:09:44', '217e8a87bfbd6da0a39a613403dee756'),
(28, '\"{\\\"sharedKeyA\\\":\\\"1951217a64d77be653a5357342c45e37d8861f9d1c1d16a69a3c7024b9127111967287ef387e55c3b750cf79e25c9fd081fbcf6c80df100d7e930825bb6cb1f4085a078489d41dc154c79aa276e80db5\\\",\\\"sharedKeyB\\\":\\\"9fd221c14c27e0e5ba7dae7ffbacd117e5123f28454bcf10ab4592ed06962d446bebf22f1ebabfcf6b9169da9775b0d543998593b3885228a02dce237290653d1028f324fef61eb3c643844d6f177fe9\\\"}\"', '2023-08-07 11:14:39', '2023-08-07 11:14:39', 'd89a9bb90af0449ff7b90713a8ad1a97'),
(29, '\"{\\\"sharedKeyA\\\":\\\"f7883c6d14fab151a1c6ced385cc97cf59e498b559d4084f4f9aa0f50c35e6278116831960285c2638ae89a6964cfb282d4f9026896e410dddef7c8940e3badfecefd84fc61d5cd03156f3918e591cba\\\",\\\"sharedKeyB\\\":\\\"3e851193b246aaeafa2bc1826018af6dc387d35ffe4d3eb30b42296bfbbf79654eb4126d1e2e9fdd223910e5dc02a0acb01ca12701cf842a22849683271cb4e4ecfd1e0fdef9ae42a869930f26a1e66d\\\"}\"', '2023-08-07 11:14:52', '2023-08-07 11:14:52', '3df776de97315c32c06bcf3358510f73'),
(30, '\"{\\\"sharedKeyA\\\":\\\"7bec91d1eebc33c4d3d8de2bd9ce933ed1e418ec7d9d124228b7146c55cb7e15b6aeec240e099c53fbd7fd20e0c1363acc83f2096b2fffa71fdd622d4c3a60569ae0514408f3d860ec420314d5b4f8e0\\\",\\\"sharedKeyB\\\":\\\"1fe7f61e5397b3330fd987a03821f0974d5b92a61da44cecc02d33b5f25362284cbd9108d081d828a884446503bc6d7cab313a2e56f2fc7c35296672c388378f317eb40c441ad59c909223e7b527d461\\\"}\"', '2023-08-07 12:26:50', '2023-08-07 12:26:50', 'd5883e6597f07d4061d1e25fbedc6b5d'),
(31, '\"{\\\"sharedKeyA\\\":\\\"0d50f083a5460002a11596737bd14e5db5f879543959a447d9d86c861e220a5e9fc59660330856fe2e3592e83981788f9c1316eb75a24351cbe68357ca9385adfd8d0dd04e16758c251b926fe785994c\\\",\\\"sharedKeyB\\\":\\\"5290b5e9720d4306bf2e248444a0f32e0b225100d807fdd8409f23358880ff2d8fd305012d910e8653966faa0c41eafd99093983f5adcc5613cbb19eccccc59d59be6dd916d9a1a11adc48eadc1b2c9a\\\"}\"', '2023-08-09 14:02:28', '2023-08-09 14:02:28', '5ddb0a3acd3a0181f8dfa4e7cb89940a'),
(32, '\"{\\\"sharedKeyA\\\":\\\"02d31839a6d44ac467197336b62d07c2cc1e2e073239d30bb29e8d85c41de470ceca9fcbecd43c483c6053826c185bbad33b528b7d998ac86277ed0e8cfef648202b0574cd0bf6bdeeb25d9b4c4ded2a\\\",\\\"sharedKeyB\\\":\\\"44d904f93f483808ad2a1349c2b84a20f1b25f8429e21f81e9f857ba4898dc7b3ffd6a420eb761600ca29fce00909a79ef5d23780eb980129eb3c91c310f6ceaeff2f7547381045dbbd45a2e7f3b02cc\\\"}\"', '2023-08-10 05:59:17', '2023-08-10 05:59:17', 'da65bbf4bb32b32ffa38cd7fd1b81418'),
(33, '\"{\\\"sharedKeyA\\\":\\\"de2e4cf8c9d84c239350fb1f51c4025783fc9b899e9faa5bdfd0930364251b31d7ab84edb0abc0bedbb86eab560d03392eaa09daee19af49fc2c097cde1d8a86141aeca033bc38f865b3c3d3edc2b528\\\",\\\"sharedKeyB\\\":\\\"f0ff1dd943591dd517bbed33efec332a7c4fa427a9a22fc65549135bbb327c1c728cc3bf13103da1c4dee3dcb7364ec532a5251c8b191a06c4cac469d778b1d8d245dc709df509a30bc7288e88fe53fe\\\"}\"', '2023-08-10 06:31:11', '2023-08-10 06:31:11', 'ee85285156e3b20fa95240adbf0da4a1');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `message_text` text NOT NULL,
  `sent_at` datetime NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `conversation_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `timestamp` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `message_text`, `sent_at`, `is_read`, `conversation_id`, `user_id`, `username`, `timestamp`) VALUES
(39, 'U2FsdGVkX1/pq3f8MS5UXTh0BQkmDNzNMeIhz8Pe0u0=', '2023-08-01 12:09:51', 0, 10, NULL, 'test', '1690884591'),
(40, 'U2FsdGVkX19JjfqQZx8IVNVCb0bUd522qlCZ1zXl5G4=', '2023-08-01 12:13:28', 0, 10, NULL, 'leon', '1690884808'),
(41, 'U2FsdGVkX1+8S3R/vu1nre8NTd1cdnJNYT0BknBYhgc=', '2023-08-01 12:14:17', 0, 10, NULL, 'leon', '1690884857'),
(42, 'U2FsdGVkX1/+x7mLo8V2rnSeHfYwbG1hFXImfiGjUQc=', '2023-08-01 12:14:25', 0, 10, NULL, 'leon', '1690884865'),
(43, 'U2FsdGVkX19o5T+lW6TXApcUUq3OqeV8R85IxiYwk1M=', '2023-08-01 12:58:46', 0, 12, NULL, 'awesome', '1690887526'),
(44, 'U2FsdGVkX18pvjWyvFH3LNNeO5RC/+Mo4XydUlQPWjk=', '2023-08-01 12:59:11', 0, 12, NULL, 'leon', '1690887551'),
(45, 'U2FsdGVkX1+u60Xs8dMxa5IzLaWGUbPP3b/2cp1W4Eg=', '2023-08-01 12:59:12', 0, 12, NULL, 'leon', '1690887552'),
(46, 'U2FsdGVkX194j2uFrn4jYOUfaYNqfhnGnYrEjfK3nUA=', '2023-08-01 12:59:25', 0, 12, NULL, 'leon', '1690887565'),
(47, 'U2FsdGVkX1+Bks9x79Vy4en9W3SQDpi8UmX47/piuVg=', '2023-08-01 14:04:10', 0, 12, NULL, 'leon', '1690891450'),
(48, 'U2FsdGVkX18aCb9wYPzgA/uAOZg5R4EX+/UyQBxQnMU=', '2023-08-01 14:04:29', 0, 12, NULL, 'awesome', '1690891469'),
(49, 'U2FsdGVkX19kbXncpbfMfWlfm4SylGFSZW49HqrbNaA=', '2023-08-01 14:04:39', 0, 12, NULL, 'awesome', '1690891479'),
(50, 'U2FsdGVkX1/CzThFEd86slVnkxFyGmdFv/c8lCh7YDacGUUBGIWza7/YjqlfwarN', '2023-08-01 14:05:50', 0, 12, NULL, 'leon', '1690891550'),
(51, 'U2FsdGVkX18Ug/AaSF0RvaIFFldrwZbUYSZ1fVjVdfU=', '2023-08-01 14:41:40', 0, 12, NULL, 'awesome', '1690893700'),
(52, 'U2FsdGVkX1/qMmaDid1rhaQQIVGJiujQAdWtE12/OnM=', '2023-08-01 14:42:24', 0, 13, NULL, 'awesome', '1690893744'),
(53, 'U2FsdGVkX1/3yZUP893dlhOFWAVq7cpHBM8mfWdeQ3A=', '2023-08-01 14:42:37', 0, 14, NULL, 'awesome', '1690893757'),
(54, 'U2FsdGVkX19Zg9Fji5P+MOxtIoemrQ9xvJov7ag0f7s=', '2023-08-01 14:43:22', 0, 12, NULL, 'awesome', '1690893802'),
(55, 'U2FsdGVkX19r9RkEGuVgiEcfPnTakDsausoUTQG8jXsOa7rTR2Bw6CQUsSCFB6+t', '2023-08-01 14:43:42', 0, 12, NULL, 'leon', '1690893822'),
(56, 'U2FsdGVkX1+8dZ115SeNKveA7QVvBrZPnEheIGqEsbMi4/cazlMnnP34NjC3oRuyV97jaF0kws6p/3RsobGBow==', '2023-08-01 14:43:56', 0, 12, NULL, 'leon', '1690893836'),
(57, 'U2FsdGVkX18Y7wLP3h0b8L3SHcqFvb4ZbA8YuiX+gtM=', '2023-08-01 17:53:35', 0, 12, NULL, 'leon', '1690905215'),
(58, 'U2FsdGVkX18G8QECQrFzgAGiCqVz9hicRlnuIVEPDY4=', '2023-08-01 17:53:52', 0, 12, NULL, 'leon', '1690905232'),
(59, 'U2FsdGVkX19WRnCxPYQen+0JVCi02VDGaVP3oPSWgSg=', '2023-08-01 17:56:45', 0, 12, NULL, 'leon', '1690905405'),
(60, 'U2FsdGVkX1//lBKG83TVlUWeFMGVNuHoXWGGeTgnmRo=', '2023-08-01 17:58:07', 0, 15, NULL, 'leon', '1690905487'),
(61, 'U2FsdGVkX1/Nfpb+26K/Qm4aXS5HrJwLiJ3NCbdEvaA=', '2023-08-01 17:58:43', 0, 15, NULL, 'leon', '1690905523'),
(62, 'U2FsdGVkX19EBH6MXhGc+vAcn937ckzOGzMqFwyuhxI=', '2023-08-01 17:58:50', 0, 15, NULL, 'leon', '1690905530'),
(63, 'U2FsdGVkX19hIjpDWdigplkaVVix/1tptWsj0z+Th8c=', '2023-08-01 17:59:00', 0, 15, NULL, 'leon', '1690905540'),
(64, 'U2FsdGVkX19UhuqHgG5XX99ktkSBBp+YUQwawcA9D5o=', '2023-08-01 18:00:39', 0, 12, NULL, 'leon', '1690905639'),
(65, 'U2FsdGVkX1/swLnOyAcIAeUZnAf/8ot5vyVb933vTOM=', '2023-08-01 18:05:02', 0, 12, NULL, 'leon', '1690905902'),
(66, 'U2FsdGVkX18xtH40W1vDT31XB8a7i83bTAZeQGspozo=', '2023-08-01 18:05:19', 0, 12, NULL, 'leon', '1690905919'),
(67, 'U2FsdGVkX18OR85efx9oTy1IjKj+1nAd9jD7UrExEdc=', '2023-08-01 18:07:51', 0, 10, NULL, 'leon', '1690906071'),
(68, 'U2FsdGVkX194a8H8MWfOlr+rRjya0jEygDty+CQHDyE=', '2023-08-01 18:08:08', 0, 10, NULL, 'leon', '1690906088'),
(69, 'U2FsdGVkX1+u4evf+gPoE+VE1aTDYb44LN2PVgCr/FE=', '2023-08-01 18:08:36', 0, 10, NULL, 'leon', '1690906116'),
(70, 'U2FsdGVkX19uEFIrH5z550zf2Q8ag7Z0IgIHTy6kXDA=', '2023-08-01 18:09:18', 0, 12, NULL, 'leon', '1690906158'),
(71, 'U2FsdGVkX18tQOd51dB3djhHXdl90r8Xf4QqagOchzc=', '2023-08-01 18:09:25', 0, 12, NULL, 'leon', '1690906165'),
(72, 'U2FsdGVkX1/S/lurVEZPDMtLDmnkOPlN5wi2Soxca/E=', '2023-08-01 18:10:22', 0, 10, NULL, 'leon', '1690906222'),
(73, 'U2FsdGVkX181lG5gDaGShLNiiDAQSIJJY/riWcI2uXY=', '2023-08-01 18:16:51', 0, 10, NULL, 'leon', '1690906611'),
(74, 'U2FsdGVkX18r4anrQZJN8U2ITs32MqgchxWOBGjgnaU=', '2023-08-01 18:17:58', 0, 12, NULL, 'leon', '1690906678'),
(75, 'U2FsdGVkX1+fLehttuqFM0WCecmaqiwwYqzBkytbFHU=', '2023-08-01 18:19:30', 0, 12, NULL, 'leon', '1690906770'),
(76, 'U2FsdGVkX1/jolf4NNUeu7utT971Ksf2vfHeCSCm08I=', '2023-08-01 18:19:37', 0, 12, NULL, 'leon', '1690906777'),
(77, 'U2FsdGVkX1+iRhkSMXl3yQGJ+6DopY+sXkocyx1FpRM=', '2023-08-01 18:21:06', 0, 10, NULL, 'leon', '1690906866'),
(78, 'U2FsdGVkX1++1Cg1n6Fv8lKprhgEP8irD7xErZRoXjk=', '2023-08-01 18:24:04', 0, 15, NULL, 'kristina', '1690907044'),
(79, 'U2FsdGVkX18AslxtccOYXLbvRyNSBT+SSsYdNNe+ra0=', '2023-08-01 18:25:13', 0, 14, NULL, 'kristina', '1690907113'),
(80, 'U2FsdGVkX19u6JPvfaImzLa9xpscihrCIRzPWUarvr8=', '2023-08-01 18:26:09', 0, 14, NULL, 'awesome', '1690907169'),
(81, 'U2FsdGVkX19DeuzuC5sEvvIzY/Jysl2CUFmyodLSRL4=', '2023-08-01 18:26:27', 0, 14, NULL, 'kristina', '1690907187'),
(82, 'U2FsdGVkX1+MN7Mr9XmQFBhqc2dGLO5jvDljAN/+zRk=', '2023-08-01 18:26:52', 0, 14, NULL, 'awesome', '1690907212'),
(83, 'U2FsdGVkX1/5EyX1ocB6VZqpRAhlUs3Xsv8FUU9nJVM=', '2023-08-01 18:28:22', 0, 15, NULL, 'kristina', '1690907302'),
(84, 'U2FsdGVkX19vtCxB5HjC6NECMK8+SVGJvn+yjAFnY80=', '2023-08-01 18:29:05', 0, 14, NULL, 'kristina', '1690907345'),
(85, 'U2FsdGVkX1/2t+AMZ4O2hkV52pQ8uvT/mi1HNmjRCx8=', '2023-08-01 18:29:16', 0, 14, NULL, 'awesome', '1690907356'),
(86, 'U2FsdGVkX19Gg9OLIXUp+DfL0ZQ7er4HfmMEnMyn9Bo=', '2023-08-01 18:30:22', 0, 14, NULL, 'kristina', '1690907422'),
(87, 'U2FsdGVkX1/tuJIKPFEwtC3O2X0elFsxWqVlpicdzkM=', '2023-08-01 18:30:52', 0, 14, NULL, 'kristina', '1690907452'),
(88, 'U2FsdGVkX1/z46ggX2Y+2DeHZnQLbimXZJ5cZfpSaEc=', '2023-08-01 18:35:46', 0, 14, NULL, 'awesome', '1690907746'),
(89, 'U2FsdGVkX19rX/P1hVEC5RPD7vhU3KIvnU1HRFNeJSM=', '2023-08-01 18:38:07', 0, 14, NULL, 'awesome', '1690907887'),
(90, 'U2FsdGVkX1/DGeHe9enJH9bPwGqtq6o/Bak1FWudZZA=', '2023-08-01 18:38:17', 0, 14, NULL, 'kristina', '1690907897'),
(91, 'U2FsdGVkX1+s32cS5+L78mn1lU4u9iN5QBIDsTuGo5m3MOp7YJvCfpM/0MABQ/mI', '2023-08-01 18:38:30', 0, 14, NULL, 'awesome', '1690907910'),
(92, 'U2FsdGVkX19KxBErHnO4OT4M3EXY8bUfRqgKOduSXImU5V5UyOrFmRZe9+EFH3ocbAHZ3/IVMZp7s02WaSxldyW7yoiiqz1tN0C4PyJejllsrBxeA7hNImc5hA1ecMyo5BN850YgYEoW9CPX1TJWVSf9FC7OVmuTm7lf9j5HaOF82Ap2rUrcWhXgEqVI8yCuYH5AXUxTu6yOBCIKENfaJ7ifKsnex3y1TmKMsdB/7slP5VIcD5lRTWqsVbeGiZuSJsrNg/4yel0ov5Lwa187pweaAVFcHo+tYLCvpJwsuTt9SbzsSD7WIhdxsT/7whVx6ap4VzNCA20qiXR342/A6s6F1IIY0hAyxb2sCFOLjxXPP2J3t4QMh/NTDz1asWYnMtVRLiKTh14SrjwECMxLhOt3lbA9EPN5+s8YkF/LYNduxvdshoaySjYDYKRG4dyyGfEIt9iSrBzf6qu78G8P2o8CqLTevh6elAJeUoojJFu43QqlCAntk7dPgy4GDnWxL1TvM9l7f7gduDUO6fCnyQ==', '2023-08-01 18:38:50', 0, 14, NULL, 'awesome', '1690907930'),
(93, 'U2FsdGVkX18YpKpBhgRKc5vYxuKQBR1NXwDRQe04aUI=', '2023-08-02 09:35:12', 0, 14, NULL, 'awesome', '1690961712'),
(94, 'U2FsdGVkX18T6c14fDkaMvmBT0U2hDslrOF0+R+5zg0=', '2023-08-02 09:37:16', 0, 14, NULL, 'awesome', '1690961836'),
(95, 'U2FsdGVkX1/MlpDhnuCr4Dom82m9Vs3AdrVtti3Yyvw=', '2023-08-02 09:38:42', 0, 12, NULL, 'awesome', '1690961922'),
(96, 'U2FsdGVkX19DuybsF1LqYd9ELJCM5Dip96pFl5Fm640=', '2023-08-02 09:39:39', 0, 12, NULL, 'awesome', '1690961979'),
(97, 'U2FsdGVkX18Cz2I8tl3Y6oOrGJz+yFUgeldLRySNCdE=', '2023-08-02 09:40:12', 0, 14, NULL, 'awesome', '1690962012'),
(98, 'U2FsdGVkX19Z1kNsNYcrG5aSZ1tbE7CGxmzvaiiJWZg=', '2023-08-02 09:40:20', 0, 14, NULL, 'awesome', '1690962020'),
(99, 'U2FsdGVkX180MNEEXfedrBaJOfN5pWBhYFDkIWaavt4=', '2023-08-02 13:52:19', 0, 14, NULL, 'awesome', '1690977139'),
(100, 'U2FsdGVkX192XWznP0bLM+FLu+FkpySAFAV34E1aRq8=', '2023-08-02 13:53:02', 0, 14, NULL, 'awesome', '1690977182'),
(101, 'U2FsdGVkX1/dJVvxm+zLYhEznX9yBzASlgkPwtOllE0=', '2023-08-02 13:56:04', 0, 14, NULL, 'awesome', '1690977364'),
(102, 'U2FsdGVkX1/o2aPhlQ+G2DgzKfOScnr/Mf4g0SSly5M=', '2023-08-02 13:57:19', 0, 14, NULL, 'awesome', '1690977439'),
(103, 'U2FsdGVkX18q1qSwrgnxQcqPAfKWkvUgJA9BXWDWejc=', '2023-08-02 13:57:37', 0, 14, NULL, 'awesome', '1690977457'),
(104, 'U2FsdGVkX1/6eHLTkWjgvGAzl5uHawBidZXwAuLY6HU=', '2023-08-02 14:03:43', 0, 14, NULL, 'awesome', '1690977823'),
(105, 'U2FsdGVkX1/LUFIQABnph/qGXrXDFS6J2IkZdDjuYaY=', '2023-08-02 14:04:14', 0, 14, NULL, 'awesome', '1690977854'),
(106, 'U2FsdGVkX18q3flR1Z/KPwTG7xxzCFKE8jtO7avgjfg=', '2023-08-02 14:04:33', 0, 14, NULL, 'kristina', '1690977873'),
(107, 'U2FsdGVkX1+P+jzlCMtGPrgCgwZuxnYN9w83Q8uF++g=', '2023-08-02 14:04:46', 0, 14, NULL, 'kristina', '1690977886'),
(108, 'U2FsdGVkX1+fwWPoEYU+BXQ+SSL5fsTdv6p6u6b8DdU=', '2023-08-02 14:05:50', 0, 14, NULL, 'kristina', '1690977950'),
(109, 'U2FsdGVkX18qKEzAfql7jVpCt52NKApL8/n76QkXqd8=', '2023-08-02 14:06:35', 0, 14, NULL, 'kristina', '1690977995'),
(110, 'U2FsdGVkX19wZyY+17ARE1PfFEo6WBdESwxco4naAKA=', '2023-08-02 14:07:43', 0, 14, NULL, 'kristina', '1690978063'),
(111, 'U2FsdGVkX19h+IaqGiiUllOBtj8KVY/O2jI71gx3j14=', '2023-08-02 14:07:52', 0, 14, NULL, 'kristina', '1690978072'),
(112, 'U2FsdGVkX19O+S2MqoWlWrkWA4StMRwjDT3uJXbUTSI=', '2023-08-02 14:09:01', 0, 14, NULL, 'kristina', '1690978141'),
(113, 'U2FsdGVkX1+lZNIv34Tful65iwAIOTqBtk1dqVjy95E=', '2023-08-02 14:09:17', 0, 14, NULL, 'kristina', '1690978157'),
(114, 'U2FsdGVkX19DmIfgK5J1OCaZW8D6aLOT5/hmlocD464=', '2023-08-02 14:09:58', 0, 14, NULL, 'kristina', '1690978198'),
(115, 'U2FsdGVkX1/phj7AIC3aUfiSBz+XBFNicyXfXGY5dt0=', '2023-08-02 14:11:04', 0, 14, NULL, 'kristina', '1690978264'),
(116, 'U2FsdGVkX1+qrE+RCdMpBku/p3Us1fy5hNgHJhq2OLk=', '2023-08-02 14:11:47', 0, 14, NULL, 'kristina', '1690978307'),
(117, 'U2FsdGVkX1+y177HZTQQOr6WfQ6kLXAwGEgrRIuVYGw=', '2023-08-02 14:12:04', 0, 14, NULL, 'awesome', '1690978324'),
(118, 'U2FsdGVkX1/J4fRlXijdIBbn+Oxg3D1WAxn9BWNRFEA=', '2023-08-02 14:14:03', 0, 14, NULL, 'kristina', '1690978443'),
(119, 'U2FsdGVkX1/Oq8+wLxNxgdTyqP/3CKUPWNqXlUGBCwA=', '2023-08-02 14:16:14', 0, 14, NULL, 'kristina', '1690978574'),
(120, 'U2FsdGVkX1+k9+DkgJJTXLxbYR8UT76cn5peAEXmExU=', '2023-08-02 14:16:44', 0, 14, NULL, 'kristina', '1690978604'),
(121, 'U2FsdGVkX18sFPfB+DB72ZFWcDrma2rZcI9GfZ9tPfg=', '2023-08-02 14:18:33', 0, 14, NULL, 'kristina', '1690978713'),
(122, 'U2FsdGVkX1/C/3bb1lKSm7bfaiCZa7JBOmX6gHNtWlg=', '2023-08-02 14:18:41', 0, 14, NULL, 'kristina', '1690978721'),
(123, 'U2FsdGVkX189NrwyDk29k9mrrD57L5RBTf4xGJRo62I=', '2023-08-02 14:19:00', 0, 14, NULL, 'kristina', '1690978740'),
(124, 'U2FsdGVkX1+O/Rle7YiTehfV4Lsqyzz6vu0SCUu0Ogg=', '2023-08-02 14:19:19', 0, 14, NULL, 'kristina', '1690978759'),
(125, 'U2FsdGVkX1943uYmmBVBRAVkKfIqrA8vmbbGlHQooX0=', '2023-08-02 16:29:41', 0, 14, NULL, 'kristina', '1690986581'),
(126, 'U2FsdGVkX1/5XADWNrEhE/SJZpmcPGY4P6SrgldwYo0=', '2023-08-02 16:34:35', 0, 14, NULL, 'kristina', '1690986875'),
(127, 'U2FsdGVkX1+VCjGfKRMxtUrCewgod5rjLjA+8IVJJnI=', '2023-08-02 16:34:50', 0, 14, NULL, 'kristina', '1690986890'),
(128, 'U2FsdGVkX1+I/8kAPbKG4mO66Yv/7pOn3zNFiFsXv2E=', '2023-08-02 16:35:24', 0, 14, NULL, 'kristina', '1690986924'),
(129, 'U2FsdGVkX18pHoBV4OAOfRgaIGo2wMFVg2chnPgbVv4=', '2023-08-02 16:36:01', 0, 14, NULL, 'kristina', '1690986961'),
(130, 'U2FsdGVkX19cYbcAe0n20lhvLcdWZR88OaWzkH8s/KY=', '2023-08-02 16:39:24', 0, 14, NULL, 'kristina', '1690987164'),
(131, 'U2FsdGVkX1+JN3wsvrOG+9ISfbba929j8tJsPwZnooQ=', '2023-08-02 16:41:11', 0, 14, NULL, 'awesome', '1690987271'),
(132, 'U2FsdGVkX1+gHsJ2Q9yFOZuCR90NBRTOedlRBPTqfjg=', '2023-08-02 16:44:49', 0, 14, NULL, 'awesome', '1690987489'),
(133, 'U2FsdGVkX1/uZJkh151Z7VPfTxMNJu9DjwAFvBZLJeY=', '2023-08-02 16:46:15', 0, 14, NULL, 'kristina', '1690987575'),
(134, 'U2FsdGVkX19/LHhyvLqdJH8coTnA/VYtuQFPZ3dlQsI=', '2023-08-02 16:47:08', 0, 14, NULL, 'awesome', '1690987628'),
(135, 'U2FsdGVkX18vZ5B7JBdCuWx1FsD/0u30vwbxKtDBAEs=', '2023-08-02 16:47:36', 0, 14, NULL, 'awesome', '1690987656'),
(136, 'U2FsdGVkX187Kg+oElojGqk/sB5Oc+G9hlJgaL6iOCY=', '2023-08-02 16:47:57', 0, 14, NULL, 'awesome', '1690987677'),
(137, 'U2FsdGVkX18rU+yMdLb/enXa01RK/jzqmjOsrCsHIy8=', '2023-08-02 16:49:05', 0, 14, NULL, 'awesome', '1690987745'),
(138, 'U2FsdGVkX18HQDt7UNqO2MRqkAxqMzltBz8gx0UPhTI=', '2023-08-02 16:49:48', 0, 14, NULL, 'kristina', '1690987788'),
(139, 'U2FsdGVkX19ujgSXxwauph6LKyc9fxtOAUBK5XdU3jU=', '2023-08-02 16:50:43', 0, 14, NULL, 'awesome', '1690987843'),
(140, 'U2FsdGVkX18tqpXRfyn9tV8plYCd77I7fQMdNJmt8zs=', '2023-08-02 16:52:32', 0, 14, NULL, 'awesome', '1690987952'),
(141, 'U2FsdGVkX18ocDgVH4McgBoOR0GgFO+YmLtV71ULP1M=', '2023-08-03 16:46:24', 0, 24, NULL, 'leon', '1691073984'),
(142, 'U2FsdGVkX19KniAVpRVVFRxatuUT1QlZKxNJzm3Pgwg=', '2023-08-03 16:49:31', 0, 24, NULL, 'leon', '1691074171'),
(143, 'U2FsdGVkX18IthXNCaIIgJTHYtrVnpFXrGg5Ge4/NCg=', '2023-08-03 16:49:58', 0, 24, NULL, 'leon', '1691074198'),
(144, 'U2FsdGVkX19PbZRNsZV7k45jAg916YIEsxCRTzZ77hE=', '2023-08-03 16:53:25', 0, 24, NULL, 'leon', '1691074405'),
(145, 'U2FsdGVkX18PKCwdeVbMyU1zNmMwTGCPrwme3v+eQxM=', '2023-08-03 16:53:33', 0, 24, NULL, 'leon', '1691074413'),
(146, 'U2FsdGVkX1+fl8d69j0YMKdDAH6z36BIjdK+D5jqQFo=', '2023-08-03 16:54:15', 0, 24, NULL, 'leon', '1691074455'),
(147, 'U2FsdGVkX19tm09gz3lnEeFVkodHbL5J3rHIH9kp42o=', '2023-08-03 16:54:18', 0, 24, NULL, 'leon', '1691074458'),
(148, 'U2FsdGVkX19+oQXNKmIF7yhcUyoZX/jA7l+As+SYyP8=', '2023-08-03 16:54:26', 0, 24, NULL, 'leon', '1691074466'),
(149, 'U2FsdGVkX18uzlMddZEi+NwTgcpGnFo76a23raOnPxw=', '2023-08-03 16:54:39', 0, 24, NULL, 'leon', '1691074479'),
(150, 'U2FsdGVkX19rj3GSNcGbIJPlHrzkr3Zj99rL5j7vA5o=', '2023-08-03 16:54:50', 0, 24, NULL, 'leon', '1691074490'),
(151, 'U2FsdGVkX19H0afEk+hYsqjVE+PjWxWQHUNzfhFwRK4=', '2023-08-03 17:09:40', 0, 25, NULL, 'leon', '1691075380'),
(152, 'U2FsdGVkX19XHEk8RzAEDIwrSrFHJuIE1ILSjFeQ7fI=', '2023-08-04 08:42:44', 0, 27, NULL, 'leon', '1691131364'),
(153, 'U2FsdGVkX1/AdNh63Vv3jMmvhPSejcEdqe/FBtp5xys=', '2023-08-07 13:12:49', 0, 25, NULL, 'leon', '1691406769'),
(154, 'U2FsdGVkX19lVvnUHVologNYPDsLP3EhlbWdFG9zNtk=', '2023-08-07 13:13:02', 0, 25, NULL, 'leon', '1691406782'),
(156, 'U2FsdGVkX19vBmS7L1j5Ict7c9L0jmG8JlHDqeq9oZQ=', '2023-08-07 13:15:03', 0, 28, NULL, 'awesome', '1691406903'),
(157, 'U2FsdGVkX18Boy3YMCJ1C7NcbDDxTirIxXg70q/Ki0k=', '2023-08-07 13:15:33', 0, 28, NULL, 'awesome', '1691406933'),
(158, 'U2FsdGVkX19Mv1kUtHPgQUCWxIGWmYKF/mDZ5t/u99M=', '2023-08-07 13:15:53', 0, 29, NULL, 'awesome', '1691406953'),
(159, 'U2FsdGVkX1/c7ZM/olbeUx50Fb+wR9ffcvJhLAyNBWI=', '2023-08-07 13:17:24', 0, 28, NULL, 'awesome', '1691407044'),
(160, 'U2FsdGVkX1+Kp1Xg/vvY2ITgptlFivlizApdFIltKXQ=', '2023-08-07 13:17:33', 0, 28, NULL, 'awesome', '1691407053'),
(161, 'U2FsdGVkX18gnPyHm7R0JagWyUT632nOoBN8dyMTR1M=', '2023-08-07 13:17:59', 0, 28, NULL, 'awesome', '1691407079'),
(162, 'U2FsdGVkX18HDT79J9VJVf1CEpwE2wBtmDdXIP30CD4=', '2023-08-07 13:18:36', 0, 27, NULL, 'awesome', '1691407116'),
(165, 'U2FsdGVkX1/lHt4aI8I3wPaNhnFBcre2oANAHOxRrnA=', '2023-08-07 13:18:58', 0, 28, NULL, 'awesome', '1691407138'),
(167, 'U2FsdGVkX1/Plki+ix0/EO2Ukch5gnPW9StEyUCVaUc=', '2023-08-07 13:20:52', 0, 27, NULL, 'awesome', '1691407252'),
(168, 'U2FsdGVkX19qPZg9yM7LmOsq8YERTvhmbttozA2WdVw=', '2023-08-07 13:20:57', 0, 27, NULL, 'awesome', '1691407257'),
(169, 'U2FsdGVkX1/W2uYgukPdoYSSg490mnRDchygUWZAI/Y=', '2023-08-07 13:21:42', 0, 29, NULL, 'awesome', '1691407302'),
(170, 'U2FsdGVkX1+q4AOxbbERkaBFtnB/A8oanLL/RgMZvhI=', '2023-08-07 13:22:10', 0, 27, NULL, 'awesome', '1691407330'),
(171, 'U2FsdGVkX1+m5CvFw7nFFJ3fUxltHTQVzn1AhuA2S5g=', '2023-08-07 13:22:29', 0, 28, NULL, 'awesome', '1691407349'),
(172, 'U2FsdGVkX183/NQL89JHZ9O/1MxadD9/AygOa11ABH0=', '2023-08-07 13:22:40', 0, 29, NULL, 'awesome', '1691407360'),
(174, 'U2FsdGVkX19+jwzHu5vxGLtaB+JiDsLwvnmY63ZO/co=', '2023-08-07 13:22:50', 0, 28, NULL, 'awesome', '1691407370'),
(175, 'U2FsdGVkX1/48l6wHzmqya8E8YeZznFQ0vsq2aleMFI=', '2023-08-07 14:27:43', 0, 29, NULL, 'awesome', '1691411263'),
(176, 'U2FsdGVkX19QVWHLe0n3Bmm5Mm7Ew6vJsrsE+j9XlpM=', '2023-08-07 14:28:13', 0, 29, NULL, 'kristina', '1691411293'),
(177, 'U2FsdGVkX18CLksDA2sk8Fr4SlweWdDKaoDgzgp/0EQ=', '2023-08-07 16:40:58', 0, 29, NULL, 'awesome', '1691419258'),
(178, 'U2FsdGVkX1/d4cYbpXYc8bU2INm7r59Dz03nnzoJpPY=', '2023-08-08 09:49:50', 0, 28, NULL, 'awesome', '1691480990'),
(179, 'U2FsdGVkX18OTMRjkMYU+G2z5XGb5FYLshfz2pwBx/k=', '2023-08-08 10:17:20', 0, 29, NULL, 'kristina', '1691482640'),
(180, 'U2FsdGVkX18EJ5Kf4DbH/8wDNjzW7fkG68eVKMjipE4=', '2023-08-08 10:18:16', 0, 29, NULL, 'kristina', '1691482696'),
(181, 'U2FsdGVkX1/jIRm//epRJHdP9IUXfkWXc8SENGp9OJ4=', '2023-08-08 10:20:02', 0, 29, NULL, 'kristina', '1691482802'),
(182, 'U2FsdGVkX1/mrTndWtlor7DDAcd+ebMcty8VkTKb4WQ=', '2023-08-08 10:22:32', 0, 29, NULL, 'kristina', '1691482952'),
(183, 'U2FsdGVkX18A7XLbd+nug9OTJ8Z+VGrRC7W2bsQL3/4=', '2023-08-08 10:24:14', 0, 29, NULL, 'kristina', '1691483054'),
(184, 'U2FsdGVkX1/weei1G3+JAHe4IIWI8nI8Jrt1Ao1Mar0=', '2023-08-08 10:24:23', 0, 29, NULL, 'kristina', '1691483063'),
(185, 'U2FsdGVkX19YlfKUOVqBOxd0QLn7Z0mcAQn/i1wRC5c=', '2023-08-08 10:26:21', 0, 29, NULL, 'kristina', '1691483181'),
(186, 'U2FsdGVkX19CvL9rwg+TijGzEJ94Ip7Q8kSjDGtNwgE=', '2023-08-08 10:26:37', 0, 29, NULL, 'kristina', '1691483197');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `public_key` text NOT NULL,
  `private_key` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_login` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `public_key`, `private_key`, `created_at`, `last_login`, `user_type`) VALUES
(45, 'leon', '$2y$10$04Qr5uJnHqyvrld9R2nDY.09gwjwhv9E91NTja5ovc0aHUyvczpJ6', 'fe8472e3dfd536e76dc04ea8c05d953d3a30ebe6d4051c52184f80cbd8b9fa3f', '15e667e72b26dc3f7758d563f81c29ad646251e7c56e92c47be8d0e444e50675', '2023-07-31 15:09:24', '2023-07-31 15:09:24', NULL),
(48, 'awesome', '$2y$10$ShXP2LTMIdp7BQJI4kbc.O6KfykEny5R/NGQxII/5b.oCWS16AYhS', 'e66327db7405f75acda403766724d64a29998e3cedafc1b778f9b4237fa45554', '4577338e7661f0722b805bd2ec29e2a836c0a8d8c19fabeb2850c0e6d9f7643a', '2023-08-01 10:28:59', '2023-08-01 10:28:59', NULL),
(49, 'kristina', '$2y$10$AZuAFvAJO4tQNmrzKQQIiOR.Z/hTF9q8dxrRjA/ANPZFDMQM5X.be', '9a19f887f774674e2422a95f80d6794d7e8c8c01be331587ed2e4ff3d4e52121', 'b679cc4faaff6c14a6b12a537523d62d9dab79ec18edca96f1da9e3bc6d98caa', '2023-08-01 11:14:32', '2023-08-01 11:14:32', NULL),
(50, 'admin', '$2y$10$nFOym5jlI0TRFhLZIGEu6eOMUKmlkezYCGDA3XtlHrX4CRadQZgRy', '98a7fe06cc80869b9831c4f43a47dd463a71d4b49d752e10014dd513bc71717b', '9a4eb310a207b505c5361b1052a6ab29d34bb0ec58c74291204cad6b134cb0bd', '2023-08-09 06:56:04', '2023-08-09 06:56:04', 'admin'),
(51, 'testUser', '$2y$10$0mEj7xPwThCRfxvQr0HLIe1x9023tIkeaOIizMLN7YyMdyHKbi.ae', 'e8860465c2a4d2de05f64e98531ce09766237c948e6aa12c1fa1a1a1c311d058', 'a75499e86220cb48ad683820396d36c3c52c587b58d4cbaac2e2df0c9ef8aa59', '2023-08-10 05:56:49', '2023-08-10 05:56:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_conversations`
--

CREATE TABLE `user_conversations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `conversation_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_conversations`
--

INSERT INTO `user_conversations` (`id`, `user_id`, `conversation_id`) VALUES
(12, 45, 24),
(13, 48, 24),
(14, 45, 25),
(15, 13, 25),
(16, 45, 26),
(17, 49, 26),
(18, 45, 27),
(19, 48, 27),
(20, 48, 28),
(21, 13, 28),
(22, 48, 29),
(23, 49, 29),
(24, 49, 30),
(25, 13, 30),
(26, 49, 31),
(27, 50, 31),
(28, 48, 32),
(29, 50, 32),
(30, 48, 33),
(31, 51, 33);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `conversation_id` (`conversation_id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_user_username` (`username`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_username` (`username`);

--
-- Indexes for table `user_conversations`
--
ALTER TABLE `user_conversations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `conversation_id` (`conversation_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=191;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `user_conversations`
--
ALTER TABLE `user_conversations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
