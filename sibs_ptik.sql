-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 03 Des 2024 pada 14.56
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sibs_ptik`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `exam_results`
--

CREATE TABLE `exam_results` (
  `id` char(36) NOT NULL,
  `student_id` char(36) NOT NULL,
  `thesis_id` char(36) NOT NULL,
  `guidance_id` char(36) NOT NULL,
  `status_request` enum('pending','approved') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `guidances`
--

CREATE TABLE `guidances` (
  `id` char(36) NOT NULL,
  `student_id` char(36) NOT NULL,
  `thesis_id` char(36) NOT NULL,
  `lecturer_id` char(36) DEFAULT NULL,
  `topic` varchar(255) NOT NULL,
  `explanation` text DEFAULT NULL,
  `thesis_file_review` varchar(255) DEFAULT NULL,
  `lecturer_notes` text DEFAULT NULL,
  `schedule` datetime NOT NULL,
  `guidance_number` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `status_request` enum('pending','approved') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `head_of_departements`
--

CREATE TABLE `head_of_departements` (
  `id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `nip` varchar(25) NOT NULL,
  `nidn` varchar(25) NOT NULL,
  `front_degree` varchar(50) DEFAULT NULL,
  `back_degree` varchar(50) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `rank` varchar(100) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `lecturers`
--

