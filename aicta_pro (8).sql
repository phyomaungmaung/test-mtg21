-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 21, 2021 at 05:05 AM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aicta_pro`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fax` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company_profile` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `ceo_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ceo_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_position` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `product_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `product_description` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `product_uniqueness` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `product_quality` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `product_market` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `business_model` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` enum('draft','pending','accepted','review','finalize','comment') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'draft',
  `video_demo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `approved_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `abbreviation` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `abbreviation`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Public Sector', 'PUB', NULL, NULL, NULL),
(2, 'Private Sector', 'PRV', NULL, NULL, NULL),
(3, 'Corporate Social Responsible', 'CSR', NULL, NULL, NULL),
(4, 'Digital Content', 'DLC', NULL, NULL, NULL),
(5, 'Start-up Company', 'STC', NULL, NULL, NULL),
(6, 'Research and Development', 'RND', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `category_user`
--

CREATE TABLE `category_user` (
  `category_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `country_id` int(10) UNSIGNED NOT NULL,
  `type` enum('candidate','semi','final','other') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'semi',
  `num_form` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `comment` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `commented_on` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `meta_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `commented_by` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('comment','reviewed','achieved') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'comment',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `comment`, `commented_on`, `meta_key`, `commented_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 'This application will approve to the preliminary judge', 'register_form', '123', '225', 'comment', '2021-03-16 21:19:17', '2021-03-16 21:19:17'),
(2, 'this application will proceed to preliminary judge', 'register_form', '124', '225', 'comment', '2021-03-16 21:21:13', '2021-03-16 21:21:13'),
(3, 'complete the product description', 'register_form', '140', '237', 'comment', '2021-04-11 01:48:29', '2021-04-11 01:48:29'),
(4, 'demo  - changes video', 'register_form', '140', '237', 'comment', '2021-04-11 01:49:00', '2021-04-11 01:49:00'),
(5, 'please conyinue fill in form ASAP', 'register_form', '147', '261', 'comment', '2021-05-16 23:42:54', '2021-05-16 23:42:54'),
(6, 'COMPANY PROFILE...PLEASE EXPLAIN MORE DETAIL ABOUT YOUR COMPANY', 'register_form', '147', '205', 'comment', '2021-05-16 23:48:00', '2021-05-16 23:48:00'),
(7, 'please detail out about your product description', 'register_form', '146', '261', 'comment', '2021-05-17 00:04:15', '2021-05-17 00:04:15'),
(8, 'Please take note Brunei Representer 1, the product BruneiICT is suitable for  Digital Content Category not for Public Category. Please change it', 'register_form', '146', '205', 'comment', '2021-05-17 00:09:48', '2021-05-17 00:09:48');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bref` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `flag` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `bref`, `flag`, `created_at`, `updated_at`) VALUES
(4, 'LAOS', 'LAOS', 'images/flag/75px-Flag_of_Laos.svg.png', NULL, '2021-04-05 00:16:47'),
(5, 'MALAYSIA', 'MALAYSIA', 'images/flag/75px-Flag_of_Malaysia.svg.png', '2021-03-01 00:12:09', '2021-04-05 00:19:41'),
(6, 'THAILAND', 'THAILAND', 'images/flag/THAI.png', '2021-03-01 00:19:54', '2021-04-05 00:17:40'),
(7, 'INDONESIA', 'INDON', 'images/flag/75px-Flag_of_Indonesia.svg.webp', '2021-03-17 16:02:19', '2021-04-05 00:14:41'),
(8, 'BRUNEI', 'BRUNEI', 'images/flag/75px-Flag_of_Brunei.svg.png', '2021-04-05 00:13:44', '2021-04-05 00:13:44'),
(9, 'CAMBODIA', 'CAMBODIA', 'images/flag/75px-Flag_of_Cambodia.svg.png', '2021-04-05 00:16:06', '2021-04-05 00:16:06'),
(10, 'MYANMAR', 'MYANMAR', 'images/flag/75px-Flag_of_Myanmar.svg.png', '2021-04-05 00:20:18', '2021-04-05 00:20:18'),
(11, 'PHILIPPINES', 'PHILIPPINES', 'images/flag/Flag_of_the_Philippines.svg.png', '2021-04-05 00:21:13', '2021-04-05 00:21:13'),
(12, 'SINGAPORE', 'SINGAPORE', 'images/flag/75px-Flag_of_Singapore.svg.png', '2021-04-05 00:21:51', '2021-04-05 00:21:51'),
(13, 'VIETNAM', 'VIETNAM', 'images/flag/75px-Flag_of_Vietnam.svg.png', '2021-04-05 00:22:27', '2021-04-05 00:22:27');

-- --------------------------------------------------------

--
-- Table structure for table `final_judges`
--

CREATE TABLE `final_judges` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `status` int(10) UNSIGNED DEFAULT 1,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `type` enum('semi','final') COLLATE utf8_unicode_ci NOT NULL,
  `in` double(8,2) UNSIGNED DEFAULT 0.00,
  `ps` double(8,2) UNSIGNED DEFAULT 0.00,
  `pv` double(8,2) UNSIGNED DEFAULT 0.00,
  `ti` double(8,2) UNSIGNED DEFAULT 0.00,
  `ef` double(8,2) UNSIGNED DEFAULT 0.00,
  `pm` double(8,2) UNSIGNED DEFAULT 0.00,
  `qt` double(8,2) UNSIGNED DEFAULT 0.00,
  `rt` double(8,2) UNSIGNED DEFAULT 0.00,
  `op` double(8,2) UNSIGNED DEFAULT 0.00,
  `en` double(8,2) UNSIGNED DEFAULT 0.00,
  `ms` double(8,2) UNSIGNED DEFAULT 0.00,
  `ca` double(8,2) UNSIGNED DEFAULT 0.00,
  `cu` double(8,2) UNSIGNED DEFAULT 0.00,
  `fi` double(8,2) UNSIGNED DEFAULT 0.00,
  `me` double(8,2) UNSIGNED DEFAULT 0.00,
  `sc` double(8,2) UNSIGNED DEFAULT 0.00,
  `tm` double(8,2) UNSIGNED DEFAULT 0.00,
  `sh` double(8,2) UNSIGNED DEFAULT 0.00,
  `total` double(8,2) UNSIGNED DEFAULT 0.00,
  `num_star` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guidelines`
--

CREATE TABLE `guidelines` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('enabled','disabled','achieved') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'enabled',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `guidelines`
--

