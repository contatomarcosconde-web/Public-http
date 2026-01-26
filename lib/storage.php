<?php

function channels_data_path(): string
{
    return __DIR__ . '/../data/channels.json';
}

function load_channels(): array
{
    $path = channels_data_path();
    if (!file_exists($path)) {
        return [];
    }

    $json = file_get_contents($path);
    if ($json === false || trim($json) === '') {
        return [];
    }

    $data = json_decode($json, true);
    return is_array($data) ? $data : [];
}

function save_channels(array $channels): void
{
    $path = channels_data_path();
    $dir = dirname($path);
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }

    $json = json_encode(array_values($channels), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    file_put_contents($path, $json);
}

function find_channel(array $channels, string $id): ?array
{
    foreach ($channels as $channel) {
        if (($channel['id'] ?? '') === $id) {
            return $channel;
        }
    }

    return null;
}

function update_channel(array $channels, array $payload): array
{
    $updated = false;
    foreach ($channels as $index => $channel) {
        if (($channel['id'] ?? '') === ($payload['id'] ?? '')) {
            $channels[$index] = $payload;
            $updated = true;
            break;
        }
    }

    if (!$updated) {
        $channels[] = $payload;
    }

    return $channels;
}

function delete_channel(array $channels, string $id): array
{
    return array_values(array_filter($channels, function ($channel) use ($id) {
        return ($channel['id'] ?? '') !== $id;
    }));
}

function normalize_channel_input(array $input, ?array $existing = null): array
{
    $name = trim((string)($input['name'] ?? ''));
    $category = trim((string)($input['category'] ?? ''));
    $iframe = trim((string)($input['iframe'] ?? ''));
    $cover = trim((string)($input['cover'] ?? ($existing['cover'] ?? '')));
    if (array_key_exists('block_popups', $input)) {
        $blockPopups = (string)$input['block_popups'] === '1';
    } else {
        $blockPopups = (bool)($existing['block_popups'] ?? false);
    }

    return [
        'id' => $existing['id'] ?? ($input['id'] ?? uniqid('ch_', true)),
        'name' => $name,
        'category' => $category,
        'iframe' => $iframe,
        'cover' => $cover,
        'block_popups' => $blockPopups,
        'created_at' => $existing['created_at'] ?? gmdate('c'),
        'updated_at' => gmdate('c'),
    ];
}

function uploads_dir(): string
{
    return __DIR__ . '/../uploads';
}

function public_cover_path(string $filename): string
{
    return 'uploads/' . $filename;
}

function safe_delete_cover(?string $cover): void
{
    if (!$cover) {
        return;
    }

    if (strpos($cover, 'uploads/') !== 0) {
        return;
    }

    $path = __DIR__ . '/../' . $cover;
    if (is_file($path)) {
        @unlink($path);
    }
}

function process_cover_upload(array $file, ?string $existingCover, ?string &$error): ?string
{
    if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
        return $existingCover;
    }

    $tmpName = $file['tmp_name'] ?? '';
    $originalName = $file['name'] ?? '';
    $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

    $allowed = [
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'webp' => 'image/webp',
    ];

    $mimeOk = true;
    if (function_exists('finfo_open')) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        if ($finfo) {
            $mime = finfo_file($finfo, $tmpName);
            finfo_close($finfo);
            $mimeOk = in_array($mime, $allowed, true);
        }
    }

    if (!$mimeOk || !array_key_exists($extension, $allowed)) {
        $error = 'Envie uma capa JPG, PNG ou WEBP válida.';
        return $existingCover;
    }

    $uploadDir = uploads_dir();
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $filenameBase = uniqid('cover_', true);
    $filename = $filenameBase . '.jpg';
    $destination = $uploadDir . '/' . $filename;

    $targetWidth = 600;
    $targetHeight = 900;

    if (function_exists('imagecreatetruecolor')) {
        $source = null;
        if ($extension === 'jpg' || $extension === 'jpeg') {
            $source = @imagecreatefromjpeg($tmpName);
        } elseif ($extension === 'png') {
            $source = @imagecreatefrompng($tmpName);
        } elseif ($extension === 'webp' && function_exists('imagecreatefromwebp')) {
            $source = @imagecreatefromwebp($tmpName);
        }

        if ($source) {
            $srcWidth = imagesx($source);
            $srcHeight = imagesy($source);
            $targetRatio = $targetWidth / $targetHeight;
            $srcRatio = $srcWidth / $srcHeight;

            if ($srcRatio > $targetRatio) {
                $cropWidth = (int)round($srcHeight * $targetRatio);
                $cropHeight = $srcHeight;
                $srcX = (int)round(($srcWidth - $cropWidth) / 2);
                $srcY = 0;
            } else {
                $cropWidth = $srcWidth;
                $cropHeight = (int)round($srcWidth / $targetRatio);
                $srcX = 0;
                $srcY = (int)round(($srcHeight - $cropHeight) / 2);
            }

            $canvas = imagecreatetruecolor($targetWidth, $targetHeight);
            $black = imagecolorallocate($canvas, 0, 0, 0);
            imagefill($canvas, 0, 0, $black);
            imagecopyresampled(
                $canvas,
                $source,
                0,
                0,
                $srcX,
                $srcY,
                $targetWidth,
                $targetHeight,
                $cropWidth,
                $cropHeight
            );

            $saved = imagejpeg($canvas, $destination, 85);
            imagedestroy($canvas);
            imagedestroy($source);

            if (!$saved) {
                $error = 'Falha ao salvar a capa enviada.';
                return $existingCover;
            }

            if ($existingCover) {
                safe_delete_cover($existingCover);
            }

            return public_cover_path($filename);
        }
    }

    $filename = $filenameBase . '.' . $extension;
    $destination = $uploadDir . '/' . $filename;

    if (!move_uploaded_file($tmpName, $destination)) {
        $error = 'Falha ao salvar a capa enviada.';
        return $existingCover;
    }

    if ($existingCover) {
        safe_delete_cover($existingCover);
    }

    return public_cover_path($filename);
}
