<?php
include_once('../includes/functions.php');
include_once('../includes/custom-functions.php');
$fn = new custom_functions;
require_once '../includes/crud.php';
$db = new Database();
$db->connect();

if (ALLOW_MODIFICATION == 0 && !defined(ALLOW_MODIFICATION)) {
    echo '<label class="alert alert-danger">This operation is not allowed in demo panel!.</label>';
    return false;
}

/** make update diractory */
$path = "../updates";
if (!file_exists($path)) {
    mkdir($path, 0755);
}

/** get update zip and extracting */
if (!isset($_FILES["zip_file"]) || $_FILES["zip_file"]['name'][0] == "" || $_FILES["zip_file"]['size'][0] <= 0) {
    $response['error'] = true;
    $response['message'] =  "Zip file not found!";
    echo json_encode($response);
    return;
}

$filename = $db->escapeString($fn->xss_clean($_FILES["zip_file"]["name"][0]));
$source = $db->escapeString($fn->xss_clean($_FILES["zip_file"]["tmp_name"][0]));
$type = $db->escapeString($fn->xss_clean($_FILES["zip_file"]["type"][0]));
$fileArray = explode(".", $filename);

if ($fileArray[count($fileArray) - 1] == 'zip') {
    $filename = $fileArray[0];
    $zip = new ZipArchive();
    if ($zip->open($_FILES["zip_file"]["tmp_name"][0]) === TRUE) {
        $zip->extractTo($path);
        $zip->close();
        $response['error'] = false;
        $response['message'] =  "Your zip file was uploaded and unpacked.";
    } else {
        $response['error'] = true;
        $response['message'] =  "There was a problem with the upload. Please try again.";
        echo json_encode($response);
        return;
    }
} else {
    $response['error'] = true;
    $response['message'] = "please select zip file";
    echo json_encode($response);
    return;
}

/** check version */
$sql = "SELECT * FROM `updates` ORDER BY `id` DESC LIMIT 1";
$db->sql($sql);
$db_current_version = $db->getResult();

$version = (isset($db_current_version[0]['version'])) ? $db_current_version[0]['version'] : "v1.0.0";

if (file_exists("$path/update.txt") || file_exists("$path/update.txt")) {

    $sub_directory = (file_exists("../updates/update.txt")) ? "../updates/" : "../update/";
    $lines_array = file($sub_directory . "update.txt");

    $search_string = "version";

    foreach ($lines_array as $line) {

        if (strpos($line, $search_string) !== false) {

            list(, $new_str) = explode(":", $line ?? '');
            $new_str = trim($new_str);
        }
    }
    $file_current_version = $new_str;
} else {
    $response['error'] = true;
    $response['message'] = "Something went wrong!";
    echo json_encode($response);
    return;
}
if ($file_current_version > $version) {
} else {
    $response['error'] = true;
    $response['message'] = "You have uploaded the wrong / old update file! Try again!";
    echo json_encode($response);
    return;
}

/** copy files  */
if (file_exists("$path/files.json") || file_exists("$path/files.json")) {
    $sub_directory = (file_exists("$path/files.json")) ? "../updates/" : "../update/";
    $lines_array = file_get_contents($sub_directory . "files.json");
    if (!empty($lines_array)) {
        $lines_arrays = json_decode($lines_array);

        foreach ($lines_arrays as $key => $line) {
            $copy = copy($sub_directory . $key, $line);
        }

        if (!$copy) {
            $response['error'] = true;
            $response['message'] = "Files could not be copied!";
            echo json_encode($response);
            return;
        }
    }
} else {
    $response['error'] = true;
    $response['message'] = "Files to be updated do not exist!";
    echo json_encode($response);
    return;
}

/** read data from folder.json and create new folder if any */
if (file_exists("$path/folder.json") || file_exists("$path/folder.json")) {

    $folder = (file_exists("$path/folder.json")) ? "../updates/" : "../update/";
    $lines_array = file_get_contents($folder . "folder.json");

    if (!empty($lines_array)) {
        $lines_arrays = json_decode($lines_array);

        foreach ($lines_arrays as $key => $line) {
            if (!is_dir($line) && !file_exists($line)) {
                mkdir($line, 0777, true);
            }
        }
    }
} else {
    $response['error'] = true;
    $response['message'] = "Folders to be created do not exist!";
    echo json_encode($response);
    return;
}

/** extract folders */
if (file_exists("$path/archives.json") || file_exists("../update/archives.json")) {
    $sub_directory = (file_exists("$path/archives.json")) ? "../updates/" : "../update/";
    $lines_array = file_get_contents($sub_directory . "archives.json");
    if (!empty($lines_array)) {
        $lines_arrays = json_decode($lines_array);

        $zip = new ZipArchive;
        foreach ($lines_arrays as $source => $destination) {
            $source = $sub_directory . $source;
            $res = $zip->open($source);
            if ($res === TRUE) {
                $destination = $source = $destination;
                $zip->extractTo($destination);
                $zip->close();
            }
        }
    }
} else {
    $response['error'] = true;
    $response['message'] =  "Arhives to be extracted are missing!";
    echo json_encode($response);
    return;
}

/** execute database queries if there are any */
if (file_exists("$path/query.sql") || file_exists("../update/query.sql")) {
    $sub_directory = (file_exists("$path/query.sql")) ? "../updates/" : "../update/";
    $sql = file_get_contents($sub_directory . 'query.sql');

    if (!empty(trim($sql))) {
        $queries = explode(';', $sql);
        for ($i = 0; $i < count($queries) - 1; $i++) {
            $db->sql($queries[$i]);
        }
    }
}

/* If everything goes well till here. Update the version in database */
$sql = "INSERT INTO `updates`(`version`) VALUES ('$file_current_version')";
$db->sql($sql);
$db->disconnect();

$response['error'] = false;
$response['message'] = "Congratulations! you have successfully update your system from $version to $file_current_version";

echo json_encode($response);
return;
