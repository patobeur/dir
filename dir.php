<?php
$path = ".";
$html = '<span class="title">Index Reader</span><br />';
//using the opendir function
$dir_handle = @opendir($path) or die("Unable to open $path");

function list_dir($dir_handle,$path,$max=0)
{
    echo "<ul>";
    while ($max < 5 && false !== ($file = readdir($dir_handle)))
    {
	
        $dir = $path.'/'.$file;
        if(is_dir($dir) && $file != '.' && $file !='..' && $file !='.git' && $file !='index2.php' && $file !='index.php')
        {
            $handle = @opendir($dir) or die("undable to open file $file");
            echo '<li class="dir">'.$file.' ('.filetype ($dir).')</li>'."\n";
            list_dir($handle, $dir, $max++);
        }
		elseif ($file != '.' && $file !='..' && $file !='index2.php' && $file !='index.php')
        {
            $extension = explode(".", $file);
            $stats = "Type : ".filetype($dir)."\n";
            $stats .= " Dernier acces:".date("M-d-Y g:i:s a", stat($dir)['atime'])."\n";
            $stats .= " Dernière modif:".date("M-d-Y g:i:s a", stat($dir)['mtime'])."\n";
            $stats .= " Dernier inode".date("M-d-Y g:i:s a", stat($dir)['ctime'])."\n";
            $stats .= " Size:".stat($dir)['7']."Ko\n";
            $stats .= " Mime:".mime_content_type($dir)."\n";
            $stats .= " Extension:".$extension[1]."\n";
            if ('php' === $extension[1])
            {
                $fichierACompter = new \SplFileObject($dir, 'r');
                $fichierACompter->seek(PHP_INT_MAX);
                $lignes =  $fichierACompter->key() + 1; 
            $stats .= " lignes:".$lignes."\n";
            }
            $stats .= " Dir:".$dir."\n";
            
            // var_dump(stat($dir));
            echo '<li class="file '.$extension[1].'"><a href="'.$dir.'" title="'.$stats.'">'.$file.'</a></li>'."\n";
        }
    }
    echo "</ul>";
    closedir($dir_handle);
}
?><!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index Reader</title>
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
    
<link href="/dir/css/css.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body>
<?=list_dir($dir_handle,$path,''); ?>    
</body>
</html>