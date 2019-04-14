<?php
// Get Variables:
if (isset($_GET['task'])) $task = $_GET['task']; else $task = "ls";
if (isset($_GET['path'])) $path  = $_GET['path']; else $path  = ".";

// Get task done:
if ($task === "load"){
    if (file_exists($path)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($path).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($path));
        readfile($path);
        $task = "ls"; // next task
        $path = preg_replace("^/.*", "", $path); // set dir path
    } else {
        echo('File not found!');
    }
}
if ($task === "ls"){
    print("Path: " . $path . "<br>");

    $files1 = scandir($path);

    foreach ($files1 as $file)
        if (is_dir ( $file )){
            print("<a href='ls.php?path=" . $path . "/" . $file . "'>" . $file . " --DIR-> </a><br>");
        } else {
            print("<a href='ls.php?task=load&path=" . $path . "/" . $file . "'>" . $file . "</a> :: <a style='color: gray!important' href='ls.php?path=" . $path . "/" . $file . "'> [Try to open as DIR] </a><br>");
        }
}
?>
