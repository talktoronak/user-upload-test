<?php
//Accepted Command-line Parameters --file --create_table --dry_run -u -p  -h -d -P --help
try{
  $short_ops= 'u:p:h:d::P::';
  $long_ops= array('file:','create_table','dry_run','help');
  $options = getopt($short_ops,$long_ops);
  if(isset($options['help']))
  {
    $help_block="Usage: user_upload.php [options] \n\n";
    $help_block.="--file <csv file name>\t this is the name of the CSV to be parsed \n";
    $help_block.="--create_table\t\t this will cause the PostgreSQL users table to be built \n\t\t\t (and no further action will be taken) \n";
    $help_block.="--dry_run\t\t this will be used with the --file directive in case we want to run the script but not insert into the DB. \n\t\t\t All other functions will be executed, but the database won't be altered \n\n";
    $help_block.="-u <DB Username>\t PostgreSQL username\n";
    $help_block.="-p <DB password>\t PostgreSQL password\n";
    $help_block.="-h <DB Hostname>\t PostgreSQL host\n\n";
    $help_block.="-d <DB Name>\t\t PostgreSQL Database Name - Optional - Default to catalyst-db\n";
    $help_block.="-P <DB Port>\t\t PostgreSQL Port - Optional - Default to 5432\n\n";
    $help_block.="--help \t\t which will output the above list of directives with details.\n";
    echo $help_block;
  }
  else {
    var_dump($options);
    if(empty($options)) throw new \Exception("Please provide required Parameters Try --help for more information.", 1);
    if(empty($options['u'])) throw new \Exception("Please provide username with -u option", 1);
    if(empty($options['p'])) throw new \Exception("Please provide password with -p option", 1);
    if(empty($options['h'])) throw new \Exception("Please provide hostname with -h option", 1);
    if(empty($options['file'])) throw new \Exception("Please provide csv file name with --file option", 1);
  }
}catch(Exception $e){
    echo 'Exception: '.  $e->getMessage(). "\n";
}
?>
