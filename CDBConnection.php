<?php
class CDBConnection
{
  private $port='5432';
  private $dbname='catalyst-db';
  private $db_connection;
  function __construct($host,$user,$password,$dbname,$port)
  {
    try{
      if(empty($dbname)) $dbname=$this->dbname;
      if(empty($port)) $port=$this->port;
      $this->db_connection=pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password") or die('Could not connect: ' . pg_last_error());
    }catch(Exception $e){
        echo 'Caught exception: '.  $e->getMessage(). "\n";
    }
  }
  // This Function will close DB Connection
  public function close_connection()
  {
    pg_close($this->db_connection);
  }
  // This Function will create new Database Table called users
  public function create_user_table()
  {
    $create_query="
            CREATE TABLE IF NOT EXISTS users(
            name CHARACTER VARYING(100),
            surname CHARACTER VARYING(100),
            email CHARACTER VARYING(255),
            CONSTRAINT email UNIQUE (email)
        );";
    $result = pg_query($this->db_connection, $create_query);
   if(!$result) {
      die('Could not create users table: '.pg_last_error($this->db_connection));
   } else {
      echo "users table created successfully\n";
      pg_free_result($result);
   }
  }
}
?>
