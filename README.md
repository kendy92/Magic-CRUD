#MAGIC CRUD

**HOW TO USE**

- Require the magic crud  in the file you want to use by adding the following line of code:



>  require_once "magic_crud.php";

Config your database information in magic_crud.php file.


**INSERT ROW**

- Create an object that holds up column name and value which require to add to the database. Result will return number of rows that successfully add to database. 0 if no row added!

> \$new_item = array('col_name_1' => 'value_1', 	   col_name_2' =>
> 'value_2');

- Call the function and pass the object and table name to it.

> MAGIC_CRUD::insert(\$new_item, "your_table_name");


**UPDATE EXISTING ROW**

- Create an object that holds up column name and value that require to update to the database. Result will return number of rows that successfully add to database. 0 if no row added!

> \$new_item = array('col_name_1' => 'value_1', col_name_2' =>
> 'value_2');

- Call the function and pass the object, table name, condition column and condition value to it.

> MAGIC_CRUD::update($obj, $table_name, $condition_col, $condition_val);

**DELETE EXISTING ROW**

- Call the function and pass the id of existing row and table name to delete from database. Result will return number of rows that successfully add to database. 0 if no row added!

> MAGIC_CRUD::delete($id, $table_name);

**FIND BY ID**

- Call the function and pass the id of existing row and table name to show data regarding to that id from database. Result will return as an object and use foreach loop to loop through the result.

> MAGIC_CRUD::details($id, $table_name)

**SHOW DATA**

- Call the function and pass the table name to show all data regarding to that table. Result will be sorted in descending order by default but you can pass second parameter as "ASC" to sort it in ascending order and return as an object. Use foreach loop to loop through the result.

> MAGIC_CRUD::show(\$table_name,$order = "DESC");

**CUSTOM SHOW**

- Call the function and pass the custom query. Result will return as an object and use foreach loop to loop through the result. It is ideally to use for multiple join table statement.

> MAGIC_CRUD::custom_show($query);


**CODED BY LILCASOFT.INFO**
