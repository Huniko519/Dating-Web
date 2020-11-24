-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 30, 2020 at 05:30 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quickdate`
--

-- --------------------------------------------------------

--
-- Table structure for table `affiliates_requests`
--

CREATE TABLE `affiliates_requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `amount` varchar(100) NOT NULL DEFAULT '0',
  `full_amount` varchar(100) NOT NULL DEFAULT '',
  `status` int(11) NOT NULL DEFAULT 0,
  `time` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `id` int(11) NOT NULL,
  `text` text DEFAULT NULL,
  `time` int(32) NOT NULL DEFAULT 0,
  `active` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `announcement_views`
--

CREATE TABLE `announcement_views` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `announcement_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `audiocalls`
--

CREATE TABLE `audiocalls` (
  `id` int(11) NOT NULL,
  `call_id` varchar(30) NOT NULL DEFAULT '0',
  `access_token` text DEFAULT NULL,
  `call_id_2` varchar(30) NOT NULL DEFAULT '',
  `access_token_2` text DEFAULT NULL,
  `from_id` int(11) NOT NULL DEFAULT 0,
  `to_id` int(11) NOT NULL DEFAULT 0,
  `room_name` varchar(50) NOT NULL DEFAULT '',
  `active` int(11) NOT NULL DEFAULT 0,
  `called` int(11) NOT NULL DEFAULT 0,
  `time` int(11) NOT NULL DEFAULT 0,
  `declined` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bank_receipts`
--

CREATE TABLE `bank_receipts` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `description` tinytext DEFAULT NULL,
  `price` varchar(50) NOT NULL DEFAULT '0',
  `mode` varchar(50) NOT NULL DEFAULT '',
  `approved` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `receipt_file` varchar(250) NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `approved_at` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `banned_ip`
--

CREATE TABLE `banned_ip` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(32) NOT NULL DEFAULT '',
  `time` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `blocks`
--

CREATE TABLE `blocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT 0,
  `block_userid` int(11) UNSIGNED DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `id` int(11) NOT NULL,
  `title` varchar(120) NOT NULL DEFAULT '',
  `content` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `posted` varchar(300) DEFAULT '0',
  `category` int(255) DEFAULT 0,
  `thumbnail` varchar(100) DEFAULT 'upload/photos/d-blog.jpg',
  `view` int(11) DEFAULT 0,
  `shared` int(11) DEFAULT 0,
  `tags` varchar(300) DEFAULT '',
  `created_at` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `id` int(11) UNSIGNED NOT NULL,
  `sender_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `receiver_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `from_delete` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `to_delete` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` int(11) UNSIGNED DEFAULT 0,
  `status` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `custom_pages`
--

CREATE TABLE `custom_pages` (
  `id` int(11) NOT NULL,
  `page_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `page_title` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `page_content` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `page_type` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `daily_credits`
--

CREATE TABLE `daily_credits` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `emails`
--

CREATE TABLE `emails` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `email_to` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `subject` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `message` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `src` varchar(50) CHARACTER SET utf8mb4 DEFAULT 'site'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `fav_user_id` int(11) UNSIGNED NOT NULL,
  `created_at` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `followers`
--

CREATE TABLE `followers` (
  `id` int(11) NOT NULL,
  `following_id` int(11) NOT NULL DEFAULT 0,
  `follower_id` int(11) NOT NULL DEFAULT 0,
  `active` int(255) NOT NULL DEFAULT 1,
  `created_at` int(11) UNSIGNED DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gifts`
--

CREATE TABLE `gifts` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(250) CHARACTER SET utf8 DEFAULT '',
  `media_file` varchar(250) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `time` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `hot`
--

CREATE TABLE `hot` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT 0,
  `hot_userid` int(11) UNSIGNED DEFAULT 0,
  `val` int(11) UNSIGNED DEFAULT 0,
  `created_at` int(11) UNSIGNED DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `langs`
--

CREATE TABLE `langs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ref` varchar(250) NOT NULL DEFAULT '',
  `options` text DEFAULT NULL,
  `lang_key` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `english` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `arabic` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `dutch` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `french` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `german` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `italian` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `portuguese` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `russian` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `spanish` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `turkish` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `langs`
--

INSERT INTO `langs` (`id`, `ref`, `options`, `lang_key`, `english`, `arabic`, `dutch`, `french`, `german`, `italian`, `portuguese`, `russian`, `spanish`, `turkish`) VALUES
(1, '', NULL, 'male', 'Male', 'الذكر', 'Mannetje', 'Mâle', 'Männlich', 'Maschio', 'Masculino', 'мужчина', 'Masculino', 'Erkek'),
(2, '', NULL, 'english', 'English', 'الإنجليزية', 'Engels', 'Anglais', 'Englisch', 'Inglese', 'Inglês', 'английский', 'Inglés', 'ingilizce'),
(4, '', NULL, 'sandy', 'Sandy', 'رملي', 'zanderig', 'Sablonneux', 'Sandig', 'sabbioso', 'Sandy', 'Сэнди', 'Arenoso', 'Kumlu'),
(5, '', NULL, 'about_a_minute_ago', 'about a minute ago', 'منذ دقيقة واحدة', 'ongeveer een minuut geleden', 'Il y a environ une minute', 'vor ungefähr einer Minute', 'circa un minuto fa', 'cerca de um minuto atrás', 'около минуты назад', 'hace alrededor de un minuto', 'yaklaşık bir dakika önce'),
(6, '', NULL, 'female', 'Female', 'إناثا', 'Vrouw', 'Femelle', 'Weiblich', 'Femmina', 'Fêmea', 'женский', 'Hembra', 'Kadın'),
(7, '', NULL, '141_cm', '141 cm', '141 سم', '141 cm', '141 cm', '141 cm', '141 cm', '141 cm', '141 см', '141 cm', '141 cm'),
(8, '', NULL, '143_cm', '143 cm', '143 سم', '143 cm', '143 cm', '143 cm', '143 cm', '143 cm', '143 см', '143 cm', '143 cm'),
(9, '', NULL, 'white', 'White', 'أبيض', 'Wit', 'blanc', 'Weiß', 'bianca', 'Branco', 'белый', 'Blanco', 'Beyaz'),
(11, '', NULL, 'just_now', 'Just now', 'في هذة اللحظة', 'Net nu', 'Juste maintenant', 'Gerade jetzt', 'Proprio adesso', 'Agora mesmo', 'Прямо сейчас', 'Justo ahora', 'Şu anda'),
(12, '', NULL, 'about', 'About', 'حول', 'Wat betreft', 'Sur', 'Über', 'Di', 'Sobre', 'Около', 'Acerca de', 'hakkında'),
(13, '', NULL, 'view_profile', 'View Profile', 'عرض الصفحة الشخصية', 'Bekijk profiel', 'Voir le profil', 'Profil anzeigen', 'Vedi profilo', 'Ver perfil', 'Просмотреть профиль', 'Ver perfil', 'Profili Görüntüle'),
(14, '', NULL, '_d_years_ago', '%d years ago', 'قبل %d سنة', '%d jaar geleden', 'il y a %d années', 'Vor %d Jahren', '%d anni fa', '%d anos atrás', '%d лет назад', 'hace %d años', '%d yıl önce'),
(15, '', NULL, 'find_matches', 'Find Matches', 'العثور على المباريات', 'Vind overeenkomsten', 'Trouver des allumettes', 'Übereinstimmungen finden', 'Trova corrispondenze', 'Encontrar correspondências', 'Найти совпадения', 'Encontrar coincidencias', 'Maçları Bul'),
(16, '', NULL, 'premium', 'Premium', 'مميز', 'Premie', 'Prime', 'Prämie', 'premio', 'Prêmio', 'премия', 'Prima', 'Ödül'),
(17, '', NULL, 'boost_me_', 'Boost me!', 'تعزيز لي!', 'Boost me!', 'Boost moi!', 'Boost mich!', 'Potenziami!', 'Me impulsione!', 'Поддержи меня!', 'Impulsame', 'Beni arttır!'),
(18, '', NULL, 'credits', 'Credits', 'قروض', 'credits', 'Crédits', 'Credits', 'Titoli di coda', 'Créditos', 'кредиты', 'Creditos', 'Kredi'),
(19, '', NULL, 'profile', 'Profile', 'الملف الشخصي', 'Profiel', 'Profil', 'Profil', 'Profilo', 'Perfil', 'Профиль', 'Perfil', 'Profil'),
(20, '', NULL, 'matches', 'Matches', 'اعواد الكبريت', 'Wedstrijden', 'Allumettes', 'Streichhölzer', 'fiammiferi', 'Fósforos', 'Матчи', 'Partidos', 'Maçlar'),
(21, '', NULL, 'visits', 'Visitors', 'الزائرين', 'bezoekers', 'Visiteurs', 'Besucher', 'I visitatori', 'Visitantes', 'Посетители', 'Visitantes', 'Ziyaretçi'),
(22, '', NULL, 'likes', 'Likes', 'الإعجابات', 'sympathieën', 'Aime', 'Likes', 'Piace', 'Gostos', 'Нравится', 'Gustos', 'Seviyor'),
(23, '', NULL, 'people_i_liked', 'People I Liked', 'أنا أحب الناس', 'Mensen die ik leuk vond', 'Les gens que j\'ai aimé', 'Leute, die ich mochte', 'Persone che mi sono piaciute', 'Pessoas que eu gostei', 'Люди, которые мне понравились', 'Gente que me gusto', 'Sevdiğim Kişiler'),
(24, '', NULL, 'people_i_disliked', 'People I Disliked', 'الناس الذين لم أحبهم', 'Mensen met wie ik een hekel had', 'Les gens que je n\'aime pas', 'Leute, die ich nicht mochte', 'Persone che non sono piaciute', 'Pessoas que eu não gostei', 'Люди, которые мне не понравились', 'Personas que no me gustaron', 'Sevmediğim Kişiler'),
(25, '', NULL, 'settings', 'Settings', 'الإعدادات', 'instellingen', 'Réglages', 'die Einstellungen', 'impostazioni', 'Definições', 'настройки', 'Ajustes', 'Ayarlar'),
(26, '', NULL, 'transactions', 'Transactions', 'المعاملات', 'transacties', 'Transactions', 'Transaktionen', 'Le transazioni', 'Transações', 'операции', 'Actas', 'işlemler'),
(27, '', NULL, 'admin_panel', 'Admin Panel', 'لوحة الادارة', 'Administratie Paneel', 'panneau d\'administration', 'Administrationsmenü', 'Pannello di Amministrazione', 'Painel de administração', 'Панель администратора', 'Panel de administrador', 'Admin Paneli'),
(28, '', NULL, 'log_out', 'Log Out', 'الخروج', 'Uitloggen', 'Connectez - Out', 'Ausloggen', 'Disconnettersi', 'Sair', 'Выйти', 'Cerrar sesión', 'Çıkış Yap'),
(29, '', NULL, 'messenger', 'Messenger', 'رسول', 'Boodschapper', 'Messager', 'Bote', 'Messaggero', 'Mensageiro', 'посыльный', 'Mensajero', 'haberci'),
(30, '', NULL, 'active_status', 'Active Status', 'الحالة النشطة', 'Actieve status', 'Statut actif', 'Aktiver Status', 'Stato attivo', 'Status ativo', 'Активный статус', 'Estado activo', 'Aktif durum'),
(31, '', NULL, 'offline', 'Offline', 'غير متصل على الانترنت', 'offline', 'Hors ligne', 'Offline', 'disconnesso', 'desligada', 'Не в сети', 'Desconectado', 'Çevrimdışı'),
(32, '', NULL, 'online', 'Online', 'عبر الانترنت', 'Online', 'En ligne', 'Online', 'in linea', 'Conectados', 'онлайн', 'En línea', 'İnternet üzerinden'),
(33, '', NULL, 'mark_all_as_read', 'Mark all as read', 'اشر عليها بانها قرات', 'Markeer alles als gelezen', 'tout marquer comme lu', 'Alles als gelesen markieren', 'Segna tutti come letti', 'marcar tudo como lido', 'отметить все как прочитанное', 'marcar todo como leido', 'Tümünü okundu olarak işaretle'),
(34, '', NULL, 'search_for_chats', 'Search for conversations', 'البحث عن المحادثات', 'Zoeken naar gesprekken', 'Rechercher des conversations', 'Suche nach Gesprächen', 'Cerca conversazioni', 'Pesquisar por conversas', 'Поиск разговоров', 'Buscar conversaciones', 'Konuşmaları ara'),
(35, '', NULL, 'reset', 'Reset', 'إعادة تعيين', 'Reset', 'Réinitialiser', 'Zurücksetzen', 'Reset', 'Restabelecer', 'Сброс', 'Reiniciar', 'Reset'),
(36, '', NULL, 'all', 'All', 'الكل', 'Allemaal', 'Tout', 'Alles', 'Tutti', 'Todos', 'Все', 'Todos', 'Herşey'),
(37, '', NULL, 'no_more_messages_to_show.', 'No more messages to show.', 'لا مزيد من الرسائل لإظهارها.', 'Geen berichten meer om te laten zien.', 'Pas plus de messages à afficher.', 'Keine Nachrichten mehr zu zeigen.', 'Non ci sono più messaggi da mostrare.', 'Não há mais mensagens para mostrar.', 'Нет больше сообщений, чтобы показать.', 'No hay más mensajes para mostrar.', 'Gösterilecek mesaj yok.'),
(38, '', NULL, 'load_more...', 'Load more', 'تحميل المزيد', 'Meer laden', 'Charger plus', 'Mehr laden', 'Carica di più', 'Carregue mais', 'Загрузи больше', 'Carga más', 'Daha fazla yükle'),
(39, '', NULL, 'stickers', 'Stickers', 'ملصقات', 'stickers', 'Des autocollants', 'Aufkleber', 'Adesivi', 'Adesivos', 'Наклейки', 'Pegatinas', 'Çıkartma'),
(40, '', NULL, 'very_low', 'Very low', 'منخفظ جدا', 'Heel laag', 'Très lent', 'Sehr niedrig', 'Molto basso', 'Muito baixo', 'Очень низкий', 'Muy bajo', 'Çok düşük'),
(41, '', NULL, 'popularity', 'Popularity', 'شعبية', 'populariteit', 'Popularité', 'Popularität', 'Popolarità', 'Popularidade', 'популярность', 'Popularidad', 'Popülerlik'),
(42, '', NULL, 'increase', 'Increase', 'زيادة', 'Toenemen', 'Augmenter', 'Erhöhen, ansteigen', 'Aumentare', 'Aumentar', 'Увеличение', 'Incrementar', 'Artırmak'),
(43, '', NULL, 'premium_users', 'Premium Users', 'المستخدمين المميزين', 'Premium gebruikers', 'Utilisateurs Premium', 'Premium-Benutzer', 'Utenti Premium', 'Usuários Premium', 'Премиум пользователи', 'Usuarios Premium', 'Premium Kullanıcılar'),
(44, '', NULL, 'add_me', 'Add Me', 'أضفني', 'Voeg me toe', 'Ajoute moi', 'Füg mich hinzu', 'Aggiungimi', 'Me adicione', 'Добавь меня', 'Agrégame', 'Beni ekle'),
(45, '', NULL, 'who_ages', 'who ages', 'من الاعمار', 'wie ouder wordt', 'qui vieillit', 'wer altert', 'chi invecchia', 'quem envelhece', 'кто стареет', 'quien envejece', 'kim yaşlanır'),
(46, '', NULL, 'located_within', 'located within', 'تقع داخل', 'gevestigd binnen', 'située à l\'intérieur', 'befindet sich innerhalb', 'situato all\'interno', 'localizado dentro', 'расположен в', 'ubicado dentro de', 'sınırları içindedir'),
(47, '', NULL, 'km_of', 'km of', 'كم من', 'km van', 'km de', 'km von', 'km di', 'km de', 'км', 'km de', 'km'),
(48, '', NULL, 'apply_filters', 'Apply Filters', 'تطبيق المرشحات', 'Filters toepassen', 'Appliquer des filtres', 'Filter anwenden', 'Applica filtri', 'Aplicar filtros', 'Применить фильтры', 'Aplicar filtros', 'Filtreleri Uygula'),
(49, '', NULL, 'close_filters', 'Close Filters', 'إغلاق الفلاتر', 'Filters sluiten', 'Fermer les filtres', 'Filter schließen', 'Chiudi filtri', 'Fechar filtros', 'Закрыть фильтры', 'Cerrar filtros', 'Filtreleri Kapat'),
(50, '', NULL, 'basic', 'Basic', 'الأساسية', 'basis-', 'De base', 'Basic', 'Di base', 'Basic', 'основной', 'BASIC', 'Temel'),
(51, '', NULL, 'looks', 'Looks', 'تبدو', 'looks', 'Regards', 'Sieht aus', 'Sembra', 'Parece', 'Видать', 'Miradas', 'Görünüyor'),
(52, '', NULL, 'background', 'Background', 'خلفية', 'Achtergrond', 'Contexte', 'Hintergrund', 'sfondo', 'fundo', 'Фон', 'Fondo', 'Arka fon'),
(53, '', NULL, 'lifestyle', 'Lifestyle', 'لايف ستايل', 'Lifestyle', 'Mode de vie', 'Lebensstil', 'Stile di vita', 'Estilo de vida', 'образ жизни', 'Estilo de vida', 'Yaşam tarzı'),
(54, '', NULL, 'more', 'More', 'أكثر من', 'Meer', 'Plus', 'Mehr', 'Di Più', 'Mais', 'Больше', 'Más', 'Daha'),
(55, '', NULL, 'gender', 'Gender', 'جنس', 'Geslacht', 'Le sexe', 'Geschlecht', 'Genere', 'Gênero', 'Пол', 'Género', 'Cinsiyet'),
(56, '', NULL, 'location', 'Location', 'موقعك', 'Plaats', 'Emplacement', 'Ort', 'Posizione', 'Localização', 'Место нахождения', 'Ubicación', 'yer'),
(57, '', NULL, 'start_typing..', 'Start typing..', 'ابدأ الطباعة..', 'Beginnen met typen..', 'Commencer à écrire..', 'Beginne zu tippen..', 'Iniziare a digitare..', 'Começe a digitar..', 'Начните печатать ..', 'Comience a escribir ...', 'Yazmaya başla ..'),
(58, '', NULL, 'ages', 'Ages', 'الأعمار', 'Ages', 'Âge', 'Alter', 'evo', 'Idades', 'Ages', 'Siglos', 'Yaşlar'),
(59, '', NULL, 'distance', 'Distance', 'مسافه: بعد', 'Afstand', 'Distance', 'Entfernung', 'Distanza', 'Distância', 'Расстояние', 'Distancia', 'Mesafe'),
(60, '', NULL, 'search', 'Search', 'بحث', 'Zoeken', 'Chercher', 'Suche', 'Ricerca', 'Procurar', 'Поиск', 'Buscar', 'Arama'),
(61, '', NULL, 'height', 'Height', 'ارتفاع', 'Hoogte', 'la taille', 'Höhe', 'Altezza', 'Altura', 'Рост', 'Altura', 'Yükseklik'),
(62, '', NULL, 'body_type', 'Body type', 'نوع الجسم', 'Lichaamstype', 'Type de corps', 'Körpertyp', 'Tipo di corpo', 'Tipo de corpo', 'Телосложение', 'Tipo de cuerpo', 'Vücut tipi'),
(63, '', NULL, 'language', 'Language', 'لغة', 'Taal', 'La langue', 'Sprache', 'linguaggio', 'Língua', 'язык', 'Idioma', 'Dil'),
(64, '', NULL, 'ethnicity', 'Ethnicity', 'الأصل العرقي', 'Afkomst', 'Ethnicité', 'Ethnizität', 'Razza', 'Etnia', 'Этнос', 'Etnicidad', 'Etnik köken'),
(65, '', NULL, 'religion', 'Religion', 'دين', 'Religie', 'Religion', 'Religion', 'Religione', 'Religião', 'религия', 'Religión', 'Din'),
(66, '', NULL, 'status', 'Status', 'الحالة', 'staat', 'Statut', 'Status', 'Stato', 'Status', 'Статус', 'Estado', 'durum'),
(67, '', NULL, 'smokes', 'Smokes', 'يدخن', 'Rook', 'Fume', 'Raucht', 'Smokes', 'Fuma', 'курит', 'Fuma', 'dumanlar'),
(68, '', NULL, 'drinks', 'Drinks', 'مشروبات', 'Drankjes', 'Boissons', 'Getränke', 'Bevande', 'Bebidas', 'напитки', 'Las bebidas', 'İçecekler'),
(69, '', NULL, 'by_interest', 'By Interest', 'حسب الفائدة', 'Op interesse', 'Par intérêt', 'Von Interesse', 'Per interesse', 'Por interesse', 'По интересам', 'Por interes', 'İlgi alanlarına göre'),
(70, '', NULL, 'e.g.__singing', 'e.g Singing', 'على سبيل المثال الغناء', 'bijvoorbeeld zingen', 'par exemple chanter', 'z.B. Singen', 'per esempio canto', 'por exemplo, cantando', 'например, пение', 'por ejemplo, cantando', 'örneğin şarkı söylemek'),
(71, '', NULL, 'education', 'Education', 'التعليم', 'Opleiding', 'Éducation', 'Bildung', 'Formazione scolastica', 'Educação', 'образование', 'Educación', 'Eğitim'),
(72, '', NULL, 'pets', 'Pets', 'الحيوانات الأليفة', 'Huisdieren', 'Animaux domestiques', 'Haustiere', 'Animali', 'Animais de estimação', 'Домашние питомцы', 'Mascotas', 'Evcil Hayvanlar'),
(73, '', NULL, 'no_more_users_to_show.', 'No more users to show', 'لا مزيد من المستخدمين للعرض', 'Geen gebruikers meer om te laten zien', 'Pas plus d\'utilisateurs à montrer', 'Keine weiteren Benutzer zum Anzeigen', 'Nessun altro utente da mostrare', 'Não há mais usuários para mostrar', 'Нет больше пользователей, чтобы показать', 'No hay más usuarios para mostrar', 'Gösterilecek başka kullanıcı yok'),
(74, '', NULL, 'random_users', 'Random Users', 'مستخدم عشوائي', 'Willekeurige gebruikers', 'Utilisateurs aléatoires', 'Zufällige Benutzer', 'Utenti casuali', 'Usuários aleatórios', 'Случайные пользователи', 'Usuarios Aleatorios', 'Rasgele Kullanıcılar'),
(75, '', NULL, 'copyright', 'Copyright', 'حقوق النشر', 'auteursrechten', 'droits d\'auteur', 'Urheberrechte ©', 'Diritto d\'autore', 'direito autoral', 'авторское право', 'Derechos de autor', 'telif hakkı'),
(76, '', NULL, 'all_rights_reserved', 'All rights reserved', 'كل الحقوق محفوظة', 'Alle rechten voorbehouden', 'Tous les droits sont réservés', 'Alle Rechte vorbehalten', 'Tutti i diritti riservati', 'Todos os direitos reservados', 'Все права защищены', 'Todos los derechos reservados', 'Tüm hakları Saklıdır'),
(77, '', NULL, 'about_us', 'About Us', 'معلومات عنا', 'Over ons', 'À propos de nous', 'Über uns', 'Riguardo a noi', 'Sobre nós', 'Насчет нас', 'Sobre nosotros', 'Hakkımızda'),
(78, '', NULL, 'terms', 'Terms', 'شروط', 'Voorwaarden', 'termes', 'Bedingungen', 'condizioni', 'Termos', 'термины', 'Condiciones', 'şartlar'),
(79, '', NULL, 'privacy_policy', 'Privacy Policy', 'سياسة خاصة', 'Privacybeleid', 'Politique de confidentialité', 'Datenschutz-Bestimmungen', 'politica sulla riservatezza', 'Política de Privacidade', 'политика конфиденциальности', 'Política de privacidad', 'Gizlilik Politikası'),
(80, '', NULL, 'contact', 'Contact', 'اتصل', 'Contact', 'Contact', 'Kontakt', 'Contatto', 'Contato', 'контакт', 'Contacto', 'Temas'),
(81, '', NULL, 'get_seen_more_by_people_around_you_in_find_match.', 'Get seen more by people around you in find match.', 'مشاهدة المزيد من الأشخاص من حولك في العثور على المطابقة.', 'Wordt meer gezien door mensen om je heen in een match.', 'Faites-vous plus voir par les gens autour de vous dans match de recherche.', 'Werden Sie mehr von Menschen um Sie herum gefunden.', 'Fatti vedere di più dalle persone intorno a te nella ricerca della corrispondenza.', 'Seja visto mais por pessoas ao seu redor em encontrar correspondência.', 'Будь замечен людьми вокруг тебя в поиске соответствия.', 'Hazte ver más por las personas a tu alrededor en match match.', 'Çevrenizdeki insanlar tarafından eşleşme bulurken daha fazla görün.'),
(82, '', NULL, 'this_service_costs_you', 'This service costs you', 'هذه الخدمة تكلفك', 'Deze service kost je', 'Ce service vous coûte', 'Dieser Service kostet Sie', 'Questo servizio ti costa', 'Este serviço custa-lhe', 'Эта услуга стоит вам', 'Este servicio te cuesta', 'Bu servis size maliyeti'),
(83, '', NULL, 'credits_and_will_last_for', 'credits and will last for', 'الاعتمادات وسوف تستمر ل', 'credits en zal duren voor', 'crédits et durera pour', 'Credits und wird dauern', 'crediti e durerà per', 'créditos e vai durar por', 'кредиты и будет длиться', 'créditos y durará por', 'krediler ve sürecek'),
(84, '', NULL, 'miuntes', 'miuntes', 'دقائق', 'miuntes', 'miuntes', 'Miuntes', 'miuntes', 'miuntes', 'miuntes', 'miuntes', 'miuntes'),
(85, '', NULL, 'cancel', 'Cancel', 'إلغاء', 'annuleren', 'Annuler', 'Stornieren', 'Annulla', 'Cancelar', 'отменить', 'Cancelar', 'İptal etmek'),
(86, '', NULL, 'boost_now', 'Boost Now', 'زد الآن', 'Boost nu', 'Boost maintenant', 'Boost Now', 'Aumenta ora', 'Aumente Agora', 'Повысьте сейчас', 'Aumentar ahora', 'Şimdi Yükselt'),
(87, '', NULL, 'ago', 'ago', 'منذ', 'geleden', 'depuis', 'vor', 'fa', 'atrás', 'тому назад', 'hace', 'önce'),
(88, '', NULL, 'from_now', 'from now', 'من الان', 'vanaf nu', 'à partir de maintenant', 'in', 'da adesso', 'a partir de agora', 'отныне', 'desde ahora', 'şu andan itibaren'),
(89, '', NULL, 'any_moment_now', 'any moment now', 'في اي لحظة الان', 'elk moment nu', 'n\'importe quel moment maintenant', 'jeden Moment jetzt', 'da un momento all\'altro', 'qualquer momento agora', 'в любой момент', 'cualquier momento ahora', 'her an şimdi'),
(90, '', NULL, '_d_minutes_ago', '%d minutes ago', 'قبل %d دقيقة', '%d minuten geleden', 'il y a %d minutes', 'vor %d Minuten', '%d minuti fa', '%d minutos atrás', '%d минут назад', 'Hace %d minutos', '%d dakika önce'),
(91, '', NULL, 'about_an_hour_ago', 'about an hour ago', 'منذ ساعة تقريبا', 'ongeveer een uur geleden', 'il y a à peu près une heure', 'vor ungefähr einer Stunde', 'circa un\'ora fa', 'cerca de uma hora atrás', 'около часа назад', 'Hace aproximadamente una hora', 'yaklaşık bir saat önce'),
(92, '', NULL, '_d_hours_ago', '%d hours ago', 'قبل %d ساعة', '%d uur geleden', 'il y a %d heures', 'Vor %d Stunden', '%d ore fa', '%d horas atrás', '%d часов назад', 'Hace %d horas', '%d saat önce'),
(93, '', NULL, 'a_day_ago', 'a day ago', 'قبل يوم', 'een dag geleden', 'il y a un jour', 'vor einem Tag', 'un giorno fa', 'um dia atrás', 'день назад', 'Hace un día', 'bir gün önce'),
(94, '', NULL, '_d_days_ago', '%d days ago', 'قبل %d يومًا', '%d dagen geleden', 'il y a %d jours', 'vor %d Tagen', '%d giorni fa', '%d dias atrás', '%d дней назад', 'Hace %d días', '%d gün önce'),
(95, '', NULL, 'about_a_month_ago', 'about a month ago', 'منذ شهر تقريبا', 'ongeveer een maand geleden', 'il y a environ un mois', 'vor ungefähr einem Monat', 'circa un mese fa', 'mais ou menos um mês atrás', 'Около месяца назад', 'Hace más o menos un mes', 'yaklaşık bir ay önce'),
(96, '', NULL, '_d_months_ago', '%d months ago', 'قبل شهر', '%d maanden geleden', 'il y a %d mois', 'vor %d Monaten', '%d mesi fa', '%d meses atrás', '%d месяцев назад', 'Hace %d meses', '%d ay önce'),
(97, '', NULL, 'about_a_year_ago', 'about a year ago', 'قبل نحو سنة', 'ongeveer een jaar geleden', 'il y a un an à peu près', 'vor etwa einem Jahr', 'circa un anno fa', 'cerca de um ano atrás', 'около года назад', 'Hace un año', 'yaklaşık bir yıl önce'),
(98, '', NULL, 'loading...', 'Loading..', 'جار التحميل..', 'Bezig met laden..', 'Chargement..', 'Wird geladen..', 'Caricamento in corso..', 'Carregando..', 'Загрузка ..', 'Cargando..', 'Yükleniyor..'),
(99, '', NULL, 'payment_declined', 'Payment declined', 'تم رفض الدفع', 'Betaling geweigerd', 'Paiement refusé', 'Zahlung abgelehnt', 'Pagamento rifiutato', 'Pagamento Recusado', 'Платеж отклонен', 'Pago rechazado', 'Ödeme Reddedildi'),
(100, '', NULL, 'amazing', 'Amazing', 'رائعة حقا', 'Verbazingwekkend', 'Incroyable', 'Tolle', 'Stupefacente', 'Surpreendente', 'Удивительно', 'Increíble', 'şaşırtıcı'),
(101, '', NULL, 'features_you_can___t_live_without', 'features you can’t live without', 'ميزات لا يمكنك العيش بدونها', 'functies waar je niet zonder kunt', 'fonctionnalités que vous ne pouvez pas vivre sans', 'Funktionen, die Sie nicht ohne leben können', 'caratteristiche che non puoi vivere senza', 'recursos que você não pode viver sem', 'функции, без которых вы не можете жить', 'características que no puedes vivir sin', 'olmadan yaşayamayacağınız özellikler'),
(102, '', NULL, 'activating_premium_will_help_you_meet_more_people__faster.', 'Activating Premium will help you meet more people, faster.', 'يساعدك تنشيط الإصدار على مقابلة المزيد من الأشخاص بشكل أسرع.', 'Door Premium te activeren, kunt u sneller meer mensen ontmoeten.', 'L\'activation de Premium vous aidera à rencontrer plus de personnes, plus rapidement.', 'Durch die Aktivierung von Premium können Sie schneller auf mehr Menschen treffen.', 'L\'attivazione di Premium ti aiuterà a incontrare più persone, più velocemente.', 'A ativação do Premium ajudará você a conhecer mais pessoas com mais rapidez.', 'Активация Premium поможет вам быстрее встретить больше людей.', 'Activar Premium te ayudará a conocer a más personas, más rápido.', 'Premium\'un etkinleştirilmesi daha fazla kişiyle daha hızlı tanışmanıza yardımcı olur.'),
(103, '', NULL, 'choose_a_plan', 'Choose a Plan', 'اختر خطة', 'Kies een plan', 'Choisissez un plan', 'Wähle einen Plan', 'Scegli un piano', 'Escolha um plano', 'Выберите план', 'Elige un plan', 'Bir Plan Seç'),
(104, '', NULL, 'weekly', 'Weekly', 'أسبوعي', 'Wekelijks', 'Hebdomadaire', 'Wöchentlich', 'settimanalmente', 'Semanal', 'еженедельно', 'Semanal', 'Haftalık'),
(105, '', NULL, 'monthly', 'Monthly', 'شهريا', 'Maandelijks', 'Mensuel', 'Monatlich', 'Mensile', 'Por mês', 'ежемесячно', 'Mensual', 'Aylık'),
(106, '', NULL, 'most_popular', 'Most popular', 'الأكثر شعبية', 'Meest populair', 'Le plus populaire', 'Am beliebtesten', 'Più popolare', 'Mais popular', 'Самый популярный', 'Más popular', 'En popüler'),
(107, '', NULL, 'yearly', 'Yearly', 'سنوي', 'jaar-', 'Annuel', 'Jährlich', 'Annuale', 'Anual', 'каждый год', 'Anual', 'Yıllık'),
(108, '', NULL, 'lifetime', 'Lifetime', 'أوقات الحياة', 'Levenslang', 'Durée de vie', 'Lebenszeit', 'Tutta la vita', 'Tempo de vida', 'Продолжительность жизни', 'Toda la vida', 'Ömür'),
(109, '', NULL, 'pay_using', 'Pay Using', 'دفع باستخدام', 'Betaal met', 'Payer en utilisant', 'Zahlen Sie mit', 'Pagare usando', 'Pague usando', 'Оплатить с помощью', 'Pagar usando', 'Kullanarak Öde'),
(110, '', NULL, 'paypal', 'PayPal', 'باي بال', 'PayPal', 'Pay Pal', 'PayPal', 'PayPal', 'PayPal', 'PayPal', 'PayPal', 'PayPal'),
(111, '', NULL, 'card', 'Card', 'بطاقة', 'Kaart', 'Carte', 'Karte', 'Carta', 'Cartão', 'Карта', 'Tarjeta', 'kart'),
(112, '', NULL, 'why_choose_premium_membership', 'Why Choose Premium Membership', 'لماذا اختيار عضوية بريميوم', 'Waarom kiezen voor Premium-lidmaatschap', 'Pourquoi choisir un abonnement Premium?', 'Warum wählen Sie eine Premium-Mitgliedschaft?', 'Perché scegliere l\'abbonamento Premium', 'Por que escolher uma assinatura premium?', 'Почему стоит выбрать премиум-членство', 'Por qué elegir membresía premium', 'Neden Premium Üyeliği Seçmelisiniz?'),
(113, '', NULL, 'see_more_stickers_on_chat', 'Get more stickers in chat', 'احصل على المزيد من الملصقات في الدردشة', 'Krijg meer stickers in de chat', 'Obtenez plus d\'autocollants dans le chat', 'Bekommen Sie mehr Aufkleber im Chat', 'Ottieni più adesivi nella chat', 'Obtenha mais autocolantes no chat', 'Получить больше стикеров в чате', 'Consigue más pegatinas en el chat', 'Sohbette daha fazla etiket edinin'),
(114, '', NULL, 'show_in_premium_bar', 'Show yourself in premium bar', 'تظهر نفسك في شريط قسط', 'Laat jezelf zien in premium bar', 'Montrez-vous au bar premium', 'Zeigen Sie sich in der Premium-Bar', 'Mostrati nel bar premium', 'Mostre-se na barra premium', 'Покажите себя в премиум баре', 'Muéstrate en barra premium', 'Kendinizi premium barda gösterin'),
(115, '', NULL, 'see_likes_notifications', 'View likes notifications', 'عرض إبداء الإعجابات', 'Bekijk leuke meldingen', 'Voir les notifications J\'aime', 'Lik-Benachrichtigungen anzeigen', 'Visualizza le notifiche di Mi piace', 'Ver notificações de gostos', 'Просмотр лайков', 'Ver notificaciones de Me gusta', 'Beğenilen bildirimleri görüntüle'),
(116, '', NULL, 'get_discount_when_buy_boost_me', 'Get a discount when using \"boost me\"', 'احصل على خصم عند استخدام ', 'Krijg een korting bij het gebruik van ', 'Obtenez une réduction lorsque vous utilisez ', 'Erhalten Sie einen Rabatt, wenn Sie ', 'Ottieni uno sconto usando ', 'Receba um desconto ao usar ', 'Получи скидку при использовании ', 'Obtén un descuento al usar ', 'Beni desteklerken indirim kazanın'),
(117, '', NULL, 'display_first_in_find_matches', 'Display first in find matches', 'عرض أولاً في العثور على التطابقات', 'Eerst weergeven in overeenkomsten zoeken', 'Afficher en premier dans les correspondances', 'Zuerst in Übereinstimmungen anzeigen', 'Visualizza prima nelle corrispondenze di ricerca', 'Exibir primeiro em encontrar correspondências', 'Отображать первым в поиске совпадений', 'Mostrar primero en encontrar coincidencias', 'İlk önce eşleşmelerde göster'),
(118, '', NULL, 'display_on_top_in_random_users', 'Display on top in random users', 'عرض في الأعلى في المستخدمين العشوائيين', 'Weergave bovenaan in willekeurige gebruikers', 'Afficher sur le dessus des utilisateurs aléatoires', 'Anzeige bei zufälligen Benutzern', 'Mostra in cima a utenti casuali', 'Exibir no topo em usuários aleatórios', 'Отображать сверху у случайных пользователей', 'Mostrar en la parte superior en usuarios aleatorios', 'Rastgele kullanıcılarda en üstte görüntüle'),
(119, '', NULL, 'your_popularity_', 'Your Popularity:', 'الشعبية الخاصة بك:', 'Uw populariteit:', 'Votre Popularité:', 'Ihre Beliebtheit:', 'La tua popolarità:', 'Sua popularidade:', 'Ваша популярность:', 'Su popularidad:', 'Popülerlik:'),
(120, '', NULL, 'increase_your_popularity_with_credits_and_enjoy_the_features.', 'Increase your popularity with credits and enjoy the features.', 'زيادة شعبيتك مع الاعتمادات والتمتع بالمزايا.', 'Vergroot je populariteit met credits en geniet van de functies.', 'Augmentez votre popularité avec des crédits et profitez des fonctionnalités.', 'Steigern Sie Ihre Beliebtheit mit Credits und genießen Sie die Funktionen.', 'Aumenta la tua popolarità con crediti e goditi le funzionalità.', 'Aumente sua popularidade com créditos e aproveite os recursos.', 'Увеличьте свою популярность с кредитами и наслаждайтесь функциями.', 'Aumenta tu popularidad con créditos y disfruta de las características.', 'Popülaritenizi kredilerle arttırın ve özelliklerin tadını çıkarın.'),
(122, '', NULL, 'x10_visits', 'x10 Visits', 'زيارات X10', 'x10 bezoeken', 'x10 visites', 'x10 Besuche', 'x10 visite', 'x10 visitas', 'x10 посещений', 'x10 visitas', 'x10 Ziyaret'),
(123, '', NULL, 'promote_your_profile_by_get_more_visits', 'Promote your profile by getting more visitors', 'تعزيز ملفك الشخصي عن طريق الحصول على المزيد من الزوار', 'Promoot je profiel door meer bezoekers te krijgen', 'Promouvoir votre profil en obtenant plus de visiteurs', 'Werben Sie für Ihr Profil, indem Sie mehr Besucher bekommen', 'Promuovi il tuo profilo attirando più visitatori', 'Promova seu perfil obtendo mais visitantes', 'Продвиньте свой профиль, получая больше посетителей', 'Promociona tu perfil consiguiendo más visitantes.', 'Daha fazla ziyaretçi alarak profilinizi tanıtın'),
(124, '', NULL, 'this_service_will_cost_you', 'this service will cost you', 'هذه الخدمة سوف تكلفك', 'deze service kost je', 'ce service vous coûtera', 'Dieser Service kostet Sie', 'questo servizio ti costerà', 'este serviço vai custar-lhe', 'эта услуга будет стоить вам', 'este servicio te costará', 'bu servis size mal olacak'),
(125, '', NULL, 'for', 'For', 'إلى عن على', 'Voor', 'Pour', 'Zum', 'Per', 'Para', 'За', 'por', 'İçin'),
(126, '', NULL, 'minutes', 'Minutes', 'الدقائق', 'Notulen', 'Minutes', 'Protokoll', 'Minuti', 'Minutos', 'минут', 'Minutos', 'Dakika'),
(127, '', NULL, 'buy_now', 'Buy Now', 'اشتري الآن', 'Koop nu', 'Acheter maintenant', 'Kaufe jetzt', 'Acquista ora', 'Compre', 'купить сейчас', 'Compra ahora', 'Şimdi satın al'),
(128, '', NULL, 'x3_matches', 'x3 Matches', 'X3 المباريات', 'x3 Wedstrijden', 'x3 matchs', 'x3 Übereinstimmungen', 'x3 partite', 'x3 correspondências', 'х3 Матчи', 'x3 coincidencias', 'x3 Maçlar'),
(129, '', NULL, 'shown_more_and_rise_up_at_the_same_time', 'Shown more and rise up at the same time', 'تظهر أكثر وترتفع في نفس الوقت', 'Meer weergeven en op hetzelfde moment opstaan', 'Plus montré et se lever en même temps', 'Mehr gezeigt und gleichzeitig aufstehen', 'Mostrato di più e si alza allo stesso tempo', 'Mostrado mais e se levanta ao mesmo tempo', 'Показано больше и подняться одновременно', 'Se muestra más y se levanta al mismo tiempo.', 'Daha fazla gösterilen ve aynı anda yükselen'),
(130, '', NULL, 'x4_likes', 'x4 Likes', 'x4 يحب', 'x4 houdt van', 'x4 j\'aime', 'x4 Gefällt mir', 'Mi piace x4', 'x4 gostos', 'x4 лайков', 'x4 me gusta', 'x4 Beğeniler'),
(131, '', NULL, 'tell_everyone_you_re_online_and_be_seen_by_users_who_want_to_chat', 'Tell everyone you&#039;re online and be seen by users who want to chat', 'أخبر الجميع بأنك على الإنترنت ومشاهدته من قبل المستخدمين الذين يرغبون في الدردشة', 'Vertel iedereen dat je online bent en wordt gezien door gebruikers die willen chatten', 'Dites à tout le monde que vous êtes en ligne et que les utilisateurs qui veulent chatter soient visibles', 'Sagen Sie allen, die Sie online sind, und werden Sie von Benutzern gesehen, die chatten möchten', 'Dì a tutti che sei online e fatti vedere dagli utenti che vogliono chattare', 'Diga a todos que você está on-line e seja visto por usuários que querem conversar', 'Расскажите всем, что вы онлайн, и вас увидят пользователи, которые хотят общаться', 'Dile a todos que estás en línea y que te vean los usuarios que quieren chatear.', 'Herkese çevrimiçi olduğunu ve sohbet etmek isteyen kullanıcılar tarafından görüldüğünü söyle'),
(132, '', NULL, 'visited_you', 'visited you', 'زار لك', 'heb je bezocht', 'vous a rendu visite', 'besuchte dich', 'ti ho visitato', 'visitou você', 'посетил тебя', 'te visité', 'seni ziyaret ettim'),
(133, '', NULL, 'your', 'Your', 'ك', 'Jouw', 'Votre', 'Ihre', 'Il tuo', 'Seu', 'Ваш', 'Tu', 'Sizin'),
(134, '', NULL, 'credits_balance', 'Credits balance', 'رصيد الاعتمادات', 'Creditsbalans', 'Solde des crédits', 'Guthabenkonto', 'Saldo dei crediti', 'Saldo de créditos', 'Баланс кредитов', 'Saldo de creditos', 'Kredi bakiyesi'),
(135, '', NULL, 'use_your_credits_to', 'Use your Credits to', 'استخدم قروضك ل', 'Gebruik uw Credits om', 'Utilisez vos crédits pour', 'Verwenden Sie Ihre Credits zu', 'Usa i tuoi crediti a', 'Use seus créditos para', 'Используйте свои кредиты для', 'Usa tus créditos para', 'Kredilerinizi kullanın'),
(136, '', NULL, 'boost_your_profile', 'Boost your profile', 'تعزيز ملفك الشخصي', 'Boost je profiel', 'Boostez votre profil', 'Steigern Sie Ihr Profil', 'Migliora il tuo profilo', 'Aumente seu perfil', 'Повысьте свой профиль', 'Aumenta tu perfil', 'Profilini yükselt'),
(137, '', NULL, 'send_a_gift', 'Send a gift', 'ارسل هدية', 'Stuur een cadeau', 'Envoyer un cadeau', 'Ein Geschenk senden', 'Manda un regalo', 'Envie um presente', 'Послать подарок', 'Enviar un regalo', 'Hediye gönder'),
(138, '', NULL, 'get_seen_100x_in_discover', 'Get seen 100x in Discover', 'احصل على المشاهدة 100x في Discover', 'Word 100x gezien in Discover', 'Être vu 100x dans Discover', 'Erhalten Sie 100x in Discover', 'Scopri 100x in Scopri', 'Seja visto 100 vezes no Discover', '100 раз вас увидят в Discover', 'Hazte ver 100x en Discover', 'Discover\'da 100x görün'),
(139, '', NULL, 'put_yourself_first_in_search', 'Put yourself First in Search', 'ضع نفسك أولا في البحث', 'Zet jezelf op de eerste plaats in zoeken', 'Mettez-vous d\'abord dans la recherche', 'Setzen Sie sich an erster Stelle der Suche', 'Mettiti al primo posto nella ricerca', 'Coloque-se em primeiro lugar na pesquisa', 'Поставь себя первым в поиске', 'Ponte en primer lugar en la búsqueda', 'Aramada Kendinizi İlk Alın'),
(140, '', NULL, 'get_additional_stickers', 'Get additional Stickers', 'احصل على ملصقات إضافية', 'Krijg extra stickers', 'Obtenir des autocollants supplémentaires', 'Zusätzliche Aufkleber erhalten', 'Ottieni adesivi aggiuntivi', 'Get adicional Adesivos', 'Получить дополнительные наклейки', 'Obtener pegatinas adicionales', 'Ek Çıkartmalar edinin'),
(141, '', NULL, 'double_your_chances_for_a_friendship', 'Double your chances for a friendship', 'مضاعفة فرصك في الصداقة', 'Verdubbel je kansen op een vriendschap', 'Double tes chances d\'amitié', 'Verdopple deine Chancen für eine Freundschaft', 'Raddoppia le tue possibilità di amicizia', 'Dobre suas chances de amizade', 'Удвойте свои шансы на дружбу', 'Duplica tus posibilidades de amistad', 'Arkadaşlık şansını ikiye katla'),
(142, '', NULL, 'buy_credits', 'Buy Credits', 'شراء إئتمانات', 'Koop tegoed', 'Acheter des crédits', 'Guthaben kaufen', 'Comprare crediti', 'Compre créditos', 'Купить кредиты', 'Compra creditos', 'Kredi satın Al'),
(143, '', NULL, 'bag_of_credits', 'Bag of Credits', 'حقيبة من قروض', 'Zak met Credits', 'Sac de crédits', 'Tasche mit Credits', 'Borsa dei crediti', 'Bolsa de Créditos', 'Сумка кредитов', 'Bolsa de creditos', 'Kredi Çantaları'),
(144, '', NULL, 'box_of_credits', 'Box of Credits', 'صندوق الاعتمادات', 'Box of Credits', 'Boîte de crédits', 'Kiste mit Credits', 'Scatola di crediti', 'Caixa de Créditos', 'Коробка кредитов', 'Caja de creditos', 'Kredi Kutusu'),
(145, '', NULL, 'chest_of_credits', 'Chest of Credits', 'الصدر من قروض', 'Chest of Credits', 'Coffre de crédits', 'Truhe mit Credits', 'Cassa dei crediti', 'Baú de Créditos', 'Сундук с кредитами', 'Cofre de creditos', 'Kredi Sandığı'),
(146, '', NULL, 'year', 'year', 'عام', 'jaar', 'année', 'Jahr', 'anno', 'ano', 'год', 'año', 'yıl'),
(147, '', NULL, 'month', 'month', 'شهر', 'maand', 'mois', 'Monat', 'mese', 'mês', 'месяц', 'mes', 'ay'),
(148, '', NULL, 'day', 'day', 'يوم', 'dag', 'journée', 'Tag', 'giorno', 'dia', 'день', 'día', 'gün'),
(149, '', NULL, 'hour', 'hour', 'ساعة', 'uur', 'heure', 'Stunde', 'ora', 'hora', 'час', 'hora', 'saat'),
(150, '', NULL, 'minute', 'minute', 'اللحظة', 'minuut', 'minute', 'Minute', 'minuto', 'minuto', 'минут', 'minuto', 'dakika'),
(151, '', NULL, 'second', 'second', 'ثانيا', 'tweede', 'seconde', 'zweite', 'secondo', 'segundo', 'второй', 'segundo', 'ikinci'),
(152, '', NULL, 'years', 'years', 'سنوات', 'jaar', 'années', 'Jahre', 'anni', 'anos', 'лет', 'años', 'yıl'),
(153, '', NULL, 'months', 'months', 'الشهور', 'maanden', 'mois', 'Monate', 'mesi', 'meses', 'месяцы', 'meses', 'ay'),
(154, '', NULL, 'days', 'days', 'أيام', 'dagen', 'journées', 'Tage', 'giorni', 'dias', 'дней', 'dias', 'günler'),
(155, '', NULL, 'hours', 'hours', 'ساعات', 'uur', 'heures', 'Std', 'ore', 'horas', 'часов', 'horas', 'saatler'),
(156, '', NULL, 'seconds', 'seconds', 'ثواني', 'seconden', 'secondes', 'Sekunden', 'secondi', 'segundos', 'секунд', 'segundos', 'saniye'),
(157, '', NULL, 'please_enable_location_services_on_your_browser.', 'Please enable location services on your browser.', 'يرجى تمكين خدمات الموقع على متصفحك.', 'Schakel locatiediensten in uw browser in.', 'Veuillez activer les services de localisation sur votre navigateur.', 'Bitte aktivieren Sie die Ortungsdienste in Ihrem Browser.', 'Si prega di abilitare i servizi di localizzazione sul browser.', 'Por favor, habilite os serviços de localização no seu navegador.', 'Пожалуйста, включите службы определения местоположения в вашем браузере.', 'Por favor habilite los servicios de localización en su navegador.', 'Lütfen tarayıcınızdaki konum servislerini etkinleştirin.'),
(158, '', NULL, 'change_photo', 'Change Avatar', 'تغيير الصورة الرمزية', 'Verander Avatar', 'Changer d\'avatar', 'Avatar ändern', 'Cambia avatar', 'Mudar Avatar', 'Сменить аватар', 'Cambiar avatar', 'Avatarı değiştir'),
(159, '', NULL, 'upgrade', 'Upgrade', 'تطوير', 'Upgrade', 'Améliorer', 'Aktualisierung', 'aggiornamento', 'Atualizar', 'Обновить', 'Mejorar', 'Yükselt'),
(160, '', NULL, 'profile_completion', 'Profile Completion', 'إتمام الملف الشخصي', 'Profiel voltooiing', 'Achèvement du profil', 'Profil Fertigstellung', 'Completamento del profilo', 'Conclusão do perfil', 'Завершение профиля', 'Completar perfil', 'Profil Tamamlama'),
(161, '', NULL, 'this_profile_is_verified', 'This profile is verified', 'تم التحقق من هذا الملف الشخصي', 'Dit profiel is geverifieerd', 'Ce profil est vérifié', 'Dieses Profil ist verifiziert', 'Questo profilo è verificato', 'Este perfil é verificado', 'Этот профиль подтвержден', 'Este perfil esta verificado', 'Bu profil doğrulandı'),
(162, '', NULL, 'edit', 'Edit', 'تصحيح', 'Bewerk', 'modifier', 'Bearbeiten', 'modificare', 'Editar', 'редактировать', 'Editar', 'Düzenle'),
(163, '', NULL, 'views', 'Views', 'الآراء', 'Keer bekeken', 'Des vues', 'Ansichten', 'Visualizzazioni', 'Views', 'Просмотры', 'Puntos de vista', 'Görünümler'),
(164, '', NULL, 'add_photos', 'Add Photos', 'إضافة الصور', 'Voeg foto\'s toe', 'Ajouter des photos', 'Fotos hinzufügen', 'Aggiungi foto', 'Adicionar fotos', 'Добавить фотографии', 'Agregar fotos', 'Fotoğraf ekle'),
(165, '', NULL, 'interests', 'Interests', 'الإهتمامات', 'Interesses', 'Intérêts', 'Interessen', 'Interessi', 'Interesses', 'интересы', 'Intereses', 'İlgi'),
(166, '', NULL, 'profile_info', 'Profile Info', 'معلومات الشخصي', 'Profielinformatie', 'Information de profil', 'Profil Information', 'Informazioni sul profilo', 'Informações do perfil', 'Информация о профиле', 'Información de perfil', 'Profil bilgisi'),
(167, '', NULL, 'preferred_language', 'Preferred Language', 'اللغة المفضلة', 'Voorkeurstaal', 'langue préférée', 'Bevorzugte Sprache', 'Lingua preferita', 'língua preferida', 'предпочтительный язык', 'Idioma preferido', 'tercih edilen dil'),
(168, '', NULL, 'hair_color', 'Hair color', 'لون الشعر', 'Haarkleur', 'Couleur de cheveux', 'Haarfarbe', 'Colore dei capelli', 'Cor de cabelo', 'Цвет волос', 'Color de pelo', 'Saç rengi'),
(169, '', NULL, 'upload_completion', 'Upload Completion', 'اكتمال التحميل', 'Upload voltooiing', 'Achèvement du téléchargement', 'Upload-Abschluss', 'Upload Completion', 'Upload Completion', 'Завершение загрузки', 'Cargar finalización', 'Yükleme Tamamlandı'),
(170, '', NULL, 'general', 'General', 'جنرال لواء', 'Algemeen', 'Général', 'Allgemeines', 'Generale', 'Geral', 'генеральный', 'General', 'Genel'),
(171, '', NULL, 'privacy', 'Privacy', 'الإجمالية', 'Privacy', 'Intimité', 'Privatsphäre', 'vita privata', 'Privacidade', 'Конфиденциальность', 'Intimidad', 'Gizlilik'),
(172, '', NULL, 'password', 'Password', 'كلمه السر', 'Wachtwoord', 'Mot de passe', 'Passwort', 'Parola d\'ordine', 'Senha', 'пароль', 'Contraseña', 'Parola'),
(173, '', NULL, 'social_links', 'Social Links', 'روابط اجتماعية', 'Sociale links', 'Liens sociaux', 'Soziale Links', 'Collegamenti sociali', 'Links Sociais', 'Социальные ссылки', 'vínculos sociales', 'Sosyal bağlantılar'),
(174, '', NULL, 'blocked_users', 'Blocked Users', 'مستخدمين محجوبين', 'Geblokkeerde gebruikers', 'Utilisateurs bloqués', 'Blockierte Benutzer', 'Utenti bloccati', 'Usuários bloqueados', 'Заблокированные пользователи', 'Usuarios bloqueados', 'Engellenmiş kullanıcılar'),
(175, '', NULL, 'first_name', 'First Name', 'الاسم الاول', 'Voornaam', 'Prénom', 'Vorname', 'Nome di battesimo', 'Primeiro nome', 'Имя', 'Nombre de pila', 'İsim'),
(176, '', NULL, 'last_name', 'Last Name', 'الكنية', 'Achternaam', 'Nom de famille', 'Nachname', 'Cognome', 'Último nome', 'Фамилия', 'Apellido', 'Soyadı'),
(177, '', NULL, 'username', 'Username', 'اسم المستخدم', 'Gebruikersnaam', 'Nom d\'utilisateur', 'Nutzername', 'Nome utente', 'Nome de usuário', 'имя пользователя', 'Nombre de usuario', 'Kullanıcı adı'),
(178, '', NULL, 'email', 'Email', 'البريد الإلكتروني', 'E-mail', 'Email', 'Email', 'E-mail', 'O email', 'Эл. адрес', 'Email', 'E-posta'),
(179, '', NULL, 'choose_your_country', 'Choose your country', 'اختر بلدك', 'Kies je land', 'Choisis ton pays', 'Wähle dein Land', 'Scegli il tuo paese', 'Escolha seu país', 'Выберите вашу страну', 'Elige tu país', 'Ülkenizi seçin'),
(180, '', NULL, 'country', 'Country', 'بلد', 'land', 'Pays', 'Land', 'Nazione', 'País', 'Страна', 'País', 'ülke'),
(181, '', NULL, 'mobile_number', 'Phone Number', 'رقم الهاتف', 'Telefoonnummer', 'Numéro de téléphone', 'Telefonnummer', 'Numero di telefono', 'Número de telefone', 'Номер телефона', 'Número de teléfono', 'Telefon numarası'),
(182, '', NULL, 'birth_date', 'Birthday', 'عيد الميلاد', 'Verjaardag', 'Anniversaire', 'Geburtstag', 'Compleanno', 'Aniversário', 'день рождения', 'Cumpleaños', 'Doğum günü'),
(183, '', NULL, 'free_member', 'Free Member', 'عضو مجاني', 'gratis lid', 'Membre gratuit', 'Freies Mitglied', 'Membro gratuito', 'Membro grátis', 'Бесплатный участник', 'miembro gratuito', 'Ücretsiz Üye'),
(184, '', NULL, 'pro_member', 'Pro Member', 'عضو محترف', 'Pro Lid', 'Membre Pro', 'Pro-Mitglied', 'Membro Pro', 'Membro Pro', 'Pro Member', 'Miembro Pro', 'Pro Üyesi'),
(185, '', NULL, 'save', 'Save', 'حفظ', 'Opslaan', 'sauvegarder', 'sparen', 'Salvare', 'Salve ', 'Сохранить', 'Salvar', 'Kayıt etmek'),
(186, '', NULL, 'about_me', 'About Me', 'عني', 'Over mij', 'À propos de moi', 'Über mich', 'Riguardo a me', 'Sobre mim', 'Обо мне', 'Sobre mi', 'Benim hakkımda'),
(187, '', NULL, 'relationship_status', 'Relationship status', 'الحالة الاجتماعية', 'Relatie status', 'Statut de la relation', 'Beziehungsstatus', 'Stato delle relazioni', 'Status de relacionamento', 'Семейное положение', 'Estado civil', 'İlişki durumu'),
(188, '', NULL, 'work_status', 'Work status', 'حالة العمل', 'Werk status', 'Statut de travail', 'Arbeitsstatus', 'Stato del lavoro', 'Status de trabalho', 'Рабочий статус', 'Situación laboral', 'İş durumu'),
(189, '', NULL, 'education_level', 'Education Level', 'مستوى التعليم', 'Opleidingsniveau', 'niveau d\'éducation', 'Bildungsniveau', 'Livello scolastico', 'Nível de educação', 'Уровень образования', 'Nivel de Educación', 'Eğitim Seviyesi'),
(190, '', NULL, 'character', 'Character', 'حرف', 'Karakter', 'Personnage', 'Charakter', 'Personaggio', 'Personagem', 'символ', 'Personaje', 'Karakter'),
(191, '', NULL, 'children', 'Children', 'الأطفال', 'Kinderen', 'Les enfants', 'Kinder', 'Bambini', 'Crianças', 'Дети', 'Niños', 'çocuklar'),
(192, '', NULL, 'friends', 'Friends', 'اصحاب', 'vrienden', 'copains', 'Freunde', 'Amici', 'Amigos', 'друзья', 'Amigos', 'Arkadaş'),
(193, '', NULL, 'i_live_with', 'I live with', 'انا اعيش مع', 'ik woon met', 'je vis avec', 'ich lebe mit', 'vivo con', 'eu moro com', 'Я живу с', 'vivo con', 'ile yaşıyorum'),
(194, '', NULL, 'car', 'Car', 'سيارة', 'Auto', 'Voiture', 'Auto', 'Auto', 'Carro', 'Автомобиль', 'Coche', 'araba'),
(195, '', NULL, 'smoke', 'Smoke', 'دخان', 'Rook', 'Fumée', 'Rauch', 'Fumo', 'Fumaça', 'дым', 'Fumar', 'Duman'),
(196, '', NULL, 'drink', 'Drink', 'يشرب', 'Drinken', 'Boisson', 'Getränk', 'Bere', 'Bebida', 'Напиток', 'Beber', 'İçki'),
(197, '', NULL, 'travel', 'Travel', 'السفر', 'Reizen', 'Voyage', 'Reise', 'Viaggio', 'Viagem', 'Путешествовать', 'Viajar', 'Seyahat'),
(198, '', NULL, 'music_genre', 'Music Genre', 'نوع الموسيقى', 'Muziek genre', 'Genre de musique', 'Musikrichtung', 'Genere musicale', 'Gênero musical', 'Музыкальный жанр', 'Género musical', 'Müzik tarzı'),
(199, '', NULL, 'dish', 'Dish', 'طبق', 'Schotel', 'Plat', 'Gericht', 'Piatto', 'Prato', 'блюдо', 'Plato', 'Tabak'),
(200, '', NULL, 'song', 'Song', 'أغنية', 'lied', 'Chanson', 'Lied', 'Canzone', 'Canção', 'песня', 'Canción', 'Şarkı'),
(201, '', NULL, 'hobby', 'Hobby', 'هواية', 'Hobby', 'Loisir', 'Hobby', 'Passatempo', 'Passatempo', 'Хобби', 'Hobby', 'Hobi'),
(202, '', NULL, 'city', 'City', 'مدينة', 'stad', 'Ville', 'Stadt', 'Città', 'Cidade', 'город', 'Ciudad', 'Kent'),
(203, '', NULL, 'sport', 'Sport', 'رياضة', 'Sport', 'sport', 'Sport', 'Sport', 'Esporte', 'спорт', 'Deporte', 'Spor'),
(204, '', NULL, 'book', 'Book', 'كتاب', 'Boek', 'Livre', 'Buch', 'Libro', 'Livro', 'Книга', 'Libro', 'Kitap'),
(205, '', NULL, 'movie', 'Movie', 'فيلم', 'Film', 'Film', 'Film', 'Film', 'Filme', 'Кино', 'Película', 'Film'),
(206, '', NULL, 'color', 'Color', 'اللون', 'Kleur', 'Couleur', 'Farbe', 'Colore', 'Cor', 'цвет', 'Color', 'Renk'),
(207, '', NULL, 'tv_show', 'TV Show', 'برنامج تلفزيوني', 'Tv programma', 'Émission de télévision', 'Fernsehsendung', 'Programma televisivo', 'Programa de TV', 'ТВ шоу', 'Programa de televisión', 'Televizyon şovu'),
(208, '', NULL, 'show_my_profile_on_google', 'Show my profile on search engines?', 'عرض ملف التعريف الخاص بي على محركات البحث؟', 'Toon mijn profiel op zoekmachines?', 'Afficher mon profil sur les moteurs de recherche?', 'Mein Profil in Suchmaschinen anzeigen?', 'Mostra il mio profilo sui motori di ricerca?', 'Mostrar meu perfil nos mecanismos de pesquisa?', 'Показать мой профиль в поисковых системах?', '¿Mostrar mi perfil en los buscadores?', 'Profilimi arama motorlarında göster'),
(209, '', NULL, 'show_my_profile_in_random_users', 'Show my profile in random users?', 'عرض ملفي الشخصي في المستخدمين عشوائية؟', 'Toon mijn profiel in willekeurige gebruikers?', 'Afficher mon profil dans des utilisateurs aléatoires?', 'Mein Profil bei zufälligen Benutzern anzeigen?', 'Mostra il mio profilo in utenti casuali?', 'Mostrar meu perfil em usuários aleatórios?', 'Показать мой профиль в случайных пользователях?', '¿Mostrar mi perfil en usuarios aleatorios?', 'Profilimi rastgele kullanıcılarda göster'),
(210, '', NULL, 'show_my_profile_in_match_profiles', 'Show my profile in find match page?', 'إظهار ملفي الشخصي في صفحة مطابقة البحث؟', 'Toon mijn profiel op zoek match pagina?', 'Afficher mon profil dans la page de correspondance?', 'Mein Profil auf der Übereinstimmungsseite anzeigen?', 'Mostra il mio profilo nella pagina di ricerca del ritrovamento?', 'Mostrar meu perfil na página de correspondência?', 'Показать мой профиль на странице поиска совпадений?', '¿Mostrar mi perfil en la página de búsqueda de coincidencias?', 'Profilimi eşleşme sayfasında bul?'),
(211, '', NULL, 'new_password', 'New Password', 'كلمة السر الجديدة', 'nieuw paswoord', 'nouveau mot de passe', 'Neues Kennwort', 'nuova password', 'Nova senha', 'новый пароль', 'Nueva contraseña', 'Yeni Şifre'),
(212, '', NULL, 'confirm_new_password', 'Confirm New Password', 'تأكيد كلمة المرور الجديدة', 'Bevestig nieuw wachtwoord', 'Confirmer le nouveau mot de passe', 'Bestätige neues Passwort', 'Conferma la nuova password', 'Confirme a nova senha', 'Подтвердите новый пароль', 'Confirmar nueva contraseña', 'Yeni şifreyi onayla'),
(213, '', NULL, 'change', 'Change', 'يتغيرون', 'Verandering', 'Changement', 'Veränderung', 'Modificare', 'mudança', '+ Изменить', 'Cambio', 'Değişiklik'),
(214, '', NULL, 'facebook', 'Facebook', 'فيس بوك', 'Facebook', 'Facebook', 'Facebook', 'Facebook', 'Facebook', 'facebook', 'Facebook', 'Facebook'),
(215, '', NULL, 'twitter', 'Twitter', 'تغريد', 'tjilpen', 'Gazouillement', 'Twitter', 'cinguettio', 'Twitter', 'щебет', 'Gorjeo', 'heyecan'),
(216, '', NULL, 'google_plus', 'Google Plus', 'جوجل بلس', 'Google Plus', 'Google Plus', 'Google Plus', 'Google Plus', 'Google Plus', 'Гугл плюс', 'Google Mas', 'Google artı'),
(217, '', NULL, 'instagrem', 'instagrem', 'instagrem', 'instagrem', 'instagrem', 'instagrem', 'instagrem', 'instagrem', 'instagrem', 'instagrem', 'instagrem'),
(218, '', NULL, 'linkedin', 'LinkedIn', 'ينكدين', 'LinkedIn', 'LinkedIn', 'LinkedIn', 'LinkedIn', 'LinkedIn', 'LinkedIn', 'LinkedIn', 'LinkedIn'),
(219, '', NULL, 'website', 'Website', 'موقع الكتروني', 'Website', 'Site Internet', 'Webseite', 'Sito web', 'Local na rede Internet', 'Веб-сайт', 'Sitio web', 'Web sitesi'),
(220, '', NULL, 'there_is_no_blocked_user_yet.', 'There are no blocked users found.', 'لم يتم العثور على أي مستخدم محظور.', 'Er zijn geen geblokkeerde gebruikers gevonden.', 'Aucun utilisateur bloqué n\'a été trouvé.', 'Es wurden keine blockierten Benutzer gefunden.', 'Non sono stati trovati utenti bloccati.', 'Não há usuários bloqueados encontrados.', 'Заблокированных пользователей не найдено.', 'No se han encontrado usuarios bloqueados.', 'Engellenen kullanıcı bulunamadı.'),
(221, '', NULL, 'no_transactions_found.', 'No transactions found.', 'لم يتم العثور على أي معاملات.', 'Geen transacties gevonden.', 'Aucune transaction trouvée.', 'Keine Transaktionen gefunden.', 'Nessuna transazione trovata.', 'Nenhuma transação encontrada.', 'Транзакций не найдено.', 'No se encontraron transacciones.', 'İşlem bulunamadı.'),
(222, '', NULL, 'login', 'Login', 'تسجيل الدخول', 'Log in', 'S\'identifier', 'Anmeldung', 'Accesso', 'Entrar', 'Авторизоваться', 'Iniciar sesión', 'Oturum aç'),
(223, '', NULL, 'register', 'Register', 'تسجيل', 'Registreren', 'registre', 'Registrieren', 'Registrare', 'registo', 'регистр', 'Registro', 'Kayıt olmak'),
(224, '', NULL, 'meet_new_and_interesting_people.', 'Meet new and interesting people.', 'تلبية الناس جديدة ومثيرة للاهتمام.', 'Ontmoet nieuwe en interessante mensen.', 'Rencontrez des personnes nouvelles et intéressantes.', 'Lerne neue und interessante Leute kennen.', 'Incontra persone nuove e interessanti.', 'Conheça pessoas novas e interessantes.', 'Встречайте новых и интересных людей.', 'Conoce gente nueva e interesante.', 'Yeni ve ilginç insanlarla tanışın.'),
(225, '', NULL, 'join', 'Join', 'انضم', 'toetreden', 'Joindre', 'Beitreten', 'Aderire', 'Junte-se', 'Присоединиться', 'Unirse', 'Katılmak'),
(226, '', NULL, 'where_you_could_meet_anyone__anywhere_', 'where you could meet anyone, anywhere!', 'حيث يمكنك مقابلة أي شخص في أي مكان!', 'waar je iemand kon ontmoeten, overal!', 'où vous pourriez rencontrer n\'importe qui, n\'importe où!', 'wo man jeden treffen könnte, überall!', 'dove puoi incontrare chiunque, ovunque!', 'onde você poderia encontrar alguém, em qualquer lugar!', 'где вы могли встретить кого угодно, где угодно!', '¡Donde puedas conocer a cualquiera, en cualquier lugar!', 'her yerde, herhangi biriyle tanışabileceğin bir yer!'),
(227, '', NULL, 'get_started', 'Get Started', 'البدء', 'Begin', 'Commencer', 'Loslegen', 'Iniziare', 'Iniciar', 'Начать', 'Empezar', 'Başlamak'),
(228, '', NULL, 'know_more', 'Know More', 'تعرف أكثر', 'Meer weten', 'Savoir plus', 'Mehr wissen', 'Saperne di più', 'Saber mais', 'Узнать больше', 'Saber más', 'Daha Fazla Bilgi Edinin'),
(229, '', NULL, 'i_am_a', 'I am a', 'أنا', 'ik ben een', 'je suis un', 'Ich bin ein', 'sono un', 'eu sou um', 'Я', 'soy un', 'Ben bir'),
(230, '', NULL, 'i_m_looking_for_a', 'I&#039;m looking for a', 'انا اتطلع الى', 'ik zoek een', 'je recherche un', 'ich suche eine', 'Sto cercando', 'eu estou procurando uma', 'Я ищу', 'Estoy buscando', 'Arıyorum'),
(231, '', NULL, 'between_ages', 'Between ages', 'بين الاجيال', 'Tussen de leeftijden', 'Entre les âges', 'Zwischen Zeitaltern', 'Tra secoli', 'Entre idades', 'Между возрастами', 'Entre edades', 'Yaş arası'),
(232, '', NULL, 'and', 'and', 'و', 'en', 'et', 'und', 'e', 'e', 'а также', 'y', 've'),
(233, '', NULL, 'let_s_begin', 'Let&#039;s Begin', 'هيا نبدأ', 'Laten we beginnen', 'Commençons', 'Lass uns anfangen', 'Cominciamo', 'Vamos começar', 'Давай начнем', 'Vamos a empezar', 'Hadi başlayalım');
INSERT INTO `langs` (`id`, `ref`, `options`, `lang_key`, `english`, `arabic`, `dutch`, `french`, `german`, `italian`, `portuguese`, `russian`, `spanish`, `turkish`) VALUES
(234, '', NULL, 'how', 'How', 'ماذا', 'Hoe', 'Comment', 'Wie', 'Come', 'Como', 'Как', 'Cómo', 'Nasıl'),
(235, '', NULL, 'works', 'Works', 'أعمال', 'Werken', 'Travaux', 'Arbeitet', 'Lavori', 'Trabalho', 'Работает', 'Trabajos', 'Eserleri'),
(236, '', NULL, 'create_account', 'Create Account', 'إنشاء حساب', 'Maak een account aan', 'Créer un compte', 'Benutzerkonto anlegen', 'Creare un profilo', 'Criar Conta em portugues-Brasil', 'Создать учетную запись', 'Crear una cuenta', 'Hesap açmak'),
(237, '', NULL, 'register_for_free___create_up_your_good_looking_profile.', 'Register for free &amp; create up your good looking Profile.', 'التسجيل مجانا & amp؛ إنشاء ملفك الشخصي الجيد.', 'Registreer gratis & amp; creëer je mooie profiel.', 'Inscrivez-vous gratuitement & amp; créez votre beau profil.', 'Registrieren Sie sich kostenlos & amp; Erstellen Sie Ihr gut aussehendes Profil.', 'Registrati gratuitamente & amp; crea il tuo bel profilo.', 'Inscreva-se gratuitamente e & amp; crie o seu perfil de boa aparência.', 'Зарегистрируйтесь бесплатно & amp; создать свой красивый профиль.', 'Registrarse gratis & amp; Crea tu buen perfil.', 'Ücretsiz kayıt olun & amp; iyi görünümlü Profilinizi oluşturun.'),
(238, '', NULL, 'search___connect_with_matches_which_are_perfect_for_you.', 'Search &amp; Connect with Matches which are perfect for you.', 'البحث & amp؛ تواصل مع مباريات مثالية لك.', 'Zoeken & amp; Maak verbinding met overeenkomsten die perfect zijn voor jou.', 'Rechercher & amp; Connectez-vous avec des matchs qui sont parfaits pour vous.', 'Suche & amp; Verbinde dich mit Treffern, die perfekt für dich sind.', 'Cerca & amp; Connettiti con le partite perfette per te.', 'Pesquisar & amp; Conecte-se com jogos que são perfeitos para você.', 'Поиск & amp; Связаться с матчами, которые идеально подходят для вас.', 'Buscar & amp; Conéctate con los partidos que son perfectos para ti.', 'Ara ve & amp; Sizin için mükemmel olan Maçlar ile bağlanın.'),
(239, '', NULL, 'start_dating', 'Start Dating', 'بدء التي يرجع تاريخها', 'Begin te daten', 'Commencer à dater', 'Starte die Partnersuche', 'Inizia Incontri', 'Comece a namorar', 'Начать знакомства', 'Comenzar a tener citas', 'Randevuyu Başlat'),
(240, '', NULL, 'start_doing_conversations_and_date_your_best_match.', 'Start doing conversations and date your best match.', 'ابدأ في إجراء المحادثات وتسجيل أفضل تطابق.', 'Begin met het voeren van gesprekken en date met je beste match.', 'Commencez à faire des conversations et datez votre meilleur match.', 'Beginnen Sie, Gespräche zu führen und treffen Sie Ihre beste Übereinstimmung.', 'Iniziare a fare conversazioni e datare la tua migliore corrispondenza.', 'Comece a fazer conversas e date seu melhor par.', 'Начни разговор и назначь свидание своему лучшему матчу.', 'Comience a hacer conversaciones y feche su mejor coincidencia.', 'Konuşma yapmaya başla ve en iyi eşleşmenle çık.'),
(241, '', NULL, 'users_loves_us', 'Users Loves Us', 'يحب المستخدمون بنا', 'Gebruikers houden van ons', 'Les utilisateurs nous aiment', 'Benutzer liebt uns', 'Gli utenti ci amano', 'Usuários nos ama', 'Пользователи нас любят', 'Los usuarios nos aman', 'Kullanıcılar bizi seviyor'),
(243, '', NULL, 'best_match', 'Best Match', 'افضل مباراة', 'Beste overeenkomst', 'Meilleure correspondance', 'Bester Treffer', 'Migliore partita', 'Melhor partida', 'Лучший матч', 'Mejor partido', 'En iyi eşleşme'),
(244, '', NULL, 'based_on_your_location__we_find_best_and_suitable_matches_for_you.', 'Based on your location, we find best and suitable matches for you.', 'استنادًا إلى موقعك ، نجد أفضل النتائج ومناسبًا لك.', 'Op basis van uw locatie vinden we de beste en geschikte matches voor u.', 'En fonction de votre emplacement, nous trouvons les correspondances les plus appropriées pour vous.', 'Basierend auf Ihrem Standort finden wir die besten und passenden Übereinstimmungen für Sie.', 'In base alla tua posizione, troviamo le migliori e le partite adatte per te.', 'Com base na sua localização, encontramos correspondências melhores e adequadas para você.', 'Исходя из вашего местоположения, мы подберем для вас лучшие и подходящие варианты.', 'Según su ubicación, encontramos las mejores y más adecuadas para usted.', 'Bulunduğunuz yere göre, sizin için en iyi ve uygun eşleşmeleri buluruz.'),
(245, '', NULL, 'fully_secure', 'Fully Secure', 'آمنة تماما', 'Volledig veilig', 'Entièrement sécurisé', 'Völlig sicher', 'Completamente sicuro', 'Totalmente seguro', 'Полностью Безопасный', 'Completamente seguro', 'Tamamen güvenli'),
(247, '', NULL, '100__privacy', '100% Privacy', 'خصوصية 100٪', '100% privacy', '100% confidentialité', '100% Privatsphäre', '100% di privacy', '100% de privacidade', '100% конфиденциальность', '100% de privacidad', '% 100 Gizlilik'),
(248, '', NULL, 'you_have_full_control_over_your_personal_information_that_you_share.', 'You have full control over your personal information that you share.', 'لديك السيطرة الكاملة على معلوماتك الشخصية التي تشاركها.', 'U hebt volledige controle over uw persoonlijke gegevens die u deelt.', 'Vous avez un contrôle total sur vos informations personnelles que vous partagez.', 'Sie haben die volle Kontrolle über Ihre persönlichen Informationen, die Sie teilen.', 'Hai il pieno controllo delle tue informazioni personali che condividi.', 'Você tem controle total sobre suas informações pessoais compartilhadas.', 'Вы имеете полный контроль над своей личной информацией, которой вы делитесь.', 'Usted tiene control total sobre su información personal que comparte.', 'Paylaştığınız kişisel bilgileriniz üzerinde tam kontrol sizde.'),
(250, '', NULL, 'don_t_have_an_account_', 'Don&#039;t have an account?', 'ليس لديك حساب؟', 'Heb je geen account?', 'Vous n\'avez pas de compte?', 'Ich habe noch kein Konto', 'Non hai un account?', 'Não tem uma conta?', 'У вас нет аккаунта?', '¿No tienes una cuenta?', 'Hesabınız yok mu?'),
(251, '', NULL, 'welcome_back_', 'Welcome back,', 'مرحبا بعودتك،', 'Welkom terug,', 'Nous saluons le retour,', 'Willkommen zurück,', 'Ben tornato,', 'Bem vindo de volta,', 'Добро пожаловать,', 'Dar una buena acogida,', 'Tekrar hoşgeldiniz,'),
(252, '', NULL, 'please_login_to_your_account.', 'Login to your account to continue. ', 'تسجيل الدخول إلى حسابك للمتابعة.', 'Log in op uw account om verder te gaan.', 'Connectez-vous à votre compte pour continuer.', 'Melden Sie sich bei Ihrem Konto an, um fortzufahren.', 'Accedi al tuo account per continuare.', 'Entre na sua conta para continuar.', 'Войдите в свой аккаунт, чтобы продолжить.', 'Inicie sesión en su cuenta para continuar.', 'Devam etmek için hesabınıza giriş yapın.'),
(253, '', NULL, 'username_or_email', 'Username or Email', 'اسم المستخدم أو البريد الالكتروني', 'Gebruikersnaam of email', 'Nom d\'utilisateur ou email', 'Benutzername oder E-Mail-Adresse', 'Nome utente o email', 'Nome de usuário ou email', 'Имя пользователя или адрес электронной почты', 'Nombre de usuario o correo electrónico', 'Kullanıcı adı ya da email'),
(254, '', NULL, 'forgot_password_', 'Forgot Password?', 'هل نسيت كلمة المرور؟', 'Wachtwoord vergeten?', 'Mot de passe oublié?', 'Passwort vergessen?', 'Ha dimenticato la password?', 'Esqueceu a senha?', 'Забыли пароль?', '¿Se te olvidó tu contraseña?', 'Parolanızı mı unuttunuz?'),
(255, '', NULL, 'login_with_facebook', 'Login with Facebook', 'تسجيل الدخول باستخدام الفيسبوك', 'Inloggen met Facebook', 'Se connecter avec Facebook', 'Mit Facebook einloggen', 'Fai il login con facebook', 'Entrar com o Facebook', 'Войти с Facebook', 'Iniciar sesión con Facebook', 'Facebook ile giriş'),
(256, '', NULL, 'login_with_twitter', 'Login with Twitter', 'تسجيل الدخول مع تويتر', 'Inloggen met Twitter', 'Se connecter avec Twitter', 'Mit Twitter anmelden', 'Accedi con Twitter', 'Entre com o Twitter', 'Войти через Twitter', 'Inicia sesión con Twitter', 'Twitter ile giriş yap'),
(257, '', NULL, 'login_with_google', 'Login with Google', 'تسجيل الدخول مع جوجل', 'Inloggen met Google', 'Connectez-vous avec Google', 'Mit Google anmelden', 'Accedi con Google', 'Entre com o Google', 'Войти через Google', 'Inicia sesión con Google', 'Google ile giriş yap'),
(258, '', NULL, 'login_with_vk', 'Login with VK', 'تسجيل الدخول مع VK', 'Inloggen met VK', 'Se connecter avec VK', 'Loggen Sie sich mit VK ein', 'Accedi con VK', 'Faça o login com VK', 'Войти через ВКонтакте', 'Iniciar sesión con VK', 'VK ile giriş yap'),
(259, '', NULL, 'already_have_an_account_', 'Already have an account?', 'هل لديك حساب؟', 'Heb je al een account?', 'Vous avez déjà un compte?', 'Hast du schon ein Konto?', 'Hai già un account?', 'já tem uma conta?', 'Уже есть аккаунт?', '¿Ya tienes una cuenta?', 'Zaten hesabınız var mı?'),
(260, '', NULL, 'password_recovery_', 'Password recovery,', 'استعادة كلمة السر،', 'Wachtwoord herstel,', 'Récupération de mot de passe,', 'Passwort-Wiederherstellung,', 'Recupero della password,', 'Recuperação de senha,', 'Восстановление пароля,', 'Recuperación de contraseña,', 'Şifre kurtarma,'),
(261, '', NULL, 'please_enter_your_registered_email_to_proceed.', 'Please enter your registered email address to proceed. ', 'يرجى إدخال عنوان البريد الإلكتروني المسجل للمتابعة.', 'Voer uw geregistreerde e-mailadres in om door te gaan.', 'Veuillez entrer votre adresse e-mail enregistrée pour continuer.', 'Bitte geben Sie Ihre registrierte E-Mail-Adresse ein, um fortzufahren.', 'Inserisci il tuo indirizzo email registrato per procedere.', 'Por favor, digite seu endereço de e-mail cadastrado para continuar.', 'Пожалуйста, введите ваш зарегистрированный адрес электронной почты, чтобы продолжить.', 'Por favor ingrese su dirección de correo electrónico registrada para continuar.', 'Lütfen devam etmek için kayıtlı e-posta adresinizi girin.'),
(262, '', NULL, 'proceed', 'Proceed', 'تقدم', 'Doorgaan', 'Procéder', 'Vorgehen', 'Procedere', 'Prosseguir', 'проследовать', 'Proceder', 'İlerlemek'),
(263, '', NULL, 'contact_us', 'Contact Us', 'اتصل بنا', 'Neem contact met ons op', 'Contactez nous', 'Kontaktiere uns', 'Contattaci', 'Contate-Nos', 'Связаться с нами', 'Contáctenos', 'Bizimle iletişime geçin'),
(264, '', NULL, 'how_can_we_help_', 'How can we help?', 'كيف يمكن أن نساعد؟', 'Hoe kunnen we helpen?', 'Comment pouvons nous aider?', 'Wie können wir helfen?', 'Come possiamo aiutare?', 'Como podemos ajudar?', 'Как мы можем помочь?', '¿Cómo podemos ayudar?', 'Nasıl yardımcı olabiliriz?'),
(265, '', NULL, 'send', 'Send', 'إرسال', 'Sturen', 'Envoyer', 'Senden', 'Inviare', 'Mandar', 'послать', 'Enviar', 'göndermek'),
(266, '', NULL, 'terms_of_use', 'Terms of use', 'تعليمات الاستخدام', 'Gebruiksvoorwaarden', 'Conditions d\'utilisation', 'Nutzungsbedingungen', 'Condizioni d\'uso', 'Termos de uso', 'Условия эксплуатации', 'Términos de Uso', 'Kullanım Şartları'),
(267, '', NULL, 'get_started_', 'Get started,', 'البدء،', 'Begin,', 'Commencer,', 'Loslegen,', 'Iniziare,', 'Iniciar,', 'Начать,', 'Empezar,', 'Başlamak,'),
(268, '', NULL, 'please_signup_to_continue_your_account.', 'Sign up to get started finding your partner!', 'قم بالتسجيل للبدء في البحث عن شريك حياتك!', 'Meld je aan om aan de slag te gaan met het vinden van je partner!', 'Inscrivez-vous pour commencer à trouver votre partenaire!', 'Melden Sie sich an, um Ihren Partner zu finden!', 'Iscriviti per iniziare a cercare il tuo partner!', 'Inscreva-se para começar a encontrar seu parceiro!', 'Зарегистрируйтесь, чтобы начать поиск своего партнера!', 'Regístrese para comenzar a encontrar a su pareja!', 'Eşinizi bulmaya başlamak için kaydolun!'),
(269, '', NULL, 'confirm_password', 'Confirm Password', 'تأكيد كلمة المرور', 'bevestig wachtwoord', 'Confirmez le mot de passe', 'Passwort bestätigen', 'conferma password', 'Confirme a Senha', 'Подтвердите Пароль', 'Confirmar contraseña', 'Şifreyi Onayla'),
(270, '', NULL, 'people_who_are_interested_in__', 'People who are interested in:', 'الأشخاص المهتمين بـ:', 'Mensen die geïnteresseerd zijn in:', 'Les personnes intéressées par:', 'Personen, die sich für Folgendes interessieren:', 'Le persone che sono interessate a:', 'Pessoas que estão interessadas em:', 'Люди, которые заинтересованы в:', 'Personas interesadas en:', 'İlgilenenler:'),
(271, '', NULL, 'no_interested_people_found.', 'No interested people found.', 'لم يتم العثور على أشخاص مهتمين.', 'Geen geïnteresseerde mensen gevonden.', 'Aucune personne intéressée trouvée.', 'Keine interessierten Personen gefunden.', 'Non sono state trovate persone interessate.', 'Nenhuma pessoa interessada encontrou.', 'Не найдено заинтересованных людей.', 'No se encontraron personas interesadas.', 'İlgili kişi bulunamadı.'),
(272, '', NULL, 'like', 'Like', 'مثل', 'Net zoals', 'Comme', 'Mögen', 'Piace', 'Gostar', 'подобно', 'Me gusta', 'Sevmek'),
(273, '', NULL, 'dislike', 'Dislike', 'لم يعجبنى', 'Afkeer', 'Ne pas aimer', 'Nicht gefallen', 'antipatia', 'Antipatia', 'нелюбовь', 'Disgusto', 'Beğenmemek'),
(274, '', NULL, 'disliked', 'Disliked', 'لم يعجبني', 'bevallen', 'N\'a pas aimé', 'Unbeliebt', 'malvisto', 'Não gostei', 'Не понравилось', 'No me gustó', 'Beğenmedim'),
(275, '', NULL, 'you_disliked', 'you disliked', 'كنت لا يعجبك', 'je had een hekel aan', 'tu n\'aimais pas', 'du mochtest es nicht', 'non ti piaceva', 'você não gostou', 'ты не любил', 'no te gustó', 'beğenmedin'),
(276, '', NULL, 'delete_account', 'Delete Account', 'حذف الحساب', 'Account verwijderen', 'Supprimer le compte', 'Konto löschen', 'Eliminare l\'account', 'Deletar conta', 'Удалить аккаунт', 'Borrar cuenta', 'Hesabı sil'),
(277, '', NULL, 'liked', 'Liked', 'احب', 'vond', 'Aimé', 'Gefallen', 'È piaciuto', 'Gostei', 'Понравилось', 'Gustó', 'sevilen'),
(278, '', NULL, 'you_liked', 'you liked', 'أعجبك', 'jij hield van', 'tu as aimé', 'du mochtest', 'ti è piaciuto', 'você gostou', 'тебе понравилось', 'te gustó', 'beğendin'),
(279, '', NULL, 'message', 'Message', 'رسالة', 'Bericht', 'Message', 'Botschaft', 'Messaggio', 'mensagem', 'Сообщение', 'Mensaje', 'Mesaj'),
(280, '', NULL, 'report_user.', 'Report user.', 'أبلغ عن مستخدم.', 'Rapporteer gebruiker.', 'Dénoncer un utilisateur.', 'Benutzer melden.', 'Segnala utente.', 'Reportar usuário.', 'Пожаловаться на пользователя.', 'Reportar usuario.', 'Kullanıcıyı bildir.'),
(281, '', NULL, 'type_here_why_you_want_to_report_this_user.', 'Please let us know why you want to report this person.', 'يرجى إعلامنا بسبب رغبتك في الإبلاغ عن هذا الشخص.', 'Laat ons weten waarom je deze persoon wilt melden.', 'S\'il vous plaît laissez-nous savoir pourquoi vous souhaitez signaler cette personne.', 'Teilen Sie uns bitte mit, warum Sie diese Person melden möchten.', 'Per favore fateci sapere perché volete segnalare questa persona.', 'Por favor, deixe-nos saber por que você deseja denunciar essa pessoa.', 'Пожалуйста, дайте нам знать, почему вы хотите сообщить об этом человеке.', 'Por favor, háganos saber por qué quiere informar a esta persona.', 'Lütfen bu kişiyi neden rapor etmek istediğinizi bize bildirin.'),
(282, '', NULL, 'report', 'Report', 'أبلغ عن', 'Verslag doen van', 'rapport', 'Bericht', 'rapporto', 'Relatório', 'отчет', 'Informe', 'Rapor'),
(283, '', NULL, 'send_gift_costs_', 'Send gift costs', 'إرسال تكاليف الهدايا', 'Verzend geschenkkosten', 'Envoyer les frais de cadeau', 'Geschenkkosten senden', 'Invia i costi del regalo', 'Envie os custos do presente', 'Отправить стоимость подарка', 'Enviar los costos de regalo', 'Hediye masrafı gönder'),
(284, '', NULL, 'chat', 'Chat', 'دردشة', 'babbelen', 'Bavarder', 'Plaudern', 'Chiacchierare', 'Bate-papo', 'чат', 'Charla', 'Sohbet'),
(285, '', NULL, 'you_have_reached_your_daily_limit', 'You have reached your daily limit', 'لقد وصلت إلى الحد اليومي الخاص بك', 'Je hebt je dagelijkse limiet bereikt', 'Vous avez atteint votre limite quotidienne', 'Sie haben Ihr Tageslimit erreicht', 'Hai raggiunto il limite giornaliero', 'Você atingiu seu limite diário', 'Вы достигли своего дневного лимита', 'Has alcanzado tu límite diario.', 'Günlük limitinize ulaştınız'),
(286, '', NULL, 'you_can_chat_to_new_people_after', 'you can chat to new people after', 'يمكنك الدردشة مع أشخاص جدد بعد', 'je kunt na afloop chatten met nieuwe mensen', 'vous pouvez discuter avec de nouvelles personnes après', 'Sie können danach mit neuen Leuten chatten', 'puoi chattare con persone nuove dopo', 'você pode conversar com novas pessoas depois', 'Вы можете общаться с новыми людьми после', 'puedes chatear con nuevas personas después', 'sonra yeni insanlarla sohbet edebilirsin'),
(287, '', NULL, 'can_t_wait__this_service_costs_you', 'can&#039;t wait? this service costs you', 'لا استطيع الانتظار؟ هذه الخدمة تكلفك', 'kan niet wachten? deze service kost je', 'ne peut pas attendre? ce service vous coûte', 'kann nicht warten Dieser Service kostet Sie', 'non puoi aspettare? questo servizio ti costa', 'não pode esperar este serviço custa você', 'не могу ждать? эта услуга стоит вам', 'no puedo esperar? este servicio te cuesta', 'bekleyemem bu servis size maliyeti'),
(288, '', NULL, 'likes_you', 'likes you', 'يعجبك', 'vind je leuk', 't\'aime bien', 'mag dich', 'gli piaci', 'gosta de você', 'вы нравитесь', 'le gustas', 'senin gibi'),
(289, '', NULL, 'this_profile_is_not_verified', 'This profile is not verified yet', 'لم يتم التحقق من هذا الملف حتى الآن', 'Dit profiel is nog niet geverifieerd', 'Ce profil n\'a pas encore été vérifié', 'Dieses Profil wurde noch nicht verifiziert', 'Questo profilo non è ancora stato verificato', 'Este perfil ainda não foi verificado', 'Этот профиль еще не подтвержден', 'Este perfil no está verificado todavía', 'Bu profil henüz doğrulanmadı'),
(290, '', NULL, 'block_user', 'Block', 'منع', 'Blok', 'Bloc', 'Block', 'Bloccare', 'Quadra', 'блок', 'Bloquear', 'Blok'),
(291, '', NULL, 'report_user', 'Report', 'أبلغ عن', 'Verslag doen van', 'rapport', 'Bericht', 'rapporto', 'Relatório', 'отчет', 'Informe', 'Rapor'),
(292, '', NULL, 'buy_now.', 'Buy Now.', 'اشتري الآن.', 'Koop nu.', 'Acheter maintenant.', 'Kaufe jetzt.', 'Acquista ora.', 'Compre.', 'Купить сейчас.', 'Compra ahora.', 'Şimdi satın al.'),
(293, '', NULL, 'low', 'Low', 'منخفض', 'Laag', 'Faible', 'Niedrig', 'Basso', 'Baixo', 'Низкий', 'Bajo', 'Düşük'),
(294, '', NULL, 'matched_you', 'matched you', 'مطابقتك', 'matched jou', 'vous correspondait', 'paßte dich zusammen', 'ti ha abbinato', 'combinou com você', 'соответствует вам', 'te emparejó', 'seninle eşleştim'),
(295, '', NULL, 'user__1', 'User #1', 'المستخدم رقم 1', 'Gebruiker # 1', 'Utilisateur n ° 1', 'Benutzer Nr. 1', 'Utente n. 1', 'Utilizador # 1', 'Пользователь № 1', 'Usuario # 1', '1. Kullanıcı'),
(297, '', NULL, 'user__2', 'User #2', 'المستخدم رقم 2', 'Gebruiker # 2', 'Utilisateur n ° 2', 'Benutzer Nr. 2', 'Utente n. 2', 'Utilizador # 2', 'Пользователь № 2', 'Usuario # 2', '2. Kullanıcı'),
(298, '', NULL, 'user__3', 'User #3', 'المستخدم رقم 3', 'Gebruiker # 3', 'Utilisateur n ° 3', 'Benutzer Nr. 3', 'Utente n. 3', 'Utilizador # 3', 'Пользователь № 3', 'Usuario # 3', 'Kullanıcı # 3'),
(299, '', NULL, 'user__4', 'User #4', 'المستخدم # 4', 'Gebruiker # 4', 'Utilisateur n ° 4', 'Benutzer Nr. 4', 'Utente n. 4', 'Utilizador # 4', 'Пользователь № 4', 'Usuario # 4', 'Kullanıcı # 4'),
(308, '', NULL, 'unread_messages', 'Unread Messages', 'رسائل غير مقروءة', 'ongelezen berichten', 'Messages non lus', 'ungelesene Nachrichten', 'Messaggi non letti', 'Mensagens não lidas', 'Непрочитанные сообщения', 'Mensajes no leídos', 'Okunmamış Mesajlar'),
(309, '', NULL, 'there_is_no_new_notifications.', 'There are no new notifications', 'لا توجد إشعارات جديدة', 'Er zijn geen nieuwe meldingen', 'Il n\'y a pas de nouvelles notifications', 'Es gibt keine neuen Benachrichtigungen', 'Non ci sono nuove notifiche', 'Não há novas notificações', 'Нет новых уведомлений', 'No hay nuevas notificaciones.', 'Yeni bildirim yok'),
(310, '', NULL, '183_cm__6__039__0__', '183 cm (6 \'0\')', '183 cm (6 \'0\')', '183 cm (6 \'0\')', '183 cm (6 \'0\')', '183 cm (6 \'0\')', '183 cm (6 \'0\')', '183 cm (6 \'0\')', '183 см (6 \'0\')', '183 cm (6 \'0\')', '183 cm (6 \'0\')'),
(311, '', NULL, '184_cm', '184 cm', '184 سم', '184 cm', '184 cm', '184 cm', '184 cm', '184 cm', '184 см', '184 cm', '184 cm'),
(312, '', NULL, '180_cm__5__039__11__', '180 cm (5 \'11\')', '180 cm (5 \'11\')', '180 cm (5 \'11\')', '180 cm (5 \'11 ', '180 cm (5 \'11\')', '180 cm (5 \'11 ', '180 cm (5 \'11\')', '180 cm (5 \'11\')', '180 cm (5 \'11\')', '180 cm (5 \'11\')'),
(313, '', NULL, 'wanna_get_more__get_premium__or_get_new_stickers_for', 'Wanna get more? get premium! OR get new stickers for', 'اريد الحصول على المزيد؟ إحصل على الأفضل! أو الحصول على ملصقات جديدة ل', 'Wil je meer krijgen? krijg premie! OF krijg nieuwe stickers voor', 'Tu veux en avoir plus? obtenir des primes! OU obtenez de nouveaux autocollants pour', 'Willst du mehr bekommen? Premium bekommen! ODER neue Aufkleber für bekommen', 'Vuoi ottenere di più? ottieni il premio! O ottieni nuovi adesivi per', 'Queres mais? obtenha prémio! OU obtenha novos adesivos para', 'Хотите получить больше? получить премию! ИЛИ получить новые наклейки для', '¿Quieres conseguir más? ¡Hazte premium! O conseguir nuevas pegatinas para', 'Daha fazla almak ister misin? prim almak! VEYA için yeni çıkartmalar'),
(314, '', NULL, 'get_premium', 'Get premium', 'إحصل على الأفضل', 'Krijg premium', 'Obtenir des primes', 'Premium bekommen', 'Ottieni premium', 'Receba premium', 'Получи премию', 'Hazte premium', 'Prim almak'),
(315, '', NULL, 'buy_now_', 'Buy Now!', 'اشتري الآن!', 'Koop nu!', 'Acheter maintenant!', 'Kaufe jetzt!', 'Acquista ora!', 'Compre!', 'Купить сейчас!', '¡Compra ahora!', 'Şimdi satın al!'),
(316, '', NULL, 'liked_you', 'liked you', 'معجب بك', 'vond je leuk', 'aimé vous', 'mochte dich', 'mi è piaciuto', 'gostei de você', 'понравился', 'te ha gustado', 'senden hoşlandım'),
(317, '', NULL, 'arabic', 'Arabic', 'عربى', 'Arabisch', 'arabe', 'Arabisch', 'Arabo', 'árabe', 'арабский', 'Arábica', 'Arapça'),
(318, '', NULL, 'dutch', 'Dutch', 'هولندي', 'Nederlands', 'néerlandais', 'Niederländisch', 'olandese', 'holandês', 'Голландский', 'holandés', 'Flemenkçe'),
(319, '', NULL, 'french', 'French', 'الفرنسية', 'Frans', 'français', 'Französisch', 'francese', 'francês', 'Французский', 'francés', 'Fransızca'),
(320, '', NULL, 'german', 'German', 'ألمانية', 'Duitse', 'allemand', 'Deutsche', 'Tedesco', 'alemão', 'Немецкий', 'alemán', 'Almanca'),
(321, '', NULL, 'italian', 'Italian', 'الإيطالي', 'Italiaans', 'italien', 'Italienisch', 'italiano', 'italiano', 'итальянский', 'italiano', 'İtalyan'),
(322, '', NULL, 'portuguese', 'Portuguese', 'البرتغالية', 'Portugees', 'Portugais', 'Portugiesisch', 'portoghese', 'Português', 'португальский', 'portugués', 'Portekizce'),
(323, '', NULL, 'russian', 'Russian', 'الروسية', 'Russisch', 'russe', 'Russisch', 'russo', 'russo', 'русский', 'ruso', 'Rusça'),
(324, '', NULL, 'spanish', 'Spanish', 'الأسبانية', 'Spaans', 'Espanol', 'Spanisch', 'spagnolo', 'espanhol', 'испанский', 'Español', 'İspanyol'),
(325, '', NULL, 'turkish', 'Turkish', 'اللغة التركية', 'Turks', 'turc', 'Türkisch', 'Turco', 'turco', 'турецкий', 'turco', 'Türk'),
(405, '', NULL, 'brown', 'Brown', 'بنى', 'Bruin', 'marron', 'Braun', 'Marrone', 'Castanho', 'коричневый', 'marrón', 'Kahverengi'),
(406, '', NULL, 'black', 'Black', 'أسود', 'Zwart', 'Noir', 'Schwarz', 'Nero', 'Preto', 'черный', 'Negro', 'Siyah'),
(407, '', NULL, 'gray_or_partially_gray', 'Gray or Partially Gray', 'رمادي أو جزئيا رمادي', 'Grijs of gedeeltelijk grijs', 'Gris ou partiellement gris', 'Grau oder teilweise grau', 'Grigio o parzialmente grigio', 'Cinza ou parcialmente cinza', 'Серый или частично серый', 'Gris o parcialmente gris', 'Gri veya kısmen gri'),
(408, '', NULL, 'red_auburn', 'Red/Auburn', 'الأحمر / احمر', 'Rood / Auburn', 'Rouge / Auburn', 'Rot / Auburn', 'Red / Auburn', 'Vermelho / castanho-avermelhado', 'Красный / Auburn', 'Rojo / Auburn', 'Kırmızı / Auburn'),
(409, '', NULL, 'blond_strawberry', 'Blond/Strawberry', 'شقراء / الفراولة', 'Blond / aardbei', 'Blond / Fraise', 'Blond / Erdbeere', 'Biondi / Strawberry', 'Loiro / Morango', 'Blond / Strawberry', 'Rubio / Fresa', 'Sarışın / Çilek'),
(410, '', NULL, 'blue', 'Blue', 'أزرق', 'Blauw', 'Bleu', 'Blau', 'Blu', 'Azul', 'синий', 'Azul', 'Mavi'),
(411, '', NULL, 'green', 'Green', 'أخضر', 'Groen', 'vert', 'Grün', 'verde', 'Verde', 'зеленый', 'Verde', 'Yeşil'),
(412, '', NULL, 'orange', 'Orange', 'البرتقالي', 'Oranje', 'Orange', 'Orange', 'arancia', 'laranja', 'оранжевый', 'naranja', 'Portakal'),
(413, '', NULL, 'pink', 'Pink', 'زهري', 'Roze', 'Rose', 'Rosa', 'Rosa', 'Rosa', 'розовый', 'Rosado', 'Pembe'),
(414, '', NULL, 'purple', 'Purple', 'أرجواني', 'Purper', 'Violet', 'Lila', 'Viola', 'Roxa', 'Пурпурный', 'Púrpura', 'Mor'),
(415, '', NULL, 'partly_or_completely_bald', 'Partly or Completely Bald', 'جزئيا أو تماما أصلع', 'Gedeeltelijk of volledig kaal', 'Partiellement ou complètement chauve', 'Teilweise oder komplett kahl', 'Parzialmente o completamente calvo', 'Parcial ou Completamente Careca', 'Частично или полностью лысый', 'Parcialmente o completamente calvo', 'Kısmen veya Tamamen Kel'),
(416, '', NULL, 'other', 'Other', 'آخر', 'anders', 'Autre', 'Andere', 'Altro', 'De outros', 'Другой', 'Otro', 'Diğer'),
(417, '', NULL, 'single', 'Single', 'غير مرتبطة', 'single', 'Unique', 'Single', 'singolo', 'solteiro', 'не замужем', 'Soltero', 'Tek'),
(418, '', NULL, 'married', 'Married', 'زوجت', 'Getrouwd', 'Marié', 'Verheiratet', 'Sposato', 'Casado', 'замужем', 'Casado', 'Evli'),
(419, '', NULL, 'i_m_studying', 'I&#039;m studying', 'أنا أدرس', 'ik ben aan het studeren', 'j\'étudie', 'ich studiere', 'sto studiando', 'Estou estudando', 'я учусь', 'estoy estudiando', 'ders çalışıyorum'),
(420, '', NULL, 'i_m_working', 'I&#039;m working', 'أعمل', 'ik ben aan het werk', 'je travaille', 'ich bin am Arbeiten', 'sto lavorando', 'estou trabalhando', 'я работаю', 'estoy trabajando', 'Çalışıyorum'),
(421, '', NULL, 'i_m_looking_for_work', 'I&#039;m looking for work', 'انا ابحث عن عمل', 'ik zoek naar werk', 'je cherche du travail', 'ich suche nach Arbeit', 'sto cercando lavoro', 'Estou procurando trabalho', 'Я ищу работу', 'Estoy buscando trabajo', 'iş arıyorum'),
(422, '', NULL, 'i_m_retired', 'I&#039;m retired', 'أنا متقاعد', 'ik ben met pensioen', 'Je suis à la retraite', 'Ich bin im Ruhestand', 'sono in pensione', 'estou aposentado', 'я ушел в отставку', 'estoy retirado', 'emekliyim'),
(423, '', NULL, 'self-employed', 'Self-Employed', 'العاملون لحسابهم الخاص', 'Eigen baas', 'Travailleur indépendant', 'Selbstständiger', 'Lavoratore autonomo', 'Trabalhadores por conta própria', 'Частный предприниматель', 'Trabajadores por cuenta propia', 'Kendi işinde çalışan'),
(424, '', NULL, 'secondary_school', 'Secondary school', 'المدرسة الثانوية', 'Middelbare school', 'École secondaire', 'Weiterführende Schule', 'Scuola media', 'Ensino Médio', 'Средняя школа', 'Escuela secundaria', 'Orta okul'),
(425, '', NULL, 'iti', 'ITI', 'ITI', 'ITI', 'ITI', 'ES I', 'ITI', 'ITI', 'ITI', 'ITI', 'ITI'),
(426, '', NULL, 'college', 'College', 'كلية', 'College', 'Université', 'Hochschule', 'Università', 'Faculdade', 'колледж', 'Universidad', 'Kolej'),
(427, '', NULL, 'university', 'University', 'جامعة', 'Universiteit', 'Université', 'Universität', 'Università', 'Universidade', 'Университет', 'Universidad', 'Üniversite'),
(428, '', NULL, 'advanced_degree', 'Advanced degree', 'درجة متقدمة', 'Geavanceerde graad', 'Degré avancé', 'Höheren Abschluss', 'Grado avanzato', 'Grau avançado', 'Ученая степень', 'Grado avanzado', 'İleri derecede'),
(429, '', NULL, 'middle_eastern', 'Middle Eastern', 'شرق اوسطي', 'Midden Oosten', 'Moyen-orientale', 'Naher Osten', 'Medio orientale', 'Oriente médio', 'Ближневосточный', 'Medio este', 'Orta Doğu'),
(430, '', NULL, 'north_african', 'North African', 'شمال أفريقيا', 'Noord-Afrikaans', 'Nord-africain', 'Nordafrikanisch', 'Nordafricano', 'Norte-africano', 'Североафриканец', 'norteafricano', 'Kuzey afrika'),
(431, '', NULL, 'latin_american', 'Latin American', 'أمريكي لاتيني', 'Latijns-Amerikaans', 'latino-américain', 'Lateinamerikanisch', 'latino americano', 'latino Americano', 'Латиноамериканская', 'latinoamericano', 'Latin Amerikalı'),
(432, '', NULL, 'mixed', 'Mixed', 'مختلط', 'Gemengd', 'Mixte', 'Gemischt', 'Misto', 'Misturado', 'смешанный', 'Mezclado', 'Karışık'),
(433, '', NULL, 'asian', 'Asian', 'آسيا', 'Aziatisch', 'asiatique', 'asiatisch', 'asiatico', 'Asiáticos', 'азиатка', 'asiático', 'Asya'),
(434, '', NULL, 'slim', 'Slim', 'معتدل البنيه', 'Slank', 'Svelte', 'Schlank', 'Sottile', 'Magro', 'Тонкий', 'Delgado', 'İnce'),
(435, '', NULL, 'sporty', 'Sporty', 'رياضي', 'sportieve', 'Sportif', 'Sportlich', 'Sportivo', 'Desportivo', 'Sporty', 'Deportivo', 'Sportif'),
(436, '', NULL, 'curvy', 'Curvy', 'متعرج', 'curvy', 'Courbée', 'Kurvig', 'Formosa', 'Curvy', 'Пышная', 'Con curvas', 'düzgün vücutlu'),
(437, '', NULL, 'round', 'Round', 'مستدير - كروي', 'Ronde', 'Rond', 'Runden', 'Il giro', 'Volta', 'Круглый', 'Redondo', 'yuvarlak'),
(438, '', NULL, 'supermodel', 'Supermodel', 'عارضة الازياء', 'Supermodel', 'Supermodel', 'Supermodel', 'Top model', 'Supermodelo', 'Супермодель', 'Supermodelo', 'Süper model'),
(439, '', NULL, 'average', 'Average', 'معدل', 'Gemiddelde', 'Moyenne', 'Durchschnittlich', 'Media', 'Média', 'Средний', 'Promedio', 'Ortalama'),
(440, '', NULL, 'accommodating', 'Accommodating', 'استيعاب', 'Meegaand', 'Accommodant', 'Zuvorkommend', 'Accomodante', 'Acomodando', 'вмещающий', 'Servicial', 'uzlaşmacı'),
(441, '', NULL, 'adventurous', 'Adventurous', 'مغامر', 'Avontuurlijk', 'Aventureux', 'Abenteuerlich', 'Avventuroso', 'Aventureiro', 'предприимчивый', 'Aventurero', 'maceraperest'),
(442, '', NULL, 'calm', 'Calm', 'هدوء', 'Kalmte', 'Calme', 'Ruhe', 'Calma', 'calma', 'штиль', 'Calma', 'Sakin'),
(443, '', NULL, 'careless', 'Careless', 'غير مبالي', 'zorgeloos', 'Négligent', 'Leichtsinnig', 'Negligente', 'Descuidado', 'неосторожный', 'Descuidado', 'Dikkatsiz'),
(444, '', NULL, 'cheerful', 'Cheerful', 'مرح', 'Vrolijk', 'De bonne humeur', 'Heiter', 'Allegro', 'Alegre', 'Веселый', 'Alegre', 'Neşeli'),
(445, '', NULL, 'demanding', 'Demanding', 'مطالبة', 'veeleisende', 'Exigeant', 'Anspruchsvoll', 'Esigente', 'Exigente', 'требовательный', 'Exigente', 'zahmetli'),
(446, '', NULL, 'extroverted', 'Extroverted', 'منطلق', 'extroverted', 'Extraverti', 'Extrovertiert', 'Estroverso', 'Extrovertido', 'экстравертированный', 'Extrovertido', 'dışa dönük'),
(447, '', NULL, 'honest', 'Honest', 'صادق', 'Eerlijk', 'Honnête', 'Ehrlich', 'Onesto', 'Honesto', 'честный', 'Honesto', 'Dürüst'),
(448, '', NULL, 'generous', 'Generous', 'كريم - سخي', 'genereus', 'généreuse', 'Großzügig', 'Generoso', 'Generoso', 'великодушный', 'Generoso', 'Cömert'),
(449, '', NULL, 'humorous', 'Humorous', 'روح الدعابة', 'Humoristisch', 'Humoristique', 'Humorvoll', 'Umoristico', 'Cómico', 'юмористический', 'Humorístico', 'Nükteli, komik'),
(450, '', NULL, 'introverted', 'Introverted', 'الانطواء', 'Introvert', 'Introverti', 'Introvertierte', 'Introverso', 'Introvertido', 'интровертированный', 'Introvertido', 'içe dönük'),
(451, '', NULL, 'liberal', 'Liberal', 'ليبرالية', 'Liberaal', 'Libéral', 'Liberal', 'Liberale', 'Liberal', 'либеральный', 'Liberal', 'Liberal'),
(452, '', NULL, 'lively', 'Lively', 'بحيوية', 'levendig', 'Animé', 'lebhaft', 'Vivace', 'Animada', 'Оживленный', 'Animado', 'Canlı'),
(453, '', NULL, 'loner', 'Loner', 'حيد', 'eenzame', 'Solitaire', 'Einzelgänger', 'Loner', 'Solitário', 'Одиночка', 'Solitario', 'yalnız yaşayan kimse'),
(454, '', NULL, 'nervous', 'Nervous', 'متوتر', 'Nerveus', 'Nerveux', 'Nervös', 'Nervoso', 'Nervoso', 'нервное', 'Nervioso', 'Sinir'),
(455, '', NULL, 'possessive', 'Possessive', 'صيغة الملكية', 'bezittelijk', 'Possessif', 'Besitzergreifend', 'Possessivo', 'Possessivo', 'Притяжательный падеж', 'Posesivo', 'İyelik'),
(456, '', NULL, 'quiet', 'Quiet', 'هادئ', 'Stil', 'Silencieux', 'Ruhig', 'Silenzioso', 'Quieto', 'Тихо', 'Tranquilo', 'Sessiz'),
(457, '', NULL, 'reserved', 'Reserved', 'محجوز', 'Gereserveerd', 'Réservé', 'Reserviert', 'Riservato', 'Reservado', 'Зарезервированный', 'Reservado', 'Ayrılmış'),
(458, '', NULL, 'sensitive', 'Sensitive', 'حساس', 'Gevoelig', 'Sensible', 'Empfindlich', 'Sensibile', 'Sensível', 'чувствительный', 'Sensible', 'Hassas'),
(459, '', NULL, 'shy', 'Shy', 'خجول', 'Verlegen', 'Timide', 'Schüchtern', 'Timido', 'Tímido', 'Застенчивый', 'Tímido', 'Utangaç'),
(460, '', NULL, 'social', 'Social', 'اجتماعي', 'sociaal', 'Social', 'Sozial', 'Sociale', 'Social', 'Социальное', 'Social', 'Sosyal'),
(461, '', NULL, 'spontaneous', 'Spontaneous', 'من تلقاء نفسها', 'Spontaan', 'Spontané', 'Spontan', 'Spontaneo', 'Espontâneo', 'спонтанный', 'Espontáneo', 'Doğal'),
(462, '', NULL, 'stubborn', 'Stubborn', 'عنيد', 'Eigenwijs', 'Têtu', 'Stur', 'Testardo', 'Teimoso', 'Упрямый', 'Obstinado', 'İnatçı'),
(463, '', NULL, 'suspicious', 'Suspicious', 'مشبوه', 'Verdacht', 'Méfiant', 'Verdächtig', 'sospetto', 'Suspeito', 'подозрительный', 'Suspicaz', 'Şüpheli'),
(464, '', NULL, 'thoughtful', 'Thoughtful', 'وقور', 'nadenkend', 'Réfléchi', 'Nachdenklich', 'riflessivo', 'Pensativo', 'Вдумчивый', 'Pensativo', 'Düşünceli'),
(465, '', NULL, 'proud', 'Proud', 'فخور', 'Trots', 'Fier', 'Stolz', 'Orgoglioso', 'Orgulhoso', 'гордый', 'Orgulloso', 'Gururlu'),
(466, '', NULL, 'considerate', 'Considerate', 'تراعي', 'Attent', 'Prévenant', 'Rücksichtsvoll', 'Premuroso', 'Atencioso', 'тактичный', 'Considerado', 'Düşünceli'),
(467, '', NULL, 'friendly', 'Friendly', 'ودود', 'Vriendelijk', 'Amical', 'Freundlich', 'amichevole', 'Amigáveis', 'Дружелюбный', 'Simpático', 'Arkadaş canlısı'),
(468, '', NULL, 'polite', 'Polite', 'مؤدب', 'Beleefd', 'Poli', 'Höflich', 'gentile', 'Educado', 'любезный', 'Cortés', 'Kibar'),
(469, '', NULL, 'reliable', 'Reliable', 'موثوق', 'Betrouwbaar', 'Fiable', 'Zuverlässig', 'Affidabile', 'Confiável', 'надежный', 'De confianza', 'Dürüst'),
(470, '', NULL, 'careful', 'Careful', 'حذر', 'Voorzichtig', 'Prudent', 'Vorsichtig', 'attento', 'Cuidado', 'Осторожный', 'Cuidadoso', 'Dikkatli'),
(471, '', NULL, 'helpful', 'Helpful', 'معاون، مساعد، مفيد، فاعل خير', 'Nuttig', 'Utile', 'Hilfreich', 'Utile', 'Útil', 'полезный', 'Servicial', 'Faydalı'),
(472, '', NULL, 'patient', 'Patient', 'صبور', 'Geduldig', 'Patient', 'Geduldig', 'Paziente', 'Paciente', 'Пациент', 'Paciente', 'Hasta'),
(473, '', NULL, 'optimistic', 'Optimistic', 'متفائل', 'Optimistisch', 'Optimiste', 'Optimistisch', 'Ottimista', 'Otimista', 'Оптимистичный', 'Optimista', 'İyimser'),
(474, '', NULL, 'no__never', 'No, never', 'لا أبدا', 'Nee nooit', 'Non jamais', 'Nein niemals', 'No, mai', 'Não nunca', 'Нет никогда', 'No nunca', 'Hayır asla'),
(475, '', NULL, 'someday__maybe', 'Someday, maybe', 'ربما يوما ما', 'Ooit misschien', 'Un jour peut-être', 'Einestages vielleicht', 'Un giorno forse', 'Algum dia talvez', 'Возможно когда-нибудь', 'Algun dia tal vez', 'Belki birgün'),
(476, '', NULL, 'expecting', 'Expecting', 'تتوقع', 'Ervan uitgaand', 'Attendant', 'Erwarten', 'Prevedendo', 'Esperando', 'Ожидая', 'Esperando', 'beklemek'),
(477, '', NULL, 'i_already_have_kids', 'I already have kids', 'لدي أطفال بالفعل', 'Ik heb al kinderen', 'J\'ai déjà des enfants', 'Ich habe schon Kinder', 'Ho già dei bambini', 'Eu já tenho filhos', 'У меня уже есть дети', 'Ya tengo hijos', 'Benim zaten çocuklarım var'),
(478, '', NULL, 'i_have_kids_and_don_t_want_more', 'I have kids and don&#039;t want more', 'لدي أطفال ولا أريد المزيد', 'Ik heb kinderen en wil niet meer', 'J\'ai des enfants et je ne veux plus', 'Ich habe Kinder und will nicht mehr', 'Ho figli e non ne voglio altri', 'Eu tenho filhos e não quero mais', 'У меня есть дети, и я не хочу больше', 'Tengo hijos y no quiero mas', 'Çocuklarım var ve daha fazla istemiyorum'),
(479, '', NULL, 'no_friends', 'No friends', 'لا أصدقاء', 'Geen vrienden', 'Pas d\'amis', 'Keine Freunde', 'No amici', 'Sem amigos', 'Нет друзей', 'Sin amigos', 'Arkadaş yok'),
(480, '', NULL, 'some_friends', 'Some friends', 'بعض الاصدقاء', 'Een paar vrienden', 'Quelques amis', 'Einige Freunde', 'Alcuni amici', 'Alguns amigos', 'Некоторые друзья', 'Algunos amigos', 'Bazı arkadaşlar'),
(481, '', NULL, 'many_friends', 'Many friends', 'العديد من الأصدقاء', 'Veel vrienden', 'Beaucoup d\'amis', 'Viele Freunde', 'Molti amici', 'Muitos amigos', 'Много друзей', 'Muchos amigos', 'Birçok arkadaş'),
(482, '', NULL, 'only_good_friends', 'Only good friends', 'فقط اصدقاء جيدين', 'Alleen goede vrienden', 'Seulement de bons amis', 'Nur gute Freunde', 'Solo buoni amici', 'Apenas bons amigos', 'Только хорошие друзья', 'Solo buenos amigos', 'Sadece iyi arkadaşlar'),
(483, '', NULL, 'none', 'None', 'لا شيء', 'Geen', 'Aucun', 'Keiner', 'Nessuna', 'Nenhum', 'Никто', 'Ninguna', 'Yok'),
(484, '', NULL, 'have_pets', 'Have pets', 'لديك حيوانات أليفة', 'Huisdieren hebben', 'Avoir des animaux de compagnies', 'Haustiere haben', 'Avere animali domestici', 'Tenha animais de estimação', 'Есть домашние животные', 'Tener mascotas', 'Evcil Hayvan edinmek'),
(485, '', NULL, 'alone', 'Alone', 'وحده', 'Alleen', 'Seul', 'Allein', 'Solo', 'Sozinho', 'В одиночестве', 'Solo', 'Yalnız'),
(486, '', NULL, 'parents', 'Parents', 'الآباء', 'Ouders', 'Parents', 'Eltern', 'genitori', 'Pais', 'Родители', 'Los padres', 'ebeveyn'),
(487, '', NULL, 'partner', 'Partner', 'شريك', 'Partner', 'Partenaire', 'Partner', 'Compagno', 'Parceiro', 'партнер', 'Compañero', 'Ortak'),
(488, '', NULL, 'my_own_car', 'My own car', 'سيارتي', 'Mijn eigen auto', 'Ma propre voiture', 'Mein eigenes Auto', 'La mia macchina', 'Meu próprio carro', 'Моя собственная машина', 'Mi propio auto', 'Kendi arabam'),
(489, '', NULL, 'muslim', 'Muslim', 'مسلم', 'moslim', 'musulman', 'Muslim', 'musulmano', 'muçulmano', 'мусульманка', 'musulmán', 'Müslüman'),
(490, '', NULL, 'atheist', 'Atheist', 'ملحد', 'Atheïst', 'Athée', 'Atheist', 'Ateo', 'Ateu', 'атеист', 'Ateo', 'Ateist'),
(491, '', NULL, 'buddhist', 'Buddhist', 'بوذي', 'Boeddhist', 'bouddhiste', 'Buddhist', 'buddista', 'budista', 'буддист', 'Budista', 'Budist'),
(492, '', NULL, 'catholic', 'Catholic', 'كاثوليكي', 'Katholiek', 'catholique', 'katholisch', 'cattolico', 'católico', 'католик', 'católico', 'katolik'),
(493, '', NULL, 'christian', 'Christian', 'مسيحي', 'Christelijk', 'Christian', 'Christian', 'cristiano', 'cristão', 'Кристиан', 'cristiano', 'Hristiyan'),
(494, '', NULL, 'hindu', 'Hindu', 'الهندوسي', 'Hindoe', 'hindou', 'Hindu-', 'indù', 'hindu', 'индус', 'hindú', 'Hindu'),
(495, '', NULL, 'jewish', 'Jewish', 'يهودي', 'Jewish', 'juif', 'jüdisch', 'ebraico', 'judaico', 'иудейский', 'judío', 'Yahudi'),
(496, '', NULL, 'agnostic', 'Agnostic', 'محايد دينيا', 'Agnostisch', 'Agnostique', 'Agnostisch', 'Agnostico', 'Agnóstico', 'агностик', 'Agnóstico', 'agnostik'),
(497, '', NULL, 'sikh', 'Sikh', 'السيخ', 'Sikh', 'Sikh', 'Sikh', 'Sikh', 'Sikh', 'сикх', 'sij', 'Sih'),
(498, '', NULL, 'never', 'Never', 'أبدا', 'Nooit', 'Jamais', 'noch nie', 'Mai', 'Nunca', 'Никогда', 'Nunca', 'Asla'),
(499, '', NULL, 'i_smoke_sometimes', 'I smoke sometimes', 'أنا أدخن في بعض الأحيان', 'Ik rook soms', 'Je fume parfois', 'Ich rauche manchmal', 'Fumo a volte', 'Eu fumo às vezes', 'Я курю иногда', 'Fumo a veces', 'Bazen sigara içerim'),
(500, '', NULL, 'chain_smoker', 'Chain Smoker', 'سلسلة المدخن', 'Kettingroker', 'Chaîne fumeur', 'Kettenraucher', 'Fumatore incallito', 'Fumante De Corrente', 'Заядлый курильщик', 'Fumador', 'Sigara içen'),
(501, '', NULL, 'i_drink_sometimes', 'I drink sometimes', 'أنا أشرب في بعض الأحيان', 'Ik drink soms', 'Je bois parfois', 'Ich trinke manchmal', 'Bevo a volte', 'Eu bebo as vezes', 'Я пью иногда', 'Yo bebo a veces', 'Bazen içerim'),
(502, '', NULL, 'yes__all_the_time', 'Yes, all the time', 'نعم ، كل الوقت', 'Ja altijd', 'Oui tout le temps', 'Ja, die ganze Zeit', 'Si Sempre', 'Sim o tempo todo', 'Да все время', 'Si todo el tiempo', 'Evet her zaman'),
(503, '', NULL, 'yes__sometimes', 'Yes, sometimes', 'نعم احيانا', 'Ja soms', 'Oui, parfois', 'Ja manchmal', 'Si Qualche volta', 'Sim as vezes', 'Да, иногда', 'Sí a veces', 'Evet bazen'),
(504, '', NULL, 'not_very_much', 'Not very much', 'ليس كثيرا', 'Niet heel erg', 'Pas beaucoup', 'Nicht sehr viel', 'Non molto', 'Não muito', 'Не очень много', 'No mucho', 'Çok değil'),
(505, '', NULL, 'no', 'No', 'لا', 'Nee', 'Non', 'Nein', 'No', 'Não', 'нет', 'No', 'Yok hayır'),
(507, '', NULL, 'avatar', 'Avatar', 'الصورة الرمزية', 'avatar', 'Avatar', 'Benutzerbild', 'Avatar', 'Avatar', 'Аватар', 'Avatar', 'Avatar'),
(508, '', NULL, 'info', 'Info', 'معلومات', 'info', 'Info', 'Info', 'Informazioni', 'Info', 'Информация', 'Información', 'Bilgi'),
(509, '', NULL, 'finish', 'Finish', 'إنهاء', 'Af hebben', 'terminer', 'Fertig', 'finire', 'Terminar', 'Конец', 'Terminar', 'Bitiş'),
(510, '', NULL, 'people_want_to_see_what_you_look_like_', 'people want to see what you look like!', 'يريد الناس أن يروا كيف تبدو!', 'mensen willen zien hoe je eruit ziet!', 'les gens veulent voir à quoi vous ressemblez!', 'Leute wollen sehen, wie du aussiehst!', 'le persone vogliono vedere come sei!', 'as pessoas querem ver como você é!', 'люди хотят видеть как ты выглядишь!', '¡La gente quiere ver cómo te ves!', 'insanlar nasıl göründüğünü görmek istiyor!'),
(511, '', NULL, 'upload_images_to_set_your_profile_picture_image.', 'Upload photos to set your profile picture.', 'قم بتحميل الصور لتعيين صورة ملفك الشخصي.', 'Upload foto\'s om uw profielfoto in te stellen.', 'Téléchargez des photos pour définir votre photo de profil.', 'Laden Sie Fotos hoch, um Ihr Profilbild festzulegen.', 'Carica foto per impostare la tua immagine del profilo.', 'Envie fotos para definir sua foto de perfil.', 'Загрузите фотографии, чтобы установить изображение профиля.', 'Sube fotos para configurar tu foto de perfil.', 'Profil resminizi ayarlamak için fotoğraf yükleyin.'),
(512, '', NULL, 'next', 'Next', 'التالى', 'volgende', 'Suivant', 'Nächster', 'Il prossimo', 'Próximo', 'следующий', 'Siguiente', 'Sonraki'),
(513, '', NULL, 'birthdate', 'Birthday', 'عيد الميلاد', 'Geboortedatum', 'Anniversaire', 'Geburtstag', 'Compleanno', 'Aniversário', 'день рождения', 'Cumpleaños', 'Doğum günü'),
(514, '', NULL, 'congratulations_', 'Congratulations!', 'تهانينا!', 'Gefeliciteerd!', 'Toutes nos félicitations!', 'Herzliche Glückwünsche!', 'Congratulazioni!', 'Parabéns!', 'Поздравляем!', '¡Felicidades!', 'Tebrikler!'),
(515, '', NULL, 'you_have_successfully_registered.', 'You have successfully created your account, please wait..', 'لقد أنشأت حسابك بنجاح ، يرجى الانتظار ..', 'Je bent succesvol geregistreerd.', 'Vous avez créé votre compte avec succès, veuillez patienter ..', 'Sie haben Ihr Konto erfolgreich erstellt. Bitte warten Sie ..', 'Hai creato correttamente il tuo account, per favore aspetta ..', 'Você criou sua conta com sucesso, aguarde ..', 'Вы успешно создали свою учетную запись, пожалуйста, подождите ..', 'Has creado exitosamente tu cuenta, por favor espera ..', 'Hesabınızı başarıyla oluşturdunuz, lütfen bekleyin ..'),
(516, '', NULL, 'images_uploaded', 'Photos successfully uploaded.', 'تم تحميل الصور بنجاح.', 'Afbeeldingen geüpload', 'Photos téléchargées avec succès.', 'Fotos wurden erfolgreich hochgeladen.', 'Foto caricate con successo.', 'Fotos carregadas com sucesso.', 'Фотографии успешно загружены.', 'Fotos subidas con éxito.', 'Fotoğraflar başarıyla yüklendi.'),
(517, '', NULL, 'now__select_any_one_image_that_you_want_to_set_as_your_profile_picture.', 'Now, choose which image you would like to be your avatar.', 'الآن ، اختر الصورة التي تريد أن تكون الصورة الرمزية الخاصة بك.', 'Selecteer nu een afbeelding die u wilt instellen als uw profielfoto.', 'Maintenant, choisissez quelle image vous voulez être votre avatar.', 'Wählen Sie nun aus, welches Bild Sie als Avatar darstellen möchten.', 'Ora, scegli quale immagine desideri essere il tuo avatar.', 'Agora, escolha qual imagem você gostaria de ser seu avatar.', 'Теперь выберите изображение, которое вы хотели бы использовать в качестве аватара.', 'Ahora, elige qué imagen quieres que sea tu avatar.', 'Şimdi, hangi resmin avatarınız olacağını seçin.'),
(518, '', NULL, 'apply', 'Apply', 'تطبيق', 'Van toepassing zijn', 'Appliquer', 'Sich bewerben', 'Applicare', 'Aplique', 'Применять', 'Aplicar', 'Uygulamak'),
(519, '', NULL, 'please_verify_your_phone_number', 'Please verify your phone number.', 'يرجى التحقق من رقم هاتفك.', 'Verifieer uw telefoonnummer', 'Veuillez vérifier votre numéro de téléphone.', 'Bitte überprüfen Sie Ihre Telefonnummer.', 'Si prega di verificare il tuo numero di telefono.', 'Por favor, verifique o seu número de telefone.', 'Пожалуйста, подтвердите свой номер телефона', 'Por favor verifique su número de teléfono.', 'Lütfen telefon numaranızı doğrulayın.'),
(520, '', NULL, 'verify_now', 'verify now', 'تحقق الآن', 'nu verifiëren', 'Vérifiez maintenant', 'Jetzt überprüfen', 'verifica ora', 'Verifique agora', 'подтвердить сейчас', 'verifica ahora', 'Şimdi doğrulayın'),
(522, '', NULL, 'user', 'User', 'المستعمل', 'Gebruiker', 'Utilisateur', 'Nutzer', 'Utente', 'Do utilizador', 'пользователь', 'Usuario', 'kullanıcı'),
(523, '', NULL, 'admin', 'Admin', 'مشرف', 'beheerder', 'Admin', 'Administrator', 'Admin', 'Admin', 'Администратор', 'Administración', 'yönetim'),
(524, '', NULL, 'unreport', 'Delete report', 'حذف التقرير', 'UnReport', 'Annuler le rapport', 'Bericht löschen', 'Elimina rapporto', 'Excluir relatório', 'UnReport', 'Eliminar informe', 'Raporu sil'),
(525, '', NULL, 'user_has_been_reported_successfully.', 'Your report has been record, thank you.', 'كان تقريرك مسجلًا ، شكرًا لك.', 'Gebruiker is succesvol gemeld.', 'L\'utilisateur a été signalé avec succès.', 'Ihr Bericht wurde aufgezeichnet, danke.', 'L\'utente è stato segnalato con successo.', 'Seu relatório foi gravado, obrigado.', 'Пользователь был успешно зарегистрирован.', 'El usuario ha sido reportado exitosamente.', 'Kullanıcı başarıyla rapor edildi.'),
(526, '', NULL, 'remove_report', 'Remove report', 'إزالة التقرير', 'Verwijder rapport', 'Supprimer le rapport', 'Bericht entfernen', 'Rimuovi rapporto', 'Remover relatório', 'Удалить отчет', 'Eliminar informe', 'Raporu kaldır'),
(527, '', NULL, 'sent_image_to_you.', 'sent an image to you.', 'ارسل لك صورة', 'Verzonden afbeelding naar jou.', 'Image envoyée à vous.', 'Bild an Sie gesendet', 'Invia l\'immagine a te.', 'Imagem enviada para você.', 'Отправлено изображение для вас.', 'Imagen enviada a ti.', 'Size görüntü gönderildi.'),
(528, '', NULL, 'very_high', 'Very high', 'عالي جدا', 'Heel hoog', 'Très haut', 'Sehr hoch', 'Molto alto', 'Muito alto', 'Очень высоко', 'Muy alto', 'Çok yüksek'),
(529, '', NULL, 'high', 'High', 'متوسط', 'hoog', 'Haute', 'Hoch', 'alto', 'Alto', 'Высоко', 'Alto', 'Yüksek'),
(530, '', NULL, '180_cm__5__039__11_quot__', '180 cm (5&#039; 11&amp;quot;)', '180 سم (5 \'11 & amp؛ quot؛)', '180 cm (5 \'11 & amp; quot;)', '180 cm (5 \'11 & quot;)', '180 cm (5 \'11 & amp; quot;)', '180 cm (5 \'11 & amp; quot;)', '180 cm (5 \'11 & amp; quot)', '180 см (5 \'11 ', '180 cm (5 \'11 & amp; quot;)', '180 cm (5 \'11\')'),
(531, '', NULL, 'get_premium_to_view_who_liked_you_', 'Get premium to view who liked you!', 'احصل على قسط لعرض من اعجبك!', 'Krijg premie om te zien wie jou leuk vond!', 'Obtenez premium pour voir qui vous a aimé!', 'Holen Sie sich Premium, um zu sehen, wer Sie mochte!', 'Ottieni premium per vedere chi ti è piaciuto!', 'Obtenha premium para ver quem gostou de você!', 'Получите премию, чтобы посмотреть, кто вам понравился!', '¡Consigue una prima para ver quién te ha gustado!', 'Sizi beğenen kim görmek için prim alın!'),
(532, '', NULL, '__sitename___brings_out_the_sense_of_adventure_in_me__the_website_is_so_easy_to_use_and_the_possibility_of_meeting_someone_from_another_culture_that_r', '{{sitename}} brings out the sense of adventure in me! The website is so easy to use and the possibility of meeting someone from another culture that relates to me is simply thrilling.', '{{sitename}} يبرز الإحساس بالمغامرة في داخلي! إن موقع الويب سهل الاستخدام ، وإمكانية مقابلة شخص ما من ثقافة أخرى تتعلق بي مثيرة ببساطة.', '{{sitename}} brengt het gevoel van avontuur in mij naar boven! De website is zo gemakkelijk te gebruiken en de mogelijkheid om iemand uit een andere cultuur te ontmoeten die op mij betrekking heeft, is gewoon opwindend.', '{{sitename}} fait ressortir le sens de l\'aventure en moi! Le site Web est si facile à utiliser et la possibilité de rencontrer quelqu\'un d\'une autre culture qui me concerne est tout simplement excitante.', '{{sitename}} bringt das Gefühl von Abenteuer in mir zum Vorschein! Die Website ist so einfach zu bedienen und die Möglichkeit, jemanden aus einer anderen Kultur zu treffen, der sich auf mich bezieht, ist einfach aufregend.', '{{sitename}} mette in risalto il senso dell\'avventura in me! Il sito web è così facile da usare e la possibilità di incontrare qualcuno di un\'altra cultura che mi riguarda è semplicemente elettrizzante.', '{{sitename}} traz a sensação de aventura em mim! O site é tão fácil de usar e a possibilidade de conhecer alguém de outra cultura que se relaciona comigo é simplesmente emocionante.', '{{sitename}} раскрывает во мне чувство приключения! Веб-сайт очень прост в использовании, и возможность встретить кого-то другого человека, относящегося ко мне, просто волнует.', '¡{{sitename}} saca el sentido de la aventura en mí! El sitio web es muy fácil de usar y la posibilidad de conocer a alguien de otra cultura que se relaciona conmigo es simplemente emocionante.', '{{sitename}} içimdeki macera duygusunu ortaya çıkarıyor! Web sitesi kullanımı çok kolay ve benimle ilgili başka bir kültürden biriyle tanışma imkanı çok heyecan verici.'),
(533, '', NULL, 'why___sitename___is_best', 'Why {{sitename}} is Best', 'لماذا يعتبر {{sitename}} أفضل', 'Waarom {{sitename}} het beste is', 'Pourquoi {{sitename}} est le meilleur', 'Warum {{Sitename}} am besten ist', 'Perché {{sitename}} è il migliore', 'Por que {{sitename}} é melhor', 'Почему {{sitename}} лучше', 'Por qué {{sitename}} es el mejor', '{{Sitename}} Neden En İyi?');
INSERT INTO `langs` (`id`, `ref`, `options`, `lang_key`, `english`, `arabic`, `dutch`, `french`, `german`, `italian`, `portuguese`, `russian`, `spanish`, `turkish`) VALUES
(534, '', NULL, 'your_account_is_safe_on___sitename__._we_never_share_your_data_with_third_party.', 'Your account is Safe on {{sitename}}. We never share your data with third party.', 'حسابك آمن على {{sitename}}. نحن لا نشارك بياناتك مع طرف ثالث.', 'Uw account is veilig op {{sitename}}. Wij delen uw gegevens nooit met derden.', 'Votre compte est en sécurité sur {{sitename}}. Nous ne partageons jamais vos données avec des tiers.', 'Ihr Konto ist sicher am {{Sitename}}. Wir geben Ihre Daten niemals an Dritte weiter.', 'Il tuo account è sicuro su {{sitename}}. Non condividiamo mai i tuoi dati con terze parti.', 'Sua conta é segura em {{sitename}}. Nós nunca compartilhamos seus dados com terceiros.', 'Ваш аккаунт в безопасности {{sitename}}. Мы никогда не передаем ваши данные третьим лицам.', 'Su cuenta es segura en {{sitename}}. Nunca compartimos sus datos con terceros.', 'Hesabınız {{sitename}} tarihinde Güvenli. Verilerinizi asla üçüncü taraflarla paylaşmayız.'),
(535, '', NULL, 'connect_with_your_perfect_soulmate_here__on___sitename__.', 'Connect with your perfect Soulmate here, on {{sitename}}.', 'تواصل مع Soulmate المثالي هنا ، على {{sitename}}.', 'Maak hier verbinding met je perfecte Soulmate, op {{sitename}}.', 'Connectez-vous avec votre âme sœur parfaite ici, le {{sitename}}.', 'Verbinde dich hier mit deinem perfekten Soulmate auf {{sitename}}.', 'Connettiti con la tua anima gemella perfetta qui, su {{sitename}}.', 'Conecte-se com seu Soulmate perfeito aqui, em {{sitename}}.', 'Соединитесь со своим идеальным другом по душе здесь, {{sitename}}.', 'Conéctate con tu alma gemela perfecta aquí, en {{sitename}}.', '{{Sitename}} adresindeki mükemmel Soulmate\'inize buradan bağlanın.'),
(539, '', NULL, '142_cm__4__039__8_quot__', '142 cm (4&#039; 8&amp;quot;)', '142 سم (4 \'8 & amp؛ quot؛)', '142 cm (4 \'8 & amp; quot;)', '142 cm (4 \'8 & quot;)', '142 cm (4 \'8 & amp; quot;)', '142 cm (4 \'8 & amp; quot;)', '142 cm (4 \'8 & amp; quot)', '142 см (4 \'8 ', '142 cm (4 \'8 & amp; quot;)', '142 cm (4 \'8 & quot)'),
(588, '', NULL, 'users', 'users', 'المستخدمين', 'gebruikers', 'utilisateurs', 'Benutzer', 'utenti', 'Comercial', 'пользователи', 'usuarios', 'kullanıcılar'),
(590, '', NULL, 'login_with_wowonder', 'Login with Wowonder', 'تسجيل الدخول مع Wowonder', 'Log in met Wowonder', 'Se connecter avec Wowonder', 'Mit Wowonder anmelden', 'Accedi con Wowonder', 'Entrar com o Wowonder', 'Войти с Wowonder', 'Iniciar sesión con Wowonder', 'Wowonder ile giriş yap'),
(592, '', NULL, 'meet_more_people_with___sitename___credits', 'Meet more People with {{sitename}} Credits', 'تعرف على المزيد من الأشخاص الذين لديهم {{sitename}} رصيدًا', 'Ontmoet meer mensen met {{sitename}} Credits', 'Rencontrer plus de personnes avec des {{sitename}} crédits', 'Treffen Sie mehr Leute mit {{Sitename}} Credits', 'Incontra più persone con crediti {{sitename}}', 'Conheça mais Pessoas com {{sitename}} Créditos', 'Встречайте больше людей с {{sitename}} кредитами', 'Conoce a más personas con {{sitename}} Créditos', '{{Sitename}} Kredileri ile daha fazla kişiyle tanış'),
(595, '', NULL, 'meet_more_people_with___sitename___credits.', 'Meet more People with {{sitename}} Credits.', 'تعرف على المزيد من الأشخاص الذين لديهم {{sitename}} رصيدًا.', 'Ontmoet meer mensen met {{sitename}} Credits.', 'Rencontrez plus de personnes avec des {{sitename}} crédits.', 'Treffen Sie mehr Leute mit {{Sitename}} Credits.', 'Incontra più persone con crediti {{sitename}}.', 'Conheça mais Pessoas com Créditos de {{sitename}}.', 'Встречайте больше людей с {{sitename}} кредитами.', 'Conoce a más personas con {{nombre del sitio}} Créditos.', '{{Sitename}} Kredileri ile daha fazla kişiyle tanışın.'),
(598, '', NULL, 'hack_attempt.', 'Hack attempt.', 'محاولة هاك.', 'Hackpoging.', 'Tentative de piratage.', 'Hack-Versuch', 'Tentativo di hacker.', 'Tentativa de hack.', 'Попытка взлома.', 'Hack intento.', 'Hack girişimi.'),
(599, '', NULL, 'forbidden', 'Forbidden', 'ممنوع', 'Verboden', 'Interdit', 'verboten', 'Proibito', 'Proibido', 'запрещено', 'Prohibido', 'yasak'),
(600, '', NULL, 'no_from_id_found.', 'No from id found.', 'لا من معرف وجدت.', 'Geen van id gevonden.', 'Aucun identifiant trouvé.', 'Nein von der ID gefunden', 'No dall\'ID trovato.', 'Não do id encontrado.', 'Нет с идентификатором найдено.', 'No de la identificación encontrada.', 'Bulunan kimliği yok.'),
(601, '', NULL, 'please_recharge_your_credits.', 'please recharge your credits.', 'يرجى إعادة شحن رصيدك.', 'laad alsjeblieft je credits op.', 'veuillez recharger vos crédits.', 'Bitte laden Sie Ihre Credits auf.', 'per favore ricarica i tuoi crediti.', 'por favor, recarregue seus créditos.', 'пожалуйста, пополните свои кредиты.', 'por favor recarga tus creditos', 'Lütfen kredilerinizi yeniden doldurun.'),
(602, '', NULL, 'message_sent', 'Message sent', 'تم الارسال', 'Bericht verzonden', 'Message envoyé', 'Nachricht gesendet', 'Messaggio inviato', 'Mensagem enviada', 'Сообщение отправлено', 'Mensaje enviado', 'Mesajı gönderildi'),
(603, '', NULL, 'bad_request', 'Bad Request', 'اقتراح غير جيد', 'Foutief verzoek', 'Mauvaise Demande', 'Ungültige Anforderung', 'Brutta richiesta', 'Pedido ruim', 'Неверный запрос', 'Solicitud incorrecta', 'Geçersiz istek'),
(604, '', NULL, 'no_user_id_found.', 'No user ID found.', 'لم يتم العثور على معرف المستخدم.', 'Geen gebruikers-ID gevonden.', 'Aucun ID utilisateur trouvé.', 'Keine Benutzer-ID gefunden', 'Nessun ID utente trovato.', 'Nenhum ID de usuário encontrado.', 'ID пользователя не найден.', 'No se ha encontrado ninguna ID de usuario.', 'Kullanıcı kimliği bulunamadı.'),
(605, '', NULL, 'no_credit_available.', 'No credit available.', 'لا الائتمان المتاحة.', 'Geen tegoed beschikbaar.', 'Aucun crédit disponible.', 'Keine Gutschrift verfügbar', 'Nessun credito disponibile.', 'Nenhum crédito disponível.', 'Нет доступных кредитов.', 'No hay crédito disponible.', 'Kredi mevcut değil.'),
(606, '', NULL, 'user_buy_stickers_successfully.', 'User buy stickers successfully.', 'شراء المستخدم ملصقات بنجاح.', 'Gebruiker koopt stickers met succes.', 'Utilisateur acheter des autocollants avec succès.', 'Benutzer kaufen erfolgreich Aufkleber.', 'L\'utente compra adesivi con successo.', 'O usuário compra adesivos com sucesso.', 'Пользователь успешно купил стикеры.', 'El usuario compra pegatinas con éxito.', 'Kullanıcı başarıyla çıkartma satın alır.'),
(607, '', NULL, 'error_while_save_like.', 'Error while save like.', 'خطأ أثناء حفظ مثل.', 'Fout tijdens opslaan zoals.', 'Erreur lors de la sauvegarde comme.', 'Fehler beim Speichern wie.', 'Errore durante il salvataggio come.', 'Erro enquanto salvar como.', 'Ошибка при сохранении вроде.', 'Error al guardar como.', 'Gibi kaydetme hatası.'),
(608, '', NULL, 'no_chat_user_id_found.', 'No chat user ID found.', 'لم يتم العثور على معرف مستخدم الدردشة.', 'Geen chat-gebruikers-ID gevonden.', 'Aucun ID utilisateur de chat trouvé.', 'Keine Chat-Benutzer-ID gefunden', 'Nessun ID utente chat trovato.', 'Nenhum ID de usuário de bate-papo encontrado.', 'ID пользователя чата не найден.', 'No se ha encontrado ningún ID de usuario de chat.', 'Sohbet kullanıcı kimliği bulunamadı.'),
(609, '', NULL, 'user_buy_new_chat_successfully.', 'User buy new chat successfully.', 'المستخدم شراء دردشة جديدة بنجاح.', 'Gebruiker koopt nieuwe chat met succes.', 'L\'utilisateur achète un nouveau chat avec succès.', 'Benutzer kaufen neuen Chat erfolgreich.', 'L\'utente compra la nuova chat con successo.', 'O usuário compra um novo bate-papo com sucesso.', 'Пользователь успешно купил новый чат.', 'Usuario compra nuevo chat con éxito.', 'Kullanıcı başarıyla yeni sohbeti satın aldı.'),
(610, '', NULL, 'error_while_buy_more_chat_credit.', 'Error while buy more chat credit.', 'خطأ أثناء شراء المزيد من رصيد الدردشة.', 'Fout bij het kopen van meer chatkrediet.', 'Erreur lors de l\'achat de plus de crédit de discussion.', 'Fehler beim Kauf von mehr Chat-Guthaben.', 'Errore durante l\'acquisto di più credito chat.', 'Erro ao comprar mais créditos de bate-papo.', 'Ошибка при покупке более чата.', 'Error al comprar más crédito de chat.', 'Daha fazla sohbet kredisi alırken hata oluştu.'),
(611, '', NULL, 'no_page_number_found.', 'no page number found.', 'لم يتم العثور على رقم الصفحة.', 'geen paginanummer gevonden.', 'aucun numéro de page trouvé.', 'keine Seitennummer gefunden', 'nessun numero di pagina trovato.', 'Nenhum número de página encontrado.', 'номер страницы не найден.', 'no se encontró el número de página.', 'sayfa numarası bulunamadı.'),
(612, '', NULL, 'no_content', 'No Content', 'لا يوجد محتوى', 'Geen inhoud', 'Pas content', 'Kein Inhalt', 'Nessun contenuto', 'Nenhum conteúdo', 'Без содержания', 'Sin contenido', 'İçerik yok'),
(613, '', NULL, 'no_amount_passed', 'No amount passed', 'أي مبلغ مرت', 'Er is geen bedrag verstreken', 'Aucun montant passé', 'Kein Betrag übergeben', 'Nessun importo superato', 'Nenhuma quantia passada', 'Сумма не передана', 'Ninguna cantidad pasada', 'Hiçbir miktar geçilmedi'),
(614, '', NULL, 'amount_is_not_number', 'Amount is not number', 'المبلغ ليس رقم', 'Bedrag is geen nummer', 'Le montant n\'est pas un nombre', 'Betrag ist keine Nummer', 'L\'importo non è il numero', 'Quantidade não é número', 'Сумма не номер', 'La cantidad no es numero', 'Tutar sayı değil'),
(615, '', NULL, 'no_description_passed', 'No description passed', 'لا يوجد وصف مقبول', 'Er is geen beschrijving opgegeven', 'Aucune description transmise', 'Keine Beschreibung übergeben', 'Nessuna descrizione è passata', 'Nenhuma descrição passada', 'Описание не передано', 'No se pasa descripción', 'Hiçbir açıklama geçilmedi'),
(616, '', NULL, 'there_is_no_mode_set_for_this_call', 'There is no mode set for this call', 'لا يوجد وضع ضبط لهذه المكالمة', 'Er is geen modus ingesteld voor deze oproep', 'Il n\'y a pas de mode défini pour cet appel', 'Für diesen Anruf ist kein Modus eingestellt', 'Non c\'è nessuna modalità impostata per questa chiamata', 'Não há modo definido para esta chamada', 'Для этого вызова не установлен режим', 'No hay modo configurado para esta llamada', 'Bu arama için ayarlanmış hiçbir mod yok'),
(617, '', NULL, 'link_generated_successfully', 'Link generated successfully', 'تم إنشاء الرابط بنجاح', 'Link met succes gegenereerd', 'Lien généré avec succès', 'Link erfolgreich erstellt', 'Link generato con successo', 'Link gerado com sucesso', 'Ссылка успешно создана', 'Enlace generado con éxito', 'Bağlantı başarıyla oluşturuldu'),
(618, '', NULL, 'transaction_user_not_match_current_active_user', 'Transaction user not match current active user', 'مستخدم المعاملة غير متطابق مع المستخدم النشط الحالي', 'Transactie gebruiker komt niet overeen met huidige actieve gebruiker', 'L\'opérateur de transaction ne correspond pas à l\'utilisateur actif actuel', 'Der Transaktionsbenutzer stimmt nicht mit dem aktiven Benutzer überein', 'L\'utente della transazione non corrisponde all\'attuale utente attivo', 'Usuário da transação não corresponde ao usuário ativo atual', 'Пользователь транзакции не соответствует текущему активному пользователю', 'El usuario de la transacción no coincide con el usuario activo actual', 'İşlem kullanıcısı geçerli aktif kullanıcıyla eşleşmiyor'),
(619, '', NULL, 'error_while_update_balance_after_charging', 'Error While update balance after charging', 'خطأ أثناء تحديث الرصيد بعد الشحن', 'Fout Tijdens update-balans na opladen', 'Erreur lors de la mise à jour de la balance après le chargement', 'Fehler Während der Aktualisierung der Waage nach dem Laden', 'Errore Durante il bilanciamento dell\'aggiornamento dopo la carica', 'Erro ao atualizar o saldo após o carregamento', 'Ошибка при обновлении баланса после зарядки', 'Error al actualizar el balance después de cargar', 'Hata şarjdan sonra güncelleme bakiyesi sırasında'),
(620, '', NULL, 'missing__url__parameter.', 'Missing `url` parameter.', 'معلمة `url` مفقودة.', 'Ontbrekende parameter `url`.', 'Paramètre `url` manquant.', 'Fehlender `url`-Parameter.', 'Parametro `url` mancante.', 'Parâmetro ', 'Отсутствует параметр `url`.', 'Falta el parámetro `url`.', 'URL parametresi eksik.'),
(621, '', NULL, 'you_can_not_delete_your_profile_image__but_you_can_change_it_first.', 'You can not delete your profile image, but you can change it first.', 'لا يمكنك حذف صورة ملفك الشخصي ، ولكن يمكنك تغييرها أولاً.', 'U kunt uw profielafbeelding niet verwijderen, maar u kunt deze eerst wijzigen.', 'Vous ne pouvez pas supprimer votre image de profil, mais vous pouvez d\'abord la modifier.', 'Sie können Ihr Profilbild nicht löschen, es kann jedoch zuerst geändert werden.', 'Non è possibile eliminare l\'immagine del profilo, ma è possibile modificarla prima.', 'Você não pode excluir sua imagem de perfil, mas pode alterá-la primeiro.', 'Вы не можете удалить изображение своего профиля, но вы можете сначала изменить его.', 'No puedes eliminar tu imagen de perfil, pero puedes cambiarla primero.', 'Profil resminizi silemezsiniz, ancak önce onu değiştirebilirsiniz.'),
(622, '', NULL, 'file_deleted_successfully', 'File deleted successfully', 'تم حذف الملف بنجاح', 'Bestand met succes verwijderd', 'Fichier supprimé avec succès', 'Datei erfolgreich gelöscht', 'File cancellato con successo', 'Arquivo excluído com sucesso', 'Файл успешно удален', 'Archivo eliminado correctamente', 'Dosya başarıyla silindi'),
(623, '', NULL, 'you_can_not_use_more_than_30_character_for_first_name.', 'you can not use more than 30 character for first name.', 'لا يمكنك استخدام أكثر من 30 حرفًا للاسم الأول.', 'je kunt niet meer dan 30 tekens gebruiken voor voornaam.', 'vous ne pouvez pas utiliser plus de 30 caractères pour le prénom.', 'Sie können nicht mehr als 30 Zeichen für den Vornamen verwenden.', 'non è possibile utilizzare più di 30 caratteri per il nome.', 'você não pode usar mais de 30 caracteres para o primeiro nome.', 'Вы не можете использовать более 30 символов для имени.', 'No puedes usar más de 30 caracteres para el primer nombre.', 'ad için 30\'dan fazla karakter kullanamazsınız.'),
(624, '', NULL, 'you_can_not_use_more_than_30_character_for_last_name.', 'you can not use more than 30 character for last name.', 'لا يمكنك استخدام أكثر من 30 حرفًا لاسم العائلة.', 'je kunt niet meer dan 30 tekens gebruiken voor de achternaam.', 'vous ne pouvez pas utiliser plus de 30 caractères pour le nom de famille.', 'Sie können nicht mehr als 30 Zeichen für den Nachnamen verwenden.', 'non è possibile utilizzare più di 30 caratteri per cognome.', 'você não pode usar mais de 30 caracteres para o sobrenome.', 'Вы не можете использовать более 30 символов для фамилии.', 'No puedes usar más de 30 caracteres para el apellido.', 'soyadı için 30\'dan fazla karakter kullanamazsınız.'),
(625, '', NULL, 'this_user_name_is_already_exist.', 'This User name is Already exist.', 'اسم المستخدم هذا موجود بالفعل.', 'Deze gebruikersnaam bestaat al.', 'Ce nom d\'utilisateur est déjà existant.', 'Dieser Benutzername ist bereits vorhanden.', 'Questo nome utente è già esistente.', 'Este nome de usuário já existe.', 'Это имя пользователя уже существует.', 'Este nombre de usuario ya existe.', 'Bu kullanıcı adı zaten var.'),
(626, '', NULL, 'this_user_name_is_reserved_word._please_choose_anther_username.', 'This User name is reserved word. please choose anther username.', 'اسم المستخدم هذا محجوز. الرجاء اختيار اسم المستخدم من anther.', 'Deze gebruikersnaam is gereserveerd woord. kies alstublieft de anther-gebruikersnaam.', 'Ce nom d\'utilisateur est un mot réservé. veuillez choisir un autre nom d\'utilisateur.', 'Dieser Benutzername ist ein reserviertes Wort. Bitte wählen Sie einen anderen Benutzernamen.', 'Questo nome utente è una parola riservata. per favore scegli un altro nome utente.', 'Este nome de usuário é uma palavra reservada. Por favor, escolha anher username.', 'Это имя пользователя является зарезервированным словом. Пожалуйста, выберите другое имя пользователя.', 'Este nombre de usuario es palabra reservada. Por favor, elija otro nombre de usuario.', 'Bu kullanıcı adı saklıdır. lütfen diğer kullanıcı adını seçin.'),
(627, '', NULL, 'empty_user_name.', 'empty user name.', 'اسم مستخدم فارغ.', 'lege gebruikersnaam.', 'Nom d\'utilisateur vide.', 'leerer Benutzername', 'nome utente vuoto.', 'nome de usuário vazio.', 'пустое имя пользователя.', 'Nombre de usuario vacío.', 'boş kullanıcı ismi.'),
(628, '', NULL, 'this_e-mail_is_invalid.', 'This e-mail is invalid.', 'هذا البريد الإلكتروني غير صالح.', 'Deze email is ongeldig.', 'Cette adresse email est invalide.', 'Diese E-Mail ist nicht gültig.', 'Questa e-mail non è valida.', 'Este email é inválido.', 'Этот адрес электронной почты недействителен.', 'Este email es invalido.', 'Bu email geçersizdir.'),
(629, '', NULL, 'this_email_is_already_exist.', 'This email is Already exist.', 'هذا البريد الإلكتروني موجود بالفعل.', 'Deze e-mail bestaat al.', 'Cet email existe déjà.', 'Diese E-Mail ist bereits vorhanden.', 'Questa email è già esistente.', 'Este email já existe.', 'Это письмо уже существует.', 'Este correo electrónico ya existe.', 'Bu e-posta zaten var.'),
(630, '', NULL, 'profile_general_data_saved_successfully.', 'Profile general data saved successfully.', 'تم حفظ البيانات العامة للملف الشخصي بنجاح.', 'Profiel algemene gegevens succesvol opgeslagen.', 'Les données générales du profil ont été enregistrées avec succès.', 'Profildaten wurden erfolgreich gespeichert.', 'Dati generali del profilo salvati correttamente.', 'Dados gerais do perfil salvos com sucesso.', 'Общие данные профиля успешно сохранены.', 'Perfil de datos generales guardados con éxito.', 'Profil genel verileri başarıyla kaydedildi.'),
(631, '', NULL, 'error_while_saving_general_profile_settings.', 'Error while saving general profile settings.', 'خطأ أثناء حفظ إعدادات الملف الشخصي العام.', 'Fout tijdens het opslaan van algemene profielinstellingen.', 'Erreur lors de l\'enregistrement des paramètres de profil généraux.', 'Fehler beim Speichern der allgemeinen Profileinstellungen.', 'Errore durante il salvataggio delle impostazioni generali del profilo.', 'Erro ao salvar as configurações gerais do perfil.', 'Ошибка при сохранении общих настроек профиля.', 'Error al guardar la configuración general del perfil.', 'Genel profil ayarları kaydedilirken hata oluştu.'),
(632, '', NULL, 'profile_data_saved_successfully.', 'Profile data saved successfully.', 'تم حفظ بيانات الملف الشخصي بنجاح.', 'Profielgegevens zijn succesvol opgeslagen.', 'Les données de profil ont été enregistrées avec succès.', 'Profildaten erfolgreich gespeichert', 'Dati del profilo salvati correttamente.', 'Dados do perfil salvos com sucesso.', 'Данные профиля успешно сохранены.', 'Datos de perfil guardados con éxito.', 'Profil verileri başarıyla kaydedildi.'),
(633, '', NULL, 'error_while_saving_profile_settings.', 'Error while saving profile settings.', 'خطأ أثناء حفظ إعدادات الملف الشخصي.', 'Fout tijdens het opslaan van profielinstellingen.', 'Erreur lors de l\'enregistrement des paramètres de profil.', 'Fehler beim Speichern der Profileinstellungen.', 'Errore durante il salvataggio delle impostazioni del profilo.', 'Erro ao salvar as configurações do perfil.', 'Ошибка при сохранении настроек профиля.', 'Error al guardar la configuración del perfil.', 'Profil ayarları kaydedilirken hata oluştu.'),
(634, '', NULL, 'profile_privacy_data_saved_successfully.', 'Profile privacy data saved successfully.', 'تم حفظ بيانات خصوصية الملف الشخصي بنجاح.', 'Profielprivacygegevens zijn succesvol opgeslagen.', 'Les données de confidentialité du profil ont été enregistrées avec succès.', 'Profildaten wurden erfolgreich gespeichert.', 'Dati sulla privacy del profilo salvati correttamente.', 'Dados de privacidade do perfil salvos com sucesso.', 'Данные о конфиденциальности профиля успешно сохранены.', 'Los datos de privacidad del perfil se guardaron correctamente.', 'Profil gizlilik verileri başarıyla kaydedildi.'),
(635, '', NULL, 'passwords_don_t_match.', 'Passwords Don&#039;t Match.', 'لا تتطابق كلمات المرور.', 'Wachtwoorden komen niet overeen.', 'Les mots de passe ne correspondent pas.', 'Passwörter stimmen nicht überein.', 'Le password non corrispondono.', 'Senhas não combinam.', 'Пароли не совпадают.', 'Las contraseñas no coinciden.', 'Şifreler Eşleşmiyor.'),
(636, '', NULL, 'missing_new_password.', 'Missing New password.', 'مفقود كلمة مرور جديدة.', 'Ontbrekend nieuw wachtwoord.', 'Nouveau mot de passe manquant.', 'Fehlendes neues Passwort.', 'Nuova password mancante.', 'Nova senha ausente.', 'Отсутствует новый пароль.', 'Falta nueva contraseña.', 'Yeni şifre eksik.'),
(637, '', NULL, 'password_is_too_short.', 'Password is too short.', 'كلمة المرور قصيرة جدا.', 'Wachtwoord is te kort.', 'Le mot de passe est trop court.', 'Das Passwort ist zu kurz.', 'La password è troppo corta.', 'A senha é muito curta.', 'Пароль слишком короткий.', 'La contraseña es demasiado corta.', 'Şifre çok kısa.'),
(638, '', NULL, 'current_password_missing_.', 'Current password missing .', 'كلمة المرور الحالية مفقودة.', 'Huidig ​​wachtwoord ontbreekt.', 'Mot de passe actuel manquant.', 'Aktuelles Passwort fehlt.', 'Password attuale mancante.', 'Senha atual ausente.', 'Текущий пароль отсутствует.', 'Falta la contraseña actual.', 'Mevcut şifre eksik.'),
(639, '', NULL, 'current_password_is_wrong__please_check_again.', 'Current password is wrong, please check again.', 'كلمة المرور الحالية خاطئة ، يرجى التحقق مرة أخرى.', 'Huidig ​​wachtwoord klopt niet, controleer nogmaals.', 'Le mot de passe actuel est incorrect, veuillez vérifier à nouveau.', 'Das aktuelle Passwort ist falsch. Bitte überprüfen Sie es erneut.', 'La password corrente è sbagliata, si prega di controllare di nuovo.', 'A senha atual está errada, por favor, verifique novamente.', 'Неверный текущий пароль, пожалуйста, проверьте еще раз.', 'La contraseña actual es incorrecta, por favor verifique nuevamente.', 'Geçerli şifre yanlış, lütfen tekrar kontrol edin.'),
(640, '', NULL, 'password_updated_successfully.', 'Password updated successfully.', 'تم تحديث كلمة السر بنجاح.', 'wachtwoord succesvol bijgewerkt.', 'Mot de passe mis à jour avec succès.', 'Passwort erfolgreich aktualisiert.', 'Password aggiornata correttamente.', 'Senha atualizada com sucesso.', 'Пароль успешно обновлен.', 'Contraseña actualizada exitosamente.', 'Şifre başarıyla güncellendi.'),
(641, '', NULL, 'error_while_update_your_password__please_check_again.', 'Error while update your password, please check again.', 'حدث خطأ أثناء تحديث كلمة المرور ، يرجى التحقق مرة أخرى.', 'Fout tijdens het bijwerken van uw wachtwoord, controleer nogmaals.', 'Erreur lors de la mise à jour de votre mot de passe, veuillez vérifier à nouveau.', 'Fehler beim Aktualisieren Ihres Passworts. Bitte überprüfen Sie es erneut.', 'Errore durante l\'aggiornamento della password, si prega di controllare di nuovo.', 'Erro ao atualizar sua senha, verifique novamente.', 'Ошибка при обновлении пароля, пожалуйста, проверьте еще раз.', 'Error al actualizar su contraseña, por favor verifique nuevamente.', 'Şifreniz güncellenirken hata oluştu, lütfen tekrar kontrol edin.'),
(642, '', NULL, 'please_enter_just_facebook_profile_user.', 'Please enter just facebook profile user.', 'يرجى إدخال مجرد ملف تعريف الفيسبوك.', 'Voer alstublieft gewoon Facebook-profielgebruiker in.', 'S\'il vous plaît entrer seulement l\'utilisateur de profil facebook.', 'Bitte geben Sie nur den Facebook-Profilbenutzer ein.', 'Si prega di inserire solo utente profilo Facebook.', 'Por favor, digite apenas o usuário do perfil do facebook.', 'Пожалуйста, введите только профиль пользователя Facebook.', 'Por favor, introduzca solo el perfil de usuario de Facebook', 'Lütfen sadece facebook profil kullanıcısını giriniz.'),
(643, '', NULL, 'please_enter_just_twitter_profile_user.', 'Please enter just twitter profile user.', 'الرجاء إدخال مجرد ملف تعريف تويتر.', 'Voer alstublieft alleen de twitter-profielgebruiker in.', 'S\'il vous plaît entrer juste utilisateur de profil twitter.', 'Bitte geben Sie einfach den Twitter-Profilbenutzer an.', 'Si prega di inserire solo utente profilo di Twitter.', 'Por favor, digite apenas o usuário do perfil do twitter.', 'Пожалуйста, введите просто профиль пользователя Twitter.', 'Por favor, introduzca sólo el perfil de usuario de Twitter.', 'Lütfen sadece twitter profil kullanıcısı giriniz.'),
(644, '', NULL, 'please_enter_just_google_profile_user.', 'Please enter just google profile user.', 'الرجاء إدخال مستخدم ملف تعريف google فقط.', 'Voer alstublieft alleen een google profielgebruiker in.', 'S\'il vous plaît entrer seulement utilisateur de profil google.', 'Bitte geben Sie einfach einen Google-Profilbenutzer ein.', 'Inserisci solo utente profilo google.', 'Por favor, digite apenas o usuário do perfil do Google.', 'Пожалуйста, введите только профиль пользователя Google.', 'Por favor, introduzca sólo el perfil de usuario de google.', 'Lütfen sadece google profil kullanıcısını girin.'),
(645, '', NULL, 'please_enter_just_instagrem_profile_user.', 'Please enter just instagrem profile user.', 'يرجى إدخال ملف تعريف instagrem فقط.', 'Voer alstublieft alleen de gebruiker van het instagremprofiel in.', 'S\'il vous plaît entrer seulement utilisateur de profil instagrem.', 'Bitte geben Sie nur instagrem Profilbenutzer ein.', 'Si prega di inserire solo utente profilo instagrem.', 'Por favor, insira apenas o usuário do perfil instagrem.', 'Пожалуйста, введите просто профиль пользователя instagrem.', 'Por favor ingrese solo instagrem perfil de usuario.', 'Lütfen sadece instagrem profil kullanıcısını giriniz.'),
(646, '', NULL, 'please_enter_just_linkedin_profile_user.', 'Please enter just linkedin profile user.', 'الرجاء إدخال مستخدم الملف الشخصي المرتبطة فقط.', 'Voer alstublieft een linkedin-gebruikersprofiel in.', 'S\'il vous plaît entrer seulement utilisateur de profil linkedin.', 'Bitte geben Sie nur den LinkedIn Benutzer an.', 'Si prega di inserire solo utente profilo linkedin.', 'Por favor, digite apenas o usuário do perfil do linkedin.', 'Пожалуйста, введите только профиль пользователя.', 'Por favor ingrese solo el perfil de usuario de linkedin', 'Lütfen sadece linkedin profil kullanıcısını giriniz.'),
(647, '', NULL, 'please_enter_valid_domain_name.', 'Please enter valid domain name.', 'الرجاء إدخال اسم مجال صالح.', 'Voer een geldige domeinnaam in.', 'Veuillez entrer un nom de domaine valide.', 'Bitte geben Sie einen gültigen Domainnamen ein.', 'Si prega di inserire il nome di dominio valido.', 'Por favor, insira um nome de domínio válido.', 'Пожалуйста, введите действительное доменное имя.', 'Por favor, introduzca un nombre de dominio válido.', 'Lütfen geçerli bir alan adı giriniz.'),
(648, '', NULL, 'social_setting_updated_successfully.', 'Social setting updated successfully.', 'تم تحديث الإعداد الاجتماعي بنجاح.', 'Sociale instellingen zijn succesvol bijgewerkt.', 'Paramètre social mis à jour avec succès.', 'Soziale Einstellungen wurden erfolgreich aktualisiert.', 'Impostazioni sociali aggiornate con successo.', 'Configuração social atualizada com sucesso.', 'Социальная настройка успешно обновлена.', 'Entorno social actualizado con éxito.', 'Sosyal ayar başarıyla güncellendi.'),
(649, '', NULL, 'error_while_saving_social_setting.', 'Error while saving social setting.', 'حدث خطأ أثناء حفظ الإعداد الاجتماعي.', 'Fout bij het opslaan van sociale instellingen.', 'Erreur lors de la sauvegarde du contexte social.', 'Fehler beim Speichern der sozialen Einstellung.', 'Errore durante il salvataggio delle impostazioni social.', 'Erro ao salvar a configuração social.', 'Ошибка при сохранении социальных настроек.', 'Error al guardar el entorno social.', 'Sosyal ayar kaydedilirken hata oluştu.'),
(650, '', NULL, 'emails_setting_saved_successfully.', 'Emails setting saved successfully.', 'تم حفظ إعداد الرسائل الإلكترونية بنجاح.', 'E-mails instellen succesvol opgeslagen.', 'Réglage des e-mails enregistré avec succès.', 'E-Mail-Einstellung erfolgreich gespeichert.', 'Impostazioni email salvate correttamente.', 'Configuração de e-mails salva com sucesso.', 'Настройки электронной почты успешно сохранены.', 'Configuración de correos electrónicos guardados con éxito.', 'E-postalar ayarı başarıyla kaydedildi.'),
(651, '', NULL, 'error_while_saving_email_setting.', 'Error while saving email setting.', 'خطأ أثناء حفظ إعداد البريد الإلكتروني.', 'Fout tijdens het opslaan van de e-mailinstelling.', 'Erreur lors de l\'enregistrement du paramètre de courrier électronique.', 'Fehler beim Speichern der E-Mail-Einstellung.', 'Errore durante il salvataggio delle impostazioni e-mail.', 'Erro ao salvar a configuração de e-mail.', 'Ошибка при сохранении настроек электронной почты.', 'Error al guardar la configuración de correo electrónico.', 'E-posta ayarları kaydedilirken hata oluştu.'),
(652, '', NULL, 'missing__to__parameter.', 'Missing `to` parameter.', 'مفقود `إلى` المعلمة.', 'Ontbrekende `to`-parameter.', 'Paramètre `to` manquant.', 'Fehlender to-Parameter.', 'Parametro `to` mancante.', 'Parâmetro `to` em falta.', 'Отсутствует параметр `to`.', 'Falta el parámetro `to`.', 'Parametresine eksik.'),
(653, '', NULL, 'missing__gift_id__parameter.', 'Missing `gift_id` parameter.', 'معلمة `gift_id` مفقودة.', 'Ontbrekende `gift_id` parameter.', 'Paramètre `gift_id` manquant.', 'Fehlender `gift_id`-Parameter.', 'Parametro `gift_id` mancante.', 'Parâmetro `gift_id` em falta.', 'Отсутствует параметр gift_id.', 'Falta el parámetro `gift_id`.', '`Gift_id` parametresi eksik.'),
(654, '', NULL, 'gift_send_successfully.', 'Gift send successfully.', 'هدية ترسل بنجاح.', 'Gift verzend met succes.', 'Cadeau envoyé avec succès.', 'Geschenk erfolgreich versenden', 'Regalo inviato con successo.', 'Dom enviar com sucesso.', 'Подарок успешно отправлен.', 'Regalo enviado con éxito.', 'Hediye başarıyla gönderildi.'),
(655, '', NULL, 'gift_send_failed.', 'Gift send failed.', 'فشلت إرسال هدية.', 'Het verzenden van geschenken is mislukt.', 'L\'envoi du cadeau a échoué.', 'Geschenksendung fehlgeschlagen', 'Invio regalo fallito.', 'Envio de presente falhou.', 'Не удалось отправить подарок.', 'El envío de regalos falló.', 'Hediye gönderimi başarısız oldu.'),
(656, '', NULL, 'missing__id__parameter.', 'Missing `id` parameter.', 'معلمة `id` مفقودة.', 'Ontbrekende `id` parameter.', 'Paramètre `id` manquant.', 'Fehlender ', 'Parametro `id` mancante.', 'Parâmetro `id` em falta.', 'Отсутствует параметр `id`.', 'Falta el parámetro `id`.', 'ID parametresi eksik.'),
(657, '', NULL, 'user_buy_more_visits_successfully.', 'User buy more visits successfully.', 'المستخدم شراء المزيد من الزيارات بنجاح.', 'Gebruiker koopt meer bezoeken met succes.', 'L\'utilisateur achète plus de visites avec succès.', 'Benutzer kaufen mehr Besuche erfolgreich.', 'L\'utente compra più visite con successo.', 'O usuário compra mais visitas com sucesso.', 'Пользователь покупает больше посещений успешно.', 'El usuario compra más visitas con éxito.', 'Kullanıcı başarıyla daha fazla ziyaret satın aldı.'),
(658, '', NULL, 'error_while_buy_more_visits.', 'Error while buy more visits.', 'حدث خطأ أثناء شراء المزيد من الزيارات.', 'Fout bij het kopen van meer bezoeken.', 'Erreur lors de l\'achat de plus de visites.', 'Fehler beim Kauf weiterer Besuche.', 'Errore durante l\'acquisto di più visite.', 'Erro ao comprar mais visitas.', 'Ошибка при покупке больше посещений.', 'Error al comprar más visitas.', 'Daha fazla ziyaret alırken hata oluştu.'),
(659, '', NULL, 'user_buy_more_matches_successfully.', 'User buy more matches successfully.', 'المستخدم شراء المزيد من المباريات بنجاح.', 'Gebruiker koopt meer wedstrijden met succes.', 'L\'utilisateur achète plus de correspondances avec succès.', 'Der Nutzer kauft erfolgreich mehr Übereinstimmungen.', 'L\'utente compra più partite con successo.', 'O usuário compra mais correspondências com sucesso.', 'Пользователь успешно купил больше матчей.', 'El usuario compra más partidos con éxito.', 'Kullanıcı başarıyla daha fazla eşleşme satın alır.'),
(660, '', NULL, 'error_while_buy_more_matches.', 'Error while buy more matches.', 'خطأ أثناء شراء المزيد من التطابقات.', 'Fout bij het kopen van meer overeenkomsten.', 'Erreur lors de l\'achat de plusieurs correspondances.', 'Fehler beim Kauf weiterer Übereinstimmungen.', 'Errore durante l\'acquisto di più partite.', 'Erro ao comprar mais correspondências.', 'Ошибка при покупке большего количества совпадений.', 'Error al comprar más partidos.', 'Daha fazla eşleşme alırken hata oluştu.'),
(661, '', NULL, 'user_buy_more_likes_successfully.', 'User buy more likes successfully.', 'يشتري المستخدم المزيد من الإعجابات بنجاح.', 'Gebruiker koopt meer likes met succes.', 'L\'utilisateur achète plus de goûts avec succès.', 'Der Nutzer kauft erfolgreich mehr Likes.', 'L\'utente compra più Mi piace con successo.', 'O usuário compra mais curtidas com sucesso.', 'Пользователь успешно купил больше лайков.', 'Usuario compra más gustos con éxito.', 'Kullanıcı daha çok satın almayı başarıyla sever.'),
(662, '', NULL, 'error_while_buy_more_likes.', 'Error while buy more likes.', 'خطأ أثناء شراء المزيد من الإعجابات.', 'Fout bij het kopen van meer likes.', 'Erreur lors de l\'achat de plus de goûts.', 'Fehler beim Kauf von mehr Likes.', 'Errore durante l\'acquisto di più Mi piace.', 'Erro ao comprar mais curtidas.', 'Ошибка пока покупай больше лайков.', 'Error al comprar más me gusta.', 'Daha fazla satın alırken hata oluştu.'),
(663, '', NULL, 'current_password_missing.', 'Current password missing.', 'كلمة المرور الحالية مفقودة.', 'Huidig ​​wachtwoord ontbreekt.', 'Mot de passe actuel manquant.', 'Aktuelles Passwort fehlt.', 'Password attuale mancante.', 'Senha atual ausente.', 'Текущий пароль отсутствует.', 'Falta la contraseña actual.', 'Mevcut şifre eksik.'),
(664, '', NULL, 'your_account_deleted_successfully.', 'Your account deleted successfully.', 'تم حذف حسابك بنجاح.', 'Uw account is succesvol verwijderd.', 'Votre compte a bien été supprimé.', 'Ihr Konto wurde erfolgreich gelöscht.', 'Il tuo account è stato eliminato con successo.', 'Sua conta foi excluída com sucesso.', 'Ваш аккаунт успешно удален.', 'Tu cuenta eliminada exitosamente.', 'Hesabınız başarıyla silindi.'),
(665, '', NULL, 'missing_e-mail', 'Missing E-mail', 'بريد إلكتروني مفقود', 'Ontbrekende e-mail', 'E-mail manquant', 'Fehlende E-Mail', 'E-mail mancante', 'E-mail ausente', 'Отсутствует электронная почта', 'Falta el correo electrónico', 'Eksik e-posta'),
(666, '', NULL, 'this_e-mail_is_invalid', 'This E-mail is invalid', 'هذا البريد الإلكتروني غير صالح', 'Deze email is ongeldig', 'Cette adresse email est invalide', 'Diese E-Mail ist nicht gültig', 'Questa e-mail non è valida', 'Este email é inválido', 'Этот адрес электронной почты недействителен', 'Este email es invalido', 'Bu email geçersizdir'),
(667, '', NULL, 'missing_message', 'Missing message', 'رسالة مفقودة', 'Bericht ontbreekt', 'Message manquant', 'Fehlende Nachricht', 'Messaggio mancante', 'Mensagem perdida', 'Сообщение отсутствует', 'Mensaje faltante', 'Eksik mesaj'),
(668, '', NULL, 'thank_you_for_contacting_us', 'Thank you for contacting us', 'أشكركم على الاتصال بنا', 'Bedankt dat je contact met ons hebt opgenomen', 'Merci de nous contacter', 'Danke, dass Sie uns kontaktiert haben', 'Grazie per averci contattato', 'Obrigado por nos contatar', 'Благодарим Вас за обращение к нам', 'Gracias por contactarnos', 'Bizimle iletişime geçtiğiniz için teşekkürler'),
(669, '', NULL, 'message_sent_successfully', 'message sent successfully', 'تم إرسال الرسالة بنجاح', 'Bericht succesvol verzonden', 'message envoyé avec succès', 'Nachricht erfolgreich gesendet', 'messaggio inviato con successo', 'mensagem enviada com sucesso', 'Сообщение успешно отправлено', 'Mensaje enviado con éxito', 'mesaj başarıyla gönderildi'),
(670, '', NULL, 'can_not_send_message', 'can not send message', 'لا يمكن إرسال رسالة', 'kan geen bericht verzenden', 'ne peut pas envoyer de message', 'kann keine Nachricht senden', 'non posso inviare un messaggio', 'não pode enviar mensagem', 'не могу отправить сообщение', 'no se puede enviar mensaje', 'mesaj gönderemiyorum'),
(671, '', NULL, 'no_token', 'No Token', 'لا يوجد رمز', 'Geen token', 'Pas de jeton', 'Kein Token', 'Nessun token', 'Nenhum token', 'Без токена', 'No Token', 'Jeton yok'),
(672, '', NULL, 'no_description', 'No description', 'بدون وصف', 'Geen beschrijving', 'Pas de description', 'Keine Beschreibung', 'Nessuna descrizione', 'Nenhuma descrição', 'нет описания', 'Sin descripción', 'açıklama yok'),
(673, '', NULL, 'no_paytype', 'No payType', 'لا يوجد نوع', 'Geen payType', 'Aucun payType', 'Kein payType', 'Nessun payType', 'Sem payType', 'Нет payType', 'No payType', 'Ödeme türü yok'),
(674, '', NULL, 'payment_successfully', 'Payment successfully', 'دفع بنجاح', 'Betaling succesvol', 'Paiement réussi', 'Zahlung erfolgreich', 'Pagamento con successo', 'Pagamento com sucesso', 'Оплата успешно', 'Pago exitoso', 'Ödeme başarıyla yapıldı'),
(675, '', NULL, 'missing_username.', 'Missing username.', 'اسم المستخدم مفقود.', 'Ontbrekende gebruikersnaam.', 'Nom d\'utilisateur manquant.', 'Fehlender Benutzername', 'Nome utente mancante', 'Nome de usuário ausente.', 'Отсутствует имя пользователя.', 'Falta el nombre de usuario.', 'Kayıp kullanıcı adı'),
(676, '', NULL, 'missing_password.', 'Missing password.', 'كلمة مرور مفقودة.', 'Ontbrekend wachtwoord.', 'Mot de passe manquant', 'Fehlendes Passwort', 'Password mancante', 'Senha ausente.', 'Отсутствует пароль.', 'Falta la contraseña.', 'Kayıp şifre'),
(677, '', NULL, 'this_e-mail_is_already_exist.', 'This E-mail is Already exist.', 'هذا البريد الإلكتروني موجود بالفعل.', 'Deze e-mail bestaat al.', 'Cet e-mail est déjà existant.', 'Diese E-Mail ist bereits vorhanden.', 'Questa e-mail è già esistente.', 'Este e-mail já existe.', 'Этот E-mail уже существует.', 'Este correo electrónico ya existe.', 'Bu e-posta zaten var.'),
(678, '', NULL, 'username_must_be_between_5_32.', 'Username must be between 5/32.', 'يجب أن يكون اسم المستخدم بين 5/32.', 'Gebruikersnaam moet tussen 5/32 zijn.', 'Le nom d\'utilisateur doit être compris entre 5/32.', 'Der Benutzername muss zwischen 5/32 liegen.', 'Il nome utente deve essere compreso tra 5/32.', 'O nome de usuário deve estar entre 5/32.', 'Имя пользователя должно быть между 5/32.', 'El nombre de usuario debe estar entre 5/32.', 'Kullanıcı adı 5/32 arasında olmalıdır.'),
(679, '', NULL, 'invalid_username_characters.', 'Invalid username characters.', 'أحرف اسم المستخدم غير صالحة.', 'Ongeldige gebruikersnaamtekens.', 'Nom d\'utilisateur invalide.', 'Ungültige Zeichen für den Benutzernamen', 'Caratteri del nome utente non validi.', 'Caracteres de nome de usuário inválidos.', 'Неверные символы имени пользователя.', 'Caracteres de usuario inválidos', 'Geçersiz kullanıcı adı karakterleri.'),
(680, '', NULL, 'registration_successfully', 'Registration successfully', 'التسجيل بنجاح', 'Registratie succesvol', 'Enregistrement réussi', 'Registrierung erfolgreich', 'Registrazione avvenuta con successo', 'Registro com sucesso', 'Регистрация успешно', 'Registro exitoso', 'Kayıt başarıyla yapıldı'),
(681, '', NULL, 'incorrect_username_or_password.', 'Incorrect username or password.', 'اسم المستخدم أو كلمة المرور غير صحيحة.', 'Foute gebruikersnaam of wachtwoord.', 'Identifiant ou mot de passe incorrect.', 'Falscher Benutzername oder Passwort.', 'Nome utente o password errati.', 'Usuário ou senha incorretos.', 'Неверное имя пользователя или пароль.', 'Nombre de usuario o contraseña incorrecta.', 'Yanlış kullanıcı adı ya da parola.'),
(682, '', NULL, 'resource_endpoint_class_file_not_found.', 'Resource endpoint class file not found.', 'لم يتم العثور على ملف فئة نقطة نهاية المورد.', 'Resource-eindpunt klassefile niet gevonden.', 'Fichier de classe de point de terminaison de ressource introuvable.', 'Ressource-Endpunktklassendatei nicht gefunden.', 'File della classe dell\'endpoint della risorsa non trovato.', 'Arquivo de classe de terminal do recurso não localizado.', 'Файл класса конечной точки ресурса не найден.', 'No se encontró el archivo de clase de punto final de recurso.', 'Kaynak uç nokta sınıfı dosyası bulunamadı.'),
(683, '', NULL, 'login_successfully', 'Login successfully', 'تسجيل الدخول بنجاح', 'Inloggen succesvol', 'Se connecter avec succès', 'Login erfolgreich', 'Accedi con successo', 'Login com sucesso', 'Войти успешно', 'Iniciar sesión correctamente', 'giriş başarılı'),
(684, '', NULL, 'an_error_occurred_while_processing_the_form.', 'An error occurred while processing the form.', 'حدث خطأ أثناء معالجة النموذج.', 'Er is een fout opgetreden tijdens het verwerken van het formulier.', 'Une erreur s\'est produite lors du traitement du formulaire.', 'Bei der Verarbeitung des Formulars ist ein Fehler aufgetreten.', 'Si è verificato un errore durante l\'elaborazione del modulo.', 'Ocorreu um erro durante o processamento do formulário.', 'Произошла ошибка при обработке формы.', 'Se produjo un error al procesar el formulario.', 'Form işlenirken bir hata oluştu.'),
(685, '', NULL, 'missing_e-mail.', 'Missing E-mail.', 'بريد إلكتروني مفقود.', 'Ontbrekende e-mail.', 'E-mail manquant.', 'Fehlende E-Mail', 'E-mail mancante.', 'E-mail ausente.', 'Отсутствует электронная почта.', 'Falta el correo electrónico.', 'Eksik e-posta'),
(686, '', NULL, 'this_e-mail', 'This E-mail', 'هذا البريد الإلكتروني', 'Deze e-mail', 'Cet e-mail', 'Diese E-Mail', 'Questa email', 'Este email', 'Это письмо', 'Este correo electrónico', 'Bu e-posta'),
(687, '', NULL, 'is_not_registered.', 'is not registered.', 'غير مسجل.', 'is niet geregistreerd.', 'n\'est pas enregistré.', 'ist nicht registriert', 'non è registrato', 'não está registrado.', 'не зарегистрировано', 'no esta registrado', 'kayıtlı değil.'),
(688, '', NULL, 'password_reset.', 'password reset.', 'إعادة ضبط كلمة المرور.', 'wachtwoord reset.', 'réinitialiser le mot de passe.', 'Passwort zurücksetzen.', 'reimpostazione della password.', 'resetar a senha.', 'восстановление пароля.', 'restablecimiento de contraseña.', 'parola sıfırlama.'),
(689, '', NULL, 'reset_password_email_sent_successfully.', 'Reset password email sent successfully.', 'إعادة تعيين البريد الإلكتروني كلمة المرور المرسلة بنجاح.', 'Reset wachtwoord e-mail succesvol verzonden.', 'Réinitialiser l\'email de mot de passe envoyé avec succès.', 'Passwort-E-Mail erfolgreich zurücksetzen.', 'Reimposta l\'e-mail della password inviata correttamente.', 'Redefinir o email de senha enviado com sucesso.', 'Сброс пароля электронная почта успешно отправлена.', 'Restablecer correo electrónico de contraseña enviado con éxito.', 'Parola sıfırlama e-postası başarıyla gönderildi.'),
(690, '', NULL, 'server_can_t_send_email_to', 'Server can&#039;t send email to', 'لا يمكن للخادم إرسال بريد إلكتروني إلى', 'Server kan geen e-mail sturen naar', 'Le serveur ne peut pas envoyer d\'email à', 'Server kann keine E-Mail senden', 'Il server non può inviare email a', 'O servidor não pode enviar email para', 'Сервер не может отправить письмо на', 'El servidor no puede enviar correo electrónico a', 'Sunucu e-posta gönderemiyor'),
(691, '', NULL, 'right_now__please_try_again_later.', 'right now, please try again later.', 'في الوقت الحالي ، يرجى المحاولة مرة أخرى في وقت لاحق.', 'Probeer het later opnieuw.', 'maintenant, veuillez réessayer plus tard.', 'Bitte versuchen Sie es später erneut.', 'adesso, riprova più tardi.', 'agora, por favor, tente novamente mais tarde.', 'сейчас, пожалуйста, попробуйте позже.', 'En este momento, por favor intente de nuevo más tarde.', 'şu anda, lütfen daha sonra tekrar deneyin.'),
(692, '', NULL, 'missing_email_code.', 'Missing email code.', 'رمز البريد الإلكتروني مفقود.', 'Ontbrekende e-mailcode.', 'Code email manquant.', 'Fehlender E-Mail-Code', 'Codice email mancante.', 'Código de email ausente.', 'Отсутствует код электронной почты.', 'Falta el código de correo electrónico.', 'Eksik e-posta kodu.'),
(693, '', NULL, 'email_verified_successfully', 'Email verified successfully', 'تم التحقق من البريد الإلكتروني بنجاح', 'Email geverifieerd met succes', 'Email vérifié avec succès', 'E-Mail erfolgreich verifiziert', 'Email verificata con successo', 'E-mail verificado com sucesso', 'Электронная почта подтверждена успешно', 'Correo electrónico verificado correctamente', 'E-posta başarıyla doğrulandı'),
(694, '', NULL, 'wrong_email_verification_code.', 'Wrong email verification code.', 'رمز التحقق من البريد الإلكتروني غير صحيح.', 'Verkeerde e-mailverificatiecode.', 'Mauvais code de vérification de courrier électronique.', 'Falscher E-Mail-Bestätigungscode', 'Codice di verifica dell\'e-mail errato.', 'Código de verificação de e-mail incorreto.', 'Неправильный код подтверждения адреса электронной почты.', 'Código de verificación de correo electrónico incorrecto.', 'Yanlış e-posta doğrulama kodu.'),
(695, '', NULL, 'no_user_found_with_this_email_or_code.', 'No user found with this email or code.', 'لم يتم العثور على مستخدم بهذا البريد الإلكتروني أو الرمز.', 'Geen gebruiker gevonden met deze e-mail of code.', 'Aucun utilisateur trouvé avec cet email ou code.', 'Es wurde kein Benutzer mit dieser E-Mail oder diesem Code gefunden.', 'Nessun utente trovato con questa email o codice.', 'Nenhum usuário encontrado com este e-mail ou código.', 'Пользователь с этим адресом электронной почты или кодом не найден.', 'Ningún usuario encontrado con este correo electrónico o código.', 'Bu e-postada veya kodda hiçbir kullanıcı bulunamadı.'),
(696, '', NULL, 'you_are_not_allowed_to_open_this_page_directly.', 'You are not allowed to open this page directly.', 'غير مسموح لك بفتح هذه الصفحة مباشرة.', 'U mag deze pagina niet rechtstreeks openen.', 'Vous n\'êtes pas autorisé à ouvrir cette page directement.', 'Sie dürfen diese Seite nicht direkt öffnen.', 'Non sei autorizzato ad aprire questa pagina direttamente.', 'Você não tem permissão para abrir esta página diretamente.', 'Вы не можете открыть эту страницу напрямую.', 'No está permitido abrir esta página directamente.', 'Bu sayfayı doğrudan açamazsınız.'),
(697, '', NULL, 'this_email_code_is_invalid.', 'This Email code is invalid.', 'رمز البريد الإلكتروني هذا غير صالح.', 'Deze e-mailcode is ongeldig.', 'Ce code email est invalide.', 'Dieser E-Mail-Code ist ungültig.', 'Questo codice email non è valido.', 'Este código de email é inválido.', 'Этот код электронной почты недействителен.', 'Este código de correo electrónico no es válido.', 'Bu e-posta kodu geçersiz.'),
(698, '', NULL, 'empty_password.', 'Empty password.', 'كلمة المرور فارغة.', 'Leeg wachtwoord.', 'Mot de passe vide.', 'Leeres Passwort.', 'Password vuota', 'Senha vazia.', 'Пустой пароль', 'Contraseña vacía.', 'Boş şifre.'),
(699, '', NULL, 'password_reset_successfully', 'Password reset successfully', 'إعادة ضبط كلمة المرور بنجاح', 'Wachtwoord resetten succesvol', 'Mot de passe réinitialisé avec succès', 'Passwort erfolgreich zurückgesetzt', 'Password reimpostata correttamente', 'Senha redefinida com sucesso', 'Пароль успешно сброшен', 'Contraseña restablecida con éxito', 'Şifre başarıyla sıfırlandı'),
(700, '', NULL, 'error_while_login_with_new_password.', 'Error While login with new password.', 'خطأ أثناء تسجيل الدخول بكلمة مرور جديدة.', 'Fout tijdens inloggen met nieuw wachtwoord.', 'Erreur lors de la connexion avec un nouveau mot de passe.', 'Fehler beim Anmelden mit neuem Passwort.', 'Errore Durante il login con nuova password.', 'Erro ao entrar com nova senha.', 'Ошибка при входе с новым паролем.', 'Error al iniciar sesión con nueva contraseña.', 'Hata Yeni şifre ile giriş yaparken.'),
(701, '', NULL, 'error_while_save_new_password.', 'Error While save new password.', 'خطأ أثناء حفظ كلمة المرور الجديدة.', 'Fout bij opslaan nieuw wachtwoord.', 'Erreur lors de la sauvegarde du nouveau mot de passe.', 'Fehler Beim Speichern eines neuen Passworts.', 'Errore Mentre si salva la nuova password.', 'Erro Enquanto salvar nova senha.', 'Ошибка при сохранении нового пароля.', 'Error al guardar la nueva contraseña.', 'Hata Yeni şifreyi kaydederken.'),
(702, '', NULL, 'missing_phone_number.', 'Missing phone number.', 'رقم الهاتف مفقود.', 'Ontbrekend telefoonnummer.', 'Numéro de téléphone manquant.', 'Fehlende Telefonnummer', 'Numero di telefono mancante', 'Número de telefone ausente.', 'Отсутствует номер телефона.', 'Falta el número de teléfono.', 'Kayıp telefon numarası'),
(703, '', NULL, 'please_provide_international_number_with_your_area_code_starting_with__.', 'Please provide international number with your area code starting with +.', 'يرجى تقديم رقم دولي برمز منطقتك الذي يبدأ بـ +.', 'Geef het internationale nummer op met uw netnummer beginnend met +.', 'Veuillez fournir un numéro international avec votre indicatif régional commençant par +.', 'Bitte geben Sie Ihre internationale Vorwahlnummer mit + an.', 'Si prega di fornire il numero internazionale con il prefisso locale che inizia con +.', 'Por favor, forneça o número internacional com o seu código de área começando com +.', 'Пожалуйста, укажите международный номер с кодом города, начиная с +.', 'Por favor, proporcione el número internacional con su código de área que comienza con +.', 'Lütfen alan kodunuzu + ile başlayan uluslararası numarayı belirtin.'),
(704, '', NULL, 'please_enter_valid_number.', 'Please enter valid number.', 'يرجى إدخال رقم صحيح.', 'Voer een geldig nummer in.', 'S\'il vous plaît entrer un numéro valide.', 'Bitte geben Sie eine gültige Nummer ein.', 'Si prega di inserire un numero valido.', 'Por favor, insira um número válido.', 'Пожалуйста, введите правильный номер.', 'Por favor, introduzca un número válido.', 'Lütfen geçerli bir numara giriniz.'),
(705, '', NULL, 'invalid_phone_number_characters.', 'Invalid phone number characters.', 'أحرف رقم الهاتف غير صالحة.', 'Ongeldige telefoonnummers.', 'Caractères de numéro de téléphone non valides.', 'Ungültige Rufnummernzeichen', 'Caratteri del numero di telefono non valido.', 'Caracteres de números de telefone inválidos.', 'Неверный номер телефона символов.', 'Caracteres de número de teléfono no válidos.', 'Geçersiz telefon numarası karakterleri.');
INSERT INTO `langs` (`id`, `ref`, `options`, `lang_key`, `english`, `arabic`, `dutch`, `french`, `german`, `italian`, `portuguese`, `russian`, `spanish`, `turkish`) VALUES
(706, '', NULL, 'this_mobile_number_is_already_exist.', 'This Mobile number is Already exist.', 'رقم الجوال هذا موجود بالفعل.', 'Dit mobiele nummer bestaat al.', 'Ce numéro de téléphone portable existe déjà.', 'Diese Handynummer ist bereits vorhanden.', 'Questo numero di cellulare è già esistente.', 'Este número de celular já existe.', 'Этот номер мобильного телефона уже существует.', 'Este número de móvil ya existe.', 'Bu cep telefonu numarası zaten var.'),
(707, '', NULL, 'mobile_activation_code.', 'Mobile Activation code.', 'رمز التنشيط المحمول.', 'Mobiele activeringscode.', 'Code d\'activation mobile.', 'Mobiler Aktivierungscode.', 'Codice di attivazione mobile.', 'Código de Ativação Móvel.', 'Мобильный код активации.', 'Código de activación móvil.', 'Mobil Aktivasyon kodu.'),
(708, '', NULL, 'verification_sms_sent_successfully.', 'Verification sms sent successfully.', 'تم إرسال رسالة التحقق بنجاح.', 'Verificatie sms succesvol verzonden.', 'Vérification SMS envoyé avec succès.', 'Überprüfungs-SMS erfolgreich gesendet.', 'SMS di verifica inviati con successo.', 'Sms de verificação enviados com sucesso.', 'Подтверждение смс отправлено успешно.', 'Verificación de sms enviados con éxito.', 'Doğrulama sms başarıyla gönderildi.'),
(709, '', NULL, 'can_t_send_verification_sms__please_try_again_later.', 'Can&#039;t send verification sms, please try again later.', 'لا يمكن إرسال رسالة تحقق ، يرجى المحاولة مرة أخرى في وقت لاحق.', 'Kan verificatie-sms niet verzenden. Probeer het later opnieuw.', 'Impossible d\'envoyer un SMS de vérification, veuillez réessayer ultérieurement.', 'Es können keine Bestätigungs-SMS gesendet werden. Bitte versuchen Sie es später erneut.', 'Impossibile inviare sms di verifica, riprova più tardi.', 'Não é possível enviar sms de verificação. Tente novamente mais tarde.', 'Не удалось отправить смс, пожалуйста, попробуйте позже.', 'No se puede enviar sms de verificación, por favor intente nuevamente más tarde', 'Doğrulama smsleri gönderilemiyor, lütfen daha sonra tekrar deneyin.'),
(710, '', NULL, 'missing_email.', 'Missing email.', 'بريد إلكتروني مفقود.', 'Ontbrekende e-mail.', 'Email manquant.', 'Fehlende E-Mail', 'Email mancante', 'E-mail ausente.', 'Отсутствует электронная почта.', 'Falta el correo electrónico.', 'Eksik e-posta.'),
(711, '', NULL, 'thank_you_for_your_registration.', 'Thank you for your registration.', 'نشكرك على التسجيل.', 'Bedankt voor uw registratie.', 'Merci pour votre inscription.', 'Danke für ihre Registrierung.', 'Grazie per la tua registrazione.', 'Obrigado por sua inscrição.', 'Спасибо за вашу регистрацию.', 'Gracias por su registro.', 'kaydınız için teşekkür ederiz.'),
(712, '', NULL, 'can_t_send_verification_email__please_try_again_later.', 'Can&#039;t send verification email, please try again later.', 'لا يمكن إرسال رسالة تحقق ، يرجى المحاولة مرة أخرى في وقت لاحق.', 'Ik kan geen verificatie-e-mail verzenden. Probeer het later opnieuw.', 'Impossible d\'envoyer un e-mail de vérification, veuillez réessayer ultérieurement.', 'Es kann keine Bestätigungs-E-Mail gesendet werden. Bitte versuchen Sie es später erneut.', 'Impossibile inviare email di verifica, riprova più tardi.', 'Não é possível enviar o e-mail de verificação. Tente novamente mais tarde.', 'Не удалось отправить письмо с подтверждением, повторите попытку позже.', 'No se puede enviar el correo electrónico de verificación, inténtalo de nuevo más tarde.', 'Doğrulama e-postası gönderilemiyor, lütfen daha sonra tekrar deneyin.'),
(713, '', NULL, 'you_can_not_like_your_self.', 'You can not like your self.', 'لا يمكنك أن تحب نفسك.', 'Je kunt jezelf niet goed vinden.', 'Vous ne pouvez pas vous aimer.', 'Sie können sich nicht mögen.', 'Non puoi come te.', 'Você não pode gostar de si mesmo.', 'Вы не можете любить себя.', 'No puedes gustarte a ti mismo.', 'Kendini beğenemezsin.'),
(714, '', NULL, 'you_can_not_perform_this_action.', 'You can not perform this action.', 'لا يمكنك تنفيذ هذا الإجراء.', 'U kunt deze actie niet uitvoeren.', 'Vous ne pouvez pas effectuer cette action.', 'Sie können diese Aktion nicht ausführen.', 'Non puoi eseguire questa azione.', 'Você não pode executar esta ação.', 'Вы не можете выполнить это действие.', 'No se puede realizar esta acción.', 'Bu işlemi gerçekleştiremezsiniz.'),
(715, '', NULL, 'error_while_deleting_dislike.', 'Error while deleting dislike.', 'خطأ أثناء حذف الكراهية.', 'Fout tijdens het verwijderen van afkeer.', 'Erreur lors de la suppression de l\'aversion.', 'Fehler beim Löschen der Abneigung.', 'Errore durante l\'eliminazione di antipatia.', 'Erro ao excluir antipatia.', 'Ошибка при удалении нелюбовь.', 'Error al eliminar el disgusto.', 'Beğenme silinirken hata oluştu.'),
(716, '', NULL, 'user_has_been_blocked_successfully.', 'User has been blocked successfully.', 'تم حظر المستخدم بنجاح.', 'Gebruiker is succesvol geblokkeerd.', 'L\'utilisateur a été bloqué avec succès.', 'Benutzer wurde erfolgreich gesperrt.', 'L\'utente è stato bloccato con successo.', 'Usuário foi bloqueado com sucesso.', 'Пользователь был успешно заблокирован.', 'El usuario ha sido bloqueado con éxito.', 'Kullanıcı başarıyla engellendi.'),
(717, '', NULL, 'error_while_save_block.', 'Error while save block.', 'خطأ أثناء حفظ الكتلة.', 'Fout tijdens opslaan blokkeren.', 'Erreur lors de la sauvegarde du bloc.', 'Fehler beim Speichern des Blocks.', 'Errore durante il salvataggio del blocco.', 'Erro ao salvar bloco.', 'Ошибка при сохранении блока.', 'Error al guardar el bloque.', 'Bloğu kaydetme hatası.'),
(718, '', NULL, 'user_has_been_unblocked_successfully.', 'User has been unblocked successfully.', 'تم إلغاء حظر المستخدم بنجاح.', 'Gebruiker is succesvol gedeblokkeerd.', 'L\'utilisateur a été débloqué avec succès.', 'Der Benutzer wurde erfolgreich entsperrt.', 'L\'utente è stato sbloccato correttamente.', 'Usuário foi desbloqueado com sucesso.', 'Пользователь успешно разблокирован.', 'El usuario ha sido desbloqueado con éxito.', 'Kullanıcının engeli başarıyla kaldırıldı.'),
(719, '', NULL, 'error_while_delete_user_block.', 'Error while delete user block.', 'خطأ أثناء حذف كتلة المستخدم.', 'Fout tijdens verwijderen gebruikersblok.', 'Erreur lors de la suppression du bloc utilisateur.', 'Fehler beim Löschen des Benutzers.', 'Errore durante l\'eliminazione del blocco utente.', 'Erro ao excluir o bloqueio do usuário.', 'Ошибка при удалении пользовательского блока.', 'Error al eliminar el bloqueo de usuario.', 'Kullanıcı bloğu silinirken hata oluştu.'),
(720, '', NULL, 'error_while_save_report.', 'Error while save report.', 'خطأ أثناء حفظ التقرير.', 'Fout tijdens opslaan rapport.', 'Erreur lors de la sauvegarde du rapport.', 'Fehler beim Speichern des Berichts', 'Errore durante il salvataggio del report.', 'Erro ao salvar o relatório.', 'Ошибка при сохранении отчета.', 'Error al guardar el informe.', 'Rapor kaydedilirken hata oluştu.'),
(721, '', NULL, 'user_has_been_unreported_successfully.', 'User has been unreported successfully.', 'لم يتم الإبلاغ عن المستخدم بنجاح.', 'Gebruiker is niet succesvol gerapporteerd.', 'L\'utilisateur n\'a pas été signalé avec succès.', 'Der Benutzer wurde nicht erfolgreich gemeldet.', 'L\'utente non è stato segnalato correttamente.', 'O usuário não foi reportado com sucesso.', 'Пользователь не был успешно зарегистрирован.', 'Usuario no ha sido reportado con éxito.', 'Kullanıcı başarıyla bildirilmedi.'),
(722, '', NULL, 'error_while_delete_user_report.', 'Error while delete user report.', 'خطأ أثناء حذف تقرير المستخدم.', 'Fout bij verwijderen gebruikersrapport.', 'Erreur lors de la suppression du rapport utilisateur.', 'Fehler beim Löschen des Benutzerberichts.', 'Errore durante l\'eliminazione del report utente.', 'Erro ao excluir o relatório do usuário.', 'Ошибка при удалении пользовательского отчета.', 'Error al eliminar el informe de usuario.', 'Kullanıcı raporu silinirken hata oluştu.'),
(723, '', NULL, 'email_verification.', 'Email Verification.', 'تأكيد بواسطة البريد الالكتروني.', 'Email verificatie.', 'Vérification de l\'E-mail.', 'E-Mail-Verifizierung.', 'Verifica email.', 'Verificação de e-mail.', 'Подтверждение адреса электронной почты.', 'Verificacion de email.', 'Eposta Doğrulama.'),
(724, '', NULL, 'verification_email_sent_successfully.', 'Verification email sent successfully.', 'تم إرسال رسالة التحقق بنجاح.', 'Verificatie e-mail succesvol verzonden.', 'Email de vérification envoyé avec succès.', 'Bestätigungs-E-Mail wurde erfolgreich gesendet.', 'Email di verifica inviata con successo.', 'E-mail de verificação enviado com sucesso.', 'Письмо с подтверждением успешно отправлено.', 'Correo electrónico de verificación enviado con éxito.', 'Doğrulama e-postası başarıyla gönderildi.'),
(725, '', NULL, 'error_while_update_email_activation.', 'Error while update email activation.', 'خطأ أثناء تنشيط البريد الإلكتروني التحديث.', 'Fout bij het bijwerken van de e-mailactivering.', 'Erreur lors de la mise à jour de l\'activation du courrier électronique.', 'Fehler beim Update der E-Mail-Aktivierung.', 'Errore durante l\'attivazione dell\'email di aggiornamento.', 'Erro durante a ativação do email de atualização.', 'Ошибка при обновлении электронной почты активации.', 'Error al actualizar la activación del correo electrónico.', 'E-posta aktivasyonu güncellenirken hata oluştu.'),
(726, '', NULL, 'missing_sms_code.', 'Missing sms code.', 'رمز الرسائل القصيرة مفقود.', 'Ontbrekende sms-code.', 'Code SMS manquant.', 'Fehlender SMS-Code.', 'Codice sms mancante', 'Falta de código sms.', 'Отсутствует смс код.', 'Falta el código sms.', 'Kayıp sms kodu.'),
(727, '', NULL, 'phone_verified_successfully', 'Phone verified successfully', 'تم التحقق من الهاتف بنجاح', 'Telefoon geverifieerd', 'Téléphone vérifié avec succès', 'Telefon erfolgreich verifiziert', 'Telefono verificato correttamente', 'Telefone confirmado com sucesso', 'Телефон успешно подтвержден', 'Teléfono verificado correctamente', 'Telefon başarıyla doğrulandı'),
(728, '', NULL, 'error_while_update_phone_activation.', 'Error while update phone activation.', 'حدث خطأ أثناء تحديث تنشيط الهاتف.', 'Fout bij activering van activeringscode.', 'Erreur lors de l\'activation du téléphone.', 'Fehler beim Aktualisieren der Telefonaktivierung.', 'Errore durante l\'aggiornamento dell\'attivazione del telefono.', 'Erro durante a ativação do telefone de atualização.', 'Ошибка при обновлении телефона при активации.', 'Error al actualizar la activación del teléfono.', 'Telefon aktivasyonu güncellenirken hata oluştu.'),
(729, '', NULL, 'wrong_phone_verification_code.', 'Wrong phone verification code.', 'رمز التحقق عبر الهاتف غير صحيح.', 'Verkeerde telefoonverificatiecode.', 'Mauvais code de vérification téléphonique.', 'Falscher Telefon-Bestätigungscode', 'Codice di verifica del telefono errato.', 'Código de verificação errado do telefone.', 'Неправильный код подтверждения телефона.', 'Código de verificación del teléfono equivocado.', 'Yanlış telefon doğrulama kodu.'),
(730, '', NULL, 'no_user_found_with_this_phone_number_or_code.', 'No user found with this phone number or code.', 'لم يتم العثور على مستخدم بهذا رقم الهاتف أو الرمز.', 'Geen gebruiker gevonden met dit telefoonnummer of code.', 'Aucun utilisateur trouvé avec ce numéro de téléphone ou code.', 'Es wurde kein Benutzer mit dieser Telefonnummer oder diesem Code gefunden.', 'Nessun utente trovato con questo numero di telefono o codice.', 'Nenhum usuário encontrado com este número de telefone ou código.', 'Пользователь с таким номером телефона или кодом не найден.', 'Ningún usuario encontrado con este número de teléfono o código.', 'Bu telefon numarası veya kodla hiçbir kullanıcı bulunamadı.'),
(731, '', NULL, 'user_boosted_successfully.', 'User boosted successfully.', 'عزز المستخدم بنجاح.', 'Gebruiker succesvol gesteund.', 'Utilisateur boosté avec succès.', 'Benutzer wurde erfolgreich gebohrt.', 'Utente potenziato con successo.', 'Usuário reforçado com sucesso.', 'Пользователь успешно увеличен.', 'Usuario impulsado con éxito.', 'Kullanıcı başarıyla yükseltildi.'),
(732, '', NULL, 'error_while_boost_user.', 'Error while boost user.', 'خطأ أثناء زيادة المستخدم.', 'Fout bij het verhogen van de gebruiker.', 'Erreur lors de l\'augmentation de l\'utilisateur.', 'Fehler beim Boost-Benutzer.', 'Errore durante il boost dell\'utente.', 'Erro ao impulsionar o usuário.', 'Ошибка при повышении пользователя.', 'Error al aumentar el usuario.', 'Kullanıcı artırılırken hata oluştu.'),
(733, '', NULL, 'user_unmatched_successfully.', 'User unmatched successfully.', 'المستخدم غير متطابق بنجاح.', 'Gebruiker is succesvol geëvenaard.', 'Utilisateur sans correspondance.', 'Der Benutzer wurde nicht gefunden.', 'Utente non abbinato correttamente.', 'Usuário incomparável com sucesso.', 'Пользователь не имеет аналогов.', 'Usuario sin emparejar con éxito.', 'Kullanıcı başarıyla eşleşmedi.'),
(734, '', NULL, 'method_not_allowed', 'Method Not Allowed', 'الطريقة غير مسموحة', 'methode niet toegestaan', 'Méthode Non Autorisée', 'Methode nicht erlaubt', 'operazione non permessa', 'Método não permitido', 'метод не разрешен', 'Método no permitido', 'izin verilmeyen yöntem'),
(735, '', NULL, 'this_call_from_test_function', 'this call from test function', 'هذه المكالمة من وظيفة الاختبار', 'deze oproep van testfunctie', 'cet appel de la fonction de test', 'dieser Aufruf von der Testfunktion', 'questa chiamata dalla funzione di test', 'esta chamada da função de teste', 'этот вызов из тестовой функции', 'esta llamada de la función de prueba', 'Test işlevinden bu çağrı'),
(736, '', NULL, 'credit', 'Credit', 'ائتمان', 'Credit', 'Crédit', 'Kredit', 'Credito', 'Crédito', 'кредит', 'Crédito', 'Kredi'),
(737, '', NULL, 'forgot_password', 'Forgot password', 'هل نسيت كلمة المرور', 'Wachtwoord vergeten', 'Mot de passe oublié', 'Passwort vergessen', 'Ha dimenticato la password', 'Esqueceu a senha', 'Забыли пароль', 'Se te olvidó tu contraseña', 'Parolanızı mı unuttunuz'),
(738, '', NULL, 'home', 'Home', 'الصفحة الرئيسية', 'Huis', 'Accueil', 'Zuhause', 'Casa', 'Casa', 'Главная', 'Casa', 'Ev'),
(739, '', NULL, 'interest', 'Interest', 'فائدة', 'Interesseren', 'Intérêt', 'Interesse', 'Interesse', 'Interesse', 'Интерес', 'Interesar', 'Faiz'),
(740, '', NULL, 'people_liked_me', 'People liked me', 'اعجبني الناس', 'Mensen vonden me leuk', 'Les gens m\'ont aimé', 'Die Leute mochten mich', 'Alla gente piacevo', 'Pessoas gostavam de mim', 'Люди мне понравились', 'La gente me gusto', 'İnsanlar benden hoşlandı'),
(741, '', NULL, 'email_code_verification', 'Email code verification', 'التحقق من كود البريد الالكتروني', 'Verificatie van e-mailcode', 'Vérification du code email', 'E-Mail-Code-Bestätigung', 'Verifica del codice email', 'Verificação do código de email', 'Проверка кода электронной почты', 'Verificación de código de correo electrónico', 'E-posta kodu doğrulama'),
(742, '', NULL, 'premium_membership', 'Premium Membership', 'عضوية متميزة', 'Premium lidmaatschap', 'Abonnement Premium', 'Premium Mitgliedschaft', 'Abbonamento premium', 'Assinatura especial', 'Премиум членство', 'Membresia premium', 'Premium Üyelik'),
(743, '', NULL, 'premium_membership_success', 'Premium Membership Success', 'عضوية قسط النجاح', 'Premium lidmaatschapssucces', 'Succès d\'adhésion Premium', 'Premium-Mitgliedschaft Erfolg', 'Successo dell\'appartenenza Premium', 'Sucesso Premium da Associação', 'Премиум членство', 'Exito de Membresia Premium', 'Premium Üyelik Başarısı'),
(744, '', NULL, 'reset_password', 'Reset Password', 'إعادة ضبط كلمة المرور', 'Reset wachtwoord', 'réinitialiser le mot de passe', 'Passwort zurücksetzen', 'Resetta la password', 'Redefinir Senha', 'Сброс пароля', 'Restablecer la contraseña', 'Şifreyi yenile'),
(745, '', NULL, 'general_settings', 'General Settings', 'الاعدادات العامة', 'Algemene instellingen', 'réglages généraux', 'Allgemeine Einstellungen', 'impostazioni generali', 'Configurações Gerais', 'общие настройки', 'Configuración general', 'Genel Ayarlar'),
(746, '', NULL, 'profile_settings_blocked', 'Profile Settings Blocked', 'تم حظر إعدادات الملف الشخصي', 'Profielinstellingen geblokkeerd', 'Paramètres de profil bloqués', 'Profileinstellungen blockiert', 'Impostazioni profilo bloccate', 'Configurações de perfil bloqueadas', 'Настройки профиля заблокированы', 'Configuraciones de perfil bloqueadas', 'Profil Ayarları Engellendi'),
(747, '', NULL, 'delete_profile', 'Delete Profile', 'حذف الملف الشخصي', 'Verwijder profiel', 'Supprimer le profil', 'Profil löschen', 'Elimina profilo', 'Excluir perfil', 'Удалить профиль', 'Borrar perfil', 'Profili sil'),
(748, '', NULL, 'profile_email_settings', 'Profile Email Settings', 'إعدادات البريد الإلكتروني للملف الشخصي', 'Profiel e-mailinstellingen', 'Paramètres de messagerie de profil', 'Profil-E-Mail-Einstellungen', 'Impostazioni email del profilo', 'Configurações de email do perfil', 'Настройки Email профиля', 'Configuración de perfil de correo electrónico', 'Profil E-posta Ayarları'),
(749, '', NULL, 'account_password_settings', 'Account Password Settings', 'إعدادات كلمة مرور الحساب', 'Account wachtwoord instellingen', 'Paramètres du mot de passe du compte', 'Kontokennworteinstellungen', 'Impostazioni della password dell\'account', 'Configurações de senha da conta', 'Настройки пароля учетной записи', 'Configuración de contraseña de cuenta', 'Hesap Şifresi Ayarları'),
(750, '', NULL, 'privacy_setting', 'Privacy Setting', 'إعدادات الخصوصية', 'Privacy-instelling', 'Paramètre de confidentialité', 'Privatsphäreeinstellung', 'Impostazioni sulla privacy', 'Configuração de privacidade', 'Настройки конфиденциальности', 'Configuración de privacidad', 'Gizlilik ayarı'),
(751, '', NULL, 'profile_setting', 'Profile Setting', 'إعداد الملف الشخصي', 'Profiel instelling', 'Paramétrage du profil', 'Profileinstellung', 'Impostazione del profilo', 'Configuração de perfil', 'Настройка профиля', 'Ajustes de perfil', 'Profil ayarı'),
(752, '', NULL, 'social_setting', 'Social Setting', 'الوضع الاجتماعي', 'Sociale situatie', 'Cadre social', 'Soziales Umfeld', 'Impostazione sociale', 'Cenário Social', 'Социальная обстановка', 'Entorno social', 'Sosyal ortam'),
(753, '', NULL, 'profile_steps', 'Profile steps', 'خطوات الملف الشخصي', 'Profielstappen', 'Étapes du profil', 'Profilschritte', 'Passaggi del profilo', 'Etapas do perfil', 'Шаги профиля', 'Pasos de perfil', 'Profil adımları'),
(754, '', NULL, 'verify_your_account', 'Verify your account', 'تحقق من حسابك', 'Verifieer uw account', 'Vérifiez votre compte', 'Überprüfen Sie Ihr Konto', 'Verifica il tuo account', 'Verifique sua conta', 'подтвердите ваш аккаунт', 'Verifica tu cuenta', 'Hesabınızı doğrulayın'),
(755, '', NULL, 'verify_e-mail_address', 'Verify E-Mail address', 'التحقق من عنوان البريد الإلكتروني', 'Bevestig e-mail adres', 'Vérifier l\'adresse e-mail', 'Email Adresse bestätigen', 'Verifica indirizzo e-mail', 'Verificar endereço de e-mail', 'Подтвердите адрес электронной почты', 'Confirme su dirección de correo electrónico', 'E-posta Adresini doğrulayın'),
(756, '', NULL, 'verify_phone', 'Verify Phone', 'تحقق من الهاتف', 'Verifieer telefoon', 'Vérifier le téléphone', 'Telefon überprüfen', 'Verifica telefono', 'Verificar telefone', 'Проверить телефон', 'Verificar telefono', 'Telefonu Doğrula'),
(757, '', NULL, 'sms_code_verification', 'SMS code verification', 'التحقق من رمز الرسائل القصيرة', 'Verificatie van sms-codes', 'Vérification du code SMS', 'SMS-Code-Bestätigung', 'Verifica del codice SMS', 'Verificação de código SMS', 'Проверка кода СМС', 'Verificación de código SMS', 'SMS kodu doğrulama'),
(758, '', NULL, 'id_cannot_be_empty__or_character._only_numbers_allowed__or_you_have_call_undefined_method', 'ID cannot be empty, or character. only numbers allowed, or you have call undefined method', 'لا يمكن أن يكون المعرف فارغًا أو حرفًا. الأرقام المسموح بها فقط ، أو لديك استدعاء طريقة غير معرفة', 'ID mag niet leeg zijn, of karakter. alleen toegestane aantallen, of u hebt aanroep ongedefinieerde methode', 'ID ne peut pas être vide ou caractère. seuls les nombres sont autorisés ou vous avez appelé une méthode indéfinie', 'ID darf nicht leer oder Zeichen sein. Es sind nur Zahlen zulässig, oder Sie haben eine undefinierte Methode aufgerufen', 'L\'ID non può essere vuoto o carattere. sono consentiti solo numeri o è necessario chiamare un metodo non definito', 'O ID não pode estar vazio ou caractere. somente números permitidos, ou você tem o método de chamada indefinida', 'Идентификатор не может быть пустым или символом. разрешены только номера, или у вас есть вызов неопределенного метода', 'La identificación no puede estar vacía, o el carácter. Solo se permiten números, o tienes llamada método indefinido', 'Kimlik boş veya karakter olamaz. yalnızca numaralara izin verilir veya tanımsız yöntemi'),
(759, '', NULL, 'bad_request__invalid_or_missing_parameter', 'Bad Request, Invalid or missing parameter', 'طلب سيئ ، معلمة غير صالحة أو مفقودة', 'Slecht verzoek, ongeldige of ontbrekende parameter', 'Requête incorrecte, paramètre invalide ou manquant', 'Ungültige oder fehlende Parameter', 'Richiesta non valida, parametro non valido o mancante', 'Solicitação incorreta, parâmetro inválido ou ausente', 'Неверный запрос, неверный или отсутствующий параметр', 'Solicitud errónea, parámetro inválido o faltante', 'Hatalı İstek, Geçersiz veya eksik parametre'),
(760, '', NULL, 'user_in_black_list', 'User in black list', 'المستخدم في القائمة السوداء', 'Gebruiker in zwarte lijst', 'Utilisateur en liste noire', 'Benutzer in der schwarzen Liste', 'Utente nella lista nera', 'Usuário na lista negra', 'Пользователь в черном списке', 'Usuario en lista negra', 'Kara listede kullanıcı'),
(761, '', NULL, 'message_sent_successfully.', 'Message sent successfully.', 'تم ارسال الرسالة بنجاح.', 'Bericht succesvol verzonden.', 'Message envoyé avec succès.', 'Nachricht erfolgreich gesendet.', 'Messaggio inviato con successo.', 'Mensagem enviada com sucesso.', 'Сообщение успешно отправлено.', 'Mensaje enviado con éxito.', 'Mesaj başarıyla gönderildi.'),
(762, '', NULL, 'operation_successfully.', 'Operation successfully.', 'العملية بنجاح.', 'Operatie succesvol.', 'Opération réussie.', 'Operation erfolgreich', 'Operazione con successo.', 'Operação com sucesso.', 'Операция прошла успешно.', 'Operación exitosa.', 'Operasyon başarıyla.'),
(763, '', NULL, 'options_loaded_successfully.', 'Options loaded successfully.', 'خيارات تم تحميلها بنجاح.', 'Opties zijn succesvol geladen.', 'Options chargées avec succès.', 'Optionen erfolgreich geladen', 'Opzioni caricate correttamente.', 'Opções carregadas com sucesso.', 'Параметры успешно загружены.', 'Opciones cargadas con éxito.', 'Seçenekler başarıyla yüklendi.'),
(764, '', NULL, 'user_name_cannot_be_empty', 'User name cannot be empty', 'اسم المستخدم لا يمكن أن يكون فارغا', 'Gebruikersnaam mag niet leeg zijn', 'Le nom d\'utilisateur ne peut pas être vide', 'Der Benutzername darf nicht leer sein', 'Il nome utente non può essere vuoto', 'O nome do usuário não pode estar vazio', 'Имя пользователя не может быть пустым', 'El nombre de usuario no puede estar vacío', 'Kullanıcı adı boş olamaz'),
(765, '', NULL, 'password_cannot_be_empty', 'Password cannot be empty', 'لا يمكن أن تكون كلمة المرور فارغة', 'Wachtwoord mag niet leeg zijn', 'Le mot de passe ne peut pas être vide', 'Passwort kann nicht leer sein', 'La password non può essere vuota', 'A senha não pode estar vazia', 'Пароль не может быть пустым', 'La contraseña no puede estar vacía', 'Şifre boş olamaz'),
(766, '', NULL, 'login_successfully__please_wait..', 'Login successfully, Please wait..', 'تسجيل الدخول بنجاح ، يرجى الانتظار ..', 'Inloggen succesvol, even geduld aub ..', 'Connectez-vous avec succès, veuillez patienter ..', 'Login erfolgreich, bitte warten ..', 'Accedi con successo, per favore aspetta ..', 'Login com sucesso, por favor aguarde ..', 'Авторизуйтесь успешно, пожалуйста, подождите ..', 'Inicie sesión correctamente, por favor espere ..', 'Giriş başarıyla yapıldı, lütfen bekleyiniz ..'),
(767, '', NULL, 'could_not_save_session', 'Could not save session', 'لا يمكن حفظ الجلسة', 'Kon de sessie niet opslaan', 'Impossible de sauvegarder la session', 'Sitzung konnte nicht gespeichert werden', 'Impossibile salvare la sessione', 'Não foi possível salvar a sessão', 'Не удалось сохранить сеанс', 'No se pudo guardar la sesión', 'Oturum kaydedilemedi'),
(768, '', NULL, 'user_not_exist', 'User Not Exist', 'المستخدم غير متوفر', 'Gebruiker bestaat niet', 'Utilisateur non existant', 'Benutzer nicht vorhanden', 'L `utente non esiste', 'Usuário não existe', 'Пользователь не существует', 'No existe ese usuario', 'Kullanıcı Yok'),
(769, '', NULL, 'wrong_password', 'Wrong password', 'كلمة مرور خاطئة', 'Verkeerd wachtwoord', 'Mauvais mot de passe', 'Falsches Passwort', 'Password errata', 'Senha incorreta', 'Неправильный пароль', 'Contraseña incorrecta', 'Yanlış şifre'),
(770, '', NULL, 'user_data_unset', 'User data unset', 'بيانات المستخدم غير محددة', 'Gebruikersgegevens worden uitgeschakeld', 'Données utilisateur non définies', 'Benutzerdaten werden nicht gesetzt', 'Dati utente non impostati', 'Dados do usuário não definidos', 'Пользовательские данные сброшены', 'Datos de usuario no configurados', 'Kullanıcı verileri ayarlanmamış'),
(771, '', NULL, 'username_must_be_between_5_32', 'Username must be between 5/32', 'يجب أن يكون اسم المستخدم بين 5/32', 'Gebruikersnaam moet tussen 5/32 zijn', 'Le nom d\'utilisateur doit être compris entre 5/32', 'Der Benutzername muss zwischen 5/32 liegen', 'Il nome utente deve essere compreso tra 5/32', 'O nome de usuário deve estar entre 5 e 32', 'Имя пользователя должно быть между 5/32', 'El nombre de usuario debe estar entre 5/32', 'Kullanıcı adı 5/32 arasında olmalıdır'),
(772, '', NULL, 'invalid_username_characters', 'Invalid username characters', 'أحرف اسم المستخدم غير صالحة', 'Ongeldige gebruikersnaamtekens', 'Nom d\'utilisateur invalide', 'Ungültige Zeichen für den Benutzernamen', 'Caratteri del nome utente non validi', 'Caracteres de nome de usuário inválidos', 'Неверные символы имени пользователя', 'Caracteres de usuario inválidos', 'Geçersiz kullanıcı adı karakterleri'),
(773, '', NULL, 'user_name_exists', 'User Name Exists', 'اسم المستخدم موجود', 'Gebruikersnaam bestaat', 'Le nom d\'utilisateur existe', 'Benutzername existiert', 'Nome utente esistente', 'Nome de usuário existente', 'Имя пользователя существует', 'El nombre de usuario existe', 'Kullanıcı Adı Var'),
(774, '', NULL, 'email_cannot_be_empty', 'Email cannot be empty', 'لا يمكن أن يكون البريد الإلكتروني فارغًا', 'E-mail mag niet leeg zijn', 'L\'email ne peut pas être vide', 'E-Mail darf nicht leer sein', 'L\'email non può essere vuota', 'E-mail não pode estar vazio', 'Email не может быть пустым', 'El correo electrónico no puede estar vacío', 'E-posta boş olamaz'),
(775, '', NULL, 'email_already_exists', 'Email Already Exists', 'البريد الالكتروني موجود بالفعل', 'Email bestaat al', 'L\'email existe déjà', 'E-Mail existiert bereits', 'Email già esistente', 'E-mail já existe', 'Адрес электронной почты уже существует', 'El Email ya existe', 'Bu e-posta zaten var'),
(776, '', NULL, 'registration_failed', 'Registration Failed', 'فشل في التسجيل', 'Registratie mislukt', 'Échec de l\'enregistrement', 'Registrierung fehlgeschlagen', 'Registrazione fallita', 'Registração falhou', 'Регистрация не удалась', 'Registro fallido', 'Kayıt başarısız'),
(777, '', NULL, 'successfully_joined.', 'Successfully joined.', 'انضم بنجاح.', 'Succesvol toegetreden.', 'Rejoint avec succès.', 'Erfolgreich beigetreten', 'Riunito con successo.', 'Entrou com sucesso.', 'Успешно присоединился.', 'Se unió con éxito.', 'Başarıyla katıldı.'),
(778, '', NULL, 'could_not_send_verification_email', 'Could not send verification email', 'لا يمكن إرسال رسالة تحقق', 'Kon verificatie-e-mail niet verzenden', 'Impossible d\'envoyer le courrier électronique de vérification', 'Es konnte keine Bestätigungs-E-Mail gesendet werden', 'Impossibile inviare email di verifica', 'Não foi possível enviar o e-mail de verificação', 'Не удалось отправить подтверждение по электронной почте', 'No se pudo enviar el correo electrónico de verificación.', 'Doğrulama e-postası gönderilemedi'),
(779, '', NULL, 'successfully_joined__please_wait..', 'Successfully joined, Please wait..', 'انضم بنجاح ، يرجى الانتظار ..', 'Met succes toegetreden, Even geduld aub ..', 'Avec succès rejoint, S\'il vous plaît patienter ..', 'Erfolgreich beigetreten, bitte warten ..', 'Si è unito con successo, per favore aspetta ..', 'Com sucesso, por favor, aguarde ..', 'Успешно присоединился, пожалуйста, подождите ..', 'Se ha unido con éxito, por favor espere ..', 'Başarıyla katıldı, Lütfen bekleyin ..'),
(780, '', NULL, 'error__an_unknown_error_occurred._please_try_again_later', 'Error: an unknown error occurred. Please try again later', 'خطأ: حدث خطأ غير معروف. الرجاء معاودة المحاولة في وقت لاحق', 'Fout: er is een onbekende fout opgetreden. Probeer het later opnieuw', 'Erreur: une erreur inconnue s\'est produite. Veuillez réessayer plus tard', 'Fehler: ein unbekannter Fehler ist aufgetreten. Bitte versuchen Sie es später erneut', 'Errore: si è verificato un errore sconosciuto. Per favore riprova più tardi', 'Erro: ocorreu um erro desconhecido. Por favor, tente novamente mais tarde', 'Ошибка: произошла неизвестная ошибка. Пожалуйста, попробуйте позже', 'Error: se ha producido un error desconocido. Por favor, inténtelo de nuevo más tarde', 'Hata: bilinmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz'),
(781, '', NULL, 'registration_success', 'Registration Success', 'نجاح التسجيل', 'Registratie succes', 'Succès d\'inscription', 'Registrierung erfolgreich', 'Registrazione avvenuta', 'Sucesso no registro', 'Вы успешно зарегистрировались', 'Registración exitosa', 'Başarılı Kayıt'),
(782, '', NULL, 'error_400_-_session_does_not_exist', 'Error 400 - Session does not exist', 'خطأ 400 - الجلسة غير موجودة', 'Fout 400 - Sessie bestaat niet', 'Erreur 400 - La session n\'existe pas', 'Fehler 400 - Sitzung ist nicht vorhanden', 'Errore 400 - La sessione non esiste', 'Erro 400 - a sessão não existe', 'Ошибка 400 - сеанс не существует', 'Error 400 - La sesión no existe', 'Hata 400 - Oturum mevcut değil'),
(783, '', NULL, 'successfully_logged_out', 'Successfully logged out', 'تم تسجيل الخروج بنجاح', 'Succesvol afgemeld', 'Déconnecté avec succès', 'Erfolgreich abgemeldet', 'Disconnesso con successo', 'Logout com sucesso', 'Успешно вышел', 'Se desconectó con éxito', 'Başarıyla çıkış yapıldı'),
(784, '', NULL, 'no_user_email__sent', 'No user email  sent', 'لم يتم إرسال بريد إلكتروني للمستخدم', 'Geen e-mail van gebruiker verzonden', 'Aucun email d\'utilisateur envoyé', 'Keine Benutzer-E-Mail gesendet', 'Nessuna email utente inviata', 'Nenhum email de usuário enviado', 'Не отправлено ни одного письма от пользователя', 'No hay correo electrónico de usuario enviado', 'Kullanıcı e-postası gönderilmedi'),
(785, '', NULL, 'e-mail_is_not_exists', 'E-mail is not exists', 'البريد الإلكتروني غير موجود', 'E-mail bestaat niet', 'E-mail n\'est pas existe', 'E-Mail existiert nicht', 'L\'e-mail non esiste', 'E-mail não existe', 'Электронная почта не существует', 'El correo electrónico no existe', 'E-posta mevcut değil'),
(786, '', NULL, 'a_reset_password_link_has_been_sent_to_your_e-mail_address', 'A reset password link has been sent to your e-mail address', 'تم إرسال رابط إعادة تعيين كلمة المرور إلى عنوان البريد الإلكتروني الخاص بك', 'Een link voor het opnieuw instellen van het wachtwoord is naar uw e-mailadres verzonden', 'Un lien de réinitialisation du mot de passe a été envoyé à votre adresse e-mail.', 'Ein Link zum Zurücksetzen des Passworts wurde an Ihre E-Mail-Adresse gesendet', 'Un link per la reimpostazione della password è stato inviato al tuo indirizzo e-mail', 'Um link de redefinição de senha foi enviado para o seu endereço de e-mail', 'Ссылка для сброса пароля была отправлена ​​на ваш адрес электронной почты', 'Se ha enviado un enlace para restablecer la contraseña a su dirección de correo electrónico.', 'E-posta adresinize şifre sıfırlama bağlantısı gönderildi'),
(787, '', NULL, 'you_enter_wrong_password', 'You enter wrong password', 'قمت بإدخال كلمة مرور خاطئة', 'U voert een verkeerd wachtwoord in', 'Vous entrez un mot de passe incorrect', 'Sie geben ein falsches Passwort ein', 'Inserisci la password sbagliata', 'Você digita a senha errada', 'Вы ввели неправильный пароль', 'Usted ingresa una contraseña incorrecta', 'Yanlış şifre gir'),
(788, '', NULL, 'profile_fetch_successfully', 'Profile fetch successfully', 'جلب ملف التعريف بنجاح', 'Profiel ophalen succesvol', 'Récupération du profil avec succès', 'Profilabruf erfolgreich', 'Il profilo va a buon fine', 'Perfil buscar com sucesso', 'Получение профиля успешно', 'Recuperar el perfil correctamente', 'Profil başarıyla alındı'),
(789, '', NULL, 'empty_username', 'Empty username', 'اسم المستخدم الفارغ', 'Lege gebruikersnaam', 'Nom d\'utilisateur vide', 'Leerer Benutzername', 'Nome utente vuoto', 'Nome de usuário vazio', 'Пустое имя пользователя', 'Nombre de usuario vacío', 'Boş kullanıcı adı'),
(790, '', NULL, 'empty_password', 'Empty password', 'كلمة المرور فارغة', 'Leeg wachtwoord', 'Mot de passe vide', 'Leeres Passwort', 'Password vuota', 'Senha vazia', 'Пустой пароль', 'Contraseña vacía', 'Boş şifre'),
(791, '', NULL, 'id_cannot_be_empty__or_character._only_numbers_allowed', 'ID cannot be empty, or character. only numbers allowed', 'لا يمكن أن يكون المعرف فارغًا أو حرفًا. فقط الأرقام المسموح بها', 'ID mag niet leeg zijn, of karakter. alleen cijfers toegestaan', 'ID ne peut pas être vide ou caractère. seuls les nombres autorisés', 'ID darf nicht leer oder Zeichen sein. Nur Zahlen erlaubt', 'L\'ID non può essere vuoto o carattere. solo numeri consentiti', 'O ID não pode estar vazio ou caractere. somente números permitidos', 'Идентификатор не может быть пустым или символом. разрешены только цифры', 'La identificación no puede estar vacía, o el carácter. solo números permitidos', 'Kimlik boş veya karakter olamaz. sadece sayılara izin verilir'),
(792, '', NULL, 'session_add_failed', 'Session add failed', 'فشل إضافة الجلسة', 'Sessie toevoegen mislukt', 'L\'ajout de session a échoué', 'Das Hinzufügen der Sitzung ist fehlgeschlagen', 'Aggiunta sessione non riuscita', 'Falha ao adicionar sessão', 'Не удалось добавить сеанс', 'Falló la adición de sesión', 'Oturum ekleme başarısız'),
(793, '', NULL, 'username_cannot_be_empty', 'Username cannot be empty', 'اسم المستخدم لا يمكن أن يكون فارغا', 'Gebruikersnaam kan niet leeg zijn', 'Le nom d\'utilisateur ne peut pas être vide', 'Der Benutzername darf nicht leer sein', 'Il nome utente non può essere vuoto', 'O nome de usuário não pode estar vazio', 'Имя пользователя не может быть пустым', 'El nombre de usuario no puede estar vacío', 'Kullanıcı adı boş olamaz'),
(794, '', NULL, 'token_cannot_be_empty', 'Token cannot be empty', 'الرمز المميز لا يمكن أن يكون فارغًا', 'Token kan niet leeg zijn', 'Le jeton ne peut pas être vide', 'Das Token darf nicht leer sein', 'Il token non può essere vuoto', 'O token não pode estar vazio', 'Токен не может быть пустым', 'El token no puede estar vacío', 'Jeton boş olamaz'),
(795, '', NULL, 'could_not_ave_session', 'Could not ave session', 'لا يمكن أن جلسة أيف', 'Kan niet ave sessie', 'Je n\'ai pas pu avoir de session', 'Sitzung konnte nicht durchgeführt werden', 'Non posso fare una sessione', 'Não foi possível uma sessão', 'Не удалось проложить сеанс', 'No se pudo tener una sesión', 'Oturum açılamadı'),
(796, '', NULL, 'user_not_found', 'User not found', 'المستخدم ليس موجود', 'Gebruiker niet gevonden', 'Utilisateur non trouvé', 'Benutzer wurde nicht gefunden', 'Utente non trovato', 'Usuário não encontrado', 'Пользователь не найден', 'Usuario no encontrado', 'Kullanıcı bulunamadı'),
(797, '', NULL, 'id_cannot_be_empty__or_character._only_numbers_allowed.', 'ID cannot be empty, or character. only numbers allowed.', 'لا يمكن أن يكون المعرف فارغًا أو حرفًا. فقط الأرقام المسموح بها.', 'ID mag niet leeg zijn, of karakter. alleen cijfers toegestaan.', 'ID ne peut pas être vide ou caractère. seuls les nombres sont autorisés.', 'ID darf nicht leer oder Zeichen sein. Nur Zahlen erlaubt.', 'L\'ID non può essere vuoto o carattere. solo numeri consentiti.', 'O ID não pode estar vazio ou caractere. apenas números permitidos.', 'Идентификатор не может быть пустым или символом. разрешены только цифры.', 'La identificación no puede estar vacía, o el carácter. sólo se permiten números.', 'Kimlik boş veya karakter olamaz. sadece numaralara izin verilir.'),
(798, '', NULL, 'error_while_deleting__blocks__data.', 'Error while deleting &quot;Blocks&quot; data.', 'حدث خطأ أثناء حذف & quot؛ إنشاء & quot؛ البيانات.', 'Fout bij het verwijderen van & quot; Blokken & quot; gegevens.', 'Erreur lors de la suppression de ', 'Fehler beim Löschen von & quot; Blöcke & quot; Daten.', 'Errore durante l\'eliminazione di & quot; Blocchi & quot; dati.', 'Erro ao excluir & quot; Blocos & quot; dados.', 'Ошибка при удалении & quot; Блоки & quot; данные.', 'Error al eliminar & quot; Bloques & quot; datos.', '\"Bloklar\" silinirken hata oluştu; veri.'),
(799, '', NULL, 'error_while_deleting__conversations__data.', 'Error while deleting &quot;Conversations&quot; data.', 'حدث خطأ أثناء حذف & quot؛ المحادثات & quot؛ البيانات.', 'Fout tijdens het verwijderen van & quot; Conversaties & quot; gegevens.', 'Erreur lors de la suppression de & quot; Conversations & quot; Les données.', 'Fehler beim Löschen von & quot; Konversationen & quot; Daten.', 'Errore durante l\'eliminazione di & quot; Conversazioni & quot; dati.', 'Erro ao excluir & quot; conversas & quot; dados.', 'Ошибка при удалении & quot; Беседы & quot; данные.', 'Error al eliminar & quot; Conversaciones & quot; datos.', '\"Konuşmalar\" silinirken hata oluştu; veri.'),
(800, '', NULL, 'error_while_deleting__likes__data.', 'Error while deleting &quot;Likes&quot; data.', 'حدث خطأ أثناء حذف & quot؛ إبداء الإعجاب & quot؛ البيانات.', 'Fout tijdens het verwijderen van & quot; Likes & quot; gegevens.', 'Erreur lors de la suppression de & L; Aime & quot; Les données.', 'Fehler beim Löschen von & quot; Likes & quot; Daten.', 'Errore durante l\'eliminazione di & quot; Mi piace & quot; dati.', 'Erro ao excluir & quot; Curtidas & quot; dados.', 'Ошибка при удалении & quot; Likes & quot; данные.', 'Error al eliminar & quot; Me gusta & quot; datos.', '\"Beğeniler\" silinirken hata oluştu; veri.'),
(801, '', NULL, 'error_while_deleting__media_files__data.', 'Error while deleting &quot;Media files&quot; data.', 'حدث خطأ أثناء حذف & quot؛ ملفات الوسائط & quot؛ البيانات.', 'Fout bij het verwijderen van & quot; Mediabestanden & quot; gegevens.', 'Erreur lors de la suppression de & quot; Fichiers multimédias & quot; Les données.', 'Fehler beim Löschen von & quot; Mediendateien & quot; Daten.', 'Errore durante l\'eliminazione di & quot; File multimediali & quot; dati.', 'Erro ao excluir os arquivos & quot; Arquivos de mídia & quot; dados.', 'Ошибка при удалении & quot; медиа-файлов & quot; данные.', 'Error al eliminar & quot; Archivos de medios & quot; datos.', '\"Medya dosyaları\" silinirken hata oluştu; veri.'),
(802, '', NULL, 'error_while_deleting__messages__data.', 'Error while deleting &quot;Messages&quot; data.', 'حدث خطأ أثناء حذف & quot؛ الرسائل & quot؛ البيانات.', 'Fout tijdens het verwijderen van & quot; Berichten & quot; gegevens.', 'Erreur lors de la suppression de & Messages; Messages & quot; Les données.', 'Fehler beim Löschen von & quot; Nachrichten & quot; Daten.', 'Errore durante l\'eliminazione di & quot; Messaggi & quot; dati.', 'Erro ao excluir & quot; Mensagens & quot; dados.', 'Ошибка при удалении & quot; Сообщения & quot; данные.', 'Error al eliminar & quot; Mensajes & quot; datos.', '\"Mesajlar\" silinirken hata oluştu; veri.'),
(803, '', NULL, 'error_while_deleting__notifications__data.', 'Error while deleting &quot;Notifications&quot; data.', 'حدث خطأ أثناء حذف & quot؛ الإشعارات & quot؛ البيانات.', 'Fout bij het verwijderen van & quot; Meldingen & quot; gegevens.', 'Erreur lors de la suppression de & Notifications; Notifications & quot; Les données.', 'Fehler beim Löschen von & quot; Benachrichtigungen & quot; Daten.', 'Errore durante l\'eliminazione di & quot; Notifiche & quot; dati.', 'Erro ao excluir & quot; Notificações & quot; dados.', 'Ошибка при удалении & quot; Уведомления & quot; данные.', 'Error al eliminar & quot; Notificaciones & quot; datos.', '\"Bildirimler\" silinirken hata oluştu; veri.'),
(804, '', NULL, 'error_while_deleting__reports__data.', 'Error while deleting &quot;Reports&quot; data.', 'حدث خطأ أثناء حذف & quot؛ التقارير & quot؛ البيانات.', 'Fout bij het verwijderen van & quot; Rapporten & quot; gegevens.', 'Erreur lors de la suppression de & Reports; Rapports & quot; Les données.', 'Fehler beim Löschen von & quot; Berichten & quot; Daten.', 'Errore durante l\'eliminazione di & quot; Rapporti & quot; dati.', 'Erro ao excluir & quot; Relatórios & quot; dados.', 'Ошибка при удалении & quot; Отчетов & quot; данные.', 'Error al eliminar & quot; Informes & quot; datos.', '\"Raporlar\" silinirken hata oluştu; veri.'),
(805, '', NULL, 'error_while_deleting__gifts__data.', 'Error while deleting &quot;Gifts&quot; data.', 'حدث خطأ أثناء حذف & quot؛ هدايا & quot؛ البيانات.', 'Fout tijdens het verwijderen van & quot; Gifts & quot; gegevens.', 'Erreur lors de la suppression de & quot; Cadeaux & quot; Les données.', 'Fehler beim Löschen von & quot; Geschenke & quot; Daten.', 'Errore durante l\'eliminazione di & quot; Regali & quot; dati.', 'Erro ao excluir os & quot; Presentes & quot; dados.', 'Ошибка при удалении & quot; Подарки & quot; данные.', 'Error al eliminar & quot; Regalos & quot; datos.', '\"Hediyeler\" silinirken hata oluştu; veri.'),
(806, '', NULL, 'error_while_deleting__visits__data.', 'Error while deleting &quot;Visits&quot; data.', 'حدث خطأ أثناء حذف & quot؛ الزيارات & quot؛ البيانات.', 'Fout bij het verwijderen van & quot; Bezoeken & quot; gegevens.', 'Erreur lors de la suppression de & quot; Visites & quot; Les données.', 'Fehler beim Löschen von & quot; Besuche & quot; Daten.', 'Errore durante l\'eliminazione di & quot; Visite & quot; dati.', 'Erro ao excluir & quot; Visitas & quot; dados.', 'Ошибка при удалении & quot; посещений & quot; данные.', 'Error al eliminar & quot; Visitas & quot; datos.', '\"Ziyaretler\" silinirken hata oluştu; veri.'),
(807, '', NULL, 'error_while_deleting__user__data.', 'Error while deleting &quot;User&quot; data.', 'حدث خطأ أثناء حذف & quot؛ المستخدم & quot؛ البيانات.', 'Fout tijdens het verwijderen van & quot; Gebruiker & quot; gegevens.', 'Erreur lors de la suppression de ', 'Fehler beim Löschen von & quot; Benutzer & quot; Daten.', 'Errore durante l\'eliminazione di & quot; Utente & quot; dati.', 'Erro ao excluir o & quot; Usuário & quot; dados.', 'Ошибка при удалении & quot; пользователя & quot; данные.', 'Error al eliminar & quot; Usuario & quot; datos.', '\"Kullanıcı\" silinirken hata oluştu; veri.'),
(808, '', NULL, 'error_while_deleting__sessions__data.', 'Error while deleting &quot;Sessions&quot; data.', 'حدث خطأ أثناء حذف & quot؛ الجلسات & quot؛ البيانات.', 'Fout tijdens het verwijderen van & quot; Sessions & quot; gegevens.', 'Erreur lors de la suppression de & quot; Sessions & quot; Les données.', 'Fehler beim Löschen von & quot; Sitzungen & quot; Daten.', 'Errore durante l\'eliminazione di & quot; Sessioni & quot; dati.', 'Erro ao excluir & quot; Sessões & quot; dados.', 'Ошибка при удалении & quot; сеансов & quot; данные.', 'Error al eliminar & quot; Sesiones & quot; datos.', '\"Oturumlar\" silinirken hata oluştu; veri.'),
(809, '', NULL, 'error_while_deleting__payments__data.', 'Error while deleting &quot;Payments&quot; data.', 'حدث خطأ أثناء حذف & quot؛ الدفعات & quot؛ البيانات.', 'Fout bij het verwijderen van & quot; Betalingen & quot; gegevens.', 'Erreur lors de la suppression de ', 'Fehler beim Löschen von & quot; Zahlungen & quot; Daten.', 'Errore durante l\'eliminazione di & quot; Pagamenti & quot; dati.', 'Erro ao excluir & quot; Pagamentos & quot; dados.', 'Ошибка при удалении & quot; Платежей & quot; данные.', 'Error al eliminar & quot; Pagos & quot; datos.', '\"Ödemeler\" silinirken hata oluştu; veri.'),
(810, '', NULL, 'like_delete_successfully.', 'Like delete successfully.', 'مثل حذف بنجاح.', 'Net als succesvol verwijderen.', 'Comme supprimer avec succès.', 'Wie erfolgreich löschen.', 'Come cancellare con successo.', 'Como excluir com sucesso.', 'Нравится удалить успешно.', 'Me gusta eliminar con éxito.', 'Başarıyla silmek gibi.'),
(811, '', NULL, 'dislike_delete_successfully.', 'Dislike delete successfully.', 'لم يعجبني حذف بنجاح.', 'Houden niet van succesvol verwijderen.', 'N\'aime pas supprimer avec succès.', 'Ich möchte nicht erfolgreich löschen.', 'Non mi piace cancellare con successo.', 'Não gosto de excluir com sucesso.', 'Не нравится удалить успешно.', 'No me gusta eliminar con éxito.', 'Başarılı bir şekilde silme işlemini sevme'),
(812, '', NULL, 'user_unblocked_successfully.', 'User unblocked successfully.', 'تم إلغاء حظر المستخدم بنجاح.', 'Gebruiker de blokkering opgeheven.', 'Utilisateur débloqué avec succès.', 'Benutzer wurde erfolgreich entsperrt.', 'Utente sbloccato con successo.', 'Usuário desbloqueado com sucesso.', 'Пользователь успешно разблокирован.', 'Usuario desbloqueado satisfactoriamente.', 'Kullanıcı başarıyla engellendi.'),
(813, '', NULL, 'user_blocked_successfully.', 'User blocked successfully.', 'تم حظر المستخدم بنجاح.', 'Gebruiker is succesvol geblokkeerd.', 'Utilisateur bloqué avec succès.', 'Benutzer erfolgreich blockiert', 'Utente bloccato correttamente.', 'Usuário bloqueado com sucesso.', 'Пользователь успешно заблокирован.', 'Usuario bloqueado satisfactoriamente.', 'Kullanıcı başarıyla engellendi.'),
(814, '', NULL, 'user_unreported_successfully.', 'User unreported successfully.', 'لم يتم الإبلاغ عن المستخدم بنجاح.', 'Gebruiker niet succesvol gemeld.', 'Utilisateur non signalé avec succès.', 'Benutzer wurde nicht erfolgreich gemeldet.', 'Utente non segnalato correttamente.', 'Usuário não relatado com sucesso.', 'Пользователь не зарегистрирован успешно.', 'Usuario no reportado con éxito.', 'Kullanıcı başarıyla bildirilmedi.'),
(815, '', NULL, 'user_reported_successfully.', 'User reported successfully.', 'أبلغ المستخدم بنجاح.', 'Gebruiker succesvol gemeld.', 'Utilisateur signalé avec succès.', 'Benutzer wurde erfolgreich gemeldet.', 'Utente segnalato correttamente.', 'Usuário relatado com sucesso.', 'Пользователь сообщил об успешном.', 'El usuario informó con éxito.', 'Kullanıcı başarıyla bildirildi.'),
(816, '', NULL, 'user_visited_successfully.', 'User visited successfully.', 'زار المستخدم بنجاح.', 'Gebruiker met succes bezocht.', 'Utilisateur visité avec succès.', 'Benutzer erfolgreich besucht', 'Utente visitato con successo.', 'Usuário visitado com sucesso.', 'Пользователь успешно посетил', 'Usuario visitado con éxito.', 'Kullanıcı başarıyla ziyaret edildi.'),
(817, '', NULL, 'could_not_save_user_visit', 'Could not save user visit', 'لا يمكن حفظ زيارة المستخدم', 'Kan gebruikersbezoek niet opslaan', 'Impossible d\'enregistrer la visite de l\'utilisateur', 'Der Besuch des Benutzers konnte nicht gespeichert werden', 'Impossibile salvare la visita dell\'utente', 'Não foi possível salvar a visita do usuário', 'Не удалось сохранить визит пользователя', 'No se pudo guardar la visita del usuario.', 'Kullanıcı ziyareti kaydedilemedi'),
(818, '', NULL, 'gift_sent_successfully.', 'Gift sent successfully.', 'الهدية ارسلت بنجاح.', 'Gift succesvol verzonden.', 'Cadeau envoyé avec succès.', 'Geschenk erfolgreich gesendet', 'Regalo inviato con successo.', 'Presente enviado com sucesso.', 'Подарок успешно отправлен.', 'Regalo enviado con éxito.', 'Hediye başarıyla gönderildi.'),
(819, '', NULL, 'could_not_save_user_gift', 'Could not save user gift', 'لا يمكن حفظ هدية المستخدم', 'Kan gebruikerscadeau niet opslaan', 'Impossible d\'enregistrer le cadeau de l\'utilisateur', 'Benutzergeschenk konnte nicht gespeichert werden', 'Impossibile salvare il regalo dell\'utente', 'Não foi possível salvar o presente do usuário', 'Не удалось сохранить подарок пользователя', 'No se pudo guardar el regalo del usuario', 'Kullanıcı hediyesi kaydedilemedi'),
(820, '', NULL, 'search_fetch_successfully', 'Search fetch successfully', 'البحث الجلب بنجاح', 'Zoekopdracht succesvol ophalen', 'Recherche réussie avec succès', 'Suchabruf erfolgreich', 'Cerca con successo', 'Buscar busca com sucesso', 'Поиск успешно', 'Búsqueda de búsqueda con éxito', 'Arama getirme başarılı bir şekilde yapıldı'),
(821, '', NULL, 'profile_updated_successfully.', 'Profile updated successfully.', 'تم تحديث الملف الشخصي بنجاح.', 'Profiel succesvol bijgewerkt.', 'Mise à jour du profil réussie.', 'Profil erfolgreich aktualisiert.', 'Profilo aggiornato con successo.', 'Perfil atualizado com sucesso.', 'Профиль успешно обновлен.', 'Perfil actualizado con éxito.', 'Profil başarıyla güncellendi.'),
(822, '', NULL, 'can_not_update_profile.', 'Can not update profile.', 'لا يمكن تحديث الملف الشخصي.', 'Kan profiel niet bijwerken.', 'Impossible de mettre à jour le profil.', 'Profil kann nicht aktualisiert werden.', 'Impossibile aggiornare il profilo.', 'Não é possível atualizar o perfil.', 'Не могу обновить профиль.', 'No se puede actualizar el perfil.', 'Profil güncellenemiyor.'),
(823, '', NULL, 'profile_avatar_updated_successfully.', 'Profile avatar updated successfully.', 'تم تحديث الصورة الرمزية للعرض بنجاح.', 'Profiel avatar succesvol bijgewerkt.', 'Avatar de profil mis à jour avec succès.', 'Profil-Avatar wurde erfolgreich aktualisiert.', 'Avatar profilo aggiornato correttamente.', 'Avatar do perfil atualizado com sucesso.', 'Профиль аватара успешно обновлен.', 'Perfil de avatar actualizado con éxito.', 'Profil avatarı başarıyla güncellendi.');
INSERT INTO `langs` (`id`, `ref`, `options`, `lang_key`, `english`, `arabic`, `dutch`, `french`, `german`, `italian`, `portuguese`, `russian`, `spanish`, `turkish`) VALUES
(824, '', NULL, 'can_not_upload_avatar_file.', 'Can not upload avatar file.', 'لا يمكن تحميل ملف الصورة الرمزية.', 'Kan avatar-bestand niet uploaden.', 'Impossible de télécharger le fichier d\'avatar.', 'Avatar-Datei kann nicht hochgeladen werden.', 'Impossibile caricare il file dell\'avatar.', 'Não é possível carregar o arquivo do avatar.', 'Не удается загрузить файл аватара.', 'No se puede subir el archivo de avatar.', 'Avatar dosyası yüklenemiyor.'),
(825, '', NULL, 'google_key__post__is_missing', 'google_key (POST) is missing', 'google_key (POST) مفقود', 'google_key (POST) ontbreekt', 'google_key (POST) est manquant', 'google_key (POST) fehlt', 'manca google_key (POST)', 'google_key (POST) está faltando', 'google_key (POST) отсутствует', 'Falta google_key (POST)', 'google_key (POST) eksik'),
(826, '', NULL, 'login_success', 'Login Success', 'النجاح في تسجيل الدخول', 'Succesvol ingelogd', 'Connexion réussie', 'Erfolgreich eingeloggt', 'Login successo', 'Sucesso de Login', 'Войти успешно', 'Acceso exitoso', 'Giriş başarılı'),
(827, '', NULL, 'empty_social_id', 'Empty social id', 'معرف اجتماعي فارغ', 'Leeg sociaal ID', 'Identifiant social vide', 'Leere soziale ID', 'ID sociale vuoto', 'ID social vazia', 'Пустой социальный идентификатор', 'Identificación social vacía', 'Boş sosyal kimlik'),
(828, '', NULL, 'payment_processed_successfully', 'Payment processed successfully', 'تمت معالجة الدفعة بنجاح', 'Betaling succesvol verwerkt', 'Paiement traité avec succès', 'Zahlung erfolgreich abgewickelt', 'Pagamento elaborato con successo', 'Pagamento processado com sucesso', 'Платеж успешно обработан', 'Pago procesado exitosamente', 'Ödeme başarıyla işlendi'),
(829, '', NULL, 'error_while_payment_process', 'Error While Payment process', 'خطأ أثناء عملية الدفع', 'Fout tijdens betalingsproces', 'Erreur lors du processus de paiement', 'Fehler beim Bezahlvorgang', 'Errore durante il processo di pagamento', 'Erro durante o processo de pagamento', 'Ошибка при обработке платежа', 'Error en el proceso de pago', 'Ödeme İşlemi Sırasında Hata'),
(830, '', NULL, 'visit_you', 'Visit you', 'زيارتك', 'Jou bezoeken', 'Te rendre visite', 'Dich besuchen', 'Visitarti', 'Visitar você', 'Посетить вас', 'Visitarte', 'Seni ziyaret et'),
(831, '', NULL, 'like_you', 'Like you', 'مثلك', 'Zoals jij', 'Comme toi', 'Wie du', 'Come te', 'Gosto de voce', 'Как ты', 'Como tú', 'Senin gibi'),
(832, '', NULL, 'dislike_you', 'Dislike you', 'يكرهك', 'Ik vind je niet leuk', 'Te déteste', 'Ich mag dich nicht', 'Non ti piace', 'Não gosta de você', 'Не нравится тебе', 'No te gusta', 'Sevmiyorum'),
(833, '', NULL, 'send_gift_to_you', 'Send gift to you', 'ارسل هدية لك', 'Stuur cadeau aan jou', 'Envoyer un cadeau à vous', 'Senden Sie ein Geschenk an Sie', 'Invia regalo a te', 'Envie um presente para você', 'Отправить подарок вам', 'Enviarte un regalo', 'Sana hediye gönder'),
(834, '', NULL, 'you_got_a_new_match__click_to_view_', 'You got a new match, click to view!', 'لقد حصلت على مباراة جديدة ، انقر للعرض!', 'Je hebt een nieuwe match, klik om te bekijken!', 'Vous avez un nouveau match, cliquez pour voir!', 'Sie haben ein neues Spiel erhalten, klicken Sie, um es anzuzeigen!', 'Hai una nuova partita, clicca per vedere!', 'Você tem um novo jogo, clique para ver!', 'Вы получили новый матч, нажмите, чтобы посмотреть!', 'Tienes un nuevo partido, haz clic para ver!', 'Yeni bir eşleşmeniz var, görmek için tıklayın!'),
(835, '', NULL, 'choose_your_relationship_status', 'Choose your Relationship status', 'اختر حالة علاقتك', 'Kies uw Relatiestatus', 'Choisissez votre statut de relation', 'Wählen Sie Ihren Beziehungsstatus', 'Scegli il tuo stato di relazione', 'Escolha o seu status de relacionamento', 'Выберите статус отношений', 'Elija su estado de relación', 'İlişki durumunuzu seçin'),
(836, '', NULL, 'choose_your_preferred_language', 'Choose your Preferred Language', 'اختر لغتك المفضلة', 'Kies uw voorkeurstaal', 'Choisissez votre langue préférée', 'Wählen Sie Ihre bevorzugte Sprache', 'Scegli la tua lingua preferita', 'Escolha o seu idioma preferido', 'Выберите предпочитаемый язык', 'Elija su idioma preferido', 'Tercih ettiğiniz dili seçin'),
(837, '', NULL, 'choose_your_work_status', 'Choose your Work status', 'اختر حالة عملك', 'Kies uw werkstatus', 'Choisissez votre statut de travail', 'Wählen Sie Ihren Arbeitsstatus', 'Scegli il tuo stato di lavoro', 'Escolha seu status de trabalho', 'Выберите свой рабочий статус', 'Elija su estado de trabajo', 'İş durumunuzu seçin'),
(838, '', NULL, 'choose_your_hair_color', 'Choose your Hair Color', 'اختر لون الشعر الخاص بك', 'Kies je haarkleur', 'Choisissez votre couleur de cheveux', 'Wählen Sie Ihre Haarfarbe', 'Scegli il tuo colore di capelli', 'Escolha sua cor de cabelo', 'Выберите цвет волос', 'Elige tu color de pelo', 'Saç renginizi seçin'),
(839, '', NULL, 'live_with', 'Live with', 'العيش مع', 'Leef met', 'Vivre avec', 'Leben mit', 'Vivere con', 'Viver com', 'Жить с', 'Vivir con', 'Birlikte yaşamak'),
(840, '', NULL, 'enter_a_tag__then_hit_enter', 'Enter a tag, then hit enter', 'أدخل علامة ، ثم اضغط على Enter', 'Voer een tag in en druk op Enter', 'Entrez une balise, puis appuyez sur Entrée', 'Geben Sie ein Tag ein und drücken Sie die Eingabetaste', 'Inserisci un tag, quindi premi invio', 'Insira uma tag e pressione Enter', 'Введите тег, затем нажмите Enter', 'Introduce una etiqueta, luego pulsa enter', 'Bir etiket girin, ardından enter tuşuna basın'),
(841, '', NULL, '_tag__hit_enter_to_add_more', '+Tag, Hit enter to add more', '+ علامة ، اضغط على Enter لإضافة المزيد', '+ Tag, druk op Enter om meer toe te voegen', '+ Tag, appuyez sur Entrée pour ajouter plus', '+ Tag, drücken Sie die Eingabetaste, um weitere hinzuzufügen', '+ Tag, premi Invio per aggiungere altro', '+ Tag, pressione Enter para adicionar mais', '+ Tag, нажмите Enter, чтобы добавить больше', '+ Etiqueta, pulsa enter para añadir más', '+ Tag, daha fazla eklemek için Enter tuşuna basın'),
(842, '', NULL, 'i__039_m_studying', 'I&#039;m studying', 'أنا أدرس', 'ik ben aan het studeren', 'j\'étudie', 'ich studiere', 'sto studiando', 'Estou estudando', 'я учусь', 'estoy estudiando', 'ders çalışıyorum'),
(843, '', NULL, 'i__039_m_working', 'I&#039;m working', 'أعمل', 'ik ben aan het werk', 'je travaille', 'ich bin am Arbeiten', 'sto lavorando', 'estou trabalhando', 'я работаю', 'estoy trabajando', 'Çalışıyorum'),
(844, '', NULL, 'i__039_m_looking_for_work', 'I&#039;m looking for work', 'انا ابحث عن عمل', 'ik zoek naar werk', 'je cherche du travail', 'ich suche nach Arbeit', 'sto cercando lavoro', 'Estou procurando trabalho', 'Я ищу работу', 'Estoy buscando trabajo', 'iş arıyorum'),
(845, '', NULL, 'i__039_m_retired', 'I&#039;m retired', 'أنا متقاعد', 'ik ben met pensioen', 'Je suis à la retraite', 'Ich bin im Ruhestand', 'sono in pensione', 'estou aposentado', 'я ушел в отставку', 'estoy retirado', 'emekliyim'),
(877, '', NULL, 'i_have_kids_and_don__039_t_want_more', 'I have kids and don&#039;t want more', 'لدي أطفال ولا أريد المزيد', 'Ik heb kinderen en wil niet meer', 'J\'ai des enfants et je ne veux plus', 'Ich habe Kinder und will nicht mehr', 'Ho figli e non ne voglio altri', 'Eu tenho filhos e não quero mais', 'У меня есть дети, и я не хочу больше', 'Tengo hijos y no quiero mas', 'Çocuklarım var ve daha fazla istemiyorum'),
(878, '', NULL, 'personality', 'Personality', 'الشخصية', 'Persoonlijkheid', 'Personnalité', 'Persönlichkeit', 'Personalità', 'Personalidade', 'личность', 'Personalidad', 'Kişilik'),
(879, '', NULL, 'favourites', 'Favourites', 'المفضلة', 'favorieten', 'Favoris', 'Favoriten', 'Preferiti', 'Favoritos', 'Избранные', 'Favoritos', 'Favoriler'),
(880, '', NULL, 'notification_saved_successfully', 'Notification saved successfully', 'تم حفظ الإشعار بنجاح', 'Notificatie succesvol opgeslagen', 'Notification enregistrée avec succès', 'Benachrichtigung erfolgreich gespeichert', 'Notifica salvata correttamente', 'Notificação salva com sucesso', 'Уведомление успешно сохранено', 'Notificación guardada con éxito', 'Bildirim başarıyla kaydedildi'),
(881, '', NULL, 'error_found__please_try_again_later.', 'Error found, please try again later.', 'تم العثور على خطأ ، يرجى المحاولة مرة أخرى في وقت لاحق.', 'Fout gevonden, probeer het later opnieuw.', 'Erreur trouvée, veuillez réessayer plus tard.', 'Fehler gefunden, bitte später erneut versuchen.', 'Errore trovato, per favore riprova più tardi.', 'Erro encontrado, por favor, tente novamente mais tarde.', 'Ошибка найдена, повторите попытку позже.', 'Se ha encontrado un error, inténtalo de nuevo más tarde.', 'Hata bulundu, lütfen daha sonra tekrar deneyin.'),
(882, '', NULL, 'return_back', 'Return back', 'رجوع', 'Terugkeren', 'Retour', 'Kehren Sie zurück', 'Torna indietro', 'Devolver', 'Вернуться назад', 'Devolver', 'Geri dön'),
(1103, '', NULL, 'choose_your_gender', 'Choose your Gender', 'اختيار جنسك', 'Kies je geslacht', 'Choisissez votre genre', 'Wählen Sie ihr Geschlecht', 'Scegli il tuo genere', 'Escolha o seu sexo', 'Выберите свой пол', 'Elige tu género', 'Cinsiyetinizi seçin'),
(1111, '', NULL, 'enter_a_location', 'Enter a location', 'أدخل الموقع', 'Voer een locatie in', 'Entrez un lieu', 'Ort eingeben', 'Inserisci una posizione', 'Digite um local', 'Введите местоположение', 'Introduce una ubicación', 'Bir yer girin'),
(1116, '', NULL, 'by_creating_your_account__you_agree_to_our', 'By creating your account, you agree to our', 'عن طريق إنشاء حسابك ، فإنك توافق على', 'Door uw account aan te maken, gaat u akkoord met onze', 'En créant votre compte, vous acceptez notre', 'Durch die Erstellung Ihres Kontos stimmen Sie unserem zu', 'Creando il tuo account, accetti i nostri', 'Ao criar sua conta, você concorda com nossos', 'Создавая свой аккаунт, вы соглашаетесь с нашими', 'Al crear su cuenta, usted acepta nuestra', 'Hesabınızı oluşturarak, kabul etmiş sayılırsınız.'),
(1117, '', NULL, 'this_phone_number_is_already_exist.', 'This Phone number is Already exist.', 'رقم الهاتف هذا موجود بالفعل.', 'Dit telefoonnummer bestaat al.', 'Ce numéro de téléphone est déjà existant.', 'Diese Telefonnummer ist bereits vorhanden.', 'Questo numero di telefono è già esistente.', 'Este número de telefone já existe.', 'Этот номер телефона уже существует.', 'Este número de teléfono ya existe.', 'Bu telefon numarası zaten var.'),
(1120, '', NULL, 'current_password', 'Current Password', 'كلمة المرور الحالي', 'huidig ​​wachtwoord', 'Mot de passe actuel', 'derzeitiges Passwort', 'Password attuale', 'senha atual', 'Текущий пароль', 'contraseña actual', 'Şimdiki Şifre'),
(1153, '', NULL, 'delete_account_', 'Delete account?', 'حذف الحساب؟', 'Account verwijderen?', 'Supprimer le compte?', 'Konto löschen?', 'Eliminare l\'account?', 'Deletar conta?', 'Удалить аккаунт?', '¿Borrar cuenta?', 'Hesabı sil?'),
(1154, '', NULL, 'are_you_sure_you_want_to_delete_your_account__all_content_including_published_photos_and_other_data_will_be_permanetly_removed_', 'Are you sure you want to delete your account? All content including published photos and other data will be permanetly removed!', 'هل انت متأكد انك تريد حذف حسابك؟ سيتم إزالة جميع المحتويات بما في ذلك الصور المنشورة وغيرها من البيانات نهائيًا!', 'Weet je zeker dat je je account wilt verwijderen? Alle inhoud inclusief gepubliceerde foto\'s en andere gegevens worden permanent verwijderd!', 'Êtes-vous sûr de vouloir supprimer votre compte? Tout le contenu, y compris les photos publiées et autres données, sera définitivement supprimé!', 'Möchten Sie Ihr Konto wirklich löschen? Alle Inhalte einschließlich veröffentlichter Fotos und anderer Daten werden dauerhaft entfernt!', 'Sei sicuro di voler cancellare il tuo account? Tutti i contenuti, incluse le foto pubblicate e altri dati, verranno rimossi definitivamente!', 'Tem certeza de que deseja excluir sua conta? Todo o conteúdo, incluindo fotos publicadas e outros dados, será permanentemente removido.', 'Вы уверены, что хотите удалить свой аккаунт? Весь контент, включая опубликованные фотографии и другие данные, будет окончательно удален!', '¿Estás seguro de que quieres eliminar tu cuenta? ¡Todo el contenido, incluidas las fotos publicadas y otros datos, se eliminará permanentemente!', 'Hesabınızı silmek istediğinizden emin misiniz? Yayınlanan fotoğraflar ve diğer veriler dahil olmak üzere tüm içerikler kalıcı olarak silinecek!'),
(1155, '', NULL, 'delete', 'Delete', 'حذف', 'Verwijder', 'Effacer', 'Löschen', 'Elimina', 'Excluir', 'удалять', 'Borrar', 'silmek'),
(1156, '', NULL, 'chat_conversations_fetch_successfully', 'Chat conversations fetch successfully', 'محادثات الدردشة جلب بنجاح', 'Chatgesprekken worden met succes opgehaald', 'Conversations de conversation réussies', 'Chat-Konversationen werden erfolgreich abgerufen', 'Le conversazioni di chat vengono recuperate con successo', 'Conversas de bate-papo buscam com sucesso', 'Чат разговоры извлекаются успешно', 'Las conversaciones de chat se llevan con éxito', 'Sohbetler başarıyla alındı'),
(1158, '', NULL, 'bank_transfer', 'Bank Transfer', 'التحويل المصرفي', 'Overschrijving', 'Virement', 'Banküberweisung', 'Trasferimento bancario', 'Transferência bancária', 'Банковский перевод', 'Transferencia bancaria', 'Banka transferi'),
(1159, '', NULL, 'close', 'Close', 'قريب', 'Dichtbij', 'Fermer', 'Schließen', 'Vicino', 'Perto', 'близко', 'Cerrar', 'Kapat'),
(1160, '', NULL, 'bank_information', 'Bank Information', 'المعلومات المصرفية', 'Bank informatie', 'Information bancaire', 'Bank Informationen', 'Informazioni bancarie', 'Informação bancária', 'Банковская информация', 'Información bancaria', 'Banka bilgisi'),
(1161, '', NULL, 'please_transfer_the_amount_of', 'Please transfer the amount of', 'يرجى نقل كمية', 'Gelieve het bedrag over te maken', 'S\'il vous plaît transférer le montant de', 'Bitte überweisen Sie den Betrag von', 'Si prega di trasferire l\'importo di', 'Por favor, transfira a quantidade de', 'Пожалуйста, перечислите сумму', 'Por favor transfiera la cantidad de', 'Lütfen tutarını aktarın'),
(1162, '', NULL, 'to_this_bank_account_to_buy', 'to this bank account to purchase', 'لهذا الحساب المصرفي للشراء', 'om deze bankrekening te kopen', 'à ce compte bancaire pour acheter', 'zu diesem Bankkonto kaufen', 'a questo conto bancario per l\'acquisto', 'para esta conta bancária para comprar', 'на этот банковский счет для покупки', 'a esta cuenta bancaria para comprar', 'satın almak için bu banka hesabına'),
(1163, '', NULL, 'upload_receipt', 'Upload Receipt', 'تحميل الإيصال', 'Upload ontvangst', 'Télécharger le reçu', 'Quittung hochladen', 'Carica ricevuta', 'Carregar Recibo', 'Загрузить квитанцию', 'Cargar Recibo', 'Makbuzu Yükle'),
(1164, '', NULL, 'confirm', 'Confirm', 'تؤكد', 'Bevestigen', 'Confirmer', 'Bestätigen', 'Confermare', 'confirme', 'подтвердить', 'Confirmar', 'Onaylamak'),
(1165, '', NULL, 'your_receipt_uploaded_successfully.', 'Your was receipt successfully uploaded.', 'تم استلام الإيصال بنجاح.', 'Uw kwitantie is succesvol geüpload.', 'Votre reçu a été téléchargé avec succès.', 'Ihre Quittung wurde erfolgreich hochgeladen.', 'La tua ricevuta è stata caricata correttamente.', 'Seu recibo foi enviado com sucesso.', 'Ваша квитанция была успешно загружена.', 'Su recibo fue cargado correctamente.', 'Makbuzunuz başarıyla yüklendi.'),
(1166, '', NULL, 'date', 'Date', 'تاريخ', 'Datum', 'Rendez-vous amoureux', 'Datum', 'Data', 'Encontro', 'Дата', 'Fecha', 'tarih'),
(1167, '', NULL, 'processed_by', 'Processed By', 'معالجتها بواسطة', 'Verwerkt door', 'Traité par', 'Verarbeitet von', 'Elaborato da', 'Processado por', 'Обработано', 'Procesado por', 'Tarafından işlenmiş'),
(1168, '', NULL, 'amount', 'Amount', 'كمية', 'Bedrag', 'Montant', 'Menge', 'Quantità', 'Montante', 'Количество', 'Cantidad', 'Miktar'),
(1169, '', NULL, 'type', 'Type', 'نوع', 'Type', 'Type', 'Art', 'genere', 'Tipo', 'Тип', 'Tipo', 'tip'),
(1170, '', NULL, 'notes', 'Notes', 'ملاحظات', 'Notes', 'Remarques', 'Anmerkungen', 'Gli appunti', 'Notas', 'Заметки', 'Notas', 'notlar'),
(1171, '', NULL, 'plan_premium_membership', 'Plan Premium Membership', 'خطة عضوية مميزة', 'Plan Premium-lidmaatschap', 'Planifier l\'abonnement Premium', 'Planen Sie die Premium-Mitgliedschaft', 'Pianifica l\'abbonamento Premium', 'Planeje a filiação Premium', 'План Премиум членства', 'Membresía Premium Plan', 'Premium Üyeliği Planlayın'),
(1172, '', NULL, 'your_boost_will_expire_in', 'Your boost will expire in', 'ستنتهي صلاحيتك في', 'Je boost verloopt over', 'Votre boost expirera dans', 'Ihr Boost läuft in ab', 'La tua spinta scadrà nel', 'Seu impulso expirará em', 'Ваш буст истекает через', 'Tu impulso expirará en', 'Desteğiniz sona erecek'),
(1173, '', NULL, 'hide', 'Hide', 'إخفاء', 'Verbergen', 'Cacher', 'verbergen', 'Nascondere', 'ocultar', 'Спрятать', 'Esconder', 'Saklamak'),
(1174, '', NULL, 'you_reach_the_max_of_swipes_per_day._you_have_to_wait__0__hours_before_you_can_redo_likes_or_upgrade_to_pro_to_for_unlimited.', 'You have reached the maximum amuont of swipes per day, you have to wait {0} hours before you can redo swipes, OR upgrade now to Pro Membership for unlimited swipes and likes.', 'لقد وصلت إلى الحد الأقصى من الضربات الشديدة في اليوم ، يجب عليك الانتظار {0} ساعات قبل أن تتمكن من إعادة الضربات الشديدة ، أو الترقية الآن إلى عضوية Pro للحصول على الضربات الشديدة والإعجابات غير المحدودة.', 'Je hebt de maximale hoeveelheid swipes per dag bereikt, je moet {0} uur wachten voordat je veegbewegingen opnieuw kunt uitvoeren OF OF nu upgraden naar Pro-lidmaatschap voor onbeperkte swipes en vind-ik-leuks.', 'Vous avez atteint le maximum de balayages par jour, vous devez patienter {0} heures avant de pouvoir refaire les balayages, OU passer maintenant à l’abonnement Pro pour des balayages et des goûts illimités.', 'Sie haben die maximale Anzahl an Wischvorgängen pro Tag erreicht. Sie müssen {0} Stunden warten, bis Sie die Wischvorgänge wiederholen können, oder ein Upgrade auf Pro-Mitgliedschaft durchführen, um unbegrenzt Wischvorgänge und Likes durchzuführen.', 'Hai raggiunto il limite massimo di swipes al giorno, devi aspettare {0} ore prima di poter ripetere i passaggi, OPPURE effettuare l\'upgrade ora a Pro Membership per swipes e likes illimitati.', 'Você atingiu a quantidade máxima de furtos por dia, precisa esperar {0} horas antes de refazer furtos ou fazer upgrade agora para a Associação Pro para furtos e curtidas ilimitados.', 'Вы достигли максимального количества свипов в день, вам нужно подождать {0} часов, прежде чем вы сможете повторить свипы, ИЛИ перейти на Про членство Pro для неограниченного количества свайпов и лайков.', 'Ha alcanzado la cantidad máxima de swipes por día, tiene que esperar {0} horas antes de poder rehacer swipes, O actualícese ahora a Pro Membership para swipes y me gusta ilimitados.', 'Günde maksimum swipe amuontuna ulaştınız, swipeları tekrar yapabilmeniz için {0} saat beklemeniz, VEYA sınırsız swipe ve beğenileriniz için Pro üyeliğine şimdi yükseltmeniz gerekiyor.'),
(1175, '', NULL, 'your_payment_was_processed_successfully.', 'Your payment was successfully processed.', 'تمت معالجة دفعتك بنجاح.', 'Uw betaling is verwerkt.', 'Votre paiement a été traité avec succès.', 'Ihre Zahlung wurde erfolgreich verarbeitet.', 'Il tuo pagamento è stato elaborato correttamente.', 'Seu pagamento foi processado com sucesso.', 'Ваш платеж был успешно обработан.', 'Su pago fue procesado con éxito.', 'Ödemeniz başarıyla işlendi.'),
(1176, '', NULL, 'sms', 'SMS', 'رسالة قصيرة', 'sms', 'SMS', 'SMS', 'sms', 'SMS', 'смс', 'SMS', 'SMS'),
(1177, '', NULL, 'sent_you_message_', 'sent you a message!', 'ارسلت لك رساله!', 'heeft je een bericht gestuurd!', 'Vous a envoyé un message!', 'Schickte dir eine Nachricht!', 'ti ho mandato un messaggio!', 'lhe enviou uma mensagem!', 'отправил вам сообщение!', '¡Te envié un mensaje!', 'sana bir mesaj yolladım!'),
(1178, '', NULL, 'sent_you_a_message_', 'sent you a message!', '', 'heeft je een bericht gestuurd!', 'Vous a envoyé un message!', 'Schickte dir eine Nachricht!', 'ti ho mandato un messaggio!', 'lhe enviou uma mensagem!', 'отправил вам сообщение!', '¡Te envié un mensaje!', 'sana bir mesaj yolladım!'),
(1179, '', NULL, 'accept', 'Accept', 'قبول', 'Aanvaarden', 'Acceptez', 'Akzeptieren', 'Accettare', 'Aceitar', 'принимать', 'Aceptar', 'Kabul etmek'),
(1180, '', NULL, 'decline', 'Decline', 'انخفاض', 'Afwijzen', 'Déclin', 'Ablehnen', 'Declino', 'Declínio', 'снижение', 'Disminución', 'düşüş'),
(1181, '', NULL, 'calling', 'Calling', 'دعوة', 'Roeping', 'Appel', 'Berufung', 'chiamata', 'Chamando', 'призвание', 'Vocación', 'çağrı'),
(1182, '', NULL, 'please_wait_for_your_friend_answer.', 'Please wait for your friend\'s answer.', 'يرجى الانتظار للحصول على إجابة صديقك.', 'Wacht alstublieft op het antwoord van uw vriend.', 'S\'il vous plaît attendre la réponse de votre ami.', 'Bitte warten Sie auf die Antwort Ihres Freundes.', 'Per favore aspetta la risposta del tuo amico.', 'Por favor, aguarde a resposta do seu amigo.', 'Пожалуйста, подождите ответа вашего друга.', 'Por favor, espere la respuesta de su amigo.', 'Lütfen arkadaşınızın cevabını bekleyin.'),
(1183, '', NULL, 'no_answer', 'No answer', 'لا اجابة', 'Geen antwoord', 'Pas de réponse', 'Keine Antwort', 'Nessuna risposta', 'Sem resposta', 'Нет ответа', 'Sin respuesta', 'Cevapsız'),
(1184, '', NULL, 'please_try_again_later.', 'Please try again later.', 'الرجاء معاودة المحاولة في وقت لاحق.', 'Probeer het later opnieuw.', 'Veuillez réessayer plus tard.', 'Bitte versuchen Sie es später erneut.', 'Per favore riprova più tardi.', 'Por favor, tente novamente mais tarde.', 'Пожалуйста, попробуйте позже.', 'Por favor, inténtelo de nuevo más tarde.', 'Lütfen daha sonra tekrar deneyiniz.'),
(1185, '', NULL, 'new_video_call', 'New incoming video call', 'مكالمة فيديو واردة جديدة', 'Nieuw binnenkomend videogesprek', 'Nouvel appel vidéo entrant', 'Neu eingehender Videoanruf', 'Nuova videochiamata in arrivo', 'Nova chamada de vídeo recebida', 'Новый входящий видеозвонок', 'Nueva llamada de video entrante', 'Yeni gelen video görüşmesi'),
(1186, '', NULL, 'wants_to_video_chat_with_you.', 'wants to video chat with you.', 'يريد دردشة الفيديو معك.', 'wil videochatten met jou.', 'veut discuter par vidéo avec vous.', 'möchte mit dir video chatten.', 'vuole chat video con te.', 'quer bater papo por vídeo com você.', 'хочет с тобой видеочат', 'quiere chatear con usted', 'seninle görüntülü sohbet etmek istiyor.'),
(1187, '', NULL, 'call_declined', 'Call declined', 'تم رفض الاتصال', 'Oproep geweigerd', 'Appel refusé', 'Anruf abgelehnt', 'Chiamata rifiutata', 'Chamada recusada', 'Звонок отклонен', 'Llamada rechazada', 'Çağrı reddedildi'),
(1188, '', NULL, 'the_recipient_has_declined_the_call__please_try_again_later.', 'The recipient has declined the call, please try again later.', 'رفض المستلم الاتصال ، يرجى المحاولة مرة أخرى لاحقًا.', 'De ontvanger heeft de oproep geweigerd. Probeer het later opnieuw.', 'Le destinataire a refusé l\'appel. Veuillez réessayer ultérieurement.', 'Der Empfänger hat den Anruf abgelehnt. Bitte versuchen Sie es später erneut.', 'Il destinatario ha rifiutato la chiamata, riprova più tardi.', 'O destinatário recusou a chamada, tente novamente mais tarde.', 'Получатель отклонил вызов, повторите попытку позже.', 'El destinatario ha rechazado la llamada, inténtalo de nuevo más tarde.', 'Alıcı aramayı reddetti, lütfen daha sonra tekrar deneyin.'),
(1189, '', NULL, 'accept___start', 'Accept & Start', 'اقبل وابدأ', 'Accepteren en starten', 'Accepter et démarrer', 'Akzeptieren und starten', 'Accetta e inizia', 'Aceitar e começar', 'Принять и начать', 'Aceptar y empezar', 'Kabul Et ve Başlat'),
(1190, '', NULL, 'answered__', 'Answered!', 'أجاب!', 'Beantwoord!', 'Répondu!', 'Antwortete!', 'Risposto!', 'Respondidas!', 'Ответил!', '¡Contestado!', 'Yanıtlanmış!'),
(1191, '', NULL, 'please_wait..', 'Please wait..', 'ارجوك انتظر..', 'Even geduld aub..', 'S\'il vous plaît, attendez..', 'Warten Sie mal..', 'Attendere prego..', 'Por favor, espere..', 'Пожалуйста, подождите..', 'Por favor espera..', 'Lütfen bekle..'),
(1192, '', NULL, 'video_call', 'Video Call', 'مكالمة فيديو', 'Video-oproep', 'Appel vidéo', 'Videoanruf', 'Video chiamata', 'Video chamada', 'Видеозвонок', 'Videollamada', 'Görüntülü arama'),
(1193, '', NULL, 'new_audio_call', 'New incoming audio call', 'مكالمة صوتية واردة جديدة', 'Nieuwe inkomende audio-oproep', 'Nouvel appel audio entrant', 'Neuer eingehender Audioanruf', 'Nuova chiamata audio in arrivo', 'Nova chamada de áudio recebida', 'Новый входящий аудиозвонок', 'Nueva llamada de audio entrante', 'Yeni gelen sesli arama'),
(1194, '', NULL, 'wants_to_talk_with_you.', 'wants to talk with you.', 'يريد التحدث معك', 'wil met je praten.', 'veut parler avec toi.', 'will mit dir reden', 'vuole parlare con te', 'quer falar com você.', 'хочет поговорить с тобой.', 'quiere hablar contigo', 'seninle konuşmak istiyor'),
(1195, '', NULL, 'audio_call', 'Audio call', 'مكالمة صوتية', 'Audio-oproep', 'Appel audio', 'Audioanruf', 'Chiamata audio', 'Chamada de áudio', 'Аудио звонок', 'Llamada de audio', 'Sesli arama'),
(1196, '', NULL, 'talking_with', 'talking with', 'يتحدث مع', 'praten met', 'parler avec', 'sprechen mit', 'parlando con', 'conversando com', 'говорить с', 'Hablando con', 'ile konuşmak'),
(1197, '', NULL, 'this_website_uses_cookies_to_ensure_you_get_the_best_experience_on_our_website.', 'This website uses cookies to ensure you get the best experience on our website.', 'يستخدم هذا الموقع ملفات تعريف الارتباط لضمان حصولك على أفضل تجربة على موقعنا.', 'Deze website maakt gebruik van cookies om ervoor te zorgen dat u de beste ervaring op onze website krijgt.', 'Ce site utilise des cookies pour vous garantir la meilleure expérience sur notre site.', 'Diese Website verwendet Cookies, um sicherzustellen, dass Sie das beste Erlebnis auf unserer Website erhalten.', 'Questo sito Web utilizza i cookie per assicurarti di ottenere la migliore esperienza sul nostro sito web.', 'Este site usa cookies para garantir que você obtenha a melhor experiência em nosso site.', 'Этот веб-сайт использует куки-файлы, чтобы обеспечить вам максимальную отдачу от нашего веб-сайта.', 'Este sitio web utiliza cookies para garantizar que obtenga la mejor experiencia en nuestro sitio web.', 'Bu web sitesi, web sitemizde en iyi deneyimi yaşamanızı sağlamak için çerezleri kullanır.'),
(1198, '', NULL, 'got_it_', 'Got It!', 'فهمتك!', 'Begrepen!', 'Je l\'ai!', 'Ich habs!', 'Fatto!', 'Consegui!', 'Понял!', '¡Lo tengo!', 'Anladım!'),
(1199, '', NULL, 'learn_more', 'Learn More', 'أعرف أكثر', 'Kom meer te weten', 'Apprendre encore plus', 'Lern mehr', 'Per saperne di più', 'Saber mais', 'Учить больше', 'Aprende más', 'Daha fazla bilgi edin'),
(1200, '', NULL, 'no_result_found', 'No result found', 'لم يتم العثور على نتائج', 'geen resultaat gevonden', 'Aucun résultat trouvé', 'Keine Einträge gefunden', 'nessun risultato trovato', 'nenhum resultado encontrado', 'Результатов не найдено', 'No se han encontrado resultados', 'sonuç bulunamadı'),
(1201, '', NULL, 'send_gif', 'Send GIF', 'إرسال GIF', 'Verzend GIF', 'Envoyer un GIF', 'Senden Sie GIF', 'Invia GIF', 'Enviar GIF', 'Отправить GIF', 'Enviar GIF', 'GIF gönder'),
(1202, '', NULL, 'search_gifs', 'Search GIFs', 'بحث صور متحركة', 'Zoek GIF\'s', 'Rechercher des GIF', 'GIFs durchsuchen', 'Cerca GIF', 'Pesquisar GIFs', 'Поиск GIF-файлов', 'Buscar GIFs', 'GIF’lerde ara'),
(1203, '', NULL, 'sticker_added', 'Sticker added', 'وأضاف ملصقا', 'Sticker toegevoegd', 'Sticker ajouté', 'Aufkleber hinzugefügt', 'Sticker aggiunto', 'Etiqueta adicionada', 'Стикер добавлен', 'Pegatina añadida', 'Etiket eklendi'),
(1204, '', NULL, 'your_phone_number_is_required.', 'Your phone number is required.', 'رقم هاتفك مطلوب.', 'Uw telefoonnummer is verplicht', 'Votre numéro de téléphone est requis.', 'Ihre Telefonnummer ist erforderlich.', 'Il tuo numero di telefono è richiesto.', 'Seu número de telefone é obrigatório.', 'Ваш номер телефона требуется.', 'Se requiere su número de teléfono.', 'Telefon numaranız gereklidir.'),
(1205, '', NULL, 'select_your_country.', 'Please select your country.', 'يرجى اختيار بلدك.', 'Selecteer uw land alstublieft.', 'S\'il vous plaît sélectionnez votre pays.', 'Bitte wählen Sie Ihr Land.', 'Selezionare il proprio paese.', 'Por favor selecione seu país.', 'Пожалуйста, выберите вашу страну.', 'Por favor seleccione su país.', 'Lütfen ülkenizi seçiniz.'),
(1206, '', NULL, 'select_your_birth_date.', 'Please select your birthday.', 'يرجى اختيار عيد ميلادك.', 'Selecteer alstublieft uw geboortedatum', 'S\'il vous plaît sélectionnez votre anniversaire.', 'Bitte wählen Sie Ihren Geburtstag aus.', 'Per favore seleziona il tuo compleanno.', 'Por favor, selecione seu aniversário.', 'Пожалуйста, выберите свой день рождения.', 'Por favor seleccione su cumpleaños.', 'Lütfen doğum gününü seç.'),
(1207, '', NULL, 'my_location', 'My Location', 'موقعي', 'Mijn locatie', 'Ma position', 'Mein Standort', 'La mia posizione', 'Minha localização', 'Мое местонахождение', 'Mi ubicacion', 'Benim konumum'),
(1208, '', NULL, 'or', 'OR', 'أو', 'OF', 'OU', 'ODER', 'O', 'OU', 'ИЛИ ЖЕ', 'O', 'VEYA'),
(1209, '', NULL, 'instagram', 'Instagram', 'إينستاجرام', 'Instagram', 'Instagram', 'Instagram', 'Instagram', 'Instagram', 'Instagram', 'Instagram', 'Instagram'),
(1210, '', NULL, 'disable', 'disable', 'تعطيل', 'onbruikbaar maken', 'désactiver', 'deaktivieren', 'disattivare', 'desativar', 'запрещать', 'inhabilitar', 'devre dışı'),
(1211, '', NULL, 'enable', 'enable', 'مكن', 'in staat stellen', 'activer', 'aktivieren', 'abilitare', 'habilitar', 'включить', 'habilitar', 'etkinleştirme'),
(1212, '', NULL, 'travel_to_another_country__and_relocate_', 'Travel to another country, and relocate!', 'السفر إلى بلد آخر ، والانتقال!', 'Reis naar een ander land en verplaats je!', 'Voyagez dans un autre pays et déplacez-vous!', 'Reisen Sie in ein anderes Land und ziehen Sie um!', 'Viaggia in un altro paese e trasferisci!', 'Viaje para outro país e mude de lugar!', 'Отправляйся в другую страну и переезжай!', '¡Viaja a otro país y múdate!', 'Başka bir ülkeye seyahat et ve yerini değiştir!'),
(1213, 'gender', NULL, '4525', 'Male', 'الذكر', 'Mannetje', 'Mâle', 'Männlich', 'Maschio', 'Masculino', 'мужчина', 'Masculino', 'Erkek'),
(1214, 'gender', NULL, '4526', 'Female', 'إناثا', 'Vrouw', 'Femelle', 'Weiblich', 'Femmina', 'Fêmea', 'женский', 'Hembra', 'Kadın'),
(1215, '', NULL, 'about_you', 'About You', 'حولك', 'Over jou', 'Au propos de vous', 'Über dich', 'A proposito di te', 'Sobre você', 'О вас', 'Acerca de ti', 'Senin hakkında'),
(1216, '', NULL, 'km', 'km', 'كم', 'km', 'km', 'km', 'km', 'km', 'км', 'km', 'km'),
(1217, '', NULL, 'message_requests', 'Message requests', 'طلبات الرسائل', 'Berichtverzoeken', 'Demandes de message', 'Nachrichtenanfragen', 'Richieste di messaggi', 'Pedidos de mensagem', 'Запросы сообщений', 'Peticiones de mensajes', 'İleti İstekler'),
(1218, '', NULL, 'all_conversations', 'All conversations', 'كل المحادثات', 'Alle gesprekken', 'Toutes les conversations', 'Alle Gespräche', 'Tutte le conversazioni', 'Todas as conversas', 'Все разговоры', 'Todas las conversaciones', 'Tüm konuşmalar'),
(1219, '', NULL, 'you_can_chat_with_this_user_after', 'You can chat with this profile after', 'يمكنك الدردشة مع هذا الملف الشخصي بعد', 'Je kunt na dit chatten met dit profiel', 'Vous pouvez discuter avec ce profil après', 'Sie können danach mit diesem Profil chatten', 'Puoi chattare con questo profilo dopo', 'Você pode conversar com este perfil depois', 'Вы можете общаться с этим профилем после', 'Puedes chatear con este perfil después', 'Sonra bu profille sohbet edebilirsiniz'),
(1220, '', NULL, 'hours.', 'hours.', 'ساعات.', 'uur.', 'heures.', 'Std.', 'ore.', 'horas.', 'ч.', 'horas', 'saatler.'),
(1221, '', NULL, 'this_user_decline_your_chat_before_so_you_can_chat_with_this_user_after', 'This user has declined your chat before, you\'ll be able to chat with this user after', 'رفض هذا المستخدم الدردشة من قبل ، وستتمكن من الدردشة مع هذا المستخدم بعد', 'Deze gebruiker heeft je chat eerder afgewezen, je kunt hierna met deze gebruiker chatten', 'Cet utilisateur a déjà refusé votre chat, vous pourrez discuter avec lui après', 'Dieser Benutzer hat Ihren Chat zuvor abgelehnt. Danach können Sie mit diesem Benutzer chatten', 'Questo utente ha rifiutato la chat in precedenza, dopo potrai chattare con questo utente', 'Este utilizador recusou o seu chat antes, poderá conversar com este utilizador depois', 'Этот пользователь отклонил ваш чат раньше, вы сможете общаться с этим пользователем после того, как', 'Este usuario ha rechazado tu chat antes, podrás chatear con este usuario después de', 'Bu kullanıcı daha önce sohbeti reddetti, daha sonra bu kullanıcıyla sohbet edebileceksiniz'),
(1222, '', NULL, 'active', 'active', 'نشيط', 'actief', 'actif', 'aktiv', 'attivo', 'ativo', 'активный', 'activo', 'aktif'),
(1223, '', NULL, 'declined', 'Declined', 'رفض', 'Afgewezen', 'Diminué', 'Abgelehnt', 'rifiutato', 'Recusado', 'Отклонено', 'Rechazado', 'Reddedilen'),
(1224, '', NULL, 'pending', 'Pending', 'قيد الانتظار', 'In afwachting', 'en attendant', 'steht aus', 'in attesa di', 'Pendente', 'в ожидании', 'Pendiente', 'kadar'),
(1225, '', NULL, 'night_mode', 'Night mode', 'وضع الليل', 'Nachtstand', 'Mode nuit', 'Nacht-Modus', 'Modalità notturna', 'Modo noturno', 'Ночной режим', 'Modo nocturno', 'Gece modu'),
(1226, '', NULL, 'day_mode', 'Day mode', 'وضع اليوم', 'Dagmodus', 'Mode jour', 'Tagesmodus', 'Modalità giorno', 'Modo dia', 'Дневной режим', 'Modo día', 'Gün modu'),
(1227, '', NULL, 'we___ll_be_back_soon_', 'We’ll be back soon!', 'سنعود قريبا!', 'We zullen snel terug zijn!', 'Nous reviendrons bientôt!', 'Wir werden bald zurück sein!', 'Torneremo presto!', 'Voltaremos em breve!', 'Мы скоро вернемся!', '¡Estaremos de vuelta pronto!', 'Yakında döneceğiz!'),
(1228, '', NULL, 'sorry_for_the_inconvenience_but_we_rsquo_re_performing_some_maintenance_at_the_moment._if_you_need_help_you_can_always', 'Sorry for the inconvenience but we\'re performing some maintenance at the moment. If you need help you can always', 'نأسف للإزعاج لكننا نقوم ببعض الصيانة في الوقت الحالي. إذا كنت بحاجة إلى مساعدة يمكنك دائما', 'Sorry voor het ongemak maar we voeren momenteel wat onderhoud uit. Als je hulp nodig hebt, kan dat altijd', 'Désolé pour le désagrément, mais nous effectuons actuellement des travaux de maintenance. Si vous avez besoin d\'aide, vous pouvez toujours', 'Wir entschuldigen uns für die Unannehmlichkeiten, aber wir führen zurzeit einige Wartungsarbeiten durch. Wenn Sie Hilfe brauchen, können Sie das immer tun', 'Ci scusiamo per l\'inconveniente, ma al momento stiamo eseguendo degli interventi di manutenzione. Se hai bisogno di aiuto puoi sempre', 'Desculpe pela inconveniência, mas estamos realizando alguma manutenção no momento. Se você precisar de ajuda, você sempre pode', 'Приносим извинения за неудобства, но в настоящее время мы проводим техническое обслуживание. Если вам нужна помощь, вы всегда можете', 'Disculpe las molestias, pero estamos realizando algunas tareas de mantenimiento en este momento. Si necesitas ayuda siempre puedes', 'Verdiğimiz rahatsızlıktan dolayı üzgünüz, ancak şu anda biraz bakım yapıyoruz. Yardıma ihtiyacınız olursa her zaman'),
(1229, '', NULL, 'otherwise_we_rsquo_ll_be_back_online_shortly_', 'otherwise we\'ll be back online shortly!', 'وإلا سنعود عبر الإنترنت قريبًا!', 'anders zijn we binnenkort weer online!', 'sinon nous serons de retour en ligne sous peu!', 'Ansonsten sind wir in Kürze wieder online!', 'altrimenti torneremo online presto!', 'caso contrário, estaremos de volta online em breve!', 'в противном случае мы скоро вернемся онлайн!', 'De lo contrario, volveremos a estar en línea pronto.', 'yoksa kısa süre sonra tekrar çevrimiçi oluruz!'),
(1230, '', NULL, 'declined_your_message_request_', 'declined your message request!', 'رفض طلب رسالتك!', 'heeft uw berichtverzoek geweigerd!', 'a refusé votre demande de message!', 'Ihre Nachricht wurde abgelehnt!', 'rifiutato la tua richiesta di messaggio!', 'recusou o seu pedido de mensagem!', 'отклонил ваш запрос на сообщение!', 'rechazó su solicitud de mensaje!', 'mesaj isteğini reddetti!'),
(1231, '', NULL, 'accepted_your_message_request_', 'accepted your message request!', 'قبلت طلب رسالتك!', 'accepteerde uw berichtaanvraag!', 'accepté votre demande de message!', 'Ihre Anfrage angenommen!', 'accettato la tua richiesta di messaggio!', 'aceitou o seu pedido de mensagem!', 'принял ваш запрос на сообщение!', 'aceptó su solicitud de mensaje!', 'mesaj isteğini kabul etti!'),
(1232, '', NULL, 'we_have_rejected_your_bank_transfer__please_contact_us_for_more_details', 'We have rejected your bank transfer, please contact us for more details.', 'لقد رفضنا تحويلك المصرفي ، يرجى الاتصال بنا للحصول على مزيد من التفاصيل.', 'We hebben uw overboeking geweigerd. Neem contact met ons op voor meer informatie.', 'Nous avons refusé votre virement bancaire, veuillez nous contacter pour plus de détails.', 'Wir haben Ihre Banküberweisung abgelehnt. Bitte kontaktieren Sie uns für weitere Informationen.', 'Abbiamo rifiutato il tuo bonifico bancario, ti preghiamo di contattarci per ulteriori dettagli.', 'Rejeitamos sua transferência bancária. Entre em contato para mais detalhes.', 'Мы отклонили ваш банковский перевод, пожалуйста, свяжитесь с нами для получения более подробной информации.', 'Hemos rechazado su transferencia bancaria, póngase en contacto con nosotros para obtener más detalles.', 'Banka havalenizi reddettik, daha fazla ayrıntı için lütfen bizimle iletişime geçin.'),
(1233, '', NULL, 'we_approved_your_bank_transfer_of__d_', 'We approved your bank transfer of %d!', 'لقد وافقنا على تحويلك المصرفي لـ ٪d!', 'We hebben uw overboeking van %d goedgekeurd!', 'Nous avons approuvé votre virement bancaire de %d!', 'Wir haben Ihrer Überweisung von %d zugestimmt!', 'Abbiamo approvato il tuo bonifico bancario di %d!', 'Nós aprovamos sua transferência bancária de %d!', 'Мы одобрили ваш банковский перевод %d!', '¡Aprobamos su transferencia bancaria de %d!', '%d banka havalenizi onayladık!'),
(1234, '', NULL, 'note', 'Note', 'ملحوظة', 'Notitie', 'Remarque', 'Hinweis', 'Nota', 'Nota', 'Заметка', 'Nota', 'Not'),
(1235, '', NULL, 'delete_chat', 'Delete chat', 'حذف الدردشة', 'Verwijder chat', 'Supprimer le chat', 'Chat löschen', 'Elimina chat', 'Excluir bate-papo', 'Удалить чат', 'Eliminar chat', 'Sohbeti sil'),
(1236, '', NULL, 'your_x3_matches_will_expire_in', 'Your x3 matches will expire in', 'ستنتهي صلاحية مباريات x3 الخاصة بك', 'Je x3-wedstrijden verlopen in', 'Vos matchs x3 expireront dans', 'Ihre x3-Matches verfallen in', 'Le tue partite x3 scadranno', 'Suas partidas x3 expiram em', 'Ваши матчи х3 истекают через', 'Tus coincidencias x3 caducarán en', 'X3 eşleşmelerinizin süresinin dolması'),
(1237, '', NULL, 'to_get_your_profile_verified_you_have_to_verify_these.', 'To get your profile verified you have to verify these.', 'للتحقق من ملف التعريف الخاص بك ، يجب عليك التحقق من ذلك.', 'Om je profiel geverifieerd te krijgen, moet je deze verifiëren.', 'Pour que votre profil soit vérifié, vous devez les vérifier.', 'Um Ihr Profil bestätigen zu lassen, müssen Sie diese überprüfen.', 'Per verificare il tuo profilo devi verificarlo.', 'Para ter seu perfil verificado, você precisa verificar isso.', 'Чтобы подтвердить свой профиль, вы должны подтвердить это.', 'Para verificar tu perfil tienes que verificar estos.', 'Profilinizi doğrulamak için bunları doğrulamanız gerekir.'),
(1238, '', NULL, 'upload_at_least_5_image.', 'Upload at least 5 image.', 'قم بتحميل 5 صورة على الأقل.', 'Upload minimaal 5 afbeeldingen.', 'Téléchargez au moins 5 images.', 'Laden Sie mindestens 5 Bilder hoch.', 'Carica almeno 5 immagini.', 'Carregue pelo menos 5 imagens.', 'Загрузите как минимум 5 изображений.', 'Sube al menos 5 imágenes.', 'En az 5 resim yükleyin.'),
(1239, '', NULL, 'unblock', 'Unblock', 'رفع الحظر', 'deblokkeren', 'Débloquer', 'Blockierung aufheben', 'Sbloccare', 'Desbloquear', 'открыть', 'Desatascar', 'engeli kaldırmak'),
(1240, '', NULL, 'phone_number__e.g__90..', 'Phone number, e.g +90..', 'رقم الهاتف ، على سبيل المثال +90 ..', 'Telefoonnummer, bijvoorbeeld +90 ..', 'Numéro de téléphone, par exemple +90 ..', 'Telefonnummer, z. B. +90 ..', 'Numero di telefono, ad esempio +90 ..', 'Número de telefone, por exemplo, +90.', 'Номер телефона, например, +90 ..', 'Número de teléfono, p. Ej. +90 ..', 'Telefon numarası, örneğin, +90 ..'),
(1241, '', NULL, 'phone_verification_needed', 'Phone verification required', 'التحقق من الهاتف مطلوب', 'Telefonische verificatie vereist', 'Vérification téléphonique requise', 'Telefonische Bestätigung erforderlich', 'È richiesta la verifica del telefono', 'Confirmação de telefone necessária', 'Требуется проверка телефона', 'Se requiere verificación por teléfono', 'Telefon doğrulaması gerekli'),
(1242, '', NULL, 'phone', 'Phone', 'هاتف', 'Telefoon', 'Téléphone', 'Telefon', 'Telefono', 'telefone', 'Телефон', 'Teléfono', 'Telefon'),
(1243, '', NULL, 'send_otp', 'Send OTP', 'إرسال OTP', 'Stuur OTP', 'Envoyer OTP', 'OTP senden', 'Invia OTP', 'Enviar OTP', 'Отправить OTP', 'Enviar OTP', 'OTP gönder'),
(1244, '', NULL, 'phone_activiation_', 'Phone activiation,', 'تفعيل الهاتف ،', 'Telefoonactivatie,', 'Activation du téléphone,', 'Telefonaktivierung,', 'Attivazione del telefono,', 'Ativação por telefone,', 'Активация телефона,', 'Activación del teléfono,', 'Telefon aktivasyonu'),
(1245, '', NULL, 'please_enter_the_verification_code_sent_to_your_phone', 'Please enter the verification code that was sent to your phone. ', 'الرجاء إدخال رمز التحقق الذي تم إرساله إلى هاتفك.', 'Voer de verificatiecode in die naar uw telefoon is verzonden.', 'Veuillez entrer le code de vérification qui a été envoyé sur votre téléphone.', 'Bitte geben Sie den Bestätigungscode ein, der an Ihr Telefon gesendet wurde.', 'Inserisci il codice di verifica che è stato inviato al tuo telefono.', 'Digite o código de verificação que foi enviado para o seu telefone.', 'Пожалуйста, введите проверочный код, который был отправлен на ваш телефон.', 'Por favor ingrese el código de verificación que fue enviado a su teléfono.', 'Lütfen telefonunuza gönderilen doğrulama kodunu girin.'),
(1246, '', NULL, 'resend', 'Re-send', 'إعادة إرسال', 'Opnieuw versturen', 'Renvoyer', 'Erneut senden', 'Re-send', 'Reenviar', 'Отправить', 'Reenviar', 'Yeniden gönder'),
(1247, '', NULL, 'please_verify_your_email_address', 'Please verify your email address.', 'يرجى التحقق من عنوان البريد الإلكتروني الخاص بك.', 'Verifieer uw email adres alstublieft.', 'Veuillez vérifier votre adresse e-mail.', 'Bitte bestätige deine Email Adresse.', 'Per cortesia verifichi il suo indirizzo email.', 'Por favor verifique seu endereço de email.', 'Пожалуйста, подтвердите ваш адрес электронной почты.', 'Por favor verifique su dirección de correo electrónico.', 'Lütfen email adresini doğrula.'),
(1248, '', NULL, 'error_while_sending_an_sms__please_try_again_later.', 'Error while sending the SMS, please try again later.', 'خطأ أثناء إرسال الرسائل القصيرة ، يرجى المحاولة مرة أخرى لاحقًا.', 'Fout tijdens het verzenden van de sms, probeer het later opnieuw.', 'Erreur lors de l\'envoi du SMS, veuillez réessayer ultérieurement.', 'Fehler beim Senden der SMS. Bitte versuchen Sie es später erneut.', 'Errore durante l\'invio dell\'SMS, riprova più tardi.', 'Erro ao enviar o SMS, tente novamente mais tarde.', 'Ошибка при отправке SMS, повторите попытку позже.', 'Error al enviar el SMS, inténtalo de nuevo más tarde.', 'SMS gönderilirken hata oluştu, lütfen daha sonra tekrar deneyin.'),
(1249, '', NULL, 'error_while_submitting_form.', 'Error while submitting form.', 'خطأ أثناء تقديم النموذج.', 'Fout bij het verzenden van het formulier.', 'Erreur lors de la soumission du formulaire.', 'Fehler beim Senden des Formulars', 'Errore durante l\'invio del modulo.', 'Erro ao enviar o formulário.', 'Ошибка при отправке формы.', 'Error al enviar el formulario.', 'Form gönderilirken hata oluştu.'),
(1250, '', NULL, 'email_verification_needed', 'Email verification required', 'التحقق من البريد الإلكتروني مطلوب', 'E-mailverificatie vereist', 'Vérification d\'email requise', 'E-Mail-Bestätigung erforderlich', 'Richiesta la verifica tramite email', 'Confirmação de email obrigatória', 'Требуется подтверждение по электронной почте', 'Se requiere verificación por correo electrónico', 'E-posta doğrulaması gerekli'),
(1251, '', NULL, 'email_activiation_', 'Email activiation,', 'تفعيل البريد الإلكتروني ،', 'E-mailactivatie,', 'Activation du courrier électronique,', 'E-Mail-Aktivierung', 'Attivazione dell\'email,', 'Ativação de email,', 'Активация электронной почты,', 'Activación de correo electrónico,', 'E-posta aktivasyonu,'),
(1252, '', NULL, 'please_enter_the_verification_code_sent_to_your_email', 'Please enter the verification code that was sent to your E-mail.', 'الرجاء إدخال رمز التحقق الذي تم إرساله إلى بريدك الإلكتروني.', 'Voer de verificatiecode in die naar uw e-mailadres is verzonden.', 'Veuillez entrer le code de vérification qui a été envoyé à votre adresse e-mail.', 'Bitte geben Sie den Bestätigungscode ein, der an Ihre E-Mail gesendet wurde.', 'Inserisci il codice di verifica che è stato inviato alla tua e-mail.', 'Por favor insira o código de verificação que foi enviado para o seu E-mail.', 'Пожалуйста, введите проверочный код, который был отправлен на ваш E-mail.', 'Por favor ingrese el código de verificación que fue enviado a su correo electrónico.', 'Lütfen E-postanıza gönderilen doğrulama kodunu girin.'),
(1253, '', NULL, 'video_and_audio_calls_to_all_users', 'Create unlimited video and audio calls.', 'إنشاء عدد غير محدود من مكالمات الفيديو والصوت.', 'Creëer onbeperkt video- en audio-oproepen.', 'Créez des appels vidéo et audio illimités.', 'Erstellen Sie unbegrenzte Video- und Audioanrufe.', 'Crea chiamate video e audio illimitate.', 'Crie chamadas ilimitadas de vídeo e áudio.', 'Создавайте неограниченные видео и аудио звонки.', 'Crea llamadas ilimitadas de video y audio.', 'Sınırsız video ve sesli arama oluşturun.'),
(1254, '', NULL, 'latest_users', 'Latest Users', 'أحدث المستخدمين', 'Laatste gebruikers', 'Derniers utilisateurs', 'Neueste Benutzer', 'Ultimi utenti', 'Usuários mais recentes', 'Последние пользователи', 'Últimos usuarios', 'Son kullanıcılar'),
(1255, '', NULL, 'wanna_get_more__get_new_stickers_for', 'Wanna get more? get new stickers for', 'هل تريد الحصول على المزيد؟ الحصول على ملصقات جديدة ل', 'Wil je meer krijgen? krijg nieuwe stickers voor', 'Tu veux en avoir plus? obtenir de nouveaux autocollants pour', 'Willst du mehr bekommen? Bekommen Sie neue Aufkleber für', 'Vuoi ottenere di più? ottenere nuovi adesivi per', 'Queres mais? obter novos adesivos para', 'Хотите получить больше? получить новые наклейки для', '¿Quieres conseguir más? conseguir nuevas pegatinas para', 'Daha fazla almak ister misin? için yeni çıkartmalar al'),
(1256, '', NULL, 'this_image_now_is_private.', 'This photo is private.', 'هذه الصورة خاصة.', 'Deze foto is privé.', 'Cette photo est privée.', 'Dieses Foto ist privat.', 'Questa foto è privata.', 'Esta foto é privada.', 'Это частное фото', 'Esta foto es privada.', 'Bu fotoğraf özel.'),
(1257, '', NULL, 'emails', 'Emails', 'رسائل البريد الإلكتروني', 'emails', 'Courriels', 'E-Mails', 'Messaggi di posta elettronica', 'Emails', 'Сообщения электронной почты', 'Correos electronicos', 'E-postalar'),
(1258, '', NULL, 'email_me_when_someone_views_your_profile', 'Email me when someone views my profile.', 'البريد الإلكتروني لي عندما شخص ما ينظر ملف التعريف الخاص بي.', 'E-mail mij als iemand mijn profiel bekijkt.', 'Envoyez-moi un email quand quelqu\'un regarde mon profil.', 'Mailen Sie mir, wenn jemand mein Profil anzeigt.', 'Inviami un\'email quando qualcuno visualizza il mio profilo.', 'Envie-me um email quando alguém visualizar meu perfil.', 'Напишите мне, когда кто-то просматривает мой профиль.', 'Envíame un correo electrónico cuando alguien vea mi perfil.', 'Birisi profilimi görüntülediğinde bana e-posta gönder.'),
(1259, '', NULL, 'email_me_when_you_get_a_new_message', 'Email me when I get a new message.', 'البريد الإلكتروني لي عندما أتلقى رسالة جديدة.', 'E-mail mij als ik een nieuw bericht ontvang.', 'Email moi quand je reçois un nouveau message.', 'Senden Sie mir eine E-Mail, wenn ich eine neue Nachricht erhalte.', 'Mandami una email quando ricevo un nuovo messaggio.', 'Envie-me um email quando receber uma nova mensagem.', 'Напишите мне, когда я получу новое сообщение.', 'Envíeme un correo electrónico cuando reciba un nuevo mensaje.', 'Yeni bir mesaj aldığımda bana e-posta gönder.'),
(1260, '', NULL, 'email_me_when_someone_like_your_profile', 'Email me when someone like me.', 'البريد الإلكتروني لي عندما شخص مثلي.', 'E-mail mij als iemand zoals ik.', 'Email moi quand quelqu\'un comme moi.', 'Mailen Sie mir, wenn mir jemand gefällt.', 'Mandami una mail quando qualcuno come me.', 'Envie-me um email quando alguém como eu.', 'Напишите мне, когда кто-то, как я.', 'Envíame un correo electrónico cuando alguien como yo.', 'Birisi benim gibi olduğunda bana e-posta gönder.'),
(1261, '', NULL, 'email_me_purchase_notifications', 'Email me my purchase notifications.', 'أرسل لي إخطارات الشراء الخاصة بي.', 'Stuur me een e-mail met mijn aankoopmeldingen.', 'Envoyez-moi mes notifications d\'achat.', 'Senden Sie mir meine Kaufbenachrichtigungen per E-Mail.', 'Inviami le mie notifiche di acquisto via email.', 'Envie-me minhas notificações de compra.', 'Отправьте мне по электронной почте мои уведомления о покупке.', 'Envíeme un correo electrónico mis notificaciones de compra.', 'Satın alma bildirimlerimi e-postayla gönder.');
INSERT INTO `langs` (`id`, `ref`, `options`, `lang_key`, `english`, `arabic`, `dutch`, `french`, `german`, `italian`, `portuguese`, `russian`, `spanish`, `turkish`) VALUES
(1262, '', NULL, 'email_me_special_offers___promotions', 'Email me special offers & promotions.', 'أرسل لي العروض الخاصة & amp؛ الترقيات.', 'E-mail mij speciale aanbiedingen & promoties.', 'Envoyez-moi des offres spéciales & promotions.', 'Mailen Sie mir spezielle Angebote & Promotionen.', 'Inviami le offerte speciali & promozioni.', 'Envie-me um email com ofertas especiais & promoções.', 'Напишите мне специальные предложения & промо акции.', 'Envíeme un correo electrónico ofertas especiales & promociones', 'Bana özel teklifleri e-postayla gönder & promosyonlar.'),
(1263, '', NULL, 'email_me_feature_announcements', 'Email me future announcements.', 'أرسل لي إعلانات المستقبل.', 'E-mail mij toekomstige aankondigingen.', 'Envoyez-moi des annonces futures.', 'Mailen Sie mir zukünftige Ankündigungen.', 'Inviami annunci futuri.', 'Envie-me futuros anúncios.', 'Пишите мне будущие объявления.', 'Envíeme un correo electrónico futuros anuncios.', 'Bana gelecekteki duyuruları e-postayla gönder.'),
(1264, '', NULL, 'email_me_when_someone_like_my_profile', 'Email me when someone like my profile.', 'البريد الإلكتروني لي عندما شخص مثل ملف التعريف الخاص بي.', 'E-mail mij als iemand mijn profiel leuk vindt.', 'Envoyez-moi un courriel lorsque quelqu\'un aime mon profil.', 'Mailen Sie mir, wenn jemand mein Profil mag.', 'Inviami un\'email quando qualcuno come il mio profilo.', 'Envie-me um email quando alguém gostar do meu perfil.', 'Напишите мне, когда кому-то понравится мой профиль.', 'Envíame un correo electrónico cuando alguien como mi perfil.', 'Birisi profilimden hoşlandığında bana e-posta gönder.'),
(1265, '', NULL, 'email_me_when_i_get_new_gift', 'Email me when I get a new gift.', 'أرسل لي رسالة إلكترونية عندما أحصل على هدية جديدة.', 'E-mail mij als ik een nieuw cadeau ontvang.', 'Email moi quand je reçois un nouveau cadeau.', 'Senden Sie mir eine E-Mail, wenn ich ein neues Geschenk bekomme.', 'Mandami una email quando ricevo un nuovo regalo.', 'Envie-me um email quando eu receber um novo presente.', 'Напишите мне, когда я получу новый подарок.', 'Envíame un correo electrónico cuando reciba un nuevo regalo.', 'Yeni bir hediye aldığımda bana e-posta gönder.'),
(1266, '', NULL, 'email_me_when_i_get_new_match', 'Email me when I get a new match.', 'أرسل لي رسالة إلكترونية عندما أحصل على تطابق جديد.', 'E-mail mij als ik een nieuwe match krijg.', 'Ecrivez-moi quand je reçois un nouveau match.', 'Senden Sie mir eine E-Mail, wenn ich ein neues Spiel bekomme.', 'Mandami una email quando avrò una nuova partita.', 'Envie-me um email quando obtiver um novo jogo.', 'Напишите мне, когда я получу новый матч.', 'Envíame un correo electrónico cuando reciba un nuevo partido.', 'Yeni bir eşleşme olduğunda bana e-posta gönder.'),
(1267, '', NULL, 'email_me_when_i_get_new_chat_request', 'Email me when I get a new chat request.', 'أرسل لي رسالة إلكترونية عندما أحصل على طلب دردشة جديد.', 'E-mail mij als ik een nieuw chatverzoek ontvang.', 'Envoyez-moi un email quand je reçois une nouvelle demande de chat.', 'Senden Sie mir eine E-Mail, wenn ich eine neue Chat-Anfrage bekomme.', 'Mandami una email quando avrò una nuova richiesta di chat.', 'Envie-me um email quando obtiver um novo pedido de chat.', 'Напишите мне, когда я получу новый запрос чата.', 'Envíeme un correo electrónico cuando reciba una nueva solicitud de chat.', 'Yeni bir sohbet isteği aldığımda bana e-posta gönder.'),
(1268, '', NULL, 'why__0__is_best', 'Why {0} is Best', 'لماذا {0} هو الأفضل', 'Waarom {0} het beste is', 'Pourquoi {0} est le meilleur', 'Warum ist {0} am besten?', 'Perché {0} è il migliore', 'Por que {0} é o melhor', 'Почему {0} лучше', 'Porque {0} es mejor', '{0} Neden En İyi?'),
(1269, '', NULL, 'your_account_is_safe_on__0_._we_never_share_your_data_with_third_party.', 'Your account is safe on {0}. We never share your data with third party.', 'حسابك آمن في {0}. نحن لا نشارك بياناتك مع طرف ثالث.', 'Je account is veilig op {0}. Wij delen uw gegevens nooit met derden.', 'Votre compte est en sécurité le {0}. Nous ne partageons jamais vos données avec des tiers.', 'Ihr Konto ist am {0} sicher. Wir geben Ihre Daten niemals an Dritte weiter.', 'Il tuo account è sicuro su {0}. Non condividiamo mai i tuoi dati con terze parti.', 'Sua conta está segura em {0}. Nós nunca compartilhamos seus dados com terceiros.', 'Ваш аккаунт в безопасности {0}. Мы никогда не передаем ваши данные третьим лицам.', 'Su cuenta está segura en {0}. Nunca compartimos sus datos con terceros.', 'Hesabınız {0} tarihinde güvende. Verilerinizi asla üçüncü taraflarla paylaşmayız.'),
(1270, '', NULL, 'connect_with_your_perfect_soulmate_here__on__0_.', 'Connect with your perfect Soulmate here, on {0}.', 'تواصل مع صديقك المثالي هنا ، على {0}.', 'Maak hier verbinding met je perfecte Soulmate, op {0}.', 'Connectez-vous avec votre âme sœur parfaite ici, sur {0}.', 'Verbinde dich hier mit deinem perfekten Soulmate auf {0}.', 'Connettiti con la tua anima gemella perfetta qui, su {0}.', 'Conecte-se com seu Soulmate perfeito aqui, em {0}.', 'Свяжись со своей идеальной родственной душой здесь, {0}.', 'Conecta con tu alma gemela perfecta aquí, en {0}.', '{0} adresindeki mükemmel Soulmate\'inize buradan bağlanın.'),
(1271, '', NULL, 'verification', 'Verification', 'التحقق', 'Verificatie', 'Vérification', 'Nachprüfung', 'Verifica', 'Verificação', 'верификация', 'Verificación', 'Doğrulama'),
(1272, '', NULL, 'you_have_been_exceed_the_activation_request_limit.', 'You have exceeded the activation request limit.', 'لقد تجاوزت حد طلب التنشيط.', 'U hebt de activeringsverzoeklimiet overschreden.', 'Vous avez dépassé la limite de demande d\'activation.', 'Sie haben das Aktivierungsanforderungslimit überschritten.', 'Hai superato il limite della richiesta di attivazione.', 'Você excedeu o limite de solicitações de ativação.', 'Вы превысили лимит запросов на активацию.', 'Has superado el límite de solicitud de activación.', 'Etkinleştirme isteği sınırını aştınız.'),
(1273, '', NULL, 'you_have_to_wait', 'You have to wait', 'عليك الانتظار', 'Je moet wachten', 'Vous devez attendre', 'Du mußt warten', 'Devi aspettare', 'Você tem que esperar', 'Вам придется подождать', 'Tienes que esperar', 'Beklemek zorundasın'),
(1274, '', NULL, 'minutes_before_you_try_to_activate_again.', 'minutes before you try to activate again.', 'قبل دقائق من محاولة التنشيط مرة أخرى.', 'minuten voordat u opnieuw probeert te activeren.', 'minutes avant d\'essayer d\'activer à nouveau.', 'Minuten, bevor Sie versuchen, erneut zu aktivieren.', 'minuti prima di provare ad attivare di nuovo.', 'minutos antes de tentar ativar novamente.', 'минут, прежде чем пытаться активировать снова.', 'Minutos antes de que intentes activar de nuevo.', 'tekrar etkinleştirmeyi denemeden birkaç dakika önce.'),
(1275, '', NULL, 'we_have_rejected_your_bank_transfer__please_contact_us_for_more_details.', 'We have rejected your bank transfer, please contact us for more details.', 'لقد رفضنا تحويلك المصرفي ، يرجى الاتصال بنا للحصول على مزيد من التفاصيل.', 'We hebben uw overboeking afgewezen. Neem contact met ons op voor meer informatie.', 'Nous avons refusé votre virement bancaire, veuillez nous contacter pour plus de détails.', 'Wir haben Ihre Überweisung abgelehnt. Bitte kontaktieren Sie uns für weitere Informationen.', 'Abbiamo rifiutato il tuo bonifico bancario, ti preghiamo di contattarci per maggiori dettagli.', 'Rejeitamos sua transferência bancária. Entre em contato para mais detalhes.', 'Мы отклонили ваш банковский перевод, пожалуйста, свяжитесь с нами для получения более подробной информации.', 'Hemos rechazado su transferencia bancaria, contáctenos para obtener más detalles.', 'Banka havalenizi reddettik, daha fazla bilgi için lütfen bizimle iletişime geçin.'),
(1276, '', NULL, 'you_transmitting_spam_messages._the_system_automatically_restricts_chat_for_you__so_you_can_chat_again_after', 'You transmitting spam messages. the system automatically restricts chat for you, so you can chat again after', 'يمكنك نقل رسائل البريد المزعج. يقوم النظام تلقائيًا بتقييد الدردشة نيابة عنك ، حتى تتمكن من الدردشة مرة أخرى بعد', 'U verzendt spam-berichten. het systeem beperkt automatisch de chat voor u, zodat u later opnieuw kunt chatten', 'Vous transmettez des messages de spam. le système restreint automatiquement le chat pour que vous puissiez discuter à nouveau après', 'Sie senden Spam-Nachrichten. Das System schränkt den Chat automatisch für Sie ein, sodass Sie danach erneut chatten können', 'Stai trasmettendo messaggi spam. il sistema limita automaticamente la chat per te, quindi puoi chattare di nuovo dopo', 'Você está transmitindo mensagens de spam. o sistema restringe automaticamente o bate-papo para você, para que você possa conversar novamente depois', 'Вы передаете спам-сообщения. система автоматически ограничивает чат, поэтому вы можете снова общаться после', 'Estás transmitiendo mensajes de spam. el sistema restringe automáticamente el chat para usted, por lo que puede volver a chatear después de', 'Spam mesajlarını iletiyorsun. sistem sohbeti sizin için otomatik olarak kısıtlar, böylece tekrar sohbete başlayabilirsiniz.'),
(1277, '', NULL, 'options', 'options', 'خيارات', 'opties', 'options', 'Optionen', 'opzioni', 'opções', 'опции', 'opciones', 'seçenekleri'),
(1278, '', NULL, 'blog', 'Blog', 'مدونة', 'blog', 'Blog', 'Blog', 'blog', 'Blog', 'Блог', 'Blog', 'Blog'),
(1279, '', NULL, 'success_stories', 'Success stories', 'قصص النجاح', 'Succesverhalen', 'Réussites', 'Erfolgsgeschichten', 'Storie di successo', 'Histórias de sucesso', 'Истории успеха', 'Historias de éxito', 'Başarı Öyküleri'),
(1280, '', NULL, 'add_new_story', 'Add your story', 'أضف قصتك', 'Voeg je verhaal toe', 'Ajoutez votre histoire', 'Fügen Sie Ihre Geschichte hinzu', 'Aggiungi la tua storia', 'Adicione sua história', 'Добавьте свою историю', 'Agrega tu historia', 'Hikayeni ekle'),
(1281, '', NULL, 'create_story', 'Create story', 'خلق قصة', 'Maak een verhaal', 'Créer une histoire', 'Erstelle eine Geschichte', 'Crea una storia', 'Criar história', 'Создать историю', 'Crear historia', 'Hikaye oluşturmak'),
(1282, '', NULL, 'no_more_stories_to_show.', 'No more stories to show.', 'لا مزيد من القصص لإظهارها.', 'Geen verhalen meer om te laten zien.', 'Pas plus d\'histoires à montrer.', 'Keine Geschichten mehr zu zeigen.', 'Niente più storie da mostrare.', 'Não há mais histórias para mostrar.', 'Нет больше историй, чтобы показать.', 'No más historias para mostrar.', 'Gösterilecek başka hikaye yok.'),
(1283, '', NULL, 'add_new_success_stories', 'Add your successful story', 'أضف قصتك الناجحة', 'Voeg uw succesvolle verhaal toe', 'Ajoutez votre histoire réussie', 'Fügen Sie Ihre Erfolgsgeschichte hinzu', 'Aggiungi la tua storia di successo', 'Adicione sua história de sucesso', 'Добавьте свою успешную историю', 'Agrega tu historia exitosa', 'Başarılı hikayenizi ekleyin'),
(1284, '', NULL, 'story__html_allowed_', 'Story (HTML allowed)', 'قصة (HTML مسموح)', 'Verhaal (HTML toegestaan)', 'Histoire (HTML autorisé)', 'Story (HTML erlaubt)', 'Storia (HTML consentito)', 'História (HTML permitido)', 'История (HTML допускается)', 'Historia (HTML permitido)', 'Öykü (HTML\'ye izin verilir)'),
(1285, '', NULL, 'quote', 'Quote', 'اقتبس', 'Citaat', 'Citation', 'Zitat', 'Citazione', 'Citar', 'котировка', 'Citar', 'Alıntı'),
(1286, '', NULL, 'story_date', 'When this story happened?', 'متى حدثت هذه القصة؟', 'Toen dit verhaal gebeurde?', 'Quand cette histoire s\'est-elle passée?', 'Wann ist diese Geschichte passiert?', 'Quando è successa questa storia?', 'Quando esta história aconteceu?', 'Когда эта история произошла?', 'Cuando sucedió esta historia?', 'Bu hikaye ne zaman oldu?'),
(1287, '', NULL, 'please_select_user_first.', 'Please choose with whom you had this story.', 'يرجى اختيار مع من كان لديك هذه القصة.', 'Kies met wie je dit verhaal had.', 'S\'il vous plaît choisir avec qui vous avez eu cette histoire.', 'Bitte wählen Sie mit wem Sie diese Geschichte hatten.', 'Per favore, scegli con chi hai avuto questa storia.', 'Por favor, escolha com quem você teve essa história.', 'Пожалуйста, выберите, с кем у вас была эта история.', 'Por favor, elija con quién tuvo esta historia.', 'Lütfen bu hikayeyi kiminle aldığınızı seçin.'),
(1288, '', NULL, 'please_select_when_story_started.', 'Please select when the story occurred.', 'يرجى تحديد متى وقعت القصة.', 'Selecteer wanneer het verhaal zich voordeed.', 'Veuillez choisir quand l\'histoire a eu lieu.', 'Bitte wählen Sie aus, wann die Geschichte aufgetreten ist.', 'Seleziona quando si è verificata la storia.', 'Por favor, selecione quando a história ocorreu.', 'Пожалуйста, выберите, когда история произошла.', 'Seleccione cuándo ocurrió la historia.', 'Lütfen hikayenin ne zaman gerçekleştiğini seçin.'),
(1289, '', NULL, 'please_enter_quote.', 'Please enter a quote.', 'يرجى إدخال اقتباس.', 'Voer een offerte in.', 'S\'il vous plaît entrer un devis.', 'Bitte geben Sie ein Angebot ein.', 'Per favore, inserisci un preventivo', 'Por favor insira uma cotação.', 'Пожалуйста, введите цитату.', 'Por favor ingrese una cotización.', 'Lütfen bir fiyat teklifi girin.'),
(1290, '', NULL, 'please_enter_your_story.', 'Please enter your story.', 'الرجاء إدخال قصتك.', 'Voer je verhaal in.', 'S\'il vous plaît entrez votre histoire.', 'Bitte geben Sie Ihre Geschichte ein.', 'Per favore, inserisci la tua storia.', 'Por favor, insira sua história.', 'Пожалуйста, введите вашу историю.', 'Por favor ingrese su historia.', 'Lütfen hikayeni yaz.'),
(1291, '', NULL, 'story_add_successfully', 'Your story has been added successfully.', 'تمت إضافة قصتك بنجاح.', 'Je verhaal is succesvol toegevoegd.', 'Votre histoire a été ajoutée avec succès.', 'Ihre Geschichte wurde erfolgreich hinzugefügt.', 'La tua storia è stata aggiunta con successo.', 'Sua história foi adicionada com sucesso.', 'Ваша история была успешно добавлена.', 'Su historia ha sido agregada con éxito.', 'Hikayen başarıyla eklendi.'),
(1292, '', NULL, 'story_add_successfully__please_wait_while_admin_approve_this_story_and_it_will_show_on_site.', 'Your story has been added successfully, please wait while we review your story and approve it.', 'تمت إضافة قصتك بنجاح ، يرجى الانتظار لحين مراجعة قصتك والموافقة عليها.', 'Je verhaal is succesvol toegevoegd. Een ogenblik geduld. We beoordelen je verhaal en keuren het goed.', 'Votre récit a été ajouté avec succès. Veuillez patienter pendant que nous examinons votre récit et l’approuvons.', 'Ihre Geschichte wurde erfolgreich hinzugefügt. Bitte warten Sie, während wir Ihre Geschichte überprüfen und genehmigen.', 'La tua storia è stata aggiunta correttamente, attendi mentre la rivediamo e la approviamo.', 'Sua história foi adicionada com sucesso. Aguarde enquanto analisamos sua história e a aprovamos.', 'Ваша история была успешно добавлена, пожалуйста, подождите, пока мы рассмотрим вашу историю и одобрим ее.', 'Su historia se ha agregado correctamente, espere mientras revisamos su historia y la aprobamos.', 'Hikayeniz başarıyla eklendi, lütfen hikayenizi gözden geçirip onaylarken bekleyin.'),
(1293, '', NULL, 'story', 'Story', 'قصة', 'Verhaal', 'Récit', 'Geschichte', 'Storia', 'História', 'История', 'Historia', 'Öykü'),
(1294, '', NULL, '1309', 'Comedy', 'كوميديا', 'Komedie', 'La comédie', 'Komödie', 'Commedia', 'Comédia', 'комедия', 'Comedia', 'Komedi'),
(1295, '', NULL, '1310', 'Cars and Vehicles', 'السيارات والمركبات', 'Auto\'s en voertuigen', 'Voitures et véhicules', 'Autos und Fahrzeuge', 'Auto e veicoli', 'Carros e Veículos', 'Автомобили и транспортные средства', 'Autos y vehiculos', 'Otomobiller ve Taşıtlar'),
(1296, '', NULL, '1311', 'Economics and Trade', 'الاقتصاد والتجارة', 'Economie en handel', 'Économie et commerce', 'Wirtschaft und Handel', 'Economia e commercio', 'Economia e Comércio', 'Экономика и торговля', 'Economía y comercio', 'Ekonomi ve Ticaret'),
(1297, '', NULL, '1312', 'Education', 'التعليم', 'Opleiding', 'Éducation', 'Bildung', 'Formazione scolastica', 'Educação', 'образование', 'Educación', 'Eğitim'),
(1298, '', NULL, '1313', 'Entertainment', 'وسائل الترفيه', 'vermaak', 'Divertissement', 'Unterhaltung', 'Divertimento', 'Entretenimento', 'Развлекательная программа', 'Entretenimiento', 'Eğlence'),
(1299, '', NULL, '1314', 'Movies & Animation', 'أفلام & amp؛ حيوية', 'Films & amp; animatie', 'Films & amp; Animation', 'Filme & amp; Animation', 'Film e amp; Animazione', 'Filmes e amp; Animação', 'Кино & amp; Анимация', 'Películas y amplificadores; Animación', 'Filmler ve amp; Animasyon'),
(1300, '', NULL, '1315', 'Gaming', 'الألعاب', 'gaming', 'Jeu', 'Gaming', 'Gaming', 'Jogos', 'азартные игры', 'Juego de azar', 'kumar'),
(1301, '', NULL, '1316', 'History and Facts', 'التاريخ والحقائق', 'Geschiedenis en feiten', 'Histoire et faits', 'Geschichte und Fakten', 'Storia e fatti', 'História e Fatos', 'История и факты', 'Historia y hechos', 'Tarihçe ve Gerçekler'),
(1302, '', NULL, '1317', 'Live Style', 'أسلوب حياة', 'Levensstijl', 'Style de vie', 'Lebensstil', 'Stile dal vivo', 'Estilo Vivo', 'Стиль жизни', 'Estilo de vida', 'Yaşam tarzı'),
(1303, '', NULL, '1318', 'Natural', 'طبيعي >> صفة', 'natuurlijk', 'Naturel', 'Natürlich', 'Naturale', 'Natural', 'натуральный', 'Natural', 'Doğal'),
(1304, '', NULL, '1319', 'News and Politics', 'الأخبار والسياسة', 'Nieuws en politiek', 'Nouvelles et politique', 'Nachrichten und Politik', 'Notizie e politica', 'Notícias e Política', 'Новости и Политика', 'Noticias y politica', 'Haberler ve Politika'),
(1305, '', NULL, '1320', 'People and Nations', 'الناس والأمم', 'Mensen en naties', 'Peuples et Nations', 'Menschen und Nationen', 'Persone e nazioni', 'Pessoas e Nações', 'Люди и народы', 'Pueblos y naciones', 'İnsanlar ve Milletler'),
(1306, '', NULL, '1321', 'Pets and Animals', 'الحيوانات الأليفة والحيوانات', 'Huisdieren en dieren', 'Animaux et Animaux', 'Haustiere und Tiere', 'Animali domestici', 'Animais de Estimação e Animais', 'Домашние животные и животные', 'Mascotas y animales', 'Evcil Hayvanlar ve Hayvanlar'),
(1307, '', NULL, '1322', 'Places and Regions', 'الأماكن والمناطق', 'Plaatsen en regio\'s', 'Lieux et régions', 'Orte und Regionen', 'Luoghi e regioni', 'Lugares e Regiões', 'Места и Регионы', 'Lugares y Regiones', 'Yerler ve Bölgeler'),
(1308, '', NULL, '1323', 'Science and Technology', 'العلوم والتكنولوجيا', 'Wetenschap en technologie', 'Science et technologie', 'Wissenschaft und Technik', 'Scienze e tecnologia', 'Ciência e Tecnologia', 'Наука и технология', 'Ciencia y Tecnología', 'Bilim ve Teknoloji'),
(1309, '', NULL, '1324', 'Sport', 'رياضة', 'Sport', 'sport', 'Sport', 'Sport', 'Esporte', 'спорт', 'Deporte', 'Spor'),
(1310, '', NULL, '1325', 'Travel and Events', 'السفر والأحداث', 'Reizen en evenementen', 'Voyage et événements', 'Reisen und Veranstaltungen', 'Viaggi ed Eventi', 'Viagens e Eventos', 'Путешествия и События', 'Viajes y eventos', 'Seyahat ve Etkinlikler'),
(1311, '', NULL, '1326', 'Other', 'آخر', 'anders', 'Autre', 'Andere', 'Altro', 'De outros', 'Другой', 'Otro', 'Diğer'),
(1312, '', NULL, 'read_more', 'Read more', 'قراءة المزيد', 'Lees verder', 'Lire la suite', 'Weiterlesen', 'Leggi di più', 'Consulte Mais informação', 'Прочитайте больше', 'Lee mas', 'Daha fazla oku'),
(1313, '', NULL, 'categories', 'Categories', 'الاقسام', 'Categorieën', 'Les catégories', 'Kategorien', 'categorie', 'Categorias', 'категории', 'Categorías', 'Kategoriler'),
(1314, '', NULL, 'no_more_articles_to_show.', 'No more articles to show.', 'لا مزيد من المقالات لإظهارها.', 'Geen artikelen meer om te tonen.', 'Pas plus d\'articles à montrer.', 'Keine weiteren Artikel zum Anzeigen.', 'Non ci sono più articoli da mostrare.', 'Não há mais artigos para mostrar.', 'Нет больше статей, чтобы показать.', 'No hay más artículos para mostrar.', 'Gösterilecek başka makale yok.'),
(1315, '', NULL, 'article', 'Article', 'مقالة - سلعة', 'Artikel', 'Article', 'Artikel', 'Articolo', 'Artigo', 'Статья', 'Artículo', 'makale'),
(1316, '', NULL, 'share_to', 'Share to', 'حصة ل', 'Delen naar', 'Partager à', 'Teilen mit', 'Condividere a', 'Compartilhar com', 'Поделиться с', 'Compartir a', 'Paylaş'),
(1317, '', NULL, 'hot_or_not', 'Hot OR Not', 'حار أم لا', 'Heet of niet', 'Chaud ou pas', 'Heiß oder nicht', 'Caldo o no', 'Quente ou não', 'Горячий или нет', 'Caliente o no', 'Çekici mi değil mi'),
(1318, '', NULL, 'image_verification', 'Image Verification', 'التحقق من الصورة', 'foto verificatie', 'verification de l\'image', 'Bildverifizierung', 'verifica immagine', 'Verificação de Imagem', 'Подтверждение изображения', 'verificación de imagen', 'Görüntü Doğrulama'),
(1319, '', NULL, 'verify_your', 'Verify your', 'تحقق الخاص بك', 'Verifieer jouw', 'Vérifier votre', 'Überprüfen Sie Ihre', 'Verifica il tuo', 'Verificar o seu', 'Проверьте свой', 'Verifique su', 'Doğrula'),
(1320, '', NULL, 'account', 'account', 'الحساب', 'account', 'Compte', 'Konto', 'account', 'conta', 'учетная запись', 'cuenta', 'hesap'),
(1321, '', NULL, 'you_will_be_required_to_take_a_selfie_holding_the_id_document_next_to_your_face__so_we_can_compare_your_photo_with_your_actual_look.this_is_just_an_additional_security_measure', 'You will be required to take a selfie holding the ID document next to your face, so we can compare your photo with your actual look. This is just an additional security measure.', 'سيُطلب منك التقاط صورة شخصية تحمل وثيقة الهوية بجوار وجهك ، حتى نتمكن من مقارنة صورتك بمظهرك الفعلي. هذا مجرد تدبير أمني إضافي.', 'U moet een selfie maken met het ID-document naast uw gezicht, zodat we uw foto kunnen vergelijken met uw werkelijke look. Dit is slechts een extra beveiligingsmaatregel.', 'Il vous sera demandé de prendre un selfie avec le document d\'identité à côté de votre visage afin que nous puissions comparer votre photo avec votre apparence réelle. Ceci est juste une mesure de sécurité supplémentaire.', 'Sie müssen ein Selfie mit dem Personalausweis neben Ihrem Gesicht machen, damit wir Ihr Foto mit Ihrem tatsächlichen Aussehen vergleichen können. Dies ist nur eine zusätzliche Sicherheitsmaßnahme.', 'Ti verrà richiesto di scattare un selfie con il documento di identità accanto al tuo viso, in modo da poter confrontare la tua foto con il tuo aspetto reale. Questa è solo un\'ulteriore misura di sicurezza.', 'Você será solicitado a tirar uma selfie segurando o documento de identificação ao lado do seu rosto, para que possamos comparar sua foto com sua aparência real. Esta é apenas uma medida de segurança adicional.', 'Вам нужно будет сделать селфи, держа удостоверение личности рядом с вашим лицом, чтобы мы могли сравнить вашу фотографию с вашим реальным видом. Это всего лишь дополнительная мера безопасности.', 'Se le pedirá que se tome una selfie con el documento de identificación junto a su cara, para que podamos comparar su foto con su aspecto real. Esta es solo una medida de seguridad adicional.', 'Kimlik belgesini yüzünüzün yanında tutan bir selfie almanız gerekecek, böylece fotoğrafınızı gerçek görünümünüzle karşılaştırabiliriz. Bu sadece ek bir güvenlik önlemidir.'),
(1322, '', NULL, 'take_snapshot', 'Take Snapshot', 'خذ لقطة', 'Maak snapshot', 'Prendre un instantané', 'Schnappschuss machen', 'Scatta un\'istantanea', 'Tire uma foto rápida', 'Моментальный снимок', 'Tomar instantáneas', 'Ekran alıntısı al'),
(1323, '', NULL, 'retake_snapshot', 'Retake Snapshot', 'استعادة لقطة', 'Snapshot opnieuw maken', 'Reprendre un instantané', 'Snapshot erneut aufnehmen', 'Ripeti istantanea', 'Recolher instantâneo', 'Сделать снимок', 'Repetir Instantánea', 'Anlık Fotoğrafı Yeniden Al'),
(1324, '', NULL, 'back', 'Back', 'الى الخلف', 'Terug', 'Retour', 'Zurück', 'Indietro', 'De volta', 'назад', 'atrás', 'Geri'),
(1325, '', NULL, 'keyword', 'Keyword', 'الكلمة', 'keyword', 'Mot-clé', 'Stichwort', 'Parola chiave', 'Palavra chave', 'Ключевое слово', 'Palabra clave', 'Kelimeler'),
(1326, '', NULL, 'no_articles_found', 'No articles found', 'لا توجد مقالات', 'Geen artikelen gevonden', 'Aucun article trouvé', 'Keine Artikel gefunden', 'Nessun articolo trovato', 'Nenhum artigo encontrado', 'Статьи не найдены', 'No se encontraron artículos.', 'Makale bulunamadı'),
(1327, '', NULL, 'tags', 'Tags', 'الكلمات', 'Tags', 'Mots clés', 'Stichworte', 'tag', 'Tag', 'Теги', 'Etiquetas', 'Etiketler'),
(1328, '', NULL, 'free', 'Free', 'حر', 'Gratis', 'Libre', 'Kostenlos', 'Gratuito', 'Livre', 'Свободно', 'Gratis', 'Ücretsiz'),
(1329, '', NULL, 'brings_out_the_sense_of_adventure_in_me__the_website_is_so_easy_to_use_and_the_possibility_of_meeting_someone_from_another_culture_that_relates_to_me_is_simply_thrilling.', 'Brings out the sense of adventure in me! The website is so easy to use and the possibility of meeting someone from another culture that relates to me is simply thrilling.', 'تبرز روح المغامرة في داخلي! موقع الويب سهل الاستخدام للغاية وإمكانية مقابلة شخص من ثقافة أخرى تتعلق بي هي ببساطة مثيرة.', 'Brengt het gevoel van avontuur in mij naar boven! De website is zo gemakkelijk te gebruiken en de mogelijkheid om iemand te ontmoeten uit een andere cultuur die op mij betrekking heeft, is gewoon opwindend.', 'Fait ressortir le sens de l\'aventure en moi! Le site Web est si facile à utiliser et la possibilité de rencontrer quelqu\'un d\'une autre culture qui me concerne est tout simplement excitante.', 'Bringt den Sinn für Abenteuer in mir hervor! Die Website ist so einfach zu bedienen und die Möglichkeit, jemanden aus einer anderen Kultur zu treffen, die mich betrifft, ist einfach aufregend.', 'Esalta in me il senso dell\'avventura! Il sito web è così facile da usare e la possibilità di incontrare qualcuno di un\'altra cultura che mi riguarda è semplicemente elettrizzante.', 'Traz a sensação de aventura em mim! O site é tão fácil de usar e a possibilidade de conhecer alguém de outra cultura que se relaciona comigo é simplesmente emocionante.', 'Вызывает во мне чувство приключения! Веб-сайт очень прост в использовании, и возможность встретить кого-то другого человека, относящегося ко мне, просто волнует.', '¡Saca la sensación de aventura en mí! El sitio web es muy fácil de usar y la posibilidad de conocer a alguien de otra cultura que se relaciona conmigo es simplemente emocionante.', 'İçimdeki macera duygusunu ortaya çıkar! Web sitesi kullanımı çok kolay ve benimle ilgili başka bir kültürden biriyle tanışma olasılığı çok heyecan verici.'),
(1330, '', NULL, 'brings_out_the_feelings_of_adventure_in_me__the_website_is_so_easy_to_use_and_the_possibility_of_meeting_someone_from_another_culture_that_relates_to_me_is_simply_thrilling.', 'Brings out the feelings of adventure in me! The website is so easy to use and the possibility of meeting someone from another culture that relates to me is simply thrilling.', 'تبرز مشاعر المغامرة في داخلي! موقع الويب سهل الاستخدام للغاية وإمكانية مقابلة شخص من ثقافة أخرى تتعلق بي هي ببساطة مثيرة.', 'Brengt de gevoelens van avontuur in mij naar boven! De website is zo gemakkelijk te gebruiken en de mogelijkheid om iemand te ontmoeten uit een andere cultuur die op mij betrekking heeft, is gewoon opwindend.', 'Fait ressortir les sentiments d\'aventure en moi! Le site Web est si facile à utiliser et la possibilité de rencontrer quelqu\'un d\'une autre culture qui me concerne est tout simplement excitante.', 'Bringt die Abenteuergefühle in mir zum Vorschein! Die Website ist so einfach zu bedienen und die Möglichkeit, jemanden aus einer anderen Kultur zu treffen, die mich betrifft, ist einfach aufregend.', 'Fa emergere i sentimenti di avventura in me! Il sito web è così facile da usare e la possibilità di incontrare qualcuno di un\'altra cultura che mi riguarda è semplicemente elettrizzante.', 'Traz os sentimentos de aventura em mim! O site é tão fácil de usar e a possibilidade de conhecer alguém de outra cultura que se relaciona comigo é simplesmente emocionante.', 'Вызывает во мне чувство приключения! Веб-сайт очень прост в использовании, и возможность встретить кого-то другого человека, относящегося ко мне, просто волнует.', '¡Saca los sentimientos de aventura en mí! El sitio web es muy fácil de usar y la posibilidad de conocer a alguien de otra cultura que se relaciona conmigo es simplemente emocionante.', 'İçimdeki macera duygularını ortaya çıkar! Web sitesi kullanımı çok kolay ve benimle ilgili başka bir kültürden biriyle tanışma olasılığı çok heyecan verici.'),
(1331, '', NULL, 'produce_out_the_sense_of_adventure_in_me__the_website_is_so_easy_to_use_and_the_possibility_of_meeting_someone_from_another_culture_that_relates_to_me_is_simply_thrilling.', 'produce out the sense of adventure in me! The website is so easy to use and the possibility of meeting someone from another culture that relates to me is simply thrilling.', 'أنتج احساس المغامرة في داخلي! موقع الويب سهل الاستخدام للغاية وإمكانية مقابلة شخص من ثقافة أخرى تتعلق بي هي ببساطة مثيرة.', 'produceer het gevoel van avontuur in mij! De website is zo gemakkelijk te gebruiken en de mogelijkheid om iemand te ontmoeten uit een andere cultuur die op mij betrekking heeft, is gewoon opwindend.', 'Produire le sens de l\'aventure en moi! Le site Web est si facile à utiliser et la possibilité de rencontrer quelqu\'un d\'une autre culture qui me concerne est tout simplement excitante.', 'zeige den Sinn für Abenteuer in mir! Die Website ist so einfach zu bedienen und die Möglichkeit, jemanden aus einer anderen Kultur zu treffen, die mich betrifft, ist einfach aufregend.', 'produce in me il senso dell\'avventura! Il sito web è così facile da usare e la possibilità di incontrare qualcuno di un\'altra cultura che mi riguarda è semplicemente elettrizzante.', 'produzir o senso de aventura em mim! O site é tão fácil de usar e a possibilidade de conhecer alguém de outra cultura que se relaciona comigo é simplesmente emocionante.', 'создай во мне чувство приключения! Веб-сайт очень прост в использовании, и возможность встретить кого-то другого человека, относящегося ко мне, просто волнует.', '¡Produce el sentido de aventura en mí! El sitio web es muy fácil de usar y la posibilidad de conocer a alguien de otra cultura que se relaciona conmigo es simplemente emocionante.', 'İçimdeki macera duygusunu ortaya çıkarmak! Web sitesi kullanımı çok kolay ve benimle ilgili başka bir kültürden biriyle tanışma olasılığı çok heyecan verici.'),
(1332, '', NULL, 'bring_out_the_sense_of_adventure_in_me__the_website_is_so_easy_to_use_and_the_possibility_of_meeting_someone_from_another_culture_that_relates_to_me_is_simply_thrilling.', 'bring out the sense of adventure in me! The website is so easy to use and the possibility of meeting someone from another culture that relates to me is simply thrilling.', 'تبرز روح المغامرة في داخلي! موقع الويب سهل الاستخدام للغاية وإمكانية مقابلة شخص من ثقافة أخرى تتعلق بي هي ببساطة مثيرة.', 'breng het gevoel van avontuur in mij naar boven! De website is zo gemakkelijk te gebruiken en de mogelijkheid om iemand te ontmoeten uit een andere cultuur die op mij betrekking heeft, is gewoon opwindend.', 'faire ressortir le sens de l\'aventure en moi! Le site Web est si facile à utiliser et la possibilité de rencontrer quelqu\'un d\'une autre culture qui me concerne est tout simplement excitante.', 'Bring den Sinn für Abenteuer in mir zum Vorschein! Die Website ist so einfach zu bedienen und die Möglichkeit, jemanden aus einer anderen Kultur zu treffen, die mich betrifft, ist einfach aufregend.', 'fai emergere il senso dell\'avventura in me! Il sito web è così facile da usare e la possibilità di incontrare qualcuno di un\'altra cultura che mi riguarda è semplicemente elettrizzante.', 'traga a sensação de aventura em mim! O site é tão fácil de usar e a possibilidade de conhecer alguém de outra cultura que se relaciona comigo é simplesmente emocionante.', 'выявить чувство приключения во мне! Веб-сайт очень прост в использовании, и возможность встретить кого-то другого человека, относящегося ко мне, просто волнует.', '¡Saca el sentido de la aventura en mí! El sitio web es muy fácil de usar y la posibilidad de conocer a alguien de otra cultura que se relaciona conmigo es simplemente emocionante.', 'İçimdeki macera duygusunu ortaya çıkarmak! Web sitesi kullanımı çok kolay ve benimle ilgili başka bir kültürden biriyle tanışma olasılığı çok heyecan verici.'),
(1333, '', NULL, 'this_profile_is_verified_by_photos', 'This profile is verified by user picture. ', 'يتم التحقق من هذا الملف الشخصي بواسطة صورة المستخدم.', 'Dit profiel is geverifieerd door gebruikersfoto.', 'Ce profil est vérifié par la photo de l\'utilisateur.', 'Dieses Profil wird durch das Benutzerbild verifiziert.', 'Questo profilo è verificato dalla foto dell\'utente.', 'Este perfil é verificado pela foto do usuário.', 'Этот профиль подтвержден фотографией пользователя.', 'Este perfil es verificado por la imagen del usuario.', 'Bu profil kullanıcı resmi tarafından doğrulandı.'),
(1334, '', NULL, 'your_account_wait_admin_photo_verification._please_try_again_later.', 'Your account is under review, Please wait until we review your picture and try again later.', 'حسابك قيد المراجعة ، يرجى الانتظار حتى نراجع صورتك ونعيد المحاولة لاحقًا.', 'Uw account wordt beoordeeld. Wacht tot we uw foto hebben beoordeeld en probeer het later opnieuw.', 'Votre compte est en cours de révision. Veuillez patienter jusqu\'à ce que nous examinions votre photo, puis réessayez ultérieurement.', 'Ihr Konto wird überprüft. Warten Sie, bis wir Ihr Bild überprüfen, und versuchen Sie es später erneut.', 'Il tuo account è in fase di revisione, attendi fino a quando non esamineremo la tua foto e riproveremo più tardi.', 'Sua conta está em revisão. Aguarde até revisarmos sua foto e tentarmos mais tarde.', 'Ваша учетная запись находится на рассмотрении. Подождите, пока мы просмотрим Вашу фотографию, и повторите попытку позже.', 'Su cuenta está en proceso de revisión. Espere hasta que revisemos su imagen e intente nuevamente más tarde.', 'Hesabınız inceleniyor. Lütfen resminizi gözden geçirene kadar bekleyin ve daha sonra tekrar deneyin.'),
(1335, '', NULL, 'your_camera_is_off_or_disconnected__please_connect_your_camera_and_try_again.', 'Your camera is off or disconnected, Please connect your camera and try again.', 'تم إيقاف تشغيل الكاميرا أو فصلها ، يرجى توصيل الكاميرا والمحاولة مرة أخرى.', 'Uw camera is uitgeschakeld of de verbinding is verbroken. Sluit uw camera aan en probeer het opnieuw.', 'Votre appareil photo est éteint ou déconnecté. Veuillez connecter votre appareil photo et réessayer.', 'Ihre Kamera ist ausgeschaltet oder nicht angeschlossen. Bitte schließen Sie Ihre Kamera an und versuchen Sie es erneut.', 'La fotocamera è spenta o disconnessa, collega la fotocamera e riprova.', 'Sua câmera está desligada ou desconectada. Conecte sua câmera e tente novamente.', 'Ваша камера выключена или отключена. Пожалуйста, подключите камеру и попробуйте снова.', 'Su cámara está apagada o desconectada. Conecte su cámara e intente nuevamente.', 'Kameranız kapalı veya bağlantısı kesildi. Lütfen kameranızı bağlayın ve tekrar deneyin.'),
(1336, '', NULL, 'try_again', 'Try again', 'حاول مجددا', 'Probeer het opnieuw', 'Réessayer', 'Versuchen Sie es nochmal', 'Riprova', 'Tente novamente', 'Попробуйте снова', 'Inténtalo de nuevo', 'Tekrar deneyin'),
(1337, '', NULL, 'you_have_previous_story_with_this_user', 'You have previous story with this user', 'لديك قصة سابقة مع هذا المستخدم', 'Je hebt een eerder verhaal met deze gebruiker', 'Vous avez une histoire précédente avec cet utilisateur', 'Sie haben eine frühere Geschichte mit diesem Benutzer', 'Hai una storia precedente con questo utente', 'Você tem uma história anterior com este usuário', 'У вас есть предыдущая история с этим пользователем', 'Tienes una historia previa con este usuario', 'Bu kullanıcıyla daha önce bir hikayen var.'),
(1338, '', NULL, 'with', 'With', 'مع', 'Met', 'Avec', 'Mit', 'Con', 'Com', 'С', 'Con', 'İle'),
(1339, '', NULL, 'create_story_with_you', 'created a story with you.', 'خلق قصة معك.', 'creëerde een verhaal met jou.', 'créé une histoire avec vous.', 'hat mit dir eine Geschichte geschrieben.', 'creato una storia con te.', 'criou uma história com você.', 'создал историю с вами.', 'Creé una historia contigo.', 'seninle bir hikaye yarattım.'),
(1340, '', NULL, 'approved_your_story_', 'approved your story!', 'وافق قصتك!', 'heeft je verhaal goedgekeurd!', 'approuvé votre histoire!', 'hat deine Geschichte genehmigt!', 'ha approvato la tua storia!', 'aprovou sua história!', 'одобрил вашу историю!', 'aprobó tu historia!', 'hikayeni onayladın!'),
(1341, '', NULL, 'has_rejected_your_story.', 'has rejected your story.', 'رفض قصتك.', 'heeft je verhaal afgewezen.', 'a rejeté votre histoire.', 'hat deine Geschichte abgelehnt.', 'ha rifiutato la tua storia.', 'rejeitou sua história.', 'отклонил вашу историю.', 'ha rechazado tu historia', 'hikayeni reddetti.'),
(1342, '', NULL, 'approve_story', 'Approve story', 'الموافقة على القصة', 'Goedkeuren verhaal', 'Approuver l\'histoire', 'Genehmige die Geschichte', 'Approvare la storia', 'Aprovar história', 'Одобрить историю', 'Aprobar historia', 'Hikayeyi onayla'),
(1343, '', NULL, 'disapprove_story', 'Disapprove story', 'رفض القصة', 'Verwerp verhaal', 'Désapprouver l\'histoire', 'Geschichte ablehnen', 'Non approvare la storia', 'Reprovar história', 'Отклонить историю', 'Desaprobar historia', 'Onaylamama hikayesi'),
(1344, '', NULL, 'you_have_story_with', 'You have a story with', 'لديك قصة مع', 'Je hebt een verhaal met', 'Vous avez une histoire avec', 'Du hast eine Geschichte mit', 'Hai una storia con', 'Você tem uma história com', 'У вас есть история с', 'Tienes una historia con', 'Bir hikayen var'),
(1345, '', NULL, 'on', 'on', 'على', 'op', 'sur', 'auf', 'sopra', 'em', 'на', 'en', 'üzerinde'),
(1346, '', NULL, 'story_approved_successfully.', 'Your story has been approved.', 'تمت الموافقة على قصتك.', 'Je verhaal is goedgekeurd.', 'Votre histoire a été approuvée.', 'Ihre Geschichte wurde genehmigt.', 'La tua storia è stata approvata.', 'Sua história foi aprovada.', 'Ваша история была одобрена.', 'Tu historia ha sido aprobada.', 'Hikayen onaylandı.'),
(1347, '', NULL, 'story_disapproved_successfully.', 'Your story has been declined.', 'لقد تم رفض قصتك.', 'Je verhaal is afgewezen.', 'Votre histoire a été refusée.', 'Ihre Geschichte wurde abgelehnt.', 'La tua storia è stata rifiutata.', 'Sua história foi recusada.', 'Ваша история была отклонена.', 'Tu historia ha sido rechazada.', 'Hikayen reddedildi.'),
(1348, '', NULL, 'social_accounts', 'Social accounts', 'الحسابات الاجتماعية', 'Sociale accounts', 'Comptes sociaux', 'Soziale Konten', 'Conti sociali', 'Contas sociais', 'Социальные аккаунты', 'Cuentas sociales', 'Sosyal hesaplar'),
(1349, '', NULL, 'publish', 'Publish', 'نشر', 'Publiceren', 'Publier', 'Veröffentlichen', 'Pubblicare', 'Publicar', 'Публиковать', 'Publicar', 'Yayınla'),
(1350, '', NULL, 'thank_you_for_your_story__we_have_sent_the_story_to__0___once_approved_your_story_will_be_published.', 'Thank you for your story, we have sent the story to {0}, once approved your story will be published.', 'شكرًا لك على قصتك ، لقد أرسلنا القصة إلى {0} ، بمجرد الموافقة على نشر قصتك.', 'Bedankt voor je verhaal, we hebben het verhaal naar {0} gestuurd, zodra goedgekeurd zal je verhaal worden gepubliceerd.', 'Merci pour votre histoire. Nous l’avons envoyée à {0}. Une fois approuvée, votre histoire sera publiée.', 'Vielen Dank für Ihre Geschichte. Wir haben die Geschichte an {0} gesendet. Sobald die Genehmigung vorliegt, wird Ihre Geschichte veröffentlicht.', 'Grazie per la tua storia, abbiamo inviato la storia a {0}, una volta approvata la tua storia sarà pubblicata.', 'Obrigado pela sua história, enviamos a história para {0}, uma vez aprovada, sua história será publicada.', 'Спасибо за вашу историю. Мы отправили историю в {0}, после того как ваша история будет опубликована.', 'Gracias por su historia, hemos enviado la historia a {0}, una vez aprobada, su historia será publicada.', 'Hikayen için teşekkürler, hikayeni yayınlayacağını onayladıktan sonra hikayeyi {0} \'a gönderdik.'),
(1351, '', NULL, 'no_user_found_with_this_name', 'No user found with this name', 'لم يتم العثور على مستخدم بهذا الاسم', 'Geen gebruiker gevonden met deze naam', 'Aucun utilisateur trouvé avec ce nom', 'Kein Benutzer mit diesem Namen gefunden', 'Nessun utente trovato con questo nome', 'Nenhum usuário encontrado com este nome', 'Пользователь с таким именем не найден', 'Ningún usuario encontrado con este nombre', 'Bu ada sahip bir kullanıcı bulunamadı'),
(1352, '', NULL, 'vk', 'VK', 'VK', 'VK', 'VK', 'VK', 'VK', 'VK', 'VK', 'VK', 'VK'),
(1353, '', NULL, 'type_a_message', 'Type a message', 'اكتب رسالة', 'Type een bericht', 'Tapez un message', 'Geben Sie eine Nachricht ein', 'Scrivi un messaggio', 'Digite uma mensagem', 'Введите сообщение', 'Escribe un mensaje', 'Bir mesaj yazın'),
(1354, '', NULL, 'boost_for_free', 'Boost For Free', 'تعزيز للحصول على الحرة', 'Boost For Free', 'Boostez gratuitement', 'Steigern Sie kostenlos', 'Boost gratuitamente', 'Impulsionar For Free', 'Повысьте бесплатно', 'Para impulsar gratuito', 'Bedava Boost'),
(1355, '', NULL, 'boost_your_profile_for_free_for', 'Boost your profile for free for', 'زيادة التعريف الخاص بك مجانا ل', 'Boost je profiel gratis voor', 'Boostez votre profil gratuitement pour', 'Steigern Sie Ihr Profil kostenlos für', 'Amplia il tuo profilo gratuitamente per', 'Impulsionar o seu perfil de graça para', 'Повысьте свой профиль бесплатно для', 'Aumentar su perfil de forma gratuita para', 'boyunca ücretsiz profilinizi Boost'),
(1356, '', NULL, 'this_profile_is_verified_by_phone', 'This profile is verified by phone', 'يتم التحقق منها هذا الملف عن طريق الهاتف', 'Dit profiel wordt gecontroleerd via de telefoon', 'Ce profil est vérifié par téléphone', 'Dieses Profil wird telefonisch überprüft', 'Questo profilo è verificato per telefono', 'Este perfil é verificada por telefone', 'Этот профиль проверяется по телефону', 'Este perfil se verifica por teléfono', 'Bu profil telefonla doğrulandı'),
(1357, '', NULL, 'your_height_is_required.', 'Your height is required.', 'مطلوب طولك.', 'Uw lengte is vereist.', 'Votre taille est nécessaire.', 'Ihre Höhe ist nicht erforderlich.', 'è richiesta la tua altezza.', 'Sua altura é necessária.', 'Ваша высота не требуется.', 'Se requiere su altura.', 'Kişisel yüksekliği gereklidir.'),
(1358, '', NULL, 'name', 'Name', 'اسم', 'Naam', 'Nom', 'Name', 'Nome', 'Nome', 'имя', 'Nombre', 'isim'),
(1359, '', NULL, 'card_number', 'Card Number', 'رقم البطاقة', 'Kaartnummer', 'Numéro de carte', 'Kartennummer', 'Numero di carta', 'Número do cartão', 'Номер карты', 'Número de tarjeta', 'Kart numarası'),
(1360, '', NULL, 'pay', 'Pay', 'دفع', 'Betalen', 'Payer', 'Zahlen', 'pagare', 'Pagar', 'платить', 'Pagar', 'Ödemek'),
(1361, '', NULL, 'please_check_your_details', 'Please check your details', 'يرجى مراجعة التفاصيل الخاصة بك', 'Kijk alsjeblieft je gegevens na', 'S\'il vous plaît vérifier vos informations', 'Bitte überprüfe deine Details', 'Si prega di verificare i tuoi dati', 'Por favor, verifique seus dados', 'Пожалуйста, проверьте свои данные', 'Por favor comprueba tus detalles', 'Bilgilerinizi kontrol edin'),
(1362, '', NULL, 'manage_sessions', 'Manage Sessions', 'إدارة الجلسات', 'Sessies beheren', 'Manage Sessions', 'Sitzungen verwalten', 'Gestisci sessioni', 'Gerenciar sessões', 'Управление сессиями', 'Administrar sesiones', 'Oturumları Yönet'),
(1363, '', NULL, 'platform', 'Platform', 'منصة', 'Platform', 'Plate-forme', 'Plattform', 'piattaforma', 'Plataforma', 'Платформа', 'Plataforma', 'platform'),
(1364, '', NULL, 'last_seen', 'Last seen', 'اخر ظهور', 'Laatst gezien', 'Vu pour la dernière fois', 'Zuletzt gesehen', 'Ultima visualizzazione', 'Visto pela última vez', 'В последний раз видел', 'Ultima vez visto', 'Son görülen'),
(1365, '', NULL, 'os', 'OS', 'THE', 'DE', 'OS', 'Betriebssystem', 'IL', 'OS', '', 'OS', ''),
(1366, '', NULL, 'browser', 'Browser', 'المتصفح', 'browser', 'Navigateur', 'Browser', '', '', 'браузер', '', ''),
(1367, '', NULL, 'action', 'Action', 'عمل', 'Actie', 'Action', 'Aktion', 'Azione', 'Açao', 'действие', 'Acción', 'Aksiyon'),
(1368, '', NULL, 'error_while_deleting_session__please_try_again_later.', 'Error while deleting session, please try again later.', 'خطأ أثناء حذف الجلسة ، يرجى المحاولة مرة أخرى لاحقًا.', 'Fout tijdens het verwijderen van de sessie. Probeer het later opnieuw.', 'Erreur lors de la suppression de la session, veuillez réessayer plus tard.', 'Fehler beim Löschen der Sitzung, versuchen Sie es später erneut.', 'Errore durante l&#39;eliminazione della sessione, riprovare più tardi.', 'Erro ao excluir a sessão, tente novamente mais tarde.', 'Ошибка при удалении сеанса, повторите попытку позже.', 'Error al eliminar sesión, intente nuevamente más tarde.', 'Oturum silinirken hata oluştu, lütfen daha sonra tekrar deneyin.'),
(1369, '', NULL, 'session_deleted_successfully.', 'Session has been deleted successfully.', 'تم حذف الجلسة بنجاح.', 'Sessie is succesvol verwijderd.', 'La session a été supprimée avec succès.', 'Sitzung wurde erfolgreich gelöscht.', 'La sessione è stata eliminata correttamente.', 'A sessão foi excluída com sucesso.', 'Сессия была успешно удалена.', 'La sesión se ha eliminado con éxito.', 'Oturum başarıyla silindi.'),
(1370, '', NULL, 'two-factor_authentication', 'Two-factor authentication', 'توثيق ذو عاملين', 'Twee-factor authenticatie', 'Authentification à deux facteurs', 'Zwei-Faktor-Authentifizierung', 'Autenticazione a due fattori', 'Autenticação de dois fatores', 'Двухфакторная аутентификация', 'Autenticación de dos factores', 'İki faktörlü kimlik doğrulama'),
(1371, '', NULL, 'turn_on_2-step_login_to_level-up_your_account_s_security__once_turned_on__you_ll_use_both_your_password_and_a_6-digit_security_code_sent_to_your_phone_or_email_to_log_in.', 'Turn on 2-step login to level-up your account&#039;s security, Once turned on, you&#039;ll use both your password and a 6-digit security code sent to your phone or email to log in.', 'قم بتشغيل تسجيل الدخول من خطوتين لتحسين مستوى حسابك', 'Schakel inloggen in twee stappen in om uw account een hoger niveau te geven', 'Activez la connexion en deux étapes pour augmenter votre compte', 'Aktivieren Sie die zweistufige Anmeldung, um Ihr Konto zu verbessern', 'Attiva l&#39;accesso in 2 passaggi per salire di livello nel tuo account', 'Ative o login em duas etapas para aumentar o nível da sua conta', 'Включите двухэтапный вход, чтобы повысить уровень своей учетной записи', 'Active el inicio de sesión en 2 pasos para subir de nivel su cuenta', 'Hesabınızı yükseltmek için 2 adımlı giriş özelliğini açın'),
(1372, '', NULL, 'two-factor_authentication_data_saved_successfully.', 'Two-factor authentication data saved successfully.', 'تم حفظ بيانات المصادقة ثنائية العوامل بنجاح.', 'Twee-factor authenticatiegegevens succesvol opgeslagen.', 'Les données d&#39;authentification à deux facteurs ont bien été enregistrées.', 'Zwei-Faktor-Authentifizierungsdaten wurden erfolgreich gespeichert.', 'Dati di autenticazione a due fattori salvati correttamente.', 'Dados de autenticação de dois fatores salvos com sucesso.', 'Данные двухфакторной аутентификации успешно сохранены.', 'Los datos de autenticación de dos factores se guardaron correctamente.', 'İki faktörlü kimlik doğrulama verileri başarıyla kaydedildi.'),
(1373, '', NULL, 'a_confirmation_email_has_been_sent.', 'A confirmation email has been sent.', '', '', 'Un e-mail de confirmation a été envoyé.', 'Eine Bestätigungs-E-Mail wurde gesendet.', 'È stata inviata una email di conferma.', 'Um email de confirmação foi enviado.', 'Письмо с подтверждением было отправлено.', 'Un correo electrónico de confirmación ha sido enviado.', 'Bir onay e-postası gönderildi.'),
(1374, '', NULL, 'we_have_sent_an_email_that_contains_the_confirmation_code_to_enable_two-factor_authentication.', 'We have sent an email that contains the confirmation code to enable Two-factor authentication.', 'لقد أرسلنا رسالة بريد إلكتروني تحتوي على رمز التأكيد لتمكين المصادقة الثنائية.', 'We hebben een e-mail verzonden met de bevestigingscode om tweefactorauthenticatie in te schakelen.', 'Nous avons envoyé un e-mail contenant le code de confirmation pour activer l&#39;authentification à deux facteurs.', 'Wir haben eine E-Mail gesendet, die den Bestätigungscode enthält, um die Zwei-Faktor-Authentifizierung zu aktivieren.', 'Abbiamo inviato un&#39;email contenente il codice di conferma per abilitare l&#39;autenticazione a due fattori.', 'Enviamos um email que contém o código de confirmação para ativar a autenticação de dois fatores.', 'Мы отправили электронное письмо с кодом подтверждения для включения двухфакторной аутентификации.', 'Hemos enviado un correo electrónico que contiene el código de confirmación para habilitar la autenticación de dos factores.', 'İki faktörlü kimlik doğrulamayı etkinleştirmek için onay kodunu içeren bir e-posta gönderdik.'),
(1375, '', NULL, 'confirmation_code', 'Confirmation code', 'رمز التأكيد', 'Bevestigingscode', 'Confirmation code', 'Bestätigungscode', 'Codice di conferma', 'Código de confirmação', 'Код подтверждения', 'Código de confirmación', 'Onay kodu'),
(1376, '', NULL, 'please_check_your_details.', 'Please check your details.', 'يرجى التأكد من تفاصيل معلوماتك.', 'Check alsjeblieft je gegevens.', 'S&#39;il vous plaît vérifier vos informations.', 'Bitte überprüfe deine Details.', 'Si prega di controllare i dettagli.', 'Por favor, verifique seus detalhes.', 'Пожалуйста, проверьте ваши данные.', 'Por favor comprueba tus detalles.', 'Lütfen bilgilerinizi kontrol edin.'),
(1377, '', NULL, 'your_e-mail_has_been_successfully_verified.', 'Your e-mail has been successfully verified.', 'تم التحقق من بريدك الإلكتروني بنجاح.', 'Uw e-mail is succesvol geverifieerd.', 'Votre e-mail a été vérifié avec succès.', 'Ihre E-Mail wurde erfolgreich überprüft.', 'La tua e-mail è stata verificata correttamente.', 'Seu email foi verificado com sucesso.', 'Ваш адрес электронной почты был успешно подтвержден.', 'Su correo electrónico ha sido verificado con éxito.', 'E-postanız başarıyla doğrulandı.');
INSERT INTO `langs` (`id`, `ref`, `options`, `lang_key`, `english`, `arabic`, `dutch`, `french`, `german`, `italian`, `portuguese`, `russian`, `spanish`, `turkish`) VALUES
(1378, '', NULL, 'phone_number_should_be_as_this_format___90..', 'Phone number should be as this format: +90..', 'يجب أن يكون رقم الهاتف بهذا الشكل: 90 ..', 'Telefoonnummer moet als dit formaat zijn: 90 ..', 'Le numéro de téléphone doit être au format suivant: 90 ..', 'Die Telefonnummer sollte das folgende Format haben: 90 ..', 'Il numero di telefono dovrebbe essere come questo formato: 90 ..', 'O número de telefone deve estar no seguinte formato: 90 ..', 'Номер телефона должен быть в таком формате: 90 ..', 'El número de teléfono debe tener este formato: 90 ..', 'Telefon numarası şu formatta olmalıdır: 90 ..'),
(1379, '', NULL, 'your_phone_number_and_e-mail_have_been_successfully_verified.', 'Your phone number and e-mail have been successfully verified.', 'تم التحقق من رقم هاتفك والبريد الإلكتروني بنجاح.', 'Uw telefoonnummer en e-mailadres zijn succesvol geverifieerd.', 'Votre numéro de téléphone et votre e-mail ont été vérifiés avec succès.', 'Ihre Telefonnummer und E-Mail-Adresse wurden erfolgreich überprüft.', 'Il tuo numero di telefono ed e-mail sono stati verificati correttamente.', 'Seu número de telefone e email foram verificados com sucesso.', 'Ваш номер телефона и адрес электронной почты были успешно проверены.', 'Su número de teléfono y correo electrónico han sido verificados con éxito.', 'Telefon numaranız ve e-postanız başarıyla doğrulandı.'),
(1380, '', NULL, 'unusual_login', 'Unusual Login', 'تسجيل دخول غير عادي', 'Ongebruikelijke login', 'Connexion inhabituelle', 'Ungewöhnliche Anmeldung', 'Login insolito', 'Login incomum', 'Необычный логин', 'Inicio de sesión inusual', 'Olağandışı Giriş'),
(1381, '', NULL, 'to_log_in__you_need_to_verify_your_identity.', 'To log in, you need to verify your identity.', 'لتسجيل الدخول ، تحتاج إلى التحقق من هويتك.', 'Om in te loggen, moet u uw identiteit verifiëren.', 'Pour vous connecter, vous devez vérifier votre identité.', 'Um sich anzumelden, müssen Sie Ihre Identität überprüfen.', 'Per accedere, è necessario verificare la tua identità.', 'Para fazer login, você precisa verificar sua identidade.', 'Для входа необходимо подтвердить свою личность.', 'Para iniciar sesión, debe verificar su identidad.', 'Giriş yapmak için kimliğinizi doğrulamanız gerekiyor.'),
(1382, '', NULL, 'we_have_sent_you_the_confirmation_code_to_your_phone_and_to_your_email_address.', 'We have sent you the confirmation code to your phone and to your email address.', 'لقد أرسلنا لك رمز التأكيد إلى هاتفك وعنوان بريدك الإلكتروني.', 'We hebben u de bevestigingscode naar uw telefoon en naar uw e-mailadres gestuurd.', 'Nous vous avons envoyé le code de confirmation sur votre téléphone et sur votre adresse e-mail.', 'Wir haben Ihnen den Bestätigungscode an Ihr Telefon und an Ihre E-Mail-Adresse gesendet.', 'Ti abbiamo inviato il codice di conferma sul tuo telefono e sul tuo indirizzo email.', 'Nós enviamos o código de confirmação para o seu telefone e seu endereço de e-mail.', 'Мы отправили вам код подтверждения на ваш телефон и на ваш адрес электронной почты.', 'Le hemos enviado el código de confirmación a su teléfono y a su dirección de correo electrónico.', 'Onay kodunu telefonunuza ve e-posta adresinize gönderdik.'),
(1383, '', NULL, 'we_have_sent_you_the_confirmation_code_to_your_email_address.', 'We have sent you the confirmation code to your email address.', 'لقد أرسلنا لك رمز التأكيد إلى عنوان بريدك الإلكتروني.', 'We hebben u de bevestigingscode naar uw e-mailadres gestuurd.', 'Nous vous avons envoyé le code de confirmation à votre adresse e-mail.', 'Wir haben Ihnen den Bestätigungscode an Ihre E-Mail-Adresse gesendet.', 'Ti abbiamo inviato il codice di conferma al tuo indirizzo email.', 'Enviámos o código de confirmação para o seu endereço de email.', 'Мы отправили вам код подтверждения на ваш адрес электронной почты.', 'Le hemos enviado el código de confirmación a su dirección de correo electrónico.', 'Size onay kodunu e-posta adresinize gönderdik.'),
(1384, '', NULL, 'please_enter_confirmation_code.', 'Please enter confirmation code.', 'الرجاء إدخال رمز التأكيد.', 'Voer de bevestigingscode in.', 'Veuillez saisir le code de confirmation.', 'Bitte geben Sie den Bestätigungscode ein.', 'Inserisci il codice di conferma', 'Digite o código de confirmação.', 'Пожалуйста, введите код подтверждения.', 'Por favor, introduzca el código de confirmación.', 'Lütfen onay kodunu girin.'),
(1385, '', NULL, 'something_went_wrong__please_try_again_later.', 'Something went wrong, please try again later.', 'هناك شئ خاطئ، يرجى المحاولة فى وقت لاحق.', 'Er is iets misgegaan. Probeer het later opnieuw.', 'Quelque chose c&#39;est mal passé. Merci d&#39;essayer plus tard.', 'Es ist ein Fehler aufgetreten. Bitte versuchen Sie es später erneut.', 'Qualcosa è andato storto, per favore riprova più tardi.', 'Ocorreu um erro. Tente novamente mais tarde.', 'Что-то пошло не так. Пожалуйста, повторите попытку позже.', 'Algo salió mal, por favor intente nuevamente más tarde.', 'Bir şeyler yanlış oldu. Lütfen sonra tekrar deneyiniz.'),
(1386, '', NULL, 'wrong_confirmation_code.', 'Wrong confirmation code.', 'رمز التأكيد الخاطئ.', 'Verkeerde bevestigingscode.', 'Code de confirmation incorrect.', 'Falscher Bestätigungscode.', 'Codice di conferma errato.', 'Código de confirmação incorreto.', 'Неверный код подтверждения.', 'Código de confirmación incorrecto.', 'Yanlış onay kodu.'),
(1387, '', NULL, 'error_while_login__please_try_again_later.', 'Error while login, please try again later.', 'خطأ أثناء تسجيل الدخول ، يرجى المحاولة مرة أخرى لاحقًا.', 'Fout tijdens inloggen, probeer het later opnieuw.', 'Erreur lors de la connexion, veuillez réessayer plus tard.', 'Fehler beim Anmelden, versuchen Sie es später erneut.', 'Errore durante l&#39;accesso, riprovare più tardi.', 'Erro durante o login, tente novamente mais tarde.', 'Ошибка при входе, повторите попытку позже.', 'Error al iniciar sesión, intente nuevamente más tarde.', 'Giriş yapılırken hata oluştu, lütfen daha sonra tekrar deneyin.'),
(1388, '', NULL, 'invalid_user_id', 'Invalid User ID', 'هوية مستخدم غير صالحه', 'Ongeldige gebruikersnaam', 'Identifiant invalide', 'Ungültige Benutzer-Id', 'ID utente non valido', 'ID de usuário inválido', 'Неверный идентификатор пользователя', 'ID de usuario invalido', 'Geçersiz kullanıcı kimliği'),
(1389, '', NULL, 'invalid_confirmation_code', 'Invalid confirmation code', 'رمز التأكيد غير صالح', 'Ongeldige bevestigingscode', 'code de confirmation invalide', 'ungültiger Bestätigungscode', 'Codice di conferma non valido', 'Código de confirmação inválido', 'неверный код подтверждения', 'Código de confirmación inválido', 'Geçersiz onay kodu'),
(1390, '', NULL, 'find_potential_matches_by_country', 'Find potential matches by country', 'البحث عن التطابقات المحتملة حسب البلد', 'Vind potentiële overeenkomsten per land', 'Trouver des correspondances potentielles par pays', 'Finden Sie mögliche Übereinstimmungen nach Land', 'Trova potenziali corrispondenze per paese', 'Encontre possíveis correspondências por país', 'Найти потенциальные совпадения по стране', 'Encuentra posibles coincidencias por país', 'Ülkelere göre potansiyel eşleşmeleri bulun'),
(1391, '', NULL, 'manage_notifications', 'Manage Notifications', 'إدارة الإخطارات', 'Beheer meldingen', 'Manage Notifications', 'Benachrichtigungen verwalten', 'Gestisci notifiche', 'Gerenciar notificações', 'Управление уведомлениями', 'Administrar notificaciones', 'Bildirimleri Yönet'),
(1392, '', NULL, 'custom_field', 'Custom field', 'حقل مخصص', 'Aangepast veld', 'Champ personnalisé', 'Benutzerdefinierte Feld', 'Campo personalizzato', 'Campo customizado', 'Пользовательское поле', 'Campo personalizado', 'Özel alan'),
(1393, '', NULL, 'food', 'food', 'طعام', 'voedsel', 'nourriture', 'Essen', '', '', 'питание', '', ''),
(1394, '', NULL, 'add_media', 'Add Media', 'إضافة وسائل الإعلام', 'Voeg media toe', 'Ajouter des médias', 'Medien hinzufügen', 'Add Media', 'Adicionar mídia', 'Добавить медиа', 'Agregar medios', 'Medya ekle'),
(1395, '', NULL, 'add_video', 'Add Video', 'أضف فيديو', 'Voeg video toe', 'Ajouter une vidéo', 'Video hinzufügen', 'Aggiungi video', 'Adicionar vídeo', 'Добавить видео', 'Añadir video', 'Video ekle'),
(1396, '', NULL, 'add_photo', 'Add Photo', 'إضافة صورة', 'Voeg foto toe', 'Ajouter une photo', 'Foto hinzufügen', 'Aggiungi foto', 'Adicionar foto', 'Добавить фото', 'Añadir foto', 'Fotoğraf ekle'),
(1397, '', NULL, 'upload', 'Upload', 'رفع', 'Uploaden', 'Télécharger', 'Hochladen', 'Caricare', 'Envio', 'Загрузить', 'Subir', 'Yükleme'),
(1398, '', NULL, 'video_title', 'Video Title', 'عنوان مقطع الفيديو', 'titel van de video', 'titre de la vidéo', 'Videotitel', 'Titolo del video', 'Título do vídeo', 'Название видео', 'Titulo del Video', 'video başlığı'),
(1399, '', NULL, 'public', 'Public', 'عامة', 'Openbaar', 'Public', 'Öffentlichkeit', 'Pubblico', 'Público', 'общественного', 'Público', 'halka açık'),
(1400, '', NULL, 'private', 'Private', 'نشر', 'Privaat', 'Privé', 'Privat', 'Privato', 'Privado', 'Частный', 'Privado', 'Özel'),
(1401, '', NULL, 'thumbnail', 'Thumbnail', 'ظفري', 'thumbnail', 'La vignette', 'Miniaturansicht', '', '', 'Thumbnail', '', ''),
(1402, '', NULL, 'my_affiliates', 'My affiliates', 'الشركات التابعة لي', 'Mijn aangeslotenen', 'Mes affiliés', 'Meine Partner', 'I miei affiliati', 'Meus afiliados', 'Мои филиалы', 'Mis afiliados', 'İştiraklerim'),
(1403, '', NULL, 'your_affiliate_link_is', 'Your affiliate link is', 'الارتباط التابع الخاص بك هو', 'Uw partnerlink is', 'Votre lien d&#39;affiliation est', 'Ihr Affiliate-Link ist', 'Il tuo link di affiliazione è', 'O seu link de afiliado é', 'Ваша партнерская ссылка', 'Su enlace de afiliado es', 'Satış ortağı bağlantınız'),
(1404, '', NULL, 'my_balance', 'My balance', 'رصيدي', 'Mijn balans', 'Mon solde', 'Mein Gleichgewicht', 'Il mio saldo', 'Meu saldo', 'Мой баланс', 'Mi balance', 'Benim dengem'),
(1405, '', NULL, 'earn_up_to', 'Earn up to', 'تكسب ما يصل الى', 'Verdien maximaal', 'Gagnez jusqu&#39;à', 'Verdienen bis zu', 'Guadagna fino a', 'Ganhe até', 'Заработай до', 'Ganar hasta', 'Kadar kazanın'),
(1406, '', NULL, 'for_each_user_your_refer_to_us__', 'for each user your refer to us !', 'لكل مستخدم يرجى الرجوع إلينا!', 'voor elke gebruiker verwijst u naar ons!', 'pour chaque utilisateur vous nous référez!', 'Für jeden Benutzer verweisen Sie auf uns!', 'per ogni utente fai riferimento a noi!', 'para cada usuário, consulte-nos!', 'для каждого пользователя вы обращаетесь к нам!', '¡para cada usuario, refiérase a nosotros!', 'her kullanıcı için bize bakın!'),
(1407, '', NULL, 'joined', 'joined', 'انضم', 'toegetreden', 'rejoint', 'beigetreten', 'Iscritto', 'juntou', 'присоединился', 'unido', 'katıldı'),
(1408, '', NULL, 'payments', 'Payments', 'المدفوعات', 'betalingen', 'Paiements', 'Zahlungen', 'pagamenti', 'Pagamentos', 'платежи', 'Pagos', 'Ödemeler'),
(1409, '', NULL, 'your_balance_is', 'Your balance is', 'رصيدك هو', 'Je saldo is', 'Votre équilibre est', 'Ihr Gleichgewicht ist', 'Il tuo saldo è', 'Seu saldo é', 'Ваш баланс', 'Su balance es', 'Bakiyeniz'),
(1410, '', NULL, '__minimum_withdrawal_request_is', ', minimum withdrawal request is', '، طلب السحب الأدنى هو', ', minimaal opnameverzoek is', ', la demande de retrait minimum est', ', Mindestauszahlungsanforderung ist', ', la richiesta di prelievo minima è', ', o pedido mínimo de retirada é', 'минимальный запрос на снятие средств', ', la solicitud de retiro mínimo es', ', minimum para çekme talebi'),
(1411, '', NULL, 'paypal_email', 'PayPal email', 'بريد باي بال', 'Paypal E-mail', 'PayPal email', 'Paypal Email', 'Email PayPal', 'Email do Paypal', 'Электронная почта PayPal', 'E-mail de Paypal', 'PayPal e-postası'),
(1412, '', NULL, 'request_withdrawal', 'Request withdrawal', 'طلب السحب', 'Verzoek tot intrekking', 'Demande de retrait', 'Rücknahme beantragen', 'Richiedi il ritiro', 'Solicitar retirada', 'Запрос на снятие', 'Solicitud de retirada', 'Para çekme isteği'),
(1413, '', NULL, 'your_request_has_been_sent__you__039_ll_receive_an_email_regarding_the_payment_details_soon.', 'Your request has been sent, you&#039;ll receive an email regarding the payment details soon.', 'تم ارسال طلبك', 'Uw aanvraag is verzonden, u', 'Votre demande a été envoyée, vous', 'Ihre Anfrage wurde gesendet, Sie', 'La tua richiesta è stata inviata, tu', 'Sua solicitação foi enviada, você', 'Ваш запрос был отправлен, вы', 'Su solicitud ha sido enviada, usted', 'Talebiniz gönderildi, siz'),
(1414, '', NULL, 'requested', 'requested', 'طلب', 'aangevraagd', 'demandé', 'angefordert', 'richiesto', 'Requeridos', 'запрошенный', 'pedido', 'talep edilen'),
(1415, '', NULL, 'payment_history', 'Payment history', 'تاريخ الدفع', 'Betaalgeschiedenis', 'Historique de paiement', 'Zahlungshistorie', 'Storico dei pagamenti', 'Histórico de pagamento', 'История платежей', 'Historial de pagos', 'Ödeme geçmişi'),
(1416, '', NULL, 'approved', 'approved', 'وافق', 'goedgekeurd', 'approuvé', 'genehmigt', 'approvato', 'aprovado', 'одобренный', 'aprobado', 'onaylandı'),
(1417, '', NULL, 'invalid_amount_value__your_amount_is_', 'Invalid amount value, your amount is:', 'قيمة المبلغ غير صالحة ، المبلغ الخاص بك هو:', 'Ongeldige bedragwaarde, uw bedrag is:', 'Valeur de montant non valide, votre montant est:', 'Ungültiger Betragswert, Ihr Betrag ist:', 'Valore dell&#39;importo non valido, l&#39;importo è:', 'Valor de valor inválido, seu valor é:', 'Неверное значение суммы, ваша сумма:', 'Valor de importe no válido, su importe es:', 'Geçersiz tutar değeri, tutarınız:'),
(1418, '', NULL, 'add_friend', 'Add Friend', 'أضف صديق', 'Vriend toevoegen', 'Ajouter un ami', 'Freund hinzufügen', 'Aggiungi amico', 'Adicionar amigo', 'Добавить друга', 'Añadir amigo', 'Arkadaş Ekle'),
(1419, '', NULL, 'unfriend', 'UnFriend', 'unfriend', 'unfriend', 'UnFriend', 'Unfreundlich', 'unfriend', 'UnFriend', 'Unfriend', 'No amigo', 'unfriend'),
(1420, '', NULL, 'friend_request_sent', 'Friend request sent', 'تم ارسال طلب صداقة', 'Vriendschapsverzoek verzonden', 'Demande d&#39;ami envoyée', 'Freundschaftsanfrage gesendet', 'Richiesta di amicizia inviata', 'Pedido de amizade enviado', 'Запрос на добавление в друзья', 'Solicitud de amistad enviada', 'Arkadaşlık isteği gönderildi'),
(1421, '', NULL, 'you_already_sent_friend_request.', 'You have already sent a request.', 'لقد قمت بالفعل بإرسال طلب.', 'U heeft al een aanvraag verzonden.', 'Vous avez déjà envoyé une demande.', 'Sie haben bereits eine Anfrage gesendet.', 'Hai già inviato una richiesta.', 'Você já enviou uma solicitação.', 'Вы уже отправили запрос.', 'Ya has enviado una solicitud.', 'Zaten bir istek gönderdiniz.'),
(1422, '', NULL, 'success', 'Success', 'نجاح', 'Succes', 'Succès', 'Erfolg', 'Successo', 'Sucesso', 'успех', 'Éxito', 'başarı'),
(1423, '', NULL, 'confirm_request_when_someone_follows_you__', 'Confirm request when someone follows you?', 'تأكيد الطلب عندما يتبعك شخص ما؟', 'Verzoek bevestigen wanneer iemand je volgt?', 'Confirmer la demande lorsque quelqu&#39;un vous suit?', 'Anfrage bestätigen, wenn Ihnen jemand folgt?', 'Conferma la richiesta quando qualcuno ti segue?', 'Confirmar solicitação quando alguém segue você?', 'Подтвердить запрос, когда кто-то следует за вами?', '¿Confirmar solicitud cuando alguien te sigue?', 'Biri sizi takip ettiğinde talebi onaylamak istiyor musunuz?'),
(1424, '', NULL, 'confirm_request_when_someone_request_friend_you__', 'Confirm request when someone request to be a friend with you?', 'تأكيد الطلب عندما يطلب شخص ما أن يكون صديقا معك؟', 'Verzoek bevestigen wanneer iemand een vriend om jou wil zijn?', 'Confirmer la demande lorsque quelqu&#39;un demande à devenir ami avec vous?', 'Anfrage bestätigen, wenn jemand darum bittet, mit Ihnen befreundet zu sein?', 'Conferma la richiesta quando qualcuno richiede di essere amico di te?', 'Confirmar solicitação quando alguém solicitar para ser seu amigo?', 'Подтвердите запрос, когда кто-то запросит дружить с вами?', '¿Confirmar solicitud cuando alguien solicita ser un amigo con usted?', 'Birisi sizinle arkadaş olmak istediğinde isteği onaylamak istiyor musunuz?'),
(1425, '', NULL, 'created_a_story_with_you.', 'created a story with you.', 'خلق قصة معك.', 'creëerde een verhaal met jou.', 'créé une histoire avec vous.', 'hat mit dir eine Geschichte erstellt.', 'creato una storia con te.', 'criou uma história com você.', 'создал историю с вами.', 'Creé una historia contigo.', 'seninle bir hikaye yarattı.'),
(1426, '', NULL, 'accepted_your_friend_request.', 'accepted your friend request.', 'قبلت طلب صديقك.', 'jouw vriendschapsverzoek geaccepteerd.', 'accepté votre demande d&#39;ami.', 'hat deine Freundschaftsanfrage akzeptiert.', 'ha accettato la tua richiesta di amicizia.', 'aceitou seu pedido de amizade.', 'принял ваш запрос на добавление в друзья.', 'acepté tu solicitud de amistad.', 'arkadaşlık isteğin kabul edildi.'),
(1427, '', NULL, 'declined_your_friend_request.', 'declined your friend request.', 'رفض طلب صديقك.', 'heeft je vriendschapsverzoek afgewezen.', 'a refusé votre demande d&#39;ami.', 'lehnte Ihre Freundschaftsanfrage ab.', 'ha rifiutato la tua richiesta di amicizia.', 'recusou o seu pedido de amizade.', 'отклонил ваш запрос на добавление в друзья.', 'rechazó su solicitud de amistad.', 'arkadaşlık isteğini reddetti.'),
(1428, '', NULL, 'send_friend_request_to_you.', 'requested to be a friend with you.', 'طلب أن يكون صديقا معك.', 'gevraagd om een ​​vriend bij je te zijn.', 'a demandé à être un ami avec vous.', 'gebeten, mit dir befreundet zu sein.', 'richiesto di essere un amico con te.', 'solicitado para ser um amigo com você.', 'просил дружить с тобой.', 'solicitó ser un amigo contigo.', 'seninle arkadaş olmak istedi.'),
(1429, '', NULL, 'friend_requests', 'Friend requests', 'طلبات صداقة', 'Vriendschapsverzoeken', 'Demandes d&#39;ami', 'Freundschaftsanfragen', 'Richieste di amicizia', 'Pedidos de amizade', 'Запросы в друзья', 'Peticiones de amistad', 'Arkadaş istekleri'),
(1430, '', NULL, 'is_now_in_friend_list.', 'is now in your friend list.', 'هو الآن في قائمة الأصدقاء الخاصة بك.', 'staat nu in uw vriendenlijst.', 'est maintenant dans votre liste d&#39;amis.', 'ist jetzt in deiner Freundesliste.', 'è ora nella tua lista amici.', 'está agora na sua lista de amigos.', 'сейчас в вашем списке друзей.', 'ahora está en tu lista de amigos.', 'şimdi arkadaş listenizde.'),
(1431, '', NULL, 'decline_request', 'Decline request', 'رفض الطلب', 'Verzoek weigeren', 'Demande de refus', 'Anfrage ablehnen', 'Rifiuta richiesta', 'Recusar solicitação', 'Отклонить запрос', 'Rechazar solicitud', 'İsteği reddet'),
(1432, '', NULL, 'accept_request', 'Accept request', 'قبول الطلب', 'Accepteer verzoek', 'Accepter la requête', 'Anfrage annehmen', 'Richiesta accettata', 'Aceitar pedido', 'Принять запрос', 'Aceptar petición', 'kabul et isteği'),
(1433, '', NULL, 'request_your_friendship.', 'requested to be your friend.', 'اطلب صداقتك', 'vraag je vriendschap.', 'demandez votre amitié.', 'Bitte um deine Freundschaft.', 'richiedi la tua amicizia.', 'solicite sua amizade.', 'просить вашей дружбы.', 'solicita tu amistad', 'arkadaşlık iste.'),
(1434, '', NULL, 'can_not_create_notification', 'can not create notification', 'لا يمكن إنشاء إشعار', 'kan geen melding maken', 'ne peut pas créer de notification', 'kann keine Benachrichtigung erstellen', 'impossibile creare la notifica', 'não pode criar notificação', 'не может создать уведомление', 'no se puede crear una notificación', 'bildirim oluşturulamıyor'),
(1435, '', NULL, 'pending_review', 'pending review', 'في انتظار المراجعة', 'in afwachting van beoordeling', 'en attendant l&#39;examen', 'ausstehende Bewertung', 'Revisione in atto', 'revisão pendente', 'ожидает оценки', 'revisión pendiente', 'bekleyen yorum'),
(1436, '', NULL, 'the_username_is_blacklisted_and_not_allowed__please_choose_another_username.', 'The username is blacklisted and not allowed, please choose another username.', 'اسم المستخدم مدرج في القائمة السوداء وغير مسموح به ، يرجى اختيار اسم مستخدم آخر.', 'De gebruikersnaam staat op de zwarte lijst en is niet toegestaan, kies een andere gebruikersnaam.', 'Le nom d&#39;utilisateur est sur liste noire et n&#39;est pas autorisé, veuillez choisir un autre nom d&#39;utilisateur.', 'Der Benutzername ist auf der schwarzen Liste und nicht erlaubt. Bitte wählen Sie einen anderen Benutzernamen.', 'Il nome utente è nella lista nera e non è consentito, scegli un altro nome utente.', 'O nome de usuário está na lista negra e não é permitido. Escolha outro nome de usuário.', 'Имя пользователя занесено в черный список и не допускается, выберите другое имя пользователя.', 'El nombre de usuario está en la lista negra y no está permitido, elija otro nombre de usuario.', 'Kullanıcı adı kara listede ve izin verilmiyor, lütfen başka bir kullanıcı adı seçin.'),
(1437, '', NULL, 'the_email_provider_is_blacklisted_and_not_allowed__please_choose_another_email_provider.', 'The email provider is blacklisted and not allowed, please choose another email provider.', 'مزود البريد الإلكتروني مدرج في القائمة السوداء وغير مسموح به ، يرجى اختيار مزود بريد إلكتروني آخر.', 'De e-mailprovider staat op de zwarte lijst en is niet toegestaan. Kies een andere e-mailprovider.', 'Le fournisseur de messagerie est sur liste noire et n&#39;est pas autorisé, veuillez choisir un autre fournisseur de messagerie.', 'Der E-Mail-Anbieter ist auf der schwarzen Liste und nicht zulässig. Bitte wählen Sie einen anderen E-Mail-Anbieter.', 'Il provider di posta elettronica è nella lista nera e non è consentito, scegli un altro provider di posta elettronica.', 'O provedor de email está na lista negra e não é permitido. Escolha outro provedor de email.', 'Поставщик электронной почты находится в черном списке и не допускается, выберите другого поставщика электронной почты.', 'El proveedor de correo electrónico está en la lista negra y no está permitido, elija otro proveedor de correo electrónico.', 'E-posta sağlayıcısı kara listeye alındı ​​ve izin verilmiyor, lütfen başka bir e-posta sağlayıcısı seçin.'),
(1438, '', NULL, 'latest__0__users.', 'Latest {0} users.', 'أحدث {0} مستخدم.', 'Laatste {0} gebruikers.', 'Derniers {0} utilisateurs.', 'Neueste {0} Benutzer.', 'Ultimi {0} utenti.', 'Últimos {0} usuários.', 'Последние {0} пользователей.', 'Últimos {0} usuarios.', 'En son {0} kullanıcı.'),
(1439, '', NULL, 'you_reach_to_limit_of_media_uploads.', 'You have reached the limit of media uploads.', 'لقد وصلت إلى الحد الأقصى لعمليات تحميل الوسائط.', 'Je hebt de limiet van media-uploads bereikt.', 'Vous avez atteint la limite des téléchargements multimédias.', 'Sie haben das Limit für das Hochladen von Medien erreicht.', 'Hai raggiunto il limite di caricamenti multimediali.', 'Você atingiu o limite de uploads de mídia.', 'Вы достигли лимита загрузки медиафайлов.', 'Has alcanzado el límite de carga de medios.', 'Medya yükleme sınırına ulaştınız.'),
(1440, '', NULL, 'email_sent_to', 'Email sent to', 'تم إرسال البريد الإلكتروني إلى', 'Email verzonden naar', 'Email envoyé à', 'Email an gesendet', 'Email inviata a', 'Email enviado para', 'Е-мейл отправлен', 'Correo electrónico enviado a', 'Adresine e-posta gönderildi'),
(1441, '', NULL, 'error_while_sending_emails', 'Error while sending emails', 'خطأ أثناء إرسال رسائل البريد الإلكتروني', 'Fout tijdens het verzenden van e-mails', 'Erreur lors de l&#39;envoi d&#39;e-mails', 'Fehler beim Senden von E-Mails', 'Errore durante l&#39;invio di e-mail', 'Erro ao enviar e-mails', 'Ошибка при отправке писем', 'Error al enviar correos electrónicos', 'E-posta gönderilirken hata oluştu'),
(1442, '', NULL, 'under_review', 'Under Review', 'قيد المراجعة', 'Wordt beoordeeld', 'À l&#39;étude', 'Wird überprüft', 'In corso di revisione', 'Sob revisão', 'На рассмотрении', 'Bajo revisión', 'İnceleme altında'),
(1443, '', NULL, 'id', 'id', '', '', '', '', '', '', '', '', ''),
(1444, '', NULL, 'ref', 'ref', '', '', '', '', '', '', '', '', ''),
(1445, '', NULL, 'lang_key', 'lang_key', '', '', '', '', '', '', '', '', ''),
(1446, '', NULL, 'unlock_private_photo_payment', 'Unlock Private Photo Feature', 'فتح ميزة الصور الخاصة', 'Ontgrendel de privéfotofunctie', 'Déverrouiller la fonction de photo privée', 'Entsperren Sie die Funktion für private Fotos', 'Sblocca funzione foto privata', 'Desbloquear recurso de foto privada', 'Разблокировать частную функцию фото', 'Desbloquear la función de foto privada', 'Özel Fotoğraf Özelliğinin Kilidini Aç'),
(1447, '', NULL, 'to_unlock_private_photo_feature_in_your_account__you_have_to_pay', 'To unlock private photo feature in your account, you can purchase it.', 'لإلغاء قفل ميزة الصورة الخاصة في حسابك ، يمكنك شرائها.', 'Om een ​​privéfoto-functie in uw account te ontgrendelen, kunt u deze kopen.', 'Pour déverrouiller la fonction de photo privée dans votre compte, vous pouvez l\'acheter.', 'Um die Funktion für private Fotos in Ihrem Konto freizuschalten, können Sie sie erwerben.', 'Per sbloccare la funzione foto privata nel tuo account, puoi acquistarla.', 'Para desbloquear o recurso de foto privada em sua conta, você pode comprá-lo.', 'Чтобы разблокировать функцию приватной фотографии в своей учетной записи, вы можете приобрести ее.', 'Para desbloquear la función de foto privada en su cuenta, puede comprarla.', 'Hesabınızdaki özel fotoğraf özelliğinin kilidini açmak için satın alabilirsiniz.'),
(1448, '', NULL, 'unlock_private_photo_feature', 'Unlock Private Photo Feature', 'فتح ميزة الصور الخاصة', 'Ontgrendel de privéfotofunctie', 'Déverrouiller la fonction de photo privée', 'Entsperren Sie die Funktion für private Fotos', 'Sblocca funzione foto privata', 'Desbloquear recurso de foto privada', 'Разблокировать частную функцию фото', 'Desbloquear la función de foto privada', 'Özel Fotoğraf Özelliğinin Kilidini Aç'),
(1449, '', NULL, 'to_unlock_video_upload_feature_in_your_account__you_have_to_pay', 'To unlock private photo feature in your account, you can purchase it.', 'لإلغاء قفل ميزة الصورة الخاصة في حسابك ، يمكنك شرائها.', 'Om een ​​privéfoto-functie in uw account te ontgrendelen, kunt u deze kopen.', 'Pour déverrouiller la fonction de photo privée dans votre compte, vous pouvez l\'acheter.', 'Um die Funktion für private Fotos in Ihrem Konto freizuschalten, können Sie sie erwerben.', 'Per sbloccare la funzione foto privata nel tuo account, puoi acquistarla.', 'Para desbloquear o recurso de foto privada em sua conta, você pode comprá-lo.', 'Чтобы разблокировать функцию приватной фотографии в своей учетной записи, вы можете приобрести ее.', 'Para desbloquear la función de foto privada en su cuenta, puede comprarla.', 'Hesabınızdaki özel fotoğraf özelliğinin kilidini açmak için satın alabilirsiniz.'),
(1450, '', NULL, 'unlock_upload_video_feature', 'Unlock Upload Video Feature', 'فتح ميزة تحميل الفيديو', 'Ontgrendel Upload Video-functie', 'Déverrouiller la fonction de téléchargement de vidéo', 'Entsperren Sie die Upload-Videofunktion', 'Sblocca la funzione Carica video', 'Desbloquear o recurso Carregar vídeo', 'Разблокировать Загрузить видео', 'Desbloquear la función Subir video', 'Video Yükleme Özelliğinin Kilidini Aç'),
(1451, '', NULL, 'unlock_video_upload_feature', 'Unlock Upload Video Feature', 'فتح ميزة تحميل الفيديو', 'Ontgrendel Upload Video-functie', 'Déverrouiller la fonction de téléchargement de vidéo', 'Entsperren Sie die Upload-Videofunktion', 'Sblocca la funzione Carica video', 'Desbloquear o recurso Carregar vídeo', 'Разблокировать Загрузить видео', 'Desbloquear la función Subir video', 'Video Yükleme Özelliğinin Kilidini Aç'),
(1452, '', NULL, 'please_upload_a_photo_with_your_passport___id____your_distinct_photo', 'Please upload a photo with your passport / ID  &amp; your distinct picture.', 'يرجى تحميل صورة مع جواز سفرك / هويتك وصورتك المميزة.', 'Upload een foto met uw paspoort / ID en uw eigen foto.', 'Veuillez télécharger une photo avec votre passeport / pièce d\'identité et votre photo distincte.', 'Bitte laden Sie ein Foto mit Ihrem Reisepass / Ausweis und Ihrem eigenen Bild hoch.', 'Carica una foto con il tuo passaporto / ID e la tua immagine distinta.', 'Faça o upload de uma foto com seu passaporte / ID e sua imagem distinta.', 'Пожалуйста, загрузите фотографию с вашим паспортом / удостоверением личности и отличной фотографией.', 'Cargue una foto con su pasaporte / identificación y su fotografía distintiva.', 'Lütfen pasaportunuz / kimliğiniz ve farklı resminizle bir fotoğraf yükleyin.'),
(1453, '', NULL, 'credit_reward', 'Credit Reward', 'مكافأة الائتمان', 'Kredietbeloning', 'Récompense de crédit', 'Kreditbelohnung', 'Ricompensa di credito', 'Recompensa de crédito', 'Кредитное вознаграждение', 'Recompensa de crédito', 'Kredi Ödülü'),
(1454, '', NULL, 'congratulation_._you_login_to_our_site_for', 'Congratulation! you logged in to our site for', 'تهنئة! ', 'Gefeliciteerd! ', 'Félicitations! ', 'Glückwunsch! ', 'Complimenti! ', 'Parabéns! ', 'Поздравляем! ', 'Enhorabuena! ', 'Tebrik! '),
(1455, '', NULL, 'and_you_earn', 'and you will earn', 'وسوف تكسب', 'en je zult verdienen', 'et tu gagneras', 'und du wirst verdienen', 'e guadagnerai', 'e você ganhará', 'и ты заработаешь', 'y ganarás', 've sen kazanacaksın'),
(1456, '', NULL, 'user_who_logs_in_consecutively_for', 'Anyone who logs in consecutively for', 'أي شخص يقوم بتسجيل الدخول على التوالي', 'Iedereen die achtereenvolgens inlogt voor', 'Quiconque se connecte consécutivement pour', 'Jeder, der sich nacheinander für anmeldet', 'Chiunque acceda consecutivamente per', 'Qualquer pessoa que efetue login consecutivamente', 'Любой, кто входит в систему последовательно для', 'Cualquiera que inicie sesión consecutivamente', 'Arka arkaya oturum açan herkes'),
(1457, '', NULL, 'you_currently_logged_in_for', 'You currently logged in for', 'قمت بتسجيل الدخول حاليا ل', 'U bent momenteel aangemeld voor', 'Vous êtes actuellement connecté pour', 'Sie haben sich derzeit angemeldet für', 'Hai effettuato l\'accesso per', 'Você está logado no momento', 'Вы вошли в систему для', 'Has iniciado sesión en', 'Şu anda giriş yaptınız'),
(1458, '', NULL, 'your_account_is_waiting_admin_approval.', 'Thank you, Your account is waiting admin approval.', 'شكرا لك ، حسابك ينتظر موافقة المشرف.', 'Bedankt, uw account wacht op goedkeuring door de beheerder.', 'Merci, votre compte attend l\'approbation de l\'administrateur.', 'Vielen Dank, Ihr Konto wartet auf die Genehmigung durch den Administrator.', 'Grazie, il tuo account è in attesa dell\'approvazione dell\'amministratore.', 'Obrigado, sua conta está aguardando aprovação do administrador.', 'Спасибо. Ваш аккаунт ожидает одобрения администратора.', 'Gracias, su cuenta está esperando la aprobación del administrador.', 'Teşekkürler, hesabınız yönetici onayını bekliyor.'),
(1459, '', NULL, 'friend-requests', 'Friend Requests', 'طلبات صداقة', 'Vriendschapsverzoeken', 'Demandes d\'ami', 'Freundschaftsanfragen', 'Richieste di amicizia', 'Pedidos de amizade', 'Запросы в друзья', 'Peticiones de amistad', 'Arkadaş istekleri'),
(1460, '', NULL, 'notifications_single', 'Notifications', 'إشعارات', 'Kennisgevingen', 'Notifications', 'Benachrichtigungen', 'notifiche', 'Notificações', 'Уведомления', 'Notificaciones', 'Bildirimler'),
(1461, '', NULL, 'for_each_user_your_refer_to_us_and_bought_a_pro_package___credit', 'For every user your refer to us and bought a pro package or credits', 'لكل مستخدم الرجوع إلينا واشترى حزمة أو ائتمانات للمحترفين', 'Voor elke gebruiker verwijs je naar ons en heb je een pro pakket of credits gekocht', 'Pour chaque utilisateur que vous nous référez et avez acheté un package pro ou des crédits', 'Für jeden Benutzer verweisen Sie auf uns und kaufen ein Pro-Paket oder Credits', 'Per ogni utente fai riferimento a noi e hai acquistato un pacchetto pro o crediti', 'Para cada usuário, consulte-nos e compre um pacote ou créditos profissionais', 'Для каждого пользователя вы обращаетесь к нам и покупаете профессиональный пакет или кредиты', 'Por cada usuario, consulte con nosotros y compre un paquete profesional o créditos', 'Her kullanıcı için bize referans verin ve profesyonel bir paket veya kredi satın alın'),
(1462, '', NULL, 'find-matches', 'find-matches', 'البحث عن التطابقات', 'vind-overeenkomsten', 'trouver des correspondances', 'Übereinstimmungen finden', 'trovare-matches', 'encontrar-correspondências', 'найти-матчи', 'encontrar coincidencias', '-Eşleşmeleri bulmak'),
(1463, '', NULL, 'gifts', 'Gifts', 'هدايا', 'Geschenken', 'Cadeaux', 'Geschenke', 'I regali', 'Presentes', 'Подарки', 'Regalos', 'Hediyeler'),
(1464, '', NULL, 'send_to_you', 'sent to you.', 'مرسلة إليك.', 'gestuurd naar jou.', 'envoyé a toi.', 'zu dir gesendet.', 'inviato a te.', 'enviado a você.', 'отправил вам.', 'enviado a ti.', 'sana gönderildi.'),
(1465, '', NULL, 'no_more_gifts_to_show.', 'No gifts to show.', 'لا توجد هدايا لإظهارها.', 'Geen geschenken om te laten zien.', 'Aucun cadeau à montrer.', 'Keine Geschenke zu zeigen.', 'Nessun regalo da mostrare.', 'Não há presentes para mostrar.', 'Нет подарков для показа.', 'No hay regalos para mostrar.', 'Gösterilecek hediye yok.'),
(1466, 'country', '004', 'AF%', 'Afghanistan', 'Afghanistan', 'Afghanistan', 'Afghanistan', 'Afghanistan', 'Afghanistan', 'Afghanistan', 'Afghanistan', 'Afghanistan', 'Afghanistan'),
(1467, 'country', '248', 'AX', 'Åland Islands', 'Åland Islands', 'Åland Islands', 'Åland Islands', 'Åland Islands', 'Åland Islands', 'Åland Islands', 'Åland Islands', 'Åland Islands', 'Åland Islands'),
(1468, 'country', '008', 'AL', 'Albania', 'Albania', 'Albania', 'Albania', 'Albania', 'Albania', 'Albania', 'Albania', 'Albania', 'Albania'),
(1469, 'country', '012', 'DZ', 'Algeria', 'Algeria', 'Algeria', 'Algeria', 'Algeria', 'Algeria', 'Algeria', 'Algeria', 'Algeria', 'Algeria'),
(1470, 'country', '016', 'AS', 'American Samoa', 'American Samoa', 'American Samoa', 'American Samoa', 'American Samoa', 'American Samoa', 'American Samoa', 'American Samoa', 'American Samoa', 'American Samoa'),
(1471, 'country', '020', 'AD', 'Andorra', 'Andorra', 'Andorra', 'Andorra', 'Andorra', 'Andorra', 'Andorra', 'Andorra', 'Andorra', 'Andorra'),
(1472, 'country', '024', 'AO', 'Angola', 'Angola', 'Angola', 'Angola', 'Angola', 'Angola', 'Angola', 'Angola', 'Angola', 'Angola'),
(1473, 'country', '660', 'AI', 'Anguilla', 'Anguilla', 'Anguilla', 'Anguilla', 'Anguilla', 'Anguilla', 'Anguilla', 'Anguilla', 'Anguilla', 'Anguilla'),
(1474, 'country', '010', 'AQ', 'Antarctica', 'Antarctica', 'Antarctica', 'Antarctica', 'Antarctica', 'Antarctica', 'Antarctica', 'Antarctica', 'Antarctica', 'Antarctica'),
(1475, 'country', '028', 'AG', 'Antigua and Barbuda', 'Antigua and Barbuda', 'Antigua and Barbuda', 'Antigua and Barbuda', 'Antigua and Barbuda', 'Antigua and Barbuda', 'Antigua and Barbuda', 'Antigua and Barbuda', 'Antigua and Barbuda', 'Antigua and Barbuda'),
(1476, 'country', '032', 'AR', 'Argentina', 'Argentina', 'Argentina', 'Argentina', 'Argentina', 'Argentina', 'Argentina', 'Argentina', 'Argentina', 'Argentina'),
(1477, 'country', '051', 'AM', 'Armenia', 'Armenia', 'Armenia', 'Armenia', 'Armenia', 'Armenia', 'Armenia', 'Armenia', 'Armenia', 'Armenia'),
(1478, 'country', '533', 'AW', 'Aruba', 'Aruba', 'Aruba', 'Aruba', 'Aruba', 'Aruba', 'Aruba', 'Aruba', 'Aruba', 'Aruba'),
(1479, 'country', '036', 'AU', 'Australia', 'Australia', 'Australia', 'Australia', 'Australia', 'Australia', 'Australia', 'Australia', 'Australia', 'Australia'),
(1480, 'country', '040', 'AT', 'Austria', 'Austria', 'Austria', 'Austria', 'Austria', 'Austria', 'Austria', 'Austria', 'Austria', 'Austria'),
(1481, 'country', '031', 'AZ', 'Azerbaijan', 'Azerbaijan', 'Azerbaijan', 'Azerbaijan', 'Azerbaijan', 'Azerbaijan', 'Azerbaijan', 'Azerbaijan', 'Azerbaijan', 'Azerbaijan'),
(1482, 'country', '044', 'BS', 'Bahamas', 'Bahamas', 'Bahamas', 'Bahamas', 'Bahamas', 'Bahamas', 'Bahamas', 'Bahamas', 'Bahamas', 'Bahamas'),
(1483, 'country', '048', 'BH', 'Bahrain', 'Bahrain', 'Bahrain', 'Bahrain', 'Bahrain', 'Bahrain', 'Bahrain', 'Bahrain', 'Bahrain', 'Bahrain'),
(1484, 'country', '050', 'BD', 'Bangladesh', 'Bangladesh', 'Bangladesh', 'Bangladesh', 'Bangladesh', 'Bangladesh', 'Bangladesh', 'Bangladesh', 'Bangladesh', 'Bangladesh'),
(1485, 'country', '052', 'BB', 'Barbados', 'Barbados', 'Barbados', 'Barbados', 'Barbados', 'Barbados', 'Barbados', 'Barbados', 'Barbados', 'Barbados'),
(1486, 'country', '112', 'BY', 'Belarus', 'Belarus', 'Belarus', 'Belarus', 'Belarus', 'Belarus', 'Belarus', 'Belarus', 'Belarus', 'Belarus'),
(1487, 'country', '056', 'BE', 'Belgium', 'Belgium', 'Belgium', 'Belgium', 'Belgium', 'Belgium', 'Belgium', 'Belgium', 'Belgium', 'Belgium'),
(1488, 'country', '084', 'BZ', 'Belize', 'Belize', 'Belize', 'Belize', 'Belize', 'Belize', 'Belize', 'Belize', 'Belize', 'Belize'),
(1489, 'country', '204', 'BJ', 'Benin', 'Benin', 'Benin', 'Benin', 'Benin', 'Benin', 'Benin', 'Benin', 'Benin', 'Benin'),
(1490, 'country', '060', 'BM', 'Bermuda', 'Bermuda', 'Bermuda', 'Bermuda', 'Bermuda', 'Bermuda', 'Bermuda', 'Bermuda', 'Bermuda', 'Bermuda'),
(1491, 'country', '064', 'BT', 'Bhutan', 'Bhutan', 'Bhutan', 'Bhutan', 'Bhutan', 'Bhutan', 'Bhutan', 'Bhutan', 'Bhutan', 'Bhutan'),
(1492, 'country', '068', 'BO', 'Bolivia', 'Bolivia', 'Bolivia', 'Bolivia', 'Bolivia', 'Bolivia', 'Bolivia', 'Bolivia', 'Bolivia', 'Bolivia'),
(1493, 'country', '070', 'BA', 'Bosnia and Herzegovina', 'Bosnia and Herzegovina', 'Bosnia and Herzegovina', 'Bosnia and Herzegovina', 'Bosnia and Herzegovina', 'Bosnia and Herzegovina', 'Bosnia and Herzegovina', 'Bosnia and Herzegovina', 'Bosnia and Herzegovina', 'Bosnia and Herzegovina'),
(1494, 'country', '072', 'BW', 'Botswana', 'Botswana', 'Botswana', 'Botswana', 'Botswana', 'Botswana', 'Botswana', 'Botswana', 'Botswana', 'Botswana'),
(1495, 'country', '074', 'BV', 'Bouvet Island', 'Bouvet Island', 'Bouvet Island', 'Bouvet Island', 'Bouvet Island', 'Bouvet Island', 'Bouvet Island', 'Bouvet Island', 'Bouvet Island', 'Bouvet Island'),
(1496, 'country', '076', 'BR', 'Brazil', 'Brazil', 'Brazil', 'Brazil', 'Brazil', 'Brazil', 'Brazil', 'Brazil', 'Brazil', 'Brazil');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT 0,
  `like_userid` int(11) UNSIGNED DEFAULT 0,
  `is_like` int(11) UNSIGNED DEFAULT 0,
  `is_dislike` int(11) UNSIGNED DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `mediafiles`
--

CREATE TABLE `mediafiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT 0,
  `file` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `is_private` int(11) UNSIGNED DEFAULT 0,
  `private_file` varchar(250) DEFAULT '',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `is_video` int(11) UNSIGNED DEFAULT 0,
  `video_file` varchar(255) DEFAULT '',
  `is_confirmed` int(11) UNSIGNED DEFAULT 0,
  `is_approved` int(11) UNSIGNED DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `from` int(11) NOT NULL DEFAULT 0,
  `from_delete` int(11) DEFAULT 0,
  `to` int(11) NOT NULL DEFAULT 0,
  `to_delete` int(11) DEFAULT 0,
  `text` text DEFAULT NULL,
  `media` varchar(255) CHARACTER SET utf8 DEFAULT '',
  `sticker` varchar(255) CHARACTER SET utf8 DEFAULT '',
  `seen` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) UNSIGNED NOT NULL,
  `notifier_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `recipient_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `seen` int(11) UNSIGNED DEFAULT 0,
  `type` varchar(50) NOT NULL DEFAULT '',
  `text` varchar(250) DEFAULT '',
  `url` varchar(150) DEFAULT '',
  `full_url` varchar(150) DEFAULT '',
  `push_sent` int(1) UNSIGNED DEFAULT 0,
  `created_at` int(11) UNSIGNED DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `option_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `option_value` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id`, `option_name`, `option_value`, `created_at`) VALUES
(1, 'load_config_in_session', '0', '2018-11-04 21:00:00'),
(2, 'meta_description', 'Quickdate is the Finest Global Dating Website Around. Connect With Local Singles & Start Your Online Dating Adventure! Enjoy Worldwide Dating with Thrilling Online Chat & More.', '2018-11-04 21:00:00'),
(3, 'meta_keywords', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', '2018-11-04 21:00:00'),
(4, 'default_title', 'QuickDate', '2018-11-04 21:00:00'),
(5, 'site_name', 'QuickDate', '2018-11-04 21:00:00'),
(6, 'default_language', 'english', '2018-11-04 21:00:00'),
(7, 'smtp_or_mail', 'mail', '2018-11-04 21:00:00'),
(8, 'smtp_host', '', '2018-11-04 21:00:00'),
(9, 'smtp_username', '', '2018-11-04 21:00:00'),
(10, 'smtp_password', '', '2018-11-04 21:00:00'),
(11, 'smtp_encryption', 'ssl', '2018-11-04 21:00:00'),
(12, 'smtp_port', '', '2018-11-04 21:00:00'),
(13, 'siteEmail', 'deendoughouz@gmail.com', '2018-11-04 21:00:00'),
(14, 'theme', 'default', NULL),
(15, 'AllLogin', '0', '2018-11-04 21:00:00'),
(16, 'googleLogin', '1', '2018-11-04 21:00:00'),
(17, 'facebookLogin', '1', '2018-11-04 21:00:00'),
(18, 'twitterLogin', '1', '2018-11-04 21:00:00'),
(19, 'linkedinLogin', '0', '2018-11-04 21:00:00'),
(20, 'VkontakteLogin', '1', '2018-11-04 21:00:00'),
(21, 'facebookAppId', '', '2018-11-04 21:00:00'),
(22, 'facebookAppKey', '', '2018-11-04 21:00:00'),
(23, 'googleAppId', '', '2018-11-04 21:00:00'),
(24, 'googleAppKey', '', '2018-11-04 21:00:00'),
(25, 'twitterAppId', '', '2018-11-04 21:00:00'),
(26, 'twitterAppKey', '', '2018-11-04 21:00:00'),
(27, 'linkedinAppId', '', '2018-11-04 21:00:00'),
(28, 'linkedinAppKey', '', '2018-11-04 21:00:00'),
(29, 'VkontakteAppId', '', '2018-11-04 21:00:00'),
(30, 'VkontakteAppKey', '', '2018-11-04 21:00:00'),
(31, 'instagramAppId', '', '2018-11-04 21:00:00'),
(32, 'instagramAppkey', '', '2018-11-04 21:00:00'),
(33, 'instagramLogin', '1', '2018-11-04 21:00:00'),
(34, 'sms_or_email', 'mail', '2018-11-09 08:28:39'),
(37, 'sms_phone_number', '', '2018-11-04 21:00:00'),
(38, 'paypal_id', '', '2018-11-09 08:36:37'),
(39, 'paypal_secret', '', '2018-11-09 08:36:49'),
(40, 'paypal_mode', 'sandbox', '2018-11-09 08:36:09'),
(41, 'currency', 'USD', '2018-11-09 09:57:45'),
(42, 'last_backup', '00-00-0000', NULL),
(44, 'amazone_s3', '0', '2018-11-09 08:43:47'),
(45, 'bucket_name', '', '2018-11-09 08:44:13'),
(46, 'amazone_s3_key', '', '2018-11-09 08:44:34'),
(47, 'amazone_s3_s_key', '', '2018-11-09 08:44:51'),
(48, 'region', 'us-east-1', '2018-11-09 08:45:22'),
(50, 'sms_t_phone_number', '', '2018-11-04 21:00:00'),
(52, 'sms_twilio_username', '', '2018-11-04 21:00:00'),
(53, 'sms_twilio_password', '', '2018-11-04 21:00:00'),
(54, 'sms_provider', 'twilio', NULL),
(55, 'profile_picture_width_crop', '400', '2018-11-09 10:04:07'),
(56, 'profile_picture_height_crop', '400', '2018-11-09 10:04:09'),
(57, 'userDefaultAvatar', 'upload/photos/d-avatar.jpg', '2018-11-09 10:08:31'),
(58, 'profile_picture_image_quality', '80', '2018-11-09 10:10:08'),
(59, 'emailValidation', '0', '2018-11-09 08:28:58'),
(60, 'stripe_secret', '', '2018-11-09 08:35:37'),
(61, 'stripe_id', '', '2018-11-09 08:35:52'),
(62, 'push_id', 'f799dc13-ec22-4d1f-9306-b9fbde7d6106', NULL),
(63, 'push_key', 'NWFjODkxZDQtYWRhYy00NTJiLTlmYTItMmEwNmIwYWZlMTcx', NULL),
(64, 'push_id_2', NULL, NULL),
(65, 'push_key_2', NULL, NULL),
(68, 'terms', '                <h4>1- Write your Terms Of Use here.</h4>\n                <p>Lorem ipsum dolor sit amet, consectetur adisdpisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis sdnostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse          cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\n                <br>\n                <h4>2- Random title</h4>\n                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>', NULL),
(69, 'about', '                <h4>1- Write your About us here.</h4>\n                <p>Lorem ipsum dolor sit amet, consectetur adisdpisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis sdnostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse          cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\n                <br>\n                <h4>2- Random title</h4>\n                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>', NULL),
(70, 'privacy_policy', '                <h4>1- Write your Privacy Policy here.</h4>\n                <p>Lorem ipsum dolor sit amet, consectetur adisdpisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis sdnostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse          cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\n                <br>\n                <h4>2- Random title</h4>\n                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>', NULL),
(71, 'facebook_url', 'http://facebook.com', '2018-11-09 09:42:51'),
(72, 'twitter_url', 'http://twitter.com', '2018-11-09 09:42:53'),
(73, 'google_url', 'http://google.com', '2018-11-09 09:42:53'),
(74, 'currency_symbol', '$', '2018-11-09 09:18:29'),
(75, 'bag_of_credits_price', '50', '2018-11-09 09:12:55'),
(76, 'bag_of_credits_amount', '1000', '2018-11-09 09:13:00'),
(77, 'box_of_credits_price', '100', '2018-11-09 09:12:57'),
(78, 'box_of_credits_amount', '5000', '2018-11-09 09:13:01'),
(79, 'chest_of_credits_price', '150', '2018-11-09 09:13:03'),
(80, 'chest_of_credits_amount', '10000', '2018-11-09 09:13:05'),
(81, 'weekly_pro_plan', '8', '2018-11-09 09:13:07'),
(82, 'monthly_pro_plan', '25', '2018-11-09 09:24:48'),
(83, 'yearly_pro_plan', '280', '2018-11-09 09:24:50'),
(84, 'lifetime_pro_plan', '500', '2018-11-09 09:24:52'),
(85, 'worker_updateDelay', '4000', '2018-11-09 09:30:26'),
(87, 'profile_record_views_minute', '1', NULL),
(90, 'cost_per_gift', '50', '2018-11-09 09:37:38'),
(91, 'deleteAccount', '1', '2018-11-09 08:29:15'),
(92, 'user_registration', '1', '2018-11-09 08:28:24'),
(93, 'maxUpload', '96000000', NULL),
(94, 'mime_types', 'text/plain,video/mp4,video/mov,video/mpeg,video/flv,video/avi,video/webm,audio/wav,audio/mpeg,video/quicktime,audio/mp3,image/png,image/jpeg,image/gif,application/pdf,application/msword,application/zip,application/x-rar-compressed,text/pdf,application/x-pointplus,text/css', NULL),
(95, 'normal_boost_me_credits_price', '70', '2018-11-14 06:39:56'),
(96, 'more_stickers_credits_price', '45', '2018-11-14 06:39:59'),
(97, 'pro_boost_me_credits_price', '35', '2018-11-16 03:23:30'),
(98, 'boost_expire_time', '4', '2018-11-16 03:23:49'),
(99, 'not_pro_chat_limit_daily', '4', '2018-11-16 03:24:06'),
(100, 'not_pro_chat_credit', '30', NULL),
(101, 'not_pro_chat_stickers_credit', '25', '2018-11-16 03:25:55'),
(102, 'not_pro_chat_stickers_limit', '24', '2018-11-16 03:26:16'),
(103, 'cost_per_xvisits', '25', NULL),
(104, 'xvisits_expire_time', '5', NULL),
(105, 'cost_per_xmatche', '35', NULL),
(106, 'xmatche_expire_time', '5', NULL),
(107, 'cost_per_xlike', '45', NULL),
(108, 'xlike_expire_time', '5', NULL),
(109, 'google_place_api', 'AIzaSyB7rRpQJyQJZYzxrvStRGFkbB0MxXWGrO0', NULL),
(110, 'wowonder_login', '1', NULL),
(111, 'wowonder_app_ID', '7d0f02f7d38c30f78cd5', NULL),
(112, 'wowonder_app_key', 'e91365ad84d413a1d017d28522e555d14225d9d', NULL),
(113, 'wowonder_domain_uri', 'https://demo.wowonder.com', NULL),
(114, 'wowonder_domain_icon', 'https://demo.wowonder.com/themes/default/img/icon.png', NULL),
(115, 'bank_transfer_note', 'In order to confirm the bank transfer, you will need to upload a receipt or take a screenshot of your transfer within 1 day from your payment date. If a bank transfer is made but no receipt is uploaded within this period, your order will be cancelled. We will verify and confirm your receipt within 3 working days from the date you upload it.', NULL),
(116, 'max_swaps', '50', NULL),
(117, 'stripe_version', 'v1', NULL),
(118, 'paysera_project_id', '0', NULL),
(119, 'paysera_password', '', NULL),
(120, 'paysera_test_mode', 'test', NULL),
(121, 'message_request_system', 'on', NULL),
(122, 'video_chat', '0', NULL),
(123, 'audio_chat', '0', NULL),
(124, 'video_accountSid', '', NULL),
(125, 'video_apiKeySid', '', NULL),
(126, 'video_apiKeySecret', '', NULL),
(127, 'giphy_api', 'GIjbMwjlfGcmNEgB0eqphgRgwNCYN8gh', NULL),
(128, 'default_unit', 'km', NULL),
(129, 'maintenance_mode', '0', NULL),
(130, 'displaymode', 'day', NULL),
(131, 'bank_description', '&lt;div class=&quot;dt_settings_header bg_gradient&quot;&gt;\r\n                    &lt;div class=&quot;dt_settings_circle-1&quot;&gt;&lt;/div&gt;\r\n                    &lt;div class=&quot;dt_settings_circle-2&quot;&gt;&lt;/div&gt;\r\n                    &lt;div class=&quot;bank_info_innr&quot;&gt;\r\n                        &lt;svg xmlns=&quot;http://www.w3.org/2000/svg&quot; viewBox=&quot;0 0 24 24&quot;&gt;&lt;path fill=&quot;currentColor&quot; d=&quot;M11.5,1L2,6V8H21V6M16,10V17H19V10M2,22H21V19H2M10,10V17H13V10M4,10V17H7V10H4Z&quot;&gt;&lt;/path&gt;&lt;/svg&gt;\r\n                        &lt;h4 class=&quot;bank_name&quot;&gt;BANK NAME&lt;/h4&gt;\r\n                        &lt;div class=&quot;row&quot;&gt;\r\n                            &lt;div class=&quot;col s12&quot;&gt;\r\n                                &lt;div class=&quot;bank_account&quot;&gt;\r\n                                    &lt;p&gt;4796824372433055&lt;/p&gt;\r\n                                    &lt;span class=&quot;help-block&quot;&gt;Account number / IBAN&lt;/span&gt;\r\n                                &lt;/div&gt;\r\n                            &lt;/div&gt;\r\n                            &lt;div class=&quot;col s12&quot;&gt;\r\n                                &lt;div class=&quot;bank_account_holder&quot;&gt;\r\n                                    &lt;p&gt;Antoian Kordiyal&lt;/p&gt;\r\n                                    &lt;span class=&quot;help-block&quot;&gt;Account name&lt;/span&gt;\r\n                                &lt;/div&gt;\r\n                            &lt;/div&gt;\r\n                            &lt;div class=&quot;col s6&quot;&gt;\r\n                                &lt;div class=&quot;bank_account_code&quot;&gt;\r\n                                    &lt;p&gt;TGBATRISXXX&lt;/p&gt;\r\n                                    &lt;span class=&quot;help-block&quot;&gt;Routing code&lt;/span&gt;\r\n                                &lt;/div&gt;\r\n                            &lt;/div&gt;\r\n                            &lt;div class=&quot;col s6&quot;&gt;\r\n                                &lt;div class=&quot;bank_account_country&quot;&gt;\r\n                                    &lt;p&gt;Turkey&lt;/p&gt;\r\n                                    &lt;span class=&quot;help-block&quot;&gt;Country&lt;/span&gt;\r\n                                &lt;/div&gt;\r\n                            &lt;/div&gt;\r\n                        &lt;/div&gt;\r\n                    &lt;/div&gt;\r\n                &lt;/div&gt;', NULL),
(132, 'version', '1.4.1', '2019-05-08 11:18:08'),
(133, 'google_tag_code', NULL, '2019-05-08 11:18:10'),
(134, 'avcall_pro', '1', '2019-05-08 11:18:11'),
(135, 'pro_system', '1', '2019-05-08 11:18:13'),
(136, 'img_blur_amount', '50', '2019-05-08 11:18:15'),
(137, 'emailNotification', '1', '2019-05-08 11:18:17'),
(138, 'activation_limit_system', '1', '2019-05-09 18:06:09'),
(139, 'max_activation_request', '5', '2019-05-09 18:06:09'),
(140, 'activation_request_time_limit', '5', '2019-05-09 18:06:09'),
(141, 'free_features', '0', '2019-08-22 14:10:20'),
(142, 'opposite_gender', '0', '2019-08-22 14:10:22'),
(143, 'image_verification', '0', '2019-08-22 14:10:24'),
(145, 'pending_verification', '0', '2019-08-22 14:10:27'),
(146, 'push', '1', '2019-08-30 19:18:56'),
(147, 'spam_warning', '1', '2019-08-30 19:18:57'),
(148, 'image_verification_start', '0', '2019-08-30 19:18:59'),
(149, 'two_factor', '1', '2020-02-23 14:17:03'),
(150, 'two_factor_type', 'email', '2020-02-23 14:17:03'),
(151, 'affiliate_system', '1', '2020-02-23 14:17:04'),
(152, 'affiliate_type', NULL, '2020-02-23 14:17:04'),
(153, 'm_withdrawal', NULL, '2020-02-23 14:17:04'),
(154, 'amount_ref', NULL, '2020-02-23 14:17:04'),
(155, 'amount_percent_ref', NULL, '2020-02-23 14:17:04'),
(156, 'connectivitySystem', '0', '2020-02-23 14:17:04'),
(157, 'connectivitySystemLimit', '5000', '2020-02-23 14:17:04'),
(158, 'show_user_on_homepage', '1', '2020-02-23 14:17:04'),
(159, 'showed_user', '25', '2020-02-23 14:17:04'),
(160, 'max_photo_per_user', '12', '2020-02-23 14:17:04'),
(161, 'review_media_files', '0', '2020-02-23 14:17:04'),
(162, 'ffmpeg_sys', '0', '2020-02-23 14:17:04'),
(163, 'max_video_duration', '30', '2020-02-23 14:17:04'),
(164, 'ffmpeg_binary', './ffmpeg/ffmpeg', '2020-02-23 14:17:04'),
(165, 'disable_phone_field', 'on', '2020-07-30 15:29:34'),
(166, 'social_media_links', 'on', '2020-07-30 15:29:35'),
(167, 'yt_api', '', '2020-07-30 15:29:37'),
(168, 'seo', 'a:32:{s:5:\"index\";a:3:{s:5:\"title\";s:17:\"Index . Quickdate\";s:16:\"meta_description\";s:176:\"Quickdate is the Finest Global Dating Website Around. Connect With Local Singles & Start Your Online Dating Adventure! Enjoy Worldwide Dating with Thrilling Online Chat & More.\";s:13:\"meta_keywords\";s:74:\"Lorem Ipsum is simply dummy text of the printing and typesetting industry.\";}s:12:\"find-matches\";a:3:{s:5:\"title\";s:24:\"Find-matches . Quickdate\";s:16:\"meta_description\";s:176:\"Quickdate is the Finest Global Dating Website Around. Connect With Local Singles & Start Your Online Dating Adventure! Enjoy Worldwide Dating with Thrilling Online Chat & More.\";s:13:\"meta_keywords\";s:74:\"Lorem Ipsum is simply dummy text of the printing and typesetting industry.\";}s:5:\"about\";a:3:{s:5:\"title\";s:17:\"About . Quickdate\";s:16:\"meta_description\";s:176:\"Quickdate is the Finest Global Dating Website Around. Connect With Local Singles & Start Your Online Dating Adventure! Enjoy Worldwide Dating with Thrilling Online Chat & More.\";s:13:\"meta_keywords\";s:74:\"Lorem Ipsum is simply dummy text of the printing and typesetting industry.\";}s:7:\"contact\";a:3:{s:5:\"title\";s:19:\"Contact . Quickdate\";s:16:\"meta_description\";s:176:\"Quickdate is the Finest Global Dating Website Around. Connect With Local Singles & Start Your Online Dating Adventure! Enjoy Worldwide Dating with Thrilling Online Chat & More.\";s:13:\"meta_keywords\";s:74:\"Lorem Ipsum is simply dummy text of the printing and typesetting industry.\";}s:6:\"credit\";a:3:{s:5:\"title\";s:18:\"Credit . Quickdate\";s:16:\"meta_description\";s:176:\"Quickdate is the Finest Global Dating Website Around. Connect With Local Singles & Start Your Online Dating Adventure! Enjoy Worldwide Dating with Thrilling Online Chat & More.\";s:13:\"meta_keywords\";s:74:\"Lorem Ipsum is simply dummy text of the printing and typesetting industry.\";}s:8:\"disliked\";a:3:{s:5:\"title\";s:20:\"Disliked . Quickdate\";s:16:\"meta_description\";s:176:\"Quickdate is the Finest Global Dating Website Around. Connect With Local Singles & Start Your Online Dating Adventure! Enjoy Worldwide Dating with Thrilling Online Chat & More.\";s:13:\"meta_keywords\";s:74:\"Lorem Ipsum is simply dummy text of the printing and typesetting industry.\";}s:6:\"forgot\";a:3:{s:5:\"title\";s:18:\"Forgot . Quickdate\";s:16:\"meta_description\";s:176:\"Quickdate is the Finest Global Dating Website Around. Connect With Local Singles & Start Your Online Dating Adventure! Enjoy Worldwide Dating with Thrilling Online Chat & More.\";s:13:\"meta_keywords\";s:74:\"Lorem Ipsum is simply dummy text of the printing and typesetting industry.\";}s:7:\"friends\";a:3:{s:5:\"title\";s:19:\"Friends . Quickdate\";s:16:\"meta_description\";s:176:\"Quickdate is the Finest Global Dating Website Around. Connect With Local Singles & Start Your Online Dating Adventure! Enjoy Worldwide Dating with Thrilling Online Chat & More.\";s:13:\"meta_keywords\";s:74:\"Lorem Ipsum is simply dummy text of the printing and typesetting industry.\";}s:3:\"hot\";a:3:{s:5:\"title\";s:15:\"Hot . Quickdate\";s:16:\"meta_description\";s:176:\"Quickdate is the Finest Global Dating Website Around. Connect With Local Singles & Start Your Online Dating Adventure! Enjoy Worldwide Dating with Thrilling Online Chat & More.\";s:13:\"meta_keywords\";s:74:\"Lorem Ipsum is simply dummy text of the printing and typesetting industry.\";}s:8:\"interest\";a:3:{s:5:\"title\";s:20:\"Interest . Quickdate\";s:16:\"meta_description\";s:176:\"Quickdate is the Finest Global Dating Website Around. Connect With Local Singles & Start Your Online Dating Adventure! Enjoy Worldwide Dating with Thrilling Online Chat & More.\";s:13:\"meta_keywords\";s:74:\"Lorem Ipsum is simply dummy text of the printing and typesetting industry.\";}s:5:\"liked\";a:3:{s:5:\"title\";s:17:\"Liked . Quickdate\";s:16:\"meta_description\";s:176:\"Quickdate is the Finest Global Dating Website Around. Connect With Local Singles & Start Your Online Dating Adventure! Enjoy Worldwide Dating with Thrilling Online Chat & More.\";s:13:\"meta_keywords\";s:74:\"Lorem Ipsum is simply dummy text of the printing and typesetting industry.\";}s:5:\"likes\";a:3:{s:5:\"title\";s:17:\"Likes . Quickdate\";s:16:\"meta_description\";s:176:\"Quickdate is the Finest Global Dating Website Around. Connect With Local Singles & Start Your Online Dating Adventure! Enjoy Worldwide Dating with Thrilling Online Chat & More.\";s:13:\"meta_keywords\";s:74:\"Lorem Ipsum is simply dummy text of the printing and typesetting industry.\";}s:5:\"login\";a:3:{s:5:\"title\";s:17:\"Login . Quickdate\";s:16:\"meta_description\";s:176:\"Quickdate is the Finest Global Dating Website Around. Connect With Local Singles & Start Your Online Dating Adventure! Enjoy Worldwide Dating with Thrilling Online Chat & More.\";s:13:\"meta_keywords\";s:74:\"Lorem Ipsum is simply dummy text of the printing and typesetting industry.\";}s:10:\"popularity\";a:3:{s:5:\"title\";s:22:\"Popularity . Quickdate\";s:16:\"meta_description\";s:176:\"Quickdate is the Finest Global Dating Website Around. Connect With Local Singles & Start Your Online Dating Adventure! Enjoy Worldwide Dating with Thrilling Online Chat & More.\";s:13:\"meta_keywords\";s:74:\"Lorem Ipsum is simply dummy text of the printing and typesetting industry.\";}s:7:\"privacy\";a:3:{s:5:\"title\";s:19:\"Privacy . Quickdate\";s:16:\"meta_description\";s:176:\"Quickdate is the Finest Global Dating Website Around. Connect With Local Singles & Start Your Online Dating Adventure! Enjoy Worldwide Dating with Thrilling Online Chat & More.\";s:13:\"meta_keywords\";s:74:\"Lorem Ipsum is simply dummy text of the printing and typesetting industry.\";}s:3:\"pro\";a:3:{s:5:\"title\";s:15:\"Pro . Quickdate\";s:16:\"meta_description\";s:176:\"Quickdate is the Finest Global Dating Website Around. Connect With Local Singles & Start Your Online Dating Adventure! Enjoy Worldwide Dating with Thrilling Online Chat & More.\";s:13:\"meta_keywords\";s:74:\"Lorem Ipsum is simply dummy text of the printing and typesetting industry.\";}s:8:\"register\";a:3:{s:5:\"title\";s:20:\"Register . Quickdate\";s:16:\"meta_description\";s:176:\"Quickdate is the Finest Global Dating Website Around. Connect With Local Singles & Start Your Online Dating Adventure! Enjoy Worldwide Dating with Thrilling Online Chat & More.\";s:13:\"meta_keywords\";s:74:\"Lorem Ipsum is simply dummy text of the printing and typesetting industry.\";}s:5:\"reset\";a:3:{s:5:\"title\";s:17:\"Reset . Quickdate\";s:16:\"meta_description\";s:176:\"Quickdate is the Finest Global Dating Website Around. Connect With Local Singles & Start Your Online Dating Adventure! Enjoy Worldwide Dating with Thrilling Online Chat & More.\";s:13:\"meta_keywords\";s:74:\"Lorem Ipsum is simply dummy text of the printing and typesetting industry.\";}s:5:\"story\";a:3:{s:5:\"title\";s:17:\"Story . Quickdate\";s:16:\"meta_description\";s:176:\"Quickdate is the Finest Global Dating Website Around. Connect With Local Singles & Start Your Online Dating Adventure! Enjoy Worldwide Dating with Thrilling Online Chat & More.\";s:13:\"meta_keywords\";s:74:\"Lorem Ipsum is simply dummy text of the printing and typesetting industry.\";}s:7:\"stories\";a:3:{s:5:\"title\";s:19:\"Stories . Quickdate\";s:16:\"meta_description\";s:176:\"Quickdate is the Finest Global Dating Website Around. Connect With Local Singles & Start Your Online Dating Adventure! Enjoy Worldwide Dating with Thrilling Online Chat & More.\";s:13:\"meta_keywords\";s:74:\"Lorem Ipsum is simply dummy text of the printing and typesetting industry.\";}s:5:\"terms\";a:3:{s:5:\"title\";s:17:\"Terms . Quickdate\";s:16:\"meta_description\";s:176:\"Quickdate is the Finest Global Dating Website Around. Connect With Local Singles & Start Your Online Dating Adventure! Enjoy Worldwide Dating with Thrilling Online Chat & More.\";s:13:\"meta_keywords\";s:74:\"Lorem Ipsum is simply dummy text of the printing and typesetting industry.\";}s:6:\"visits\";a:3:{s:5:\"title\";s:18:\"Visits . Quickdate\";s:16:\"meta_description\";s:176:\"Quickdate is the Finest Global Dating Website Around. Connect With Local Singles & Start Your Online Dating Adventure! Enjoy Worldwide Dating with Thrilling Online Chat & More.\";s:13:\"meta_keywords\";s:74:\"Lorem Ipsum is simply dummy text of the printing and typesetting industry.\";}s:11:\"maintenance\";a:3:{s:5:\"title\";s:23:\"Maintenance . Quickdate\";s:16:\"meta_description\";s:176:\"Quickdate is the Finest Global Dating Website Around. Connect With Local Singles & Start Your Online Dating Adventure! Enjoy Worldwide Dating with Thrilling Online Chat & More.\";s:13:\"meta_keywords\";s:74:\"Lorem Ipsum is simply dummy text of the printing and typesetting industry.\";}s:12:\"transactions\";a:3:{s:5:\"title\";s:24:\"Transactions . Quickdate\";s:16:\"meta_description\";s:176:\"Quickdate is the Finest Global Dating Website Around. Connect With Local Singles & Start Your Online Dating Adventure! Enjoy Worldwide Dating with Thrilling Online Chat & More.\";s:13:\"meta_keywords\";s:74:\"Lorem Ipsum is simply dummy text of the printing and typesetting industry.\";}s:10:\"userverify\";a:3:{s:5:\"title\";s:22:\"Userverify . Quickdate\";s:16:\"meta_description\";s:176:\"Quickdate is the Finest Global Dating Website Around. Connect With Local Singles & Start Your Online Dating Adventure! Enjoy Worldwide Dating with Thrilling Online Chat & More.\";s:13:\"meta_keywords\";s:74:\"Lorem Ipsum is simply dummy text of the printing and typesetting industry.\";}s:10:\"verifymail\";a:3:{s:5:\"title\";s:22:\"Verifymail . Quickdate\";s:16:\"meta_description\";s:176:\"Quickdate is the Finest Global Dating Website Around. Connect With Local Singles & Start Your Online Dating Adventure! Enjoy Worldwide Dating with Thrilling Online Chat & More.\";s:13:\"meta_keywords\";s:74:\"Lorem Ipsum is simply dummy text of the printing and typesetting industry.\";}s:13:\"verifymailotp\";a:3:{s:5:\"title\";s:25:\"Verifymailotp . Quickdate\";s:16:\"meta_description\";s:176:\"Quickdate is the Finest Global Dating Website Around. Connect With Local Singles & Start Your Online Dating Adventure! Enjoy Worldwide Dating with Thrilling Online Chat & More.\";s:13:\"meta_keywords\";s:74:\"Lorem Ipsum is simply dummy text of the printing and typesetting industry.\";}s:13:\"unusual-login\";a:3:{s:5:\"title\";s:25:\"Unusual-login . Quickdate\";s:16:\"meta_description\";s:176:\"Quickdate is the Finest Global Dating Website Around. Connect With Local Singles & Start Your Online Dating Adventure! Enjoy Worldwide Dating with Thrilling Online Chat & More.\";s:13:\"meta_keywords\";s:74:\"Lorem Ipsum is simply dummy text of the printing and typesetting industry.\";}s:11:\"verifyphone\";a:3:{s:5:\"title\";s:23:\"Verifyphone . Quickdate\";s:16:\"meta_description\";s:176:\"Quickdate is the Finest Global Dating Website Around. Connect With Local Singles & Start Your Online Dating Adventure! Enjoy Worldwide Dating with Thrilling Online Chat & More.\";s:13:\"meta_keywords\";s:74:\"Lorem Ipsum is simply dummy text of the printing and typesetting industry.\";}s:14:\"verifyphoneotp\";a:3:{s:5:\"title\";s:26:\"Verifyphoneotp . Quickdate\";s:16:\"meta_description\";s:176:\"Quickdate is the Finest Global Dating Website Around. Connect With Local Singles & Start Your Online Dating Adventure! Enjoy Worldwide Dating with Thrilling Online Chat & More.\";s:13:\"meta_keywords\";s:74:\"Lorem Ipsum is simply dummy text of the printing and typesetting industry.\";}s:5:\"steps\";a:3:{s:5:\"title\";s:17:\"Steps . Quickdate\";s:16:\"meta_description\";s:176:\"Quickdate is the Finest Global Dating Website Around. Connect With Local Singles & Start Your Online Dating Adventure! Enjoy Worldwide Dating with Thrilling Online Chat & More.\";s:13:\"meta_keywords\";s:74:\"Lorem Ipsum is simply dummy text of the printing and typesetting industry.\";}s:10:\"video-call\";a:3:{s:5:\"title\";s:22:\"Video-call . Quickdate\";s:16:\"meta_description\";s:176:\"Quickdate is the Finest Global Dating Website Around. Connect With Local Singles & Start Your Online Dating Adventure! Enjoy Worldwide Dating with Thrilling Online Chat & More.\";s:13:\"meta_keywords\";s:74:\"Lorem Ipsum is simply dummy text of the printing and typesetting industry.\";}}', '2020-07-30 15:29:39'),
(169, 'lock_private_photo', '0', '2020-07-30 15:29:40'),
(170, 'lock_private_photo_fee', '30', '2020-07-30 15:29:42'),
(171, 'lock_pro_video', '0', '2020-07-30 15:29:43'),
(172, 'lock_pro_video_fee', '40', '2020-07-30 15:29:45'),
(173, 'verification_on_signup', '0', '2020-07-30 15:29:46'),
(174, 'credit_earn_system', '1', '2020-07-30 15:29:48'),
(175, 'credit_earn_max_days', '10', '2020-07-30 15:29:50'),
(176, 'credit_earn_day_amount', '50', '2020-07-30 15:29:51');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `amount` int(11) NOT NULL DEFAULT 0,
  `type` varchar(15) NOT NULL DEFAULT '',
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `pro_plan` varchar(100) DEFAULT '',
  `credit_amount` varchar(100) DEFAULT '0',
  `via` varchar(100) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `profilefields`
--

CREATE TABLE `profilefields` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `length` int(11) NOT NULL DEFAULT 0,
  `placement` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'profile',
  `registration_page` int(11) NOT NULL DEFAULT 0,
  `profile_page` int(11) NOT NULL DEFAULT 0,
  `select_type` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'none',
  `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT 0,
  `report_userid` int(11) UNSIGNED DEFAULT 0,
  `report_text` text DEFAULT NULL,
  `seen` int(11) UNSIGNED DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `session_id` varchar(200) NOT NULL DEFAULT '',
  `user_id` int(11) NOT NULL DEFAULT 0,
  `platform` varchar(30) NOT NULL DEFAULT 'web',
  `platform_details` text DEFAULT NULL,
  `time` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `site_ads`
--

CREATE TABLE `site_ads` (
  `id` int(11) NOT NULL,
  `placement` varchar(50) NOT NULL DEFAULT '',
  `code` text DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `site_ads`
--

INSERT INTO `site_ads` (`id`, `placement`, `code`, `active`) VALUES
(1, 'header', '', 0),
(2, 'footer', '', 0),
(3, 'home_side_bar', '', 0),
(4, 'profile_side_bar', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `stickers`
--

CREATE TABLE `stickers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `file` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `is_pro` int(11) UNSIGNED DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `success_stories`
--

CREATE TABLE `success_stories` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `story_user_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `quote` varchar(250) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `story_date` date NOT NULL,
  `status` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `userfields`
--

CREATE TABLE `userfields` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `first_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `last_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `avater` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT 'upload/photos/d-avatar.jpg  ',
  `address` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `gender` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '0',
  `facebook` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `google` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `twitter` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `linkedin` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `website` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `instagram` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `web_device_id` varchar(100) CHARACTER SET utf8 DEFAULT '',
  `language` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT 'english',
  `email_code` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `src` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT 'Undefined',
  `ip_address` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `type` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT 'user',
  `phone_number` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `timezone` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `lat` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '0',
  `lng` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '0',
  `about` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `birthday` varchar(200) DEFAULT '0000-00-00',
  `country` varchar(10) CHARACTER SET utf8 DEFAULT '',
  `registered` int(10) UNSIGNED DEFAULT 0,
  `lastseen` int(10) UNSIGNED DEFAULT 0,
  `smscode` int(10) UNSIGNED DEFAULT 0,
  `pro_time` int(10) UNSIGNED DEFAULT 0,
  `last_location_update` int(10) UNSIGNED DEFAULT 0,
  `balance` decimal(11,2) UNSIGNED DEFAULT 0.00,
  `verified` enum('0','1') CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '0',
  `status` enum('0','1','2','3') CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '0',
  `active` enum('0','1','2') CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '0',
  `admin` enum('0','1','2') CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '0',
  `start_up` enum('0','1','2','3') CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '0',
  `is_pro` enum('0','1') CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '0',
  `pro_type` enum('0','1','2','3','4') CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '0',
  `social_login` enum('0','1') CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '0',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT current_timestamp(),
  `mobile_device_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `web_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `mobile_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `height` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `hair_color` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `web_token_created_at` int(11) DEFAULT 0,
  `mobile_token_created_at` int(11) DEFAULT 0,
  `web_device` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `mobile_device` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `interest` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `location` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `relationship` int(10) UNSIGNED DEFAULT 0,
  `work_status` int(10) UNSIGNED DEFAULT 0,
  `education` int(10) UNSIGNED DEFAULT 0,
  `ethnicity` int(10) UNSIGNED DEFAULT 0,
  `body` int(10) UNSIGNED DEFAULT 0,
  `character` int(10) UNSIGNED DEFAULT 0,
  `children` int(10) UNSIGNED DEFAULT 0,
  `friends` int(10) UNSIGNED DEFAULT 0,
  `pets` int(10) UNSIGNED DEFAULT 0,
  `live_with` int(10) UNSIGNED DEFAULT 0,
  `car` int(10) UNSIGNED DEFAULT 0,
  `religion` int(10) UNSIGNED DEFAULT 0,
  `smoke` int(10) UNSIGNED DEFAULT 0,
  `drink` int(10) UNSIGNED DEFAULT 0,
  `travel` int(10) UNSIGNED DEFAULT 0,
  `music` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `dish` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `song` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `hobby` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `city` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `sport` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `book` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `movie` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `colour` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `tv` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `privacy_show_profile_on_google` int(10) UNSIGNED DEFAULT 0,
  `privacy_show_profile_random_users` int(10) UNSIGNED DEFAULT 0,
  `privacy_show_profile_match_profiles` int(10) UNSIGNED DEFAULT 0,
  `email_on_profile_view` int(10) UNSIGNED DEFAULT 0,
  `email_on_new_message` int(10) UNSIGNED DEFAULT 0,
  `email_on_profile_like` int(10) UNSIGNED DEFAULT 0,
  `email_on_purchase_notifications` int(10) UNSIGNED DEFAULT 0,
  `email_on_special_offers` int(10) UNSIGNED DEFAULT 0,
  `email_on_announcements` int(11) UNSIGNED DEFAULT 0,
  `phone_verified` int(11) UNSIGNED DEFAULT 0,
  `online` int(11) UNSIGNED DEFAULT 0,
  `is_boosted` int(11) UNSIGNED DEFAULT 0,
  `boosted_time` int(11) UNSIGNED DEFAULT 0,
  `is_buy_stickers` int(11) UNSIGNED DEFAULT 0,
  `user_buy_xvisits` int(11) UNSIGNED DEFAULT 0,
  `xvisits_created_at` int(11) UNSIGNED DEFAULT 0,
  `user_buy_xmatches` int(11) UNSIGNED DEFAULT 0,
  `xmatches_created_at` int(11) UNSIGNED DEFAULT 0,
  `user_buy_xlikes` int(11) UNSIGNED DEFAULT 0,
  `xlikes_created_at` int(11) UNSIGNED DEFAULT 0,
  `show_me_to` varchar(50) NOT NULL DEFAULT '',
  `email_on_get_gift` int(11) UNSIGNED DEFAULT 0,
  `email_on_got_new_match` int(11) UNSIGNED DEFAULT 0,
  `email_on_chat_request` int(11) UNSIGNED DEFAULT 0,
  `last_email_sent` int(32) UNSIGNED DEFAULT 0,
  `approved_at` int(11) UNSIGNED DEFAULT 0,
  `snapshot` varchar(250) NOT NULL DEFAULT '',
  `hot_count` int(11) UNSIGNED DEFAULT 0,
  `spam_warning` int(11) UNSIGNED DEFAULT 0,
  `activation_request_count` int(11) UNSIGNED DEFAULT 0,
  `last_activation_request` int(11) UNSIGNED DEFAULT 0,
  `two_factor` int(11) UNSIGNED DEFAULT 0,
  `two_factor_verified` int(11) UNSIGNED DEFAULT 0,
  `two_factor_email_code` varchar(250) DEFAULT '',
  `new_email` varchar(250) DEFAULT '',
  `new_phone` varchar(250) DEFAULT '',
  `permission` text DEFAULT NULL,
  `referrer` int(11) UNSIGNED DEFAULT 0,
  `aff_balance` varchar(100) DEFAULT '0',
  `paypal_email` varchar(100) DEFAULT '',
  `confirm_followers` enum('0','1') DEFAULT '0',
  `reward_daily_credit` int(11) UNSIGNED DEFAULT 0,
  `lock_pro_video` int(11) UNSIGNED DEFAULT 1,
  `lock_private_photo` int(11) UNSIGNED DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_chat_buy`
--

CREATE TABLE `user_chat_buy` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `chat_user_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_gifts`
--

CREATE TABLE `user_gifts` (
  `id` int(11) NOT NULL,
  `from` int(11) NOT NULL DEFAULT 0,
  `to` int(11) NOT NULL DEFAULT 0,
  `gift_id` int(11) NOT NULL DEFAULT 0,
  `time` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `verification_requests`
--

CREATE TABLE `verification_requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `message` text DEFAULT NULL,
  `user_name` varchar(150) NOT NULL DEFAULT '',
  `passport` varchar(3000) NOT NULL DEFAULT '',
  `photo` varchar(3000) NOT NULL DEFAULT '',
  `seen` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `videocalles`
--

CREATE TABLE `videocalles` (
  `id` int(11) NOT NULL,
  `access_token` text DEFAULT NULL,
  `access_token_2` text DEFAULT NULL,
  `from_id` int(11) NOT NULL DEFAULT 0,
  `to_id` int(11) NOT NULL DEFAULT 0,
  `room_name` varchar(50) NOT NULL DEFAULT '',
  `active` int(11) NOT NULL DEFAULT 0,
  `called` int(11) NOT NULL DEFAULT 0,
  `time` int(11) NOT NULL DEFAULT 0,
  `declined` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `views`
--

CREATE TABLE `views` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT 0,
  `view_userid` int(11) UNSIGNED DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `affiliates_requests`
--
ALTER TABLE `affiliates_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `time` (`time`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `active` (`active`);

--
-- Indexes for table `announcement_views`
--
ALTER TABLE `announcement_views`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `announcement_id` (`announcement_id`);

--
-- Indexes for table `audiocalls`
--
ALTER TABLE `audiocalls`
  ADD PRIMARY KEY (`id`),
  ADD KEY `to_id` (`to_id`),
  ADD KEY `from_id` (`from_id`),
  ADD KEY `call_id` (`call_id`),
  ADD KEY `called` (`called`),
  ADD KEY `declined` (`declined`);

--
-- Indexes for table `bank_receipts`
--
ALTER TABLE `bank_receipts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `banned_ip`
--
ALTER TABLE `banned_ip`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ip_address` (`ip_address`);

--
-- Indexes for table `blocks`
--
ALTER TABLE `blocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `block_userid` (`block_userid`),
  ADD KEY `created_at` (`created_at`);

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`),
  ADD KEY `title` (`title`),
  ADD KEY `category` (`category`),
  ADD KEY `tags` (`tags`(255));

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`),
  ADD KEY `created_at` (`created_at`),
  ADD KEY `receiver_id_2` (`receiver_id`),
  ADD KEY `sender_id_2` (`sender_id`),
  ADD KEY `from_delete` (`from_delete`),
  ADD KEY `to_delete` (`to_delete`);

--
-- Indexes for table `custom_pages`
--
ALTER TABLE `custom_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daily_credits`
--
ALTER TABLE `daily_credits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `emails`
--
ALTER TABLE `emails`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `followers`
--
ALTER TABLE `followers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `following_id` (`following_id`),
  ADD KEY `follower_id` (`follower_id`),
  ADD KEY `active` (`active`),
  ADD KEY `order1` (`following_id`,`id`),
  ADD KEY `order2` (`follower_id`,`id`);

--
-- Indexes for table `gifts`
--
ALTER TABLE `gifts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `hot`
--
ALTER TABLE `hot`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `hot_userid` (`hot_userid`),
  ADD KEY `val` (`hot_userid`),
  ADD KEY `created_at` (`created_at`);

--
-- Indexes for table `langs`
--
ALTER TABLE `langs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `langs_english_index` (`english`),
  ADD KEY `ref` (`ref`(191)),
  ADD KEY `langs_lang_key_unique` (`lang_key`) USING BTREE;

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `like_userid` (`like_userid`),
  ADD KEY `is_like` (`is_like`),
  ADD KEY `is_dislike` (`is_dislike`),
  ADD KEY `created_at` (`created_at`);

--
-- Indexes for table `mediafiles`
--
ALTER TABLE `mediafiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `file` (`file`),
  ADD KEY `created_at` (`created_at`),
  ADD KEY `is_private` (`is_private`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `from` (`from`),
  ADD KEY `to` (`to`),
  ADD KEY `seen` (`seen`),
  ADD KEY `order1` (`from`,`id`),
  ADD KEY `order3` (`to`,`id`),
  ADD KEY `order7` (`seen`,`id`),
  ADD KEY `order8` (`id`),
  ADD KEY `created_at` (`created_at`),
  ADD KEY `messages_from_delete_index` (`from_delete`),
  ADD KEY `messages_to_delete_index` (`to_delete`);
ALTER TABLE `messages` ADD FULLTEXT KEY `text` (`text`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifier_id` (`notifier_id`),
  ADD KEY `recipient_id` (`recipient_id`),
  ADD KEY `type` (`type`),
  ADD KEY `push_sent` (`push_sent`),
  ADD KEY `created_at` (`created_at`),
  ADD KEY `seen` (`seen`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `options_option_name_unique` (`option_name`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `profilefields`
--
ALTER TABLE `profilefields`
  ADD PRIMARY KEY (`id`),
  ADD KEY `registration_page` (`registration_page`),
  ADD KEY `active` (`active`),
  ADD KEY `profile_page` (`profile_page`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `report_userid` (`report_userid`),
  ADD KEY `created_at` (`created_at`),
  ADD KEY `seen` (`seen`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `session_id` (`session_id`(191)),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `platform` (`platform`),
  ADD KEY `time` (`time`);

--
-- Indexes for table `site_ads`
--
ALTER TABLE `site_ads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `placement` (`placement`);

--
-- Indexes for table `stickers`
--
ALTER TABLE `stickers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `file` (`file`);

--
-- Indexes for table `success_stories`
--
ALTER TABLE `success_stories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `story_user_id` (`story_user_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `userfields`
--
ALTER TABLE `userfields`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_first_name_index` (`first_name`),
  ADD KEY `users_web_token` (`web_token`) USING BTREE,
  ADD KEY `users_mobile_token` (`mobile_token`) USING BTREE,
  ADD KEY `users_hair_color` (`hair_color`) USING BTREE,
  ADD KEY `is_boosted` (`is_boosted`),
  ADD KEY `is_buy_stickers` (`is_buy_stickers`),
  ADD KEY `ethnicity` (`ethnicity`),
  ADD KEY `last_name` (`last_name`),
  ADD KEY `address` (`address`),
  ADD KEY `language` (`language`),
  ADD KEY `lat` (`lat`),
  ADD KEY `lng` (`lng`),
  ADD KEY `birthday` (`birthday`(191)),
  ADD KEY `lastseen` (`lastseen`),
  ADD KEY `start_up` (`start_up`),
  ADD KEY `height` (`height`),
  ADD KEY `location` (`location`),
  ADD KEY `relationship` (`relationship`),
  ADD KEY `work_status` (`work_status`),
  ADD KEY `education` (`education`),
  ADD KEY `education_2` (`education`),
  ADD KEY `body` (`body`),
  ADD KEY `character` (`character`),
  ADD KEY `children` (`children`),
  ADD KEY `friends` (`friends`),
  ADD KEY `pets` (`pets`),
  ADD KEY `live_with` (`live_with`),
  ADD KEY `religion` (`religion`),
  ADD KEY `smoke` (`smoke`),
  ADD KEY `drink` (`drink`),
  ADD KEY `online` (`online`),
  ADD KEY `xvisits_created_at` (`xvisits_created_at`),
  ADD KEY `show_me_to` (`show_me_to`),
  ADD KEY `verified` (`verified`),
  ADD KEY `xmatches_created_at` (`xmatches_created_at`),
  ADD KEY `smscode` (`smscode`),
  ADD KEY `password` (`password`),
  ADD KEY `gender` (`gender`),
  ADD KEY `email_code` (`email_code`),
  ADD KEY `type` (`type`),
  ADD KEY `country` (`country`),
  ADD KEY `balance` (`balance`),
  ADD KEY `active` (`active`),
  ADD KEY `status` (`status`),
  ADD KEY `admin` (`admin`),
  ADD KEY `location_2` (`location`),
  ADD KEY `relationship_2` (`relationship`),
  ADD KEY `work_status_2` (`work_status`),
  ADD KEY `education_3` (`education`),
  ADD KEY `body_2` (`body`),
  ADD KEY `character_2` (`character`,`children`,`friends`,`pets`,`live_with`,`car`,`religion`),
  ADD KEY `height_2` (`height`),
  ADD KEY `show_me_to_2` (`show_me_to`);

--
-- Indexes for table `user_chat_buy`
--
ALTER TABLE `user_chat_buy`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `chat_user_id` (`chat_user_id`),
  ADD KEY `created_at` (`created_at`);

--
-- Indexes for table `user_gifts`
--
ALTER TABLE `user_gifts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `from` (`from`),
  ADD KEY `to` (`to`),
  ADD KEY `gift_id` (`gift_id`);

--
-- Indexes for table `verification_requests`
--
ALTER TABLE `verification_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `videocalles`
--
ALTER TABLE `videocalles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `to_id` (`to_id`),
  ADD KEY `from_id` (`from_id`),
  ADD KEY `called` (`called`),
  ADD KEY `declined` (`declined`);

--
-- Indexes for table `views`
--
ALTER TABLE `views`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `view_userid` (`view_userid`),
  ADD KEY `created_at` (`created_at`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `affiliates_requests`
--
ALTER TABLE `affiliates_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `announcement_views`
--
ALTER TABLE `announcement_views`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audiocalls`
--
ALTER TABLE `audiocalls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bank_receipts`
--
ALTER TABLE `bank_receipts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `banned_ip`
--
ALTER TABLE `banned_ip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blocks`
--
ALTER TABLE `blocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `custom_pages`
--
ALTER TABLE `custom_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `daily_credits`
--
ALTER TABLE `daily_credits`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emails`
--
ALTER TABLE `emails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `followers`
--
ALTER TABLE `followers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gifts`
--
ALTER TABLE `gifts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hot`
--
ALTER TABLE `hot`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `langs`
--
ALTER TABLE `langs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1497;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mediafiles`
--
ALTER TABLE `mediafiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=177;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `profilefields`
--
ALTER TABLE `profilefields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `site_ads`
--
ALTER TABLE `site_ads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `stickers`
--
ALTER TABLE `stickers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `success_stories`
--
ALTER TABLE `success_stories`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `userfields`
--
ALTER TABLE `userfields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_chat_buy`
--
ALTER TABLE `user_chat_buy`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_gifts`
--
ALTER TABLE `user_gifts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `verification_requests`
--
ALTER TABLE `verification_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `videocalles`
--
ALTER TABLE `videocalles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `views`
--
ALTER TABLE `views`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
