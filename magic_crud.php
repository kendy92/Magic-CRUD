<?php
/*
MAGIC CRUD 2018 VERSION 1.0
CODED BY LILCASOFT.INFO
*/
class MAGIC_CRUD{

  /* DATABASE CONFIGURATION */
  private static $host = "mysql:host=localhost; dbname=you_db_name"; //put your database name here
  private static $user = "root"; //change username to match your sql user
  private static $pass = "root"; //change password to match your sql pass

  /* ARRAY TO STORE COLS, VALS DECLARATION */
  private static $cols = "";
  private static $vals = "";


  public static function connectDB() { //USE: self::connectDB() to initialize connection
    try {
      $conn = new PDO(self::$host, self::$user, self::$pass);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      return $e->getMessage();
    }
    return $conn;
  }

  public static function custom_show($query) { //inject custom query to the function. Use for join $query
    try {
      $conn = self::connectDB();
      $conn->query("SET NAMES utf8");
      $cmd = $conn->prepare($query);
      $cmd->setFetchMode(PDO::FETCH_OBJ); //return result as an object
      $cmd->execute();
      return $cmd->fetchAll();
    } catch (PDOException $e) {
      return $e->getMessage();
    }
  }

  public static function show($table_name,$order = "DESC"){ /* $order = {DESC | ASC} */
    try {
      $conn = self::connectDB();
      $conn->query("SET NAMES utf8");
      $cmd = $conn->prepare("SELECT * FROM `{$table_name}` ORDER BY id {$order}");
      $cmd->setFetchMode(PDO::FETCH_OBJ); //return result as an object
      $cmd->execute();
      return $cmd->fetchAll();
    } catch (PDOException $e) {
      return $e->getMessage();
    }
  }

  public static function insert($obj, $table_name){
			$count = 1;
			$query = "";
			$arr_cols = array();
			$arr_vals = array();
			try {
					$conn = self::connectDB();
					$cols = ""; // Initialize $cols variable
					$vals = ""; // Initialize $vals variable

					$query .= "INSERT INTO `".$table_name."`";
					foreach($obj as $key => $val) {
							if($count == count($obj)){ //remove hyphen at last item of array
									$cols .= $key;
									$vals .= ":".$key;
							}else{
									$cols .= $key.", ";
									$vals .= ":".$key.", ";
							}
							array_push($arr_cols, $key);
							array_push($arr_vals, $val);
							$count++;
					}
					$query = $query."(".$cols.") VALUES(".$vals.")";
					$cmd = $conn->prepare($query);
					for ($i=0; $i < count($obj); $i++) { //bind var to all items
							$cmd->bindParam(":{$arr_cols[$i]}", $arr_vals[$i]);
					}
					return $cmd->execute();
			} catch (PDOException $e) {
					return $e->getMessage();
			}
	}


	public static function insert_get_id($obj, $table_name){
			$count = 1;
			$query = "";
			$arr_cols = array();
			$arr_vals = array();
			try {
					$conn = self::connectDB();
					$cols = ""; // Initialize $cols variable
					$vals = ""; // Initialize $vals variable

					$query .= "INSERT INTO `".$table_name."`";
					foreach($obj as $key => $val) {
							if($count == count($obj)){ //remove hyphen at last item of array
									$cols .= $key;
									$vals .= ":".$key;
							}else{
									$cols .= $key.", ";
									$vals .= ":".$key.", ";
							}
							array_push($arr_cols, $key);
							array_push($arr_vals, $val);
							$count++;
					}
					$query = $query."(".$cols.") VALUES(".$vals.")";
					$cmd = $conn->prepare($query);
					for ($i=0; $i < count($obj); $i++) { //bind var to all items
							$cmd->bindParam(":{$arr_cols[$i]}", $arr_vals[$i]);
					}
					$result = $cmd->execute();

					if ($result) {
							// If insertion was successful, return the last inserted row id
							return $conn->lastInsertId();
					} else {
							return false;
					}
			} catch (PDOException $e) {
					return $e->getMessage();
			}
	}

  public static function update($obj, $table_name, $condition_col, $condition_val){
    $count = 1;
    $query = "";
    $arr_cols = array();
    $arr_vals = array();
    try {
      $conn = self::connectDB();
      $cols = ""; // Initialize $cols variable
			$vals = ""; // Initialize $vals variable
      $query .= "UPDATE `".$table_name."` SET ";
      foreach($obj as $key => $val) {
        if($count == count($obj)){ //remove hyphon at last item of array
          self::$cols .= $key."= :{$key}";

        }else{
          self::$cols .= $key."= :{$key}, ";
        }
        array_push($arr_cols,$key);
        array_push($arr_vals,$val);
        $count++;
      }
      $query = $query.self::$cols." WHERE ".$condition_col."= :".$condition_col;
      $cmd = $conn->prepare($query);

      for ($i=0; $i < count($obj); $i++) { //bind var to all items
        $cmd->bindParam(":{$arr_cols[$i]}", $arr_vals[$i]);
      }
        //set param for condition statement
        $cmd->bindParam(":{$condition_col}", $condition_val);
      return $cmd->execute();

    } catch (PDOException $e) {
      return $e->getMessage();
    }
  }

  public static function delete($id, $table_name){
    try {
      $conn = self::connectDB();
      $cmd = $conn->prepare("DELETE FROM `{$table_name}` WHERE id = :i");
      $cmd->bindParam(':i',$id);
      return $cmd->execute();
    } catch (PDOException $e) {
      return $e->getMessage();
    }
  }

  public static function details($id, $table_name){
    try {
      $conn = self::connectDB();
      $conn->query("SET NAMES utf8");
      $cmd = $conn->prepare("SELECT * FROM `{$table_name}` WHERE id = :i");
      $cmd->setFetchMode(PDO::FETCH_OBJ); //return result as an object
      $cmd->bindParam(':i',$id);
      $cmd->execute();
      return $cmd->fetchAll();
    } catch (PDOException $e) {
      return $e->getMessage();
    }
  }

  public static function search($table_name, $condition_col, $condition_value) {
    try {
      $condition_value = "%".$condition_value."%";
       $conn = self::connectDB();
       $conn->query("SET NAMES utf8");
       $cmd = $conn->prepare("SELECT * FROM `{$table_name}` WHERE {$condition_col} LIKE :val");
       $cmd->setFetchMode(PDO::FETCH_OBJ);
       $cmd->bindParam(':val', $condition_value,PDO::PARAM_STR);
       $cmd->execute();
       return $cmd->fetchAll();
     } catch (PDOException $e) {
       return $e->getMessage();
     }
   }

}
 ?>