INSERT INTO `guidelines` (`id`, `role_id`, `title`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, 'Candidate', '<p><strong>Candidate Role Can do the following features:</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<ol>\r\n	<li>Entry the form:&nbsp; &nbsp;\r\n	<ul>\r\n		<li>The fom&nbsp; is seperated in to 6 steps(tabs) and&nbsp;&nbsp;candidate have to fill all information before submit.&nbsp;</li>\r\n		<li>\r\n		<p>Candidate can file some infomation and keep some&nbsp;infomation to fill next time by go to last tab( last step) then click on button &quot;save&quot; or click on button &quot;Save and continue&quot; in each steps. (check image below)</p>\r\n		</li>\r\n		<li>\r\n		<p>Candidate have to click on button &quot;Submit Final&quot; so that application will submit to&nbsp;country representer to review.&nbsp;</p>\r\n		</li>\r\n		<li>\r\n		<p>The form that submit final will not able edit unless Country Representer give some comment to update before daedline.&nbsp;</p>\r\n		</li>\r\n		<li>\r\n		<p>Check image below to see the needed infoamtion in 6 steps:</p>\r\n\r\n		<ul>\r\n			<li>\r\n			<p>Step 1 : Company Detail&nbsp;</p>\r\n\r\n			<p><img alt=\"company detail\" src=\"/fmg/photos/shares/candidate1.png\" style=\"width:100%\" /> <img alt=\"\" src=\"/fmg/photos/shares/candidate2.png\" style=\"width:100%\" /></p>\r\n			</li>\r\n			<li>\r\n			<p>Step 2 : Contact person Detaiols</p>\r\n\r\n			<p><img alt=\"\" src=\"/fmg/photos/shares/candidate3.png\" style=\"width:100%\" /></p>\r\n			</li>\r\n			<li>\r\n			<p>Step 3 : Product Detail Part 1 &nbsp;</p>\r\n\r\n			<p><img alt=\"\" src=\"/fmg/photos/shares/candidate4.png\" style=\"width:100%\" /><img alt=\"\" src=\"/fmg/photos/shares/candidate5.png\" style=\"width:100%\" /></p>\r\n			</li>\r\n			<li>\r\n			<p>Step 4&nbsp; Product Detail Part 2 &nbsp;</p>\r\n\r\n			<p><img alt=\"\" src=\"/fmg/photos/shares/candidate6.png\" style=\"width:100%\" /><img alt=\"\" src=\"/fmg/photos/shares/candidate7.png\" style=\"width:100%\" /></p>\r\n			</li>\r\n			<li>\r\n			<p>Step 5: Video Demo Pro&nbsp;</p>\r\n\r\n			<p>Browse or Drag &amp; Drop the video demo about product&nbsp;</p>\r\n\r\n			<p><img alt=\"\" src=\"/fmg/photos/shares/candidate8.png\" style=\"width:100%\" /></p>\r\n			</li>\r\n			<li>\r\n			<p>Step 6 : Final</p>\r\n\r\n			<p>&nbsp;</p>\r\n\r\n			<p><img alt=\"\" src=\"/fmg/photos/shares/candidate9.png\" style=\"width:100%\" />&nbsp;</p>\r\n\r\n			<p>Remider:</p>\r\n\r\n			<ul>\r\n				<li>Save entry form as draft when you click on button &quot;save and continue&quot; in step 1 to step 5.</li>\r\n				<li>click on Submit Final if every onfomation is ready or click on save to save as draft.</li>\r\n				<li>Submit final form: Once you click on this button, you will not able to edit the entry form unless your application form has any comments from your country representer before dateline.\r\n				<p>&nbsp;</p>\r\n				</li>\r\n			</ul>\r\n			</li>\r\n		</ul>\r\n		</li>\r\n	</ul>\r\n	</li>\r\n	<li>Profile\r\n	<p>&nbsp;</p>\r\n\r\n	<ul>\r\n		<li>change password<img alt=\"\" src=\"/fmg/photos/shares/candidate10.png\" style=\"width:100%\" />&nbsp;&nbsp;</li>\r\n		<li>edit profile &nbsp;\r\n		<p><img alt=\"\" src=\"/fmg/photos/shares/candidate11.png\" style=\"width:100%\" /></p>\r\n		</li>\r\n	</ul>\r\n	</li>\r\n</ol>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>', 'enabled', '2019-06-17 08:55:58', '2021-04-09 00:19:59'),
(2, 3, 'Representer', '<p><strong>Representer &nbsp;Can the following features:</strong></p>\r\n\r\n<ol>\r\n	<li>Candidate:\r\n	<ul>\r\n		<li>List candidate : show all candidate in the representer&#39;s country check image bellow</li>\r\n	</ul>\r\n	</li>\r\n</ol>\r\n\r\n<p><img alt=\"\" src=\"/fmg/photos/shares/606d2f0b4b319.JPG\" style=\"width:100%\" /></p>\r\n\r\n<ul>\r\n	<li>Create candidate : There is a button &quot;New Candidate&quot; in the image of list candidate, click on the button it will show a form as image bellow&nbsp;to create new candidate then fill all infomation and click on button &quot;save&quot; , a new candicate will created.&nbsp;</li>\r\n</ul>\r\n\r\n<p><img alt=\"\" src=\"/fmg/photos/shares/606d347e3bb0c.JPG\" style=\"width:100%\" /></p>\r\n\r\n<ul>\r\n	<li>Edit Candidate :&nbsp;There is a button with icon pencil&nbsp;in each row of table of image of list candidates, click on the button it will show a form as image bellow&nbsp;to create edit candidate then update&nbsp;information and click on button &quot;save&quot; , the&nbsp;candidate will update.</li>\r\n</ul>\r\n\r\n<p><img alt=\"\" src=\"/fmg/photos/shares/606d3528c1d03.JPG\" style=\"width:100%\" /></p>\r\n\r\n<ul>\r\n	<li>Delete candidate :&nbsp;There is a button with icon trash&nbsp;in each row of table of image of list candidates, click on the button it will show a popup alert as image bellow&nbsp;to confirm delete candidate. Click on button &quot;Yes, delete&quot; to Delete candidate or click on icon &quot;No, Cancel&quot; to cancel deleting.</li>\r\n</ul>\r\n\r\n<p><big>&nbsp; &nbsp; &nbsp;Note</big>: Candidate can be delete only when candidate never fill the application form, otherwise&nbsp;Country representer have to contact the admin to delete.</p>\r\n\r\n<p><img alt=\"\" src=\"/fmg/photos/shares/606d4dd44b442.JPG\" style=\"width:100%\" /></p>\r\n\r\n<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 2.&nbsp; Judge</p>\r\n\r\n<ul>\r\n	<li>List all judges<img alt=\"\" src=\"/fmg/photos/shares/representerjudge.png\" style=\"width:100%\" /></li>\r\n	<li>Create Judge</li>\r\n	<li>Edit Judge</li>\r\n	<li>Delete Judge</li>\r\n</ul>\r\n\r\n<p>&nbsp; &nbsp; &nbsp; &nbsp;3.&nbsp; &nbsp;Application</p>\r\n\r\n<ul>\r\n	<li>List application: Show all application that candidate submit&nbsp;in the representer&#39;s country. There are 2 tabs,&nbsp;which Form Submitted and Form Accepted as follow:</li>\r\n</ul>\r\n\r\n<p><img alt=\"\" src=\"fmg/photos/shares/606d50b839c23.JPG\" style=\"width:100%\" /><img alt=\"listapplication\" src=\"/fmg/photos/shares//606d50b839c23.JPG\" style=\"width:100%\" /></p>\r\n\r\n<ul>\r\n	<li>View application: In each row of table in list application there is button with icon &quot;sandwich&quot; or list&nbsp;&nbsp;then click on the icon to review the information that candidate fill. There are 6 tabs of information to view and representer can be either click tab icon or button next to view other tabs of information. Representer can also comment or feedback the application on the right side,&nbsp;check images all tabs bellow:&nbsp;</li>\r\n</ul>\r\n\r\n<p><img alt=\"\" src=\"/fmg/photos/shares/viewappcandidate.JPG\" style=\"width:100%\" /></p>\r\n\r\n<p><img alt=\"\" src=\"/fmg/photos/shares/step2apps.JPG\" style=\"width:100%\" /></p>\r\n\r\n<p><img alt=\"\" src=\"/fmg/photos/shares/step3app.JPG\" style=\"width:100%\" /></p>\r\n\r\n<p><img alt=\"\" src=\"/fmg/photos/shares/step4app.JPG\" style=\"width:100%\" /></p>\r\n\r\n<p><img alt=\"\" src=\"/fmg/photos/shares/step5app.JPG\" style=\"width:100%\" /></p>\r\n\r\n<ul>\r\n	<li>Accept application :&nbsp;In each row of table in list application there is button with icon &quot;check&quot; then click on the icon(button), it will show an alert popup&nbsp; to confirm&nbsp;accept application&nbsp;for asean judging list (online judging list or semi final judging list), if click button &quot; Yes, accept&quot; application goes to ASEAN list otherwise&nbsp;click on button &quot;No, cancel&quot; . <strong>Be warning , </strong>once an application accepted Representer will not abled to see application anymore.</li>\r\n	<li><strong>Be warning , </strong>once an application accepted, Representer will not be able&nbsp;to see application of the applicant in the Form Submitted Application List.</li>\r\n</ul>\r\n\r\n<p><img alt=\"\" src=\"/fmg/photos/shares/accept.JPG\" style=\"width:100%\" /></p>\r\n\r\n<p>&nbsp; &nbsp; &nbsp; &nbsp;6. Profile</p>\r\n\r\n<ul>\r\n	<li>&nbsp;&nbsp;View profile</li>\r\n</ul>\r\n\r\n<p><img alt=\"\" src=\"/fmg/photos/shares/profilerepresenter.JPG\" style=\"width:100%\" /></p>\r\n\r\n<ul>\r\n	<li>Edit Profile</li>\r\n</ul>\r\n\r\n<p><img alt=\"\" src=\"/fmg/photos/shares/editprofile.JPG\" style=\"width:100%\" /></p>\r\n\r\n<ul>\r\n	<li>Change Password</li>\r\n</ul>\r\n\r\n<p><img alt=\"\" src=\"/fmg/photos/shares/chgpwd.JPG\" style=\"width:100%\" /></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>', 'enabled', '2019-06-17 08:57:05', '2021-04-15 00:02:04'),
(3, 1, 'Guideline for Admin', '<p>Admin Role Can use the follow feature:</p>\r\n\r\n<ol>\r\n	<li>User\r\n	<ul>\r\n		<li>List all users: Users can be Admin or Representer<img alt=\"\" src=\"/fmg/photos/shares/admin1.png\" style=\"width:100%\" /></li>\r\n		<li>Create new user:&nbsp;There is a button &quot;New User&quot; in the image of list users, click on the button it will show a form as image bellow&nbsp;to create new user then fill all infomation and click on button &quot;save&quot; , a new user will create.&nbsp;<img alt=\"\" src=\"/fmg/photos/shares/admin2.png\" style=\"width:100%\" /></li>\r\n		<li>Edit user :There is a button with icon pencil&nbsp;in each row of table of image of list users, click on the button it will show a form as image bellow&nbsp;to create edit user then update&nbsp;infomation and click on button &quot;save&quot; , the&nbsp;user will update.<img alt=\"\" src=\"/fmg/photos/shares/admin3.png\" style=\"width:100%\" /></li>\r\n		<li>Delete user:&nbsp;There is a button with icon trash&nbsp;in each row of table of image of list users, click on the button it will show a popup alert as image bellow&nbsp;to confirm delete user. click on button &quot;Yes, delete&quot; to Delete user or click on icon &quot;No, Cancel&quot; to cancel deleting.&nbsp;<img alt=\"\" src=\"/fmg/photos/shares/admin4.png\" style=\"width:100%\" /></li>\r\n	</ul>\r\n	</li>\r\n	<li>Candiate&nbsp;\r\n	<ul>\r\n		<li>List all Candidates :&nbsp;show all candidate in the system check image bellow<img alt=\"\" src=\"/fmg/photos/shares/admin5.png\" style=\"width:100%\" /></li>\r\n		<li>Create new candidate :&nbsp;There is a button &quot;New Candidate&quot; in the image of list candidate, click on the button it will show a form as image bellow&nbsp;to create new candiate then fill all infomation and click on button &quot;save&quot; , a new candiate will created.&nbsp;<img alt=\"\" src=\"/fmg/photos/shares/admin6.png\" style=\"width:100%\" /></li>\r\n		<li>Edit candidate:&nbsp;There is a button with icon pencil&nbsp;in each row of table of image of list candidates, click on the button it will show a form as image bellow&nbsp;to create edit candiate then update&nbsp;infomation and click on button &quot;save&quot; , the&nbsp;candiate will update.<img alt=\"\" src=\"/fmg/photos/shares/admin7.png\" style=\"width:100%\" /></li>\r\n		<li>Delete candidate:&nbsp;There is a button with icon trash&nbsp;in each row of table of image of list candidates, click on the button it will show a popup alert as image bellow&nbsp;to confirm delete candiate. click on button &quot;Yes, delete&quot; to Delete candiate or click on icon &quot;No, Cancel&quot; to cancel deleting.&nbsp;<strong><big>Note</big></strong>: Delete candidate carefully or use this function only if country representer request.<img alt=\"\" src=\"/fmg/photos/shares/admin8.png\" style=\"width:100%\" /></li>\r\n	</ul>\r\n	</li>\r\n	<li>Judge\r\n	<ul>\r\n		<li>List all jusges<img alt=\"\" src=\"/fmg/photos/shares/admin9.png\" style=\"width:100%\" /></li>\r\n		<li>Create Judge</li>\r\n		<li>Edit Judge</li>\r\n		<li>Delete Judge</li>\r\n	</ul>\r\n	</li>\r\n	<li>Application\r\n	<ul>\r\n		<li>List all applications<img alt=\"\" src=\"/fmg/photos/shares/admin10.png\" style=\"width:100%\" /></li>\r\n		<li>Review application : just the same as representer Guideline please check Representer Guidline.</li>\r\n		<li>Review Video demo: watch video demo without view any other information by click on icon play in each row that video availible. Image bellow it the screen of video demo.<img alt=\"\" src=\"/fmg/photos/shares/admin11.png\" style=\"width:100%\" /></li>\r\n		<li>Accept application :&nbsp; just the same as representer Guideline please check Representer Guidline.</li>\r\n	</ul>\r\n	</li>\r\n	<li>Asean Application\r\n	<ul>\r\n		<li>List application : all application that is accepted will availible here.</li>\r\n		<li>view video: just the same as link video of application list</li>\r\n	</ul>\r\n	</li>\r\n	<li>Profile&nbsp;\r\n	<ul>\r\n		<li>View profile:&nbsp;Generaly , system will open profile page after login. if you are at other page then you can click on peofile menu on the left menu.&nbsp; on page profile, you can edit profile by click button &quot;edit Profile&quot; (check image below) then system will go to editable page.<img alt=\"\" src=\"/fmg/photos/shares/admin12.png\" style=\"width:100%\" /></li>\r\n		<li>Edite profile<img alt=\"\" src=\"/fmg/photos/shares/admin13.png\" style=\"width:100%\" /></li>\r\n		<li>Change password<img alt=\"\" src=\"/fmg/photos/shares/admin14.png\" style=\"width:100%\" /></li>\r\n	</ul>\r\n	</li>\r\n	<li>Setting : The configuration will be in the setting block, Example : SATART_JUDGING_DATE is the date that Judage of Online Judging can start to judge.\r\n	<ul>\r\n		<li>List Settings<img alt=\"\" src=\"/fmg/photos/shares/admin15.png\" style=\"width:100%\" /></li>\r\n		<li>Edit : Warning: Do not edit any settings if don&#39;t know what it does. Suggest edit the settings in type date only because admin may need to update a few setting related to date such as\r\n		<ul>\r\n			<li>When dateline of form summition</li>\r\n			<li>when judge can start to Judge the online Judging</li>\r\n			<li>when the dateline of online judging</li>\r\n			<li>when Final judge can judge</li>\r\n		</ul>\r\n		</li>\r\n		<li>Create: You can create any setting but it may&nbsp; useless&nbsp; or not affect to the system&nbsp;</li>\r\n		<li>Delete : Warning , Do not delete any existing setting , otherwhish the system may crush.</li>\r\n	</ul>\r\n	</li>\r\n</ol>\r\n\r\n<ul>\r\n	<li>&nbsp;</li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>', 'enabled', '2019-06-17 08:59:44', '2021-04-11 18:55:31'),
(4, 5, 'Judge', '<p><strong>Judge can do some following features:</strong></p>\r\n\r\n<ol>\r\n	<li><strong>Asean Application:</strong>\r\n\r\n	<ol>\r\n		<li><strong>&nbsp;</strong>This menu is for listing all the accepted application form of candidates that related to your&nbsp;responsibled categories.</li>\r\n		<li>&nbsp;There are two tabs as below:&nbsp;\r\n		<ul>\r\n			<li>Not yet Judge: It means that all the applications listed below are accepted by Representer Country but not yet judged by the judges.</li>\r\n		</ul>\r\n		</li>\r\n	</ol>\r\n	</li>\r\n</ol>\r\n\r\n<p><img alt=\"\" src=\"/fmg/photos/shares/notyetjudge.JPG\" style=\"width:100%\" /></p>\r\n\r\n<ul>\r\n	<li>Already Judged: Application list which had scores by the judges. Judges can edit the scores before deadline period by click the green icon for rejudge.</li>\r\n</ul>\r\n\r\n<p><img alt=\"\" src=\"/fmg/photos/shares/alreadyjudge.JPG\" style=\"width:100%\" /></p>\r\n\r\n<p>There are 3 actions that judge can do:</p>\r\n\r\n<ol>\r\n	<li><strong>Review application: </strong>First icon in the Action column. Judge can view&nbsp;application form details by the Applicant (Candidate).</li>\r\n</ol>\r\n\r\n<p><img alt=\"\" src=\"/fmg/photos/shares/reviewform.JPG\" style=\"width:100%\" /></p>\r\n\r\n<p>&nbsp; &nbsp; &nbsp; &nbsp;2.&nbsp;<strong>View Video:&nbsp;</strong>The second icon in the action column.&nbsp;Judge can view and play video of candidate.</p>\r\n\r\n<p><img alt=\"\" src=\"/fmg/photos/shares/video.JPG\" style=\"width:100%\" /></p>\r\n\r\n<p>&nbsp; &nbsp; &nbsp; &nbsp;3. <strong>Judge</strong>: The last icon in the activity column.&nbsp;Judge must provide score in the criteria box.</p>\r\n\r\n<p><img alt=\"\" src=\"/fmg/photos/shares/score.JPG\" style=\"width:100%\" />The&nbsp;criteria and details for judge, please check in the portal.</p>\r\n\r\n<p><strong>&nbsp; &nbsp; &nbsp; &nbsp;2. Result:&nbsp; </strong>There are 2 tabs which are Online Result and Final Result of online judging due to the date assigned.</p>\r\n\r\n<ul>\r\n	<li>Online Result : Example&nbsp;as follow:</li>\r\n</ul>\r\n\r\n<p><img alt=\"\" src=\"/fmg/photos/shares/onlineresult.JPG\" style=\"width:100%\" /></p>\r\n\r\n<ul>\r\n	<li>Final Result: Example as follow:</li>\r\n</ul>\r\n\r\n<p><img alt=\"\" src=\"/fmg/photos/shares/finalesult.JPG\" style=\"width:100%\" /><img alt=\"\" src=\"/fmg/photos/shares/finalresult.JPG\" style=\"width:100%\" /></p>\r\n\r\n<p><strong>&nbsp; &nbsp; &nbsp; 3. Guideline:&nbsp;</strong>Judge can see the guidline of responsible task of judge only.</p>\r\n\r\n<p><strong>&nbsp; &nbsp; &nbsp; 4. Profile:&nbsp;</strong>Judge can view and edit his own information.</p>\r\n\r\n<ul>\r\n	<li><strong>Edit Profile</strong>&nbsp;:</li>\r\n</ul>\r\n\r\n<p><img alt=\"\" src=\"/fmg/photos/shares/profilejudge.JPG\" style=\"width:100%\" /></p>\r\n\r\n<ul>\r\n	<li><strong>Change Password:&nbsp;</strong>Judge can change their password.</li>\r\n</ul>\r\n\r\n<p><img alt=\"\" src=\"/fmg/photos/shares/chgpwdjudge.JPG\" style=\"width:100%\" /></p>', 'enabled', '2019-07-23 13:23:32', '2021-04-07 22:51:47'),
(5, 6, 'Final Judging', '<p><strong>Final Judge can do some following features:</strong></p>\r\n\r\n<ol>\r\n	<li><strong>Final Judging:</strong>\r\n\r\n	<ol>\r\n		<li>\r\n		<p><strong>&nbsp;</strong>This menu is for listing all the application form of candidates that will be selected for first, second, and third place. You can also filter the form by category by choosing the category in the selection box.<img alt=\"\" src=\"/fmg/photos/shares/judge1.png\" style=\"width:100%\" /></p>\r\n		</li>\r\n		<li>In activity column there are 3 actions that judge can do:\r\n		<ol>\r\n			<li>\r\n			<p><strong>View Video:&nbsp;</strong>The first icon in the action column, Judge can view and play video of candidate.<img alt=\"\" src=\"/fmg/photos/shares/judge2.png\" style=\"width:100%\" /></p>\r\n			</li>\r\n			<li>\r\n			<p><strong>Review application:</strong> It is the second icon in the action column, Judge can view detail on information of application form.<img alt=\"\" src=\"/fmg/photos/shares/judge3.png\" style=\"width:100%\" /></p>\r\n			</li>\r\n			<li>\r\n			<p><strong>Judge:</strong> The last icon in the action column, Judge must provide score in the criteria box but not zero. The&nbsp;criteria for judging, please check in this link :&nbsp;<a href=\"https://aseanictaward.com/index.php/judging-guidelines/general-judging-criteria/\">https://aseanictaward.com/index.php/judging-guidelines/general-judging-criteria/</a>. During the process of providing score or after you submit the score, the medal will generate automatically. In one category judge cannot provide the same medal. If&nbsp;this case is happend, judge must change the score.<img alt=\"\" src=\"/fmg/photos/shares/judge4.png\" style=\"width:100%\" /></p>\r\n			</li>\r\n		</ol>\r\n		</li>\r\n	</ol>\r\n	</li>\r\n	<li><strong>Result:&nbsp;</strong>Judge can see the final result of final judging after the freez button is clicked by the administrator.</li>\r\n	<li><strong>Guidline:&nbsp;</strong>Judge can see the guidline of responsible task of final judge only.</li>\r\n	<li><strong>Profile:&nbsp;</strong>Judge can view and edit his own information.<img alt=\"\" src=\"/fmg/photos/shares/judge5.png\" style=\"width:100%\" /></li>\r\n	<li><strong>Change Password:&nbsp;</strong>Judge can change his/her&nbsp;own password.<img alt=\"\" src=\"/fmg/photos/shares/judge6.png\" style=\"width:100%\" /></li>\r\n</ol>', 'enabled', '2019-07-24 11:57:27', '2021-04-11 17:52:27');

