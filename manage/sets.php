<?php

/*********************************
 * GET GLOBAL VARS AND FUNCTIONS *
 *********************************/
define('SAPPHO_MANAGE', TRUE);
require_once "../global.php";



if (!empty($_GET["delete"])) {

    $set_id = clean($_GET["delete"]);

    $sql = "UPDATE photo_collection ".
           "SET sets=sets-1         ".
           "WHERE collection_id=(SELECT collection_id   ".
           "                     FROM photo_set         ".
           "                     WHERE set_id='$set_id')";
    if (!$result = mysql_query($sql)) print_error();

    $sql = "DELETE FROM photo_set   ".
           "WHERE set_id='$set_id'  ";
    if (!$result = mysql_query($sql)) print_error();

    header("Location: sets.php");

};



if (!empty($_POST["edit"])) {

    $set_id      = clean($_POST["edit"]);
    $coll_id     = clean($_POST["coll_id"]);
    $search_path = clean($_POST["search_path"]);
    $title       = clean($_POST["title"]);
    $body        = clean($_POST["body"]);

    $sql = "SELECT collection_id    ".
           "FROM photo_set          ".
           "WHERE set_id='$set_id'  ";
    if (!$result = mysql_query($sql)) print_error();
    list($old_coll_id) = mysql_fetch_row($result);

    $sql = "UPDATE photo_set                ".
           "SET collection_id='$coll_id',   ".
           "    search_path='$search_path', ".
           "    title='$title',             ".
           "    body='$body'                ".
           "WHERE set_id='$set_id'          ";
    if (!$result = mysql_query($sql)) print_error();

    $sql = "UPDATE photo_collection             ".
           "SET sets=sets-1                     ".
           "WHERE collection_id='$old_coll_id'  ";
    if (!$result = mysql_query($sql)) print_error();

    $sql = "UPDATE photo_collection         ".
           "SET sets=sets+1                 ".
           "WHERE collection_id='$coll_id'  ";
    if (!$result = mysql_query($sql)) print_error();

    header("Location: sets.php");

};



if (isset($_POST["insert"])) {

    $coll_id     = clean($_POST["coll_id"]);
    $search_path = clean($_POST["search_path"]);
    $title       = clean($_POST["title"]);
    $body        = clean($_POST["body"]);
    $sql = "INSERT INTO photo_set           ".
           "SET collection_id='$coll_id',   ".
           "    search_path='$search_path', ".
           "    title='$title',             ".
           "    body='$body'                ";
    if (!$result = mysql_query($sql)) print_error();

    $sql = "UPDATE photo_collection         ".
           "SET sets=sets+1                 ".
           "WHERE collection_id='$coll_id'  ";
    if (!$result = mysql_query($sql)) print_error();

    header("Location: sets.php");

};



if (!empty($_GET["edit"])) {

    $set_id = clean($_GET["edit"]);
    $sql = "SELECT set_id,          ".
           "       collection_id,   ".
           "       search_path,     ".
           "       title,           ".
           "       body             ".
           "FROM photo_set          ".
           "WHERE set_id='$set_id'  ";
    if (!$result = mysql_query($sql)) print_error();
    $set = mysql_fetch_array($result);

    header('Content-Type: text/html; charset=utf-8');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
    <head>
    <title><?php echo $sappho_title; ?> &mdash; manage &mdash; sets</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <style type="text/css">
            @import "<?php echo $sappho_path; ?>/style.css";
        </style>
    </head>
    <body>
        <div id="container">
            <h1><a href="<?php echo $sappho_path; ?>/"><?php echo $sappho_title; ?></a> &raquo; <a href="<?php echo $sappho_path; ?>/manage/">manage</a></h1>
            <h2><a href="sets.php">sets</a> &raquo; editing <i><?php echo $set["title"]; ?></i></h2>
            <div id="edit">
                <form action="sets.php" method="post">
                    <input type="text" name="search_path" value="<?php echo $set["search_path"]; ?>" /><br />
                    <input type="text" name="title" value="<?php echo $set["title"]; ?>" /><br />
                    <textarea name="body" rows="8"><?php echo $set["body"]; ?></textarea><br />
                    <select name="coll_id">
                        <option value="0">---- choose a collection ----</option>
<?php
    $sql = "SELECT collection_id, title FROM photo_collection ORDER BY title ASC";
    if (!$result = mysql_query($sql)) print_error();
    while (list($coll_id, $col_title) = mysql_fetch_row($result)) {
        if ($coll_id == $set["collection_id"]) { $sel = " selected"; }
        else { unset($sel); };
        echo "                        <option value=\"$coll_id\"$sel>$col_title</option>\n";
    };
?>
                    </select><br />
                    <input type="hidden" name="edit" value="<?php echo $set["set_id"]; ?>" />
                    <input type="submit" />
                </form>
            </div>
        </div>
    </body>
</html>
<?php

    die();

};



