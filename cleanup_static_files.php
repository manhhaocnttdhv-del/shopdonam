<?php
/**
 * Script để xóa các file tĩnh không cần thiết
 * Chạy: php cleanup_static_files.php
 */

$basePath = __DIR__;

// Danh sách các file/thư mục cần xóa
$filesToDelete = [
    // CKEditor - chỉ giữ tiếng Việt
    'public/ckeditor/lang/af.js',
    'public/ckeditor/lang/ar.js',
    'public/ckeditor/lang/az.js',
    'public/ckeditor/lang/bg.js',
    'public/ckeditor/lang/bn.js',
    'public/ckeditor/lang/bs.js',
    'public/ckeditor/lang/ca.js',
    'public/ckeditor/lang/cs.js',
    'public/ckeditor/lang/cy.js',
    'public/ckeditor/lang/da.js',
    'public/ckeditor/lang/de-ch.js',
    'public/ckeditor/lang/de.js',
    'public/ckeditor/lang/el.js',
    'public/ckeditor/lang/en-au.js',
    'public/ckeditor/lang/en-ca.js',
    'public/ckeditor/lang/en-gb.js',
    'public/ckeditor/lang/en.js',
    'public/ckeditor/lang/eo.js',
    'public/ckeditor/lang/es-mx.js',
    'public/ckeditor/lang/es.js',
    'public/ckeditor/lang/et.js',
    'public/ckeditor/lang/eu.js',
    'public/ckeditor/lang/fa.js',
    'public/ckeditor/lang/fi.js',
    'public/ckeditor/lang/fo.js',
    'public/ckeditor/lang/fr-ca.js',
    'public/ckeditor/lang/fr.js',
    'public/ckeditor/lang/gl.js',
    'public/ckeditor/lang/gu.js',
    'public/ckeditor/lang/he.js',
    'public/ckeditor/lang/hi.js',
    'public/ckeditor/lang/hr.js',
    'public/ckeditor/lang/hu.js',
    'public/ckeditor/lang/id.js',
    'public/ckeditor/lang/is.js',
    'public/ckeditor/lang/it.js',
    'public/ckeditor/lang/ja.js',
    'public/ckeditor/lang/ka.js',
    'public/ckeditor/lang/km.js',
    'public/ckeditor/lang/ko.js',
    'public/ckeditor/lang/ku.js',
    'public/ckeditor/lang/lt.js',
    'public/ckeditor/lang/lv.js',
    'public/ckeditor/lang/mk.js',
    'public/ckeditor/lang/mn.js',
    'public/ckeditor/lang/ms.js',
    'public/ckeditor/lang/nb.js',
    'public/ckeditor/lang/nl.js',
    'public/ckeditor/lang/no.js',
    'public/ckeditor/lang/oc.js',
    'public/ckeditor/lang/pl.js',
    'public/ckeditor/lang/pt-br.js',
    'public/ckeditor/lang/pt.js',
    'public/ckeditor/lang/ro.js',
    'public/ckeditor/lang/ru.js',
    'public/ckeditor/lang/si.js',
    'public/ckeditor/lang/sk.js',
    'public/ckeditor/lang/sl.js',
    'public/ckeditor/lang/sq.js',
    'public/ckeditor/lang/sr-latn.js',
    'public/ckeditor/lang/sr.js',
    'public/ckeditor/lang/sv.js',
    'public/ckeditor/lang/th.js',
    'public/ckeditor/lang/tr.js',
    'public/ckeditor/lang/tt.js',
    'public/ckeditor/lang/ug.js',
    'public/ckeditor/lang/uk.js',
    'public/ckeditor/lang/zh-cn.js',
    'public/ckeditor/lang/zh.js',
    
    // CKEditor samples - không cần thiết
    'public/ckeditor/samples',
    
    // Thư mục trùng lặp không cần thiết
    'public/temp/build',
    'public/temp/css',
    'public/temp/images',
    'public/temp/js/admin.js',
    'public/temp/js/slide.js',
    'public/temp/js/validate.js',
    'public/temp/sass',
];

$deletedCount = 0;
$errorCount = 0;

echo "Bắt đầu dọn dẹp file tĩnh không cần thiết...\n\n";

foreach ($filesToDelete as $file) {
    $fullPath = $basePath . '/' . $file;
    
    if (file_exists($fullPath)) {
        if (is_dir($fullPath)) {
            if (deleteDirectory($fullPath)) {
                echo "✓ Đã xóa thư mục: $file\n";
                $deletedCount++;
            } else {
                echo "✗ Lỗi khi xóa thư mục: $file\n";
                $errorCount++;
            }
        } else {
            if (unlink($fullPath)) {
                echo "✓ Đã xóa file: $file\n";
                $deletedCount++;
            } else {
                echo "✗ Lỗi khi xóa file: $file\n";
                $errorCount++;
            }
        }
    } else {
        echo "- Không tìm thấy: $file\n";
    }
}

echo "\n";
echo "Hoàn thành!\n";
echo "Đã xóa: $deletedCount file/thư mục\n";
if ($errorCount > 0) {
    echo "Lỗi: $errorCount file/thư mục\n";
}

function deleteDirectory($dir) {
    if (!file_exists($dir)) {
        return true;
    }
    
    if (!is_dir($dir)) {
        return unlink($dir);
    }
    
    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }
        
        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }
    }
    
    return rmdir($dir);
}

