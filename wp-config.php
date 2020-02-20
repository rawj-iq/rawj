<?php
/**
 * إعدادات الووردبريس الأساسية
 *
 * عملية إنشاء الملف wp-config.php تستخدم هذا الملف أثناء التنصيب. لا يجب عليك
 * استخدام الموقع، يمكنك نسخ هذا الملف إلى "wp-config.php" وبعدها ملئ القيم المطلوبة.
 *
 * هذا الملف يحتوي على هذه الإعدادات:
 *
 * * إعدادات قاعدة البيانات
 * * مفاتيح الأمان
 * * بادئة جداول قاعدة البيانات
 * * المسار المطلق لمجلد الووردبريس
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** إعدادات قاعدة البيانات - يمكنك الحصول على هذه المعلومات من مستضيفك ** //

/** اسم قاعدة البيانات لووردبريس */
define( 'DB_NAME', 'rawj_db' );

/** اسم مستخدم قاعدة البيانات */
define( 'DB_USER', 'root' );

/** كلمة مرور قاعدة البيانات */
define( 'DB_PASSWORD', '' );

/** عنوان خادم قاعدة البيانات */
define( 'DB_HOST', 'localhost' );

/** ترميز قاعدة البيانات */
define( 'DB_CHARSET', 'utf8mb4' );

/** نوع تجميع قاعدة البيانات. لا تغير هذا إن كنت غير متأكد */
define( 'DB_COLLATE', '' );

/**#@+
 * مفاتيح الأمان.
 *
 * استخدم الرابط التالي لتوليد المفاتيح {@link https://api.wordpress.org/secret-key/1.1/salt/}
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '1vN+U1u.1V[*nFVIDC-:U_?t)U.e|}7f9</n#aEQwb?h9>rP}^nJ-AqW[%q]0a=Z' );
define( 'SECURE_AUTH_KEY',  'Qh jO,jdoDQ3c@rIR3kFNng?@KbmBPw~;e6aWfSV([~W<)0W.@b[qD7Tp:8;mC#6' );
define( 'LOGGED_IN_KEY',    'Msz4+ ylB_(t!@$t`8E%;K;3^B@527)]B4LBs+0]Aja.tB|YPJmBU<UlpB.3owDW' );
define( 'NONCE_KEY',        'obb4.o>U7_UY1<UMT}zT#y`i3L92.HX%_URf3bI2w~O=JT*q,iH@O5RqE2e%gNLU' );
define( 'AUTH_SALT',        'L{i%Po/i3^x>r.{arZ=uPXhURU,_G+W Ak?y90. zfS){}<=zvFlVRYHclV[_>js' );
define( 'SECURE_AUTH_SALT', ')p]g;]H%ErYOpAbXuwFR#~Ugq88/HsDq_#AsNTL`*yD2+T+PNjN(AArH14P3?XF#' );
define( 'LOGGED_IN_SALT',   'l8#P0IKn5/e!FFy_!2)Sr)CfGe,6:~5;QSVK#wc=SDpziLbZORuvm+@5%Es5C16U' );
define( 'NONCE_SALT',       'N,+ZQptI5a{RfTSF}R0jfTo@(3sYai}B{}Kff!S]x}:I(QW>-8sSz6w8.b#5+j9/' );

/**#@-*/

/**
 * بادئة الجداول في قاعدة البيانات.
 *
 * تستطيع تركيب أكثر من موقع على نفس قاعدة البيانات إذا أعطيت لكل موقع بادئة جداول مختلفة
 * يرجى استخدام حروف، أرقام وخطوط سفلية فقط!
 */
$table_prefix = 'wp_';

/**
 * للمطورين: نظام تشخيص الأخطاء
 *
 * قم بتغييرالقيمة، إن أردت تمكين عرض الملاحظات والأخطاء أثناء التطوير.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* هذا هو المطلوب، توقف عن التعديل! نتمنى لك التوفيق. */

/** المسار المطلق لمجلد ووردبريس. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** إعداد متغيرات الووردبريس وتضمين الملفات. */
require_once( ABSPATH . 'wp-settings.php' );