-- --------------------------------------------------------

--
-- Table structure for table `judges`
--

CREATE TABLE `judges` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `status` int(10) UNSIGNED DEFAULT 1,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `type` enum('semi','final') COLLATE utf8_unicode_ci NOT NULL,
  `in` double(8,2) UNSIGNED DEFAULT 0.00,
  `ps` double(8,2) UNSIGNED DEFAULT 0.00,
  `pv` double(8,2) UNSIGNED DEFAULT 0.00,
  `ti` double(8,2) UNSIGNED DEFAULT 0.00,
  `ef` double(8,2) UNSIGNED DEFAULT 0.00,
  `pm` double(8,2) UNSIGNED DEFAULT 0.00,
  `qt` double(8,2) UNSIGNED DEFAULT 0.00,
  `rt` double(8,2) UNSIGNED DEFAULT 0.00,
  `op` double(8,2) UNSIGNED DEFAULT 0.00,
  `en` double(8,2) UNSIGNED DEFAULT 0.00,
  `ms` double(8,2) UNSIGNED DEFAULT 0.00,
  `ca` double(8,2) UNSIGNED DEFAULT 0.00,
  `cu` double(8,2) UNSIGNED DEFAULT 0.00,
  `fi` double(8,2) UNSIGNED DEFAULT 0.00,
  `me` double(8,2) UNSIGNED DEFAULT 0.00,
  `sc` double(8,2) UNSIGNED DEFAULT 0.00,
  `tm` double(8,2) UNSIGNED DEFAULT 0.00,
  `sh` double(8,2) UNSIGNED DEFAULT 0.00,
  `total` double(8,2) UNSIGNED DEFAULT 0.00,
  `num_star` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0000_00_00_000000_create_settings_table', 1),
