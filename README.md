# user-upload-test
This is program to upload user data into database. This program will only work as command line and output will be display on command line.


# Assumptions
- It has been assume that PHP 7.2 and PostgreSQL has already been installed on machine
- If PostgreSQL module for PHP 7.2 is not install on machine please run following command to install it via running following command
```sudo apt-get install php7.2-pgsql```
- Database with Name **catalyst-db** is already exists and necessary permission already granted to provided DB user.
- PostgreSQL Port is set to 5432.

## Usage
```
Usage: php user_upload.php [options]

--file <csv file name>	 this is the name of the CSV to be parsed
--create_table		 this will cause the PostgreSQL users table to be built (and no further action will be taken)
--dry_run		  this will be used with the --file directive in case we want to run the script but not insert into the DB.
			        All other functions will be executed, but the database won't be altered

-u <DB Username>	 PostgreSQL username
-p <DB password>	 PostgreSQL password
-h <DB Hostname>	 PostgreSQL host

-d <DB Name>		 PostgreSQL Database Name - Optional - Default to catalyst-db
-P <DB Port>		 PostgreSQL Port - Optional - Default to 5432

--help 		 which will output the above list of directives with details.
```