if (isset($_GET["insert"])) {

    header('Content-Type: text/html; charset=utf-8');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
    <head>
    <title><?php echo $sappho_title; ?> &mdash; manage &mdash; sets</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <style type="text/css">
            @import "<?php echo $sappho_path; ?>/style.css";
        </style>
    </head>
    <body>
        <div id="container">
            <h1><a href="<?php echo $sappho_path; ?>/"><?php echo $sappho_title; ?></a> &raquo; <a href="<?php echo $sappho_path; ?>/manage/">manage</a></h1>
            <h2><a href="sets.php">sets</a> &raquo; inserting a new row</h2>
            <div id="edit">
                <form action="sets.php" method="post">
                    <input type="text" name="search_path" value="search-path" /><br />
                    <input type="text" name="title" value="title" /><br />
                    <textarea name="body" rows="8">description</textarea><br />
                    <select name="coll_id">
                        <option value="">---- choose a collection ----</option>
<?php
    $sql = "SELECT collection_id, title FROM photo_collection ORDER BY title ASC";
    if (!$result = mysql_query($sql)) print_error();
    while (list($coll_id, $col_title) = mysql_fetch_row($result)) {
        if ($coll_id == $set["collection_id"]) { $sel = " selected"; }
        else { unset($sel); };
        echo "                        <option value=\"$coll_id\"$sel>$col_title</option>\n";
    };
?>
                    </select><br />
                    <input type="hidden" name="insert" />
                    <input type="submit" />
                </form>
            </div>
        </div>
    </body>
</html>
<?php

    die();

};

header('Content-Type: text/html; charset=utf-8');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
    <head>
    <title><?php echo $sappho_title; ?> &mdash; manage &mdash; sets</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <style type="text/css">
            @import "<?php echo $sappho_path; ?>/style.css";
        </style>
    </head>
    <body>
        <div id="container">
            <h1><a href="<?php echo $sappho_path; ?>/"><?php echo $sappho_title; ?></a> &raquo; <a href="<?php echo $sappho_path; ?>/manage/">manage</a></h1>
            <h2>sets</h2>
            <div id="insert"><a href="sets.php?insert">insert new row</a></div>
            <div id="list">
                <table>
                    <tr>
                        <th>collection</th>
                        <th>search path</th>
                        <th>title</th>
                        <th>body</th>
                        <th>sort</th>
                        <th>edit</th>
                        <th>del</th>
                    </tr>
<?php

$sql = "SELECT photo_collection.title   AS col_title,   ".
       "       photo_set.set_id,                        ".
       "       photo_set.search_path,                   ".
       "       photo_set.title,                         ".
       "       photo_set.body                           ".
       "FROM photo_set                                  ".
       "LEFT JOIN photo_collection                      ".
       "    USING ( collection_id )                     ".
       "ORDER BY collection_id,                         ".
       "         set_id                                 ";
if (!$result = mysql_query($sql)) print_error();
while ($set = mysql_fetch_array($result)) {
    echo "                    <tr>\n";
    echo "                        <td>{$set["col_title"]}</td>\n";
    echo "                        <td>{$set["search_path"]}</td>\n";
    echo "                        <td>{$set["title"]}</td>\n";
    echo "                        <td>{$set["body"]}</td>\n";
    echo "                        <td><a href=\"set_sort.php?set_id={$set["set_id"]}\">sort</a></td>\n";
    echo "                        <td><a href=\"sets.php?edit={$set["set_id"]}\">edit</a></td>\n";
    echo "                        <td><a href=\"sets.php?delete={$set["set_id"]}\">del</a></td>\n";
    echo "                    </tr>\n";
};

?>
                </table>
            </div>
        </div>
    </body>
</html>