(2, '2014_10_12_000000_create_users_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2015_05_06_194030_create_youtube_access_tokens_table', 1),
(5, '2019_04_22_020104_create_countries_table', 1),
(6, '2019_04_22_020327_add_id_country_users_table', 1),
(7, '2019_04_23_153201_add_column_token__user_table', 1),
(8, '2019_05_28_025730_create_applications_table', 1),
(9, '2019_05_28_026104_create_comments_table', 1),
(10, '2019_05_28_085334_create_permission_tables', 1),
(11, '2019_05_28_120104_create_guidelines_table', 1),
(12, '2019_05_30_154403_create_categories_table', 1),
(13, '2019_05_30_155121_create_category_user_table', 1),
(14, '2019_05_31_102116_create_videos_table', 1),
(16, '2019_06_06_100008_create_judges_table', 2),
(17, '2019_06_18_095829_create_results_table', 2),
(18, '2019_06_28_143214_result_stars', 2);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Entities\\User', 205),
(1, 'App\\Entities\\User', 302),
(3, 'App\\Entities\\User', 215),
(3, 'App\\Entities\\User', 225),
(3, 'App\\Entities\\User', 226),
(3, 'App\\Entities\\User', 236),
(3, 'App\\Entities\\User', 237),
(3, 'App\\Entities\\User', 261),
(3, 'App\\Entities\\User', 267),
(3, 'App\\Entities\\User', 268),
(3, 'App\\Entities\\User', 280),
(3, 'App\\Entities\\User', 281),
(3, 'App\\Entities\\User', 282),
(3, 'App\\Entities\\User', 283),
(3, 'App\\Entities\\User', 294),
(3, 'App\\Entities\\User', 303),
(4, 'App\\Entities\\User', 206),
(4, 'App\\Entities\\User', 210),
(4, 'App\\Entities\\User', 211),
(4, 'App\\Entities\\User', 212),
(4, 'App\\Entities\\User', 213),
(4, 'App\\Entities\\User', 214),
(4, 'App\\Entities\\User', 216),
(4, 'App\\Entities\\User', 218),
(4, 'App\\Entities\\User', 219),
(4, 'App\\Entities\\User', 220),
(4, 'App\\Entities\\User', 221),
(4, 'App\\Entities\\User', 222),
(4, 'App\\Entities\\User', 223),
(4, 'App\\Entities\\User', 224),
(4, 'App\\Entities\\User', 227),
(4, 'App\\Entities\\User', 228),
(4, 'App\\Entities\\User', 229),
(4, 'App\\Entities\\User', 235),
(4, 'App\\Entities\\User', 238),
(4, 'App\\Entities\\User', 241),
(4, 'App\\Entities\\User', 242),
(4, 'App\\Entities\\User', 243),
(4, 'App\\Entities\\User', 244),
(4, 'App\\Entities\\User', 245),
(4, 'App\\Entities\\User', 246),
(4, 'App\\Entities\\User', 247),
(4, 'App\\Entities\\User', 248),
(4, 'App\\Entities\\User', 258),
(4, 'App\\Entities\\User', 265),
(4, 'App\\Entities\\User', 270),
(4, 'App\\Entities\\User', 271),
(4, 'App\\Entities\\User', 272),
(4, 'App\\Entities\\User', 273),
(4, 'App\\Entities\\User', 274),
(4, 'App\\Entities\\User', 275),
(4, 'App\\Entities\\User', 276),
(4, 'App\\Entities\\User', 277),
(4, 'App\\Entities\\User', 278),
(4, 'App\\Entities\\User', 279),
(4, 'App\\Entities\\User', 284),
(4, 'App\\Entities\\User', 285),
(4, 'App\\Entities\\User', 286),
(4, 'App\\Entities\\User', 287),
(4, 'App\\Entities\\User', 288),
(4, 'App\\Entities\\User', 289),
(4, 'App\\Entities\\User', 290),
(4, 'App\\Entities\\User', 291),
(4, 'App\\Entities\\User', 292),
(4, 'App\\Entities\\User', 293),
(4, 'App\\Entities\\User', 295),
(4, 'App\\Entities\\User', 296),
(4, 'App\\Entities\\User', 297),
(4, 'App\\Entities\\User', 298),
(4, 'App\\Entities\\User', 299),
(4, 'App\\Entities\\User', 300),
(4, 'App\\Entities\\User', 301),
(4, 'App\\Entities\\User', 304),
(4, 'App\\Entities\\User', 305),
(4, 'App\\Entities\\User', 306),
(4, 'App\\Entities\\User', 307),
(5, 'App\\Entities\\User', 217),
(5, 'App\\Entities\\User', 226),
(5, 'App\\Entities\\User', 231),
(5, 'App\\Entities\\User', 232),
(5, 'App\\Entities\\User', 239),
(5, 'App\\Entities\\User', 308),
(5, 'App\\Entities\\User', 309),
(6, 'App\\Entities\\User', 231),
(6, 'App\\Entities\\User', 232),
(6, 'App\\Entities\\User', 234),
(6, 'App\\Entities\\User', 240),
(6, 'App\\Entities\\User', 260),
(6, 'App\\Entities\\User', 261),
(6, 'App\\Entities\\User', 262),
(6, 'App\\Entities\\User', 263),
(6, 'App\\Entities\\User', 264);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('vilakonepha@hotmail.com', '$2y$10$FCJbWYajp6pJTLtdG2JMPexaBJUZygHUbVh/sptUaW.AqPfSN8OrO', '2020-07-16 20:04:16'),
('izaazlinajudges123@gmail.com', '$2y$10$RCqOMbrEsORF9PlKq5EhE./vksT2eX7SPdmANB1sBmszvH1pNU.ui', '2021-03-17 00:15:39'),
('csrmas1@mailnesia.com', '$2y$10$.s5ksIuwGDhdVNfCKn110OlgkYXM2c38xmlKa8nr9xabmC9yKsbqW', '2021-04-06 19:49:14'),
('syisziee@gmail.com', '$2y$10$bBA.AwuGh4q7E3WyiT2rKu2LpTN9xjmqD33EcAo7yI5W76lkv4og2', '2021-04-07 23:12:41'),
('singaporerepresenter3@mailnesia.com', '$2y$10$6zblgbgXmHVysqafnocj0OSoVjhgVcT0Cl589AJpiCIZIQHhFix02', '2021-05-18 19:07:57');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'view-user', 'web', '2019-05-31 01:13:53', '2019-05-31 01:13:53'),
(2, 'delete-user', 'web', '2019-05-31 01:13:53', '2019-05-31 01:13:53'),
(3, 'edit-user', 'web', '2019-05-31 01:13:53', '2019-05-31 01:13:53'),
(4, 'create-user', 'web', '2019-05-31 01:13:53', '2019-05-31 01:13:53'),
(5, 'view-role', 'web', '2019-05-31 01:16:00', '2019-05-31 01:16:00'),
(6, 'delete-role', 'web', '2019-05-31 01:16:00', '2019-05-31 01:16:00'),
(7, 'edit-role', 'web', '2019-05-31 01:16:00', '2019-05-31 01:16:00'),
(8, 'create-role', 'web', '2019-05-31 01:16:00', '2019-05-31 01:16:00'),
(9, 'view-candidate', 'web', '2019-05-31 01:19:57', '2019-05-31 01:19:57'),
(10, 'delete-candidate', 'web', '2019-05-31 01:19:57', '2019-05-31 01:19:57'),
(11, 'edit-candidate', 'web', '2019-05-31 01:19:57', '2019-05-31 01:19:57'),
(12, 'create-candidate', 'web', '2019-05-31 01:19:57', '2019-05-31 01:19:57'),
(13, 'list-form', 'web', '2019-05-31 01:19:57', '2019-05-31 01:19:57'),
(14, 'view-form', 'web', '2019-05-31 01:19:57', '2019-05-31 01:19:57'),
(15, 'video-form', 'web', '2019-05-31 01:19:57', '2019-05-31 01:19:57'),
(16, 'accept-form', 'web', '2019-05-31 01:19:57', '2019-05-31 01:19:57'),
(17, 'review-form', 'web', '2019-05-31 01:19:57', '2019-05-31 01:19:57'),
(18, 'delete-form', 'web', '2019-05-31 01:19:57', '2019-05-31 01:19:57'),
(19, 'edit-form', 'web', '2019-05-31 01:19:57', '2019-05-31 01:19:57'),
(20, 'create-form', 'web', '2019-05-31 01:19:57', '2019-05-31 01:19:57'),
(21, 'create-mailalert', 'web', '2019-05-31 01:19:57', '2019-05-31 01:19:57'),
(22, 'view-comment', 'web', '2019-05-31 01:19:57', '2019-05-31 01:19:57'),
(23, 'create-comment', 'web', '2019-05-31 01:19:57', '2019-05-31 01:19:57'),
(24, 'delete-country', 'web', '2019-05-31 01:19:57', '2019-05-31 01:19:57'),
(25, 'edit-country', 'web', '2019-05-31 01:19:57', '2019-05-31 01:19:57'),
(26, 'view-country', 'web', '2019-05-31 01:19:58', '2019-05-31 01:19:58'),
(27, 'create-country', 'web', '2019-05-31 01:19:58', '2019-05-31 01:19:58'),
(28, 'delete-category', 'web', '2019-05-31 01:19:58', '2019-05-31 01:19:58'),
(29, 'edit-category', 'web', '2019-05-31 01:19:58', '2019-05-31 01:19:58'),
(30, 'view-category', 'web', '2019-05-31 01:19:58', '2019-05-31 01:19:58'),
(31, 'create-category', 'web', '2019-05-31 01:19:58', '2019-05-31 01:19:58'),
(32, 'delete-setting', 'web', '2019-05-31 01:19:58', '2019-05-31 01:19:58'),
(33, 'edit-setting', 'web', '2019-05-31 01:19:58', '2019-05-31 01:19:58'),
(34, 'view-setting', 'web', '2019-05-31 01:19:58', '2019-05-31 01:19:58'),
(35, 'create-setting', 'web', '2019-05-31 01:19:58', '2019-05-31 01:19:58'),
(36, 'list-aseanapp', 'web', '2019-05-31 01:19:58', '2019-05-31 01:19:58'),
(37, 'delete-aseanapp', 'web', '2019-05-31 01:19:58', '2019-05-31 01:19:58'),
(38, 'edit-aseanapp', 'web', '2019-05-31 01:19:58', '2019-05-31 01:19:58'),
(39, 'view-aseanapp', 'web', '2019-05-31 01:19:59', '2019-05-31 01:19:59'),
(40, 'create-aseanapp', 'web', '2019-05-31 01:19:59', '2019-05-31 01:19:59'),
(41, 'delete-guideline', 'web', '2019-05-31 01:19:59', '2019-05-31 01:19:59'),
(42, 'edit-guideline', 'web', '2019-05-31 01:19:59', '2019-05-31 01:19:59'),
(43, 'view-guideline', 'web', '2019-05-31 01:19:59', '2019-05-31 01:19:59'),
(44, 'create-guideline', 'web', '2019-05-31 01:19:59', '2019-05-31 01:19:59'),
(45, 'list-guideline', 'web', '2019-05-31 01:19:59', '2019-05-31 01:19:59'),
(46, 'judge-judge', 'web', '2019-05-31 01:19:59', '2019-05-31 01:19:59'),
(47, 'delete-judge', 'web', '2019-05-31 01:19:59', '2019-05-31 01:19:59'),
(48, 'edit-judge', 'web', '2019-05-31 01:19:59', '2019-05-31 01:19:59'),
(49, 'view-judge', 'web', '2019-05-31 01:20:00', '2019-05-31 01:20:00'),
(50, 'create-judge', 'web', '2019-05-31 01:20:00', '2019-05-31 01:20:00'),
(51, 'list-judge', 'web', '2019-05-31 01:20:00', '2019-05-31 01:20:00'),
(52, 'generate_semi-result', 'web', '2019-05-31 01:20:00', '2019-05-31 01:20:00'),
(53, 'export_final_detail-result', 'web', '2019-05-31 01:20:00', '2019-05-31 01:20:00'),
(54, 'export_final-result', 'web', '2019-05-31 01:20:00', '2019-05-31 01:20:00'),
(55, 'generate_final-result', 'web', '2019-05-31 01:20:00', '2019-05-31 01:20:00'),
(56, 'view-final-result', 'web', '2019-05-31 01:20:00', '2019-05-31 01:20:00'),
(57, 'semifinal-result', 'web', '2019-05-31 01:20:00', '2019-05-31 01:20:00'),
(58, 'download_judge_score_detail-report', 'web', '2019-05-31 01:20:01', '2019-05-31 01:20:01'),
(59, 'download_judge_score-report', 'web', '2019-05-31 01:20:01', '2019-05-31 01:20:01'),
(60, 'freeze-final-judge', 'web', '2019-05-31 01:20:01', '2019-05-31 01:20:01'),
(61, 'app-final-judge', 'web', '2019-05-31 01:20:01', '2019-05-31 01:20:01'),
(62, 'judge-final-judge', 'web', '2019-05-31 01:20:01', '2019-05-31 01:20:01'),
(63, 'delete-final-judge', 'web', '2019-05-31 01:20:01', '2019-05-31 01:20:01'),
(64, 'edit-final-judge', 'web', '2019-05-31 01:20:01', '2019-05-31 01:20:01'),
(65, 'view-final-judge', 'web', '2019-05-31 01:20:01', '2019-05-31 01:20:01'),
(66, 'create-final-judge', 'web', '2019-05-31 01:20:02', '2019-05-31 01:20:02'),
(67, 'list-final-judge', 'web', '2019-05-31 01:20:02', '2019-05-31 01:20:02'),
(68, 'list-user', 'web', '2019-06-12 00:40:46', '2019-06-12 00:40:46'),
(69, 'list-candidate', 'web', '2019-06-12 00:40:48', '2019-06-12 00:40:48'),
(70, 'list-category', 'web', '2019-06-12 00:40:49', '2019-06-12 00:40:49'),
(71, 'list-setting', 'web', '2019-06-12 00:40:51', '2019-06-12 00:40:51'),
(72, 'video-application', 'web', '2019-06-12 00:43:56', '2019-06-12 00:43:56'),
(73, 'list-application', 'web', '2019-06-12 00:43:57', '2019-06-12 00:43:57'),
(74, 'view-application', 'web', '2019-06-12 00:43:58', '2019-06-12 00:43:58'),
(75, 'review-application', 'web', '2019-06-12 00:44:00', '2019-06-12 00:44:00'),
(76, 'accept-application', 'web', '2019-06-12 00:44:01', '2019-06-12 00:44:01'),
(77, 'create-application', 'web', '2019-06-12 00:54:40', '2019-06-12 00:54:40'),
(78, 'edit-application', 'web', '2019-06-12 00:54:42', '2019-06-12 00:54:42'),
(79, 'view-video', 'web', '2019-06-12 00:58:45', '2019-06-12 00:58:45'),
(80, 'review-video', 'web', '2019-06-12 00:58:47', '2019-06-12 00:58:47'),
(81, 'generate.semi-result', 'web', '2019-07-01 11:01:13', '2019-07-01 11:01:13'),
(82, 'list-result', 'web', '2019-07-01 11:01:13', '2019-07-01 11:01:13'),
(83, 'list-country', 'web', '2019-07-07 21:25:17', '2019-07-07 21:25:17'),
(84, 'semi_score_detail-report', 'web', '2019-07-30 13:51:36', '2019-07-30 13:51:36');

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `type` enum('default','semi','final') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'default',
  `generated_by` int(10) UNSIGNED DEFAULT NULL,
  `status` enum('default','active','revision') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  `total` double(8,2) DEFAULT NULL,
  `rank` double(8,2) DEFAULT NULL,
  `total_star` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `result_stars`