CREATE TABLE `lecturers` (
  `id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `nip` varchar(18) NOT NULL,
  `nidn` varchar(10) NOT NULL,
  `front_degree` varchar(50) DEFAULT NULL,
  `back_degree` varchar(50) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `rank` varchar(100) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `lecturers`
--

INSERT INTO `lecturers` (`id`, `user_id`, `nip`, `nidn`, `front_degree`, `back_degree`, `position`, `rank`, `type`, `phone_number`, `created_at`, `updated_at`) VALUES
('42a75f42-de4e-36e1-a519-9046cdc12125', '5a9ea1df-b80d-486b-994b-0e83b8fa5ec7', '198207222002111002', '0021069404', 'Prof.', 'Ph.D', 'Kaprodi', 'Lektor Kepala', NULL, '08000000002', '2024-12-03 06:28:44', '2024-12-03 06:28:44'),
('54cce962-d5d6-336c-990f-caf2c4d0b5f6', '53209626-2c66-4955-844c-4eba7e6ac96e', '195604012008091004', '0022036101', 'Prof.', 'Ph.D', 'Kaprodi', 'Lektor Kepala', NULL, '08000000004', '2024-12-03 06:28:44', '2024-12-03 06:28:44'),
('770712e1-1198-33ab-90d6-5cc7ce860561', 'e6243ea9-bf78-409d-b94f-cf6ea00b887b', '196209282002042003', '0009106608', 'Prof.', 'Ph.D', 'Kaprodi', 'Lektor Kepala', NULL, '08000000003', '2024-12-03 06:28:44', '2024-12-03 06:28:44'),
('88dc9576-0b80-365b-b355-c7ca877bbcfb', '2d71cf7d-93d2-4a2c-96b5-3891dd87e065', '198607192018031005', '0009047103', 'Prof.', 'Ph.D', 'Kaprodi', 'Lektor Kepala', NULL, '08000000005', '2024-12-03 06:28:44', '2024-12-03 06:28:44'),
('b31861e5-e24d-35c8-aa10-61ae567ed493', 'ed19ccee-cd63-4b11-8e62-54f02298fb2c', '197008162024101001', '0006035110', 'Prof.', 'Ph.D', 'Kaprodi', 'Lektor Kepala', NULL, '08000000001', '2024-12-03 06:28:43', '2024-12-03 06:28:43');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_04_09_130313_create_lecturers_table', 1),
(5, '2024_04_09_143625_create_students_table', 1),
(6, '2024_04_09_155750_create_head_of_departements_table', 1),
(7, '2024_04_11_031355_create_theses_table', 1),
(8, '2024_04_11_161924_create_guidances_table', 1),
(9, '2024_04_12_183400_create_exam_results_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` char(36) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('K10mGrTgKGhSggmdjQOyAreapM9to1oDG9vlfMh2', '16f847d5-e85d-401f-9840-7826d930e826', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiRGVjYldUYWp3Mkxqd1JyQkJFRDljRnpxRGM0RElXc3lCQUsxVTYxTiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7czozNjoiMTZmODQ3ZDUtZTg1ZC00MDFmLTk4NDAtNzgyNmQ5MzBlODI2IjtzOjE0OiJ0b2FzdERpc3BsYXllZCI7YjoxO30=', 1733233744),
('poe321DjFTFb5Vj4BayNzpRFbG2tM0Zqc48xPSjC', '16f847d5-e85d-401f-9840-7826d930e826', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoieGdCb0ZUTVNhZVVBTEVUUVdsb2hSQmVqcFozeUIyZ0lWSzVhTjI2dCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wZW5nYWp1YW4tdWppYW4tbWFoYXNpc3dhIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO3M6MzY6IjE2Zjg0N2Q1LWU4NWQtNDAxZi05ODQwLTc4MjZkOTMwZTgyNiI7czoxNDoidG9hc3REaXNwbGF5ZWQiO2I6MTtzOjU6ImFsZXJ0IjthOjA6e319', 1733234124);

-- --------------------------------------------------------

--
-- Struktur dari tabel `students`
--

CREATE TABLE `students` (
  `id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `lecturer_id_1` char(36) NOT NULL,
  `lecturer_id_2` char(36) DEFAULT NULL,
  `nim` varchar(10) NOT NULL,
  `batch` smallint(5) UNSIGNED NOT NULL,
  `concentration` enum('RPL','Multimedia','TKJ') NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `students`
--

INSERT INTO `students` (`id`, `user_id`, `lecturer_id_1`, `lecturer_id_2`, `nim`, `batch`, `concentration`, `phone_number`, `address`, `created_at`, `updated_at`) VALUES
('23359229-bfdc-3e4d-8102-d5611733e699', 'ae8092e8-a827-4fac-ac00-55f174f0bf4c', '54cce962-d5d6-336c-990f-caf2c4d0b5f6', 'b31861e5-e24d-35c8-aa10-61ae567ed493', '21208004', 2021, 'Multimedia', NULL, NULL, '2024-12-03 06:28:45', '2024-12-03 06:28:45'),
('3b690eaf-aa1d-39bb-ac18-5abc8a62ba41', 'bd5eba77-2b34-49b7-a9ae-e1a31f15656a', '770712e1-1198-33ab-90d6-5cc7ce860561', '54cce962-d5d6-336c-990f-caf2c4d0b5f6', '21208010', 2021, 'Multimedia', NULL, NULL, '2024-12-03 06:28:46', '2024-12-03 06:28:46'),
('58213b22-9652-3b8c-8fa8-8bda67d6546d', 'fcf57d54-d8ce-423d-9044-e622c34d7590', 'b31861e5-e24d-35c8-aa10-61ae567ed493', 'b31861e5-e24d-35c8-aa10-61ae567ed493', '21208002', 2021, 'RPL', NULL, NULL, '2024-12-03 06:28:45', '2024-12-03 06:28:45'),
('5f8c1dd6-d786-3d65-b287-17a8d87d02b1', 'f6da4f1a-1251-4459-bb34-1000e90bf744', '54cce962-d5d6-336c-990f-caf2c4d0b5f6', '770712e1-1198-33ab-90d6-5cc7ce860561', '21208009', 2021, 'Multimedia', NULL, NULL, '2024-12-03 06:28:46', '2024-12-03 06:28:46'),
('6a9b2b25-327c-307b-a1cd-35248dabaaf2', '42f33c43-5701-43f6-8048-aef4493c11e0', '770712e1-1198-33ab-90d6-5cc7ce860561', '54cce962-d5d6-336c-990f-caf2c4d0b5f6', '21208005', 2021, 'Multimedia', NULL, NULL, '2024-12-03 06:28:45', '2024-12-03 06:28:45'),
('88f7af9c-afda-3aef-8db3-9d1f8c582655', 'e6cdb50c-7df9-4c01-8d88-0ba1d7bb6c50', 'b31861e5-e24d-35c8-aa10-61ae567ed493', '770712e1-1198-33ab-90d6-5cc7ce860561', '21208008', 2021, 'TKJ', NULL, NULL, '2024-12-03 06:28:46', '2024-12-03 06:28:46'),
('a879fe6c-6ee6-3526-b65a-d65fa73a4efe', '79f36c83-2043-481e-b3f3-56c9188ac8bd', '770712e1-1198-33ab-90d6-5cc7ce860561', '54cce962-d5d6-336c-990f-caf2c4d0b5f6', '21208001', 2021, 'RPL', NULL, NULL, '2024-12-03 06:28:44', '2024-12-03 06:28:44'),
('b4bc9e9a-4c59-35d8-a78b-4fdafda2aed7', '3631fffb-780f-458f-a3c4-91159b8f9cc6', '54cce962-d5d6-336c-990f-caf2c4d0b5f6', '88dc9576-0b80-365b-b355-c7ca877bbcfb', '21208006', 2021, 'TKJ', NULL, NULL, '2024-12-03 06:28:45', '2024-12-03 06:28:45'),
('d0d78047-9835-3418-bd8a-07f28db559bf', 'd2289167-e3b0-40a6-b17e-4eea86da67e3', '54cce962-d5d6-336c-990f-caf2c4d0b5f6', 'b31861e5-e24d-35c8-aa10-61ae567ed493', '21208003', 2021, 'RPL', NULL, NULL, '2024-12-03 06:28:45', '2024-12-03 06:28:45'),
('e62f6da9-8d4f-3522-a1d4-4d2909191e12', '3ebe8138-6f83-4ed9-84a2-9d7e0c53673f', '88dc9576-0b80-365b-b355-c7ca877bbcfb', '88dc9576-0b80-365b-b355-c7ca877bbcfb', '21208007', 2021, 'RPL', NULL, NULL, '2024-12-03 06:28:45', '2024-12-03 06:28:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `theses`
--

CREATE TABLE `theses` (
  `id` char(36) NOT NULL,
  `student_id` char(36) NOT NULL,
  `title` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `approval_lecturer_1` enum('pending','approved') NOT NULL DEFAULT 'pending',
  `approval_lecturer_2` enum('pending','approved') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` char(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','student','lecturer','HoD') NOT NULL DEFAULT 'student',
  `photo` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `role`, `photo`, `remember_token`, `created_at`, `updated_at`) VALUES
('16f847d5-e85d-401f-9840-7826d930e826', 'admin', 'admin', 'admin@gmail.com', '2024-12-03 06:28:43', '$2y$12$ovsrAOjXwcr33ywtBD.PfOmTTAm3fZQhffkxEWvNl5fBvwxqDh3g.', 'admin', NULL, 'dtD2BOmAt5', '2024-12-03 06:28:43', '2024-12-03 06:35:44'),
('2d71cf7d-93d2-4a2c-96b5-3891dd87e065', 'Jarrett Lowe', '0009047103', '0009047103@unima.ac.id', NULL, '$2y$12$G6q7p1efb5NP4AJPoo66yOmUpk6AKtQ7Cn8fDIya3YdUvpZ.ujsiC', 'lecturer', NULL, NULL, '2024-12-03 06:28:44', '2024-12-03 06:28:44'),
('3631fffb-780f-458f-a3c4-91159b8f9cc6', 'Jeremie Kulas', '21208006', '21208006@unima.ac.id', NULL, '$2y$12$zRG0ofBEirTSzm2ytCVnz.f95ihgva0dX7OseFx2Wrfdq1OFwukLm', 'student', NULL, NULL, '2024-12-03 06:28:45', '2024-12-03 06:28:45'),
('3ebe8138-6f83-4ed9-84a2-9d7e0c53673f', 'Lyda Reinger', '21208007', '21208007@unima.ac.id', NULL, '$2y$12$ncrrVcqCxdtN.OIMnqlTmupsv8GFxwb8XQRXOhI6GAAJSVMEH2kLm', 'student', NULL, NULL, '2024-12-03 06:28:45', '2024-12-03 06:28:45'),
('42f33c43-5701-43f6-8048-aef4493c11e0', 'Mr. Ignacio Schamberger MD', '21208005', '21208005@unima.ac.id', NULL, '$2y$12$DE/TA90XICHqvfl2kuXzaeGwndmeaQGEqgoy64hgCeFw/Mq1lcGAG', 'student', NULL, NULL, '2024-12-03 06:28:45', '2024-12-03 06:28:45'),
('53209626-2c66-4955-844c-4eba7e6ac96e', 'Grady Kuvalis', '0022036101', '0022036101@unima.ac.id', NULL, '$2y$12$ovujHJeqcHR8TyW6ELvlLekt.ax0Jg/R2YBqfC2NF2pxuCe5HRur6', 'lecturer', NULL, NULL, '2024-12-03 06:28:44', '2024-12-03 06:28:44'),
('5a9ea1df-b80d-486b-994b-0e83b8fa5ec7', 'Isac Durgan', '0021069404', '0021069404@unima.ac.id', NULL, '$2y$12$mjBspCQswVqeo3kZMgrz2.nE6CmF49AwnpKar1/MyNwBbzYhQVf.2', 'lecturer', NULL, NULL, '2024-12-03 06:28:44', '2024-12-03 06:28:44'),
('79f36c83-2043-481e-b3f3-56c9188ac8bd', 'Mr. Shane Harvey', '21208001', '21208001@unima.ac.id', NULL, '$2y$12$uG81NRmTsRAlmhElkUDvcOtVVc3pt62FcrECZ/Z.oHoO4C6dmL8NW', 'student', NULL, NULL, '2024-12-03 06:28:44', '2024-12-03 06:28:44'),
('ae8092e8-a827-4fac-ac00-55f174f0bf4c', 'Mrs. Gail Leuschke', '21208004', '21208004@unima.ac.id', NULL, '$2y$12$TInzEXSi3ZAAjJTOsxg//Omr07.4St.LA5Y0GpKpX5V3IMbFW15zG', 'student', NULL, NULL, '2024-12-03 06:28:45', '2024-12-03 06:28:45'),
('bd5eba77-2b34-49b7-a9ae-e1a31f15656a', 'Monty Kuphal', '21208010', '21208010@unima.ac.id', NULL, '$2y$12$X6e/hA4s3LM1f97RvAlFKeEKaoGsnWnt2.I9.vK5LHMZzchjZ8EWe', 'student', NULL, NULL, '2024-12-03 06:28:46', '2024-12-03 06:28:46'),
('d2289167-e3b0-40a6-b17e-4eea86da67e3', 'Jack Dickinson', '21208003', '21208003@unima.ac.id', NULL, '$2y$12$AzWRKEsw8Mj/WMzw4FA7F.OnVEPEXgI7I0rMQIw4pfxYfFJe0CcV.', 'student', NULL, NULL, '2024-12-03 06:28:45', '2024-12-03 06:28:45'),
('e6243ea9-bf78-409d-b94f-cf6ea00b887b', 'Winona Larkin V', '0009106608', '0009106608@unima.ac.id', NULL, '$2y$12$BhvPE08uxj5QSgD8/BPJHuEj6uur1bC3.A49CtiV7TSSa8sUCY/Ri', 'lecturer', NULL, NULL, '2024-12-03 06:28:44', '2024-12-03 06:28:44'),
('e6cdb50c-7df9-4c01-8d88-0ba1d7bb6c50', 'Prof. Brigitte Jenkins Sr.', '21208008', '21208008@unima.ac.id', NULL, '$2y$12$SUhpZpFjIcMtHGI77q8qseie.1J/vWpL.X.v8jyXuLbSMlPk0B8h.', 'student', NULL, NULL, '2024-12-03 06:28:46', '2024-12-03 06:28:46'),
('ed19ccee-cd63-4b11-8e62-54f02298fb2c', 'Mr. Alexys Little Jr.', '0006035110', '0006035110@unima.ac.id', NULL, '$2y$12$vKQVTGaC3AJhxgVsavMlTuX3sDEwgSOaK3wpYr6oZ0jFruP4X8.PG', 'lecturer', NULL, NULL, '2024-12-03 06:28:43', '2024-12-03 06:28:43'),
('f6da4f1a-1251-4459-bb34-1000e90bf744', 'Gus Schaefer', '21208009', '21208009@unima.ac.id', NULL, '$2y$12$bDQm3NeVlJDjMPdqa5uQVe968xfLdBmhjPOwYSrmKwOIIA.eOLvF6', 'student', NULL, NULL, '2024-12-03 06:28:46', '2024-12-03 06:28:46'),
('fcf57d54-d8ce-423d-9044-e622c34d7590', 'Sydni Wehner', '21208002', '21208002@unima.ac.id', NULL, '$2y$12$71x2BNW3vzgqJWRh4Z1nieurLl/RZIHRxjkkjBA/Z0FY09jy77QSy', 'student', NULL, NULL, '2024-12-03 06:28:45', '2024-12-03 06:28:45');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `exam_results`
--
ALTER TABLE `exam_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_results_student_id_foreign` (`student_id`),
  ADD KEY `exam_results_thesis_id_foreign` (`thesis_id`),
  ADD KEY `exam_results_guidance_id_foreign` (`guidance_id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `guidances`
--
ALTER TABLE `guidances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guidances_student_id_foreign` (`student_id`),
  ADD KEY `guidances_thesis_id_foreign` (`thesis_id`),
  ADD KEY `guidances_lecturer_id_foreign` (`lecturer_id`);

--
-- Indeks untuk tabel `head_of_departements`
--
ALTER TABLE `head_of_departements`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `head_of_departements_nip_unique` (`nip`),
  ADD UNIQUE KEY `head_of_departements_nidn_unique` (`nidn`),
  ADD KEY `head_of_departements_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `lecturers`
--
ALTER TABLE `lecturers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lecturers_nip_unique` (`nip`),
  ADD UNIQUE KEY `lecturers_nidn_unique` (`nidn`),
  ADD KEY `lecturers_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `students_nim_unique` (`nim`),
  ADD KEY `students_user_id_foreign` (`user_id`),
  ADD KEY `students_lecturer_id_1_foreign` (`lecturer_id_1`),
  ADD KEY `students_lecturer_id_2_foreign` (`lecturer_id_2`);

--
-- Indeks untuk tabel `theses`
--
ALTER TABLE `theses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `theses_student_id_foreign` (`student_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `exam_results`
--
ALTER TABLE `exam_results`
  ADD CONSTRAINT `exam_results_guidance_id_foreign` FOREIGN KEY (`guidance_id`) REFERENCES `guidances` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exam_results_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exam_results_thesis_id_foreign` FOREIGN KEY (`thesis_id`) REFERENCES `theses` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `guidances`
--
ALTER TABLE `guidances`
  ADD CONSTRAINT `guidances_lecturer_id_foreign` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `guidances_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `guidances_thesis_id_foreign` FOREIGN KEY (`thesis_id`) REFERENCES `theses` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `head_of_departements`
--
ALTER TABLE `head_of_departements`
  ADD CONSTRAINT `head_of_departements_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `lecturers`
--
ALTER TABLE `lecturers`
  ADD CONSTRAINT `lecturers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_lecturer_id_1_foreign` FOREIGN KEY (`lecturer_id_1`) REFERENCES `lecturers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `students_lecturer_id_2_foreign` FOREIGN KEY (`lecturer_id_2`) REFERENCES `lecturers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `students_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `theses`
--
ALTER TABLE `theses`
  ADD CONSTRAINT `theses_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
