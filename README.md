# user-upload-test
This is program to upload user data into database. This program will only work as command line and output will be display on command line.


# Assumptions
- It has been assume that PHP 7.2 and PostgreSQL 9.5 or above has already been installed on machine
- PostgreSQL module for PHP 7.2 is already installed.
- PostgreSQL Port is set to **5432**, If not please use -P option supplied on Usage section below.
-  You are going to run this on **catalyst-db** Database, If not please follow steps on Prerequisite section or use -d option supplied on Usage section below.
## Prerequisite
- If PostgreSQL module for PHP 7.2 is not install on machine please run following command to install it via command line
```sudo apt-get install php7.2-pgsql```
-   Please create database **catalyst-db** in PostgreSQL and make sure you grant necessary permission to DB user you will be using to run this command.
## Usage
```
Usage: php user_upload.php [options]

--file <csv file name>	this is the name of the CSV to be parsed
--create_table		    this will cause the PostgreSQL users table to be built (and no further action will be taken)
--dry_run		        this will be used with the --file directive in case we want to run the script but not insert into the DB.
                        All other functions will be executed, but the database won't be altered

-u <DB Username>	PostgreSQL username
-p <DB password>	PostgreSQL password
-h <DB Hostname>	PostgreSQL host

-d <DB Name>		PostgreSQL Database Name - Optional - Default to catalyst-db
-P <DB Port>		PostgreSQL Port - Optional - Default to 5432

--help 		        which will output the above list of directives with details.
```
