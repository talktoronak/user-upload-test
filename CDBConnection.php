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

  //Process CSV File and return User data as Associative Array
  private function get_data_from_file($file_path)
  {
    try{
      if(is_file($file_path))
      {
        $data = @file($file_path,FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);//Read File from parameter and ignore any empty line
        $data = array_map('str_getcsv',$data);// Convert CSV Line into Array
        $header = array_map('trim',array_shift($data)); // Get First Header Line and Trim
        foreach ($data as $key => $value)
        {
            $value = array_map('trim',$value);
            $users[] = array_combine($header,$value);// Merge with Header to prepare Assiciate Array for Each Line record
        }
        return $users;
      }
      else {
          throw new Exception('Please supply correct filename.');
      }
    }catch(Exception $e){
        echo 'File exception: '.  $e->getMessage(). "\n";
    }
  }

  //This function will only check data and do not take any operation on Database
  public function check_data($file_path)
  {
    $user_data=$this->get_data_from_file($file_path);
    foreach ($user_data as $key => $user) {
      if(!filter_var($user['email'],FILTER_VALIDATE_EMAIL))
      {
        echo "Skip Record - Invalid Email Address - ".$user['email']." on Line ".($key+2)."\n";
        unset($user_data[$key]);
      }
      else {
        $user_data[$key]['name']=ucfirst(strtolower($user['name']));
        $user_data[$key]['surname']=ucfirst(strtolower($user['surname']));
        $user_data[$key]['email']=strtolower($user['email']);
      }
    }
    return $user_data;
  }

  //This function will update data into Database
  public function update_data($file_path)
  {
    $clean_user_data=$this->check_data($file_path);
    //var_dump($clean_user_data);exit;
    foreach ($clean_user_data as $key => $user) {
        $exist=$this->email_exists_in_db($user['email']);
        if(!$exist) $this->add_user_in_db($user);
        else  $this->update_user_in_db($user);
    }
  }

  //This Function to check if record with email is exsist in Table or not
  private function email_exists_in_db($email) {
      $result = pg_query($this->db_connection,"SELECT 1 FROM users WHERE email='".pg_escape_string(strtolower($email))."'");
      if(!$result) {
         die('Could not execute query: '.pg_last_error($this->db_connection));
      }
      else {
        if(pg_num_rows($result)>0) return true;
        else return false;
      }
  }
  //Add New Row Record in User Table
  private function add_user_in_db($user) {
      $insert_query="INSERT INTO users(name,surname,email) VALUES (";
      $insert_query.="'".pg_escape_string($user['name'])."',";
      $insert_query.="'".pg_escape_string($user['surname'])."',";
      $insert_query.="'".pg_escape_string($user['email'])."');";
      $result = pg_query($this->db_connection,$insert_query);
      if(!$result) {
         die('Could not insert Record: '.pg_last_error($this->db_connection));
      }else {
         echo "users record Inserted - Email - ".$user['email']."\n";
         pg_free_result($result);
      }
  }
  //Update New Row Record in User Table
  private function update_user_in_db($user) {
      $update_query="UPDATE users SET ";
      $update_query.="name = '".pg_escape_string($user['name'])."', ";
      $update_query.="surname = '".pg_escape_string($user['surname'])."' ";
      $update_query.="WHERE email='".pg_escape_string($user['email'])."';";
      $result = pg_query($this->db_connection,$update_query);
      if(!$result) {
         die('Could not insert Record: '.pg_last_error($this->db_connection));
      }else {
        echo "users record Updated - Email - ".$user['email']."\n";
        pg_free_result($result);
      }
  }
}
?>
