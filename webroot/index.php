<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);

    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        echo "🚫 Gagal menyimpan file.";
        exit;
    }

    if (checkMime($target_file) && checkFileType($target_file)) {
	echo "✅ File berhasil diupload: <a href='$target_file'>" . htmlspecialchars($target_file) . "</a>";
    } else {
        unlink($target_file);
        echo "🚫 File tidak valid dan telah dihapus.";
        
    }

    echo '<br><br><a href="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">Kembali</a>';
    exit;
}

function checkMime($fileName) {
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $fileName);
    finfo_close($finfo);

    echo "📎 Deteksi MIME: $mime<br>";

    return in_array($mime, ['image/jpeg', 'image/png']);
}

function checkFileType($fileName) {
    $imageFileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    if ($imageFileType != "jpg" && $imageFileType != "png") {
        echo "🚫 Hanya ekstensi .jpg dan .png yang diizinkan.<br>";
        return false;
    }
    return true;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload Image</title>
</head>
<body>
    <h2>Upload Image</h2>
    <form action="" method="post" enctype="multipart/form-data">
        Pilih file:<br><br>
        <input type="file" name="image" required>
        <br><br>
        <input type="submit" value="Upload">
    </form>
</body>
</html>