--

CREATE TABLE `result_stars` (
  `id` int(10) UNSIGNED NOT NULL,
  `result_id` int(10) UNSIGNED DEFAULT NULL,
  `gold` int(11) NOT NULL DEFAULT 0,
  `silver` int(11) NOT NULL DEFAULT 0,
  `brown` int(11) NOT NULL DEFAULT 0,
  `medal` enum('gold','silver','brown') COLLATE utf8_unicode_ci DEFAULT 'brown',
  `status` enum('default','active','revision') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'web', '2019-06-13 23:39:17', '2019-06-13 23:39:17'),
(2, 'Reviewer', 'web', '2019-06-13 23:39:17', '2019-06-13 23:39:17'),
(3, 'Representer', 'web', '2019-06-13 23:39:17', '2019-06-13 23:39:17'),
(4, 'Candidate', 'web', '2019-06-13 23:39:17', '2019-06-13 23:39:17'),
(5, 'Judge', 'web', '2019-06-13 23:39:17', '2019-06-13 23:39:17'),
(6, 'Final Judge', 'web', '2019-06-13 23:39:17', '2019-06-13 23:39:17');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(9, 1),
(9, 3),
(10, 1),
(10, 3),
(11, 1),
(11, 3),
(12, 1),
(12, 3),
(13, 1),
(13, 3),
(14, 1),
(14, 3),
(14, 4),
(14, 5),
(15, 1),
(15, 3),
(15, 5),
(16, 1),
(16, 3),
(17, 1),
(17, 3),
(19, 1),
(19, 3),
(19, 4),
(20, 1),
(20, 4),
(21, 1),
(22, 1),
(22, 3),
(23, 1),
(23, 3),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(36, 5),
(37, 1),
(38, 1),
(39, 1),
(39, 5),
(39, 6),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(43, 3),
(44, 1),
(45, 1),
(46, 5),
(47, 1),
(47, 3),
(48, 1),
(48, 3),
(49, 1),
(49, 3),
(50, 1),
(50, 3),
(51, 1),
(51, 3),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(57, 3),
(57, 5),
(58, 1),
(59, 1),
(60, 1),
(61, 1),
(62, 1),
(62, 6),
(63, 1),
(64, 1),
(65, 1),
(65, 6),
(66, 1),
(66, 6),
(67, 1),
(67, 6),
(68, 1),
(69, 1),
(69, 3),
(70, 1),
(71, 1),
(72, 1),
(72, 3),
(72, 5),
(73, 1),
(73, 3),
(74, 1),
(74, 3),
(74, 4),
(74, 5),
(75, 1),
(75, 3),
(76, 1),
(76, 3),
(77, 4),
(78, 3),
(78, 4),
(79, 1),
(79, 5),
(79, 6),
(80, 1),
(80, 5),
(81, 1),
(82, 1),
(82, 3),
(82, 5),
(83, 1),
(84, 1);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` enum('BOOLEAN','NUMBER','DATE','TEXT','SELECT','FILE','TEXTAREA') COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `hidden` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `code`, `type`, `label`, `value`, `hidden`, `created_at`, `updated_at`) VALUES
(1, 'login_bg_img', 'FILE', 'LOGIN_BG_IMG', 'login_bg_img.jpeg', 0, NULL, '2021-03-16 00:59:46'),
(2, 'limit_candidate_per_cate', 'NUMBER', 'LIMIT_CANDIDATE_PER_CATE', '3', 1, NULL, '2019-08-07 02:58:43'),
(3, 'is_use_admin_template', 'BOOLEAN', 'IS_USE_ADMIN_TEMPLATE', 'true', 1, NULL, '2019-08-07 02:58:55'),
(4, 'is_auto_auload_process', 'BOOLEAN', 'IS_AUTO_AULOAD_PROCESS', 'true', 1, NULL, '2019-08-07 02:59:08'),
(5, 'show_not_complete', 'BOOLEAN', 'SHOW_NOT_COMPLETE', 'true', 1, NULL, '2019-08-07 02:59:18'),
(6, 'can_final_judge', 'BOOLEAN', 'CAN_FINAL_JUDGE', 'false', 0, NULL, '2021-05-18 18:42:54'),
(7, 'freeze_without_con', 'BOOLEAN', 'FREEZE_WITHOUT_CON', 'false', 1, NULL, '2019-08-07 02:59:37'),
(8, 'limit_representer', 'NUMBER', 'LIMIT_REPRESENTER', '1', 1, NULL, '2019-08-07 02:46:50'),
(9, 'started_judgement_date', 'DATE', 'STARTED_JUDGEMENT_DATE', '03/05/2020', 0, NULL, '2021-05-18 18:44:32'),
(10, 'ended_judgement_date', 'DATE', 'ENDED_JUDGEMENT_DATE', '02/12/2020', 0, NULL, '2021-05-18 18:44:57'),
(11, 'closed_form_date', 'DATE', 'CLOSED_FORM_DATE', '06/05/2021', 0, NULL, '2021-05-20 17:45:35'),
(12, 'semi_final_result_date', 'DATE', 'SEMI_FINAL_RESULT_DATE', '06/11/2020', 0, NULL, '2021-05-20 05:31:11'),
(13, 'video_upload_max_size', 'NUMBER', 'VIDEO_UPLOAD_MAX_SIZE', '2100000000', 1, '2019-06-13 09:10:39', '2019-08-07 03:00:11'),
(14, 'final_judge_date', 'DATE', 'FINAL_JUDGE_DATE', '02/05/2020', 0, '2019-07-30 06:01:53', '2021-05-18 18:45:28'),
(15, 'industries', 'SELECT', 'industries', '{\"Korea\":\"Korea\",\"Japan\":\"Japan\"}', 0, '2019-08-07 02:54:37', '2019-08-07 02:57:08');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `country_id` int(10) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `is_super_admin` tinyint(1) NOT NULL DEFAULT 0,
  `confirmation_code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `country_id`, `active`, `parent_id`, `is_super_admin`, `confirmation_code`, `deleted_at`) VALUES
