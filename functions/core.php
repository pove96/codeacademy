<?php

function save_photo($_FILE, $target_dir = 'uploads') {

    $target_fname = time() . '-' . $_FILE['name'];
    $target_path = $target_dir . '/' . $target_fname;

    // Check file type and upload errors first
    if (!in_array($_FILE['type'], ['image/jpeg', 'image/png']) || $_FILE['error'] !== 0) {
        return false;
    }

    $success = move_uploaded_file($_FILE['tmp_name'], $target_path);
    if ($success) {
        return $target_path;
    }

    return false;
}