(205, 'Super Admin', 'izaazlina@gmail.com', NULL, '$2y$10$k5OmzhjEMbDAI7a0VvhTHOeYlNXsR2bsB89lQ9vlaU4UqHPOUgi3G', 'HmtYlGcg56EnxOE6Y7jOjHI7RSEWvrSxySYejRWGH1j70wFMrQeYwiNbW9Gw', '2020-03-27 02:42:13', '2021-05-09 23:50:20', 5, 1, NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `application_id` int(10) UNSIGNED DEFAULT NULL,
  `youtube_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mine_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` enum('host','achieved','youtube') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'host',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `youtube_access_tokens`
--

CREATE TABLE `youtube_access_tokens` (
  `id` int(10) UNSIGNED NOT NULL,
  `access_token` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `applications_user_id_foreign` (`user_id`),
  ADD KEY `applications_approved_by_foreign` (`approved_by`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`),
  ADD UNIQUE KEY `categories_abbreviation_unique` (`abbreviation`),
  ADD KEY `categories_created_by_foreign` (`created_by`);

--
-- Indexes for table `category_user`
--
ALTER TABLE `category_user`
  ADD PRIMARY KEY (`category_id`,`user_id`,`country_id`,`type`),
  ADD KEY `category_user_user_id_foreign` (`user_id`),
  ADD KEY `category_user_country_id_foreign` (`country_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `final_judges`
--
ALTER TABLE `final_judges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guidelines`
--
ALTER TABLE `guidelines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guidelines_role_id_foreign` (`role_id`);

--
-- Indexes for table `judges`
--
ALTER TABLE `judges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `result_stars`
--
ALTER TABLE `result_stars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_code_unique` (`code`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_country_id_foreign` (`country_id`),
  ADD KEY `users_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `videos_path_unique` (`path`),
  ADD UNIQUE KEY `videos_youtube_id_unique` (`youtube_id`),
  ADD KEY `videos_application_id_foreign` (`application_id`);

--
-- Indexes for table `youtube_access_tokens`
--
ALTER TABLE `youtube_access_tokens`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `final_judges`
--
ALTER TABLE `final_judges`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `guidelines`
--
ALTER TABLE `guidelines`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `judges`
--
ALTER TABLE `judges`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `result_stars`
--
ALTER TABLE `result_stars`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=310;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `youtube_access_tokens`
--
ALTER TABLE `youtube_access_tokens`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `applications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `category_user`
--
ALTER TABLE `category_user`
  ADD CONSTRAINT `category_user_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `category_user_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `category_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `guidelines`
--
ALTER TABLE `guidelines`
  ADD CONSTRAINT `guidelines_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`),
  ADD CONSTRAINT `users_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `videos`
--
ALTER TABLE `videos`
  ADD CONSTRAINT `videos_application_id_foreign` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
